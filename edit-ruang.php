<?php
require 'koneksi.php';

function e($teks) {
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: rooms.php");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM ruangan WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$ruangan = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$ruangan) {
    header("Location: rooms.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gedung = trim($_POST['gedung'] ?? '');
    $nomor = trim($_POST['nomor_ruang'] ?? '');
    $kapasitasInput = $_POST['kapasitas'] ?? '';
    $proyektor = $_POST['proyektor'] ?? '';
    $pc = $_POST['pc'] ?? '';
    $status = $_POST['status'] ?? '';

    if (
        $gedung === '' ||
        $nomor === '' ||
        $kapasitasInput === '' ||
        !ctype_digit((string)$kapasitasInput) ||
        (int)$kapasitasInput < 1 ||
        (int)$kapasitasInput > 2147483647 ||
        !in_array($proyektor, ['Tersedia', 'Tidak Ada'], true) ||
        !in_array($pc, ['Tersedia', 'Tidak Ada'], true) ||
        !in_array($status, ['Aktif', 'Nonaktif'], true)
    ) {
        $error = 'Periksa kembali data yang dimasukkan.';
    } else {
        $kapasitas = (int)$kapasitasInput;

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE ruangan
             SET gedung = ?, nomor_ruang = ?, kapasitas = ?,
                 proyektor = ?, pc = ?, status = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssisssi",
            $gedung,
            $nomor,
            $kapasitas,
            $proyektor,
            $pc,
            $status,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: rooms.php");
            exit;
        } else {
            $error = 'Data gagal diperbarui. Silakan coba lagi.';
            mysqli_stmt_close($stmt);
        }
    }

    // Menjaga input yang sudah diketik ketika validasi gagal
    $ruangan['gedung'] = $gedung;
    $ruangan['nomor_ruang'] = $nomor;
    $ruangan['kapasitas'] = $kapasitasInput;
    $ruangan['proyektor'] = $proyektor;
    $ruangan['pc'] = $pc;
    $ruangan['status'] = $status;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ruangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="halaman-tambah">
    <div class="form-box">
        <h1>Edit Ruangan</h1>
        <p class="subjudul">Ubah data ruang dan fasilitas sidang</p>

        <?php if ($error !== ''): ?>
            <p style="color:red;"><?= e($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="edit-ruang.php?id=<?= (int)$id ?>">
            <label for="gedung">Gedung</label>
            <input
                type="text" id="gedung" name="gedung"
                maxlength="50" required
                value="<?= e($ruangan['gedung']) ?>"
            >

            <label for="nomor_ruang">Nomor Ruang</label>
            <input
                type="text" id="nomor_ruang" name="nomor_ruang"
                maxlength="20" required
                value="<?= e($ruangan['nomor_ruang']) ?>"
            >

            <label for="kapasitas">Kapasitas Ruangan</label>
            <input
                type="number" id="kapasitas" name="kapasitas"
                min="1" required
                value="<?= e($ruangan['kapasitas']) ?>"
            >

            <label>Proyektor</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="proyektor"
                        value="Tersedia"
                        <?= $ruangan['proyektor'] === 'Tersedia' ? 'checked' : '' ?>
                        required>
                    Tersedia
                </label>

                <label>
                    <input type="radio" name="proyektor"
                        value="Tidak Ada"
                        <?= $ruangan['proyektor'] === 'Tidak Ada' ? 'checked' : '' ?>>
                    Tidak Ada
                </label>
            </div>

            <label>PC</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="pc"
                        value="Tersedia"
                        <?= $ruangan['pc'] === 'Tersedia' ? 'checked' : '' ?>
                        required>
                    Tersedia
                </label>

                <label>
                    <input type="radio" name="pc"
                        value="Tidak Ada"
                        <?= $ruangan['pc'] === 'Tidak Ada' ? 'checked' : '' ?>>
                    Tidak Ada
                </label>
            </div>

            <label for="status">Status Ruangan</label>
            <select id="status" name="status" required>
                <option value="Aktif"
                    <?= $ruangan['status'] === 'Aktif' ? 'selected' : '' ?>>
                    Aktif
                </option>

                <option value="Nonaktif"
                    <?= $ruangan['status'] === 'Nonaktif' ? 'selected' : '' ?>>
                    Nonaktif
                </option>
            </select>

            <div class="tombol-form">
                <a href="rooms.php" class="btn-kembali">Kembali</a>
                <button type="submit" class="btn-simpan">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
