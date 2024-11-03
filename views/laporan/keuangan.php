<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';
include_once '../../class/laporankeuangan.php';

$database = new Database();
$db = $database->getConnection();
$laporan = new LaporanKeuangan($db);
$rekap = $laporan->getRekapKeuangan();
?>

<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h2>Laporan Keuangan</h2>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white dashboard-card">
                <div class="card-body">
                    <h6 class="card-title">Total Modal</h6>
                    <h4>Rp <?php echo number_format($rekap['total_modal'], 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white dashboard-card">
                <div class="card-body">
                    <h6 class="card-title">Revenue Aktual</h6>
                    <h4>Rp <?php echo number_format($rekap['actual_revenue'], 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white dashboard-card">
                <div class="card-body">
                    <h6 class="card-title">Profit Aktual</h6>
                    <h4>Rp <?php echo number_format($rekap['actual_profit'], 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white dashboard-card">
                <div class="card-body">
                    <h6 class="card-title">Potential Profit</h6>
                    <h4>Rp <?php echo number_format($rekap['potential_profit'], 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Detail Laporan Rugi Laba per Produk</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Margin/Unit</th>
                            <th>Total Terjual</th>
                            <th>Profit Terealisasi</th>
                            <th>Potential Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $detail = $laporan->getLaporanRugiLabaDetail();
                        $total_realized = 0;
                        $total_potential = 0;

                        while ($row = $detail->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            $total_realized += $realized_profit;
                            $total_potential += $potential_profit;

                            echo "<tr>";
                            echo "<td>{$namaBarang}</td>";
                            echo "<td>Rp " . number_format($hargaBeli, 0, ',', '.') . "</td>";
                            echo "<td>Rp " . number_format($hargaJual, 0, ',', '.') . "</td>";
                            echo "<td>{$stok}</td>";
                            echo "<td>Rp " . number_format($margin_per_unit, 0, ',', '.') . "</td>";
                            echo "<td>{$total_terjual}</td>";
                            echo "<td>Rp " . number_format($realized_profit, 0, ',', '.') . "</td>";
                            echo "<td>Rp " . number_format($potential_profit, 0, ',', '.') . "</td>";
                            echo "</tr>";
                        }
                        ?>
                        <tr class="table-info">
                            <td colspan="6"><strong>Total</strong></td>
                            <td><strong>Rp <?php echo number_format($total_realized, 0, ',', '.'); ?></strong></td>
                            <td><strong>Rp <?php echo number_format($total_potential, 0, ',', '.'); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../includes/footer.php'; ?>