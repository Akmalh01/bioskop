<?php
// Periksa koneksi
include '../../src/config/config.php';

// Query untuk mengambil data dari tabel film
$sql = "SELECT * FROM film";
$result = mysqli_query($conn, $sql);

// Ambil semua baris data
$films = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Bebaskan hasil kueri
mysqli_free_result($result);

// Tutup koneksi
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../src/css/output.css">

</head>

<body>

    <?php include '../../src/components/navbar.php'; ?>

    <div class="relative overflow-x-auto shadow-md mr-6 ml-6 sm:rounded-lg mt-10">
        <div class="flex justify-between items-center mb-4">
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal">
                Add Product
            </button>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-white  uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Judul
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Genre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Durasi (menit)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Sutradara
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Details
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Rilis
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Harga Tiket
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Change
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Delete
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($films as $film) : ?>
                    <tr class='odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700'>
                        <th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>
                            <?= $film['judul'] ?></th>
                        <td class='px-6 py-4'><?= $film['genre'] ?></td>
                        <td class='px-6 py-4'><?= $film['durasi'] ?> Menit</td>
                        <td class='px-6 py-4'><?= $film['sutradara'] ?></td>
                        <td class='px-6 py-4'><button class="details-btn" data-sinopsis="<?= $film['sinopsis'] ?>" data-gambar="<?= $film['gambar'] ?>">Details</button></td>
                        <td class='px-6 py-4'><?= $film['tanggal_rilis'] ?></td>
                        <td class='px-6 py-4'>Rp <?= number_format($film['harga_tiket'], 0, ',', '.') ?></td>
                        <td class='px-6 py-4'>
                            <button class='font-medium text-blue-600 hover:underline edit-btn' data-id="<?= $film['id'] ?>">
                                Edit
                            </button>
                        </td>

                        <td class='px-6 py-4'>
                            <a href='delete.php?id=<?= $film['id'] ?>' class='font-medium text-red-700 hover:underline' onclick="return confirm('Apakah Anda yakin ingin menghapus film ini?')">Delete</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50 hidden" id="popup">
        <div class="flex items-center justify-start">
            <img id="popup-image" src="" alt="" class="w-32 h-auto mr-4 rounded-lg shadow-md">
            <div class="overflow-auto max-h-60">
                <p id="popup-sinopsis" class="text-gray-800 leading-normal"></p>
            </div>
        </div>
    </div>



    <!-- Create modal -->
    <div id="createProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Product</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-target="createProductModal" data-modal-toggle="createProductModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="save_film.php" method="POST" enctype="multipart/form-data">
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
                            <input type="text" name="judul" id="judul" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan judul film" required="">
                        </div>
                        <div>
                            <label for="genre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Genre</label>
                            <input type="text" name="genre" id="genre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan genre film" required="">
                        </div>
                        <div>
                            <label for="durasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Durasi
                                (menit)</label>
                            <input type="number" name="durasi" id="durasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Durasi film dalam menit" required="">
                        </div>
                        <div>
                            <label for="sutradara" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sutradara</label>
                            <input type="text" name="sutradara" id="sutradara" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan nama sutradara" required="">
                        </div>
                        <div>
                            <label for="sinopsis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sinopsis</label>
                            <textarea name="sinopsis" id="sinopsis" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tulis sinopsis film di sini"></textarea>
                        </div>
                        <div>
                            <label for="tanggal_rilis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                Rilis</label>
                            <input type="date" name="tanggal_rilis" id="tanggal_rilis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                        </div>
                        <div>
                            <label for="gambar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar</label>
                            <input type="file" name="gambar" id="gambar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                        </div>
                        <div>
                            <label for="harga_tiket" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga Tiket</label>
                            <input type="number" name="harga_tiket" id="harga_tiket" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Harga tiket film" required="">
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-700 dark:hover:bg-blue-500 dark:focus:ring-gray-500">
                        <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambahkan film baru
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal untuk Update -->
    <div id="updateModal" class="fixed inset-0 z-50 hidden overflow-auto bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <!-- Tempat untuk menampilkan form update -->
            <div id="updateFormContainer"></div>
            <button id="closeUpdateModal" class="mt-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Close</button>
        </div>
    </div>


    <script>
        const detailsButtons = document.querySelectorAll(".details-btn");
        const popup = document.getElementById("popup");
        const popupSinopsis = document.getElementById("popup-sinopsis");
        const popupImage = document.getElementById("popup-image");

        detailsButtons.forEach(button => {
            button.addEventListener("click", () => {
                const sinopsis = button.getAttribute("data-sinopsis");
                const gambar = button.getAttribute("data-gambar");

                popupSinopsis.textContent = sinopsis;
                popupImage.src = gambar;

                popup.style.display = "block";
            });
        });

        popup.addEventListener("click", (event) => {
            if (event.target === popup) {
                popup.style.display = "none";
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
        const editButtons = document.querySelectorAll(".edit-btn");
        const updateFormContainer = document.getElementById("updateFormContainer");
        const updateModal = document.getElementById("updateModal");
        const closeUpdateModal = document.getElementById("closeUpdateModal");

        editButtons.forEach(button => {
            button.addEventListener("click", function () {
                const filmId = button.getAttribute("data-id");
                // Memuat form update ke dalam modal menggunakan AJAX
                const xhr = new XMLHttpRequest();
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        updateFormContainer.innerHTML = xhr.responseText;
                        updateModal.classList.remove("hidden");
                    }
                };
                xhr.open("GET", `update.php?id=${filmId}`, true);
                xhr.send();
            });
        });

        closeUpdateModal.addEventListener("click", function () {
            updateModal.classList.add("hidden");
        });
    });
    </script>
    <script src="../../node_modules/flowbite/dist/flowbite.min.js"></script>

</body>

</html>