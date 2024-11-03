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

// Hitung margin ratio dan ROI
$margin_ratio = 0;
$roi = 0;

if ($rekap['actual_revenue'] > 0) {
    $margin_ratio = ($rekap['actual_profit'] / $rekap['actual_revenue']) * 100;
}

if ($rekap['total_modal'] > 0) {
    $roi = ($rekap['actual_profit'] / $rekap['total_modal']) * 100;
}
?>

<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h2>Dashboard</h2>
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
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistik Detail</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center border-end">
                                <h6 class="text-muted mb-2">Total Jenis Barang</h6>
                                <h2 class="mb-0"><?php echo $total_items; ?></h2>
                                <small class="text-muted">Items in Inventory</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center border-end">
                                <h6 class="text-muted mb-2">Margin Ratio</h6>
                                <h2 class="mb-0"><?php echo number_format($margin_ratio, 2); ?>%</h2>
                                <small class="text-muted">Profit/Revenue Ratio</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="text-muted mb-2">Return on Investment</h6>
                                <h2 class="mb-0"><?php echo number_format($roi, 2); ?>%</h2>
                                <small class="text-muted">Profit/Modal Ratio</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>