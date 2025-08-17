@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0" style="height: 100vh; overflow: hidden;">
        <div class="row ">
            <div class="col-12 h-100">
                <div class="card ">
                    <div class="card-header">
                        Edit User
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="mb-3 row">
                            <label for="nm_lengkap" class="col-md-2 col-form-label">Nama lengkap</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $data->nama_lengkap }}"
                                    placeholder="Silahkan isi dengan nama lengkap" id="nm_lengkap" name="nm_lengkap"
                                    value="{{ old('nm_lengkap') }}">
                                @error('nm_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="username" class="col-md-2 col-form-label">Username</label>
                            <div class="col-md-4">
                                <input class="form-control @error('username') is-invalid @enderror" type="text"
                                    placeholder="Silahkan isi dengan Username" id="username" name="username"
                                    value="{{ $data->username }}">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-4">
                                <input class="form-control @error('email') is-invalid @enderror" type="text"
                                    placeholder="Silahkan isi dengan email" id="email" name="email"
                                    value="{{ $data->email }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="role" class="col-md-2 col-form-label">Role</label>
                            <div class="col-md-4">
                                <select class="form-control" id="role" name="tipe" required>
                                    <optgroup label="Daftar Tipe">
                                        <option value="" disabled {{ $data->role == '' ? 'selected' : '' }}>Silahkan
                                            Pilih Tipe</option>
                                        <option value="Admin" data-role="admin"
                                            {{ $data->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Anggota" data-role="anggota"
                                            {{ $data->role == 'anggota' ? 'selected' : '' }}>Anggota</option>
                                    </optgroup>
                                </select>

                            </div>
                            <label for="no_hp" class="col-md-2 col-form-label">Nomor HP</label>
                            <div class="col-md-4">
                                <input class="form-control @error('no_hp') is-invalid @enderror" type="text"
                                    placeholder="Silahkan isi dengan nomor hp" id="no_hp" name="no_hp"
                                    value="{{ $data->no_hp }}">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-md-2 col-form-label">Password</label>
                            <div class="col-md-4">
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    placeholder="Silahkan isi dengan password" id="password" name="password">

                            </div>
                            <label for="kon_password" class="col-md-2 col-form-label">Konfirmasi Password</label>
                            <div class="col-md-4">
                                <input class="form-control @error('kon_password') is-invalid @enderror" type="password"
                                    placeholder="Silahkan isi dengan konfirmasi password" id="kon_password"
                                    name="kon_password">

                            </div>
                        </div>
                        <div style="float: right;">
                            <button type="button" class="btn btn-primary btn-md" id="simpan">Simpan</button>

                            <a href="{{ route('user.index') }}" class="btn btn-warning btn-md">Kembali</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('users.js.edit')
@endpush
