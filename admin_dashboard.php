<?php
session_start();

// Sertakan file koneksi
include('koneksi.php');

// Proteksi halaman, hanya admin yang dapat mengakses
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect jika bukan admin
    exit();
}

// Ambil data produk
$productQuery = "SELECT p.*, c.name AS category FROM products p JOIN categories c ON p.category_id = c.id";
$productResult = mysqli_query($conn, $productQuery);

// Tambah produk
if (isset($_POST['addProduct'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    
    // Ambil nama dan lokasi file gambar
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    
    // Tentukan path gambar
    $image_path = 'uploads/' . $image;  // Path relatif ke folder 'uploads'
    
    // Pindahkan file gambar ke folder 'uploads/'
    move_uploaded_file($image_tmp, $image_path);

    // Query untuk menambah produk
    $insertQuery = "INSERT INTO products (name, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssdss", $name, $description, $price, $category_id, $image_path);
    $stmt->execute();

    // Redirect setelah produk ditambahkan
    header("Location: admin_dashboard.php");
}

// Edit produk
if (isset($_POST['editProduct'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // Jika ada gambar baru yang diunggah
    if (!empty($image)) {
        // Tentukan path gambar baru
        $image_path = 'uploads/' . $image;
        
        // Pindahkan gambar baru ke folder 'uploads/'
        move_uploaded_file($image_tmp, $image_path);
        
        // Query untuk update produk termasuk gambar baru
        $updateQuery = "UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssdssi", $name, $description, $price, $category_id, $image_path, $product_id);
    } else {
        // Jika gambar tidak diubah, cukup update informasi produk tanpa mengganti gambar
        $updateQuery = "UPDATE products SET name = ?, description = ?, price = ?, category_id = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssdsi", $name, $description, $price, $category_id, $product_id);
    }
    $stmt->execute();

    // Redirect setelah produk diperbarui
    header("Location: admin_dashboard.php");
}

// Hapus produk
if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    $deleteQuery = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    header("Location: admin_dashboard.php"); // Redirect setelah hapus produk
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style_dashboardAdmin.css">
    <script src="assets/js/confirm_delete.js" defer></script>
</head>
<body>
<!-- Header -->
<header>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li> <!-- Hapus link ke profil -->
        </ul>
    </nav>
    <h1>Welcome, Admin!</h1>
</header>

<!-- Daftar Produk -->
<section class="product-list">
    <h2>Product Management</h2>
    <button onclick="document.getElementById('addProductForm').style.display='block'">Add New Product</button>
    
    <div class="products">
        <?php while ($product = mysqli_fetch_assoc($productResult)): ?>
            <div class="product">
                <!-- Menampilkan gambar produk -->
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" onerror="this.onerror=null; this.src='assets/images/default-image.jpg'">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Price:</strong> Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                <a href="admin_dashboard.php?edit=<?php echo $product['id']; ?>">Edit</a>
                <a href="admin_dashboard.php?delete=<?php echo $product['id']; ?>" onclick="return confirmDelete()">Delete</a>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- Add Product Form -->
<div id="addProductForm" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('addProductForm').style.display='none'">&times;</span>
        <h2>Add New Product</h2>
        <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Product Description" required></textarea>
            <input type="number" name="price" placeholder="Price" required>
            <select name="category_id" required>
                <?php
                $categoryQuery = "SELECT * FROM categories";
                $categoryResult = mysqli_query($conn, $categoryQuery);
                while ($category = mysqli_fetch_assoc($categoryResult)): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                <?php endwhile; ?>
            </select>
            <input type="file" name="image" required>
            <button type="submit" name="addProduct">Add Product</button>
        </form>
    </div>
</div>

<!-- Edit Product Form -->
<?php
if (isset($_GET['edit'])) {
    $product_id = $_GET['edit'];
    $editQuery = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($editQuery);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
?>
<div id="editProductForm" class="modal" style="display: block;">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('editProductForm').style.display='none'">&times;</span>
        <h2>Edit Product</h2>
        <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
            <select name="category_id" required>
                <?php
                $categoryQuery = "SELECT * FROM categories";
                $categoryResult = mysqli_query($conn, $categoryQuery);
                while ($category = mysqli_fetch_assoc($categoryResult)): ?>
                    <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $product['category_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <input type="file" name="image">
            <button type="submit" name="editProduct">Update Product</button>
        </form>
    </div>
</div>
<?php } ?>

</body>
</html>
