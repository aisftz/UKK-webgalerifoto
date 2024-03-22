<?php
include('proses/koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Nurhabibah">
    <title>Website Galeri Foto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body class="bg-gray-300 font-[courier-new]">

    <nav class="bg-white p-2 px-5 fixed top-0 z-50 w-screen flex">
        <div class="container mx-auto flex justify-between items-center">
            <a class="flex items-center" href="dashboard.php">
                <img src="img/Batman-Logo.png" class="h-7 w-7" alt="">
                <span class="text-[#2277ff] text-2xl font-semibold ml-2 hidden sm:block">Web Galeri Foto</span>
            </a>
        </div>
        <div class="flex justify-between mr-4">
            <a href="login.php"
                class="bg-[#2277ff] mr-2 text-white px-4 py-1 rounded-full text-lg hover:bg-[#2067da] active:bg-[#1c5bc0] transition duration-300 btn">Masuk</a>
            <a href="register.php"
                class="bg-gray-200 px-4 py-1 rounded-full text-lg hover:bg-gray-300 active:bg-gray-400 transition duration-300 btn">Daftar</a>
        </div>
    </nav>

    <section class="bg-gray-300 min-h-screen flex items-center justify-center font-serif">
        <!-- login container -->
        <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-2xl p-3 items-center mx-10 mt-10">
            <!-- form -->
            <div class="sm:w-1/2 w-80 px-5 sm:px-10">
                <h2 class="text-3xl text-center font-bold mb-5 uppercase  text-[#2277ff]">Login</h2>
                <?php
                if (isset($error)) {
                    echo '<div id="errorMessage" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">' . $error . '</div>';
                }
                ?>
                <form method="post" action="proses/proseslogin.php" class="flex flex-col">
                    <label class="mt-5" for="username">
                        <span class="block font-semibold mb-1 text-slate-700">Username</span>
                        <input type="text" id="username" name="username" placeholder="masukkan username..." class="px-3 mb-5 py-2 border shadow-md rounded-xl w-full block text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required/>
                    </label>
                    <label class="mb-5" for="password">
                        <span class="block font-semibold text-slate-700">Password</span>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="Masukkan password..." class="w-full px-3 py-2 border shadow-md rounded-xl w-full block text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required>
                            <span id="toggleButton" class="absolute right-3 top-1/2 -translate-y-1/2">
                                <i id="eyeIcon" class="fas fa-eye text-gray-500 cursor-pointer"></i>
                            </span>
                        </div>
                    </label>
                    <button type="submit" name="kirim" class="bg-[#2277ff] rounded-xl text-white text-center py-2 hover:bg-[#2067da] hover:scale-105 duration-300">Login</button>
                </form>

                <div class="mt-3 grid items-center text-gray-500">
                    <hr class="border-gray-400">
                </div>

                <div class="text-center">
                    <p class="mt-2 text-xs">Belum punya akun?<a href="register.php" class="text-xs text-sky-600 cursor-pointer hover:underline hover:text-sky-800"> daftar disini</a></p>
                </div>
            </div>
            <!-- image -->
            <div class="sm:block hidden w-1/2">
                <img class="rounded-2xl " src="https://images.pexels.com/photos/9628161/pexels-photo-9628161.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
            </div>
        </div>
    </section>

    <!-- <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UKK RPL 2024 | Nurhabibah Syafitri</p>
    </footer> -->

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        const toggleButton = document.getElementById('toggleButton');
        const eyeIcon = document.getElementById('eyeIcon');
        const errorMessage = document.getElementById('errorMessage');

        toggleButton.addEventListener('click', function() {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        setTimeout(function() {
            errorMessage.style.display = 'none';
        }, 3000);
    });
</script>


</body>
</html>
