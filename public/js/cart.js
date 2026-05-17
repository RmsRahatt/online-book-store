document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.getElementById('add-to-cart-btn');

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const bookId = this.getAttribute('data-book-id');
            const qtyInput = document.getElementById('quantity');
            const quantity = parseInt(qtyInput.value);
            const errorMsg = document.getElementById('qty-error');
            const maxStock = parseInt(qtyInput.getAttribute('max'));

            if (isNaN(quantity) || quantity < 1 || quantity > maxStock) {
                errorMsg.style.display = 'inline';
                return;
            }

            errorMsg.style.display = 'none';

            fetch('api.php?action=add_to_cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    book_id: bookId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error(error);
                alert('An error occurred while adding to the cart.');
            });
        });
    }
});