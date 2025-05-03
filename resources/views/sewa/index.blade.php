@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0" style="height: 100vh; overflow: hidden;">
        <div class="row h-100 m-0">
            <div class="col-12 h-100">
                <div class="card h-100 m-0">
                    <div class="card-header">
                        <div class="mb-3 row">
                            <div class="col-md-2 col-form-label">
                                <select class="form-control select2-multiple" style="width: 100%" id="status"
                                    name="status">
                                    <option value="" disabled selected>Silahkan Pilih</option>
                                    <option value="Boking">Boking</option>
                                    <option value="Berlangsung">Berlangsung</option>
                                    <option value="selesai">selesai</option>
                                    <option value="Batal">Batal</option>
                                    <option value="">Semua</option>

                                </select>
                            </div>
                            <div class="col-md-10">
                                <a href="{{ route('pemesanan.create') }}" class="btn btn-primary float-right">Input
                                    Pemesanan</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="sewa" class="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center" hidden>id</th>
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

    {{-- Modal Rincian Boking --}}
    <div id="modal_rincian_boking" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Status Sewa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Informasi penyewa dan mobil -->
                    <div class="mb-3 row">
                        <label for="penyewa2" class="col-md-2 col-form-label">Penyewa</label>
                        <div class="col-md-4">
                            <input type="text" id="penyewa2" name="penyewa2" class="form-control" readonly>
                        </div>

                        <label for="merk2" class="col-md-2 col-form-label">Mobil</label>
                        <div class="col-md-4">
                            <input type="text" id="merk2" name="merk2" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Tanggal ambil dan pulang -->
                    <div class="mb-3 row">
                        <label for="tgl_ambil2" class="col-md-2 col-form-label">Tanggal Ambil</label>
                        <div class="col-md-4">
                            <input type="text" id="tgl_ambil2" name="tgl_ambil2" class="form-control" readonly>
                            <input type="hidden" id="id_sewa2" name="id_sewa2">
                        </div>

                        <label for="tgl_pulang2" class="col-md-2 col-form-label">Tanggal Pulang</label>
                        <div class="col-md-4">
                            <input type="text" id="tgl_pulang2" name="tgl_pulang2" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-4 row">
                        <label for="tipe" class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-6">
                            <select id="tipe" name="tipe" class="form-control" required>
                                <optgroup label="Daftar Status">
                                    <option value="" selected disabled>Silahkan Pilih Status</option>
                                    <option value="Berlangsung">Berlangsung</option>
                                    <option value="Batal">Batal</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mb-3 row">
                        <div class="col-md-12 text-center">
                            <button id="simpan_boking" class="btn btn-primary btn-md">Simpan</button>
                            <button type="button" class="btn btn-warning btn-md" data-dismiss="modal">Keluar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Modal Rincian Berlangsung --}}
    <div id="modal_rincian_berlangsung" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Status Sewa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Informasi penyewa dan mobil -->
                    <div class="mb-3 row">
                        <label for="penyewa3" class="col-md-2 col-form-label">Penyewa</label>
                        <div class="col-md-4">
                            <input type="text" id="penyewa3" name="penyewa3" class="form-control" readonly>
                        </div>

                        <label for="merk3" class="col-md-2 col-form-label">Mobil</label>
                        <div class="col-md-4">
                            <input type="text" id="merk3" name="merk3" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Tanggal ambil dan pulang -->
                    <div class="mb-3 row">
                        <label for="tgl_ambil3" class="col-md-2 col-form-label">Tanggal Ambil</label>
                        <div class="col-md-4">
                            <input type="text" id="tgl_ambil3" name="tgl_ambil3" class="form-control" readonly>
                            <input type="hidden" id="id_sewa3" name="id_sewa3">
                        </div>

                        <label for="tgl_pulang3" class="col-md-2 col-form-label">Tanggal Pulang</label>
                        <div class="col-md-4">
                            <input type="text" id="tgl_pulang3" name="tgl_pulang3" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-4 row">
                        <label for="tipe2" class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-6">
                            <select id="tipe2" name="tipe2" class="form-control" required>
                                <optgroup label="Daftar Status">
                                    <option value="" selected disabled>Silahkan Pilih Status</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Batal">Batal</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mb-3 row">
                        <div class="col-md-12 text-center">
                            <button id="simpan_boking2" class="btn btn-primary btn-md">Simpan</button>
                            <button type="button" class="btn btn-warning btn-md" data-dismiss="modal">Keluar</button>
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
