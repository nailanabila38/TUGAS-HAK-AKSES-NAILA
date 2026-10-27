<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        die("ID ruangan tidak valid.");
    }

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM ruangan WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: rooms.php");
        exit;
    } else {
        die("Gagal menghapus data: " . mysqli_error($conn));
    }

} else {
    header("Location: rooms.php");
    exit;
}
?>