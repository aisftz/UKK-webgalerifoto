<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $komentarid = $_POST['komentarid'];

    $query = mysqli_query($conn, "DELETE FROM komentarfoto WHERE komentarid='$komentarid'");

    if ($query) {
        // Redirect ke dashboard setelah berhasil
        header("Location: ../dashboard.php");

    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        header("Location: ../dashboard.php");
        
    }
} else {
    // Redirect jika bukan metode POST
    header("Location: ../dashboard.php");
}
?>
