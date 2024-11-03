<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';
include_once '../../class/paketpenjualan.php';
?>

<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h2>Optimasi Paket Penjualan</h2>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="budget" class="form-label">Budget Maximum (Rp)</label>
                            <input type="number" class="form-control" id="budget" name="budget" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="minItems" class="form-label">Minimum Items</label>
                            <input type="number" class="form-control" id="minItems" name="minItems" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary d-block w-100">Hitung Optimasi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Database();
        $db = $database->getConnection();
        $paket = new PaketPenjualan($db);

        $hasil = $paket->hitungOptimasiPaket($_POST['budget'], $_POST['minItems']);
    ?>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Hasil Optimasi Paket</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h5>Total Biaya</h5>
                        <h4>Rp <?php echo number_format($hasil['totalCost'], 0, ',', '.'); ?></h4>
                    </div>
                    <div class="col-md-4">
                        <h5>Total Items</h5>
                        <h4><?php echo $hasil['totalItems']; ?> pcs</h4>
                    </div>
                    <div class="col-md-4">
                        <h5>Sisa Budget</h5>
                        <h4>Rp <?php echo number_format($hasil['remainingBudget'], 0, ',', '.'); ?></h4>
                    </div>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th>Quantity</th>
                            <th>Margin/Unit</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hasil['items'] as $item): ?>
                        <tr>
                            <td><?php echo $item['namaBarang']; ?></td>
                            <td>Rp <?php echo number_format($item['hargaJual'], 0, ',', '.'); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>Rp <?php echo number_format($item['margin'], 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($item['hargaJual'] * $item['quantity'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</div>

<?php include_once '../../includes/footer.php'; ?>