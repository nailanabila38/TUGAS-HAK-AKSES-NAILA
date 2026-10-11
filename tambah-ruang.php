<?php
require 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gedung = trim($_POST['gedung'] ?? '');
    $nomor = trim($_POST['nomor_ruang'] ?? '');
    $kapasitas = $_POST['kapasitas'] ?? '';
    $proyektor = $_POST['proyektor'] ?? '';
    $pc = $_POST['pc'] ?? '';
    $status = $_POST['status'] ?? '';

    // Validasi data yang dimasukkan
    if (
        $gedung === '' ||
        $nomor === '' ||
        $kapasitas === '' ||
        !ctype_digit((string)$kapasitas) ||
        (int)$kapasitas < 1 ||
        !in_array($proyektor, ['Tersedia', 'Tidak Ada'], true) ||
        !in_array($pc, ['Tersedia', 'Tidak Ada'], true) ||
        !in_array($status, ['Aktif', 'Nonaktif'], true)
    ) {
        $error = 'Periksa kembali semua data. Kapasitas harus lebih dari 0.';
    } else {
        $kapasitas = (int)$kapasitas;

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO ruangan
            (gedung, nomor_ruang, kapasitas, proyektor, pc, status)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssisss",
            $gedung,
            $nomor,
            $kapasitas,
            $proyektor,
            $pc,
            $status
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: rooms.php");
            exit;
        } else {
            $error = 'Data gagal disimpan. Silakan coba lagi.';
        }

        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ruangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="halaman-tambah">
    <div class="form-box">
        <h1>Tambah Ruangan</h1>

        <p class="subjudul">
            Masukkan data ruangan dan fasilitas sidang
        </p>

        <?php if ($error !== ''): ?>
            <p style="color:red;">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="tambah-ruang.php">
            <label for="gedung">Gedung</label>
            <input
                type="text"
                id="gedung"
                name="gedung"
                placeholder="Contoh: Gedung A"
                maxlength="50"
                value="<?= htmlspecialchars($_POST['gedung'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="nomor_ruang">Nomor Ruang</label>
            <input
                type="text"
                id="nomor_ruang"
                name="nomor_ruang"
                placeholder="Contoh: A301"
                maxlength="20"
                value="<?= htmlspecialchars($_POST['nomor_ruang'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="kapasitas">Kapasitas Ruangan</label>
            <input
                type="number"
                id="kapasitas"
                name="kapasitas"
                min="1"
                placeholder="Contoh: 30"
                value="<?= htmlspecialchars($_POST['kapasitas'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label>Proyektor</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="proyektor"
                        value="Tersedia" required>
                    Tersedia
                </label>

                <label>
                    <input type="radio" name="proyektor"
                        value="Tidak Ada">
                    Tidak Ada
                </label>
            </div>

            <label>PC</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="pc"
                        value="Tersedia" required>
                    Tersedia
                </label>

                <label>
                    <input type="radio" name="pc"
                        value="Tidak Ada">
                    Tidak Ada
                </label>
            </div>

            <label for="status">Status Ruangan</label>
            <select id="status" name="status" required>
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>

            <div class="tombol-form">
                <a href="rooms.php" class="btn-kembali">
                    Kembali
                </a>

                <button type="submit" class="btn-simpan">
                    Simpan Ruangan
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
