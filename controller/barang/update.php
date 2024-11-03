<?php
include_once '../../config/database.php';
include_once '../../class/barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barang->idBarang = $_POST['idBarang'];
    $barang->namaBarang = $_POST['namaBarang'];
    $barang->keterangan = $_POST['keterangan'];
    $barang->satuan = $_POST['satuan'];
    $barang->hargaBeli = $_POST['hargaBeli'];
    $barang->hargaJual = $_POST['hargaJual'];
    $barang->stok = $_POST['stok'];

    if ($barang->update()) {
        header("Location: ../../views/barang/index.php?success=updated");
    } else {
        header("Location: ../../views/barang/edit.php?id=" . $barang->idBarang . "&error=1");
    }
}