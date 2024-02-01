@extends('layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"> Laporan</h4>
                        <div class="data-tables">
                            <table id="table2" class="table table-bordered table-hover text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>No.</th>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksis as $i =>$transaksi)
                                        
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="text-center"> {{ $transaksi->invoice }}</td>
                                        <td class="text-center"> {{ $transaksi->user->name }}</td>
                                        <td class="text-center"> {{ $transaksi->produk->nama_produk}}</td>
                                        <td class="text-center">Rp.{{ number_format ( $transaksi->harga, 0,',','.') }}</td>
                                        <td class="text-center"> {{ $transaksi->kuantitas}}</td>
                                        <td class="text-center">Rp.{{ number_format ( $transaksi->total_harga, 0,',','.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-end mt-3">
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
