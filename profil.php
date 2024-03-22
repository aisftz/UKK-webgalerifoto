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
    $alamat = $user['alamat'];
} else {
    $namalengkap = "Guest";
    $email = "";
}

$userid = $_SESSION['userid'];
$sql_album_dropdown = mysqli_query($conn, "SELECT * FROM album");
$albums_dropdown = mysqli_fetch_all($sql_album_dropdown, MYSQLI_ASSOC);
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
                    <a href="profil.php" class="flex items-center">
                        <span class="">Profil</span>
                    </a>
                </li>
                <li class="px-4 py-2 hover:bg-gray-400 hover:text-white transition duration-300">
                    <a href="foto.php" class="flex items-center">
                        <span class="">Tambah Foto</span>
                    </a>
                </li>
                <li class="px-4 py-2 hover:bg-gray-400 hover:text-white transition duration-300">
                    <a href="album.php" class="flex items-center">
                        <span class="">Album</span>
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

    <?php
    if (isset($_SESSION['editberhasil'])) {
        echo '<div id="notif" class="bg-green-200 text-green-800 p-4 mb-4 rounded-md fixed top-16 z-50 w-screen">';
        echo $_SESSION['editberhasil'];
        echo '</div>';
        unset($_SESSION['editberhasil']);
    }

    if (isset($_SESSION['resetberhasil'])) {
        echo '<div id="notif" class="bg-green-200 text-green-800 p-4 mb-4 rounded-md fixed top-16 z-50 w-screen">';
        echo $_SESSION['resetberhasil'];
        echo '</div>';
        unset($_SESSION['resetberhasil']);
    }
    if (isset($_SESSION['reseterror'])) {
        echo '<div id="notif" class="bg-yellow-200 text-green-800 p-4 mb-4 rounded-md fixed top-16 z-50 w-screen">';
        echo $_SESSION['reseterror'];
        echo '</div>';
        unset($_SESSION['reseterror']);
    }
    if (isset($_SESSION['resetgagal'])) {
        echo '<div id="notif" class="bg-red-200 text-green-800 p-4 mb-4 rounded-md fixed top-16 z-50 w-screen">';
        echo $_SESSION['resetgagal'];
        echo '</div>';
        unset($_SESSION['resetgagal']);
    }
    ?>

    <!-- Content -->
    <div class="container mx-auto px-5 mb-9 sm:px-0 min-h-[25.55rem] mt-24">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold mb-4">Profil Pengguna</h1>
            <div class="border-t border-gray-200 mb-6"></div>
            <div class="mb-4">
                <label for="namalengkap" class="block text-gray-700 font-bold mb-2">Nama Lengkap:</label>
                <p id="namalengkap"><?php echo $namalengkap; ?></p>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Username:</label>
                <p id="email"><?php echo $username; ?></p>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <p id="email"><?php echo $email; ?></p>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Alamat:</label>
                <p id="email"><?php echo $alamat; ?></p>
            </div>
            <div class="mt-8 flex justify-between">
                <button id="editProfileBtn" class="bg-green-500 hover:bg-green-600 transition duration-300 text-white font-semibold py-2 px-4 rounded-md mr-4">Edit Profil</button>
                <button id="resetPasswordBtn" class="bg-red-500 hover:bg-red-600 transition duration-300 text-white font-semibold py-2 px-4 rounded-md">Reset Password</button>

            </div>
        </div>
    </div>
    
    <!-- Popup Edit Profil -->
    <div id="editProfileModal" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-75 flex justify-center items-center hidden inset-0 z-50">
        <div class="bg-white w-[25rem] md:w-1/2 rounded-lg shadow-md px-6 py-3">
            <div class="flex justify-end">
                <button id="closeEditProfileBtn" class="text-gray-600 hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <h1 class="text-3xl font-bold mb-4">Edit Profil Pengguna</h1>
            <div class="border-t border-gray-200 mb-6"></div>
            <form id="editProfileForm" action="proses/edit_profil.php" method="POST">
                <div class="mb-4">
                    <label for="editNamalengkap" class="block text-gray-700 font-bold mb-2">Nama Lengkap:</label>
                    <input type="text" id="editNamalengkap" name="editNamalengkap" value="<?php echo $namalengkap; ?>" class="p-2 w-full border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label for="editUsername" class="block text-gray-700 font-bold mb-2">Username:</label>
                    <input type="text" id="editUsername" name="editUsername" value="<?php echo $username; ?>" class="p-2 w-full border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label for="editEmail" class="block text-gray-700 font-bold mb-2">Email:</label>
                    <input type="email" id="editEmail" name="editEmail" value="<?php echo $email; ?>" class="p-2 w-full border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label for="editAlamat" class="block text-gray-700 font-bold mb-2">Alamat:</label>
                    <textarea id="editAlamat" name="editAlamat" class="p-2 w-full border rounded-md focus:outline-none focus:ring focus:ring-blue-200"><?php echo $alamat; ?></textarea>
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 transition duration-300 text-white font-semibold py-2 px-4 rounded-md mr-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popup Reset Password -->
    <div id="resetPasswordModal" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-75 flex justify-center items-center hidden inset-0 z-50">
        <div class="bg-white w-[25rem] md:w-1/3 rounded-lg shadow-md p-6">
            <div class="flex justify-end">
                <button id="closeResetPasswordBtn" class="text-gray-600 hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-bold mb-2">Reset Password</h2>
                <div class="border-t border-gray-200 mb-6"></div>
                <form action="proses/reset_password.php" method="POST">
                    <div class="mb-4">
                        <label for="oldPassword" class="block text-gray-700 font-bold mb-2">Password Lama:</label>
                        <input type="password" id="oldPassword" name="oldPassword" class="p-2 w-full border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                    </div>
                    <div class="mb-4">
                        <label for="newPassword" class="block text-gray-700 font-bold mb-2">Password Baru:</label>
                        <input type="password" id="newPassword" name="newPassword" class="p-2 w-full border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                    </div>
                    <div class="mb-4">
                        <label for="confirmNewPassword" class="block text-gray-700 font-bold mb-2">Konfirmasi Password Baru:</label>
                        <input type="password" id="confirmNewPassword" name="confirmNewPassword" class="p-2 w-full border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                    </div>
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 transition duration-300 text-white font-semibold py-2 px-4 rounded-md">Reset Password</button>
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
        
        // Script Edit Profil
        const editProfileBtn = document.getElementById('editProfileBtn');
        const editProfileModal = document.getElementById('editProfileModal');
        const closeEditProfileBtn = document.getElementById('closeEditProfileBtn');

        editProfileBtn.addEventListener('click', function() {
            editProfileModal.classList.remove('hidden');
        });

        closeEditProfileBtn.addEventListener('click', function() {
            editProfileModal.classList.add('hidden');
        });

        // Script Reset Password
        const resetPasswordBtn = document.getElementById('resetPasswordBtn');
        const resetPasswordModal = document.getElementById('resetPasswordModal');
        const closeResetPasswordBtn = document.getElementById('closeResetPasswordBtn');

        resetPasswordBtn.addEventListener('click', function() {
            resetPasswordModal.classList.remove('hidden');
        });

        closeResetPasswordBtn.addEventListener('click', function() {
            resetPasswordModal.classList.add('hidden');
        });

        setTimeout(function() {
            notif.style.display = 'none';
        }, 3000);

    </script>
    
</body>
</html>

