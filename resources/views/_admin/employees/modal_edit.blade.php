<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editUserForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editUserLabel">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_full_name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="full_name" id="edit_full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_password" class="form-label">Kata Sandi <small>(kosongkan jika tidak diubah)</small></label>
                            <input type="password" name="password" id="edit_password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_role" class="form-label">Peran</label>
                            <select name="role" id="edit_role" class="form-select">
                                <option value="employee">Karyawan</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_phone" class="form-label">No. Telepon</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_position" class="form-label">Posisi</label>
                            <input type="text" name="position" id="edit_position" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_gender" class="form-label">Jenis Kelamin</label>
                            <select name="gender" id="edit_gender" class="form-select">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_birth_date" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="birth_date" id="edit_birth_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_status" class="form-label">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui Karyawan</button>
                </div>
            </form>
        </div>
    </div>
</div>
