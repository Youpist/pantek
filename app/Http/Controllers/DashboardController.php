<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TopUp;
use App\Models\Produk;
use App\Models\Wallet;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function adminIndex()
    {
        $title = 'Dashboard';
        $users = User::all();
        return view('admin.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function kantinIndex()
    {
        $title = 'Dashboard';
        $produks = Produk::all();
        $kategoris = Kategori::all();
        $total_pemasukan = Transaksi::all()->sum('total_harga');
        $total_perhari = Transaksi::whereDate('tgl_transaksi', today())->sum('total_harga');
        return view('kantin.index', compact('title', 'produks', 'kategoris', 'total_pemasukan', 'total_perhari'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function bankIndex()
    {
        $title = 'Dashboard';
        $customers = User::where('role', 'customer')->get();
        $wallets = Wallet::all();
        $topups = TopUp::all();
        
        $withdrawals = Withdrawal::all();
        $requestTopups = TopUp::all();
        $requestWithdrawals = Withdrawal::where('status', 'menunggu')->get();
        return view('bank.index', compact('title', 'customers', 'wallets', 'requestTopups','requestWithdrawals', 'topups','withdrawals' ));
    }

    /**
     * Display the specified resource.
     */
    public function customerIndex()
    {
        $title = 'Dashboard';
        $produks = Produk::all();
        $wallets = Wallet::where('id_user', auth()->user()->id)->first();

        return view('customer.index', compact('title', 'wallets', 'produks'));
    }
}
