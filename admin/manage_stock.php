<?php
// Include the database connection
include('../vault_connect.php');

// Fetch products for dropdown (pid)
$products = $conn->query("SELECT pid, product_name FROM products")->fetchAll(PDO::FETCH_ASSOC);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $pid = $_POST['pid'];
    $stock = $_POST['stock'];

    try {
        // Check if the product already exists in the stock table
        $checkStmt = $conn->prepare("SELECT stock FROM stock WHERE pid = ?");
        $checkStmt->execute([$pid]);
        $existingStock = $checkStmt->fetchColumn();

        if ($existingStock !== false) {
            // Product exists, update the stock quantity
            $newStock = $existingStock + $stock;
            $updateStmt = $conn->prepare("UPDATE stock SET stock = ? WHERE pid = ?");
            $updateStmt->execute([$newStock, $pid]);
            echo "<script>alert('Stock updated successfully!'); window.location.href = 'dashboard.php'; </script>";
        } else {
            // Product does not exist, insert a new record
            $insertStmt = $conn->prepare("INSERT INTO stock (pid, stock) VALUES (?, ?)");
            $insertStmt->execute([$pid, $stock]);
            echo "<script>alert('Stock added successfully!'); window.location.href = 'dashboard.php'; </script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }

    // Set the connection to null
    $conn = null;
}
?>


<head>
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: 500;
        }

        .form-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
            height: 38px;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Add this rule to override the appearance property */
        .form-select::-ms-expand {
            display: none;
        }
    </style>
</head>

<div class="form-container">
    <h2>Add Stock</h2>
    <form method="POST" action="manage_stock.php">
        <div class="form-group">
            <input type="number" name="pid" id="pid" class="form-control" placeholder="Product ID" required>
        </div>
        <div class="form-group">
            <input type="number" name="stock" id="stock" class="form-control" placeholder="Stock Quantity" required
                min="0">
        </div>
        <button type="submit" class="btn btn-primary">Add Stock</button>
    </form>
</div>