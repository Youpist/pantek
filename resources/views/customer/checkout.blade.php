
@extends('layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">weekend</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Saldo Anda</p>
                            <h4 class="mb-0">Rp. {{ number_format($wallets->saldo) }}</h4>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-area">
                            <div class="invoice-head">
                                <div class="row">
                                    <div class="iv-left col-6">
                                        <span>CHECKOUT</span>
                                    </div>
                                    <div class="iv-right col-6 text-md-right">
                                        <span>#34445998</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="invoice-address">
                                        <h3>Checkout</h3>
                                        <h5>{{ auth()->user()->nama }}</h5>
                                        <p>{{ auth()->user()->email }}</p>
                                        <p>Rekening :</p>
                                        <p>{{ auth()->user()->wallet->rekening }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <ul class="invoice-date">
                                        <li>Invoice Date : now()</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-table table-responsive mt-5">
                                <table class="table table-bordered table-hover text-right">
                                    <thead>
                                        <tr class="text-capitalize">
                                            <th scope="col"></th>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: middle;"> <img width="100px"
                                                    src="{{ asset('storage/produk/' . $keranjang->produk->foto) }}"
                                                    alt=""></td>
                                            <td style="vertical-align: middle;">
                                                {{ $keranjang->produk->nama_produk }}</td>
                                            <td style="vertical-align: middle;">
                                                Rp.{{ number_format($keranjang->produk->harga, 0, ',', '.') }},00
                                            </td>
                                            <td style="vertical-align: middle;">{{ $keranjang->jumlah_produk }}
                                            </td>
                                            <td style="vertical-align: middle;">
                                                Rp.{{ number_format($keranjang->total_harga, 0, ',', '.') }},00
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">total balance :</td>
                                            <td>$140</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-buttons text-right">
                            <a href="#" class="invoice-btn">print invoice</a>
                            <a href="#" class="invoice-btn">send invoice</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
