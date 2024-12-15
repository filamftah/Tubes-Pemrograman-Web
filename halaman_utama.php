<?php
// Mulai sesi
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Katalog Produk</title>
    <style>
        /* Reset untuk margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Styling untuk halaman utama */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        /* Navbar */
        nav {
            background-color: #2a6ba1;
            color: #fff;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav .logo h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        nav ul {
            list-style-type: none;
            display: flex;
            justify-content: flex-end;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Hero Section with Blurred Background */
        .hero {
            background-image: url('assets/img/background1.jpg'); /* Ganti dengan gambar latar belakang Anda */
            background-position: center;
            background-size: cover;
            position: relative;
            height: 100vh;
            filter: blur(0px); /* Atur tingkat keburaman gambar */
            z-index: 1;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Overlay untuk menambahkan kontras */
            z-index: 2;
        }

        .hero .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            z-index: 3;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .hero .cta-btn {
            background-color: #2a6ba1;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }

        .hero .cta-btn:hover {
            background-color:rgb(162, 162, 162);
        }

        /* Tentang Kami Section */
        .about {
            background-color: #f4f4f4;
            padding: 60px 20px;
            text-align: center;
        }

        .about h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        /* Fitur Section */
        .features {
            padding: 60px 20px;
            text-align: center;
        }

        .features h2 {
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .feature-cards {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .feature-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 30%;
            margin: 10px;
            text-align: center;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .feature-card p {
            font-size: 1rem;
            color: #555;
        }

        /* Footer */
        footer {
            background-color: #2a6ba1;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="logo">
            <h1>Katalog Produk</h1>
        </div>
        <ul>
            <li><a href="#about">Tentang Kami</a></li>
            <li><a href="#features">Fitur</a></li>
            <li><a href="login.php">Login</a></li>
           
        </ul>
    </nav>

    <!-- Hero Section with Blurred Background -->
    <section class="hero">
        <div class="hero-content">
            <h1>Selamat Datang di Katalog Produk</h1>
            <p>Temukan berbagai produk terbaik, dari elektronik hingga barang rumah tangga.</p>
            <a href="login.php" class="cta-btn">Mulai Menjelajah</a>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="about" class="about">
        <h2>Tentang Kami</h2>
        <p>Katalog Produk adalah platform untuk menjelajahi berbagai produk terbaik yang telah dikurasi untuk memenuhi kebutuhan Anda.</p>
    </section>

    <!-- Fitur Section -->
    <section id="features" class="features">
        <h2>Kenapa Memilih Kami?</h2>
        <div class="feature-cards">
            <div class="feature-card">
                <h3>Pilihan Produk Luas</h3>
                <p>Temukan berbagai produk dengan mudah, dari berbagai kategori yang tersedia.</p>
            </div>
            <div class="feature-card">
                <h3>Pencarian Mudah</h3>
                <p>Cari produk favorit Anda dengan cepat dan temukan yang terbaik untuk Anda.</p>
            </div>
            <div class="feature-card">
                <h3>Harga Terjangkau</h3>
                <p>Dapatkan harga terbaik dengan berbagai diskon menarik yang kami tawarkan.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Katalog Produk. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>
