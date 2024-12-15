<?php
session_start();

// Sertakan file koneksi
include('koneksi.php');

// Cek apakah user sudah login dan role-nya adalah 'user'
if ($_SESSION['role'] != 'user') {
    header("Location: login.php"); // Proteksi halaman
    exit();
}

// Ambil produk dari database
$productQuery = "SELECT p.*, c.name AS category FROM products p JOIN categories c ON p.category_id = c.id";
$productResult = mysqli_query($conn, $productQuery);

// Ambil kategori produk dari database
$categoryQuery = "SELECT DISTINCT c.name AS category FROM products p JOIN categories c ON p.category_id = c.id";
$categoryResult = mysqli_query($conn, $categoryQuery);

// Ambil data profil pengguna
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="assets/css/style_dashboardUsers.css">
    <script src="assets/js/search_kategori.js" defer></script>
</head>
<body>
<!-- Header -->
<header>
    <nav>
        <ul>
            <li><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
</header>

<!-- Kategori Produk -->
<section class="categories">
    <h2>Filter by Category</h2>
    <div class="category-buttons">
        <?php while ($category = mysqli_fetch_assoc($categoryResult)): ?>
            <button class="category-btn" onclick="filterByCategory('<?php echo htmlspecialchars($category['category']); ?>')"><?php echo ucfirst(htmlspecialchars($category['category'])); ?></button>
        <?php endwhile; ?>
    </div>
</section>

<!-- Pencarian Produk -->
<section class="search">
    <h2>Search Products</h2>
    <input type="text" id="search" placeholder="Search for products..." oninput="searchProducts()">
</section>

<!-- Daftar Produk -->
<section class="product-list">
    <h2>Product List</h2>
    <div class="products" id="product-list">
        <?php while ($product = mysqli_fetch_assoc($productResult)): ?>
            <div class="product" data-category="<?php echo htmlspecialchars($product['category']); ?>">
                <?php 
                    // Ambil URL gambar yang disimpan di database
                    $imageURL = htmlspecialchars($product['image']);
                ?>
                <!-- Menampilkan gambar menggunakan URL yang ada di database -->
                <img src="<?php echo $imageURL; ?>" alt="Product">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <!-- Menampilkan harga dalam format Rupiah -->
                <p><strong>Price:</strong> Rp <?php echo number_format(htmlspecialchars($product['price']), 0, ',', '.'); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</section>
</body>
</html>
