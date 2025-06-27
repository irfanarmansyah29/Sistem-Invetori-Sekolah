<?php
include 'koneksi.php';
?>
<h2>Rekap Stok Per Kategori</h2>
<table border="1" cellpadding="10" cellspacing="0">
  <tr>
    <th>Kategori</th>
    <th>Total Jumlah</th>
  </tr>
  <?php
  $sql = "SELECT kategori.nama_kategori, SUM(barang.jumlah) AS total_jumlah 
          FROM barang 
          JOIN kategori ON barang.id_kategori = kategori.id_kategori 
          GROUP BY kategori.id_kategori";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row['nama_kategori'] . "</td>";
      echo "<td>" . $row['total_jumlah'] . "</td>";
      echo "</tr>";
  }
  ?>
</table>