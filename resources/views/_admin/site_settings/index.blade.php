@extends('_admin.layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold">Pengaturan Situs</h3>
        </div>
    </div>

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Nama Perusahaan</label>
                                <input type="text" name="company_name" class="form-control"
                                    value="{{ old('company_name', $setting->company_name ?? '') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="company_logo" class="form-label">Logo Perusahaan</label>
                                <input type="file" name="company_logo" class="form-control">
                                @if (!empty($setting->company_logo))
                                    <img src="{{ asset('storage/' . $setting->company_logo) }}" alt="Logo"
                                        class="mt-2" height="60">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', $setting->address ?? '') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $setting->phone ?? '') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="email" class="form-label">Email Perusahaan</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $setting->email ?? '') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="default_check_in" class="form-label">Jam Masuk Default</label>
                                <input type="time" name="default_check_in" class="form-control"
                                    value="{{ old('default_check_in', $setting->default_check_in ?? '08:00') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="default_check_out" class="form-label">Jam Keluar Default</label>
                                <input type="time" name="default_check_out" class="form-control"
                                    value="{{ old('default_check_out', $setting->default_check_out ?? '17:00') }}">
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="footer_text" class="form-label">Teks Footer</label>
                                <textarea name="footer_text" class="form-control" rows="3">{{ old('footer_text', $setting->footer_text ?? '') }}</textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
