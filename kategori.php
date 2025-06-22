<?php
//LOAD DATA
$id = $_GET['edit'] ?? '';
$hapus = $_GET['hapus'] ?? '';
$edit = isset($_GET['edit']);
$cari = $_GET['cari'] ?? '';
$where = '';

if (!empty($cari)) {
  $cari = mysqli_real_escape_string($conn, $cari);
  $where = "WHERE nama_kategori LIKE '%$cari%'";
}


//HAPUS KATEGORI
if ($hapus) {
  mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = '$hapus'");
  echo "<script>location='index.php?page=kategori';</script>";
  exit;
}

//SIMPAN TAMBAH/EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama'];
  if ($edit) {
    mysqli_query($conn, "UPDATE kategori SET nama_kategori = '$nama' WHERE id_kategori = '$id'");
  } else {
    mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$nama')");
  }
  echo "<script>location='index.php?page=kategori';</script>";
  exit;
}

//AMBIL DATA JIKA EDIT
$row = ['nama_kategori' => ''];
if ($edit) {
  $result = mysqli_query($conn, "SELECT * FROM kategori WHERE id_kategori = '$id'");
  $row = mysqli_fetch_assoc($result);
}
?>

<h1 class="header-title">Kategori</h1><br>

<!-- FORM TAMBAH / EDIT -->
<div class="content" style="margin-bottom: 20px; max-width: 500px;">
  <form method="post">
    <p><label>Nama Kategori</label><br>
      <input type="text" name="nama" required value="<?= $row['nama_kategori'] ?>"
        style="width:100%; padding:10px; margin-top:5px; border:1px solid #cbd5e1; border-radius:8px;">
    </p>

    <p style="margin-top: 10px;">
      <button type="submit" class="btn"><?= $edit ? 'Update' : 'Simpan' ?></button>
      <?php if ($edit): ?>
        <a href="index.php?page=kategori" class="btn" style="background:#94a3b8; margin-left:10px">Batal</a>
      <?php endif ?>
    </p>
  </form>
</div>

<!-- TABEL DATA KATEGORI -->

<div class="table-container">
  <form method="get" style="margin-bottom: 15px; display: flex; gap: 10px;">
    <input type="hidden" name="page" value="kategori">
    <input type="text" name="cari" value="<?= htmlspecialchars($cari) ?>" placeholder="Cari nama kategori..."
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
      $kategori = mysqli_query($conn, "SELECT * FROM kategori $where ORDER BY id_kategori ASC");
      $no = 1;
      while ($k = mysqli_fetch_assoc($kategori)) : ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $k['nama_kategori'] ?></td>
          <td>
            <a href="index.php?page=kategori&edit=<?= $k['id_kategori'] ?>" class="btn edit">Edit</a>
            <a href="index.php?page=kategori&hapus=<?= $k['id_kategori'] ?>" class="btn hapus"
              onclick="return confirm('Yakin hapus kategori ini?')">Hapus</a>

          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<style>
  .btn.edit {
    background: #3b82f6;
  }

  .btn.hapus {
    background: #ef4444;
  }

  .table-container {
    overflow-x: auto;
    overflow-y: auto;
    max-height: 400px;
    max-width: 100%;
  }
</style>