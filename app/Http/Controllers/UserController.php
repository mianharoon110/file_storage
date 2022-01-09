<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function viewRegisterForm() {
        return view('auth.register');
    }

    function viewLoginForm() {
        return view('auth.login');
    }

    function register(Request $request):RedirectResponse {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|max:12|confirmed'
        ]);
        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $saveResult = $user->save();
        } catch (\Exception $e) {
            //log error
        }
        return back()->with('isRegistered',$saveResult);
    }

    function login(Request $request) {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        try {
            $user = User::where('email', '=', $request->email)->first();

            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $request->session()->put('userId', $user->id);
                    return redirect('dashboard');
                }
            }
        } catch (\Exception $e) {
            //log error
        }
        return back()->with('loginFailed',false);
    }

    function logout(){
        if(session()->has('userId')){
            session()->pull('userId');
            return redirect('/');
        }
    }
}
