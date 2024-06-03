<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\admin_login;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        return view('admin.sign-in');
        // if(Auth::guard('admin')->guest())
        // {
        //     return view('admin.sign-in');
        // }
    }

    public function login(Request $request){
        $email= $request->email;
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // $user = admin_login::where('email', $request->email)->first();

        // if ($user) {
        //     // Verify the password manually
        //     if (Hash::check($request->password, $user->password)) {
        //         // Authenticate the user
        //         Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]);
        //         return redirect()->route('dashboard'); // Change to your intended route
        //     } else {
        //         // Password does not match
        //         return back()->withErrors([
        //             'password' => 'The provided password does not match our records.',
        //         ])->onlyInput('email');
        //     }
        // } else {
        //     // Email does not exist
        //     return back()->withErrors([
        //         'email' => 'The provided email does not exist in our records.',
        //     ])->onlyInput('email');
        // }

        if($credentials)
        {
            // if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])){
            //     return redirect()->route('dashboard');
            // }else{
            //    if(!Auth::guard('admin')->attempt(['email'=>$request->email])) 
            //    {
            //         return redirect()->route('sign-in')->with('error','email is incorrect.');
            //    }
            //    return redirect()->route('sign-in')->with('error','password is incorrect.');
            // }

            if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password]))
            {
                return redirect()->route('dashboard');
            }
            else{
                return redirect()->route('sign-in')->with('error','Invalid details');
            }

        }else{
            return redirect()->route('sign-in')->with('error', $credentials);
        }
    }


    // public function logout(){
    //     if(Auth::guard('admin')->logout())
    //     {
    //         return redirect()->route('sign-in');
    //     }
    // }
}
