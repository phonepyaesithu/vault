<?php
try {
    // Database connection
    $pdo = new PDO('mysql:host=localhost;dbname=vault', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to select products with stock
    $sql = "
  SELECT 
    p.pid, 
    p.product_name, 
    p.product_img, 
    p.price, 
    st.stock 
  FROM 
    products p
  LEFT JOIN 
    stock st ON p.pid = st.pid
  ORDER BY st.stock ASC;
";

    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<head>
    <style>
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin: px 0;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .product-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .product-table img {
            width: 100px;
            height: auto;
            object-fit: contain;
        }

        .low-stock {
            color: red;
        }
    </style>
</head>

<div class="container my-4">
    <table class="product-table">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($products as $product) {
                // Check if stock is low
                $stockClass = $product['stock'] <= 3 ? 'low-stock' : '';
                ?>
                <tr>
                    <td>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($product['product_img']); ?>"
                            alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                    </td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></td>
                    <td class="<?php echo $stockClass; ?>"><?php echo htmlspecialchars($product['stock']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
// Close connection
$pdo = null;
?>