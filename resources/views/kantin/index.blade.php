@extends('layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-4 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">wallet</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Pendapatan</p>
                            <h4 class="mb-0">Rp.{{ number_format($total_pemasukan, 0,',','.') }}</h4>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-4 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">wallet</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Pendapatan Perhari</p>
                            <h4 class="mb-0">Rp.{{ number_format($total_perhari, 0,',','.') }}</h4>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Tabel Produk</h4>
                        <div class="data-tables">
                            <table id="table2" class="table table-bordered table-hover text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>No.</th>
                                        <th>Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Kategori</th>
                                        <th>Desc</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produks as $i => $produk)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td class="text-center"><img src="{{asset('./storage/produk/'. $produk->foto)}}" 
                                                alt="{{$produk->nama_produk}} " width="100px"></td>
                                            <td>{{ $produk->nama_produk }}</td>
                                            <td>Rp.{{number_format($produk->harga, 0,',','.')}},00</td>
                                            <td>{{ $produk->stok }}</td>
                                            <td>{{ $produk->kategori->nama_kategori}}</td>
                                            <td>{{ $produk->desc }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
