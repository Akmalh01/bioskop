<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page Bioskop</title>
  <link rel="stylesheet" href="../src/css/output.css">
</head>
<body class="bg-gray-900 text-white">

<?php include '../src/components/header.php'; ?>

<div class="container mx-auto px-4 mt-24">
    <div class="flex flex-wrap items-center justify-between my-12">
      <!-- Gambar orang menonton film -->
      <div class="w-full lg:w-1/2">
        <img src="../src/images/human.jpeg" alt="Orang Menonton Film" class="rounded-lg shadow-lg">
      </div>

      <!-- Deskripsi Bioskop dan Contact Person -->
      <div class="w-full lg:w-1/2 lg:pl-10 mt-6 lg:mt-0">
        <h2 class="text-3xl font-semibold mb-4">Nikmati Pengalaman Menonton yang Tak Terlupakan</h2>
        <p class="text-gray-400 mb-8">
          Bioskop kami menyediakan pengalaman menonton terbaik dengan kualitas suara dan gambar yang luar biasa. Datang dan rasakan sendiri!
        </p>
        
        <!-- Contact Person -->
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <span class="text-sm font-semibold">Hubungi Kami:</span>
          </div>
          <div class="ml-4">
            <p class="text-sm">Email: contact@bioskop.com</p>
            <p class="text-sm">Telepon: (021) 123-4567</p>
          </div>
        </div>

        <!-- Get Started Button -->
        <a href="register.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Get Started
</a>
      </div>
    </div>
  </div>

</body>
</html>