<?php
include_once '../../config/database.php';
include_once '../../class/barang.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get old penjualan data for stock adjustment
    $query = "SELECT jumlahPenjualan, idBarang FROM penjualan WHERE idPenjualan = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_POST['idPenjualan']]);
    $oldData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Update penjualan
    $query = "UPDATE penjualan 
              SET jumlahPenjualan = :jumlahPenjualan, 
                  hargaJual = :hargaJual 
              WHERE idPenjualan = :idPenjualan";
    
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':jumlahPenjualan', $_POST['jumlahPenjualan']);
    $stmt->bindParam(':hargaJual', $_POST['hargaJual']);
    $stmt->bindParam(':idPenjualan', $_POST['idPenjualan']);
    
    if ($stmt->execute()) {
        // Adjust stock
        $barang = new Barang($db);
        $barang->idBarang = $oldData['idBarang'];
        
        // Return old stock
        $barang->updateStok($oldData['jumlahPenjualan'], 'tambah');
        // Deduct new amount
        $barang->updateStok($_POST['jumlahPenjualan'], 'kurang');
        
        header("Location: ../../views/penjualan/index.php?success=updated");
    } else {
        header("Location: ../../views/penjualan/edit.php?id=" . $_POST['idPenjualan'] . "&error=1");
    }
}