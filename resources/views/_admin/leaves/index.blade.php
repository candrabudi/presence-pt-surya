@extends('_admin.layouts.app')

@section('content')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div
                class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">Permintaan Izin Kerja</h3>
            </div>
        </div>
    </div>

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Karyawan</th>
                                <th>Nama Karyawan</th>
                                <th>Jenis Cuti</th>
                                <th>Dari</th>
                                <th>Sampai</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaves as $leave)
                                <tr>
                                    <td>
                                        <a href="" class="fw-bold text-secondary">
                                            #KAR : {{ str_pad($leave->user->id, 5, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="fw-bold ms-1">{{ $leave->user->full_name }}</span>
                                    </td>
                                    @php
                                        $jenisCuti = [
                                            'sick' => 'Sakit',
                                            'annual' => 'Tahunan',
                                            'personal' => 'Pribadi',
                                            'other' => 'Lainnya',
                                        ];
                                    @endphp

                                    <td>{{ $jenisCuti[$leave->type] ?? ucfirst($leave->type) }}</td>

                                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}</td>
                                    <td>{{ $leave->reason }}</td>
                                    <td>
                                        @if ($leave->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif($leave->status == 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($leave->status == 'pending')
                                            <div class="btn-group" role="group" aria-label="Aksi Cuti">
                                                <button type="button" class="btn btn-outline-secondary btn-approve"
                                                    data-bs-toggle="modal" data-bs-target="#statusModal"
                                                    data-id="{{ $leave->id }}" data-status="approved" title="Setujui">
                                                    <i class="icofont-check-circled text-success"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary btn-reject"
                                                    data-bs-toggle="modal" data-bs-target="#statusModal"
                                                    data-id="{{ $leave->id }}" data-status="rejected" title="Tolak">
                                                    <i class="icofont-close-circled text-danger"></i>
                                                </button>
                                            </div>
                                        @else
                                            <em>Tidak ada aksi</em>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        @if ($leaves->lastPage() > 1)
                            @php
                                $currentPage = $leaves->currentPage();
                                $lastPage = $leaves->lastPage();
                            @endphp
                            <nav aria-label="Navigasi halaman" class="mt-3">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $currentPage > 1 ? $leaves->url($currentPage - 1) : '#' }}">Sebelumnya</a>
                                    </li>

                                    @for ($i = 1; $i <= $lastPage; $i++)
                                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $leaves->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $currentPage < $lastPage ? $leaves->url($currentPage + 1) : '#' }}">Selanjutnya</a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="statusForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" id="statusInput" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Konfirmasi Status Cuti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin <span id="statusText"></span> pengajuan cuti ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ya, Lanjutkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var statusModal = document.getElementById('statusModal');
            var statusForm = document.getElementById('statusForm');
            var statusInput = document.getElementById('statusInput');
            var statusText = document.getElementById('statusText');

            statusModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var leaveId = button.getAttribute('data-id');
                var status = button.getAttribute('data-status');

                statusForm.action = '/admin/leaves/' + leaveId;
                statusInput.value = status;

                statusText.textContent = (status === 'approved') ? 'menyetujui' : 'menolak';
            });
        });
    </script>
@endpush
