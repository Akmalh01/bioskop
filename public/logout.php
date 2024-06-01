<?php
// Mulai sesi untuk mengakses session
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Hapus semua cookie yang berhubungan dengan login
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/'); // Mengatur waktu kedaluwarsa ke masa lalu
}
if (isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600, '/'); // Mengatur waktu kedaluwarsa ke masa lalu
}

// Redirect ke halaman login atau halaman utama
header("Location: index.php");
exit();
?>
