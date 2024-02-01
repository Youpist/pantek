@extends('layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-5 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">account_balance_wallet</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Saldo Anda</p>
                            <h4 class="mb-0">Rp. {{ number_format($wallets->saldo, 0,',','.') }}</h4>

                        </div>
                        <div class="float-end">
                            <button type="button" class="btn btn-light my-3 mr-3" data-bs-toggle="modal"
                                data-bs-target="#topupModal"><i class="ti-plus">Top up</i>
                            </button>
                            <button type="button" class="btn btn-light my-3 mr-3" data-bs-toggle="modal"
                                data-bs-target="#tariktunaiModal"><i class="ti-archive"></i> Tarik Tunai</button>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">

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
                                        <td class="text-center"><img src="{{ asset('./storage/produk/' . $produk->foto) }}"
                                                alt="{{ $produk->nama_produk }} " width="100px"></td>
                                        <td>{{ $produk->nama_produk }}</td>
                                        <td>Rp.{{ number_format($produk->harga, 0, ',', '.') }},00</td>
                                        <td>{{ $produk->stok }}</td>
                                        <td>{{ $produk->kategori->nama_kategori }}</td>
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
    <div class="modal fade" id="topupModal" tabindex="-1" role="dialog" aria-labelledby="topupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="topupModalLabel">Top Up</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('customer.topup') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rekening">Rekening</label>
                            <input id="rekening" name="rekening" type="text" placeholder="" class="form-control"
                                required value="{{ $wallets->rekening }}">
                        </div>

                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="text" id="nominal" class="form-control" placeholder="" name="nominal"
                                required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Top Up</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tariktunaiModal" tabindex="-1" role="dialog" aria-labelledby="tariktunaiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tariktunaiModalLabel">Tarik Tunai</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('withdrawal.request') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rekening">Rekening</label>
                            <input id="rekening" name="rekening" type="text" placeholder="" class="form-control"
                                required value="{{ $wallets->rekening }}">
                        </div>

                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="text" id="nominal" class="form-control" placeholder="" name="nominal"
                                required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tarik Tunai</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
