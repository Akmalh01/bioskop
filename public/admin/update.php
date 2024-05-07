<?php
include '../../src/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirim dari form
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $durasi = $_POST['durasi'];
    $sutradara = $_POST['sutradara'];
    $sinopsis = $_POST['sinopsis'];
    $tanggal_rilis = $_POST['tanggal_rilis'];
    $harga_tiket = $_POST['harga_tiket'];

    // Proses upload gambar
    $target_dir = "../../src/uploads/"; // Folder tujuan untuk menyimpan gambar
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Periksa apakah file gambar valid
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if($check !== false) {
            echo "<script>alert('File is an image - " . $check["mime"] . "');</script>";
            $uploadOk = 1;
        } else {
            echo "<script>alert('File is not an image.');</script>";
            $uploadOk = 0;
        }
    }

    // Periksa apakah file gambar sudah ada
    if (file_exists($target_file)) {
        echo "<script>alert('Sorry, file already exists.');</script>";
        $uploadOk = 0;
    }

    // Periksa ukuran gambar
    if ($_FILES["gambar"]["size"] > 500000) {
        echo "<script>alert('Sorry, your file is too large.');</script>";
        $uploadOk = 0;
    }

    // Izinkan hanya beberapa format gambar tertentu
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        $uploadOk = 0;
    }

    // Cek jika upload berhasil
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.');</script>";
    } else {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            echo "<script>alert('The file ". htmlspecialchars( basename( $_FILES["gambar"]["name"])). " has been uploaded.');</script>";
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    }

    // Lakukan operasi UPDATE ke dalam database jika upload berhasil
    if ($uploadOk == 1) {
        // Lakukan operasi UPDATE ke dalam database
        $sql = "UPDATE film SET judul='$judul', genre='$genre', durasi='$durasi', sutradara='$sutradara', sinopsis='$sinopsis', tanggal_rilis='$tanggal_rilis', gambar='$target_file', harga_tiket='$harga_tiket' WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Data film berhasil diupdate."); window.location = "film.php"; </script>';
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "');</script>";
        }

        mysqli_close($conn);
    }
}
?>
