<?php
session_start();
include 'koneksi.php';
$fotoid = $_GET['fotoid'];
$userid = $_SESSION['userid'];

$ceksuka = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");

if (mysqli_num_rows($ceksuka) == 1) {
    while ($row = mysqli_fetch_array($ceksuka)) {
        $likeid = $row['likeid'];
        $query = mysqli_query($conn, "DELETE FROM likefoto WHERE likeid='$likeid'");
    }
}

$cekdislike = mysqli_query($conn, "SELECT * FROM dislikefoto WHERE fotoid='$fotoid' AND userid='$userid'");

if (mysqli_num_rows($cekdislike) == 1) {
    while ($row = mysqli_fetch_array($cekdislike)) {
        $dislikeid = $row['dislikeid'];
        $query = mysqli_query($conn, "DELETE FROM dislikefoto WHERE dislikeid='$dislikeid'");
    }
} else {
    $tanggaldislike = date('y-m-d');
    $query = mysqli_query($conn, "INSERT INTO dislikefoto VALUES('','$fotoid','$userid','$tanggaldislike')");
}

header("Location: ../dashboard.php");
exit();
?>
