<?php
class Pengguna {
    private $conn;
    private $table_name = "pengguna";
    
    public $idPengguna;
    public $namaPengguna;
    public $password;
    public $namaDepan;
    public $namaBelakang;
    public $noHp;
    public $alamat;
    public $idAkses;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function login($username, $password) {
        try {
            $query = "SELECT * FROM " . $this->table_name . " 
                    WHERE namaPengguna = :username";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Jika password di database masih plain text
                if ($password === $row['password']) {
                    $this->idPengguna = $row['idPengguna'];
                    $this->namaPengguna = $row['namaPengguna'];
                    $this->idAkses = $row['idAkses'];
                    return true;
                }
                // Jika password sudah di-hash
                else if (password_verify($password, $row['password'])) {
                    $this->idPengguna = $row['idPengguna'];
                    $this->namaPengguna = $row['namaPengguna'];
                    $this->idAkses = $row['idAkses'];
                    return true;
                }
            }
            return false;
        } catch(PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }
    
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET namaPengguna=:namaPengguna,
                    password=:password,
                    namaDepan=:namaDepan,
                    namaBelakang=:namaBelakang,
                    noHp=:noHp,
                    alamat=:alamat,
                    idAkses=:idAkses";
        
        try {
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->namaPengguna = htmlspecialchars(strip_tags($this->namaPengguna));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->namaDepan = htmlspecialchars(strip_tags($this->namaDepan));
            $this->namaBelakang = htmlspecialchars(strip_tags($this->namaBelakang));
            $this->noHp = htmlspecialchars(strip_tags($this->noHp));
            $this->alamat = htmlspecialchars(strip_tags($this->alamat));
            
            // Bind data
            $stmt->bindParam(":namaPengguna", $this->namaPengguna);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":namaDepan", $this->namaDepan);
            $stmt->bindParam(":namaBelakang", $this->namaBelakang);
            $stmt->bindParam(":noHp", $this->noHp);
            $stmt->bindParam(":alamat", $this->alamat);
            $stmt->bindParam(":idAkses", $this->idAkses);
            
            if($stmt->execute()) {
                return true;
            }
            return false;
        } catch(PDOException $e) {
            error_log("Create user error: " . $e->getMessage());
            return false;
        }
    }
}