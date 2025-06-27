<?php

include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');
//LOAD DATA
$id = $_GET['edit'] ?? '';
$hapus = $_GET['hapus'] ?? '';
$edit = isset($_GET['edit']);


$barang = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang");

//HAPUS DATA
if ($hapus) {
  mysqli_query($conn, "DELETE FROM peminjaman WHERE id_peminjaman = '$hapus'");
  echo "<script>location='index.php?page=peminjaman';</script>";
  exit;
}

//SIMPAN TAMBAH / EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama'];
  $id_barang = $_POST['barang'];
  $tgl_pinjam = $_POST['tgl_pinjam'];

  if ($edit) {
    mysqli_query($conn, "UPDATE peminjaman SET 
            nama_peminjam = '$nama', 
            id_barang = '$id_barang',
            tgl_pinjam = '$tgl_pinjam'
            WHERE id_peminjaman = '$id'");
  } else {
    mysqli_query($conn, "INSERT INTO peminjaman 
            (nama_peminjam, id_barang, tgl_pinjam, status)
            VALUES ('$nama', '$id_barang', '$tgl_pinjam', 'dipinjam')");
  }
  echo "<script>location='index.php?page=peminjaman';</script>";
  exit;
}

//AMBIL DATA SAAT EDIT
$row = ['nama_peminjam' => '', 'id_barang' => '', 'tgl_pinjam' => ''];
if ($edit) {
  $result = mysqli_query($conn, "SELECT * FROM peminjaman WHERE id_peminjaman = '$id'");
  $row = mysqli_fetch_assoc($result);
}
?>

<h1 class="header-title">Peminjaman Barang</h1>

<div class="flex-container">
  <!-- FORM TAMBAH / EDIT -->
  <div class="form-box">
    <h2>Tambah peminjaman</h2><br><br>
    <form method="post">
      <p><label>Nama Peminjam</label><br>
        <input type="text" name="nama" required class="input" value="<?= $row['nama_peminjam'] ?>">
      </p>
      <p><label>Barang</label><br>
        <select name="barang" required class="input">
          <option value="">-- Pilih Barang --</option>
          <?php foreach ($barang as $b): ?>
            <option value="<?= $b['id_barang'] ?>" <?= $b['id_barang'] == $row['id_barang'] ? 'selected' : '' ?>>
              <?= $b['nama_barang'] ?>
            </option>
          <?php endforeach ?>
        </select>
      </p>
      <p><label>Tanggal Pinjam</label><br>
        <input type="datetime-local" name="tgl_pinjam" class="input" value="<?= date('Y-m-d\TH:i') ?>" required>
      </p>
      <p>
        <button type="submit" class="btn"><?= $edit ? 'Update' : 'Simpan' ?></button>
        <?php if ($edit): ?>
          <a href="index.php?page=peminjaman" class="btn gray">Batal</a>
        <?php endif ?>
      </p>
    </form>
  </div>

  <!-- TABEL DATA -->
  <div class="table-box">
    <div class="table-container">
      <h2>Table peminjaman</h2><br><br>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Barang</th>
            <th>Tgl Pinjam</th>
            <th>Status</th>
            <th>Tgl kembali</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $data = mysqli_query($conn, "SELECT p.*, b.nama_barang FROM peminjaman p 
          LEFT JOIN barang b ON p.id_barang = b.id_barang 
          ORDER BY p.tgl_pinjam DESC");
          $no = 1;
          while ($d = mysqli_fetch_assoc($data)) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $d['nama_peminjam'] ?></td>
              <td><?= $d['nama_barang'] ?></td>
              <td><?= $d['tgl_pinjam'] ?></td>
              <td class="status-<?= strtolower($d['status']) ?>">
                <?= ucfirst($d['status']) ?>
                <?php if (strtolower($d['status']) == 'dipinjam'): ?>
                  <br><a href="index.php?page=pengembalian&id=<?= $d['id_peminjaman'] ?>" class="btn green" style="margin-top: 5px;">Kembalikan</a>
                <?php endif; ?>
              </td>

              <td><?= $d['tanggal_kembali'] ?: '-' ?></td>
              <td>
                <a href="index.php?page=peminjaman&edit=<?= $d['id_peminjaman'] ?>" class="btn">Edit</a>
                <a href="index.php?page=peminjaman&hapus=<?= $d['id_peminjaman'] ?>" class="btn gray" onclick="return confirm('Hapus data ini?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
  .header-title {
    font-size: 24px;
    font-weight: bold;
    margin: 30px;
    color: #1e293b;
  }

  .flex-container {
    display: flex;
    gap: 30px;
    margin: 0 30px 40px;
    align-items: flex-start;
  }

  .form-box,
  .table-box {
    background: #fff;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .form-box {
    flex: 1;
    max-width: 400px;
  }

  .table-box {
    flex: 2;
    overflow-x: auto;
  }

  label {
    font-weight: 600;
    font-size: 14px;
  }

  .input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    margin-top: 5px;
    margin-bottom: 16px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
  }

  .btn {
    background: #3b82f6;
    color: white;
    padding: 10px 16px;
    font-size: 14px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
  }

  .btn.gray {
    background:#ef4444;
    color:rgb(255, 255, 255);
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }

  .table-container {
    overflow-x: auto;
    overflow-y: auto;
    max-height: 400px;
    max-width: 100%;
  }

  table th,
  table td {
    border: 1px solid #e2e8f0;
    padding: 10px;
    text-align: left;
  }

  table thead {
    background-color: #f8fafc;
  }

  .status-dipinjam {
    color: #f59e0b;
    font-weight: bold;
  }

  .status-dikembalikan {
    color: #10b981;
    font-weight: bold;
  }
</style>