<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Auth;
use Validator;
class LoginController extends Controller
{
    //
    public function index(Request $request){
        return view('pages.user.login');
    }

    public function submit(Request $request){
        $rules = [
            'email'      => 'required',
            'password'      => 'required'
        ];

        $messages = [
            'email.required'     => 'Username wajib diisi',
            'password.required'     => 'Password wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $remember = $request->has('remember') ? true : false;

        $data = [
            'email'     => $request->email,
            'password'  => $request->password,
        ];


        if (Auth::attempt($data, $remember)) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->withInput()->withErrors(['error_login' => 'Username atau Password tidak ditemukan!']);
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('login');
    }

}
