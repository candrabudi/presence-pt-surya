@extends('_admin.layouts.app')

@section('content')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div
                class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">Karyawan</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal"
                        data-bs-target="#addUser">
                        <i class="icofont-plus-circle me-2 fs-6"></i>Tambah Karyawan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="statusFilter" class="form-label">Filter Status</label>
            <select id="statusFilter" class="form-select">
                <option value="">Semua</option>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>
    </div>

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <table id="employeeTable" class="table table-hover align-middle mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>No. Telepon</th>
                                <th>Posisi</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Status</th>
                                <th>Login Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $index => $employee)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $employee->full_name }}</td>
                                    <td>{{ $employee->username }}</td>
                                    <td>{{ $employee->phone ?? '-' }}</td>
                                    <td>{{ $employee->position ?? '-' }}</td>
                                    <td>{{ ucfirst($employee->gender ?? '-') }}</td>
                                    <td>{{ $employee->birth_date }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $employee->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $employee->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td>{{ $employee->last_login_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Tindakan">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick='openEditModal(@json($employee))'>
                                                <i class="icofont-edit text-success"></i>
                                            </button>
                                            <form action="{{ route('admin.employees.destroy', $employee->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-secondary deleterow"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="icofont-ui-delete text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($employees->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data karyawan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('_admin.employees.modal_create')
    @include('_admin.employees.modal_edit')
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"></script>

    <script>
        function openEditModal(employee) {
            const modal = new bootstrap.Modal(document.getElementById('editUser'));
            document.getElementById('editUserForm').action = `/admin/employees/${employee.id}`;
            document.getElementById('edit_id').value = employee.id;
            document.getElementById('edit_full_name').value = employee.full_name;
            document.getElementById('edit_username').value = employee.username;
            document.getElementById('edit_password').value = ''; // kosongkan password
            document.getElementById('edit_role').value = employee.role;
            document.getElementById('edit_phone').value = employee.phone ?? '';
            document.getElementById('edit_position').value = employee.position ?? '';
            document.getElementById('edit_gender').value = employee.gender ?? '';
            document.getElementById('edit_birth_date').value = employee.birth_date ?? '';
            document.getElementById('edit_status').value = employee.status;
            modal.show();
        }
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#employeeTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                columnDefs: [{
                    targets: 7,
                    render: function(data, type, row) {
                        if (data.includes("Aktif")) return "Aktif";
                        if (data.includes("Tidak Aktif")) return "Tidak Aktif";
                        return data;
                    }
                }]
            });

            $('#statusFilter').on('change', function() {
                var val = $(this).val();
                table.column(7).search(val).draw();
            });
        });
    </script>
@endpush
