<?php
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta'); 

$tglMulai = $_GET['mulai'] ?? '';
$tglSelesai = $_GET['selesai'] ?? '';

$where = "";
if ($tglMulai && $tglSelesai) {
    $where = "WHERE p.tgl_pinjam BETWEEN '$tglMulai' AND '$tglSelesai'";
}

// Ambil data peminjaman
$data = mysqli_query($conn, "SELECT p.*, b.nama_barang FROM peminjaman p 
    LEFT JOIN barang b ON p.id_barang = b.id_barang $where ORDER BY p.tgl_pinjam DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Cetak Laporan Peminjaman</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
    }
    h2 {
      text-align: center;
      margin-bottom: 10px;
    }
    .range {
      text-align: center;
      margin-bottom: 20px;
      font-size: 14px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }
    th, td {
      border: 1px solid #444;
      padding: 8px;
      text-align: left;
    }
    th {
      background: #f0f0f0;
    }
    .footer {
      margin-top: 40px;
      text-align: right;
      font-size: 13px;
    }
  </style>
</head>
<body>

<h2>LAPORAN PEMINJAMAN BARANG</h2>
<div class="range">
  Periode: <?= $tglMulai ?> s/d <?= $tglSelesai ?>
</div>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Peminjam</th>
      <th>Barang</th>
      <th>Tanggal Pinjam</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; while ($d = mysqli_fetch_assoc($data)) : ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= $d['nama_peminjam'] ?></td>
      <td><?= $d['nama_barang'] ?></td>
      <td><?= $d['tgl_pinjam'] ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<div class="footer">
  Dicetak pada: <?= date('d-m-Y H:i:s') ?> WIB
</div>

<script>
  window.print();
</script>

</body>
</html>
