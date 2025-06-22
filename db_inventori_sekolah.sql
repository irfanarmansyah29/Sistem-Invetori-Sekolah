
CREATE DATABASE IF NOT EXISTS db_inventori_sekolah;
USE db_inventori_sekolah;

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(100)
);
INSERT INTO users (username, password) VALUES ('admin', MD5('admin'));

CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100)
);

CREATE TABLE lokasi (
    id_lokasi INT AUTO_INCREMENT PRIMARY KEY,
    nama_lokasi VARCHAR(100)
);

CREATE TABLE barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100),
    id_kategori INT,
    id_lokasi INT,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori),
    FOREIGN KEY (id_lokasi) REFERENCES lokasi(id_lokasi)
);

CREATE TABLE peminjaman (
    id_peminjaman INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT,
    peminjam VARCHAR(100),
    tgl_pinjam DATE,
    FOREIGN KEY (id_barang) REFERENCES barang(id_barang)
);
