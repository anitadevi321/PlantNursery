<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    // send contact_us page
    public function index(){
        return view('frontend.contact');
    }

    // store query or messages
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:contact_us,email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

       if($validation)
       {
            $data= ContactUs::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

           return redirect()->back()->with('success','send message successfuly.');
       }
       else{
        return redirect()->back()->withInput()->withErrors($credentials);
       }
    }
}