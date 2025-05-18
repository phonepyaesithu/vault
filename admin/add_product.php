<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Getting POST data
    $pid = $_POST['pid'];
    $product_name = $_POST['product_name'];
    $brand = $_POST['brand'];
    $product_category = $_POST['product_category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $materials = $_POST['materials'];
    $care = $_POST['care'];

    // Handling image uploads
    if (isset($_FILES['product_img']) && isset($_FILES['product_img_hover'])) {
        $product_img_tmp = $_FILES['product_img']['tmp_name'];
        $product_img_hover_tmp = $_FILES['product_img_hover']['tmp_name'];

        // Check if files are uploaded correctly and are images
        if (
            is_uploaded_file($product_img_tmp) && getimagesize($product_img_tmp) &&
            is_uploaded_file($product_img_hover_tmp) && getimagesize($product_img_hover_tmp)
        ) {

            // Get the image content
            $product_img = file_get_contents($product_img_tmp);
            $product_img_hover = file_get_contents($product_img_hover_tmp);

            try {
                // Database connection
                $pdo = new PDO('mysql:host=localhost;dbname=vault', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare the SQL statement with placeholders
                $stmt = $pdo->prepare("INSERT INTO products (pid, product_name, brand, product_category, product_img, product_img_hover, price, description, materials, care) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $pid, PDO::PARAM_INT);
                $stmt->bindParam(2, $product_name);
                $stmt->bindParam(3, $brand);
                $stmt->bindParam(4, $product_category);
                $stmt->bindParam(5, $product_img, PDO::PARAM_LOB); // Bind image as BLOB
                $stmt->bindParam(6, $product_img_hover, PDO::PARAM_LOB); // Bind hover image as BLOB
                $stmt->bindParam(7, $price, PDO::PARAM_STR); // Use string for price
                $stmt->bindParam(8, $description);
                $stmt->bindParam(9, $materials);
                $stmt->bindParam(10, $care);

                // Execute the query and check for success
                if ($stmt->execute()) {
                    echo "<script>window.location.href = '../admin/dashboard.php?page=display_products';</script> 
                    <div class='alert alert-success' role='alert'><i class='bi bi-check-circle'></i> Product added successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error: Could not execute the query.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger' role='alert'>Error: " . $e->getMessage() . "</div>";
            }

            // Close the connection
            $pdo = null;
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error: Please upload valid images.</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: Image files are required.</div>";
    }
}
?>

<head>
    <style>
        .main-content {
            max-width: 800px;
            margin: 0 auto;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #343a40;
            color: #fff;
            padding: 10px 15px;
            border-bottom: 1px solid #e1e1e1;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<div class="container main-content">
    <div class="card">
        <div class="card-body">
            <form action="dashboard.php?page=add_product" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="number" class="form-control" id="pid" name="pid" placeholder="Product ID">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="product_name" name="product_name"
                        placeholder="Product Name" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="brand" name="brand" placeholder="Brand" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="product_category" name="product_category"
                        placeholder="Category" required>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control" id="product_img" name="product_img" accept="image/*"
                        placeholder="Product Image" required>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control" id="product_img_hover" name="product_img_hover"
                        placeholder="Product Image Hover" accept="image/*" required>
                </div>
                <div class="form-group">
                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Price"
                        required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" rows="3"
                        placeholder="Description" required></textarea>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="materials" name="materials" rows="1"
                        placeholder="Materials"></textarea>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="care" name="care" rows="1"
                        placeholder="Care Instruction"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>
</div>