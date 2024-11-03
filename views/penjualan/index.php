<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';
include_once '../../class/penjualan.php';

$database = new Database();
$db = $database->getConnection();
$penjualan = new Penjualan($db);
?>

<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h2>Daftar Penjualan</h2>
        </div>
        <div class="col text-end">
            <a href="create.php" class="btn btn-primary">Tambah Penjualan</a>
        </div>
    </div>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil <?php echo $_GET['success'] == 'created' ? 'ditambahkan' : 'dihapus'; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Jual</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $penjualan->read();
                        $no = 1;
                        
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            $total = $jumlahPenjualan * $hargaJual;
                            
                            echo "<tr>";
                            echo "<td>{$no}</td>";
                            echo "<td>" . date('d/m/Y H:i', strtotime($tanggalPenjualan)) . "</td>";
                            echo "<td>{$namaBarang}</td>";
                            echo "<td>{$jumlahPenjualan}</td>";
                            echo "<td>Rp " . number_format($hargaJual, 0, ',', '.') . "</td>";
                            echo "<td>Rp " . number_format($total, 0, ',', '.') . "</td>";
                            echo "<td>";
                            echo "<a href='../../controller/penjualan/delete.php?id={$idPenjualan}' 
                                    class='btn btn-sm btn-danger'
                                    onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                            $no++;
                        }

                        if ($no == 1) {
                            echo "<tr><td colspan='7' class='text-center'>Belum ada data penjualan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../includes/footer.php'; ?>