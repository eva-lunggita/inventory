<?php
class Penjualan {
    private $conn;
    private $table_name = "penjualan";

    public $idPenjualan;
    public $jumlahPenjualan;
    public $hargaJual;
    public $idPengguna;
    public $idBarang;
    public $tanggalPenjualan;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET jumlahPenjualan=:jumlahPenjualan, 
                    hargaJual=:hargaJual, 
                    idPengguna=:idPengguna, 
                    idBarang=:idBarang";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":jumlahPenjualan", $this->jumlahPenjualan);
        $stmt->bindParam(":hargaJual", $this->hargaJual);
        $stmt->bindParam(":idPengguna", $this->idPengguna);
        $stmt->bindParam(":idBarang", $this->idBarang);
        
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT p.*, b.namaBarang 
                FROM " . $this->table_name . " p
                LEFT JOIN barang b ON p.idBarang = b.idBarang
                ORDER BY p.tanggalPenjualan DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT p.*, b.namaBarang, b.hargaJual as hargaBarang 
                FROM " . $this->table_name . " p
                LEFT JOIN barang b ON p.idBarang = b.idBarang
                WHERE p.idPenjualan = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idPenjualan);
        $stmt->execute();
        return $stmt;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idPenjualan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idPenjualan);
        return $stmt->execute();
    }
}