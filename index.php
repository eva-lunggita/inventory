<?php
include_once 'includes/header.php';
include_once 'config/database.php';
include_once 'class/barang.php';
include_once 'class/laporankeuangan.php';

$database = new Database();
$db = $database->getConnection();

$laporan = new LaporanKeuangan($db);
$rekap = $laporan->getRekapKeuangan();

$barang = new Barang($db);
$total_items = $barang->read()->rowCount();
?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1>Dashboard</h1>
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

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Menu Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="views/barang/create.php" class="btn btn-primary">Tambah Barang</a>
                        <a href="views/laporan/optimasi.php" class="btn btn-success">Optimasi Paket</a>
                        <a href="views/laporan/keuangan.php" class="btn btn-info text-white">Laporan Keuangan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <p>Total Jenis Barang: <strong><?php echo $total_items; ?></strong></p>
                    <?php
                    if ($rekap['actual_revenue'] > 0) {
                        $margin_ratio = ($rekap['actual_profit'] / $rekap['actual_revenue']) * 100;
                        echo "<p>Margin Ratio: <strong>" . number_format($margin_ratio, 2) . "%</strong></p>";
                    }
                    
                    if ($rekap['total_modal'] > 0) {
                        $roi = ($rekap['actual_profit'] / $rekap['total_modal']) * 100;
                        echo "<p>Return on Investment: <strong>" . number_format($roi, 2) . "%</strong></p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>