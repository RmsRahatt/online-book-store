<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background-color: #f4f7f6; 
            display: flex; 
            justify-content: center; 
            align-items: center;
             min-height: 100vh;
              margin: 0; }
        .checkout-container { 
            background: #fff; 
            padding: 30px; 
            border-radius: 12px;
             box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
             width: 100%; 
             max-width: 400px; 
            }
        .form-group {
             margin-bottom: 20px;
             }
        label {
             display: block; 
             margin-bottom: 8px; 
             font-weight: 600;
             }
        textarea, select {
             width: 100%; 
             padding: 12px;
              border: 1px solid #ccc;
               border-radius: 6px;
                box-sizing: border-box;
             }
        button {
             width: 100%; 
             padding: 12px; 
             background-color: #007bff; 
             color: white; 
             border: none;
              border-radius: 6px;
               font-weight: bold; 
               cursor: pointer; 
            }
        button:hover {
             background-color: #0056b3; 
            }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2>Complete Your Order</h2>
    <form id="checkoutForm">
        <div class="form-group">
            <label for="address">Shipping Address:</label>
            <textarea name="address" id="address" required placeholder="Enter full address"></textarea>
        </div>
        
        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value=""> Select</option>
                <option value="bkash">bKash</option>
                <option value="nagad">Nagad</option>
                <option value="cod">Cash on Delivery</option>
            </select>
        </div>
        
        <button type="button" onclick="placeOrder()">Confirm Order</button>
    </form>
</div>

<script>
function placeOrder() {
    let addr = document.getElementById('address').value;
    let pay = document.getElementById('payment_method').value;

    if(addr === "" || pay === "") {
        alert("Please fill in all details!");
        return;
    }

    let formData = new FormData(document.getElementById('checkoutForm'));
    
    fetch('controller/OrderController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert("Order placed successfully! ID: " + data.order_id);
            window.location.href = "view/purchase_history.php";
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Check Console for errors!");
    });
}
</script>

</body>
</html>