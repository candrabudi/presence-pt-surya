@extends('layouts.mobile.app')

@section('header')
    <div class="header fixed-top d-flex align-items-center justify-content-between px-3"
        style="height: 56px; background: #fff; border-bottom: 1px solid #eee;">

        <a href="{{ route('employee.dashboard') }}"
            class="btn btn-link text-decoration-none p-0 m-0 d-flex align-items-center" style="color: #121927;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="ms-1">Kembali</span>
        </a>

        <h5 class="m-0 text-center flex-grow-1" style="position: absolute; left: 50%; transform: translateX(-50%);">
            Absensi
        </h5>
    </div>
@endsection

@section('content')
    <div class="container py-4 px-3">
        <div class="text-center mb-4">
            <h4 class="fw-bold mb-1">Halo, {{ Auth::user()->full_name }}</h4>
            <small class="text-muted">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</small>
        </div>

        <div class="bg-light rounded-4 p-3 mb-4 border">
            <div class="text-center mb-3">
                <video id="video" autoplay playsinline class="mirror-video"></video>
                <canvas id="canvas" style="display: none;"></canvas>
            </div>

            @if (!$attendance || !$attendance->check_out)
                <div class="d-grid">
                    <button onclick="ambilFoto('{{ !$attendance ? 'checkin' : 'checkout' }}')"
                        class="btn btn-kamera text-white">
                        <i class="ri-camera-line fs-4 me-2"></i>
                        {{ !$attendance ? 'Ambil Foto Check-In' : 'Ambil Foto Check-Out' }}
                    </button>
                </div>
            @else
                <div class="alert alert-success text-center rounded-3 mb-0 small">
                    Kamu sudah <strong>Check-Out</strong> hari ini 🎉
                </div>
            @endif
        </div>

        @if ($attendance)
            <div class="bg-light rounded-4 p-3 border" style="max-width: 100%; box-sizing: border-box;">
                <h6 class="fw-bold mb-3 text-primary">Status Absensi</h6>
                <ul class="list-unstyled small mb-3" style="line-height: 1.5;">
                    <li>✅ <strong>Check-In:</strong> {{ $attendance->check_in ?? '-' }}</li>
                    <li>⏳ <strong>Check-Out:</strong> {{ $attendance->check_out ?? '-' }}</li>
                    <li>📌 <strong>Status:</strong> <span class="text-capitalize">{{ $attendance->status }}</span></li>
                </ul>

                <div class="d-flex justify-content-between gap-3">
                    @if ($attendance->check_in_photo)
                        <div class="text-center flex-fill">
                            <label class="form-label small fw-semibold d-block mb-1">Foto Check-In</label>
                            <img src="{{ asset('storage/' . $attendance->check_in_photo) }}" alt="Check-In"
                                style="width: 48vw; max-width: 140px; height: auto; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                        </div>
                    @endif

                    @if ($attendance->check_out_photo)
                        <div class="text-center flex-fill">
                            <label class="form-label small fw-semibold d-block mb-1">Foto Check-Out</label>
                            <img src="{{ asset('storage/' . $attendance->check_out_photo) }}" alt="Check-Out"
                                style="width: 48vw; max-width: 140px; height: auto; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>

    <style>
        .mirror-video {
            width: 100%;
            aspect-ratio: 3 / 4;
            border-radius: 1rem;
            object-fit: cover;
            transform: scaleX(-1);
            border: 1px solid #dee2e6;
        }

        .btn-kamera {
            background-color: #0d6efd;
            border-radius: 50px;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            transition: background 0.3s ease;
        }

        .btn-kamera:hover {
            background-color: #0b5ed7;
        }

        .border {
            border: 1px solid #dee2e6 !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');

        async function bukaKamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user'
                    }
                });
                video.srcObject = stream;
            } catch (err) {
                alert('Tidak dapat membuka kamera: ' + err.message);
            }
        }

        async function ambilFoto(tipe) {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            context.save();
            context.translate(canvas.width, 0);
            context.scale(-1, 1); // flip horizontal
            context.drawImage(video, 0, 0);
            context.restore();

            const gambar = canvas.toDataURL('image/jpeg');

            try {
                const url = tipe === 'checkin' ?
                    "{{ route('employee.attendance.checkin') }}" :
                    "{{ route('employee.attendance.checkout') }}";

                await axios.post(url, {
                    photo: gambar,
                    type: tipe
                });

                window.location.href = "{{ route('employee.attendance.success') }}";
            } catch (err) {
                alert('Gagal mengirim foto. Silakan coba lagi.');
                console.error(err);
            }
        }

        window.addEventListener('DOMContentLoaded', bukaKamera);
    </script>
@endsection
@section('menubar')
    @include('layouts.mobile.partials.menubar-footer')
@endsection
