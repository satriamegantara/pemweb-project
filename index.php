<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/thumbnail.png" type="image/png">
    <title>Galaxy Explorer</title>

    <!-- Cara 2: Jika ingin pakai font lokal (uncomment baris di bawah, comment Google Fonts) -->
    <!-- <link rel="stylesheet" href="css/fonts.css"> -->

    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <!-- Background galaxy -->
        <div class="bg"></div>

        <!-- Planet-planet (hanya animasi saat hover) -->
        <img src="assets/images/planet1.png"   alt="planet" class="planet planet-left">
        <img src="assets/images/planet4.png" alt="saturn" class="planet saturn">
        <img src="assets/images/planet2.png"  alt="planet" class="planet planet-right">
        <img src="assets/images/planet3.png"  alt="planet" class="planet planet-top">

        <!-- Konten tengah -->
        <div class="content">
            <h1 class="title">GALAXY EXPLORER</h1>
            <p class="subtitle">Unveiling stories from every hidden galaxy</p>
            <button class="start-btn">START</button>
        </div>
    </div>

    <script>
        document.querySelector('.start-btn').addEventListener('click', () => {
            alert('Menuju galaksi tak terjamah... 🚀');
            // window.location.href = 'game.html';
        });
    </script>
</body>
</html>