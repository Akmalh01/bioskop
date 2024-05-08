<?php
include '../../src/config/config.php';

// Jika form update disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $durasi = $_POST['durasi'];
    $sutradara = $_POST['sutradara'];
    $sinopsis = $_POST['sinopsis'];
    $tanggal_rilis = $_POST['tanggal_rilis'];
    $harga_tiket = $_POST['harga_tiket'];

    // Query untuk mengupdate data film berdasarkan ID
    $sql = "UPDATE film SET judul='$judul', genre='$genre', durasi='$durasi', sutradara='$sutradara', sinopsis='$sinopsis', tanggal_rilis='$tanggal_rilis', harga_tiket='$harga_tiket' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        // Jika update berhasil, redirect ke halaman utama
        header("Location: film.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Jika tidak disubmit secara langsung, maka ambil data dari database untuk ditampilkan pada form
$id = $_GET['id'];
$sql = "SELECT * FROM film WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$film = mysqli_fetch_assoc($result);

mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Film</title>
    <link rel="stylesheet" href="../../src/css/output.css">
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-center text-2xl font-semibold text-gray-800">Update Film</h2>
            <!-- Form Update -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" class="mt-8 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                <input type="hidden" name="id" value="<?php echo $film['id']; ?>">
                <!-- Kolom 1 -->
                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" name="judul" id="judul" value="<?php echo $film['judul']; ?>" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                    <input type="text" name="genre" id="genre" value="<?php echo $film['genre']; ?>" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="durasi" class="block text-sm font-medium text-gray-700">Durasi (menit)</label>
                    <input type="number" name="durasi" id="durasi" value="<?php echo $film['durasi']; ?>" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="sutradara" class="block text-sm font-medium text-gray-700">Sutradara</label>
                    <input type="text" name="sutradara" id="sutradara" value="<?php echo $film['sutradara']; ?>" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <!-- Kolom 2 -->
                <div>
                    <label for="sinopsis" class="block text-sm font-medium text-gray-700">Sinopsis</label>
                    <textarea name="sinopsis" id="sinopsis" rows="4" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"><?php echo $film['sinopsis']; ?></textarea>
                </div>
                <div>
                    <label for="tanggal_rilis" class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                    <input type="date" name="tanggal_rilis" id="tanggal_rilis" value="<?php echo $film['tanggal_rilis']; ?>" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <!-- <div>
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <input type="hidden" name="gambar">
                </div> -->
                <div>
                    <label for="harga_tiket" class="block text-sm font-medium text-gray-700">Harga Tiket</label>
                    <input type="number" name="harga_tiket" id="harga_tiket" value="<?php echo $film['harga_tiket']; ?>" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-blue-700">Update Film</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
