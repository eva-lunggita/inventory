CREATE DATABASE inventory_db;
USE inventory_db;

CREATE TABLE hakakses (
    idAkses INT PRIMARY KEY AUTO_INCREMENT,
    namaAkses VARCHAR(50),
    keterangan TEXT
);

CREATE TABLE pengguna (
    idPengguna INT PRIMARY KEY AUTO_INCREMENT,
    namaPengguna VARCHAR(100),
    password VARCHAR(255),
    namaDepan VARCHAR(100),
    namaBelakang VARCHAR(100),
    noHp VARCHAR(15),
    alamat TEXT,
    idAkses INT,
    FOREIGN KEY (idAkses) REFERENCES hakakses(idAkses)
);

CREATE TABLE barang (
    idBarang INT PRIMARY KEY AUTO_INCREMENT,
    namaBarang VARCHAR(100),
    keterangan TEXT,
    satuan VARCHAR(20),
    hargaBeli DECIMAL(10,2),
    hargaJual DECIMAL(10,2),
    stok INT,
    idPengguna INT,
    FOREIGN KEY (idPengguna) REFERENCES pengguna(idPengguna)
);

CREATE TABLE pembelian (
    idPembelian INT PRIMARY KEY AUTO_INCREMENT,
    jumlahPembelian INT,
    hargaBeli DECIMAL(10,2),
    idPengguna INT,
    FOREIGN KEY (idPengguna) REFERENCES pengguna(idPengguna)
);

CREATE TABLE penjualan (
    idPenjualan INT PRIMARY KEY AUTO_INCREMENT,
    jumlahPenjualan INT,
    hargaJual DECIMAL(10,2),
    idPengguna INT,
    idBarang INT,
    tanggalPenjualan DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idPengguna) REFERENCES pengguna(idPengguna),
    FOREIGN KEY (idBarang) REFERENCES barang(idBarang)
);

CREATE TABLE paket_penjualan (
    idPaket INT PRIMARY KEY AUTO_INCREMENT,
    namaPaket VARCHAR(100),
    deskripsi TEXT,
    hargaPaket DECIMAL(10,2),
    status ENUM('active','inactive') DEFAULT 'active'
);

-- Insert default admin user and access level
INSERT INTO hakakses (namaAkses, keterangan) 
VALUES ('admin', 'Administrator');

INSERT INTO pengguna (namaPengguna, password, namaDepan, namaBelakang, idAkses) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'System', 1);