@extends('_admin.layouts.app')

@section('content')
    <div class="container-xxl">
        <div class="row align-items-center mb-3">
            <div class="col">
                <h3 class="fw-bold">Absensi Karyawan (Admin)</h3>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.attendance.index') }}" class="mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama atau Username"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- Filter Status --</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <div class="atted-info d-flex mb-3 flex-wrap gap-3">
            <div class="full-present me-2">
                <i class="icofont-check-circled text-success me-1"></i>
                <span>Hadir Penuh</span>
            </div>
            <div class="Half-day me-2">
                <i class="icofont-wall-clock text-warning me-1"></i>
                <span>Hadir Setengah Hari</span>
            </div>
            <div class="absent me-2">
                <i class="icofont-close-circled text-danger me-1"></i>
                <span>Tidak Hadir</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="width:100%">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            <th>{{ $day }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                        <tr>
                            <td><span class="fw-bold small">{{ $employee->full_name }}</span></td>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $date = \Carbon\Carbon::create($year, $month, $day)->toDateString();
                                    $attendance = $attendances->get($employee->id)
                                        ? $attendances[$employee->id]->firstWhere('date', $date)
                                        : null;
                                @endphp
                                <td class="text-center">
                                    @if ($attendance)
                                        @if ($attendance->status === 'present')
                                            <i class="icofont-check-circled text-success"></i>
                                        @elseif ($attendance->status === 'late' || $attendance->status === 'half')
                                            <i class="icofont-wall-clock text-warning"></i>
                                        @else
                                            <i class="icofont-close-circled text-danger"></i>
                                        @endif
                                    @else
                                        <i class="icofont-close-circled text-danger"></i>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $daysInMonth + 1 }}" class="text-center">Tidak ada data karyawan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            @php
                $currentPage = $employees->currentPage();
                $lastPage = $employees->lastPage();
            @endphp

            <nav aria-label="Navigasi halaman">
                <ul class="pagination mt-4">
                    <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $currentPage > 1 ? $employees->url($currentPage - 1) : '#' }}">
                            Sebelumnya
                        </a>
                    </li>

                    @for ($i = 1; $i <= $lastPage; $i++)
                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $employees->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ $currentPage < $lastPage ? $employees->url($currentPage + 1) : '#' }}">
                            Selanjutnya
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
@endsection
