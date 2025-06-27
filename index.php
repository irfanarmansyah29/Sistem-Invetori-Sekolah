<?php
session_start();
if (!isset($_SESSION['login']) && ($_GET['page'] ?? '') != 'login') {
    header("Location: index.php?page=login");
    exit;
}
include 'koneksi.php';
$page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Inventori Sekolah</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            height: 100vh;
            background-color: #f1f5f9;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background: #1e3a8a;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
        }

        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 40px;
            font-weight: 600;
        }

        .sidebar .user {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            padding: 10px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .user img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }

        .sidebar .user span {
            font-size: 15px;
            font-weight: 600;
            color: #fff;
        }

        /* Link Menu */
        .sidebar a {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 15px;
            transition: background 0.25s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* MAIN CONTENT */
        .main {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
        }

        .page-header {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .content-box {
            background: #f9fafb;
            /* lebih lembut dari putih */
            padding: 24px 28px;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .content-box:hover {
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
        }



        .card-boxes {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .card {
            flex: 1;
            min-width: 180px;
            padding: 20px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .blue {
            background: #3b82f6;
        }

        .green {
            background: #10b981;
        }

        .orange {
            background: #f59e0b;
        }

        .purple {
            background: #8b5cf6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
        }

        table th {
            background-color: #f8fafc;
            text-align: left;
        }

        .btn {
            display: inline-block;
            background: #3b82f6;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
        }

        .btn:hover {
            background: #2563eb;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                flex-direction: row;
                width: 100%;
                overflow-x: auto;
                padding: 20px;
                gap: 15px;
            }

            .main {
                padding: 15px;
            }
        }

        .welcome-box {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            color: white;
            padding: 18px 24px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .welcome-box h2 {
            font-size: 20px;
            font-weight: 500;
        }

        .user-dropdown {
            position: relative;
        }

        .user-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.1);
            cursor: pointer;
            color: #fff;
        }

        .user-toggle img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-toggle .arrow {
            font-size: 12px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            margin-top: 8px;
            z-index: 1000;
            min-width: 140px;
            overflow: hidden;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px 15px;
            color: #1e293b;
            text-decoration: none;
            font-size: 14px;
        }

        .dropdown-menu a:hover {
            background-color:rgb(6, 6, 246);
        }
    </style>
</head>
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(e) {
        const toggle = document.querySelector('.user-toggle');
        const dropdown = document.getElementById('dropdownMenu');
        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>


<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="user-dropdown">
            <div class="user-toggle" onclick="toggleDropdown()">
                <img src="icon.png" alt="User">
                <span><?= $_SESSION['nama_lengkap'] ?></span>
                <span class="arrow">▼</span>
            </div>
            <div id="dropdownMenu" class="dropdown-menu">
                <a href="logout.php">🚪 Logout</a>
            </div><br>
        </div>

        <a href="index.php?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>"> <span>Dashboard</span></a>
        <a href="index.php?page=barang" class="<?= $page == 'barang' ? 'active' : '' ?>"> <span>Data Barang</span></a>
        <a href="index.php?page=kategori" class="<?= $page == 'kategori' ? 'active' : '' ?>"> <span>Kategori</span></a>
        <a href="index.php?page=lokasi" class="<?= $page == 'lokasi' ? 'active' : '' ?>"> <span>Lokasi/Ruangan</span></a>
        <a href="index.php?page=peminjaman" class="<?= $page == 'peminjaman' ? 'active' : '' ?>"> <span>Peminjaman</span></a>
        <a href="index.php?page=laporan_peminjaman" class="<?= $page == 'laporan_peminjaman' ? 'active' : '' ?>"> <span>Laporan Peminjaman</span></a>
        <a href="index.php?page=laporan_barang_rusak" class="<?= $page == 'laporan_barang_rusak' ? 'active' : '' ?>"> <span>Laporan Barang Rusak</span></a>
        <a href="index.php?page=riwayat" class="<?= $page == 'riwayat' ? 'active' : '' ?>"> <span>riwayat Stok Per Kategori</span></a>
        <a href="index.php?page=users" class="<?= $page == 'users' ? 'active' : '' ?>"> <span>Pengguna</span></a>
        

    </div>

    <div class="main">
        <div class="welcome-box">
            <h2> Selamat datang, <?= $_SESSION['nama_lengkap'] ?>!</h2>
        </div>

        <div class="content-box">
            <?php
            $pages = [
                'dashboard' => 'dashboard.php',
                'barang' => 'barang.php',
                'kategori' => 'kategori.php',
                'lokasi' => 'lokasi.php',
                'peminjaman' => 'peminjaman.php',
                'pengembalian' => 'pengembalian.php',
                'laporan_peminjaman' => 'laporan_peminjaman.php',
                'laporan_barang_rusak' => 'laporan_barang_rusak.php',
                'riwayat' => 'riwayat_stok_perkategori.php',
                'users' => 'users.php'
            ];
            if (isset($pages[$page])) {
                include $pages[$page];
            } else {
                echo "<p>Halaman tidak ditemukan.</p>";
            }
            ?>
        </div>
    </div>

</body>

</html>