<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\admin_login;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class VerifyEmailController extends Controller
{
    public function index(){
        return view('admin.verify_email');
    }


    public function check_email(Request $request){
        //$email= $request->email;
        $credentials = $request->validate([
            'email' => 'required|string',
        ]);

        if($credentials)
        {
            $admin = admin_login::where('email', $request->email)->first();
            $email = admin_login::where('email', $request->email)->pluck('email')->first();

            if($admin){
                $otp = rand(100000, 999999);
               $expiresAt = Carbon::now()->addMinutes(10);
        
                // admin_login::create([
                //     'user_id' => $user->id,
                //     'otp' => $otp,
                //     'expires_at' => $expiresAt,
                // ]);
        
                admin_login::where('email', $request->email)->update([
                    'otp' => $otp,
                ]);
                Mail::raw("Your OTP is: $otp", function ($message) use ($admin) {
                    $message->to('techanita2003@gmail.com')
                        ->subject('Your OTP Code');
                });
        
                return response()->json(['message' => 'OTP sent to your email.']);
            }
            else{
                return redirect()->route('verify_email')->with('error', 'Invalid email');
            }
            
        }
        else{
            return redirect()->route('verify_email')->with('error',$credentials );
        }
    }

}
