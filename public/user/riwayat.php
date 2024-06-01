<?php
require "../../src/config/config.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit;
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

$query = "SELECT pemesanan.*, film.judul, film.gambar, pemilihan_tiket.jam_tayang, pemilihan_tiket.tempat_duduk 
          FROM pemesanan 
          INNER JOIN film ON pemesanan.film_id = film.id
          INNER JOIN pemilihan_tiket ON pemesanan.id = pemilihan_tiket.pemesanan_id
          WHERE pemesanan.user_id = $user_id";
$result = mysqli_query($conn, $query);

// Check if there is any booking history
if ($result && mysqli_num_rows($result) > 0) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan Tiket</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>

<body>
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-8">Riwayat Pemesanan Tiket</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="max-w-sm rounded overflow-hidden shadow-lg transition-transform transform hover:scale-105">
                <img class="w-full" src="../../src/uploads/<?= $row['gambar'] ?>" alt="<?= $row['judul'] ?>">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2"><?= $row['judul'] ?></div>
                    <p class="text-gray-700 text-base"><?= $row['jumlah_tiket'] ?> Tiket</p>
                    <p class="text-gray-700 text-base">Total Harga: Rp. <?= number_format($row['total_harga'], 2) ?></p>
                    <p class="text-gray-700 text-base">Jam Tayang: <?= $row['jam_tayang'] ?></p>
                    <p class="text-gray-700 text-base">Tempat Duduk: <?= $row['tempat_duduk'] ?></p>
                    <p class="text-gray-700 text-base">Status: <?= ucfirst($row['status']) ?></p>
                    <div class="flex items-center mt-4">
                        <?php if ($row['status'] === 'belum_dibayar'): ?>
                            <button onclick="openPopup(<?= $row['id'] ?>)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-auto rounded-xl">Bayar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<!-- Popup -->
<div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-2xl font-bold mb-4">Opsi Pembayaran</h2>
        <form id="payment-form" method="POST" action="proses_pembayaran.php">
            <input type="hidden" id="pemesanan_id" name="pemesanan_id">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="metode_pembayaran">
                    Metode Pembayaran
                </label>
                <select id="metode_pembayaran" name="metode_pembayaran" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="updatePaymentFields()">
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="kartu_kredit">Kartu Kredit</option>
                    <option value="ewallet">E-Wallet</option>
                </select>
            </div>
            <div class="mb-4" id="payment-details"></div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <p class="text-gray-600 text-sm mt-2">Email Anda akan digunakan untuk mengirimkan bukti pembayaran.</p>
            </div>
            <div class="flex items-center justify-between">
                <button type="button" onclick="closePopup()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Bayar
                </button>
            </div>
        </form>
    </div>
</div>


<script>
function updatePaymentFields() {
    const paymentMethod = document.getElementById('metode_pembayaran').value;
    const paymentDetails = document.getElementById('payment-details');
    paymentDetails.innerHTML = '';

    if (paymentMethod === 'transfer') {
        paymentDetails.innerHTML = `
            <label class="block text-gray-700 text-sm font-bold mb-2" for="bank_transfer">
                Nomor Rekening Transfer Bank
            </label>
            <input type="text" id="bank_transfer" name="bank_transfer" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        `;
    } else if (paymentMethod === 'kartu_kredit') {
        paymentDetails.innerHTML = `
            <label class="block text-gray-700 text-sm font-bold mb-2" for="credit_card">
                Nomor Kartu Kredit
            </label>
            <input type="text" id="credit_card" name="credit_card" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        `;
    } else if (paymentMethod === 'ewallet') {
        paymentDetails.innerHTML = `
            <label class="block text-gray-700 text-sm font-bold mb-2" for="ewallet_number">
                Nomor E-Wallet
            </label>
            <input type="text" id="ewallet_number" name="ewallet_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        `;
    }
}

function openPopup(pemesananId) {
    document.getElementById('pemesanan_id').value = pemesananId;
    document.getElementById('popup').classList.remove('hidden');
}

function closePopup() {
    document.getElementById('popup').classList.add('hidden');
}
</script>
</body>

</html>
<?php
} else {
    // If no booking history
    echo "<div class='container mx-auto py-8'><h1 class='text-2xl font-bold mb-8'>Riwayat Pemesanan Tiket</h1><p>Belum ada riwayat pemesanan.</p></div>";
}
?>
