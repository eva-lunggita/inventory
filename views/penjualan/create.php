<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';
include_once '../../class/barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);
?>

<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h2>Tambah Penjualan</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="../../controller/penjualan/create.php" method="POST">
                <div class="mb-3">
                    <label for="idBarang" class="form-label">Pilih Barang</label>
                    <select class="form-select" id="idBarang" name="idBarang" required>
                        <option value="">Pilih Barang</option>
                        <?php
                        $stmt = $barang->read();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['idBarang']}' data-harga='{$row['hargaJual']}' data-stok='{$row['stok']}'>";
                            echo $row['namaBarang'] . " (Stok: " . $row['stok'] . ")";
                            echo "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlahPenjualan" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" id="jumlahPenjualan" name="jumlahPenjualan" required>
                </div>

                <div class="mb-3">
                    <label for="hargaJual" class="form-label">Harga Jual</label>
                    <input type="number" class="form-control" id="hargaJual" name="hargaJual" readonly>
                </div>

                <input type="hidden" name="idPengguna" value="1">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="index.php" class="btn btn-secondary me-md-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('idBarang').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const hargaJual = selected.getAttribute('data-harga');
    document.getElementById('hargaJual').value = hargaJual;
});
</script>

<?php include_once '../../includes/footer.php'; ?>