<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="pagetitle">
    <h1>Manajemen Diskon</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-body pt-4">

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">Daftar Diskon</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle"></i> Tambah Diskon
                </button>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($diskon as $d) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['tanggal'] ?></td>
                            <td>Rp<?= number_format($d['nominal'], 0, ',', '.') ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-edit" data-id="<?= $d['id'] ?>" data-tanggal="<?= $d['tanggal'] ?>" data-nominal="<?= $d['nominal'] ?>" data-bs-toggle="modal" data-bs-target="#modalEdit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <a href="/diskon/delete/<?= $d['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($diskon)) : ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data diskon</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</section>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/diskon/store" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Diskon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control <?= session('errors.tanggal') ? 'is-invalid' : '' ?>" value="<?= old('tanggal') ?>">
                    <div class="invalid-feedback"><?= session('errors.tanggal') ?></div>
                </div>
                <div class="mb-3">
                    <label for="nominal">Nominal</label>
                    <input type="number" name="nominal" class="form-control <?= session('errors.nominal') ? 'is-invalid' : '' ?>" value="<?= old('nominal') ?>">
                    <div class="invalid-feedback"><?= session('errors.nominal') ?></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEdit" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Diskon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="editId">
                <div class="mb-3">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="editTanggal" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="nominal">Nominal</label>
                    <input type="number" name="nominal" id="editNominal" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Script isi data ke modal edit -->
<script>
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const tanggal = this.dataset.tanggal;
            const nominal = this.dataset.nominal;

            document.getElementById('editId').value = id;
            document.getElementById('editTanggal').value = tanggal;
            document.getElementById('editNominal').value = nominal;

            document.getElementById('formEdit').action = `/diskon/update/${id}`;
        });
    });
</script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        <?php if (session('modal') === 'tambah') : ?>
            new bootstrap.Modal(document.getElementById('modalTambah')).show();
        <?php elseif (session('modal') === 'edit') : ?>
            const modal = new bootstrap.Modal(document.getElementById('modalEdit'));
            document.getElementById('editId').value = "<?= session('edit_data.id') ?>";
            document.getElementById('editTanggal').value = "<?= session('edit_data.tanggal') ?>";
            document.getElementById('editNominal').value = "<?= session('edit_data.nominal') ?>";
            modal.show();
        <?php endif; ?>
    });
</script>

<?= $this->endSection(); ?>