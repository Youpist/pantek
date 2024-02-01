<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Pengguna';
      $users = User::all() ;
      return view('admin.data_pengguna', compact('title','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required',
            'role'=> 'required'
        ]);

        $user = User::create($validation);

        $rekening = '64'. $user->id. now('dmYhis');

        Wallet::create([
            'rekening'=> $rekening,
            'id_user'=> $user->id,
            'saldo'=> 0,
            'status'=> 'aktif'
        ]);

        return redirect()->back()->with('success', 'berhasil menambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
