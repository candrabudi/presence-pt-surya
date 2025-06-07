@extends('layouts.mobile.app')

@section('header')
    <div class="header fixed-top d-flex align-items-center justify-content-between px-3"
        style="height: 56px; background: #fff;">

        <h3 class="m-0">Profile</h3>

        <div class="right d-flex align-items-center gap-3">

            <a href="#" class="icon-noline d-none">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 3.75C12.6858 3.75 13.25 4.31421 13.25 5C13.25 5.68579 12.6858 6.25 12 6.25C11.3142 6.25 10.75 5.68579 10.75 5C10.75 4.31421 11.3142 3.75 12 3.75Z"
                        fill="#121927" stroke="#121927" stroke-width="1.5"></path>
                    <path
                        d="M12 17.75C12.6858 17.75 13.25 18.3142 13.25 19C13.25 19.6858 12.6858 20.25 12 20.25C11.3142 20.25 10.75 19.6858 10.75 19C10.75 18.3142 11.3142 17.75 12 17.75Z"
                        fill="#121927" stroke="#121927" stroke-width="1.5"></path>
                    <path
                        d="M12 10.75C12.6858 10.75 13.25 11.3142 13.25 12C13.25 12.6858 12.6858 13.25 12 13.25C11.3142 13.25 10.75 12.6858 10.75 12C10.75 11.3142 11.3142 10.75 12 10.75Z"
                        fill="#121927" stroke="#121927" stroke-width="1.5"></path>
                </svg>
            </a>

            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0" style="color:#121927;" title="Logout"
                    onclick="return confirm('Anda yakin ingin logout?')">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 17L21 12L16 7" stroke="#121927" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M21 12H9" stroke="#121927" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M12 19H5C4.44772 19 4 18.5523 4 18V6C4 5.44772 4.44772 5 5 5H12" stroke="#121927"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="box-profile text-center">
        <div class="avatar">
            <img src="{{ asset('mobile/images/avt/avt-1.jpg') }}" alt="avt">
        </div>

        <form action="{{ route('employee.profile.update') }}" method="POST" class="px-4 text-start">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="full_name" class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                    name="full_name" value="{{ old('full_name', auth()->user()->full_name) }}" required>
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label fw-bold">Telepon</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                    name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label fw-bold">Alamat</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', auth()->user()->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="position" class="form-label fw-bold">Jabatan</label>
                <input type="text" class="form-control @error('position') is-invalid @enderror" id="position"
                    name="position" value="{{ old('position', auth()->user()->position) }}">
                @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label fw-bold">Jenis Kelamin</label>
                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                    <option value="" disabled {{ auth()->user()->gender ? '' : 'selected' }}>Pilih Jenis Kelamin
                    </option>
                    <option value="male" {{ old('gender', auth()->user()->gender) === 'male' ? 'selected' : '' }}>
                        Laki-laki</option>
                    <option value="female" {{ old('gender', auth()->user()->gender) === 'female' ? 'selected' : '' }}>
                        Perempuan</option>
                    <option value="other" {{ old('gender', auth()->user()->gender) === 'other' ? 'selected' : '' }}>
                        Lainnya</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="birth_date" class="form-label fw-bold">Tanggal Lahir</label>
                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                    name="birth_date" value="{{ old('birth_date', auth()->user()->birth_date) }}">
                @error('birth_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            <h5 class="mb-3 mt-5">Ubah Password</h5>

            <div class="mb-3">
                <label for="current_password" class="form-label fw-bold">Password Lama</label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                    id="current_password" name="current_password" autocomplete="current-password">
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password Baru</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    autocomplete="new-password">
            </div>

            <button type="submit" class="tf-btn primary mt-10">Simpan Perubahan</button>
        </form>

    </div>
@endsection

@section('menubar')
    @include('layouts.mobile.partials.menubar-footer')
@endsection
