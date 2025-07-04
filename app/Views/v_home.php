<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<!-- Table with stripped rows -->
<div class="row">
    <?php foreach ($product as $key => $item) : ?>
        <div class="col-lg-6">
            <?= form_open('keranjang') ?>
            <?php
            echo form_hidden('id', $item['id']);
            echo form_hidden('nama', $item['nama']);
            echo form_hidden('harga', $item['harga']);
            echo form_hidden('foto', $item['foto']);
            ?>
            <div class="card shadow-sm rounded-4">
                <div class="card-body text-center">
                    <img src="<?php echo base_url() . "img/" . $item['foto'] ?>" alt="..." class="img-fluid rounded mb-3" style="max-width: 250px;">
                    <h5 class="card-title fw-bold"><?php echo $item['nama'] ?></h5>
                    <p class="text-success fs-5"><?php echo number_to_currency($item['harga'], 'IDR') ?></p>
                    <a href="<?= base_url('diskon/tambah/' . $item['id']) ?>" class="btn btn-primary rounded-pill px-4 py-2">
                        <i class="bi bi-cart-plus me-2"></i>Beli
                    </a>
                </div>
            </div>

            <?= form_close() ?>
        </div>
    <?php endforeach ?>
</div>
<!-- End Table with stripped rows -->
<?= $this->endSection() ?>