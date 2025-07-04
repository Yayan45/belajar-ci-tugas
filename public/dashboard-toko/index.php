<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard Toko</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .container-custom {
            max-width: 1200px;
            margin: auto;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .table thead {
            background-color: #f0f4f8;
        }

        .table th {
            font-weight: 600;
            color: #0d6efd;
        }

        .badge-status {
            font-size: 0.9rem;
        }

        .badge-status.selesai {
            background-color: #198754;
        }

        .badge-status.belum {
            background-color: #ffc107;
        }

        #jam,
        #menit,
        #detik {
            font-weight: bold;
            color: #0dcaf0;
        }
    </style>
</head>

<body>
    <?php
    function curl()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost:8080/api",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "content-type: application/x-www-form-urlencoded",
                "key: random123678abcghi",
            ],
        ]);

        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output);
    }
    ?>

    <div class="container mt-4 container-custom">
        <div class="text-center mb-4">
            <h1 class="display-5 text-primary fw-semibold">Dashboard Transaksi Toko</h1>
            <p class="text-muted"><?= date("l, d M Y") ?> <span id="jam"></span>:<span id="menit"></span>:<span id="detik"></span></p>
        </div>

        <div class="card p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-start">Username</th>
                            <th class="text-start">Alamat</th>
                            <th class="text-start">Total Harga</th>
                            <th class="text-start">Ongkir</th>
                            <th class="text-start">Jumlah Item</th>
                            <th class="text-center">Status</th>
                            <th class="text-start">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = curl();
                        if (!empty($data->results)) {
                            $i = 1;
                            foreach ($data->results as $trans) {
                                // Hitung jumlah item
                                $jumlahItem = 0;
                                foreach ($trans->details as $detail) {
                                    $jumlahItem += $detail->jumlah;
                                }

                                $statusBadge = $trans->status == 1
                                    ? '<span class="badge badge-status selesai"><i class="bi bi-check-circle me-1"></i>Selesai</span>'
                                    : '<span class="badge badge-status belum selesai"><i class="bi bi-hourglass-split me-1"></i>Belum selesai</span>';
                        ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td class="text-start"><?= $trans->username ?></td>
                                    <td class="text-start"><?= $trans->alamat ?: '-' ?></td>
                                    <td class="text-start">Rp <?= number_format($trans->total_harga, 0, ',', '.') ?></td>
                                    <td class="text-start">Rp <?= number_format($trans->ongkir, 0, ',', '.') ?></td>
                                    <td class="text-start"><i class="bi bi-bag-check-fill text-success me-1"></i><?= $jumlahItem ?> pcs</td>
                                    <td class="text-center"><?= $statusBadge ?></td>
                                    <td class="text-start"><?= $trans->created_at ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="8" class="text-muted text-center">Belum ada transaksi tersedia.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Live Clock -->
    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById("jam").textContent = String(now.getHours()).padStart(2, '0');
            document.getElementById("menit").textContent = String(now.getMinutes()).padStart(2, '0');
            document.getElementById("detik").textContent = String(now.getSeconds()).padStart(2, '0');
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>