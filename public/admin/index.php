<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
require '../../src/config/config.php';
// Ambil data statistik dari database
$queryUsers = "SELECT COUNT(*) AS total_users FROM user";
$querySales = "SELECT SUM(total_harga) AS total_sales FROM pemesanan WHERE status = 'dibayar'";
$queryOrders = "SELECT COUNT(*) AS total_orders FROM pemesanan";

$resultUsers = mysqli_query($conn, $queryUsers);
$resultSales = mysqli_query($conn, $querySales);
$resultOrders = mysqli_query($conn, $queryOrders);

$totalUsers = mysqli_fetch_assoc($resultUsers)['total_users'];
$totalSales = mysqli_fetch_assoc($resultSales)['total_sales'];
$totalOrders = mysqli_fetch_assoc($resultOrders)['total_orders'];

// Ambil data aktivitas terbaru dari database
$queryRecentActivities = "
    SELECT user.nama, pemesanan.tanggal_pemesanan, pemesanan.status
    FROM pemesanan 
    JOIN user ON pemesanan.user_id = user.id 
    ORDER BY pemesanan.tanggal_pemesanan DESC 
    LIMIT 5";

$resultRecentActivities = mysqli_query($conn, $queryRecentActivities);

// Tutup koneksi
mysqli_close($conn);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../src/css/output.css">
</head>
<body class="bg-gray-100">
    <?php include '../../src/components/navbar.php'; ?>

    <div class="flex">
        

        <!-- Main Content -->
        <div class="w-4/5 p-8">
            <h1 class="text-3xl font-bold mb-8">Welcome, Admin!</h1>
            <div class="grid grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-bold mb-2">Users</h2>
                    <p class="text-gray-700 text-lg">Total: <?php echo $totalUsers; ?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-bold mb-2">Sales</h2>
                    <p class="text-gray-700 text-lg">Total: Rp.<?php echo number_format($totalSales, 2); ?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-bold mb-2">Orders</h2>
                    <p class="text-gray-700 text-lg">Total: <?php echo $totalOrders; ?></p>
                </div>
            </div>
            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4">Recent Activities</h2>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <?php while($row = mysqli_fetch_assoc($resultRecentActivities)): ?>
                        <li class="py-4">
                            <p class="text-gray-700">User <strong><?php echo htmlspecialchars($row['nama']); ?></strong> placed an order.</p>
                            <span class="text-gray-500 text-sm"><?php echo htmlspecialchars($row['tanggal_pemesanan']); ?></span>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>