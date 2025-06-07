@extends('layouts.mobile.app')
@section('header')
    <div class="header fixed-top d-flex align-items-center justify-content-between px-3"
        style="height: 56px; background: #fff; border-bottom: 1px solid #eee;">

        {{-- Left: Back to Dashboard --}}
        <a href="{{ route('employee.dashboard') }}"
            class="btn btn-link text-decoration-none p-0 m-0 d-flex align-items-center" style="color: #121927;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="ms-1">Kembali</span>
        </a>

        <h5 class="m-0 text-center flex-grow-1" style="position: absolute; left: 50%; transform: translateX(-50%);">
            Ajukan Izin
        </h5>
    </div>
@endsection
@section('content')
    <form id="leaveForm" action="{{ route('employee.leave.store') }}" method="POST" class="mt-10"
        enctype="multipart/form-data">
        @csrf

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-field form-2">
            <div class="label h7">Tanggal Mulai</div>
            <fieldset class="mt-12">
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
            </fieldset>
        </div>

        <div class="form-field form-2 mt-24">
            <div class="label h7">Tanggal Selesai</div>
            <fieldset class="mt-12">
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
            </fieldset>
        </div>

        <div class="form-field form-2 mt-24">
            <div class="label h7">Jenis Izin</div>
            <fieldset class="mt-12">
                <select name="type" class="form-control" required>
                    <option value="">-- Pilih Jenis Izin --</option>
                    <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>Sakit</option>
                    <option value="annual" {{ old('type') == 'annual' ? 'selected' : '' }}>Tahunan</option>
                    <option value="personal" {{ old('type') == 'personal' ? 'selected' : '' }}>Pribadi</option>
                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </fieldset>
        </div>

        <div class="form-field mt-24">
            <div class="label h7">Alasan</div>
            <fieldset class="mt-12">
                <textarea name="reason" required>{{ old('reason') }}</textarea>
            </fieldset>
        </div>

        <div class="form-field form-2 mt-24">
            <div class="label h7">Upload Bukti Pendukung (opsional)</div>
            <div class="box-uploadfile mt-12">
                <label class="uploadfile">
                    <input type="file" name="attachment" class="ip-file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    <svg width="24" height="24">...</svg>
                    <div class="text body-4">Format PDF, DOC, JPG, PNG</div>
                    <div class="file button-1 text-primary">Browse Files</div>
                </label>
            </div>
        </div>

        <div class="fixed-button">
            <button type="submit" class="tf-btn primary">Ajukan Izin</button>
        </div>
    </form>

    <script>
        document.getElementById('leaveForm').addEventListener('submit', function(e) {
            const startDate = new Date(document.querySelector('[name="start_date"]').value);
            const endDate = new Date(document.querySelector('[name="end_date"]').value);
            const fileInput = document.querySelector('[name="attachment"]');
            const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
            const maxFileSize = 2 * 1024 * 1024; // 2MB

            if (startDate > endDate) {
                e.preventDefault();
                alert('Tanggal mulai tidak boleh setelah tanggal selesai.');
                return;
            }

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileSize = file.size;
                const fileExt = file.name.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(fileExt)) {
                    e.preventDefault();
                    alert('Format file tidak didukung. Hanya PDF, DOC, JPG, PNG.');
                    return;
                }

                if (fileSize > maxFileSize) {
                    e.preventDefault();
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    return;
                }
            }
        });
    </script>
@endsection
