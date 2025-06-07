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
            <span class="ms-1">kembali</span>
        </a>

        <h5 class="m-0 text-center flex-grow-1" style="position: absolute; left: 50%; transform: translateX(-50%);">
            Riwayat Izin
        </h5>
    </div>
@endsection
@section('content')
    <form method="GET" class="mb-4">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ request('start_date') }}">
            </div>
            <div class="col-md-6">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    @if ($leaves->count())
        <div class="d-flex flex-column gap-3">
            @foreach ($leaves as $leave)
                <div class="p-3 border rounded bg-light">
                    <div class="mb-2"><strong>Jenis:</strong> {{ ucfirst($leave->type) }}</div>
                    <div class="mb-2"><strong>Periode:</strong> {{ $leave->start_date }} s.d {{ $leave->end_date }}</div>
                    <div class="mb-2"><strong>Alasan:</strong> {{ $leave->reason }}</div>
                    <div class="mb-2"><strong>Status:</strong>
                        @if ($leave->status == 'approved')
                            <span class="text-success fw-semibold">Disetujui</span>
                        @elseif($leave->status == 'rejected')
                            <span class="text-danger fw-semibold">Ditolak</span>
                        @else
                            <span class="text-warning fw-semibold">Menunggu</span>
                        @endif
                    </div>
                    @if ($leave->attachment_path)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $leave->attachment_path) }}" target="_blank"
                                class="text-primary text-decoration-underline">
                                Lihat Lampiran
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $leaves->withQueryString()->links() }}
        </div>
    @else
        <p class="text-muted mt-3">Tidak ada data pengajuan izin.</p>
    @endif
@endsection
