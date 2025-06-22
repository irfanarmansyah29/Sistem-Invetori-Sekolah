<?php
include 'koneksi.php';

//LOAD DATA
$id = $_GET['edit'] ?? '';
$hapus = $_GET['hapus'] ?? '';
$edit = isset($_GET['edit']);
$kategori = mysqli_query($conn, "SELECT * FROM kategori");
$lokasi = mysqli_query($conn, "SELECT * FROM lokasi");
$cari = $_GET['cari'] ?? '';
$where = '';

if (!empty($cari)) {
  $cari = mysqli_real_escape_string($conn, $cari);
  $where = "WHERE b.nama_barang LIKE '%$cari%' OR b.kode_barang LIKE '%$cari%'";
}


if ($hapus) {
  mysqli_query($conn, "DELETE FROM barang WHERE id_barang = '$hapus'");
  echo "<script>location='index.php?page=barang';</script>";
  exit;
}

//SIMPAN TAMBAH/EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $kode = $_POST['kode'];
  $nama = $_POST['nama'];
  $kat  = $_POST['kategori'];
  $lok  = $_POST['lokasi'];
  $kond = $_POST['kondisi'];
  $jml  = $_POST['jumlah'];

  if ($edit) {
    mysqli_query($conn, "UPDATE barang SET 
            kode_barang='$kode', nama_barang='$nama', 
            id_kategori='$kat', id_lokasi='$lok', kondisi='$kond', jumlah='$jml'
            WHERE id_barang='$id'");
  } else {
    mysqli_query($conn, "INSERT INTO barang 
            (kode_barang, nama_barang, id_kategori, id_lokasi, kondisi, jumlah)
            VALUES ('$kode', '$nama', '$kat', '$lok', '$kond', '$jml')");
  }
  echo "<script>location='index.php?page=barang';</script>";
  exit;
}

//AMBIL DATA BARANG (UNTUK EDIT)
$row = ['kode_barang' => '', 'nama_barang' => '', 'id_kategori' => '', 'id_lokasi' => '', 'kondisi' => 'Baik', 'jumlah' => '1'];
if ($edit) {
  $result = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = '$id'");
  $row = mysqli_fetch_assoc($result);
}

?>

<style>
  .flex-container {
    display: flex;
    gap: 30px;
    align-items: flex-start;
    margin-left: 30px;
    margin-right: 30px;
  }

  .form-box,
  .table-box {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
  }

  .form-box {
    flex: 1;
    max-width: 400px;
  }

  .table-box {
    flex: 2;
    overflow-x: auto;
  }

  h1.header-title {
    font-size: 24px;
    font-weight: 600;
    margin: 30px;
    color: #1e293b;
  }

  label {
    font-weight: 600;
    font-size: 14px;
  }

  input.input,
  select.input {
    padding: 10px;
    font-size: 14px;
    width: 100%;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    margin-top: 6px;
    margin-bottom: 16px;
  }

  .radio-wrap {
    display: flex;
    gap: 15px;
    margin-top: 6px;
    margin-bottom: 16px;
  }

  .btn {
    background: #3b82f6;
    color: white;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-right: 10px;
  }

  .btn.gray {
    background: #e2e8f0;
    color: #1e293b;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }

  table th,
  table td {
    padding: 10px;
    border: 1px solid #e2e8f0;
    text-align: left;
  }

  table th {
    background: #f8fafc;
  }

  .btn {
    padding: 8px 14px;
    font-size: 14px;
    border-radius: 6px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    display: inline-block;
  }

  .btn.small {
    padding: 4px 8px;
    font-size: 11px;
    border-radius: 4px;
  }


  .btn.edit {
    background-color: #3b82f6;
  }

  .btn.hapus {
    background-color: #ef4444;
  }

  .table-container {
    overflow-x: auto;
    overflow-y: auto;
    max-height: 565px;
    max-width: 100%;
  }
</style>
<div>
  <h1 class="header-title">Data Barang</h1>
  <div class="flex-container">

    <div class="form-box">
      <h2>Tambah Barang</h2><br><br>
      <form method="post">
        <label>Kode Barang</label>
        <input type="text" name="kode" class="input" required value="<?= $row['kode_barang'] ?>">

        <label>Nama Barang</label>
        <input type="text" name="nama" class="input" required value="<?= $row['nama_barang'] ?>">

        <label>Kategori</label>
        <select name="kategori" class="input" required>
          <option value="">-- Pilih Kategori --</option>
          <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id_kategori'] ?>" <?= $k['id_kategori'] == $row['id_kategori'] ? 'selected' : '' ?>>
              <?= $k['nama_kategori'] ?>
            </option>
          <?php endforeach ?>
        </select>

        <label>Lokasi</label>
        <select name="lokasi" class="input" required>
          <option value="">-- Pilih Lokasi --</option>
          <?php foreach ($lokasi as $l): ?>
            <option value="<?= $l['id_lokasi'] ?>" <?= $l['id_lokasi'] == $row['id_lokasi'] ? 'selected' : '' ?>>
              <?= $l['nama_lokasi'] ?>
            </option>
          <?php endforeach ?>
        </select>

        <label>Kondisi</label>
        <div class="radio-wrap">
          <label><input type="radio" name="kondisi" value="Baik" <?= $row['kondisi'] == 'Baik' ? 'checked' : '' ?>> Baik</label>
          <label><input type="radio" name="kondisi" value="Rusak Ringan" <?= $row['kondisi'] == 'Rusak Ringan' ? 'checked' : '' ?>> Rusak Ringan</label>
          <label><input type="radio" name="kondisi" value="Rusak Berat" <?= $row['kondisi'] == 'Rusak Berat' ? 'checked' : '' ?>> Rusak Berat</label>
        </div>

        <label>Jumlah</label>
        <input type="number" name="jumlah" class="input" required value="<?= $row['jumlah'] ?>">

        <button type="submit" class="btn"><?= $edit ? 'Update' : 'Simpan' ?></button>
        <?php if ($edit): ?>
          <a href="index.php?page=barang" class="btn gray">Batal</a>
        <?php endif ?>
      </form>
    </div>

    <div class="table-box">
      <div class="table-container">
        <h2>Table Barang</h2>
        <form method="get" style="margin-bottom: 15px;">
          <input type="hidden" name="page" value="barang">
          <input type="text" name="cari" value="<?= htmlspecialchars($cari) ?>" placeholder="Cari nama/kode barang..." class="input" style="width: 250px; margin-right: 10px;">
          <button type="submit" class="btn">Cari</button>
        </form>
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Kategori</th>
              <th>Lokasi</th>
              <th>Kondisi</th>
              <th>Jumlah</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $data = mysqli_query($conn, "
          SELECT b.*, k.nama_kategori, l.nama_lokasi 
          FROM barang b
          LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
          LEFT JOIN lokasi l ON b.id_lokasi = l.id_lokasi
          $where
          ORDER BY b.id_barang ASC") or die(mysqli_error($conn));
            $no = 1;
            while ($d = mysqli_fetch_assoc($data)) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['kode_barang'] ?></td>
                <td><?= $d['nama_barang'] ?></td>
                <td><?= $d['nama_kategori'] ?></td>
                <td><?= $d['nama_lokasi'] ?></td>
                <td><?= $d['kondisi'] ?></td>
                <td><?= $d['jumlah'] ?></td>
                <td>
                  <a href="index.php?page=barang&edit=<?= $d['id_barang'] ?>" class="btn small edit">Edit</a>
                  <a href="index.php?page=barang&hapus=<?= $d['id_barang'] ?>" class="btn small hapus" onclick="return confirm('Hapus data ini?')">Hapus</a>

                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>