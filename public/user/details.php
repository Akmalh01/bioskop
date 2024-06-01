<?php
require '../../src/config/config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM film WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="col-span-1 lg:col-span-1">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900"><?= $data['judul'] ?></h2>
                <p class="mt-1 text-sm text-gray-500">Genre: <?= $data['genre'] ?></p>
                <p class="mt-1 text-sm text-gray-500">Durasi: <?= $data['durasi'] ?> Menit</p>
                <p class="mt-1 text-sm text-gray-500">Sutradara: <?= $data['sutradara'] ?></p>
                <p class="mt-1 text-sm text-gray-500">Sinopsis: <?= $data['sinopsis'] ?></p>
                <p class="mt-1 text-sm text-gray-500">Tanggal Rilis: <?= $data['tanggal_rilis'] ?></p>
                <p class="mt-1 text-sm text-gray-500">Harga Tiket: Rp. <?= number_format($data['harga_tiket'], 2) ?></p>
                <a href="purchase.php?id=<?= $data['id'] ?>" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md">
                    Pesan Tiket
                </a>
            </div>
            <div class="col-span-1 lg:col-span-1">
                <img src="../../src/uploads/<?= $data['gambar'] ?>" alt="Title" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
            </div>
        </div>
        </body>
        </html>
<?php
    } else {
        echo "Film tidak ditemukan.";
    }
} else {
    echo "ID tidak diberikan.";
}
?>
