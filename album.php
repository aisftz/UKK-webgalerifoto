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
$sql_album_dropdown = mysqli_query($conn, "SELECT * FROM album WHERE userid='$userid'");
$albums_dropdown = mysqli_fetch_all($sql_album_dropdown, MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Nurhabibah">
    <title>Web galeri poto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
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
                <input
                    class="border-2 border-gray-500 bg-white h-8 px-5 pr-10 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 md:w-[22rem] "
                    type="search"
                    name="search"
                    placeholder="Cari sesuatu..."
                />
                <button type="submit" class="absolute right-4  mt-2 mr-4 -translate-y-1/2">
                    <i class="fas fa-search absolute  transform  text-gray-500"></i>
                </button>
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

    <?php
        if (isset($_SESSION['notiftambah'])) {
        echo '<div id="notif" class="bg-green-200 text-green-800 p-4 mb-4 rounded-md fixed top-16 z-50 w-screen">';
        echo $_SESSION['notiftambah'];
        echo '</div>';
        unset($_SESSION['notiftambah']);
    }
    if (isset($_SESSION['notifedit'])) {
        echo '<div id="notif" class="bg-yellow-200 text-green-800 p-4 mb-4 rounded-md fixed top-16 z-50 w-screen">';
        echo $_SESSION['notifedit'];
        echo '</div>';
        unset($_SESSION['notifedit']);
    }
    if (isset($_SESSION['notifhapus'])) {
        echo '<div id="notif" class="bg-red-200 text-green-800 p-4 mb-4 rounded-md fixed top-16 z-50 w-screen">';
        echo $_SESSION['notifhapus'];
        echo '</div>';
        unset($_SESSION['notifhapus']);
    }
    ?>

    <!-- content -->
    <div class="container mt-24 mx-auto px-5 mb-9 sm:px-0 min-h-[25.55rem]">
        <div class="flex justify-end mb-4">
            <a href="javascript:void(0);" onclick="openAddAlbumModal()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300">
                <i class="fas fa-plus"></i> Tambah Album
            </a>
        </div>

        <!-- Table -->
        <div class="mt-6">
            <h2 class="text-2xl font-semibold mb-4">Daftar Album</h2>
            <div class="overflow-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Album</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                            $no = 1;
                            $userid = $_SESSION['userid'];
                            $sql    = mysqli_query($conn, "SELECT * FROM album WHERE userid='$userid'");
                            while($data = mysqli_fetch_array($sql)){
                        ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $no++ ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $data['namaalbum'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $data['deskripsi'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $data['tanggalbuat'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="javascript:void(0);" onclick="openEditAlbumModal('<?php echo $data['albumid']; ?>', '<?php echo $data['namaalbum']; ?>', '<?php echo $data['deskripsi']; ?>')" class="bg-yellow-400 text-white rounded-md px-2 py-2 hover:bg-yellow-500 transition duration-300">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <span class="mx-1">|</span>
                                <a href="javascript:void(0);" onclick="openDeleteAlbumModal('<?php echo $data['albumid']; ?>')" class="bg-red-500 text-white px-2 py-2 rounded-md hover:bg-red-600 transition duration-300">
                                    <i class="fas fa-trash-alt"></i> 
                                </a> 
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tambah Album -->
    <div id="addAlbumModal" class="fixed inset-0 z-50 hidden overflow-auto bg-gray-500 bg-opacity-75">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white w-[25rem] md:w-1/2 p-6 rounded-md">
                <div class="flex justify-end">
                    <button onclick="closeAddAlbumModal()" class="text-gray-600 hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <h2 class="text-2xl font-semibold mb-4">Tambah Album</h2>
                    
                <form action="proses/crud-album.php" method="post" class="flex flex-col items-start">
                    <input type="hidden" name="albumid" id="albumid" value="">
                    <label for="namaalbum" class="block text-sm font-medium text-gray-600">Nama Album</label>
                    <input type="text" id="namaalbum" name="namaalbum" class="mt-1 p-2 border rounded-md w-full mb-4" required>

                    <label for="deskripsi" class="block text-sm font-medium text-gray-600">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" class="mt-1 p-2 border rounded-md w-full mb-4"></textarea>

                    <button type="submit" name="tambah" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 self-end transition duration-300">Tambah Album</button>
                </form>


            </div>
        </div>
    </div>


    <!-- Edit Album -->
    <div id="editAlbumModal" class="fixed inset-0 z-50 hidden overflow-auto bg-gray-500 bg-opacity-75">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white w-[25rem] md:w-1/2 p-6 rounded-md">
                <div class="flex justify-end">
                    <button onclick="closeEditAlbumModal()" class="text-gray-600 hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <h2 class="text-2xl font-semibold mb-4">Edit Album</h2>
                <form action="proses/crud-album.php" method="post" class="flex flex-col items-start">
                    <input type="hidden" id="editAlbumId" name="albumid">
                    <label for="editNamaAlbum" class="block text-sm font-medium text-gray-600">Nama Album</label>
                    <input type="text" id="editNamaAlbum" name="namaalbum" class="mt-1 p-2 border rounded-md w-full mb-4" required>

                    <label for="editDeskripsi" class="block text-sm font-medium text-gray-600">Deskripsi</label>
                    <textarea id="editDeskripsi" name="deskripsi" rows="3" class="mt-1 p-2 border rounded-md w-full mb-4"></textarea>

                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 self-end transition duration-300" name="edit">Edit Album</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Delete Album -->
     <div id="deleteAlbumModal" class="fixed inset-0 z-50 hidden bg-gray-500 bg-opacity-75 w-screen">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white w-96 p-6 rounded-md">
                <div class="flex justify-end">
                    <button onclick="closeDeleteAlbumModal()" class="text-gray-600 hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Hapus Album</h2>
                <form action="proses/crud-album.php" method="post">
                    <input type="hidden" id="deleteAlbumId" name="albumid">
                    <p class="text-gray-700 mb-4">Apakah Anda yakin ingin menghapus album ini?</p>
                    <div class="flex justify-end space-x-4">
                        <button onclick="deleteAlbum()" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300" name="hapus">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                        <button type="button" onclick="closeDeleteAlbumModal()" class="border border-gray-500 text-gray-600 px-4 py-2 rounded-md hover:bg-gray-100 transition duration-300">
                            Batal
                        </button>
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
        function openAddAlbumModal() {
            document.getElementById('addAlbumModal').classList.remove('hidden');
        }

        function closeAddAlbumModal() {
            document.getElementById('addAlbumModal').classList.add('hidden');
        }
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

        function openEditAlbumModal(albumid, namaalbum, deskripsi) {
            document.getElementById('editAlbumModal').classList.remove('hidden');
            document.getElementById('editAlbumId').value = albumid;
            document.getElementById('editNamaAlbum').value = namaalbum;
            document.getElementById('editDeskripsi').value = deskripsi;
        }

        function closeEditAlbumModal() {
            document.getElementById('editAlbumModal').classList.add('hidden');
        }

        function openDeleteAlbumModal(albumid) {
            document.getElementById('deleteAlbumModal').classList.remove('hidden');
            document.getElementById('deleteAlbumId').value = albumid;
        }

        function closeDeleteAlbumModal() {
            document.getElementById('deleteAlbumModal').classList.add('hidden');
        }

        function deleteAlbum() {
            closeDeleteAlbumModal();
        }

        setTimeout(function() {
            notif.style.display = 'none';
        }, 3000);


        
    </script>
</body>
</html>

