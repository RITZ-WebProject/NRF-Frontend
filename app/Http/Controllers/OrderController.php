<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Omnipay\Omnipay;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use phpseclib\Crypt\RSA;
use App\Models\DeliveryInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\TempDeliInfo;
use App\Models\TempInvoice;
use App\Models\TempOrderProduct;
use App\Models\Township;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Support\Facades\Log;
use phpseclib\Crypt\AES;

class OrderController extends Controller
{
    public function cartSubtotal($cart)
    {
    $total = 0;
    if (isset($cart)) {
        foreach ($cart as $item) {
            $total += $item->attributes['dollor'];
        }
    }
    return $total;
    }

    public function cart()
    {
        $cart_items = \Cart::getContent();
        return view('cart.cart', compact('cart_items'));
    }

    public function clearCart()
    {
        foreach (\Cart::getContent() as $item) {
            \Cart::remove($item->id);
        }

        return view('cart.cart');
    }


    public function addToCart($id, $size)
    {

        $userId = session()->get('customer_uniquekey');
        $product = DB::table('products')->where('products.id', '=', $id)->first();

        $existingOrder = Order::where('customer_id', $userId)
        ->where('product_id', $id)
        ->whereDate('created_at', today())
        ->first();
        if ($existingOrder) {
            return redirect()->back()->with('error', 'You have already ordered this product today.');
        }

        $cartItems = \Cart::getContent();
        foreach ($cartItems as $cartItem) {
            $existingProduct = DB::table('products')->where('products.id', '=', $cartItem->id)->first();
            if ($existingProduct->category_id == $product->category_id) {
                return redirect()->back()->with('error', 'You can only add one item from this category.');
            }
        }

        if (\Cart::get($id) === null) {
            \Cart::add([
                'id' => $id,
                'name' => $product->product_name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => array(
                    'size' => $size,
                    'photo' => $product->photo,
                    'small_quantity' => $product->small_quantity,
                    'medium_quantity' => $product->medium_quantity,
                    'large_quantity' => $product->large_quantity,
                    'xlarge_quantity' => $product->xlarge_quantity,
                    'xxlarge_quantity' => $product->xxlarge_quantity,
                    'xxxlarge_quantity' => $product->xxxlarge_quantity,
                    'dollor' => $product->dollor
                )
            ]);
            Session::put('cart_time', now());
        } else {
            return redirect()->back()->with('error', 'Item already in cart');
        }
        return redirect()->back()->with('info', 'Product added to cart successfully!');
    }


    public function cart_update(Request $request)
    {
        $itemId = $request->id;
        $newSize = $request->size;

        $item = \Darryldecode\Cart\Facades\CartFacade::get($itemId);
        $item->attributes->put('size', $newSize);
        \Darryldecode\Cart\Facades\CartFacade::update($itemId, [
            'attributes' => $item->attributes
        ]);

        session()->flash('success', 'Size Chart is Updated Successfully !');

        return redirect('/cart');
    }

    public function removeCart($id)
    {
        $userId = session()->get('customer_uniquekey');
        \Cart::remove($id);
        session()->flash('success', 'Cart Item Removed Successfully!');
        return redirect()->back();
    }

    public function cartCheckout()
    {
        $cart = \Cart::getContent();
        $customer = DB::table('customers')->where('id', '=', session()->get('customer_uniquekey'))->first();
        $divisions = DB::table('tbl_divisions')->orderby('division_name')->select('division_name', 'id')->get();
        $districts = DB::table('tbl_districts')->get();
        $townships = DB::table('tbl_townships')->get();
        $countries = DB::table('countries')->get();
        $total = \Cart::getTotal();
        $addresses = DB::table('customers')
            ->leftJoin('tbl_divisions', 'tbl_divisions.id', '=', 'customers.division_id')
            ->leftJoin('tbl_districts', 'tbl_districts.id', '=', 'customers.district_id')
            ->leftJoin('tbl_townships', 'tbl_townships.id', '=', 'customers.township_id')
            ->where('customers.id', session()->get('customer_uniquekey'))
            ->first();
        return view('cart.checkout', compact('cart', 'total', 'divisions', 'districts', 'townships','countries', 'customer', 'addresses'));
    }

    public function checkInStock($order) {
        $current_size = strtolower($order->attributes["size"]);
        $select_size = $current_size.'_quantity';
        $current_stock = "";
        $current_product = Product::find($order->id);
        if ($current_size != "no" &&  $current_size != "free" && $current_size != "small") {
            $current_stock = $current_product->$select_size;
        } else {
            $current_stock = $current_product->small_quantity;
        }
        if($current_stock <= 0) {
            return false;
        }
        return true;
    }

    public function decreaseStock($product, $size_check) {
        try {
            $size = strtolower($size_check);
            $size_qty = "";
    
            if ($size == "no" || $size == "free" || $size == "small") {
                $size_qty = 'small_quantity';
            } else {
                $size_qty = $size.'_quantity';
            }    
            $product = Product::find($product);
            $product->$size_qty -= 1;
            $product->save();
        } catch (\Exception $e) {
            dd($e);
        }
    }
    

    public function getDistrict(Request $request)
    {
        $dists = District::where("division_id", $request->division_id)
            ->pluck("district_name", "id");
        return response()->json($dists);
    }

    public function getTownship(Request $request)
    {
        $towns = Township::where("district_id", $request->district_id)
            ->pluck("township_name", "id");
        return response()->json($towns);
    }

    public function orderStore(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'recipient_name' => 'required|string',
        'recipient_phone' => 'required|string',
        'country_id' => 'required|string',
        'address' => 'required|string'
    ]);

    // Start a database transaction
    DB::beginTransaction();

    try {
        $cart = \Cart::getContent();
        $totalPrice = 0;
        
            $totalPrice = \Cart::getTotal();
            $invoice = new TempInvoice;
            $invoice->customer_id = session()->get('customer_uniquekey');
            $invoice->status = "pending";
            $invoice->total_price = \Cart::getTotal();
            $invoice->payment_method = "online";
            $invoice->fees = 0;
            $invoice->save();

        // Create delivery information and handle out-of-stock items and order products
        $delivery_info = new TempDeliInfo;
        $delivery_info->invoice_id = $invoice->id;
        $delivery_info->customer_id = session()->get('customer_uniquekey');
        $delivery_info->country_id = $request->country_id;
        
        $divisionSelect = $request->input('division_id_select');
        $divisionInput = $request->input('division_id_input');
        if (!empty($divisionSelect)) {
            $delivery_info->division_id = $divisionSelect;
        } elseif (!empty($divisionInput)) {
            $delivery_info->division_id = $divisionInput;
        } else {
            $delivery_info->division_id=null;
        }
        
        $districtSelect = $request->input('district_id_select');
        $districtInput = $request->input('district_id_input');
        if (!empty($districtSelect)) {
            $delivery_info->district_id =$districtSelect;
        } elseif (!empty($districtInput)) {
            $delivery_info->district_id = $districtInput;
        } else {
            $delivery_info->district_id=null;
        }
        $townshipSelect = $request->input('township_id_select');
        $townshipInput = $request->input('township_id_input');
        if (!empty($townshipSelect)) {
            $delivery_info->township_id = $townshipSelect;
        } elseif (!empty($townshipInput)) {
            $delivery_info->township_id = $townshipInput;
        } else {
            $delivery_info->township_id=null;
        }
        $delivery_info->delivery_address = $request->address;
        $delivery_info->recipient_name = $request->recipient_name;
        $delivery_info->recipient_phone = $request->recipient_phone;
        $delivery_info->save();
        $totalAmount = 0;
        $items = []; 

        foreach ($cart as $carts) {
            if(!$this->checkInStock($carts)) {
                $invoice->total_price -= $carts->price;
                $invoice->save();
                \Cart::remove($carts->id);
                DB::rollBack();
                return response()->json(['status_code' => 404, 'message' => 'out of stock']);
                return redirect()->back()->with('error', 'Item is out of stock');
            } else {
                if (DB::table('ordered_products')->where('customer_id', session()->get('customer_uniquekey'))->where('product_id', $carts->id)->first()) {
                    \Cart::remove($carts->id);
                    DB::rollBack();
                    return response()->json(['status_code' => 403, 'message' => 'you have already ordered this product.']);
                }
                $order = new TempOrderProduct;
                $order->invoice_id = $invoice->id;
                $order->customer_id = session()->get('customer_uniquekey');
                $order->product_id = $carts->id;
                $order->price = $carts->price;
                $order->size = $carts->attributes['size'];
                $order->status = 'pending';
                $order->save();

                // Add product details to the items array
                $product = Product::find($carts->id);
                if ($product) {
                    $items[] = [
                        'name' => $product->product_name,
                        'amount' => $order->price,
                        'quantity' => 1,
                    ];
                } else {
                dd('Product not found');
                }
                $totalAmount += $carts->price;
            }
        }

        \Cart::clear();
        DB::commit();
        $orderId=$invoice->id;
        $customerName=$delivery_info->recipient_name;
        $data = [
            "clientId" => "f17dd814-0f2f-3a7a-a138-bee3c04c0807",
            "publicKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDj32iCJ4wjM9E5zTavXYeIlgi2U0/q7s4JsE6QGmfY3iFaHOtfjmDgFdaeoGK5HJUVd1ScpvCyqGiZbtBRzHjgCCUCV67CO0rEMBrKCCfzM/eTOSwBB8z7Wm4qHJEPnAvY1aNkSAY+OBSQ75VuO1bYWhl5bfuVfMdQhYqmHaqpTQIDAQAB",
            "items" => json_encode($items), 
            "customerName" => $customerName,
            "totalAmount" => $totalAmount,
            "merchantOrderId" => $orderId,
            "merchantKey" => "j7utuok.IVWGy2A3OrQlyeBE0AEpqLJJJZ8",
            "projectName" => "NoReplacementsFound",
            "merchantName" => "NRF"
        ];
        $publicKey = '-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCFD4IL1suUt/TsJu6zScnvsEdLPuACgBdjX82QQf8NQlFHu2v/84dztaJEyljv3TGPuEgUftpC9OEOuEG29z7z1uOw7c9T/luRhgRrkH7AwOj4U1+eK3T1R+8LVYATtPCkqAAiomkTU+aC5Y2vfMInZMgjX0DdKMctUur8tQtvkwIDAQAB-----END PUBLIC KEY-----';
        
        $rsa = new RSA();
        $rsa->loadKey($publicKey);
        $rsa->setEncryptionMode(2); 
        $value = json_encode($data);
        $ciphertext = $rsa->encrypt($value);
        $payloadBase64 = base64_encode($ciphertext);
        $payloadEncoded = urlencode($payloadBase64); 
        $secretKey = 'ae1426ff6d0736d31119a3d5168143aa';
        $hashedValue = hash_hmac('sha256', $value, $secretKey);
        $redirect_url = "https://form.dinger.asia/?hashValue=$hashedValue&payload=$payloadEncoded";
        return redirect($redirect_url);
         

    } catch (\Exception $err) {
        // dd($err);
        DB::rollBack();
        abort(403, "Fail to order, missing required informations.");
        return response()->json(['status_code' => 404, 'message' => 'Fail to order']);
    }
}
   public function success(Request $request)
{
    $merchantOrderId = $request->input('merchantOrderId');
    $state = $request->input('state');

    if ($state === 'SUCCESS') {
        // Retrieve data from temporary tables
        $invoice = TempInvoice::where('id', $merchantOrderId)->get();
        $deliInfo = TempDeliInfo::where('invoice_id', $merchantOrderId)->get();
        $orderProducts = TempOrderProduct::where('invoice_id', $merchantOrderId)->get();

        DB::beginTransaction();

        try {
            // Create new records in permanent tables
            $inv = new Invoice;
            $inv->customer_id = $invoice->customer_id;
            $inv->status = "pending";
            $inv->total_price = $invoice->total_price;
            $inv->payment_method = "online";
            $inv->fees = 0;
            $inv->save();

            $deli = new DeliveryInfo;
            $deli->invoice_id = $deliInfo->invoice_id;
            $deli->customer_id = $deliInfo->customer_id;
            $deli->country_id = $deliInfo->country_id;
            $deli->division_id = $deliInfo->division_id;
            $deli->district_id = $deliInfo->district_id;
            $deli->township_id = $deliInfo->township_id;
            $deli->delivery_address = $deliInfo->delivery_address;
            $deli->recipient_name = $deliInfo->recipient_name;
            $deli->recipient_phone = $deliInfo->recipient_phone;
            $deli->save();

            foreach ($orderProducts as $orderProduct) {
                $order = new Order;
                $order->invoice_id = $orderProduct->invoice_id;
                $order->customer_id = $orderProduct->customer_id;
                $order->product_id = $orderProduct->product_id;
                $order->price = $orderProduct->price;
                $order->size = $orderProduct->size;
                $order->status = 'pending';
                $order->save();
                $this->decreaseStock($order->product_id, $order->size);
            }

            // Delete records from temporary tables
            TempOrderProduct::where('invoice_id', $merchantOrderId)->delete();
            TempDeliInfo::where('invoice_id', $merchantOrderId)->delete();
            TempInvoice::where('id', $merchantOrderId)->delete();

            DB::commit();
            
            // Redirect to the success page
            return redirect()->route('payment.success');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // Handle the exception
            Order::where('invoice_id', $merchantOrderId)->delete();
            DeliveryInfo::where('invoice_id', $merchantOrderId)->delete();
            Invoice::where('id', $merchantOrderId)->delete();
            return response()->json(['status_code' => 500, 'message' => 'Error occurred while processing the payment.']);
        }
    } else {
        // Payment failed, delete the temporary order data
        DB::beginTransaction();
        TempOrderProduct::where('invoice_id', $merchantOrderId)->delete();
        TempDeliInfo::where('invoice_id', $merchantOrderId)->delete();
        TempInvoice::where('id', $merchantOrderId)->delete();
        DB::commit();
        
        // Redirect to the error page
        return view('cart.error_page');
    }
}

    public function error(Request $request)
{
    $merchantOrderId = $request->input('merchantOrderId');
    try {
        // Start a database transaction
        DB::beginTransaction();
        TempOrderProduct::where('invoice_id', $merchantOrderId)->delete();
        TempDeliInfo::where('invoice_id', $merchantOrderId)->delete();
        TempInvoice::where('id', $merchantOrderId)->delete();
        DB::commit();
        return view('cart.error_page');
    } catch (\Exception $err) {
        DB::rollBack();
        return response()->json(['status_code' => 500, 'message' => 'Error occurred while deleting records']);
    }
}

}
