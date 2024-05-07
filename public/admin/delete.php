<?php
// Periksa koneksi
include '../../src/config/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file gambar dari database
    $sql_select = "SELECT gambar FROM film WHERE id = $id";
    $result_select = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_assoc($result_select);
    $gambar = $row['gambar'];

    // Query untuk menghapus produk berdasarkan ID
    $sql_delete = "DELETE FROM film WHERE id = $id";

    if (mysqli_query($conn, $sql_delete)) {
        // Hapus gambar dari folder uploads
        $file_path = "../../src/uploads/" . $gambar;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    // Tutup koneksi
    mysqli_close($conn);

    // Redirect kembali ke halaman utama setelah menghapus produk
    header("Location: crud.php");
    exit();
}
?>
