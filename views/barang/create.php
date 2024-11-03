<?php
include_once '../../includes/header.php';
?>

<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h2>Tambah Barang Baru</h2>
        </div>
    </div>

    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Gagal menambahkan data barang
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } ?>

    <div class="card">
        <div class="card-body">
            <form action="../../controller/barang/create.php" method="POST">
                <div class="mb-3">
                    <label for="namaBarang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="namaBarang" name="namaBarang" required>
                </div>
                
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" class="form-control" id="satuan" name="satuan" required>
                </div>
                
                <div class="mb-3">
                    <label for="hargaBeli" class="form-label">Harga Beli</label>
                    <input type="number" class="form-control" id="hargaBeli" name="hargaBeli" required>
                </div>
                
                <div class="mb-3">
                    <label for="hargaJual" class="form-label">Harga Jual</label>
                    <input type="number" class="form-control" id="hargaJual" name="hargaJual" required>
                </div>
                
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" required>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="index.php" class="btn btn-secondary me-md-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once '../../includes/footer.php'; ?>