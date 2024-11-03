<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';
include_once '../../class/barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);
$barang->idBarang = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID tidak ditemukan.');
$stmt = $barang->readOne();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h2>Edit Barang</h2>
        </div>
    </div>

    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Gagal mengupdate data barang
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } ?>

    <div class="card">
        <div class="card-body">
            <form action="../../controller/barang/update.php" method="POST">
                <input type="hidden" name="idBarang" value="<?php echo $row['idBarang']; ?>">
                
                <div class="mb-3">
                    <label for="namaBarang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="namaBarang" name="namaBarang" 
                           value="<?php echo $row['namaBarang']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?php echo $row['keterangan']; ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" class="form-control" id="satuan" name="satuan" 
                           value="<?php echo $row['satuan']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="hargaBeli" class="form-label">Harga Beli</label>
                    <input type="number" class="form-control" id="hargaBeli" name="hargaBeli" 
                           value="<?php echo $row['hargaBeli']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="hargaJual" class="form-label">Harga Jual</label>
                    <input type="number" class="form-control" id="hargaJual" name="hargaJual" 
                           value="<?php echo $row['hargaJual']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" 
                           value="<?php echo $row['stok']; ?>" required>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="index.php" class="btn btn-secondary me-md-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once '../../includes/footer.php'; ?>