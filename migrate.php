<?php
$koneksi = mysqli_connect("localhost", "root", "", "bioskop");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
    exit();
}

// tabel admin
$sqlAdmin = "CREATE TABLE IF NOT EXISTS admin (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role ENUM('admin', 'superadmin') NOT NULL
)";

// tabel film
$sqlFilm = "CREATE TABLE IF NOT EXISTS film (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(50) NOT NULL,
    genre VARCHAR(30) NOT NULL,
    durasi INT NOT NULL,
    sutradara VARCHAR(50) NOT NULL,
    sinopsis TEXT,
    tanggal_rilis DATE NOT NULL,
    gambar VARCHAR(100),
    harga_tiket DECIMAL(10, 2) NOT NULL
)";

// tabel user
$sqlUser = "CREATE TABLE IF NOT EXISTS user (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// tabel pemesanan
$sqlPemesanan = "CREATE TABLE IF NOT EXISTS pemesanan (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    film_id INT(6) UNSIGNED NOT NULL,
    jumlah_tiket INT NOT NULL,
    total_harga DECIMAL(10, 2) NOT NULL,
    tanggal_pemesanan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('dibayar', 'belum_dibayar') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (film_id) REFERENCES film(id)
)";

// tabel pemilihan tiket
$pemilihanTiket = "CREATE TABLE IF NOT EXISTS pemilihan_tiket (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pemesanan_id INT(6) UNSIGNED NOT NULL,
    jam_tayang TIME NOT NULL,
    tempat_duduk VARCHAR(10) NOT NULL,
    FOREIGN KEY (pemesanan_id) REFERENCES pemesanan(id)
)";

if (mysqli_query($koneksi, $sqlAdmin)) {
    echo "Tabel 'admin' berhasil dibuat\n";
} else {
    echo "Error: " . $sqlAdmin . "<br>" . mysqli_error($koneksi);
}

if (mysqli_query($koneksi, $sqlFilm)) {
    echo "Tabel 'film' berhasil dibuat\n";
} else {
    echo "Error: " . $sqlFilm . "<br>" . mysqli_error($koneksi);
}

if (mysqli_query($koneksi, $sqlUser)) {
    echo "Tabel 'user' berhasil dibuat\n";
} else {
    echo "Error: " . $sqlUser . "<br>" . mysqli_error($koneksi);
}

if (mysqli_query($koneksi, $sqlPemesanan)) {
    echo "Tabel 'pemesanan' berhasil dibuat\n";
} else {
    echo "Error: " . $sqlPemesanan . "<br>" . mysqli_error($koneksi);
}

if ($conn->query($pemilihanTiket) === TRUE) {
    echo "Tabel pemilihan_tiket berhasil dibuat";
} else {
    echo "Error membuat tabel: " . $conn->error;
}

// Tutup koneksi
mysqli_close($koneksi);
?>
