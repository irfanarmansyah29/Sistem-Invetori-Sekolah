<?php
include 'koneksi.php';

function hitung($conn, $sql)
{
  $result = mysqli_query($conn, $sql);
  return $result ? mysqli_num_rows($result) : 0;
}

$totalBarang   = hitung($conn, "SELECT * FROM barang");
$barangRusak   = hitung($conn, "SELECT * FROM barang WHERE kondisi LIKE '%Rusak%'");
$barangPinjam  = hitung($conn, "SELECT * FROM peminjaman");
$totalRuangan  = hitung($conn, "SELECT * FROM lokasi");
?>

<h1 class="header-title">Dashboard</h1><br><br>

<style>
  .card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
    animation: fadeIn 0.6s ease;
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 30px;
  }

  .card-row {
    display: flex;
    gap: 20px;
    justify-content: space-between;
  }

  @media (max-width: 768px) {
    .card-row {
      flex-direction: column;
    }
  }


  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .card {
    background: white;
    border-radius: 16px;
    padding: 30px 35px;
    display: flex;
    align-items: center;
    gap: 25px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.07);
    transition: all 0.3s ease;
    border-left: 8px solid transparent;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
  }

  .icon-box {
    width: 64px;
    height: 64px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    border-radius: 12px;
  }

  .card.blue {
    border-left-color: #3b82f6;
  }

  .card.orange {
    border-left-color: #f97316;
  }

  .card.green {
    border-left-color: #10b981;
  }

  .card.purple {
    border-left-color: #8b5cf6;
  }

  .card .info {
    display: flex;
    flex-direction: column;
  }

  .card .info label {
    font-size: 16px;
    color: #64748b;
    margin-bottom: 6px;
  }

  .card .info strong {
    font-size: 32px;
    font-weight: 700;
    color: #0f172a;
  }
</style>

<div class="card-container">
  <div class="card-row">
    <div class="card blue">
      <div class="icon-box">📦</div>
      <div class="info">
        <label>Total Barang</label>
        <strong><?= $totalBarang ?></strong>
      </div>
    </div>

    <div class="card orange">
      <div class="icon-box">💔</div>
      <div class="info">
        <label>Barang Rusak</label>
        <strong><?= $barangRusak ?></strong>
      </div>
    </div>
  </div>
  <div class="card-row">
    <div class="card green">
      <div class="icon-box">🔄</div>
      <div class="info">
        <label>Barang Dipinjam</label>
        <strong><?= $barangPinjam ?></strong>
      </div>
    </div>

    <div class="card purple">
      <div class="icon-box">🏫</div>
      <div class="info">
        <label>Total Ruangan</label>
        <strong><?= $totalRuangan ?></strong>
      </div>
    </div>
  </div>
</div>