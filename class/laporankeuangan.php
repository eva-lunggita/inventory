<?php
class LaporanKeuangan {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getLaporanRugiLabaDetail() {
        $query = "SELECT 
                    b.namaBarang,
                    b.hargaBeli,
                    b.hargaJual,
                    b.stok,
                    (b.hargaJual - b.hargaBeli) as margin_per_unit,
                    (b.hargaJual - b.hargaBeli) * b.stok as potential_profit,
                    COALESCE(SUM(p.jumlahPenjualan), 0) as total_terjual,
                    COALESCE(SUM(p.jumlahPenjualan * (b.hargaJual - b.hargaBeli)), 0) as realized_profit
                FROM barang b
                LEFT JOIN penjualan p ON b.idBarang = p.idBarang
                GROUP BY b.idBarang
                ORDER BY realized_profit DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getRekapKeuangan() {
        $query = "SELECT 
                    SUM(b.hargaBeli * b.stok) as total_modal,
                    SUM(b.hargaJual * b.stok) as potential_revenue,
                    SUM((b.hargaJual - b.hargaBeli) * b.stok) as potential_profit,
                    COALESCE(SUM(p.jumlahPenjualan * b.hargaJual), 0) as actual_revenue,
                    COALESCE(SUM(p.jumlahPenjualan * (b.hargaJual - b.hargaBeli)), 0) as actual_profit
                FROM barang b
                LEFT JOIN penjualan p ON b.idBarang = p.idBarang";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}