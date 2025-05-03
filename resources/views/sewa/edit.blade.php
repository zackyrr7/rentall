@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0" style="height: 100vh; overflow: hidden;">
        <div class="row ">
            <div class="col-12 h-100">
                <div class="card ">
                    <div class="card-header">
                        Data Pemesanan
                    </div>
                    <div class="card-body">
                        @csrf

                        <div class="mb-3 row">
                            <label for="tipe" class="col-md-2 col-form-label">tipe</label>
                            <div class="col-md-4">
                                <select class="form-control" id="tipe" name="tipe" required>
                                    <optgroup label="Daftar Tipe">
                                        <option value="" selected disabled>Silahkan Pilih Tipe</option>
                                        <option value="Manual" {{ $data[0]->tipe == 'Manual' ? 'selected' : '' }}>Manual
                                        </option>
                                        <option value="Automatic" {{ $data[0]->tipe == 'Automatic' ? 'selected' : '' }}>
                                            Automatic</option>
                                    </optgroup>
                                </select>

                            </div>
                            <label for="tipe" class="col-md-2 col-form-label">Status</label>

                            @php
                                if ($data[0]->STATUS == '0') {
                                    $status = 'Boking';
                                } elseif ($data[0]->STATUS == '1') {
                                    $status = 'Berlangsung';
                                } elseif ($data[0]->STATUS == '2') {
                                    $status = 'Selesai';
                                } else {
                                    $status = 'Dibatalkan';
                                }

                            @endphp



                            <div class="col-md-4">
                                <input class="form-control" type="text" value="{{ $status }}" disabled
                                    placeholder="Silahkan diisi dengan tanggal ambil" id="status" name="tgl_ambil">

                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tgl_ambil" class="col-md-2 col-form-label">Tanggal Ambil</label>
                            <div class="col-md-4">
                                <input class="form-control" type="date" value="{{ $data[0]->tgl_ambil }}"
                                    placeholder="Silahkan diisi dengan tanggal ambil" id="tgl_ambil" name="tgl_ambil">
                            </div>
                            <label for="tgl_pulang" class="col-md-2 col-form-label">Tanggal Pulang</label>
                            <div class="col-md-4">
                                <input class="form-control" type="date"
                                    placeholder="Silahkan diisi dengan tanggal Pulang" value="{{ $data[0]->tgl_pulang }}"
                                    id="tgl_pulang" name="tgl_pulang">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="hari_sewa" class="col-md-2 col-form-label">Total hari penyewaan</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text"
                                    value="{{ \Carbon\Carbon::parse($data[0]->tgl_pulang)->diffInDays(\Carbon\Carbon::parse($data[0]->tgl_ambil)) }}"
                                    id="hari_sewa" name="hari_sewa" readonly>
                            </div>

                        </div>


                        <div class="mb-3 row">
                            <label for="mobil" class="col-md-2 col-form-label">mobil</label>
                            <div class="col-md-4">
                                <select class="form-control" id="mobil" name="mobil" required>
                                    <option value="{{ $data[0]->id_mobil }}" selected>
                                        {{ $data[0]->merk . ' | ' . $data[0]->plat_nomor . ' | ' . $data[0]->tgl_pulang }}
                                    </option>
                                </select>
                            </div>

                            <input type="hidden" id="id_mobil" name="id_mobil" value="{{ $data[0]->id_mobil }}">

                            <label for="harga" class="col-md-2 col-form-label">Harga</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" id="harga"
                                    value="{{ rupiah($data[0]->harga) }}" name="harga" readonly style="text-align: right">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="discount" class="col-md-2 col-form-label">Discount</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="discount" id="discount"
                                    value="{{ rupiah($data[0]->diskon) }}" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"
                                    data-type="currency" style="text-align: right">
                            </div>

                            <label for="total" class="col-md-2 col-form-label">Total</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" id="total" name="total"
                                    value="{{ rupiah($data[0]->total) }}" readonly style="text-align: right">
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="penyewa" class="col-md-2 col-form-label">Penyewa</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" id="penyewa" name="penyewa"
                                    value="{{ $data[0]->penyewa }}" placeholder="Silahkan diisi dengan nama penyewa">

                            </div>
                            <label for="anggota" class="col-md-2 col-form-label">Anggota pengeluar</label>
                            <div class="col-md-4">
                                <select class="form-control" id="anggota" name="anggota" required>
                                    <optgroup label="Daftar Anggota">
                                        <option value="" selected disabled>Silahkan Pilih Anggota</option>
                                        @foreach ($nama as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $data[0]->id_user == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div style="float: right;">
                            <button type="button" class="btn btn-primary btn-md" id="simpan">Simpan</button>

                            <a href="{{ route('pemesanan.index') }}" class="btn btn-warning btn-md">Kembali</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection




@push('js')
    @include('sewa.js.edit')
@endpush
