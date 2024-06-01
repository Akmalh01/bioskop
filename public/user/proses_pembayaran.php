<?php
require "../../src/config/config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $pemesanan_id = intval($_POST['pemesanan_id']);
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $email = $_POST['email'];

    // Get booking details
    $query = "SELECT pemesanan.*, film.judul, film.harga_tiket
              FROM pemesanan
              INNER JOIN film ON pemesanan.film_id = film.id
              WHERE pemesanan.id = $pemesanan_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $pemesanan = mysqli_fetch_assoc($result);

        // Update payment status
        $update_query = "UPDATE pemesanan SET status = 'dibayar' WHERE id = $pemesanan_id";
        if (mysqli_query($conn, $update_query)) {
            // Send email confirmation
            require '../../vendor/PHPMailer/src/Exception.php';
            require '../../vendor/PHPMailer/src/PHPMailer.php';
            require '../../vendor/PHPMailer/src/SMTP.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Ganti dengan host SMTP Anda
                $mail->SMTPAuth = true;
                $mail->Username = 'drafbioskop@gmail.com'; // Ganti dengan username SMTP Anda
                $mail->Password = 'kzrmivsbkkcbferp'; // Ganti dengan password SMTP Anda
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('your_email@example.com', 'Bioskop DRAF');
                $mail->addAddress($email);

                 // Content
                 $mail->isHTML(true);
                 $mail->Subject = 'Bukti Pembayaran Pemesanan Tiket';
                 $mail->Body    = '
                 <!DOCTYPE html>
                 <html lang="en">
                 <head>
                     <meta charset="UTF-8">
                     <meta name="viewport" content="width=device-width, initial-scale=1.0">
                     <title>Bukti Pembayaran</title>
                     <style>
                         body {
                             font-family: Arial, sans-serif;
                             background-color: #f8fafc;
                             color: #1a202c;
                             margin: 0;
                             padding: 0;
                             box-sizing: border-box;
                         }
                         .container {
                             max-width: 600px;
                             margin: 0 auto;
                             padding: 20px;
                             background-color: #ffffff;
                             border-radius: 8px;
                             box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                         }
                         .header {
                             text-align: center;
                             background-color: #4a90e2;
                             color: white;
                             padding: 10px 0;
                             border-radius: 8px 8px 0 0;
                         }
                         .header h1 {
                             margin: 0;
                         }
                         .content {
                             padding: 20px;
                         }
                         .content h1 {
                             color: #2d3748;
                         }
                         .details {
                             background-color: #edf2f7;
                             padding: 20px;
                             border-radius: 8px;
                             margin-top: 20px;
                         }
                         .details p {
                             margin: 0;
                             padding: 10px 0;
                             border-bottom: 1px solid #e2e8f0;
                         }
                         .details p:last-child {
                             border-bottom: none;
                         }
                         .footer {
                             text-align: center;
                             padding: 20px;
                             background-color: #4a90e2;
                             color: white;
                             border-radius: 0 0 8px 8px;
                             margin-top: 20px;
                         }
                     </style>
                 </head>
                 <body>
                     <div class="container">
                         <div class="header">
                             <h1>Bukti Pembayaran</h1>
                         </div>
                         <div class="content">
                             <h1>Terima Kasih!</h1>
                             <p>Terima kasih telah melakukan pembayaran. Berikut adalah detail pemesanan Anda:</p>
                             <div class="details">
                                 <p><strong>Judul Film:</strong> ' . $pemesanan['judul'] . '</p>
                                 <p><strong>Jumlah Tiket:</strong> ' . $pemesanan['jumlah_tiket'] . '</p>
                                 <p><strong>Total Harga:</strong> Rp. ' . number_format($pemesanan['total_harga'], 2) . '</p>
                                 <p><strong>Metode Pembayaran:</strong> ' . ucfirst($metode_pembayaran) . '</p>
                             </div>
                         </div>
                         <div class="footer">
                             <p>&copy; ' . date('Y') . ' Bioskop-DRAF. Semua hak dilindungi.</p>
                         </div>
                     </div>
                 </body>
                 </html>';
 
                 $mail->send();
                 echo 'Bukti pembayaran telah dikirim ke email Anda.';
             } catch (PHPMailer\PHPMailer\Exception $e) {
                 echo "Pesan tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}";
             }
 
             // Redirect to index page
             echo "<script>alert('Pembayaran berhasil! Bukti pembayaran telah dikirim ke email Anda.'); window.location.href='index.php';</script>";
         } else {
             echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
         }
     } else {
         echo "Pemesanan tidak ditemukan.";
     }
 }
 ?>