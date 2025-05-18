<?php
include('vault_connect.php');

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];

    // Use a prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT pid, product_name, product_img, product_img_hover, price FROM products WHERE product_name LIKE ? OR brand LIKE ?");
    $likeQuery = "%$searchQuery%";
    $stmt->execute([$likeQuery, $likeQuery]);

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the search results as HTML
    if ($products) {
        echo '<div class="search-results-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">'; // Flex container for search results

        foreach ($products as $row) { ?>
            <div class="search-result-item" style="flex: 1 1 calc(25% - 20px); max-width: calc(25% - 20px);">
                <!-- Flex child with responsive sizing -->
                <a href="product.php?pid=<?php echo $row['pid']; ?>" style="text-decoration: none; color: inherit;">
                    <div class="card mb-4" style="border: none; display: flex; flex-direction: column; align-items: center;">
                        <div class="img-container" style="padding: 20px;"> <!-- Smaller padding for images -->
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_img']); ?>"
                                class="card-img-top normal-img" alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                style="width: 100%; height: auto; transition: opacity 0.5s ease;">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_img_hover']); ?>"
                                class="card-img-top hover-img" alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                style="width: 100%; height: auto; transition: opacity 0.5s ease;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 14px;"><?php echo htmlspecialchars($row['product_name']); ?>
                            </h5>
                            <p class="card-text" style="font-size: 13px;">
                                $<?php echo htmlspecialchars(number_format($row['price'], 2)); ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php }
        echo '</div>'; // Close the flex container
    } else {
        echo "<p>No products found matching your search.</p>";
    }
}
?>