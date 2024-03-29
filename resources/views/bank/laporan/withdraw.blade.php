@extends('layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"> Detail Laporan Withdrawal</h4>
                        <div class="data-tables">
                            <table id="table2" class="table table-bordered table-hover text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>No.</th>
                                        <th>Rekening</th>
                                        <th>Nama</th>
                                        <th>Nominal</th>
                                        <th>Kode Unik</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdrawals as $i => $withdrawal)
                                        
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="text-center"> {{ $withdrawal->wallet->rekening }}</td>
                                        <td class="text-center"> {{ $withdrawal->wallet->user->name}}</td>
                                        <td class="text-center">Rp.{{ number_format ( $withdrawal->nominal, 0,',','.') }}</td>
                                        <td class="text-center">{{ $withdrawal->kode_unik }}</td>
                                        <td class="text-center">{{ $withdrawal->status }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-right mt-3">
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
