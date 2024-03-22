<?php
include('koneksi.php');

$cari = $_GET['cari'];
$query = mysqli_query($conn, "SELECT * FROM foto WHERE judulfoto LIKE '%$cari%'");

if (mysqli_num_rows($query) > 0) {
    while ($data = mysqli_fetch_array($query)) {
        echo "<div class='col-span-1 md:col-span-1 lg:col-span-1'>
                <a href='#' onclick='document.getElementById(\"komentar$data[fotoid]\").style.display = \"block\"'>
                    <div class='card'>
                        <img style='height: 12rem;' src='assets/img/$data[lokasifile]' class='card-img-top object-cover w-full h-48' title='$data[judulfoto]'>
                        <div class='card-footer flex justify-between text-center bg-gray-100 p-4'>
                            <div>
                                <a href='proses_like.php?fotoid=$data[fotoid]' class='text-lg $likeClass focus:outline-none'>
                                    <i class='fa-solid fa-thumbs-up'></i>
                                </a>
                                <span class='ml-1 mr-2'>$likeCount</span>
                                <a href='proses/proses_dislike.php?fotoid=$data[fotoid]' class='text-lg $dislikeClass focus:outline-none'>
                                    <i class='fa-solid fa-thumbs-down'></i>
                                </a>
                                <span class='ml-1 mr-2'>$dislikeCount</span>
                            </div>
                            <div>
                                <a href='#' onclick='document.getElementById(\"komentar$data[fotoid]\").style.display = \"block\"' class='text-gray-500'><i class='fa-solid fa-comment'></i> $komentarCount Komentar</a>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- pop-up -->
                <div id='komentar$data[fotoid]' class='fixed inset-0 bg-gray-800 bg-opacity-50 z-40 hidden'>
                    <div class='md:flex w-[100%] p-10 md:p-0 overflow-auto md:overflow-hidden md:items-center md:justify-center h-screen'>
                        <div class='relative w-[100%] md:w-auto md:h-[28rem]'>
                            <img src='assets/img/$data[lokasifile]' class='w-[100%] md:w-auto md:h-[28rem]' title='$data[judulfoto]'>
                            <button onclick='document.getElementById(\"komentar$data[fotoid]\").style.display = \"none\"' class='absolute text-gray-500 right-[1%] top-[1%] hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5 md:hidden '><i class='fas fa-times'></i></button>
                        </div>
                        <div class='bg-white p-3 md:w-[35%] w-[100%] md:h-[28rem]'>
                            <div class='relative hidden md:block'>
                                <button onclick='document.getElementById(\"komentar$data[fotoid]\").style.display = \"none\"' class='absolute text-gray-500 right-0 top-0 hover:bg-opacity-30 transition duration-300 hover:text-black hover:bg-black w-5'><i class='fas fa-times'></i></button>
                            </div>
                           <h2 class='text-xl font-bold text-left top-5'>$data[judulfoto]</h2>
                            <hr class='my-2'>
                            <!-- Kolom Komentar -->
                            <div class='overflow-auto h-64'>";
                                $fotoid = $data['fotoid'];
                                $komentar = mysqli_query($conn, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE komentarfoto.fotoid='$fotoid'");
                                while ($row = mysqli_fetch_array($komentar)) {
                                    echo "<div class='flex justify-between border p-2 rounded-lg bg-slate-200 mb-2 mr-2'> 
                                            <div class='w-full'> 
                                                <p class='text-sm font-bold text-left -mb-1'>$row[namalengkap]</p>
                                                <div class=' w-[85%]'>
                                                    <p class='text-md text-left whitespace-pre-wrap mb-1'>$row[isikomentar]</p>
                                                </div>
                                                <p class='text-xs text-gray-700 text-left'>$row[tanggalkomentar]   <a href='#' class='ml-5'>Hapus</a></p>
                                            </div>
                                            <div class='mt-5 items-center relative'>
                                                <div class='absolute right-2 flex'>
                                                    $likeKomen
                                                </div>    
                                            </div>
                                          </div>";
                                }
                            echo "</div>
                            <hr class='my-1'>
                            <div class=''>
                                <div class='text-xs'>
                                    $like
                                    $dislike
                                </div>
                                <div class='flex'>
                                    <p class='text-md font-bold text-left mr-3'>$data[namalengkap]</p>
                                    <p class='text-md text-left'>$data[deskripsifoto]</p>
                                </div>
                                <p class='text-xs text-left'>$data[tanggalunggah]</p>
                            </div>
                            <div class='md:absolute md:w-[33%]'>
                                <form action='proses/proses_komentar.php' method='post'>
                                    <input type='hidden' name='fotoid' value='$data[fotoid]'>
                                    <div class='relative flex justify-between -bottom-3 md:bottom-0 md:w-full'>
                                        <input name='isikomentar' class='w-full border p-2 mb-4' placeholder='Tulis komentar'>
                                        <button type='submit' class='bg-blue-500 text-white h-[42px] px-2'>Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
    }
} else {
    echo "<div class='col-span-1 md:col-span-1 lg:col-span-1'>
            <div class='card'>
                <div class='card-body text-center'>
                    <h2 class='text-xl font-bold'>Tidak ada hasil pencarian</h2>
                </div>
            </div>
          </div>";
}
?>