<?php
class Barang {
    private $conn;
    private $table_name = "barang";

    public $idBarang;
    public $namaBarang;
    public $keterangan;
    public $satuan;
    public $hargaBeli;
    public $hargaJual;
    public $stok;
    public $idPengguna;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET namaBarang=:namaBarang, keterangan=:keterangan, 
                    satuan=:satuan, hargaBeli=:hargaBeli, 
                    hargaJual=:hargaJual, stok=:stok, 
                    idPengguna=:idPengguna";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":namaBarang", $this->namaBarang);
        $stmt->bindParam(":keterangan", $this->keterangan);
        $stmt->bindParam(":satuan", $this->satuan);
        $stmt->bindParam(":hargaBeli", $this->hargaBeli);
        $stmt->bindParam(":hargaJual", $this->hargaJual);
        $stmt->bindParam(":stok", $this->stok);
        $stmt->bindParam(":idPengguna", $this->idPengguna);
        
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idBarang = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idBarang);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET namaBarang=:namaBarang, keterangan=:keterangan,
                    satuan=:satuan, hargaBeli=:hargaBeli,
                    hargaJual=:hargaJual, stok=:stok
                WHERE idBarang=:idBarang";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":namaBarang", $this->namaBarang);
        $stmt->bindParam(":keterangan", $this->keterangan);
        $stmt->bindParam(":satuan", $this->satuan);
        $stmt->bindParam(":hargaBeli", $this->hargaBeli);
        $stmt->bindParam(":hargaJual", $this->hargaJual);
        $stmt->bindParam(":stok", $this->stok);
        $stmt->bindParam(":idBarang", $this->idBarang);
        
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idBarang = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idBarang);
        return $stmt->execute();
    }

    public function updateStok($jumlah, $tipe = 'tambah') {
        $query = "UPDATE " . $this->table_name . " 
                SET stok = stok " . ($tipe == 'tambah' ? '+' : '-') . " :jumlah 
                WHERE idBarang = :idBarang";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":jumlah", $jumlah);
        $stmt->bindParam(":idBarang", $this->idBarang);
        
        return $stmt->execute();
    }
}