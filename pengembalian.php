<?php
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');
$id = $_GET['id'] ?? '';

// ambil data peminjaman yang belum dikembalikan
$data = mysqli_query($conn, "SELECT p.*, b.nama_barang FROM peminjaman p 
  LEFT JOIN barang b ON p.id_barang = b.id_barang 
  WHERE p.status = 'Dipinjam' AND p.id_peminjaman = '$id'");
$d = mysqli_fetch_assoc($data);

// jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_peminjaman = $_POST['id_peminjaman'];
    $tgl_kembali = date('Y-m-d');

    $tgl_kembali = date('Y-m-d H:i:s');

    mysqli_query($conn, "UPDATE peminjaman SET 
      status = 'Dikembalikan', 
      tanggal_kembali = '$tgl_kembali' 
      WHERE id_peminjaman = '$id_peminjaman'");

    echo "<script>alert('Barang berhasil dikembalikan!');location='index.php?page=peminjaman';</script>";
    exit;
}
?>

<h1 class="header-title">Form Pengembalian</h1>

<?php if ($d): ?>
    <div class="form-box" style="margin: 30px;">
        <form method="post">
            <input type="hidden" name="id_peminjaman" value="<?= $d['id_peminjaman'] ?>">

            <p><label>Nama Peminjam</label><br>
                <input type="text" class="input" value="<?= $d['nama_peminjam'] ?>" readonly>
            </p>

            <p><label>Barang</label><br>
                <input type="text" class="input" value="<?= $d['nama_barang'] ?>" readonly>
            </p>

            <p><label>Tanggal Pinjam</label><br>
                <input type="datetime-local" name="tgl_pinjam" class="input" value="<?= date('Y-m-d\TH:i', strtotime($d['tgl_pinjam'])) ?>" readonly>
            </p>

            <p><label>Tanggal Kembali</label><br>
                <input type="datetime-local" name="tanggal_kembali" class="input" value="<?= date('Y-m-d\TH:i') ?>">

            </p>

            <button type="submit" class="btn">Kembalikan</button>
            <a href="index.php?page=peminjaman" class="btn gray">Batal</a>
        </form>
    </div>
<?php else: ?>
    <p style="margin: 30px; color: red;">Data tidak ditemukan atau sudah dikembalikan.</p>
<?php endif ?>

<style>
    .form-box {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        max-width: 100%;
    }

    label {
        font-weight: bold;
        font-size: 14px;
    }

    .input {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        margin: 8px 0 16px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: #f8fafc;
    }

    .btn {
        background: #10b981;
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
        background: #e2e8f0;
        color: #1e293b;
    }
</style>