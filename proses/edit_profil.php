<?php
session_start();
include('koneksi.php');

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Tangkap data yang dikirim melalui form
$userid = $_SESSION['userid'];
$namalengkap = $_POST['editNamalengkap'];
$email = $_POST['editEmail'];
$alamat = $_POST['editAlamat'];
$username = $_POST['editUsername']; // Tambahkan ini untuk menangkap perubahan username

// Update data profil pengguna ke dalam database
$updateQuery = "UPDATE user SET namalengkap='$namalengkap', email='$email', alamat='$alamat', username='$username' WHERE userid='$userid'";
if ($conn->query($updateQuery) === TRUE) {
    $_SESSION['editberhasil'] = "Profil berhasil diperbarui.";
    header("Location: ../profil.php");
    exit();
} else {
    $_SESSION['editgagal'] = "Gagal memperbarui profil: " . $conn->error;
    header("Location: ../profil.php");
    exit();
}
?>
