<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
require '../../src/config/config.php';
// Ambil data pemesanan dari database
$queryOrders = "
    SELECT pemesanan.id, user.nama, film.judul, pemesanan.jumlah_tiket, pemesanan.total_harga, pemesanan.tanggal_pemesanan, pemesanan.status 
    FROM pemesanan 
    JOIN user ON pemesanan.user_id = user.id 
    JOIN film ON pemesanan.film_id = film.id 
    ORDER BY pemesanan.tanggal_pemesanan DESC";

$resultOrders = mysqli_query($conn, $queryOrders);

// Tutup koneksi
mysqli_close($conn);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Report</title>
    <link rel="stylesheet" href="../../src/css/output.css">
</head>
<body class="bg-gray-100">
    <?php include '../../src/components/navbar.php'; ?>

    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-8">Order Report</h1>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">Order ID</th>
                        <th class="py-2">User Name</th>
                        <th class="py-2">Film Title</th>
                        <th class="py-2">Tickets</th>
                        <th class="py-2">Total Price</th>
                        <th class="py-2">Order Date</th>
                        <th class="py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($resultOrders)): ?>
                    <tr class="bg-gray-100">
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($row['id']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($row['jumlah_tiket']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars(number_format($row['total_harga'], 2)); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($row['tanggal_pemesanan']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
