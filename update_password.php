<?php
require 'koneksi.php'; // Koneksi ke database

// Membuat hash untuk password
$adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
$userPassword = password_hash('user123', PASSWORD_DEFAULT);

// Query untuk menyisipkan data ke dalam tabel users
$query = "INSERT INTO users (username, password, email, role) VALUES
          ('admin', '$adminPassword', 'admin@example.com', 'admin'),
          ('user1', '$userPassword', 'user1@example.com', 'user')";

// Menjalankan query
if (mysqli_query($conn, $query)) {
    echo "Data berhasil ditambahkan!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
