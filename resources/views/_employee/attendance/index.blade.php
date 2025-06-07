@extends('layouts.mobile.app')

@section('header')
    <div class="header fixed-top d-flex align-items-center justify-content-between px-3 border-bottom bg-white"
        style="height: 56px;">
        <a href="{{ route('employee.dashboard') }}"
            class="btn btn-link p-0 m-0 d-flex align-items-center text-dark text-decoration-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="ms-1">Kembali</span>
        </a>
        <div class="text-center w-100 position-absolute" style="left: 0;">
            <h6 class="m-0 fw-bold">Riwayat Absensi</h6>
        </div>
    </div>
@endsection

@section('content')
    <div class="pt-5"></div>

    <div class="container-fluid px-3">

        <form method="GET" class="d-flex flex-wrap align-items-end gap-3 mb-4 bg-white p-3 rounded shadow-sm">

            <div class="flex-grow-1 w-150px">
                <label for="start" class="form-label small fw-semibold text-muted mb-1">Tanggal Mulai</label>
                <input type="date" id="start" name="start"
                    value="{{ request('start', now()->startOfWeek()->format('Y-m-d')) }}"
                    class="form-control form-control-sm rounded-pill shadow-sm" />
            </div>

            <div class="flex-grow-1 w-100">
                <label for="end" class="form-label small fw-semibold text-muted mb-1">Tanggal Selesai</label>
                <input type="date" id="end" name="end"
                    value="{{ request('end', now()->endOfWeek()->format('Y-m-d')) }}"
                    class="form-control form-control-sm rounded-pill shadow-sm" />
            </div>

            <div>
                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm"
                    style="transition: background-color 0.3s ease;">
                    Tampilkan
                </button>
            </div>

        </form>

        <ul class="list-unstyled">
            @foreach ($dates as $day)
                @php
                    $dateKey = $day->format('Y-m-d');
                    $attendance = $attendances->get($dateKey);
                    $checkIn = $attendance?->check_in
                        ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i')
                        : null;
                    $checkOut = $attendance?->check_out
                        ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i')
                        : null;
                @endphp

                <li class="mb-3">
                    <div class="card shadow-sm rounded-4 p-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="flex-grow-1">
                                <div class="fw-bold fs-6 mb-2">{{ $day->translatedFormat('l, d F Y') }}</div>

                                @if ($attendance)
                                    <div class="d-flex flex-column gap-1">
                                        <div class="{{ $checkIn ? 'text-success' : 'text-warning' }}">
                                            🟢 Check-In: {{ $checkIn ?? 'Belum dilakukan' }}
                                        </div>
                                        <div class="{{ $checkOut ? 'text-danger' : 'text-warning' }}">
                                            🔴 Check-Out: {{ $checkOut ?? 'Belum dilakukan' }}
                                        </div>
                                        <span
                                            class="badge bg-{{ match ($attendance->status) {
                                                'present' => 'success',
                                                'late' => 'warning',
                                                'half' => 'info',
                                                default => 'secondary',
                                            } }} mt-2 px-3 py-1 fs-7">
                                            Status: {{ ucfirst($attendance->status) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="text-muted fst-italic">Tidak ada data absensi</div>
                                @endif
                            </div>

                            <div class="d-flex gap-3 text-center">
                                <div>
                                    <img src="{{ $attendance && $attendance->check_in_photo ? asset('storage/' . $attendance->check_in_photo) : 'https://cdn-icons-png.flaticon.com/128/12471/12471063.png' }}"
                                        class="rounded-circle border shadow-sm"
                                        style="width: 48px; height: 48px; object-fit: cover;">
                                    <div class="small mt-1 text-muted">IN</div>
                                </div>
                                <div>
                                    <img src="{{ $attendance && $attendance->check_out_photo ? asset('storage/' . $attendance->check_out_photo) : 'https://cdn-icons-png.flaticon.com/128/12471/12471063.png' }}"
                                        class="rounded-circle border shadow-sm"
                                        style="width: 48px; height: 48px; object-fit: cover;">
                                    <div class="small mt-1 text-muted">OUT</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

@section('menubar')
    @include('layouts.mobile.partials.menubar-footer')
@endsection
