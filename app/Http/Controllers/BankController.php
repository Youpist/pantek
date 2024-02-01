<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function topupIndex()
    {
        $title = 'Konfirmasi Topup';
        $topups = TopUp::all();
        return view('bank.topup', compact('topups', 'title'));  
    }
    public function withdrawalIndex()
    {
        $title = 'Konfirmasi Withdrawal';
        $withdrawals = Withdrawal::all();
        return view('bank.withdrawal', compact('withdrawals', 'title'));  
    }

    /**
     * Untuk Customer
     */
    public function topup(Request $request)
    {
        $request->validate([
            'nominal'=> 'required|integer',
            'rekening'=> 'required|string|exists:wallets,rekening'
        ]);

        $kodeUnik = 'TU'. auth()->user()->id . now()->format('dmYhis');
        $topup = TopUp::create([
            'rekening'=> $request->rekening,
            'nominal'=> $request->nominal,
            'kode_unik'=>$kodeUnik,
            'status'=> 'menunggu'
        ]);
        return redirect()->route('customer.index')->with('success', 'Permintaan top up berhasil');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function konfirmasiTopup($id)
    {
        $topup = TopUp::findOrfail($id);

        $topup->status = 'dikonfirmasi';
        $topup->save();

        $wallet = Wallet::where('rekening', $topup->rekening)->first();
        $wallet->saldo += $topup->nominal;
        $wallet->save();

        return redirect()->route('bank.topup')->with('success', 'Berhasil dikonfirmasi');
    }
    

    /**
     * Display the specified resource.
     */
    public function tolakTopup($id)
    {
        $topup = TopUp::findOrfail($id);

        $topup->status = 'ditolak';
        $topup->save();

        return redirect()->route('bank.index')->with('success', 'Topup ditolak');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function withdrawal(Request $request)
    {
        
        $request->validate([
            'nominal'=> 'required|integer',
            'rekening'=> 'required|string|exists:wallets,rekening'
        ]);
        $wallet = Wallet::where('rekening', $request->rekening)->first();
        if($wallet->saldo < $request->nominal){
            return redirect()->back()->with('error', 'Saldo tidak mencukupi');
        }

        $kodeUnik = 'WD' . auth()->user()->id . now()->format('dmYhis');
        $withdrawal = Withdrawal::create([
            'rekening' => $request->rekening,
            'nominal'=> $request->nominal,
            'kode_unik'=> $kodeUnik,
            'status'=> 'menunggu'
        ]);

        return redirect()->route('customer.index')->with('success', 'Berhasil withdraw');
    }

    /**
     * Update the specified resource in storage.
     */
    public function konfirmasiWithdrawal($id)
    {
        $withdrawal = Withdrawal::findOrfail($id);

        $withdrawal->status = 'dikonfirmasi';
        $withdrawal->save();

        $wallet = Wallet::where('rekening', $withdrawal->rekening)->first();
        $wallet->saldo -= $withdrawal->nominal;
        $wallet->save();

        return redirect()->route('bank.index')->with('success', 'Withdraw dikonfirmasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function tolakWithdrawal($id)
    {
        $withdrawal = Withdrawal::findOrfail($id);

        $withdrawal->status = 'ditolak';
        $withdrawal->save();

        return redirect()->route('bank.index')->with('error', 'Withdraw ditolak');
    }

    public function laporanTopupHarian(){
        $title = 'Laporan Topup Harian';

        // $today = now()->toDateString();
        // $wallet = Wallet::where('id_user', auth()->id())->first();
        $topups = TopUp::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal' ))
        // ->where('rekening', $wallet->rekening)
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();
        $totalNominal = $topups->sum('nominal');

        return view('bank.laporan.topup-harian', compact('title', 'topups', 'totalNominal'));
    }

    public function laporanTopup($tanggal){
        $title = 'Laporan Topup';

        $tanggal = date('Y-m-d', strtotime($tanggal));
        $topups= TopUp::where(DB::raw('DATE(created_at)'), $tanggal)->get();
        $totalNominal = $topups->sum('nominal');

        return view('bank.laporan.topup_detail', compact('title', 'topups', 'totalNominal'));
    }

    public function laporanWithdrawalHarian(){
        $title = 'Laporan Withdrawal Harian';

        // $today = now()->toDateString();
        $withdrawals = Withdrawal::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();
        $totalNominal = $withdrawals->sum('nominal');

        return view('bank.laporan.withdrawal-harian', compact('title', 'withdrawals', 'totalNominal'));
    }

    public function laporanWithdrawal($tanggal){
        $title = 'Laporan Withdrawal';

        $tanggal = date('Y-m-d', strtotime($tanggal));
        $withdrawals = Withdrawal::where(DB::raw('DATE(created_at)'), $tanggal)->get();
        $totalNominal = $withdrawals->sum('nominal');

        return view('bank.laporan.withdraw', compact('title', 'withdrawals', 'totalNominal'));
    }

    public function riwayatTopup(){
        $title = 'Riwayat Topup';

        $wallet = Wallet::where('id_user', auth()->id())->first();
        // $topups = TopUp::where('rekening', $wallet->rekening)->get();
        $topups = TopUp::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
        ->where('rekening', $wallet->rekening)
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();

        return view('customer.riwayat.topup', compact('title', 'topups', 'wallet'));
    }

    public function riwayatWithdrawal(){
        $title = 'Riwayat Withdrawal';

        $wallet = Wallet::where('id_user', auth()->id())->first();
        $withdrawals = Withdrawal::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
        ->where('rekening', $wallet->rekening)
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();

        return view('customer.riwayat.withdrawal', compact('title', 'withdrawals', 'wallet'));
    }
}
