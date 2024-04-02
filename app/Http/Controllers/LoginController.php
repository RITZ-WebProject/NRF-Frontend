<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Customers;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    public function index() {
        return view('login.login');
    }

    public function customLogin(Request $request) {
        $request->validate([
                'email' => 'required',
                'password' => 'required|min:6|max:255',
        ]);
        $user = Customer::select('id','email','phone_primary','password')->where('email',$request->email)->orWhere('phone_primary',$request->email)->first();

        if($user) {
            if(password_verify($request->password,$user->password))
            {
                session()->put('email',$request->email);
                session()->put('customer_uniquekey',$user->id);
            	DB::table('customers')->where('email', $request->email)->update([
                    'active_status' => 'online'
                ]);
                return redirect('/shop')->with('Login Successful');
            }
            else {
                return redirect()->back()->with('fail', 'Invalid Password');
            }
        }
        else {
            return redirect()->back()->with('fail',"Incorrect Email or Password!");
        }
    }

    public function signOut(){
    	$email = session('email');
        Customer::where('email', $email)->update([
            'active_status' => 'offline'
        ]);
        Session::flush();
        Auth::logout();

        return Redirect('/login');
    }
}
