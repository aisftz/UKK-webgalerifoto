<?php
session_start();
include('proses/koneksi.php');
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Anda belum login. Silakan login terlebih dahulu.');
            window.location.href = 'index.php';
          </script>";
    exit();
}

$username = $_SESSION['username'];

$userQuery = "SELECT * FROM user WHERE username='$username'";
$result = $conn->query($userQuery);
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $namalengkap = $user['namalengkap'];
    $email = $user['email'];
} else {
    $namalengkap = "Guest";
    $email = "";
}

$userid = $_SESSION['userid'];
$sql_album_dropdown = mysqli_query($conn, "SELECT * FROM album");
$albums_dropdown = mysqli_fetch_all($sql_album_dropdown, MYSQLI_ASSOC);

$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    $query = mysqli_query($conn, "SELECT * FROM foto WHERE judulfoto LIKE '%$search%'");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Nurhabibah">
    <title>Web galeri poto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-300 font-[courier-new]">

    <nav class="bg-white p-2 px-5 h-16 fixed top-0 z-10 w-screen">
        <div class="items-center flex justify-between h-12">
            <a class="flex items-center" href="dashboard.php">
                <img src="img/Batman-Logo.png" class="h-7 w-7" alt="">
                <span class="text-[#2277ff] text-2xl font-semibold ml-2 hidden sm:block">Web Galeri Foto</span>
            </a>
            <div class="relative">
                <form method="GET" action="" class="mb-4">
                    <input class="border-2 border-gray-500 bg-white h-8 px-5 pr-10 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 md:w-[22rem]" type="search" name="search" placeholder="Cari sesuatu...">
                    <button type="submit" class="absolute right-4 mt-2 mr-4 -translate-y-1/2">
                        <i class="fas fa-search absolute transform text-gray-500"></i>
                    </button>
                </form>
            </div>
            <div class="hidden sm:block sm:flex items-center space-x-4  text-gray-500">
                <div class="relative outline-block">
                    <button id="dropdownBtn1" class="bg-white rounded-full text-gray-500 text-xl">
                        <span class="">Album</span>
                    </button>
                    <div id="dropdownMenu1" class="hidden absolute right-0 w-48 bg-gray-900 border rounded-md shadow-lg mt-1 py-2 overflow-auto z-30">
                        <a href="album.php" class="block px-4 py-2 text-sm hover:bg-gray-800 text-white transition duration-300">
                            <span>+ Tambah Album</span>
                        </a>
                        <?php
                        $album = mysqli_query($conn, "SELECT * FROM album");
                        while($row = mysqli_fetch_array($album)) { ?>
                            <a href="dashboard.php?albumid=<?php echo $row['albumid'] ?>" class="block px-4 py-2 text-sm hover:bg-gray-800 text-white transition duration-300">
                                <?php echo $row['namaalbum'] ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <a href="foto.php" class="nav-link text-xl hover:underline hover:text-gray-700">Foto</a>
                <div class="relative outline-block">
                    <button id="dropdownBtn" class="bg-white rounded-full text-gray-500 text-xl">
                        <span class="">
                            <?php echo $username; ?>
                        </span>
                        <i class="fa-solid fa-chevron-down text-lg mr-5"></i>
                    </button>
                    <div id="dropdownMenu" class="hidden absolute right-0 w-48 bg-gray-900 border rounded-md shadow-lg mt-1 p-3 overflow-auto z-30">
                        <a href="profil.php" class="block px-4 py-2 text-sm hover:bg-gray-800 text-white transition duration-300">
                            <i class="fa-solid fa-user mr-4"></i>
                            <span>Profile</span>
                        </a>
                        <!-- <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-800 text-white transition duration-300">
                            <i class="fa-solid fa-gear mr-4"></i>
                            <span >Setting</span>
                        </a> -->
                        <a href="proses/logout.php" class="block px-4 py-2 text-sm hover:bg-gray-800 text-white transition duration-300">
                            <i class="fas fa-sign-out-alt mr-4"></i>
                            <span >Log Out</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="sm:hidden flex items-center">
                <button id="burger-icon" class="focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>
    
    <div id="responsive-nav" class="max-w-screen md:hidden fixed inset-0 h-[330px] z-50 bg-gray-100 hidden">
        <div class="flex justify-end p-4 bg-[#2277ff]">
            <button id="close-btn" class="text-white fixed">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <nav class="flex flex-col space-y-4 -mt-10">
            <ul class="space-y-2 mt-8">
                <li class="px-4 py-2 pb-5 transition duration-300 bg-[#2277ff] text-white">
                    <div class="flex items-center">
                        <span class="font-bold text-2xl mb-3"><?php echo $namalengkap; ?></span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-xl"><?php echo $email; ?></span>
                    </div>
                </li>
                <li class="px-4 py-2 hover:bg-gray-400 hover:text-white transition duration-300">
                    <a href="album.php" class="flex items-center">
                        <span class="">Album</span>
                    </a>
                </li>
                <li class="px-4 py-2 hover:bg-gray-400 hover:text-white transition duration-300">
                    <a href="foto.php" class="flex items-center">
                        <span class="">Tambah Foto</span>
                    </a>
                </li>
                <li class="px-4 py-2 hover:bg-gray-400 hover:text-white transition duration-300">
                    <a href="profil.php" class="flex items-center">
                        <span class="">Profil</span>
                    </a>
                </li>
                <li class="px-4 py-2 hover:bg-gray-400 hover:text-white transition duration-300">
                    <a href="proses/logout.php" class="flex items-center">
                        <span class="">Log Out</span>
                    </a>
                </li>
                
            </ul>
        </nav>
    </div>

    <!-- Content -->
    <div class="container mt-24 mx-auto px-5 mb-9 sm:px-0 min-h-[25.55rem]">
        <!-- <div class="flex gap-5 items-center mb-6">
            <h1 class="text-3xl font-bold hidden sm:block">Albums:</h1>
            <div class="flex gap-2 overflow-auto">
                <?php
                $album = mysqli_query($conn, "SELECT * FROM album");
                while($row = mysqli_fetch_array($album)) { ?>
                    <a href="dashboard.php?albumid=<?php echo $row['albumid'] ?>" class="bg-blue-500 text-white px-4 py-2 rounded-full">
                        <?php echo $row['namaalbum'] ?>
                    </a>
                <?php } ?>
            </div>
        </div> -->

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php
            if (isset($_GET['albumid'])) {
                $albumid = $_GET['albumid'];
                $query = mysqli_query($conn, "SELECT foto.*, user.namalengkap FROM foto JOIN user ON foto.userid = user.userid WHERE foto.albumid='$albumid'");
                while($data = mysqli_fetch_array($query)){ ?>
                    <div class="col-span-1 md:col-span-1 lg:col-span-1 mt-4">
                        <a href="#" onclick="document.getElementById('komentar<?php echo $data['fotoid'] ?>').style.display = 'block'">
                            <div class="card">
                                <img style="height: 12rem;" src="assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top object-cover w-full h-48" title="<?php echo $data['judulfoto'] ?>">
                                <div class="text-center bg-gray-100 p-4 flex justify-between">
                                    <div class="flex absolute">
                                        <div class="">
                                            <?php
                                                $fotoid = $data['fotoid'];
                                                $ceksuka = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                                $cekdislike = mysqli_query($conn, "SELECT * FROM dislikefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                                $likeCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'"));
                                                $likeCounty = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM dislikefoto WHERE fotoid='$fotoid'"));
                                            ?>
                                            <!-- Like -->
                                            <a href="proses/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" class="text-md mr-3  <?php echo (mysqli_num_rows($ceksuka) == 1) ? 'text-sky-500' : 'text-gray-500'; ?> focus:outline-none">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                                <span class="text-md text-black"><?php echo $likeCount ?></span>
                                            </a>
                                            <!-- Dislike -->
                                            <a href="proses/proses_dislike.php?fotoid=<?php echo $data['fotoid'] ?>" class="text-md mr-3 <?php echo (mysqli_num_rows($cekdislike) == 1) ? 'text-red-500' : 'text-gray-500'; ?> focus:outline-none">
                                                <i class="fa-solid fa-thumbs-down"></i>
                                                <span class="text-md text-black"><?php echo $likeCounty ?></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <a onclick="document.getElementById('komentar<?php echo $data['fotoid'] ?>').style.display = 'block'" class="text-gray-500 cursor-pointer"><i class="fa-solid fa-comment"></i> <?php
                                        $jmlkomen = mysqli_query($conn, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                                        echo mysqli_num_rows($jmlkomen) ;
                                        ?></a>
                                    </div>
                                    <!-- <a href="assets/img/<?php echo $data['lokasifile'] ?>" download="<?php echo $data['judulfoto'] ?>.jpg" class="text-gray-500" title="Download Photo">
                                        <i class="fa-solid fa-download"></i>
                                    </a> -->
                                </div>
                            </div>
                        </a>
                        <!-- pop-up -->
                        <div id="komentar<?php echo $data['fotoid'] ?>" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-40 hidden">
                            <div class="md:flex w-[100%] p-10 md:p-0 overflow-auto md:overflow-hidden md:items-center md:justify-center h-screen">
                                <div class="relative w-[100%] md:w-auto md:h-[28rem]">
                                    <img src="assets/img/<?php echo $data['lokasifile'] ?>" class="w-[100%] md:w-auto md:h-[28rem]" title="<?php echo $data['judulfoto'] ?>">
                                    <button onclick="document.getElementById('komentar<?php echo $data['fotoid'] ?>').style.display = 'none'" class="absolute text-gray-500 right-[1%] top-[1%] hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5 md:hidden "><i class="fas fa-times"></i></button>
                                </div>
                                <div class="bg-white p-3 md:w-[35%] w-[100%] md:h-[28rem]">
                                    <div class="relative hidden md:block">
                                        <button onclick="document.getElementById('komentar<?php echo $data['fotoid'] ?>').style.display = 'none'" class="absolute text-gray-500 right-0 top-0 hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5"><i class="fas fa-times"></i></button>
                                    </div>
                                    <h2 class="text-xl font-bold text-left top-5"><?php echo $data['judulfoto'] ?></h2>
                                    <hr class="my-2">
                                    <!-- Kolom Komentar -->  
                                    <div class="overflow-auto h-64">
                                        <?php
                                        $fotoid = $data['fotoid'];
                                        $userid = $_SESSION['userid'];
                                        $komentar = mysqli_query($conn, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE komentarfoto.fotoid='$fotoid'");
                                        while ($row = mysqli_fetch_array($komentar)) {
                                            ?>
                                            <div class="flex justify-between border p-2 rounded-lg bg-slate-200 mb-2 mr-2">
                                                <div class="w-full">
                                                    <p class="text-sm font-bold text-left -mb-1"><?php echo $row['namalengkap'] ?></p>
                                                    <div class="w-[85%]">
                                                        <p class="text-md text-left whitespace-pre-wrap mb-1"><?php echo $row['isikomentar'] ?></p>
                                                    </div>
                                                    <p class="text-xs text-gray-700 text-left"><?php echo $row['tanggalkomentar'] ?>
                                                        <?php
                                                        if ($row['userid'] == $userid) {
                                                            ?>
                                                            <a href="javascript:void(0)" onclick="showEditModal('<?php echo $row['komentarid']; ?>', '<?php echo $row['isikomentar']; ?>')" class="ml-5">Edit</a>
                                                            <a href="javascript:void(0)" onclick="showDeleteModal('<?php echo $row['komentarid']; ?>')" class="ml-5">Hapus</a>
                                                        <?php } ?>
                                                    </p>
                                                </div>
                                                <div class="mt-5 items-center relative">
                                                    <div class="absolute right-2 flex">
                                                        <?php
                                                        $komentarid = $row['komentarid'];
                                                        $ceksuka = mysqli_query($conn, "SELECT * FROM likekomen WHERE komentarid='$komentarid' AND userid='$userid'");
                                                        $likeCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likekomen WHERE komentarid='$komentarid'"));
                                                        ?>
                                                        <!-- Like Komen -->
                                                        <a href="proses/proses_likekomen.php?komentarid=<?php echo $row['komentarid'] ?>" class="text-sm mr-1 <?php echo (mysqli_num_rows($ceksuka) == 1) ? 'text-red-500' : 'text-gray-500'; ?> focus:outline-none flex">
                                                            <i class="fa-solid fa-heart mr-2"></i>
                                                            <span class=" text-sm"><?php echo $likeCount ?></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <hr class="my-1">
                                    <div class="">
                                        <div class="text-xs">
                                            <?php
                                                $fotoid = $data['fotoid'];
                                                $ceksuka = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                                $cekdislike = mysqli_query($conn, "SELECT * FROM dislikefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                                $likeCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'"));
                                                $likeCounty = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM dislikefoto WHERE fotoid='$fotoid'"));
                                            ?>
                                            <!-- Like -->
                                            <a href="proses/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" class="text-lg mr-3  <?php echo (mysqli_num_rows($ceksuka) == 1) ? 'text-sky-500' : 'text-gray-500'; ?> focus:outline-none">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                                <span class="text-lg text-black"><?php echo $likeCount ?></span>
                                            </a>
                                            <!-- Dislike -->
                                            <a href="proses/proses_dislike.php?fotoid=<?php echo $data['fotoid'] ?>" class="text-lg mr-3 <?php echo (mysqli_num_rows($cekdislike) == 1) ? 'text-red-500' : 'text-gray-500'; ?> focus:outline-none">
                                                <i class="fa-solid fa-thumbs-down"></i>
                                                <span class="text-lg text-black"><?php echo $likeCounty ?></span>
                                            </a>
                                        </div>
                                        <div class="flex">
                                            <p class="text-md font-bold text-left mr-3"><?php echo $data['namalengkap'] ?></p>
                                            <p class="text-md text-left"><?php echo $data['deskripsifoto'] ?></p>
                                        </div>
                                        <p class="text-xs text-left"><?php echo $data['tanggalunggah'] ?></p>
                                    </div>
                                    <div class="md:absolute md:w-[33%]">
                                        <form action="proses/proses_komentar.php" method="post">
                                            <input type="hidden" name="fotoid" value="<?php echo $data['fotoid']; ?>">
                                            <div class="relative flex justify-between -bottom-3 md:bottom-0 md:w-full">
                                                <input name="isikomentar" class="w-full border p-2 mb-4" placeholder="Tulis komentar">
                                                <button type="submit" class="bg-blue-500 text-white h-[42px] px-2">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                $query = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid");
                while($data = mysqli_fetch_array($query)) { ?>
                    <div class="col-span-1 md:col-span-1 lg:col-span-1 ">
                        <a onclick="document.getElementById('komentar<?php echo $data['fotoid'] ?>').style.display = 'block'" class="cursor-pointer">
                            <div class="card">
                                <img style="height: 12rem;" src="assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top object-cover w-full h-48" title="<?php echo $data['judulfoto'] ?>">
                                <div class="text-center bg-gray-100 p-4 flex justify-between">
                                    <div class="flex absolute">
                                        <div class="">
                                            <?php
                                                $fotoid = $data['fotoid'];
                                                $ceksuka = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                                $cekdislike = mysqli_query($conn, "SELECT * FROM dislikefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                                $likeCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'"));
                                                $likeCounty = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM dislikefoto WHERE fotoid='$fotoid'"));
                                            ?>
                                            <!-- Like -->
                                            <a href="proses/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" class="text-md mr-3  <?php echo (mysqli_num_rows($ceksuka) == 1) ? 'text-sky-500' : 'text-gray-500'; ?> focus:outline-none">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                                <span class="text-md text-black"><?php echo $likeCount ?></span>
                                            </a>
                                            <!-- Dislike -->
                                            <a href="proses/proses_dislike.php?fotoid=<?php echo $data['fotoid'] ?>" class="text-md mr-3 <?php echo (mysqli_num_rows($cekdislike) == 1) ? 'text-red-500' : 'text-gray-500'; ?> focus:outline-none">
                                                <i class="fa-solid fa-thumbs-down"></i>
                                                <span class="text-md text-black"><?php echo $likeCounty ?></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <a onclick="document.getElementById('komentar<?php echo $data['fotoid'] ?>').style.display = 'block'" class="text-gray-500 cursor-pointer"><i class="fa-solid fa-comment"></i> <?php
                                        $jmlkomen = mysqli_query($conn, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                                        echo mysqli_num_rows($jmlkomen) ;
                                        ?></a>
                                    </div>
                                    <!-- <a href="assets/img/<?php echo $data['lokasifile'] ?>" download="<?php echo $data['judulfoto'] ?>.jpg" class="text-gray-500" title="Download Photo">
                                        <i class="fa-solid fa-download"></i>
                                    </a> -->
                                </div>
                            </div>
                        </a>
                        <!-- popup -->
                        <div id="komentar<?php echo $data['fotoid'] ?>" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-40 hidden">
                            <div class="md:flex w-[100%] p-10 md:p-0 overflow-auto md:overflow-hidden md:items-center md:justify-center h-screen">
                                <div class="relative w-[100%] md:w-auto md:h-[28rem]">
                                    <img src="assets/img/<?php echo $data['lokasifile'] ?>" class="w-[100%] md:w-auto md:h-[28rem]" title="<?php echo $data['judulfoto'] ?>">
                                    <button onclick="document.getElementById('komentar<?php echo $data['fotoid'] ?>').style.display = 'none'" class="absolute text-gray-500 right-[1%] top-[1%] hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5 md:hidden "><i class="fas fa-times"></i></button>
                                </div>
                                <div class="bg-white p-3 md:w-[35%] w-[100%] md:h-[28rem]">
                                    <div class="relative hidden md:block">
                                        <button onclick="document.getElementById('komentar<?php echo $data['fotoid'] ?>').style.display = 'none'" class="absolute text-gray-500 right-0 top-0 hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5"><i class="fas fa-times"></i></button>
                                    </div>
                                    <h2 class="text-xl font-bold text-left top-5"><?php echo $data['judulfoto'] ?></h2>
                                    <hr class="my-2">
                                    <!-- Kolom Komentar -->  
                                    <div class="overflow-auto h-64">
                                        <?php
                                        $fotoid = $data['fotoid'];
                                        $userid = $_SESSION['userid'];
                                        $komentar = mysqli_query($conn, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE komentarfoto.fotoid='$fotoid'");
                                        while ($row = mysqli_fetch_array($komentar)) {
                                            ?>
                                            <div class="flex justify-between border p-2 rounded-lg bg-slate-200 mb-2 mr-2">
                                                <div class="w-full">
                                                    <p class="text-sm font-bold text-left -mb-1"><?php echo $row['namalengkap'] ?></p>
                                                    <div class="w-[85%]">
                                                        <p class="text-md text-left whitespace-pre-wrap mb-1"><?php echo $row['isikomentar'] ?></p>
                                                    </div>
                                                    <p class="text-xs text-gray-700 text-left"><?php echo $row['tanggalkomentar'] ?>
                                                        <?php
                                                        if ($row['userid'] == $userid) {
                                                            ?>
                                                            <a href="javascript:void(0)" onclick="showEditModal('<?php echo $row['komentarid']; ?>', '<?php echo $row['isikomentar']; ?>')" class="ml-5">Edit</a>
                                                            <a href="javascript:void(0)" onclick="showDeleteModal('<?php echo $row['komentarid']; ?>')" class="ml-5">Hapus</a>
                                                        <?php } ?>
                                                    </p>
                                                </div>
                                                <div class="mt-5 items-center relative">
                                                    <div class="absolute right-2 flex">
                                                        <?php
                                                        $komentarid = $row['komentarid'];
                                                        $ceksuka = mysqli_query($conn, "SELECT * FROM likekomen WHERE komentarid='$komentarid' AND userid='$userid'");
                                                        $likeCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likekomen WHERE komentarid='$komentarid'"));
                                                        ?>
                                                        <!-- Like Komen -->
                                                        <a href="proses/proses_likekomen.php?komentarid=<?php echo $row['komentarid'] ?>" class="text-sm mr-1 <?php echo (mysqli_num_rows($ceksuka) == 1) ? 'text-red-500' : 'text-gray-500'; ?> focus:outline-none flex">
                                                            <i class="fa-solid fa-heart mr-2"></i>
                                                            <span class=" text-sm"><?php echo $likeCount ?></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <hr class="my-1">
                                    <div class="">
                                        <div class="text-xs">
                                            <?php
                                                $fotoid = $data['fotoid'];
                                                $ceksuka = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                                $cekdislike = mysqli_query($conn, "SELECT * FROM dislikefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                                $likeCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'"));
                                                $likeCounty = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM dislikefoto WHERE fotoid='$fotoid'"));
                                            ?>
                                            <!-- Like -->
                                            <a href="proses/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" class="text-lg mr-3  <?php echo (mysqli_num_rows($ceksuka) == 1) ? 'text-sky-500' : 'text-gray-500'; ?> focus:outline-none">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                                <span class="text-lg text-black"><?php echo $likeCount ?></span>
                                            </a>
                                            <!-- Dislike -->
                                            <a href="proses/proses_dislike.php?fotoid=<?php echo $data['fotoid'] ?>" class="text-lg mr-3 <?php echo (mysqli_num_rows($cekdislike) == 1) ? 'text-red-500' : 'text-gray-500'; ?> focus:outline-none">
                                                <i class="fa-solid fa-thumbs-down"></i>
                                                <span class="text-lg text-black"><?php echo $likeCounty ?></span>
                                            </a>
                                        </div>
                                        <div class="flex">
                                            <p class="text-md font-bold text-left mr-3"><?php echo $data['namalengkap'] ?></p>
                                            <p class="text-md text-left"><?php echo $data['deskripsifoto'] ?></p>
                                        </div>
                                        <p class="text-xs text-left"><?php echo $data['tanggalunggah'] ?></p>
                                    </div>
                                    <div class="md:absolute md:w-[33%]">
                                        <form action="proses/proses_komentar.php" method="post">
                                            <input type="hidden" name="fotoid" value="<?php echo $data['fotoid']; ?>">
                                            <div class="relative flex justify-between -bottom-3 md:bottom-0 md:w-full">
                                                <input name="isikomentar" class="w-full border p-2 mb-4" placeholder="Tulis komentar">
                                                <button type="submit" class="bg-blue-500 text-white h-[42px] px-2">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
    
    <!-- Modal Edit Komentar -->
    <div id="editKomentarModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden">
        <div class="flex justify-center items-center h-screen ">
            <div class="bg-white p-5 rounded-lg w-96">
                <div class="flex justify-end mb-3">
                    <button onclick="document.getElementById('editKomentarModal').style.display = 'none'" class="text-gray-600 hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Edit Komen</h2>
                <form action="proses/proses_editkomen.php" method="post">
                    <input type="hidden" name="action" value="edit_comment">
                    <input type="hidden" id="editKomentarId" name="komentarid">
                    <textarea name="isikomentar" id="editKomentarText" class="w-full border p-2 mb-4"></textarea>
                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="bg-blue-500 text-white h-[42px] px-2 rounded-md hover:bg-blue-600 transition duration-300">Simpan</button>
                        <button type="button" onclick="document.getElementById('editKomentarModal').style.display = 'none'" class="bg-gray-500 text-white h-[42px] px-2 ml-2 rounded-md hover:bg-gray-600 transition duration-300">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Komentar -->
    <div id="deleteKomentarModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden">
        <div class="flex justify-center items-center h-screen">
            <div class="bg-white w-96 p-6 rounded-md">
                <div class="flex justify-end mb-3">
                    <button onclick="document.getElementById('deleteKomentarModal').style.display = 'none'" class="text-gray-600 hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Hapus Komentar</h2>
                <form action="proses/proses_hapuskomen.php" method="post">
                    <input type="hidden" name="action" value="delete_comment">
                    <input type="hidden" id="deleteKomentarId" name="komentarid">
                    <p>Apakah Anda yakin ingin menghapus komentar ini?</p>
                    <div class="flex justify-end space-x-4 mt-10">
                        <button type="submit" class="bg-red-500 text-white h-[42px] px-2 rounded-md hover:bg-red-600 transition duration-300"><i class="fas fa-trash-alt"></i> Hapus</button>
                        <button type="button" onclick="document.getElementById('deleteKomentarModal').style.display = 'none'" class="bg-gray-500 text-white h-[42px] px-2 ml-2 rounded-md hover:bg-gray-600 transition duration-300">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class=" w-full bg-blue-800 text-white py-4">
        <div class="container mx-auto flex flex-col items-center">
            <div class="flex space-x-4 mb-4">
                <a href="https://web.facebook.com/profile.php?id=100014738895482" class="text-gray-300 hover:text-white transition duration-300">
                    <i class="fab fa-facebook-square text-2xl"></i>
                </a>
                <a href="https://wa.me/6281991716036" class="text-gray-300 hover:text-white transition duration-300">
                    <i class="fab fa-whatsapp-square text-2xl"></i>
                </a>
                <a href="https://www.instagram.com/nuraisyaftri_/" class="text-gray-300 hover:text-white transition duration-300">
                    <i class="fab fa-instagram-square text-2xl"></i>
                </a>
            </div>
            <p class="text-sm ">&copy; UKK RPL 2024 | Nurhabibah Syafitri XII RPL 4</p>
        </div>
    </footer>

    <script>
        document.getElementById('dropdownBtn').addEventListener('click', function () {
            var dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('hidden');
        });
        document.getElementById('dropdownBtn1').addEventListener('click', function () {
            var dropdownMenu = document.getElementById('dropdownMenu1');
            dropdownMenu.classList.toggle('hidden');
        });

        const burgerIcon = document.getElementById('burger-icon');
        const responsiveNav = document.getElementById('responsive-nav');
        const closeBtn = document.getElementById('close-btn');

        burgerIcon.addEventListener('click', () => {
            responsiveNav.classList.toggle('hidden');
        });

        closeBtn.addEventListener('click', () => {
            responsiveNav.classList.add('hidden');
        });
        
        function showEditModal(komentarid, isikomentar) {
            document.getElementById('editKomentarId').value = komentarid;
            document.getElementById('editKomentarText').value = isikomentar;
            document.getElementById('editKomentarModal').style.display = 'block';
        }

        function showDeleteModal(komentarid) {
            document.getElementById('deleteKomentarId').value = komentarid;
            document.getElementById('deleteKomentarModal').style.display = 'block';
        }

    </script>
    
</body>
</html>

