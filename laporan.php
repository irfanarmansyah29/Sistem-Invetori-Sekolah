<?php
include "koneksi.php";

// ambil nilai dari parameter GET
$tglMulai = $_GET['mulai'] ?? '';
$tglSelesai = $_GET['selesai'] ?? '';

// ambil daftar tanggal unik dari tabel peminjaman
$tanggalQuery = mysqli_query($conn, "SELECT DISTINCT tgl_pinjam FROM peminjaman ORDER BY tgl_pinjam DESC");

$where = "";
if ($tglMulai && $tglSelesai) {
  $where = "WHERE p.tgl_pinjam BETWEEN '$tglMulai' AND '$tglSelesai'";
}
?>

<h1 class="header-title">Laporan Peminjaman</h1><br><br>

<div class="content" style="max-width: 700px; margin-bottom: 20px;">
  <form method="get" style="display: flex; gap: 10px; flex-wrap: wrap;">
    <input type="hidden" name="page" value="laporan">

    <div>
      <label>Dari Tanggal:</label><br>
      <select name="mulai" required style="padding: 10px; border-radius: 8px; border:1px solid #cbd5e1;">
        <option value="">-- Pilih Tanggal --</option>
        <?php mysqli_data_seek($tanggalQuery, 0);
        foreach ($tanggalQuery as $t): ?>
          <option value="<?= $t['tgl_pinjam'] ?>" <?= $tglMulai == $t['tgl_pinjam'] ? 'selected' : '' ?>>
            <?= $t['tgl_pinjam'] ?>
          </option>
        <?php endforeach ?>
      </select>
    </div>

    <div>
      <label>Sampai Tanggal:</label><br>
      <select name="selesai" required style="padding: 10px; border-radius: 8px; border:1px solid #cbd5e1;">
        <option value="">-- Pilih Tanggal --</option>
        <?php mysqli_data_seek($tanggalQuery, 0);
        foreach ($tanggalQuery as $t): ?>
          <option value="<?= $t['tgl_pinjam'] ?>" <?= $tglSelesai == $t['tgl_pinjam'] ? 'selected' : '' ?>>
            <?= $t['tgl_pinjam'] ?>
          </option>
        <?php endforeach ?>
      </select>
    </div>

    <div style="align-self: end;">
      <button type="submit" class="btn">Tampilkan</button>
    </div>

    <?php if ($tglMulai && $tglSelesai): ?>
      <div style="align-self: end;">
        <a href="cetak_laporan.php?mulai=<?= $tglMulai ?>&selesai=<?= $tglSelesai ?>" target="_blank" class="btn" style="background: #10b981">Cetak</a>
      </div>
    <?php endif ?>
  </form>
</div>

<!-- TABEL -->
<div class="content">
  <div class="table-container">
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
        <?php
        $no = 1;
        $data = mysqli_query($conn, "SELECT p.*, b.nama_barang FROM peminjaman p 
        LEFT JOIN barang b ON p.id_barang = b.id_barang $where ORDER BY p.tgl_pinjam DESC");
        while ($d = mysqli_fetch_assoc($data)) :
        ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $d['nama_peminjam'] ?></td>
            <td><?= $d['nama_barang'] ?></td>
            <td><?= $d['tgl_pinjam'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<style>
  .table-container {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 500px;
        max-width: 100%;
    }
</style>