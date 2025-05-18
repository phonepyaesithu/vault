<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=vault', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT pid, product_name, product_img, product_img_hover, price FROM products";
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            position: relative;
            overflow: hidden;
        }

        .card-img-top {
            width: 100%;
            height: auto;
            transition: opacity 0.5s ease;
        }

        .card:hover .hover-img {
            opacity: 1;
        }

        .hover-img {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.5s ease;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <?php foreach ($products as $row) { ?>
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="img-container" style="position: relative;">
                            <!-- Original Image -->
                            <img src="data:image/jpeg;base64,<?php echo isset($row['product_img']) ? base64_encode($row['product_img']) : ''; ?>"
                                class="card-img-top original-img"
                                alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                style="width: 100%; height: auto;">
                            <!-- Hover Image -->
                            <img src="data:image/jpeg;base64,<?php echo isset($row['product_img_hover']) ? base64_encode($row['product_img_hover']) : ''; ?>"
                                class="card-img-top hover-img" alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                style="width: 100%; height: auto;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['product_name']); ?></h5>
                            <p class="card-text">$<?php echo htmlspecialchars($row['price']); ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>