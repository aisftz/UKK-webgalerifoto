<?php 
session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $namaalbum  = $_POST['namaalbum'];
    $deskripsi  = $_POST['deskripsi'];
    $tanggal    = date('y-m-d');
    $userid     = $_SESSION['userid'];

    $sql = mysqli_query($conn, "INSERT INTO album VALUES('','$namaalbum','$deskripsi','$tanggal','$userid')");

    $_SESSION['notiftambah'] = 'Album berhasil ditambahkan!';
    header('Location: ../album.php');
    exit();
}


if (isset($_POST['edit'])) {
    $albumid    = $_POST['albumid'];
    $namaalbum  = $_POST['namaalbum'];
    $deskripsi  = $_POST['deskripsi'];
    $tanggal    = date('y-m-d');
    $userid     = $_SESSION['userid'];

    $sql = mysqli_query($conn, "UPDATE album SET namaalbum='$namaalbum', deskripsi='$deskripsi', tanggalbuat='$tanggal' WHERE albumid='$albumid'");

    $_SESSION['notifedit'] = 'Album berhasil diperbarui!';
    header('Location: ../album.php');
    exit();
}

if (isset($_POST['hapus'])) {
    $albumid = $_POST['albumid'];

    $sql = mysqli_query($conn, "DELETE FROM album WHERE albumid='$albumid'");

    $_SESSION['notifhapus'] = 'Album berhasil dihapus!';
    header('Location: ../album.php');
    exit();
}
?>