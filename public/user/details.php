<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Details Film</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="../../src/css/output.css">
</head>
<body>

<?php
include '../../src/config/config.php';
// Ambil ID film dari URL
$id = $_GET['id'];

$sql = "SELECT * FROM film WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data dari setiap baris
    while($row = $result->fetch_assoc()) {
        $judul = $row["judul"];
        $genre = $row["genre"];
        $durasi = $row["durasi"];
        $sutradara = $row["sutradara"];
        $sinopsis = $row["sinopsis"];
        $tanggal_rilis = $row["tanggal_rilis"];
        $gambar = $row["gambar"];
        $harga_tiket = $row["harga_tiket"];
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<div class="relative z-10" role="dialog" aria-modal="true">
  <div class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block"></div>

  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">
      <div class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">
        <div class="relative flex w-full items-center overflow-hidden bg-white px-4 pb-8 pt-14 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
        <!-- <button id="closeButton" type="button" class="absolute right-4 top-4 text-gray-400 hover:text-gray-500 sm:right-6 sm:top-8 md:right-6 md:top-6 lg:right-8 lg:top-8">
    <span class="sr-only">Close</span>
    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
</button> -->

          <div class="grid w-full grid-cols-1 items-start gap-x-6 gap-y-8 sm:grid-cols-12 lg:gap-x-8">
            <div class="aspect-h-3 aspect-w-2 overflow-hidden rounded-lg bg-gray-100 sm:col-span-4 lg:col-span-5">
              <img src="<?php echo $gambar; ?>" alt="<?php echo $judul; ?>" class="object-cover object-center">
            </div>
            <div class="sm:col-span-8 lg:col-span-7">
              <h2 class="text-2xl font-bold text-gray-900 sm:pr-12"><?php echo $judul; ?></h2>

              <section aria-labelledby="information-heading" class="mt-2">
                <h3 id="information-heading" class="sr-only">Informasi Film</h3>

                <p class="text-2xl text-gray-900">Rp<?php echo number_format($harga_tiket, 2); ?></p>

                <div class="mt-6">
                  <h4 class="sr-only">Detail Film</h4>
                  <div>
                    <p><strong>Genre:</strong> <?php echo $genre; ?></p>
                    <p><strong>Durasi:</strong> <?php echo $durasi; ?> menit</p>
                    <p><strong>Sutradara:</strong> <?php echo $sutradara; ?></p>
                    <p><strong>Tanggal Rilis:</strong> <?php echo $tanggal_rilis; ?></p>
                  </div>
                </div>
              </section>

              <section aria-labelledby="options-heading" class="mt-10">
                <h3 id="options-heading" class="sr-only">Sinopsis</h3>
                <div>
                  <p><?php echo nl2br($sinopsis); ?></p>
                </div>
              </section>

              <button type="button" class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Beli Tiket</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    document.getElementById('closeButton').addEventListener('click', function() {
        window.parent.postMessage('closeModal', '*');
    });
</script>
</body>
</html>
