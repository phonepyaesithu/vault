<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - HYPELOKAL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/account.css">
    <link rel="icon" type="image/png" href="pictures/hlogo.png">
</head>

<body>

    <?php include('navbar.php'); ?>

    <div id="spacer-div" style="height: 50px; background-color: white;"></div>

    <div class="container mt-4">
        <h2>Account</h2>

        <?php
        include('vault_connect.php');

        // Check if the session variable 'firstname' and 'email' are set
        if (isset($_SESSION['firstname'], $_SESSION['email'])) {
            $firstName = htmlspecialchars($_SESSION['firstname']);
            $email = htmlspecialchars($_SESSION['email']);

            echo "<div id='welcome-text'>Greetings, $firstName.</div>";

            try {
                // Query to retrieve orders and their items for the logged-in user using PDO
                $stmt = $conn->prepare("
                    SELECT o.order_id, o.order_date, o.payment_method, o.delivery_method, 
                           oi.product_name, oi.price, oi.quantity 
                    FROM orders o
                    JOIN order_items oi ON o.order_id = oi.order_id
                    WHERE o.email = :email
                ");
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                // Fetch all orders and items
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Check if the user has any orders
                if (count($orders) > 0) {
                    echo "<h3 class='mt-4'>Order History</h3>";
                    echo "<div class='order-history'>";
                    echo "<table class='table table-bordered mt-3'>";
                    echo "<thead class='table-light'>";
                    echo "<tr>
                            
                            <th>Order Date</th>
                            <th>Payment Method</th>
                            <th>Delivery Method</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                          </tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    // Display each order and its items
                    foreach ($orders as $order) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($order['order_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['payment_method']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['delivery_method']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['product_name']) . "</td>";
                        echo "<td>$" . number_format($order['price'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($order['quantity']) . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>You have no orders yet.</p>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "<p>Please log in to view your account details and order history.</p>";
        }

        $conn = null; // Close the PDO connection
        ?>

        <div class="logout-link mt-4">
            <button id="logout-btn" class="btn btn-danger"><a href="logout.php"
                    class="text-white text-decoration-none">Log out</a></button>
        </div>
    </div>

    <script src="../js/search.js"></script>

</body>

</html>
