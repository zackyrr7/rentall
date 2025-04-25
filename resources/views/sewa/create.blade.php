@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0" style="height: 100vh; overflow: hidden;">
        <div class="row ">
            <div class="col-12 h-100">
                <div class="card ">
                    <div class="card-header">
                        Input Pemesanan
                    </div>
                    <div class="card-body">
                        @csrf

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
                        </div>

                        <div class="mb-3 row">
                            <label for="tgl_ambil" class="col-md-2 col-form-label">Tanggal Ambil</label>
                            <div class="col-md-4">
                                <input class="form-control" type="date" placeholder="Silahkan diisi dengan tanggal ambil"
                                    id="tgl_ambil" name="tgl_ambil">
                            </div>
                            <label for="tgl_pulang" class="col-md-2 col-form-label">Tanggal Pulang</label>
                            <div class="col-md-4">
                                <input class="form-control" type="date"
                                    placeholder="Silahkan diisi dengan tanggal Pulang" id="tgl_pulang" name="tgl_pulang">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="hari_sewa" class="col-md-2 col-form-label">Total hari penyewaan</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" id="hari_sewa" name="hari_sewa">
                            </div>

                        </div>


                        <div class="mb-3 row">
                            <label for="mobil" class="col-md-2 col-form-label">mobil</label>
                            <div class="col-md-4">
                                <select class="form-control" id="mobil" name="mobil" required>
                                </select>

                            </div>
                            <label for="harga" class="col-md-2 col-form-label">Harga</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" id="harga" name="harga" readonly
                                    style="text-align: right">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="discount" class="col-md-2 col-form-label">Discount</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="discount" id="discount"
                                    pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" style="text-align: right">
                            </div>

                            <label for="total" class="col-md-2 col-form-label">Total</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" id="total" name="total" readonly
                                    style="text-align: right">
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="penyewa" class="col-md-2 col-form-label">Penyewa</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" id="harga" name="penyewa"
                                    placeholder="Silahkan diisi dengan nama penyewa">

                            </div>
                            <label for="anggota" class="col-md-2 col-form-label">Anggota pengeluar</label>
                            <div class="col-md-4">
                                <select class="form-control" id="anggota" name="anggota" required>
                                    <optgroup label="Daftar Anggota">
                                        <option value="" selected disabled>Silahkan Pilih Anggota</option>
                                        @foreach ($nama as $item)
                                            <option value="{{ $item->nama_lengkap }}">{{ $item->nama_lengkap }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
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
    @include('sewa.js.create')
@endpush
