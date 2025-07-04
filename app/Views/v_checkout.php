<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <?= form_open('buy', 'class="row g-3"') ?>
        <?= form_hidden('username', session()->get('username')) ?>
        <?= form_input(['type' => 'hidden', 'name' => 'total_harga', 'id' => 'total_harga', 'value' => '']) ?>

        <div class="col-12">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" value="<?= session()->get('username'); ?>" readonly>
        </div>
        <div class="col-12">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div>
        <div class="col-12">
            <label for="kelurahan" class="form-label">Kelurahan</label>
            <select class="form-control" name="kelurahan" id="kelurahan" required></select>
        </div>
        <div class="col-12">
            <label for="layanan" class="form-label">Layanan</label>
            <select class="form-control" name="layanan" id="layanan" required></select>
        </div>
        <div class="col-12">
            <label for="ongkir" class="form-label">Ongkir</label>
            <input type="text" class="form-control" id="ongkir" name="ongkir" readonly>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="col-12">
            <table class="table table-hover table-bordered align-middle shadow-sm">
                <thead class="table-light text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    $total_diskon = 0;
                    $total_asli = 0;
                    if (!empty($items)) :
                        foreach ($items as $item) :
                            $harga_asli = $item['price'] + (session('diskon_nominal') ?? 0);
                            $harga_diskon = $item['price'];
                            $qty = $item['qty'];
                            $diskon_item = (session('diskon_nominal') ?? 0) * $qty;
                            $total_diskon += $diskon_item;
                            $total_asli += $harga_asli * $qty;
                    ?>
                            <tr>
                                <td><?= $item['name'] ?></td>
                                <td>
                                    <?php if (session()->has('diskon_nominal')) : ?>
                                        <span class="text-muted">
                                            <?= number_to_currency($harga_asli, 'IDR') ?>
                                        </span><br>
                                    <?php else : ?>
                                        <span class="fw-normal">
                                            <?= number_to_currency($harga_diskon, 'IDR') ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= $qty ?></td>
                            </tr>
                    <?php endforeach;
                    endif; ?>

                    <?php if (session()->has('diskon_nominal')) : ?>
                        <tr class="text-danger">
                            <td colspan="2" class="text-end">Potongan Diskon</td>
                            <td class="text-end">-<?= number_to_currency($total_diskon, 'IDR') ?></td>
                        </tr>
                        <tr class="fw-semibold text-muted">
                            <td colspan="2" class="text-end">Jumlah Diskon</td>
                            <td class="text-end"><?= number_to_currency($harga_diskon, 'IDR') ?></td>
                        </tr>

                    <?php endif; ?>

                    <tr>
                        <td colspan="2" class="text-end">Ongkir</td>
                        <td class="text-end" id="ongkir_view">Rp0</td>
                    </tr>
                    <tr class="bg-light fw-bold">
                        <td colspan="2" class="text-end text-primary">Total Bayar</td>
                        <td class="text-end text-primary">
                            <span id="total"><?= number_to_currency($total, 'IDR') ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                <i class="bi bi-cart-check me-2"></i> Buat Pesanan
            </button>
        </div>
    </div>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        var ongkir = 0;
        var total = <?= $total ?>;

        hitungTotal();

        $('#kelurahan').select2({
            placeholder: 'Ketik nama kelurahan...',
            ajax: {
                url: '<?= base_url('get-location') ?>',
                dataType: 'json',
                delay: 1500,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.subdistrict_name + ", " + item.district_name + ", " + item.city_name + ", " + item.province_name + ", " + item.zip_code
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 3
        });

        $("#kelurahan").on('change', function() {
            var id_kelurahan = $(this).val();
            $("#layanan").empty();
            ongkir = 0;

            $.ajax({
                url: "<?= site_url('get-cost') ?>",
                type: 'GET',
                data: {
                    'destination': id_kelurahan
                },
                dataType: 'json',
                success: function(data) {
                    data.forEach(function(item) {
                        var text = item["description"] + " (" + item["service"] + ") : estimasi " + item["etd"];
                        $("#layanan").append($('<option>', {
                            value: item["cost"],
                            text: text
                        }));
                    });
                    hitungTotal();
                },
            });
        });

        $("#layanan").on('change', function() {
            ongkir = parseInt($(this).val());
            hitungTotal();
        });

        function hitungTotal() {
            let grand_total = total + ongkir;
            $("#ongkir").val(ongkir);
            $("#ongkir_view").text("IDR " + ongkir.toLocaleString());
            $("#total").text("IDR " + grand_total.toLocaleString());
            $("#total_harga").val(grand_total);
        }
    });
</script>
<?= $this->endSection() ?>