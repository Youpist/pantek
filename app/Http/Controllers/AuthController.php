<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email harus diisi',
                'password.required' => 'Password harus diisi',
            ]
            );

            $infologin = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($infologin)){
                if (Auth::user()->role == "admin"){
                    return redirect()->route('admin.index');
                }elseif(Auth::user()->role == "kantin"){
                    return redirect()->route('kantin.index');
                }elseif(Auth::user()->role == "customer"){
                    return redirect()->route('customer.index');
                }elseif(Auth::user()->role == "bank"){
                    return redirect()->route('bank.index');
                }
            }else{
                return redirect(route('login'))->withErrors('Email dan Password salah');
            }
    }
    function logout(){
        Auth::logout();
        return redirect('');
    }
    
}
