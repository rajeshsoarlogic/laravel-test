<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Mail;
use Auth;

class CustomLoginController extends Controller
{
    public function __construct(){

    }

    public function loginRequest(){
        return view('login-request');
    }

    public function loginRequestEmail(Request $request){
        //dd($request->toArray());
        $validated = $request->validate([
            'email' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if($user){
            $uuid = Str::uuid()->toString();
            $user->uuid = $uuid;
            $user->save();
            $loginLink = route('login.link', $uuid);
            //dd($loginLink);
            $dataLogin = array(
                'loginLink' => $loginLink,
                'user' => $user
            );
    
            Mail::send('emails.requestLoginLink', $dataLogin, function ($m) use ($user) {
                $m->from('hello@app.com', 'Your Application');
                $m->to($user->email, $user->name)->subject('Login Link');
            });
            return redirect()->route('/');
        }else{
            return redirect()->back()->with('status',$request->email.' not exists');
        }

    }

    public function loginLink($token){
        $user = User::where('uuid', $token)->first();
        //dd($user->toArray());
        Auth::loginUsingId($user->id);
        return redirect()->route('home');
    }
}
