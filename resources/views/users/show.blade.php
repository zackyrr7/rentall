@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0" style="height: 100vh; overflow: hidden;">
        <div class="row ">
            <div class="col-12 h-100">
                <div class="card ">
                    <div class="card-header">
                        Show User
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="mb-3 row">
                            <label for="nm_lengkap" class="col-md-2 col-form-label">Nama lengkap</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="Silahkan isi dengan nama lengkap"
                                    id="nm_lengkap" value="{{ $data->nama_lengkap }}" name="nm_lengkap" readonly>
                                @error('nm_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="username" class="col-md-2 col-form-label">Username</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" placeholder="Silahkan isi dengan Username"
                                    id="username" name="username" value="{{ $data->username }}" readonly>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" value="{{ $data->email }}" readonly
                                    placeholder="Silahkan isi dengan email" id="email" name="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="role" class="col-md-2 col-form-label">Role</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" value="{{ $data->role }}" readonly
                                    placeholder="Silahkan isi dengan email" id="email" name="email">

                            </div>
                            <label for="no_hp" class="col-md-2 col-form-label">Nomor HP</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" placeholder="Silahkan isi dengan nomor hp"
                                    id="no_hp" name="no_hp" value="{{ $data->no_hp }}">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div style="float: right;">


                            <a href="{{ route('user.index') }}" class="btn btn-warning btn-md">Kembali</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
