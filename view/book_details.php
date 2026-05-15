<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($book) || empty($book)) {
    die("Book details not available.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($book['title']) ?> - Online Book Store</title>
    <style>
        .book-container { display: flex; gap: 20px; max-width: 800px; margin: 0 auto; padding: 20px; }
        .book-image img { max-width: 300px; height: auto; }
        .book-info { flex: 1; }
        .error-msg { color: red; display: none; }
    </style>
</head>
<body>

    <?php //'navbar.php'; ?>

    <div class="book-container">
        <div class="book-image">
            <?php 
                $imgPath = !empty($book['image_path']) ? htmlspecialchars($book['image_path']) : 'public/uploads/default-book.png';
            ?>
            <img src="../<?= $imgPath ?>" alt="Cover of <?= htmlspecialchars($book['title']) ?>">
        </div>
        
        <div class="book-info">
            <h1><?= htmlspecialchars($book['title']) ?></h1>
            <h3>By: <?= htmlspecialchars($book['author']) ?></h3>
            <p><strong>Category:</strong> <?= htmlspecialchars($book['category_name'] ?? 'Uncategorized') ?></p>
            <p><strong>Price:</strong> $<?= htmlspecialchars(number_format($book['price'], 2)) ?></p>
            <p><strong>Stock:</strong> <span id="stock-count"><?= htmlspecialchars($book['stock']) ?></span> available</p>
            
            <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>

            <?php if ($book['stock'] > 0): ?>
                <div class="cart-controls">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $book['stock'] ?>">
                    <button id="add-to-cart-btn" data-book-id="<?= $book['id'] ?>">Add to Cart</button>
                    <span class="error-msg" id="qty-error">Invalid quantity!</span>
                </div>
            <?php else: ?>
                <p style="color: red;"><strong>Out of Stock</strong></p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.getElementById('add-to-cart-btn')?.addEventListener('click', function() {
            const qtyInput = document.getElementById('quantity');
            const errorMsg = document.getElementById('qty-error');
            const maxStock = parseInt(qtyInput.getAttribute('max'));
            let qty = parseInt(qtyInput.value);

            if (isNaN(qty) || qty < 1 || qty > maxStock) {
                errorMsg.style.display = 'inline';
                return; 

            errorMsg.style.display = 'none';
            const bookId = this.getAttribute('data-book-id');

            console.log("Valid Add to Cart -> Book ID:", bookId, "Quantity:", qty);
            alert("Ready to send to AJAX: Book " + bookId + " x" + qty);
        });
    </script>

</body>
</html>