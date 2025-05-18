<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOP - HYPELOKAL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" type="image/png" href="pictures/hlogo.png">
</head>

<body>

    <?php include("navbar.php"); ?>
    <div id="spacer-div" style="height: 70px; background-color: white;"></div>

    <div class="filter-row text-center mt-4">
        <button id="filter-btn" class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            FILTER<i class="bi bi-funnel-fill"></i>
        </button>
    </div>

    <!-- Offcanvas Sidebar -->


    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <!-- <h5 class="offcanvas-title" id="offcanvasExampleLabel">FILTER MENU</h5> -->
            <i id="filter-clear" class="fa-solid fa-filter-circle-xmark" onclick="clearFilters()"
                style="cursor: pointer;"></i>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <hr class="dropdown-divider">
        <div class="offcanvas-body">
            <div>
                <h6>BRANDS</h6>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                        value="HYPELOKAL" onclick="filterProducts()">
                    <label class="form-check-label" for="inlineCheckbox1">HYPELOKAL</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                        value="POST ARCHIVE FACTION (PAF)" onclick="filterProducts()">
                    <label class="form-check-label" for="inlineCheckbox1">POST ARCHIVE FACTION (PAF)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="MOWALOLA"
                        onclick="filterProducts()">
                    <label class="form-check-label" for="inlineCheckbox2">Mowalola</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="JULIUS"
                        onclick="filterProducts()">
                    <label class="form-check-label" for="inlineCheckbox3">JULIUS</label>
                </div>


                <hr class="dropdown-divider">

                <h6>CATEGORIES</h6>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="Top"
                        onclick="filterProducts()">
                    <label class="form-check-label" for="inlineCheckbox3">TOP</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="Bottoms"
                        onclick="filterProducts()">
                    <label class="form-check-label" for="inlineCheckbox4">BOTTOMS</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="Accessories"
                        onclick="filterProducts()">
                    <label class="form-check-label" for="inlineCheckbox5">ACCESSORIES</label>
                </div>


            </div>
        </div>



    </div>



    <!-- PHP Logic for Products -->
    <?php
    include('vault_connect.php');

    // Fetch total number of products
    $total_products = "SELECT COUNT(*) AS total_products FROM products";
    $total_products_result = $conn->query($total_products);
    $total_products_row = $total_products_result->fetch(PDO::FETCH_ASSOC);
    $total_products = $total_products_row['total_products'];

    // Pagination setup
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $products_per_page = 16;
    $total_pages = ceil($total_products / $products_per_page);
    $offset = ($page - 1) * $products_per_page;

    // Fetch products with pagination
    $sql = "SELECT pid, product_name, product_img, product_img_hover, price FROM products ORDER BY pid LIMIT 16 OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>



    <!-- Products Section -->
    <div class="container mt-5">
        <div class="row">
            <?php foreach ($products as $row) { ?>
                <div class="col-md-3">
                    <a href="product.php?pid=<?php echo $row['pid']; ?>" style="text-decoration: none; color: inherit;">
                        <div class="card mb-4" style="border: none; text-align: center;">
                            <div class="img-container" style="padding: 20px;">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_img']); ?>"
                                    class="card-img-top normal-img"
                                    alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                    style="transition: opacity 0.5s ease;">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_img_hover']); ?>"
                                    class="card-img-top hover-img"
                                    alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                    style="transition: opacity 0.5s ease;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" style="font-size: 15px;">
                                    <?php echo htmlspecialchars($row['product_name']); ?>
                                </h5>
                                <p class="card-text">$<?php echo htmlspecialchars(number_format($row['price'], 2)); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
            <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

    <?php include('burger_slider.php'); ?>
    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and Popper.js -->
    <script src="../js/filter.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/search.js"></script>
    <script src="../js/cart_function.js"></script>

</body>

</html>