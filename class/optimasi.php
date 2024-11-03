<?php
class Optimasi {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function hitungOptimasiPaket($budget, $minItems) {
        $query = "SELECT b.idBarang, b.namaBarang, b.hargaJual, b.stok, 
                        (b.hargaJual - b.hargaBeli) as margin
                 FROM barang b 
                 WHERE b.stok > 0 
                 ORDER BY margin DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $selectedItems = [];
        $totalCost = 0;
        $totalItems = 0;
        
        foreach ($items as $item) {
            if ($totalCost + $item['hargaJual'] <= $budget && $totalItems < $minItems) {
                $maxQty = min(
                    floor(($budget - $totalCost) / $item['hargaJual']),
                    $item['stok']
                );
                
                if ($maxQty > 0) {
                    $selectedItems[] = [
                        'idBarang' => $item['idBarang'],
                        'namaBarang' => $item['namaBarang'],
                        'hargaJual' => $item['hargaJual'],
                        'quantity' => $maxQty,
                        'margin' => $item['margin']
                    ];
                    
                    $totalCost += ($item['hargaJual'] * $maxQty);
                    $totalItems += $maxQty;
                }
            }
        }
        
        return [
            'items' => $selectedItems,
            'totalCost' => $totalCost,
            'totalItems' => $totalItems,
            'remainingBudget' => $budget - $totalCost
        ];
    }
}