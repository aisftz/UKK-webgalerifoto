<?php
session_start();
include 'koneksi.php';

// Pastikan metode POST terpenuhi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $komentarid = $_POST['komentarid'];
    $isikomentar = $_POST['isikomentar'];

    // Update komentar di database
    $query = mysqli_query($conn, "UPDATE komentarfoto SET isikomentar='$isikomentar' WHERE komentarid='$komentarid'");

    if ($query) {
        // Redirect ke dashboard setelah berhasil
        echo "<script>
        alert('Komentar berhasil diubah');
        location.href='../dashboard.php';
        </script>";
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "<script>
        alert('Gagal mengubah komentar');
        history.back();
        </script>";
    }
} else {
    // Redirect jika bukan metode POST
    header("Location: ../dashboard.php");
}
?>
