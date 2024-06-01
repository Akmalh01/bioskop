<?php
session_start();
require '../../src/config/config.php';

// Pengecekan apakah pengguna sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bioskop</title>
    <link rel="stylesheet" href="../../src/css/output.css">
</head>
<style>
    .hidden {
        display: none;
    }

    .bg-smoke-light {
        background-color: rgba(0, 0, 0, 0.5);
    }
</style>

<body>
    <?php require '../../src/config/config.php'; ?>
    <nav class="bg-transparent p-3 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Cinema_XXI.svg/2560px-Cinema_XXI.svg.png" alt="Logo Bioskop XYZ" class="h-8">
            <div class="flex space-x-3">
                <a href="riwayat.php" class="text-black hover:text-purple-300 px-2 py-2 rounded-md text-xs font-medium transition duration-200 ease-in-out transform hover:scale-105">Pembelian</a>
                <a href="../logout.php" class="text-red-700 hover:text-red-500 px-2 py-2 rounded-md text-xs font-medium transition duration-200 ease-in-out transform hover:scale-105">Logout</a>
            </div>
        </div>
    </nav>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:max-w-full lg:px-8">
            <div class="flex justify-between">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Daftar Film</h2>
                <div class="mb-3">
                    <div class="flex gap-4">
                        <form action="search.php" method="GET">
                            <input type="text" id="keyword" name="keyword" placeholder="Search" class="transition-all ease-in-out duration-700 hover:border hover:px-3 hover:rounded-full hover:border-black hover:w-60">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <?php
                $ambil = mysqli_query($conn, "SELECT * FROM film");

                foreach ($ambil as $data) :
                ?>
                    <!-- produk -->
                    <div class="group relative">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                            <img src="../../src/uploads/<?= $data['gambar'] ?>" alt="Title" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <?= $data['judul'] ?>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">Durasi: <?= $data['durasi'] ?> Menit</p>
                            </div>
                            <div class="flex flex-col gap-2">
                                <p class="text-sm text-right font-medium text-gray-900">Rp. <?= number_format($data['harga_tiket'])  ?></p>
                                <button onclick="openModal(<?= $data['id'] ?>)" class="w-40 h-8 bg-gray-300 rounded-md flex justify-center items-center">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <span>Details</span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div id="modal" class="hidden fixed inset-0 z-50 overflow-auto bg-smoke-light flex">
        <div class="relative p-8 bg-white w-full max-w-md m-auto flex-col flex rounded-lg">
            <button onclick="closeModal()" class="absolute top-0 right-0 p-2">
                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M18 6L6 18M6 6l12 12" />
                </svg>
            </button>
            <div id="modal-content">
                <!-- Details will be loaded here -->
            </div>
        </div>
    </div>
    <script>
        function openModal(id) {
            fetch(`details.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('modal-content').innerHTML = data;
                    document.getElementById('modal').classList.remove('hidden');
                });
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</body>

</html>
