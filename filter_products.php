<?php
include('vault_connect.php');

// Retrieve brands and categories from the POST request
if (isset($_POST['brands']) && isset($_POST['categories'])) {
    $selectedBrands = json_decode($_POST['brands']);
    $selectedCategories = json_decode($_POST['categories']);

    // Build the base query
    $sql = "SELECT pid, product_name, product_img, product_img_hover, price FROM products WHERE 1=1";
    $params = [];

    // Add filtering by brands if brands are selected
    if (!empty($selectedBrands)) {
        $brandPlaceholders = rtrim(str_repeat('?,', count($selectedBrands)), ',');
        $sql .= " AND brand IN ($brandPlaceholders)";
        $params = array_merge($params, $selectedBrands);
    }

    // Add filtering by categories if categories are selected
    if (!empty($selectedCategories)) {
        $categoryPlaceholders = rtrim(str_repeat('?,', count($selectedCategories)), ',');
        $sql .= " AND product_category IN ($categoryPlaceholders)";
        $params = array_merge($params, $selectedCategories);
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return filtered products as HTML
    foreach ($products as $row) { ?>
        <div class="col-md-3">
            <a href="product.php?pid=<?php echo $row['pid']; ?>" style="text-decoration: none; color: inherit;">
                <div class="card mb-4" style="border: none; display: flex; flex-direction: column; align-items: center;">
                    <div class="img-container" style="padding:40px; padding-top:60px">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_img']); ?>"
                            class="card-img-top normal-img" alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                            style="width: 110%; height: auto; transition: opacity 0.5s ease;">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_img_hover']); ?>"
                            class="card-img-top hover-img" alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                            style="width: 100%; height: auto; transition: opacity 0.5s ease;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 15px;"><?php echo htmlspecialchars($row['product_name']); ?>
                        </h5>
                        <p class="card-text">$<?php echo htmlspecialchars(number_format($row['price'], 2)); ?></p>
                    </div>
                </div>
            </a>
        </div>
    <?php }
}
?>
