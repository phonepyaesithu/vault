<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=vault', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete product if the delete button is clicked
    if (isset($_POST['delete'])) {
        $pid = $_POST['pid'];
        $stmt = $pdo->prepare("DELETE FROM products WHERE pid = ?");
        $stmt->execute([$pid]);
        // Redirect to the same page to avoid resubmission
        header("Location: dashboard.php?page=manage_products&message=Product deleted successfully!");
        exit; // Ensure script execution stops after redirect
    }

    // Fetch all products
    $stmt = $pdo->query("SELECT pid, product_name, product_img, price FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// After all PHP logic, start the HTML output
?>

<div class="container">
    <h2 id="manage_product_header"><i class="bi bi-gear-wide-connected"></i>Manage Products</h2>
    
    <?php
    // Display success message if it exists
    if (isset($_GET['message'])) {
        echo "<p class='message'>" . htmlspecialchars($_GET['message']) . "</p>";
    }
    ?>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Product ID</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
                <td><?php echo htmlspecialchars($product['pid']); ?></td>
                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($product['product_img']); ?>"
                        class="card-img-top normal-img" alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                        style="width:100px; height:fit-content;"></td>
                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                <td>$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></td>
                <td>
                    <form action="dashboard.php?page=manage_products" method="post" style="display:inline-block;" 
                          onsubmit="return confirm('Are you sure you want to delete this product?');">
                        <input type="hidden" name="pid" value="<?php echo htmlspecialchars($product['pid']); ?>">
                        <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    <a href="edit_product.php?pid=<?php echo htmlspecialchars($product['pid']); ?>"
                        class="btn btn-warning btn-sm"><i class="bi bi-pencil-square" style="padding:0"></i></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
$pdo = null;
?>
