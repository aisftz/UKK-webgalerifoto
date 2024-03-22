<?php
session_start();
include 'koneksi.php';
$komentarid = $_GET['komentarid'];
$userid = $_SESSION['userid'];

$ceksuka = mysqli_query($conn, "SELECT * FROM likekomen WHERE komentarid='$komentarid' AND userid='$userid'");

if (mysqli_num_rows($ceksuka) == 1) {
    while($row = mysqli_fetch_array($ceksuka)) {
        $likekomenid = $row['likekomenid'];
        $query = mysqli_query($conn, "DELETE FROM likekomen WHERE likekomenid='$likekomenid'");
        echo "<script> 
        location.href='../dashboard.php';
        </script>";
     }
}else{
    $tanggallikekomen = date('y-m-d');
    $query = mysqli_query($conn,"INSERT INTO likekomen VALUES('','$komentarid','$userid','$tanggallikekomen')");

    echo "<script> 
    location.href='../dashboard.php';
    </script>";
    }


?>