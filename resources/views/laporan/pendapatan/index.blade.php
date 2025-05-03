@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0" style="height: 100vh; overflow: hidden;">
        <div class="row ">
            <div class="col-12 h-100">
                <div class="card ">
                    <div class="card-header">
                        Laporan pendaptan
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="mb-3 row">
                            <label for="tgl_awal" class="col-md-2 col-form-label">Tanggal Awal</label>
                            <div class="col-md-4">
                                <input class="form-control" type="date" placeholder="Silahkan diisi dengan tanggal Awal"
                                    id="tgl_awal" name="tgl_awal">
                            </div>
                            <label for="tgl_akhir" class="col-md-2 col-form-label">Tanggal Akhir</label>
                            <div class="col-md-4">
                                <input class="form-control" type="date" placeholder="Silahkan diisi dengan tanggal Ahhir"
                                    id="tgl_akhir" name="tgl_akhir">
                            </div>
                        </div>

                        {{-- Margin --}}
                        <div class="mb-3 row">
                            <label for="sptb" class="col-md-12 col-form-label">
                                Ukuran Margin Untuk Cetakan PDF (Milimeter)
                            </label>
                            <label for="sptb" class="col-md-2 col-form-label"></label>
                            <label for="" class="col-md-1 col-form-label">Kiri</label>
                            <div class="col-md-1">
                                <input type="number" class="form-control" id="margin_kiri" name="margin_kiri"
                                    value="15">
                            </div>
                            <label for="" class="col-md-1 col-form-label">Kanan</label>
                            <div class="col-md-1">
                                <input type="number" class="form-control" id="margin_kanan" name="margin_kanan"
                                    value="15">
                            </div>
                            <label for="" class="col-md-1 col-form-label">Atas</label>
                            <div class="col-md-1">
                                <input type="number" class="form-control" id="margin_atas" name="margin_atas"
                                    value="15">
                            </div>
                            <label for="" class="col-md-1 col-form-label">Bawah</label>
                            <div class="col-md-1">
                                <input type="number" class="form-control" id="margin_bawah" name="margin_bawah"
                                    value="15">
                            </div>
                        </div>

                        <div class="mb-3 row" style="float: center;">
                            <div class="col-md-12" style="text-align: center">
                                <button class="btn btn-dark btn-md cetak_laporan" data-jenis="layar">Layar</button>
                                <button class="btn btn-warning btn-md cetak_laporan" data-jenis="pdf">PDF</button>
                                <button class="btn btn-success btn-md cetak_laporan" data-jenis="excel">Excel</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('laporan.pendapatan.js.index')
@endpush
