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

        foreach ($cart as $carts) {
            if(!$this->checkInStock($carts)) {
                $invoice->total_price -= $carts->price;
                $invoice->save();
                \Cart::remove($carts->id);
                DB::rollBack();
                return response()->json(['status_code' => 404, 'message' => 'out of stock']);
                return redirect()->back()->with('error', 'Item is out of stock');

            } else {
                if (DB::table('ordered_products')->where('customer_id', session()->get('customer_uniquekey'))->where('product_id', $carts->id)->first()) 
                {
                    \Cart::remove($carts->id);
                    DB::rollBack();
                    return response()->json(['status_code' => 403, 'message' => 'you have already ordered this product.']);
                }
                $order = new TempOrderProduct();
                $order->invoice_id = $invoice->id;
                $order->customer_id = session()->get('customer_uniquekey');
                $order->product_id = $carts->id;
                $order->price = $carts->price;
                $order->size = $carts->attributes['size'];
                $order->status = 'pending';
                $order->save();
            }
        }

        \Cart::clear();
        DB::commit();

        $totalAmount = $invoice->total_price;
        $orderId=$invoice->id;
        $customerName=$delivery_info->recipient_name;
        $product = Product::find($order->product_id);
        if ($product) {
            $items = [
                [
                    'name' => $product->product_name,
                    'amount' => $order->price,
                    'quantity' => 1,
                ]
            ];
        } else {
           dd('hit');
        }
        

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

        DB::rollBack();
        abort(403, "Fail to order, missing required informations.");
        return response()->json(['status_code' => 404, 'message' => 'Fail to order']);
    }
}

public function dingerCallback(Request $request)
{
    $url="https://noreplacementsfound.com/dinger-callback";
    $paymentResult = $request->input('paymentResult');
    $checksum = $request->input('checksum');
    $callbackKey = '2855e461a79d46ef637a0cfaae0850c2';
    $decrypted = openssl_decrypt(base64_decode($paymentResult), 'AES-256-ECB', $callbackKey);
    $computedChecksum = hash('sha256', $decrypted);
    if ($computedChecksum !== $checksum) {
        return "Incorrect signature.";
    }
    $decryptedValues = json_decode($decrypted, true);
    $totalAmount = $decryptedValues['totalAmount'];
    $createdAt = $decryptedValues['createdAt'];
    $transactionStatus = $decryptedValues['transactionStatus'];
    $methodName = $decryptedValues['methodName'];
    $merchantOrderId = $decryptedValues['merchantOrderId'];
    $transactionId = $decryptedValues['transactionId'];
    $customerName = $decryptedValues['customerName'];
    $providerName = $decryptedValues['providerName'];

    // Perform actions based on the transaction status
    if ($transactionStatus === 'SUCCESS') {
        DB::beginTransaction();
        
        $invoice = new Invoice();
        $invoice->customer_id = session()->get('customer_uniquekey');
        $invoice->status = $transactionStatus;
        $invoice->total_price = $totalAmount;
        $invoice->payment_method = $providerName;
        $invoice->fees = 0;
        $invoice->save();

        $invoiceDetail = TempInvoice::where('customer_id', session()->get('customer_uniquekey'))->get()->last();
        $delivery=TempDeliInfo::where('invoice_id',$invoiceDetail->id)->get()->last();
        $delivery_info = new DeliveryInfo();
        $delivery_info->invoice_id = $invoice->id;
        $delivery_info->customer_id = $delivery->customer_id;
        $delivery_info->country_id = $delivery->country_id;
        $delivery_info->division_id = $delivery->division_id;
        $delivery_info->district_id = $delivery->district_id;
        $delivery_info->township_id = $delivery->township_id;
        $delivery_info->delivery_address = $delivery->delivery_address;
        $delivery_info->recipient_phone = $delivery->recipient_phone;
        $delivery_info->recipient_name = $delivery->recipient_name;
        $delivery_info->save();

        $orders = TempOrderProduct::where('invoice_id', $invoiceDetail->id)->get();
        foreach ($orders as $orderinfo) {
            $size = $orderinfo->size . '_quantity';
            if ($orderinfo->size == "free" || $orderinfo->size == "no") {
                $size = "small_quantity";
            }
            $update_quantity = DB::table('products')->select($size)->where('id', $orderinfo->product_id)->first();
            if ($update_quantity->$size <= 0) {
                return redirect()->route('error');
                DB::rollBack();
            }
            $order = new Order();
            $order->invoice_id = $invoice->id;
            $order->customer_id = $orderinfo->customer_id;
            $order->product_id = $orderinfo->product_id;
            $order->price = $orderinfo->price;
            $order->size = $orderinfo->size;
            $order->status = $orderinfo->status;
            $order->save();
            $this->decreaseStock($order->product_id,$order->size);
        }
        TempOrderProduct::where('customer_id', session()->get('customer_uniquekey'))->get()->last()->delete();
        TempDeliInfo::where('customer_id', session()->get('customer_uniquekey'))->get()->last()->delete();
        TempInvoice::where('customer_id', session()->get('customer_uniquekey'))->get()->last()->delete();

        DB::commit();
        return redirect()->route('success');
    } else {
            TempOrderProduct::where('customer_id', session()->get('customer_uniquekey'))->get()->last()->delete();
            TempDeliInfo::where('customer_id', session()->get('customer_uniquekey'))->get()->last()->delete();
            TempInvoice::where('customer_id', session()->get('customer_uniquekey'))->get()->last()->delete();
        }
    }  
    public function success()
    {
        return view('cart.success_page');
    }  
    public function error()
    {
        return view('cart.error_page');
    }

    // public function checkPayment(Request $request)
    // {
    //     $url = "https://api.kbzpay.com/payment/gateway/queryorder";

    //     $timeStamp = time();
    //     $nonceStr = $this->generateRandomString();
    //     $merch_order_id = $request->merch_order_id;

    //     $stringA = "appid=kp81a3303eb48343ed990ffa97a0ebb7&merch_code=200277&merch_order_id=" . $merch_order_id . "&method=kbz.payment.queryorder&nonce_str=" . $nonceStr . "&timestamp=" . $timeStamp . "&version=3.0&key=fd8d884e3b5ac31bb86fc3622ef57e0d";


    //     $sign = strtoupper(hash("SHA256", $stringA));
    //     // Prepare the request data
    //     $data = array(
    //         'Request' => array(
    //             'timestamp' => $timeStamp,
    //             'nonce_str' => $nonceStr,
    //             'method' => 'kbz.payment.queryorder',
    //             'sign_type' => 'SHA256',
    //             'sign' => $sign,
    //             'version' => '3.0',
    //             'biz_content' => array(
    //                 'appid' => 'kp81a3303eb48343ed990ffa97a0ebb7',
    //                 'merch_code' => '200277',
    //                 'merch_order_id' => $merch_order_id
    //             )
    //         )
    //     );

    //     // return response()->json([$sign, $stringA]);

    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //     ])->post($url, $data);

    //     $decodeResponse = json_decode($response->body())->Response;
    //     $customerid = session()->get('customer_uniquekey'); 
    //     if ($decodeResponse->result === "SUCCESS") {
	//     DB::beginTransaction();
    //         $invoiceDetail = TempInvoice::where('merchant_order_id', $request->merch_order_id)->get()->last();
	//     $invoice = new Invoice();
    //         $invoice->customer_id = $invoiceDetail->customer_id;
    //         $invoice->status = $invoiceDetail->status;
    //         $invoice->total_price = $invoiceDetail->total_price;
    //         $invoice->payment_method = 'kpay';
    //         $invoice->save();
	//     $delivery=TempDeliInfo::where('invoice_id',$invoiceDetail->id)->get()->last();
    //         //dd($delivery);
    //         $delivery_info = new DeliveryInfo();
    //         $delivery_info->invoice_id = $invoice->id;
    //         $delivery_info->customer_id = $delivery->customer_id;
    //         $delivery_info->division_id = $delivery->division_id;
    //         $delivery_info->district_id = $delivery->district_id;
    //         $delivery_info->township_id = $delivery->township_id;
    //         $delivery_info->delivery_address = $delivery->delivery_address;
    //         $delivery_info->recipient_phone = $delivery->recipient_phone;
    //         $delivery_info->recipient_name = $delivery->recipient_name;
    //         $delivery_info->save();
	
    //         //dd($delivery_info->save());
    //         $orders = TempOrderProduct::where('invoice_id', $invoiceDetail->id)->get();
    //         foreach ($orders as $orderinfo) {
	// 	//size check start--------
    //             $size = $orderinfo->size . '_quantity';
    //             if ($orderinfo->size == "free" || $orderinfo->size == "no") {
    //                 $size = "small_quantity";
    //             }
    //             //dd($size);
    //             $update_quantity = DB::table('products')->select($size)->where('id', $orderinfo->product_id)->first();
	// 	//dd($update_quantity);
    //             if ($update_quantity->$size <= 0) {
    //                 return view('cart.error_page');
	// 	    DB::rollBack();
	// 	    //DB::table('products')->where('id', $orderinfo->product_id)->increment($size);
    //             }
	// 	//DB::table('products')->where('id', $orderinfo->product_id)->increment($size);
    //             //size check end-----
    //             $order = new Order();
    //             $order->invoice_id = $invoice->id;
    //             $order->customer_id = $orderinfo->customer_id;
    //             $order->product_id = $orderinfo->product_id;
    //             $order->price = $orderinfo->price;
    //             $order->size = $orderinfo->size;
    //             $order->status = $orderinfo->status;
    //             $order->save();
    //             $this->decreaseStock($order->product_id,$order->size);
    //         }
    //         TempOrderProduct::where('customer_id', $customerid)->delete();
    //         TempDeliInfo::where('customer_id', $customerid)->delete();
    //         TempInvoice::where('customer_id', $customerid)->delete();

	//     DB::commit();
    //         return view('cart.success_page');
    //     } else {
	//     DB::table('products')->where('id', $orderinfo->product_id)->increment($size);
    //         TempOrderProduct::where('customer_id', $customerid)->delete();
    //         TempDeliInfo::where('customer_id', $customerid)->delete();
    //         TempInvoice::where('customer_id', $customerid)->delete();
    //     }
    // }
}
