@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Akun / Pengguna Sistem</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Akun</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col d-flex justify-content-start">
                <a class="btn btn-secondary" href="{{ route('users.index') }}">
                    <i class="fa fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        <form id="formUserCreate" action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Akun / Pengguna Sistem</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name"><strong>Nama</strong></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Masukkan nama lengkap" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email"><strong>Email</strong></label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Masukkan alamat email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="password"><strong>Password</strong>
                                        </label>
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Masukkan password" minlength="12"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+\[\]{};:'&quot;,.&lt;&gt;/?\\|`~]).{12,}$"
                                            title="Minimal 12 karakter, kombinasi huruf besar/kecil, angka, dan simbol.">
                                        <span class="text-muted d-block" style="font-size: 0.85em; margin-top: 2px;">
                                            <i class="fa fa-info-circle"></i>
                                            Minimal 12 karakter, kombinasi huruf besar, kecil, angka & simbol.
                                        </span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="confirm-password"><strong>Konfirmasi Password</strong></label>
                                        <input type="password" name="confirm-password" id="confirm-password"
                                            class="form-control" placeholder="Ulangi password" minlength="12">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="roles"><strong>Role</strong></label>
                                <select name="roles" id="roles"
                                    class="form-control @error('roles') is-invalid @enderror">
                                    <option value="">-- Pilih Role --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" {{ old('roles') == $role ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" form="formUserCreate" class="btn btn-primary">
                                <i class="fa fa-save me-2"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
