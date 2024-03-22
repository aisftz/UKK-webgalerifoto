<?php
include'koneksi.php'; 

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$namalengkap = $_POST['namalengkap'];
$alamat = $_POST['alamat'];


    $user = "SELECT * FROM user WHERE username='$username'";
    $cekuser = $conn->query($user);

    if ($cekuser->num_rows > 0) {
        echo "<script>
            alert('Username sudah digunakan. Silakan pilih username lain.');
            location.href='../register.php';
            </script>";
    } else {
        $sql = mysqli_query($conn, "INSERT INTO user VALUES ('', '$username', '$password', '$email', '$namalengkap', '$alamat')");
        if ($sql) {
            echo "<script>
            alert('Pendaftaran Akun Berhasil');
            location.href='../login.php';
            
            </script>";
        } else {
            echo "<script>
            alert('Registrasi Gagal. Silahkan Coba Lagi.');
            location.href='../register.php';
            
            </script>";
        }
    }
?>
