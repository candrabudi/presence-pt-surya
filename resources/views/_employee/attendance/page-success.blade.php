@extends('layouts.mobile.app')

@section('content')
    <div class="app-fullheight2 d-flex flex-column justify-content-between align-items-center py-5 px-4">
        <div></div>

        <div class="box-success text-center">
            <img src="{{ asset('mobile/images/icon/success.png') }}" alt="Berhasil"
                style="max-width: 120px; height: auto; margin-bottom: 20px;">
            <div class="box-title">
                <h2 class="fw-bold text-success">
                    Berhasil {{ session('attendance_type') === 'checkout' ? 'Check-Out' : 'Check-In' }}
                </h2>
                <p class="body-2 mt-2 text-muted">
                    Kamu telah berhasil melakukan {{ session('attendance_type') === 'checkout' ? 'Check-Out' : 'Check-In' }}
                    hari ini.
                </p>
            </div>
        </div>

        <div class="group-btn w-100 mt-4">
            <a href="{{ route('employee.dashboard') }}" class="tf-btn primary w-100 text-center">Kembali ke Beranda</a>
        </div>
    </div>
@endsection
