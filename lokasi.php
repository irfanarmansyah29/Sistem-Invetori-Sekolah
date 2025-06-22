<?php
//LOAD DATA
$id = $_GET['edit'] ?? '';
$hapus = $_GET['hapus'] ?? '';
$edit = isset($_GET['edit']);
$cari = $_GET['cari'] ?? '';
$where = '';

if (!empty($cari)) {
  $cari = mysqli_real_escape_string($conn, $cari);
  $where = "WHERE nama_lokasi LIKE '%$cari%'";
}


//HAPUS
if ($hapus) {
  mysqli_query($conn, "DELETE FROM lokasi WHERE id_lokasi = '$hapus'");
  echo "<script>location='index.php?page=lokasi';</script>";
  exit;
}

//SIMPAN TAMBAH/EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama'];
  if ($edit) {
    mysqli_query($conn, "UPDATE lokasi SET nama_lokasi = '$nama' WHERE id_lokasi = '$id'");
  } else {
    mysqli_query($conn, "INSERT INTO lokasi (nama_lokasi) VALUES ('$nama')");
  }
  echo "<script>location='index.php?page=lokasi';</script>";
  exit;
}

//AMBIL DATA JIKA EDIT
$row = ['nama_lokasi' => ''];
if ($edit) {
  $result = mysqli_query($conn, "SELECT * FROM lokasi WHERE id_lokasi = '$id'");
  $row = mysqli_fetch_assoc($result);
}
?>

<h1 class="header-title">Lokasi / Ruangan</h1><br>

<!-- FORM TAMBAH / EDIT -->
<div class="content" style="margin-bottom: 20px; max-width: 500px;">
  <form method="post">
    <p><label>Nama Lokasi</label><br>
      <input type="text" name="nama" required value="<?= $row['nama_lokasi'] ?>"
        style="width:100%; padding:10px; margin-top:5px; border:1px solid #cbd5e1; border-radius:8px;">
    </p>
    <p style="margin-top: 10px;">
      <button type="submit" class="btn"><?= $edit ? 'Update' : 'Simpan' ?></button>
      <?php if ($edit): ?>
        <a href="index.php?page=lokasi" class="btn" style="background:#94a3b8; margin-left:10px">Batal</a>
      <?php endif ?>
    </p>
  </form>
</div>

<!-- TABEL DATA LOKASI -->
<div class="table-container">
  <form method="get" style="margin-bottom: 15px; display: flex; gap: 10px;">
    <input type="hidden" name="page" value="lokasi">
    <input type="text" name="cari" value="<?= htmlspecialchars($cari) ?>" placeholder="Cari nama lokasi..."
      class="input" style="padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; width: 250px;">
    <button type="submit" class="btn" style="background: #3b82f6;">Cari</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $lokasi = mysqli_query($conn, "SELECT * FROM lokasi $where ORDER BY id_lokasi ASC");
      $no = 1;
      while ($l = mysqli_fetch_assoc($lokasi)) : ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $l['nama_lokasi'] ?></td>
          <td>
            <a href="index.php?page=lokasi&edit=<?= $l['id_lokasi'] ?>" class="btn">Edit</a>
            <a href="index.php?page=lokasi&hapus=<?= $l['id_lokasi'] ?>" class="btn" style="background:#ef4444"
              onclick="return confirm('Yakin hapus lokasi ini?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<style>
  .table-container {
    overflow-x: auto;
    overflow-y: auto;
    max-height: 400px;
    max-width: 100%;
  }
</style>