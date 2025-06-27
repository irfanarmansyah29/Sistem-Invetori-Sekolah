<?php
include 'koneksi.php';
?>
<h2>Laporan Barang Rusak</h2>
<div class="box">
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Kondisi</th>
            <th>Jumlah</th>
        </tr>
        <?php
        $sql = "SELECT barang.nama_barang, kategori.nama_kategori, lokasi.nama_lokasi, barang.kondisi, barang.jumlah 
          FROM barang 
          JOIN kategori ON barang.id_kategori = kategori.id_kategori
          JOIN lokasi ON barang.id_lokasi = lokasi.id_lokasi
          WHERE barang.kondisi IN ('Rusak Ringan', 'Rusak Berat')";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['nama_barang'] . "</td>";
            echo "<td>" . $row['nama_kategori'] . "</td>";
            echo "<td>" . $row['nama_lokasi'] . "</td>";
            echo "<td>" . $row['kondisi'] . "</td>";
            echo "<td>" . $row['jumlah'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<style>
    .table-container {
    overflow-x: auto;
    overflow-y: auto;
    max-height: 565px;
    max-width: 100%;
  }
</style>