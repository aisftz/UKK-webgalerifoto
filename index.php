<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Nurhabibah">
    <title>Website Galeri Foto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="src/style.css"> -->
</head>
<body class="bg-gray-300 font-sans leading-normal tracking-normal">

    <nav class="bg-white p-2 px-5 fixed top-0 z-50 w-screen">
        <div class="items-center flex justify-between">
            <a class="flex items-center" href="dashboard.php">
                <img src="img/Batman-Logo.png" class="h-7 w-7" alt="">
                <span class="text-[#2277ff] text-xl font-semibold ml-2 hidden sm:block">Web Galeri Foto</span>
            </a>
            <div class="flex justify-between mr-4">
                <a href="login.php"
                    class="bg-[#2277ff] mr-2 text-white px-4 py-1 rounded-full text-lg hover:bg-[#2067da] active:bg-[#1c5bc0] transition duration-300 btn">Masuk</a>
                <a href="register.php"
                    class="bg-gray-200 px-4 py-1 rounded-full text-lg hover:bg-gray-300 transition duration-300 btn">Daftar</a>
            </div>
        </div>

    </nav>

    <main class="flex-1 overflow-x-hidden overflow-y-auto">
        <div class="w-full relative m-auto">
        <!-- gallery -->
            <div class="mySlides fade">
                <div class="bg-black bg-opacity-50 text-white p-2 absolute bottom-0 w-full text-center">1 / 7</div>
                <img src="img/awan.jpg" class="w-full">
            </div>

            <div class="mySlides fade">
                <div class="bg-black bg-opacity-50 text-white p-2 absolute bottom-0 w-full text-center">2 / 7</div>
                <img src="img/sjw2.jpg" class="w-full">
            </div>

            <div class="mySlides fade">
                <div class="bg-black bg-opacity-50 text-white p-2 absolute bottom-0 w-full text-center">3 / 7</div>
                    <img src="img/sjw3.jpg" class="w-full">
                </div>
                    
                <div class="mySlides fade">
                    <div class="bg-black bg-opacity-50 text-white p-2 absolute bottom-0 w-full text-center">4 / 7</div>
                        <img src="img/sjw4.jpg" class="w-full" alt="">
                    </div>
                    
                    <div class="mySlides fade">
                        <div class="bg-black bg-opacity-50 text-white p-2 absolute bottom-0 w-full text-center">5 / 7</div>
                        <img src="img/sjw5.jpg" class="w-full">
                    </div>

                    <div class="mySlides fade">
                        <div class="bg-black bg-opacity-50 text-white p-2 absolute bottom-0 w-full text-center">6 / 7</div>
                        <img src="img/hae in1.jpg" class="w-full">
                    </div>

                    <div class="mySlides fade">
                        <div class="bg-black bg-opacity-50 text-white p-2 absolute bottom-0 w-full text-center">7 / 7</div>
                        <img src="img/hae in.jpg" class="w-full">
                    </div>

                    <a class="cursor-pointer absolute top-1/2 w-auto p-4 -mt-10 text-white font-bold text-xl transition duration-300 ease border-r-3 border-gray-200 rounded-r-sm hover:bg-[rgba(0,0,0,0.8)]" onclick="plusSlides(-1)">❮</a>
                    <a class="right-0 cursor-pointer absolute top-1/2 w-auto p-4 -mt-10 text-white font-bold text-xl transition duration-300 ease border-r-3 border-gray-200 rounded-l-sm hover:bg-[rgba(0,0,0,0.8)]" onclick="plusSlides(1)">❯</a>
                </div>

            </main>

    <script>
       let slideIndex = 1;
      showSlides(slideIndex);

      function plusSlides(n) {
        showSlides((slideIndex += n));
      }

      function currentSlide(n) {
        showSlides((slideIndex = n));
      }

      function showSlides(n) {
        let i;
        const slides = document.getElementsByClassName("mySlides");
        const dots = document.getElementsByClassName("dot");
        if (n > slides.length) {
          slideIndex = 1;
        }
        if (n < 1) {
          slideIndex = slides.length;
        }
        for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
          dots[i].classList.remove("bg-gray-900");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].classList.add("bg-gray-900");
      }

      // Fungsi untuk menjalankan slideshow otomatis
      function autoSlide() {
        plusSlides(1);
      }

      // Set interval untuk menjalankan fungsi autoSlide setiap 3 detik (atau sesuaikan dengan kebutuhan Anda)
      setInterval(autoSlide, 3000); // 3000 milidetik = 3 detik
    </script>

    <!-- <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UKK RPL 2024 | Nurhabibah Syafitri</p>
    </footer> -->


<!-- <script type="text/javascript" src="assets/js/bootstrap.min.js"></script> -->
</body>
</html>