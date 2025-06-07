@extends('_admin.layouts.app')
@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-6">
            <h3 class="fw-bold mb-0">Jadwal Kerja</h3>
        </div>
    </div>

    <div class="row clearfix g-3">
        <div class="col-md-7">
            <div class="card mb-3">
                <div class="card-body p-3">
                    <table id="workScheduleTable" class="table table-hover align-middle mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr data-id="{{ $schedule->id }}" data-day="{{ $schedule->day }}"
                                    data-start="{{ $schedule->start_time }}" data-end="{{ $schedule->end_time }}">
                                    <td>{{ $schedule->day }}</td>
                                    <td>{{ $schedule->start_time ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : 'Libur' }}
                                    </td>
                                    <td>{{ $schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : 'Libur' }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-edit">Edit</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card mb-3">
                <div class="card-body p-3">
                    <h5 class="mb-3">Form Edit Jadwal Kerja</h5>

                    <form method="POST" id="editScheduleForm" action="">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="day" class="form-label">Hari</label>
                            <input type="text" id="day" name="day" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="start_time" class="form-label">Jam Mulai</label>
                            <input type="time" id="start_time" name="start_time" class="form-control"
                                placeholder="Kosongkan jika libur">
                        </div>

                        <div class="mb-3">
                            <label for="end_time" class="form-label">Jam Selesai</label>
                            <input type="time" id="end_time" name="end_time" class="form-control"
                                placeholder="Kosongkan jika libur">
                        </div>

                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editButtons = document.querySelectorAll('.btn-edit');
            const form = document.getElementById('editScheduleForm');
            const dayInput = document.getElementById('day');
            const startInput = document.getElementById('start_time');
            const endInput = document.getElementById('end_time');

            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tr = button.closest('tr');
                    const id = tr.getAttribute('data-id');
                    const day = tr.getAttribute('data-day');
                    const start = tr.getAttribute('data-start');
                    const end = tr.getAttribute('data-end');

                    form.action = `/admin/work-schedules/${id}`;
                    dayInput.value = day;
                    startInput.value = start ?? '';
                    endInput.value = end ?? '';
                });
            });
        });
    </script>
@endsection
