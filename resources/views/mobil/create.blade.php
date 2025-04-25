@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0" style="height: 100vh; overflow: hidden;">
        <div class="row ">
            <div class="col-12 h-100">
                <div class="card ">
                    <div class="card-header">
                        Tambah Mobil
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="mb-3 row">
                            <label for="merk" class="col-md-2 col-form-label">Merk</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="Silahkan isi dengan merk"
                                    id="merk" name="merk">

                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tipe" class="col-md-2 col-form-label">tipe</label>
                            <div class="col-md-4">
                                <select class="form-control" id="tipe" name="tipe" required>
                                    <optgroup label="Daftar Tipe">
                                        <option value="" selected disabled>Silahkan Pilih Tipe</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Automatic">Automatic</option>
                                    </optgroup>
                                </select>

                            </div>
                            <label for="plat" class="col-md-2 col-form-label">Plat Nomor</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" placeholder="Silahkan isi dengan plat nomor"
                                    id="plat" name="plat">
                            </div>

                        </div>
                        <div class="mb-3 row">
                            <label for="tahun" class="col-md-2 col-form-label">Tahun</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" placeholder="Silahkan isi dengan tahun mobil"
                                    id="tahun" name="tahun">
                            </div>
                            <label for="harga" class="col-md-2 col-form-label">Harga Sewa</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="harga" id="harga"
                                    pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" style="text-align: right">
                            </div>

                        </div>

                        <div style="float: right;">
                            <button type="button" class="btn btn-primary btn-md" id="simpan">Simpan</button>

                            <a href="{{ route('mobil.index') }}" class="btn btn-warning btn-md">Kembali</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('mobil.js.create')
@endpush
