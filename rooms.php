<?php
require 'koneksi.php';

// Mengambil seluruh data ruangan
$result = mysqli_query(
    $conn,
    "SELECT * FROM ruangan ORDER BY id ASC"
);

if (!$result) {
    die("Gagal mengambil data ruangan.");
}

// Menghitung statistik dari database
$total = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM ruangan")
)['jumlah'];

$aktif = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM ruangan WHERE status = 'Aktif'")
)['jumlah'];

$proyektor = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM ruangan WHERE proyektor = 'Tersedia'")
)['jumlah'];

$pc = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM ruangan WHERE pc = 'Tersedia'")
)['jumlah'];

// Fungsi untuk menampilkan teks dengan aman
function e($teks) {
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang &amp; Fasilitas Sidang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main">

    <div class="header">
        <div>
            <h1>Ruang &amp; Fasilitas Sidang</h1>
            <p>Kelola data ruang ujian dan fasilitas sidang</p>
        </div>

        <a href="tambah-ruang.php" class="btn-tambah">
            + Tambah Ruangan
        </a>
    </div>

    <div class="statistik">
        <div class="card">
            <p>Total Ruangan</p>
            <h2><?= e($total) ?></h2>
        </div>

        <div class="card">
            <p>Ruang Aktif</p>
            <h2><?= e($aktif) ?></h2>
        </div>

        <div class="card">
            <p>Memiliki Proyektor</p>
            <h2><?= e($proyektor) ?></h2>
        </div>

        <div class="card">
            <p>Memiliki PC</p>
            <h2><?= e($pc) ?></h2>
        </div>
    </div>

    <div class="data-container">
        <div class="data-header">
            <h2>Data Ruangan</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gedung</th>
                    <th>Nomor Ruang</th>
                    <th>Kapasitas</th>
                    <th>Proyektor</th>
                    <th>PC</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($row['gedung']) ?></td>
                        <td><?= e($row['nomor_ruang']) ?></td>
                        <td><?= e($row['kapasitas']) ?> Orang</td>

                        <td class="<?= $row['proyektor'] === 'Tersedia' ? 'tersedia' : 'tidak' ?>">
                            <?= $row['proyektor'] === 'Tersedia' ? '✓ Tersedia' : '✕ Tidak Ada' ?>
                        </td>

                        <td class="<?= $row['pc'] === 'Tersedia' ? 'tersedia' : 'tidak' ?>">
                            <?= $row['pc'] === 'Tersedia' ? '✓ Tersedia' : '✕ Tidak Ada' ?>
                        </td>

                        <td>
                            <span class="status <?= $row['status'] === 'Aktif' ? 'aktif-status' : 'nonaktif-status' ?>">
                                <?= e($row['status']) ?>
                            </span>
                        </td>

                        <td>
                            <a
                                class="btn-edit"
                                href="edit-ruang.php?id=<?= (int)$row['id'] ?>"
                            >Edit</a>

                            <form
    action="hapus-ruang.php"
    method="POST"
    style="display:inline"
    onsubmit="return confirm('Yakin ingin menghapus ruangan ini?');"
>
    <input
        type="hidden"
        name="id"
        value="<?= (int)$row['id'] ?>"
    >

    <button type="submit" class="btn-hapus">
        Hapus
    </button>
</form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align:center;">
                        Belum ada data ruangan.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>