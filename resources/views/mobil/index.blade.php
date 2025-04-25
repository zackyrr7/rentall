@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0" style="height: 100vh; overflow: hidden;">
        <div class="row h-100 m-0">
            <div class="col-12 h-100">
                <div class="card h-100 m-0">
                    <div class="card-header">
                        <a href="{{ route('mobil.create') }}" class="btn btn-primary float-right">Tambah Mobil</a>
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="mobil" class="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Merk</th>
                                            <th class="text-center">Tipe</th>
                                            <th class="text-center">Plat Nomor</th>
                                            <th class="text-center">tahun</th>
                                            <th class="text-center">Harga sewa</th>
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
    @include('mobil.js.index')
@endpush
