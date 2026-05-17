document.addEventListener('DOMContentLoaded', function() {
    const qtyInputs = document.querySelectorAll('.cart-qty');
    const removeBtns = document.querySelectorAll('.remove-btn');
    const checkoutBtn = document.getElementById('checkout-btn');

    qtyInputs.forEach(input => {
        input.addEventListener('change', function() {
            const cartId = this.getAttribute('data-cart-id');
            const qty = parseInt(this.value);
            const max = parseInt(this.getAttribute('max'));

            if (qty < 1 || qty > max) {
                alert('Invalid quantity selected.');
                location.reload(); 
                return;
            }

            fetch('api.php?action=update_cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    cart_id: cartId,
                    quantity: qty
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); 
                } else {
                    alert('Could not update quantity.');
                }
            });
        });
    });

    removeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to remove this book from your cart?')) {
                return;
            }

            const cartId = this.getAttribute('data-cart-id');

            fetch('api.php?action=remove_from_cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    cart_id: cartId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Could not remove item.');
                }
            });
        });
    });

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            window.location.href = 'checkout.php'; 
        });
    }
});