<?php
// Pengecekan apakah cookie user_id dan user_email masih ada
if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_email'])) {
    // Jika cookie ada, arahkan ke halaman index.php di folder user
    header("Location: user/index.php");
    exit();
}
require '../src/config/config.php';
// Ambil data film yang sedang tayang dari database
$queryFilms = "SELECT id, judul, sinopsis, gambar FROM film WHERE tanggal_rilis <= CURDATE() ORDER BY tanggal_rilis DESC";
$resultFilms = mysqli_query($conn, $queryFilms);

// Tutup koneksi
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Bioskop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<style>
    .brand {
        font-family: "Sedan", serif;
        font-weight: 400;
        font-style: normal;
    }
</style>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gray-900 text-white">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="index.php" class="text-2xl font-bold brand">XXI</a>
            <nav class="space-x-6">
                <a href="index.php" class="hover:underline">Home</a>
                <a href="#now-playing" class="hover:underline">Now Playing</a>
                <a href="login.php" class="bg-blue-500 px-4 py-2 rounded-md text-white">Login</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-screen" style="background-image: url('../src/images/bg.png');">
        <div class="container mx-auto flex items-center justify-center h-full">
            <div class="text-center">
                <h1 class="text-5xl font-bold text-white mb-6 brand">Welcome to XXI</h1>
                <p class="text-lg text-gray-200 mb-6">Experience the best movies with the best quality.</p>
                <a href="#now-playing" class="bg-blue-500 text-white px-6 py-3 rounded-md text-lg font-medium">View Now Playing</a>
            </div>
        </div>
    </section>

    <!-- Now Playing Section -->
    <section id="now-playing" class="py-20 bg-white">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold text-gray-800 text-center mb-12">Sedang Tayang</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Movie Cards -->
                <?php while($row = mysqli_fetch_assoc($resultFilms)): ?>
                <div class="bg-white rounded-lg shadow-lg">
                    <img src="../src/uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Movie Poster" class="rounded-t-lg w-full h-80 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($row['judul']); ?></h3>
                        <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($row['sinopsis']); ?></p>
                        <a onclick="redirectToLogin()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Buy Ticket</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 DRAF Bioskop. All Rights Reserved.</p>
            <div class="mt-4">
                <a href="#" class="text-gray-400 hover:text-white mx-2">Facebook</a>
                <a href="#" class="text-gray-400 hover:text-white mx-2">Twitter</a>
                <a href="#" class="text-gray-400 hover:text-white mx-2">Instagram</a>
            </div>
        </div>
    </footer>
    <script>
        function redirectToLogin() {
            alert('Please login to buy a ticket.');
            window.location.href = 'login.php';
        }
    </script>
</body>

</html>
