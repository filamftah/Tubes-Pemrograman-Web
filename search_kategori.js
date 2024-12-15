// Filter produk berdasarkan kategori
function filterByCategory(category) {
    const products = document.querySelectorAll('.product');
    products.forEach(product => {
        if (category === 'All' || product.getAttribute('data-category') === category) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

// Pencarian produk berdasarkan nama
function searchProducts() {
    const query = document.getElementById('search').value.toLowerCase();
    const products = document.querySelectorAll('.product');
    products.forEach(product => {
        const name = product.querySelector('h3').textContent.toLowerCase();
        if (name.includes(query)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}
