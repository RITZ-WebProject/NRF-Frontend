<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Session;

class ContactUsController extends Controller
{
    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ];

        // Send email to the owner
        Mail::to('eek752000@gmail.com')->send(new ContactUsMail($data));

        // Flash a success message to the session
        Session::flash('success', 'Your message was successfully sent to NRF Admin. Thank you for your message!');

        return redirect()->back();
    }
}
