@extends('_admin.layouts.app')

@section('content')
    <div class="container-xxl">

        <div class="row align-items-center mb-3">
            <div class="col">
                <h3 class="fw-bold">Hari Libur</h3>
            </div>
            <div class="col-auto">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addHolidayModal">
                    <i class="icofont-plus-circle me-2 fs-6"></i>Tambah Hari Libur
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.holidays.index') }}" class="mb-3">
            <div class="input-group w-50">
                <input type="text" name="search" class="form-control" placeholder="Cari nama hari libur..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Nama Hari Libur</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($holidays as $index => $holiday)
                            @php
                                $dayName = \Carbon\Carbon::parse($holiday->date)->translatedFormat('l'); // nama hari dalam bahasa lokal
                                $formattedDate = \Carbon\Carbon::parse($holiday->date)->translatedFormat('d F Y');
                            @endphp
                            <tr>
                                <td>{{ $holidays->firstItem() + $index }}</td>
                                <td>{{ $dayName }}</td>
                                <td>{{ $formattedDate }}</td>
                                <td>{{ $holiday->name }}</td>
                                <td>{{ ucfirst($holiday->type) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-secondary btn-edit-holiday"
                                            data-id="{{ $holiday->id }}" data-name="{{ $holiday->name }}"
                                            data-date="{{ $holiday->date }}" data-type="{{ $holiday->type }}"
                                            data-bs-toggle="modal" data-bs-target="#editHolidayModal">
                                            <i class="icofont-edit text-success"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.holidays.destroy', $holiday->id) }}"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus hari libur ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-secondary">
                                                <i class="icofont-ui-delete text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data hari libur tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            @if ($holidays->lastPage() > 1)
                @php
                    $currentPage = $holidays->currentPage();
                    $lastPage = $holidays->lastPage();
                @endphp
                <nav aria-label="Navigasi halaman" class="mt-3">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                            <a class="page-link"
                                href="{{ $currentPage > 1 ? $holidays->url($currentPage - 1) : '#' }}">Sebelumnya</a>
                        </li>

                        @for ($i = 1; $i <= $lastPage; $i++)
                            <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $holidays->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                            <a class="page-link"
                                href="{{ $currentPage < $lastPage ? $holidays->url($currentPage + 1) : '#' }}">Selanjutnya</a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>

    </div>

    <div class="modal fade" id="addHolidayModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <form method="POST" action="{{ route('admin.holidays.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Hari Libur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="holiday_name" class="form-label">Nama Hari Libur</label>
                        <input type="text" id="holiday_name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="holiday_date" class="form-label">Tanggal Hari Libur</label>
                        <input type="date" id="holiday_date" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="holiday_type" class="form-label">Tipe Hari Libur</label>
                        <select id="holiday_type" name="type" class="form-select" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="national">Nasional</option>
                            <option value="company">Perusahaan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editHolidayModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <form method="POST" action="" class="modal-content" id="editHolidayForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Hari Libur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_holiday_id" name="id">
                    <div class="mb-3">
                        <label for="edit_holiday_name" class="form-label">Nama Hari Libur</label>
                        <input type="text" id="edit_holiday_name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_holiday_date" class="form-label">Tanggal Hari Libur</label>
                        <input type="date" id="edit_holiday_date" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_holiday_type" class="form-label">Tipe Hari Libur</label>
                        <select id="edit_holiday_type" name="type" class="form-select" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="national">Nasional</option>
                            <option value="company">Perusahaan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.btn-edit-holiday').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const date = this.dataset.date;
                const type = this.dataset.type;

                const form = document.getElementById('editHolidayForm');
                form.action = `/admin/holidays/${id}`;

                document.getElementById('edit_holiday_id').value = id;
                document.getElementById('edit_holiday_name').value = name;
                document.getElementById('edit_holiday_date').value = date;
                document.getElementById('edit_holiday_type').value = type;
            });
        });
    </script>
@endpush
