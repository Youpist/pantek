@extends('layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">add</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Transaksi Topup</p>
                            <h4 class="mb-0">{{ count($topups) }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">payments</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Transaksi Withdraw</p>
                            <h4 class="mb-0">{{ count($withdrawals) }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>
            
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Permintaan Topup</h4>
                        <div class="data-tables">
                            <table id="table2" class="table table-bordered table-hover text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>No.</th>
                                        <th>Customer</th>
                                        <th>Rekening</th>
                                        <th>Nominal</th>
                                        <th>Kode Unik</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requestTopups as $i => $topup)

                                    <tr>
                                        <td>{{$i + 1}}</td>
                                        <td>{{$topup->wallet->user->name}}</td>
                                        <td>{{$topup->rekening}}</td>
                                        <td>Rp. {{number_format($topup->nominal, 0, ',', '.')}}</td>
                                        <td>{{$topup->kode_unik}}</td>
                                        <td>{{$topup->status}}</td>
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

    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Permintaan Tarik Tunai</h4>
                <div class="data-tables">
                    <table id="table2" class="table table-bordered table-hover text-center">
                        <thead class="bg-light text-capitalize">
                            <tr>
                                <th>No.</th>
                                <th>Customer</th>
                                <th>Rekening</th>
                                <th>Nominal</th>
                                <th>Kode Unik</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawals as $i => $withdrawal)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $withdrawal->wallet->user->name }}</td>
                                    <td>{{ $withdrawal->rekening }}</td>
                                    <td>{{ $withdrawal->nominal }}</td>
                                    <td>{{ $withdrawal->kode_unik }}</td>
                                    <td>{{ $withdrawal->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
