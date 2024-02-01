@extends('layout.main')

@section('content')
    
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Permintaan Tarik Tunai</h4>
            <div class="data-tables">
                <table id="table2" class="table table-bordered table-hover text-center">
                    <thead class="bg-light text-capitalize text-center">
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Rekening</th>
                            <th>Nominal</th>
                            <th>Kode Unik</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($withdrawals as $i => $withdrawal)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $withdrawal->wallet->user->name }}</td>
                                <td>{{ $withdrawal->rekening }}</td>
                                <td>Rp.{{ number_format($withdrawal->nominal, 0,',','.') }}</td>
                                <td>{{ $withdrawal->kode_unik }}</td>
                                <td>{{ $withdrawal->status }}</td>
                                <td class="col-2">
                                    @if ($withdrawal->status === 'menunggu')
                                        <form
                                            action="{{ route('konfirmasi.withdrawal', $withdrawal->id) }}"
                                            method="post" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="btn btn-primary btn-sm">Konfirmasi</button>
                                        </form>

                                        <form
                                            action="{{ route('tolak.withdrawal', $withdrawal->id) }}"
                                            method="post" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm">Tolak</button>
                                        </form>
                                    @elseif($withdrawal->status === 'dikonfirmasi')
                                        <button type="submit"
                                            class="btn btn-success btn-sm col-12">{{ $withdrawal->status }}</button>
                                    @else
                                        <button type="submit"
                                            class="btn btn-danger btn-sm col-12">{{ $withdrawal->status }}</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    @endsection
