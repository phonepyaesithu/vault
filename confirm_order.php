<?php
session_start();
require 'vault_connect.php'; 

// Check if form data is sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON cart data
    $cartData = json_decode($_POST['cartData'], true);
    $paymentMethod = $_POST['paymentMethod'] ?? 'Credit Card';
    $deliveryMethod = $_POST['deliveryMethod'] ?? 'Standard';
    $firstName = $_SESSION['firstname'] ?? '';
    $lastName = $_SESSION['lastname'] ?? '';
    $email = $_SESSION['email'] ?? '';
    $address = $_POST['address'] ?? '';

    // If cart data is valid, proceed with the order confirmation
    if ($cartData && count($cartData) > 0) {
        // Calculate total, tax, and grand total
        $totalAmount = 0;
        foreach ($cartData as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        $taxRate = 0.08; // 8% tax rate
        $taxAmount = $totalAmount * $taxRate;
        $grandTotal = $totalAmount + $taxAmount;

        // Insert order into orders table
        $stmt = $conn->prepare("INSERT INTO orders (first_name, last_name, email, address, payment_method, delivery_method, order_date) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$firstName, $lastName, $email, $address, $paymentMethod, $deliveryMethod]);
        $orderId = $conn->lastInsertId(); // Get the last inserted order ID

        // Insert order items into order_items table and update stock
        foreach ($cartData as $item) {
            // Insert into order_items table
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, pid, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$orderId, $item['id'], $item['name'], $item['price'], $item['quantity']]);

            // Update stock in the stock table
            $stmt = $conn->prepare("UPDATE stock SET stock = stock - ? WHERE pid = ?");
            $stmt->execute([$item['quantity'], $item['id']]);
        }

        // Display order confirmation (same as before)
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Order Confirmation</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="icon" type="image/png" href="pictures/hlogo.png">
            <style>
                .order-header {
                    font-size: 24px;
                    font-family: 'SFBold', sans-serif;
                    margin-bottom: 20px;
                }

                .order-details {
                    margin-top: 30px;
                }
            </style>
        </head>

        <body>

            <?php include('navbar.php') ?>
            <div id="spacer-div" style="height: 50px; background-color: white;"></div>

            <div class="container mt-5">
                <h2 class="order-header">Order Confirmation</h2>
                <h5>Thank you for your order!</h5>

                <div class="order-details">
                    <h4>Your Order Details</h4>
                    <ul class="list-group mb-3">
                        <?php
                        foreach ($cartData as $item) {
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                            echo "<span>{$item['name']} (Quantity: {$item['quantity']})</span>";
                            echo "<span>$" . number_format($item['price'] * $item['quantity'], 2) . "</span>";
                            echo "</li>";
                        }
                        ?>
                    </ul>

                    <h5>Total Price (Before Tax): $<?php echo number_format($totalAmount, 2); ?></h5>
                    <h5>Tax (8%): $<?php echo number_format($taxAmount, 2); ?></h5>
                    <h5>Grand Total: $<?php echo number_format($grandTotal, 2); ?></h5>
                    <h5>Payment Method: <?php echo htmlspecialchars($paymentMethod); ?></h5>
                    <h5>Delivery Method: <?php echo htmlspecialchars($deliveryMethod); ?></h5>
                    <h5>Delivery Address: <?php echo htmlspecialchars($address); ?></h5>
                    <h5>Customer Email: <?php echo htmlspecialchars($email); ?></h5>
                    <h5>Customer Name: <?php echo htmlspecialchars("$firstName $lastName"); ?></h5>
                </div>

                <div class="mt-4">
                    <a href="index.php" class="btn btn-primary"
                        style="background-color: black; color: white; text-decoration: none;">Return to Home</a>
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
    echo "<div class='alert alert-danger text-center'>Invalid request!</div>";
}
?>