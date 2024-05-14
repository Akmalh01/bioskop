<?php
include 'config.php';

// Fungsi registrasi pengguna
function registerUser($nama, $email, $password) {
    global $conn;
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$hashed_password')";
    
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Registrasi berhasil. Silakan login."); window.location = "login.php";</script>';
    } else {
        echo '<script>alert("Registrasi gagal. Silakan coba lagi.");</script>';
    }
}

// Fungsi login pengguna
function loginUser($email, $password) {
    global $conn;
    
    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id']; // Simpan ID pengguna di session
            
            // Simpan beberapa data pengguna dalam cookie
            setcookie('user_id', $row['id'], time() + (86400 * 30), "/"); // Cookie berlaku selama 30 hari
            setcookie('user_email', $row['email'], time() + (86400 * 30), "/"); // Cookie berlaku selama 30 hari
            
            echo '<script>alert("Login berhasil"); window.location = "user/index.php";</script>';
        } else {
            echo "Login gagal. Silakan cek email dan password Anda.";
        }
    } else {
        echo "Login gagal. Pengguna tidak ditemukan.";
    }
}


// Fungsi login admin
function loginAdmin($username, $password) {
    global $conn;
    
    $sql = "SELECT * FROM admin WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            // Login berhasil, arahkan ke halaman admin
            session_start();
            $_SESSION['admin_id'] = $row['id']; // Simpan ID admin di session
            header("Location: index.php");
            exit;
        } else {
            echo "Login gagal. Silakan cek username dan password Anda.";
        }
    } else {
        echo "Login gagal. Admin tidak ditemukan.";
    }
}

function logoutAdmin() {
    session_start();
    // Hapus semua variabel session
    session_unset();
    // Hancurkan session
    session_destroy();
    // Redirect ke halaman login
    header("Location: login.php");
    exit;
}


?>
