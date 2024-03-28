<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Invoice;
use App\Models\Newletter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Newsletter;
use App\Models\Order;
use App\Models\Product;

class CustomersController extends Controller
{
    public static function generateCustomerID()
    {
        $customers = DB::table('customers')->get()->last();
        $prefix = "NRF-C-";
        if ($customers) {
            $customer_uniquekey = ++$customers->customer_uniquekey;
            return $customer_uniquekey;
        } else {
            $customer_uniquekey = $prefix . "000001";
            return $customer_uniquekey;
        }
    }

    public function create()
    {
        return view('login.register');
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string','min:6','max:255'],
            'email' => ['required', 'unique:customers,email', 'email', 'max:255'],
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|max:11|unique:customers,phone_primary'
        ]);

        if ($validator) {
            $customer = new Customer();
            $customer->customer_name = $request->customer_name;
            $customer->email = $request->email;
            $customer->password = Hash::make($request->password);
            $customer->phone_primary = $request->phone_number;
            $customer->save();
            return redirect('/login')->with("info", 'New Customers is Added');
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    public function storeAddress(Request $request)
{ 
    // Retrieve the logged-in customer
    $customer_id = session()->get('customer_uniquekey');
    $customer = Customer::find($customer_id);

    // Update the address fields
    $customer->country_id = $request->country_id;
    
    $divisionSelect = $request->input('division_id_select');
    $divisionInput = $request->input('division_id_input');
    $customer->division_id = !empty($divisionSelect) ? $divisionSelect : (!empty($divisionInput) ? $divisionInput : null);
    
    $districtSelect = $request->input('district_id_select');
    $districtInput = $request->input('district_id_input');
    $customer->district_id = !empty($districtSelect) ? $districtSelect : (!empty($districtInput) ? $districtInput : null);

    $townshipSelect = $request->input('township_id_select');
    $townshipInput = $request->input('township_id_input');
    $customer->township_id = !empty($townshipSelect) ? $townshipSelect : (!empty($townshipInput) ? $townshipInput : null);

    $customer->home_no = $request->home_no;
    $customer->street_name = $request->street_name;

    // Save the updated customer data
    $customer->save();

    return redirect('account/')->with("info", 'Your billing address has been updated.');
}


    public function profile()
    {
        $customer_id = session()->get('customer_uniquekey');
        $account = DB::table('customers')->where('customers.id', '=', $customer_id)->first();
        $addresses = DB::table('customers')
            ->leftJoin('countries','countries.name', '=', 'customers.country_id')
            ->leftJoin('tbl_divisions', 'tbl_divisions.id', '=', 'customers.division_id')
            ->leftJoin('tbl_districts', 'tbl_districts.id', '=', 'customers.district_id')
            ->leftJoin('tbl_townships', 'tbl_townships.id', '=', 'customers.township_id')
            ->where('customers.id', session()->get('customer_uniquekey'))
            ->first();
        $orders = DB::table('invoices')
            ->leftJoin('ordered_products', 'ordered_products.invoice_id', 'invoices.id')
            ->where('invoices.customer_id', '=', $account->id)
            ->select('invoices.*', 'ordered_products.id', 'ordered_products.invoice_id', 'ordered_products.price')
            ->distinct('invoices.id')
            ->orderBy('invoices.created_at', 'desc')
            ->latest('invoices.created_at')
            ->get();
        $countries = DB::table('countries')->get();
        $divisions = DB::table('tbl_divisions')->orderby('division_name')->select('division_name', 'id')->get();
        $districts = DB::table('tbl_districts')->get();
        $townships = DB::table('tbl_townships')->get();

        $invoices = DB::table('invoices')->where('invoices.customer_id', $customer_id)->get();

        $invoice_info = DB::table('invoices')
            ->leftJoin('delivery_info', 'delivery_info.customer_id', 'invoices.customer_id')
            ->where('invoices.customer_id', $customer_id)
            ->first();
        return view('account.my-account', compact('account','countries', 'orders', 'customer_id', 'divisions', 'districts', 'townships', 'invoices', 'addresses'));
    }

    public function editProfile($id)
    {
        $customer_id = session()->get('customer_uniquekey');
        $password = session()->get('password');

        $customer = DB::table('customers')->where('id', '=', $customer_id)->first();

        return view('account.edit_profile', compact('customer', 'password'));
    }
    public function editAddress()
    {
        $addresses = DB::table('customers')
            ->leftJoin('countries','countries.name', '=', 'customers.country_id')
            ->leftJoin('tbl_divisions', 'tbl_divisions.id', '=', 'customers.division_id')
            ->leftJoin('tbl_districts', 'tbl_districts.id', '=', 'customers.district_id')
            ->leftJoin('tbl_townships', 'tbl_townships.id', '=', 'customers.township_id')
            ->where('customers.id', session()->get('customer_uniquekey'))
            ->first();
        $countries = DB::table('countries')->get();
        $divisions = DB::table('tbl_divisions')->orderby('division_name')->select('division_name', 'id')->get();
        $districts = DB::table('tbl_districts')->get();
        $townships = DB::table('tbl_townships')->get();
        return view('account.address', compact('addresses','countries','divisions','districts','townships'));
    }
    public function storeProfile(Request $request, $id)
    {
        $customer_id = session()->get('customer_uniquekey');
        $validator = $request->validate([
            'phone_primary' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|max:18',
        ]);

        if ($validator) {
            $test=DB::table('customers')->where('id', $customer_id)->update([
                'customer_name' => $request->customer_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_primary' => $request->phone_primary,
            ]);

            return redirect('account/')->with("info", 'Existing Customers is Updated');
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }
    public function updateProfile(Request $request)
{
    // Validate the form data
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'email' => 'required|string|email|max:255',
        'oldpassword' => 'required|string',
        'newPassword' => 'required|string'
    ]);

    $customer_id = session()->get('customer_uniquekey');
    $user = Customer::find($customer_id); // Use Eloquent model to retrieve the user

    if (!$user) {
        return back()->with('error', 'User not found.');
    }

    if (!Hash::check($request->oldpassword, $user->password)) {
        return back()->with('error', 'The old password is incorrect.');
    }

    $update = $user->update([
        'customer_name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->newPassword),
        'phone_primary' => $request->phone,
    ]);

    if ($update) {
        return redirect('account/')->with("success", 'Profile updated successfully.');
    } else {
        return redirect('account/')->with("error", 'Failed to update profile. Please try again.');
    }
}
    public function getOrderHistory()
    {
        $orders = DB::table("invoices")->where("invoices.customer_id", '=', session()->get('customer_uniquekey'));
        return view('account.my-account', compact($orders));
    }

    public function invoice($id)
    {
        $invoice_info=Order::where('invoice_id',$id)->get();
        $total_price=Order::where('invoice_id',$id)->sum('price');

        $invoice_detail = DB::table('ordered_products')
            ->leftJoin('products', 'products.id', '=', 'ordered_products.product_id')
            ->leftJoin('invoices', 'invoices.id', '=', 'ordered_products.invoice_id')
            ->where('ordered_products.invoice_id', $id)
            ->select('ordered_products.*', 'products.product_name')
            ->get();
        return view('account.invoice', compact('invoice_info','invoice_detail','total_price'));
    }

    public function order_view($id)
    {
        $order_details = DB::table('ordered_products')
            ->leftJoin('products', 'products.id', '=', 'ordered_products.product_id')
            ->where('ordered_products.invoice_id', $id)
            ->select('ordered_products.*', 'products.product_name', 'products.photo')
            ->get();
        return view('account.order_view', compact('order_details'));
    }

    public function newsletter_signup(Request $request)
    {
        //dd($request);
        $validator = $request->validate([
            'email' => 'required|email|unique:newsletter,email'
        ]);

        if ($validator) {
            $newsletter = new Newletter();
            $newsletter->email = $request->email;
            $newsletter->save();
            return redirect()->back()->with("success", "Thank you for signing up for the newsletter");
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }
}
