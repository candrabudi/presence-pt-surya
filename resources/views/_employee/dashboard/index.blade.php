@extends('layouts.mobile.app')

@section('header')
    <div class="header-avt fixed-top">
        <a href="setup-profile.html" class="box-avt">
            <div class="avt">
                <img src="{{ asset('mobile/images/avt/avt-1.jpg') }}" alt="avt">
            </div>
            <div class="content">
                <span class="body-4 text-dark-4">Welcome back!</span>
                <h4 class="name">
                    Hello! {{ Auth::user()->full_name }}
                    <img class="icon" src="{{ asset('mobile/images/icon/hello.png') }}" alt="">
                </h4>
            </div>
        </a>
    </div>
@endsection

@section('content')
    <div class="mt-24 banner-box text-white">
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1 pe-2">
                <h6 class="fw-bold mb-1 text-white">
                    {{ $schedule ? $schedule->start_time . ' - ' . $schedule->end_time . ' WIB' : 'Tidak ada jadwal kerja' }}
                </h6>
                <small class="d-block mb-2">{{ \Carbon\Carbon::now()->translatedFormat('l, j M Y') }}</small>

                @if ($holiday)
                    <div class="badge bg-danger-subtle text-white mb-2 px-3 py-1 rounded-pill">
                        <i class="ri-calendar-event-line me-1"></i> Hari Libur: {{ $holiday->name }}
                    </div>
                @elseif ($leave)
                    <div class="badge bg-warning text-dark mb-2 px-3 py-1 rounded-pill">
                        <i class="ri-suitcase-line me-1"></i> Cuti: {{ ucfirst($leave->type) }}
                    </div>
                @elseif ($attendance)
                    <div class="small">
                        <div>Check-In: <strong>{{ $attendance->check_in ?? '-' }}</strong></div>
                        <div>Check-Out: <strong>{{ $attendance->check_out ?? '-' }}</strong></div>
                    </div>
                @else
                    <div class="small text-white">Belum ada absensi hari ini</div>
                @endif

                <div class="mt-2 small">
                    Total Checkpoint: <strong>1</strong>
                </div>
            </div>

            <div class="text-center">
                @if ($holiday || $leave)
                    <div class="badge bg-secondary text-white px-3 py-2 rounded-pill mt-1">Tidak perlu absensi</div>
                @elseif (!$attendance)
                    <form action="{{ route('employee.attendance.checkin') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="btn btn-light text-primary rounded-circle shadow-sm">
                            <i class="ri-login-box-line fs-4"></i>
                        </button>
                        <div class="text-white small mt-1">Check-In</div>
                    </form>
                @elseif (!$attendance->check_out)
                    <form action="{{ route('employee.attendance.checkout') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="btn btn-light text-danger rounded-circle shadow-sm">
                            <i class="ri-logout-box-line fs-4"></i>
                        </button>
                        <div class="text-white small mt-1">Check-Out</div>
                    </form>
                @else
                    <div class="badge bg-success px-3 py-2 rounded-pill mt-1">Sudah Check-Out</div>
                @endif
            </div>
        </div>

        <div class="circle-animation">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
        </div>
    </div>

    <div class="mt-24 bg-white p-3 rounded-4 shadow-sm">
        <h6 class="fw-bold mb-3 text-primary">
            <i class="ri-calendar-2-line me-1"></i> Hari Libur Bulan Ini
        </h6>

        @if ($monthlyHolidays->count())
            <ul class="list-group list-group-flush">
                @foreach ($monthlyHolidays as $item)
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}</strong><br>
                            <small class="text-muted">{{ $item->name }}</small>
                        </div>
                        <span
                            class="badge 
                        {{ $item->type === 'national' ? 'bg-danger' : 'bg-warning text-dark' }}
                        rounded-pill text-uppercase mt-1">
                            {{ $item->type === 'national' ? 'Nasional' : 'Perusahaan' }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-muted small">
                Tidak ada hari libur pada bulan ini.
            </div>
        @endif
    </div>

    <div class="mt-4 bg-white p-3 rounded-4 shadow-sm" style="max-width: 100%; box-sizing: border-box;">
    <h6 class="fw-bold mb-3 text-primary d-flex align-items-center gap-2" style="font-size: 1.1rem;">
        <i class="ri-time-line fs-5"></i> Absensi Minggu Ini
    </h6>

    <ul class="list-group list-group-flush">
        @foreach (\Carbon\CarbonPeriod::create(now()->startOfWeek(), now()->endOfWeek()) as $day)
            @php
                $attendance = $weeklyAttendances->get($day->format('Y-m-d'));

                $checkInTime = $attendance && $attendance->check_in
                    ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i')
                    : '-';
                $checkOutTime = $attendance && $attendance->check_out
                    ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i')
                    : '-';
            @endphp
            <li class="list-group-item px-0 py-3 border-0" style="border-bottom: 1px solid #eee;">
                <strong class="d-block mb-2" style="font-size: 1rem;">
                    {{ $day->translatedFormat('l, d F') }}
                </strong>

                @if ($attendance)
                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                        <div class="text-success d-flex flex-column align-items-start flex-grow-1" style="min-width: 0; max-width: 50%;">
                            <div style="font-weight: 600; font-size: 0.95rem; white-space: nowrap;">
                                ✅ Check-In: {{ $checkInTime }}
                            </div>
                            @if ($attendance->check_in_photo)
                                <img src="{{ asset('storage/' . $attendance->check_in_photo) }}" alt="Check-in"
                                    class="rounded-3 border mt-2"
                                    style="width: 100%; max-width: 140px; height: 90px; object-fit: cover;">
                            @endif
                        </div>

                        <div class="text-danger d-flex flex-column align-items-end flex-grow-1" style="min-width: 0; max-width: 50%;">
                            <div style="font-weight: 600; font-size: 0.95rem; white-space: nowrap;">
                                ⏳ Check-Out: {{ $checkOutTime }}
                            </div>
                            @if ($attendance->check_out_photo)
                                <img src="{{ asset('storage/' . $attendance->check_out_photo) }}" alt="Check-out"
                                    class="rounded-3 border mt-2"
                                    style="width: 100%; max-width: 140px; height: 90px; object-fit: cover;">
                            @endif
                        </div>
                    </div>
                @else
                    <small class="text-muted" style="font-size: 0.9rem;">Tidak ada data absensi</small>
                @endif
            </li>
        @endforeach
    </ul>
</div>

@endsection

@section('menubar')
    @include('layouts.mobile.partials.menubar-footer')
@endsection
