<?php
session_start();


$firstName = $_SESSION['firstname'] ?? '';
$lastName = $_SESSION['lastname'] ?? '';
$email = $_SESSION['email'] ?? '';

// Check if cart data is sent via POST
if (isset($_POST['cartData'])) {
    // Decode the JSON cart data
    $cartData = json_decode($_POST['cartData'], true);

    // If cart data is valid, proceed with the checkout
    if ($cartData && count($cartData) > 0) {
        // Define a tax rate (e.g., 8%)
        $taxRate = 0.08;
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirm Your Order</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <link rel="stylesheet" href="../css/styles.css">
            <link rel="icon" type="image/png" href="pictures/hlogo.png">
            <style>
                body {
                    background-color: #f8f9fa;
                }

                .cart-item img {
                    width: 80px;
                    height: 80px;
                    object-fit: cover;
                    border-radius: 5px;
                }

                .cart-item {
                    margin-bottom: 20px;
                    padding-bottom: 15px;
                    border-bottom: 1px solid #ddd;
                    text-align: left;
                }

                .checkout-header {
                    font-size: 24px;
                    font-family: 'SFBold', sans-serif;
                    margin-bottom: 30px;
                    text-align: center;
                }

                .confirm-btn {
                    letter-spacing: 1.5px;
                    font-weight: bold;
                }

                .order-summary {
                    margin-top: 30px;
                    padding: 20px;
                    background-color: white;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .total-section h5 {
                    text-align: right;
                }

                .form-label {
                    font-weight: 500;
                }
            </style>
        </head>

        <body>
            <?php include('navbar.php') ?>

            <div id="spacer-div" style="height: 50px; background-color: white;"></div>

            <div class="container mt-5">
                <h2 class="checkout-header">Confirm Your Order</h2>

                <!-- Cart items list -->
                <div class="mb-4">
                    <ul class="list-group">
                        <?php foreach ($cartData as $item) { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center cart-item">
                                <div class="d-flex align-items-center">
                                    <img src="data:image/jpeg;base64,<?php echo $item['image']; ?>"
                                        alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    <div class="ms-3">
                                        <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                                        <p class="mb-0">Quantity: <?php echo $item['quantity']; ?></p>
                                        <p class="mb-0">Price: $<?php echo number_format($item['price'], 2); ?></p>
                                    </div>
                                </div>
                                <span class="text-muted">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <!-- Order summary and details form -->
                <div class="order-summary mx-auto">
                    <?php
                    $totalAmount = 0;
                    foreach ($cartData as $item) {
                        $totalAmount += $item['price'] * $item['quantity'];
                    }
                    $taxAmount = $totalAmount * $taxRate;
                    $grandTotal = $totalAmount + $taxAmount;
                    ?>

                    <!-- Total calculations -->
                    <div class="total-section mb-3">
                        <h5>Total Items: <?php echo count($cartData); ?></h5>
                        <h5>Total Price (before tax): $<?php echo number_format($totalAmount, 2); ?></h5>
                        <h5>Tax (8%): $<?php echo number_format($taxAmount, 2); ?></h5>
                        <h5>Grand Total: $<?php echo number_format($grandTotal, 2); ?></h5>
                    </div>

                    <!-- Address and customer details form -->
                    <form action="confirm_order.php" method="POST">
                        <input type="hidden" name="cartData" value='<?php echo json_encode($cartData); ?>'>
                        <input type="hidden" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>">
                        <input type="hidden" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                        <div class="mb-3">
                            <label for="address" class="form-label">Delivery Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <!-- Payment Methods -->
                        <div class="payment-method mt-3">
                            <h5>Payment Method</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard"
                                    value="Credit Card" checked>
                                <label class="form-check-label" for="creditCard">Credit Card</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="paypal" value="PayPal">
                                <label class="form-check-label" for="paypal">PayPal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="kbzpay" value="KBZ Pay">
                                <label class="form-check-label" for="kpay">KBZ Pay</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer"
                                    value="Bank Transfer">
                                <label class="form-check-label" for="bankTransfer">Bank Transfer</label>
                            </div>
                        </div>

                        <!-- Delivery Methods -->
                        <div class="delivery-method mt-3">
                            <h5>Delivery Method</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="deliveryMethod" id="foodpanda"
                                    value="Food Panda" checked>
                                <label class="form-check-label" for="foodpanda">Food Panda
                                    </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="deliveryMethod" id="royalexpress"
                                    value="Royal Express">
                                <label class="form-check-label" for="expressDelivery">Royal Express</label>
                            </div>
                        </div>

                        <!-- Confirm Order Button -->
                        <button type="submit" class="btn btn-success confirm-btn mt-4 w-100"
                            style="background-color: black; color:white">Confirm Order</button>
                    </form>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>

        </html>
        <?php
    } else {
        echo "<div class='alert alert-warning text-center'>Your cart is empty!</div>";
    }
} else {
    echo "<div class='alert alert-danger text-center'>No cart data received!</div>";
}
?>