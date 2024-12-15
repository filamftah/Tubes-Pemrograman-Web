// Function to handle confirmation before deleting a product
function confirmDelete(productId) {
    // Menampilkan konfirmasi kepada pengguna
    const confirmation = confirm("Are you sure you want to delete this product?");
    
    if (confirmation) {
        // Jika pengguna menekan OK, redirect ke halaman delete.php dengan parameter ID produk
        window.location.href = "delete.php?id=" + productId;
    }
}
