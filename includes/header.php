<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/inventory/includes/auth.php';
checkLogin();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/inventory/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/inventory/index.php">Inventory System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/inventory/views/barang/index.php">Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/inventory/views/penjualan/index.php">Penjualan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/inventory/views/laporan/optimasi.php">Optimasi Paket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/inventory/views/laporan/keuangan.php">Laporan Keuangan</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'User'; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="/inventory/logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>