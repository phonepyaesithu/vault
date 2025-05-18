<?php

include('../vault_connect.php');
// Establish the database connection


// Fetch product details based on pid
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE pid = ?");
    $stmt->execute([$pid]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Product not found.");
    }
} else {
    die("Product ID is not specified.");
}

// Update product details in the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle image update only if a new file is uploaded
    if ($_FILES['product_img']['name']) {
        // Read the image as binary data
        $product_img = file_get_contents($_FILES['product_img']['tmp_name']);

        // Update the product with the new image
        $stmt = $conn->prepare("UPDATE products SET product_name = ?, product_img = ?, price = ?, description = ? WHERE pid = ?");
        $stmt->bindParam(1, $product_name);
        $stmt->bindParam(2, $product_img, PDO::PARAM_LOB); // Bind the image as a BLOB
        $stmt->bindParam(3, $price);
        $stmt->bindParam(4, $description);
        $stmt->bindParam(5, $pid);
    } else {
        // Update the product without changing the image
        $stmt = $conn->prepare("UPDATE products SET product_name = ?, price = ?, description = ? WHERE pid = ?");
        $stmt->bindParam(1, $product_name);
        $stmt->bindParam(2, $price);
        $stmt->bindParam(3, $description);
        $stmt->bindParam(4, $pid);
    }

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully.'); window.location.href='dashboard.php?page=manage_products';</script>";
    } else {
        echo "<script>alert('Error. Could not update the product.'); window.location.href='dashboard.php?page=manage_products';</script>";
    }
}


$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - VAULT</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../admin_styles.css">
    <link rel="stylesheet" href="../css/styles.css">

</head>

<body>

    <?php include('../navbar.php'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h2>Edit Product</h2>
                    </div>
                    <div class="card-body">
                        <form action="edit_product.php?pid=<?php echo htmlspecialchars($pid); ?>" method="post" enctype="multipart/form-data">

                            <div class="mb-3">
                                <input type="text" class="form-control" id="pid" name="pid" placeholder="Product ID" value="<?php echo htmlspecialchars($product['pid']); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control" id="product_category" name="product_category" placeholder="Product Category" value="<?php echo htmlspecialchars($product['product_category']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <input type="file" class="form-control" id="product_img" name="product_img" accept="image/*" placeholder="Product Image">
                                <small class="form-text text-muted">Leave blank to keep the current image.</small>
                            </div>

                            <div class="mb-3">
                                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>