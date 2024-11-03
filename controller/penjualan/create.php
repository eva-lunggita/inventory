<?php
include_once '../../config/database.php';
include_once '../../class/barang.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "INSERT INTO penjualan (idBarang, jumlahPenjualan, hargaJual, idPengguna) 
              VALUES (:idBarang, :jumlahPenjualan, :hargaJual, :idPengguna)";
    
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':idBarang', $_POST['idBarang']);
    $stmt->bindParam(':jumlahPenjualan', $_POST['jumlahPenjualan']);
    $stmt->bindParam(':hargaJual', $_POST['hargaJual']);
    $stmt->bindParam(':idPengguna', $_POST['idPengguna']);
    
    if ($stmt->execute()) {
        // Update stok barang
        $barang = new Barang($db);
        $barang->idBarang = $_POST['idBarang'];
        $barang->updateStok($_POST['jumlahPenjualan'], 'kurang');
        
        header("Location: ../../views/penjualan/index.php?success=created");
    } else {
        header("Location: ../../views/penjualan/create.php?error=1");
    }
}