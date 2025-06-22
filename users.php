<?php
include 'koneksi.php';

$id = $_GET['edit'] ?? '';
$hapus = $_GET['hapus'] ?? '';
$edit = isset($_GET['edit']);

// Hapus data
if ($hapus) {
    mysqli_query($conn, "DELETE FROM users WHERE id_user = '$hapus'");
    echo "<script>location='index.php?page=users';</script>";
    exit;
}

// Simpan / update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);


    if ($edit) {
        if ($_POST['password']) {
            mysqli_query($conn, "UPDATE users SET username='$username', password='$password' WHERE id_user='$id'");
        } else {
            mysqli_query($conn, "UPDATE users SET username='$username' WHERE id_user='$id'");
        }
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password, nama_lengkap) VALUES ('$username', '$password', '$nama')");
    }
    echo "<script>location='index.php?page=users';</script>";
    exit;
}

// Ambil data saat edit
$row = ['nama_lengkap' => '', 'username' => '', 'password' => ''];
if ($edit) {
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id'");
    $row = mysqli_fetch_assoc($result);
}
?>

<h1 class="header-title">Manajemen Pengguna</h1>

<div class="flex-container">
    <div class="form-box">
        <h2>Table Pengguna</h2><br><br>
        <form method="post">
            <p>
                <label>Nama Lengkap</label><br>
                <input type="text" name="nama_lengkap" required class="input" value="<?= $row['nama_lengkap'] ?? '' ?>">
            </p>
            <p>
                <label>Username</label><br>
                <input type="text" name="username" required class="input" value="<?= $row['username'] ?>">
            </p>
            <p>
                <label>Password <?= $edit ? '(kosongkan jika tidak diubah)' : '' ?></label><br>
                <input type="password" name="password" class="input">
            </p>
            <p>
                <button type="submit" class="btn"><?= $edit ? 'Update' : 'Simpan' ?></button>
                <?php if ($edit): ?>
                    <a href="index.php?page=users" class="btn gray">Batal</a>
                <?php endif ?>
            </p>
        </form>
    </div>

    <div class="table-box">
        <div class="table_container">
            <h2>Tambah Pengguna</h2><br><br>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query($conn, "SELECT * FROM users ORDER BY id_user ASC");
                    while ($d = mysqli_fetch_assoc($data)) :
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['nama_lengkap'] ?></td>
                            <td><?= $d['username'] ?></td>
                            <td>
                                <a href="index.php?page=users&edit=<?= $d['id_user'] ?>" class="btn">Edit</a>
                                <a href="index.php?page=users&hapus=<?= $d['id_user'] ?>" class="btn gray" onclick="return confirm('Hapus user ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile ?>
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
        border: 1px solid #e2e8f0;
        padding: 10px;
        text-align: left;
    }

    table thead {
        background-color: #f8fafc;
    }

    .table-container {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 400px;
        max-width: 100%;
    }
</style>