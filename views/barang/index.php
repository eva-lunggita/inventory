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
            <h2>Daftar Barang</h2>
        </div>
        <div class="col text-end">
            <a href="create.php" class="btn btn-primary">Tambah Barang</a>
        </div>
    </div>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil <?php 
                if ($_GET['success'] == 'created') {
                    echo 'ditambahkan';
                } elseif ($_GET['success'] == 'updated') {
                    echo 'diupdate';
                } else {
                    echo 'dihapus';
                }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } ?>

    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Terjadi kesalahan dalam memproses data
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Barang</th>
                            <th>Keterangan</th>
                            <th>Satuan</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $barang->read();
                        $no = 1; // Inisialisasi nomor urut
                        
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<tr>";
                            echo "<td class='text-center'>{$no}</td>"; // Tampilkan nomor urut
                            echo "<td>{$namaBarang}</td>";
                            echo "<td>{$keterangan}</td>";
                            echo "<td>{$satuan}</td>";
                            echo "<td>Rp " . number_format($hargaBeli, 0, ',', '.') . "</td>";
                            echo "<td>Rp " . number_format($hargaJual, 0, ',', '.') . "</td>";
                            echo "<td class='text-center'>{$stok}</td>";
                            echo "<td class='text-center'>";
                            echo "<a href='edit.php?id={$idBarang}' class='btn btn-sm btn-primary me-1'>Edit</a>";
                            echo "<a href='../../controller/barang/delete.php?id={$idBarang}' class='btn btn-sm btn-danger' 
                                    onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                            $no++; // Increment nomor urut
                        }

                        if ($no == 1) { // Jika tidak ada data
                            echo "<tr><td colspan='8' class='text-center'>Tidak ada data barang</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../includes/footer.php'; ?>