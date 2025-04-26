@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0" style="height: 100vh; overflow: hidden;">
        <div class="row h-100 m-0">
            <div class="col-12 h-100">
                <div class="card h-100 m-0">
                    <div class="card-header">
                        <a href="{{ route('pemesanan.create') }}" class="btn btn-primary float-right">Input Pemesanan</a>
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="sewa" class="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Merk</th>
                                            <th class="text-center">Plat</th>
                                            <th class="text-center">Penyewa</th>
                                            <th class="text-center">Nama Anggota</th>
                                            <th class="text-center">Tanggal ambil</th>
                                            <th class="text-center">Tanggal pulang</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('sewa.js.index')
@endpush
