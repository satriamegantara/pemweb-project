<?php
// index.php - halaman utama Spacepedia
// Jika nanti ingin menampilkan data dari database, tinggal tambahkan include config + query
// include "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spacepedia - Home</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
        <div class="logo">Spacepedia</div>
        <nav>
            <a href="#planet">Planet</a>
            <a href="#bintang">Bintang</a>
            <a href="#galaksi">Galaksi</a>
            <a href="#nebula">Nebula</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h1>Welcome to Spacepedia</h1>
            <p>Eksplorasi planet, bintang, galaksi, dan keajaiban luar angkasa lainnya.</p>
        </div>
    </section>

    <section class="objek-container">
        <h2 class="section-title">Objek Antariksa</h2>
        <div class="cards">
            <!-- Contoh card statis (nantinya diganti PHP fetch database) -->
            <div class="card" style="--accent:#FFCC00;">
                <img src="assets/images/sun.jpg" alt="sun">
                <h3>Matahari</h3>
                <p class="tipe">Bintang</p>
                <a class="detail-btn" href="#">Detail</a>
            </div>

            <div class="card" style="--accent:#1E90FF;">
                <img src="assets/images/earth.jpg" alt="earth">
                <h3>Bumi</h3>
                <p class="tipe">Planet</p>
                <a class="detail-btn" href="#">Detail</a>
            </div>
        </div>
    </section>

    <footer>
        <p>© 2025 Spacepedia. All rights reserved.</p>
    </footer>
</body>
</html>