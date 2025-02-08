<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\OtpMail;
use App\Mail\TokenMail;
use App\Models\ForgotPassword;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //
    public function register(){
        return view('auth.register');
    }
    public function registerPost(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users',
            'address' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        // store user 
        $otp=random_int(10000,99999);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'otp' => $otp,
            'otp_expire_at' => Carbon::now()->addMinutes(5),
        ]);
        // send otp to user
        
        Mail::to($request->email)->send(new OtpMail($otp));
        return redirect(route('otp'))->with('success','Account created successfully');
    }
    public function otp(){
        return view('auth.otp');
    }


    public function verifyOtp(Request $request){
        $request->validate([
            'otp' => 'required|integer',
        ]);
        $user=User::where('otp',$request->otp)->first();
        if(!$user){
            return back()->with('error','Invalid OTP or OTP Expired');
        }
        if($user->otp_expire_at && Carbon::now()->gt($user->otp_expire_at)){
            return back()->with('error','OTP Expired.Please request a new OTP');
        }

        $user->otp=0;
        $user->otp_expire_at=null;
        $user->is_verified='1';
        $user->save();
        return redirect(route('login'))->with('success','OTP Verified! You can now log in.');
    }
    
    public function login(){
        return view('auth.login');
    }

    public function loginpost(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email=$request->email;
        $emailExist=User::where('email',$email)->first();
        if ($emailExist) {
            if (Hash::check($request->password,$emailExist->password)){
                Auth::login($emailExist);
                return redirect(route('dashboard'));
            }
            else{
                return back()->with('error','Invalid  password');
            }
        }
        
        return view('auth.login')-> with('error','Invalid email or password');
    }

    public function forgotpassword(){
        return view('auth.forgotpassword');
    }

    public function forgotpasswordpost(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);
        $email=$request->email;
        $token=Str::random(60);
        $created=Carbon::now();
        $emailExist=User::where('email',$email)->first();
        if ($emailExist){
            $user_id=$emailExist->id;
            $user=ForgotPassword::where('user_id',$user_id)->first();
            if($user){
                $user->token=$token;
                $user->createdAT=$created;
                $user->save();
            }
            else{
                $newUser=new ForgotPassword();
                $newUser->user_id=$user_id;
                $newUser->token=$token;
                $newUser->createdAT=$created;
                $newUser->save();
            }
                Mail::to($email)->send(new TokenMail($token));
                return back()->with('success','Reset link sent to your email');
            }
        else{
                return back()->with('error','incorrect email');
            }
        }

    public function setnewpassword($token){
            return view('auth.resetpassword',compact('token'));
        }

    public function resetpasswordpost(Request $request ,$token){
            $request->validate([
                'password'=>'required|confirmed|min:6',
            ]);
            $tokenExist=ForgotPassword::where('token',$token)->first();
            if($tokenExist){
                if (Carbon::now()->subMinutes(5)<$tokenExist->createdAt){
                    $id=$tokenExist->user_id;
                    $userExist=User::where('id',$id)->first();
                    $userExist->password=Hash::make($request->password);
                    $userExist->save();
                    return redirect(route('login'))->with('success','password change successfully');


                }
                else{
                    return redirect(route('forgotpassword'))->with('error','Reset link has expired');
                }
            }
            else{
                return redirect(route('forgotpassword'))->with('error','incorrect  reset link');
            }
    }
    
    public function logout(){
        Auth::logout();
        return redirect(route('login'));
    }

}