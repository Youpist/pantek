<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Wallet;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;

class TransaksiController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function customerIndexKantin()
    {
        $title = 'Kantin';
        $produks = Produk::all();
        $wallets = Wallet::where('id_user', auth()->user()->id )->first();
        // $bestSeller = Produk::select('produks.*', DB::raw('SUM(transaksis.kuantitas) as total_terjual'))
        // ->join('transaksis', 'produks.id', '=','transaksis.id_produk')
        // ->groupBy('produks.id')
        // ->orderByDesc('total_terjual')
        // ->first();
        return view('customer.kantin', compact('title', 'produks', 'wallets',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function keranjangIndex()
    {
        $title = 'Keranjang';
        $wallets = Wallet::where('id_user', auth()->user()->id)->first();
        $id_user =Auth::id();
        $keranjangs = Keranjang::where('id_user', $id_user)->get();

        $totalharga = 0;

        foreach ($keranjangs as $keranjang){
            $totalHargaPerItem= $keranjang->produk->harga * $keranjang->jumlah_produk;
            $totalharga += $totalHargaPerItem; 
        }
        return view('customer.keranjang', compact('title','wallets', 'id_user', 'keranjangs', 'totalharga'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addToCart(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'jumlah_produk'=> 'required|numeric',
            'id_produk'=> 'required',
            'id_user'=> 'required',
            'harga'=> 'required',
        ]);

        $id_user = $request->id_user;
        $produk = Produk::find($request->id_produk);

        if(!$produk){
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $jumlah_produk = $request->jumlah_produk;
        $total_harga = $request->harga * $jumlah_produk;

        $produk_sama = Keranjang::where('id_user', $id_user)->where('id_produk', $produk->id)->first();

        if($produk_sama){
            $produk_sama->jumlah_produk += $jumlah_produk;
            $produk_sama->total_harga += $total_harga;
            $produk_sama->save();
        }else{
            Keranjang::create([
                'id_user'=> $id_user,
                'id_produk'=> $produk->id,
                'jumlah_produk'=> $jumlah_produk,
                'total_harga'=> $total_harga
            ]);

            return redirect()->back()->with('success', 'Berhasil memasukan keranjang');
        }
    }

    /**
     * Display the specified resource.
     */
    public function keranjangDestroy($id)
    {
        $keranjang = Keranjang::findOrfail($id);

        if(!$keranjang){
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $keranjang->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function checkout(Request $request)
    {
        $id_user = auth()->user()->id;

        $selectedProduks = Keranjang::where('id_user', $id_user)->get();

        $totalHarga = $selectedProduks->sum('total_harga');
        $userWallet = Wallet::where('id_user', $id_user)->first();

        if($userWallet->saldo < $totalHarga){
            return redirect()->route('customer.index')->with(['error' =>  'Saldo tidak mencukupi']);
        }
        $invoice = 'INV'. auth()->user()->id . now()->format('dmYhis');
        session(['current_invoice' => $invoice]);

        foreach($selectedProduks as $product){
            $transaksi = new Transaksi();
            $transaksi->id_user = $id_user;
            $transaksi->id_produk =$product->id_produk;
            $transaksi->harga =$product->produk->harga;
            $transaksi->total_harga =$product->total_harga;
            $transaksi->kuantitas =$product->jumlah_produk;
            $transaksi->tgl_transaksi =now();
            $transaksi->invoice = $invoice;
            $transaksi->status = 'paid';
            $transaksi->save();

            $produk = Produk::find($product->id_produk);
            $produk->stok -= $product->jumlah_produk;
            $produk->save();

            $product->delete();
        }
        $userWallet->saldo -= $totalHarga;
        $userWallet->save();

        $title = 'Invoice';
        return view('customer.invoice', compact('selectedProduks','totalHarga', 'produk', 'title', 'invoice'));
    }

        public function invoice(){
            $invoice = session('current_invoice');
            $transaksis = Transaksi::where('invoice', $invoice)->get();
            $totalharga = $transaksis->sum('total_harga');

            $selectedProduks = [];
            foreach ($transaksis as $transaksi){
                $produk = Produk::find($transaksi->id_produk);

                $selectedProduks []= [
                    'produk'=> $produk,
                    'nama_produk'=> $produk->nama_produk,
                    'kuantitas'=> $transaksi->kuantitas,
                    'total_harga'=> $transaksi->total_harga
                ];
            }

            session()->forget('current_invoice');
            return view('customer.cetak-invoice', compact('selectedProduks', 'invoice', 'totalharga'));
        }

        // Untuk kantin
    public function laporanTransaksiHarian(){
        $title = 'Laporan Transaksi Harian';

        $transaksis = Transaksi::select(DB::raw('DATE(tgl_transaksi) as tanggal'), DB::raw('SUM(total_harga) as total_harga'))
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();
        

        $totalharga = $transaksis->sum('total_harga');

        return view('kantin.laporan.transaksi_harian', compact('title', 'transaksis', 'totalharga'));

    }

    public function laporanTransaksi($invoice){
        $title = 'Laporan Transaksi';

        // $invoice = date('Y-m-d', strtotime($invoice));
        
        $transaksis = Transaksi::where('invoice', $invoice)->get();
        $totalharga = $transaksis->sum('total_harga');
        session(['current_invoice'=> $invoice]);

        return view('kantin.laporan.transaksi', compact('title', 'transaksis', 'totalharga', 'invoice'));
    }

    public function riwayatTransaksi(){
        $title = 'Riwayat Transaksi';

        $transaksis = Transaksi::select(DB::raw('DATE(tgl_transaksi) as tanggal'), DB::raw('SUM(total_harga) as total_harga'))
        ->where('id_user', auth()->id())
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();
        

        $totalharga = $transaksis->sum('total_harga');

        return view('customer.riwayat.transaksi', compact('title', 'transaksis', 'totalharga'));
    }

    public function detailRiwayatTransaksi($invoice){
        $title = 'Detail Pembelian';

        $selectedProduks = Transaksi::where('invoice', $invoice)->get();
        $totalHarga = $selectedProduks->sum('total_harga');
        session(['current_invoice' => $invoice]);

        return view('customer.invoice', compact('title','selectedProduks', 'totalHarga', 'invoice'));
    }
}
