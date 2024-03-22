<?php
session_start();
include 'koneksi.php';

$username   =   $_POST['username'];
$password   =   $_POST['password'];

$sql    =   mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password' ");

$cek    =   mysqli_num_rows($sql);

if ($cek > 0) {
    $data   =   mysqli_fetch_array($sql);
    
    $_SESSION['username'] = $data['username'];
    $_SESSION['userid'] = $data['userid'];
        header("Location: ../dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah. Silakan coba lagi.";
        include('../login.php');
    }


?>

<script>
    setTimeout(function() {
        window.location.href = '../login.php';
    }, 3000);
</script>
