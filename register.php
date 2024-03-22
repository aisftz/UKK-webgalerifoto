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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body class="bg-gray-300 font-[courier-new] leading-normal tracking-normal">

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

    <section class=" min-h-screen flex items-center justify-center font-serif">
        <!-- register container -->
        <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-2xl p-3 items-center mx-10 mt-10">
            <!-- form -->
            <div class="sm:w-1/2 w-80 px-5 sm:px-10">
                <h2 class="text-3xl text-center font-semibold mb-2 uppercase  text-[#2277ff]">Register</h2>
                <form method="post" action="proses/prosesregister.php" class="flex flex-col">
                    <label class="" for="username">
                        <span class="block text-slate-700">Username</span>
                        <input type="text" id="username" name="username" placeholder="masukkan username..." class="px-3 mb-2 py-2 border shadow-sm rounded-xl w-full block text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required />
                    </label>
                    <label class="" for="password">
                        <span class="block text-slate-700">Password</span>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="Masukkan password..." class="w-full px-3 mb-2 py-2 border shadow-sm rounded-xl block text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required />
                            <span id="toggleButton" class="absolute right-3 top-1/2 -translate-y-1/2">
                                <i id="eyeIcon" class="fas fa-eye text-gray-500 cursor-pointer"></i>
                            </span>
                        </div>
                    </label>
                    <label for="email">
                        <span class="block mb-1 text-slate-700">Email</span>
                        <input type="email" id="email" name="email" placeholder="masukkan email..." class="px-3 mb-2 py-2 border shadow-sm rounded-xl w-full block text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required />
                    </label>
                    <label for="namalengkap">
                        <span class="block mb-1 text-slate-700">Nama Lengkap</span>
                        <input type="text" id="namalengkap" name="namalengkap" placeholder="masukkan Nama Lengkap..." class="px-3 mb-2 py-2 border shadow-sm rounded-xl w-full block text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required />
                    </label>
                    <label for="alamat">
                        <span class="block text-slate-700">Alamat</span>
                        <input type="text" id="alamat" name="alamat" placeholder="masukkan Alamat..." class="px-3 mb-5 py-2 border shadow-sm rounded-xl w-full block text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required />
                    </label>
                    <button type="submit" name="kirim" class="bg-[#2277ff] rounded-xl text-white text-center py-2 hover:bg-[#2067da] hover:scale-105 duration-300">Daftar</button>
                </form>

                <div class="mt-3 grid items-center text-gray-500">
                    <hr class="border-gray-400">
                </div>

                <div class="text-center">
                    <p class="mt-2 text-xs">Sudah punya akun?<a href="login.php" class="mt-3 text-xs text-sky-600 cursor-pointer hover:underline hover:text-sky-800"> Login disini</a></p>
                </div>

            </div>
            <!-- image -->
            <div class="sm:block hidden w-1/2">
                <img class="rounded-2xl" src="https://images.pexels.com/photos/9628161/pexels-photo-9628161.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
            </div>
        </div>
    </section>

    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UKK RPL 2024 | Nurhabibah Syafitri</p>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        const toggleButton = document.getElementById('toggleButton');
        const eyeIcon = document.getElementById('eyeIcon');

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
    });
    </script>

    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
