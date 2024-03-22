<?php
session_start();
include 'koneksi.php';

$username = $_SESSION['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];
$confirmNewPassword = $_POST['confirmNewPassword'];

$sql = mysqli_query($conn, "SELECT password FROM user WHERE username='$username'");
$data = mysqli_fetch_assoc($sql);
$oldPasswordDB = $data['password'];

if ($oldPassword !== $oldPasswordDB) {
    $_SESSION['reset_password_error'] = "Password lama tidak cocok.";
    header("Location: ../profil.php");
    exit();
}

if ($newPassword !== $confirmNewPassword) {
    $_SESSION['reseterror'] = "Password baru dan konfirmasi password tidak cocok.";
    header("Location: ../profil.php");
    exit();
}

$updatePassword = mysqli_query($conn, "UPDATE user SET password='$newPassword' WHERE username='$username'");
if ($updatePassword) {
    $_SESSION['resetberhasil'] = "Password berhasil direset.";
    header("Location: ../profil.php");
    exit();
} else {
    $_SESSION['resetgagal'] = "Gagal mereset password. Silakan coba lagi.";
    header("Location: ../profil.php");
    exit();
}
?>
