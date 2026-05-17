<?php require_once 'partials/header.php'; ?>

    <h1>Shopping Cart</h1>

    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr id="cart-row-<?= $item['cart_id'] ?>">
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td>
                            <input type="number" 
                                   class="cart-qty" 
                                   data-cart-id="<?= $item['cart_id'] ?>" 
                                   value="<?= $item['quantity'] ?>" 
                                   min="1" 
                                   max="<?= $item['stock'] ?>">
                        </td>
                        <td class="item-subtotal">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        <td>
                            <button class="remove-btn" data-cart-id="<?= $item['cart_id'] ?>">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-total">
            Total: $<span id="grand-total"><?= number_format($cartTotal, 2) ?></span>
        </div>
        
        <br>
        <button id="checkout-btn">Proceed to Checkout</button>
    <?php endif; ?>

    <script src="public/js/cart_manage.js"></script>
<?php require_once 'partials/footer.php'; ?>