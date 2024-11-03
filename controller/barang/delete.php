<?php
include_once '../../config/database.php';
include_once '../../class/barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

if (isset($_GET['id'])) {
    $barang->idBarang = $_GET['id'];
    
    if ($barang->delete()) {
        header("Location: ../../views/barang/index.php?success=deleted");
    } else {
        header("Location: ../../views/barang/index.php?error=1");
    }
} else {
    header("Location: ../../views/barang/index.php?error=1");
}