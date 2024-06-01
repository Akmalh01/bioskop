<?php
session_start();
require '../../src/config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $film_id = intval($_GET['id']);
    $query = "SELECT * FROM film WHERE id = $film_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_id = $_SESSION['user_id']; // Menggunakan user_id dari sesi
            $jumlah_tiket = intval($_POST['jumlah_tiket']);
            $total_harga = $jumlah_tiket * $data['harga_tiket'];
            $jam_tayang = $_POST['jam_tayang'];
            $tempat_duduk = $_POST['tempat_duduk'];
            $status = 'belum_dibayar';

            $insert_query = "INSERT INTO pemesanan (user_id, film_id, jumlah_tiket, total_harga, status) VALUES ($user_id, $film_id, $jumlah_tiket, $total_harga, '$status')";

            if (mysqli_query($conn, $insert_query)) {
                $pemesanan_id = mysqli_insert_id($conn);
                foreach ($tempat_duduk as $duduk) {
                    $insert_ticket_query = "INSERT INTO pemilihan_tiket (pemesanan_id, jam_tayang, tempat_duduk) VALUES ($pemesanan_id, '$jam_tayang', '$duduk')";
                    mysqli_query($conn, $insert_ticket_query);
                }
                echo "<script>
                        alert('Pemesanan berhasil!');
                        window.location.href = 'index.php';
                      </script>";
                exit();
            } else {
                echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Tiket</title>
    <link rel="stylesheet" href="../../src/css/output.css">
    <style>
        .seat {
            width: 30px;
            height: 30px;
            background-color: #ddd;
            margin: 5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .selected {
            background-color: #6c7ae0;
        }
        .row {
            display: flex;
            justify-content: center;
        }
        .screen {
            background-color: #ccc;
            height: 50px;
            margin: 20px 0;
            text-align: center;
            line-height: 50px;
            font-weight: bold;
        }
        .showtime {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            cursor: pointer;
            display: inline-block;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .showtime.selected {
            background-color: #6c7ae0;
            color: white;
        }
    </style>
</head>
<body>
<div class="max-w-2xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900"><?= $data['judul'] ?></h2>
    <p class="mt-1 text-sm text-gray-500">Harga Tiket: Rp. <?= number_format($data['harga_tiket'], 2) ?></p>
    <form method="POST" action="">
        <label for="jumlah_tiket" class="block mt-4 text-sm font-medium text-gray-700">Jumlah Tiket</label>
        <input type="number" id="jumlah_tiket" name="jumlah_tiket" class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md" required>
        
        <label class="block mt-4 text-sm font-medium text-gray-700">Jam Tayang</label>
        <div id="showtimes">
            <div class="showtime" data-time="14:00">14:00</div>
            <div class="showtime" data-time="17:00">17:00</div>
            <div class="showtime" data-time="20:00">20:00</div>
        </div>
        <input type="hidden" id="jam_tayang" name="jam_tayang" required>
        
        <label class="block mt-4 text-sm font-medium text-gray-700">Tempat Duduk</label>
        <div class="screen">Layar</div>
        <?php
            $rows = ['A', 'B', 'C', 'D', 'E'];
            $cols = 10;
            foreach ($rows as $row) {
                echo '<div class="row">';
                for ($col = 1; $col <= $cols; $col++) {
                    $seat = $row . $col;
                    echo '<div class="seat" data-seat="' . $seat . '">' . $seat . '</div>';
                    if ($col == 5) {
                        echo '<div style="width: 30px;"></div>'; // Gang di tengah
                    }
                }
                echo '</div>';
            }
        ?>
        <input type="hidden" id="tempat_duduk" name="tempat_duduk[]" required>
        
        <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md">
            Pesan Tiket
        </button>
    </form>
</div>
<script>
    document.querySelectorAll('.showtime').forEach(showtime => {
        showtime.addEventListener('click', function () {
            document.querySelectorAll('.showtime').forEach(s => s.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('jam_tayang').value = this.getAttribute('data-time');
        });
    });

    document.querySelectorAll('.seat').forEach(seat => {
        seat.addEventListener('click', function () {
            let jumlah_tiket = parseInt(document.getElementById('jumlah_tiket').value);
            let selectedSeats = document.querySelectorAll('.seat.selected').length;
            
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedSeats--;
            } else if (selectedSeats < jumlah_tiket) {
                this.classList.add('selected');
                selectedSeats++;
            } else {
                alert('Anda hanya dapat memilih ' + jumlah_tiket + ' tempat duduk.');
            }

            // Update tempat duduk input field
            let selected = document.querySelectorAll('.seat.selected');
            let seats = [];
            selected.forEach(s => seats.push(s.getAttribute('data-seat')));
            document.getElementById('tempat_duduk').value = seats.join(',');
        });
    });
</script>
</body>
</html>
<?php
    } else {
        echo "Film tidak ditemukan.";
    }
} else {
    echo "ID tidak diberikan.";
}
?>
