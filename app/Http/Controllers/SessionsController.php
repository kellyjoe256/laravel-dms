<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('destroy');
    }
    
    public function create()
    {
        $data = [
            'title' => 'Login - DMS',
            'body_class' => 'hold-transition login-page',
        ];

        return view('main/login', $data);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username is required',
            'password.required' => 'Password is required',
        ]);
        
        $user = User::where('username', '=', $request->username)->first();
        if (!$user || !($user->checkCredentials($request->password))) {
            return back()->with([
                'class' => 'alert-danger',
                'message' => 'Please check your credentials',
            ]);
        }

        auth()->login($user);

        return redirect()->route('index');
    }

    public function destroy()
    {
        $user = auth()->user();
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        auth()->logout();
        session()->pull('lastActivityTime');

        return redirect()->route('login')->with([
            'class' => 'alert-success',
            'message' => 'You signed out successfully',
        ]);
    }
}
