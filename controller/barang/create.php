<?php
include_once '../../config/database.php';
include_once '../../class/barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barang->namaBarang = $_POST['namaBarang'];
    $barang->keterangan = $_POST['keterangan'];
    $barang->satuan = $_POST['satuan'];
    $barang->hargaBeli = $_POST['hargaBeli'];
    $barang->hargaJual = $_POST['hargaJual'];
    $barang->stok = $_POST['stok'];
    $barang->idPengguna = 1; // Default admin user

    if ($barang->create()) {
        header("Location: ../../views/barang/index.php?success=created");
    } else {
        header("Location: ../../views/barang/create.php?error=1");
    }
}