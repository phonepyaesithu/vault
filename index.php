<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HYPELOKAL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="icon" type="image/png" href="pictures/hlogo.png">
</head>

<body>


    <?php include('navbar.php'); ?>

    <div id="spacer-div" style="height: 50px; background-color: white;"></div>


    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            <!-- First Carousel Slide -->
            <div class="carousel-item" data-bs-interval="4000">
                <div id="juliusBanner" class="d-block w-100">
                    <a href="../shop.php"><button name="julius_shop_button" id="julius_button">DISCOVER
                            JULIUS</button></a>
                </div>
            </div>


            <!-- Second Carousel Slide -->
            <div class="carousel-item active" data-bs-interval="4000">
                <div id="pafBanner" class="d-block w-100">
                    <a href="../shop.php"><button name="paf_shop_button" id="paf_button">SHOP (PAF)</button></a>
                </div>
            </div>

        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <?php
    // Database connection (using PDO)
    include('vault_connect.php');

    // Query to fetch products
    $sql = "SELECT pid, product_name, product_img, product_img_hover, price FROM products LIMIT 12";
    $stmt = $conn->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <!-- products section -->
    <div class="container mt-5">
        <div class="row">
            <?php foreach ($products as $row) { ?>
                <div class="col-md-3">
                    <!-- Four cards per row -->
                    <a href="product.php?pid=<?php echo $row['pid']; ?>" style="text-decoration: none; color: inherit;">
                        <!-- Link to product detail page -->
                        <div class="card mb-4"
                            style="border: none; display: flex; flex-direction: column; align-items: center;">
                            <!-- Flexbox centering -->
                            <div class="img-container" style="padding:40px; padding-top:60px"
                                style="width: 100%; height: auto; display: flex; justify-content: center; align-items: center;">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_img']); ?>"
                                    class="card-img-top normal-img"
                                    alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                    style="width: 90%; height: auto; transition: opacity 0.5s ease;">
                                <!-- Original image -->
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_img_hover']); ?>"
                                    class="card-img-top hover-img"
                                    alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                    style="width: 80%; height: auto; transition: opacity 0.5s ease;"> <!-- Hover image -->
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



    <?php include('burger_slider.php'); ?>


    <!-- Fetch Feedback -->
    <?php
    // Database connection (using PDO)
    include('vault_connect.php');

    // Query to fetch feedback
    $sql = "SELECT email, feedback FROM feedback";
    $stmt = $conn->query($sql);
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Feedback Carousel -->
    <div id="feedbackCarousel" class="carousel slide mt-5" data-bs-ride="carousel"
        style="border-top: 1px solid rgba(0, 0, 0, 0.059); background-color:rgba(0, 0, 0, 0.059);">
        <div class="carousel-inner">
            <?php $active = true; ?>
            <?php foreach ($feedbacks as $feedback) { ?>
                <div class="carousel-item <?php if ($active) {
                    echo 'active';
                    $active = false;
                } ?>">
                    <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                        <div class="text-center">
                            <h2 class="display-5 font-weight-bold" style="font-size: 30px;">
                                "<?php echo htmlspecialchars($feedback['feedback']); ?>"
                            </h2>
                            <p class="mt-3" style="font-size: 16px;">
                                <?php echo htmlspecialchars($feedback['email']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Carousel controls with black arrows -->
        <button class="carousel-control-prev" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(1);"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(1);"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <?php include('footer.php'); ?>


</body>

</html>

<?php
// Close the connection
$pdo = null;
?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/search.js"></script>
</body>

</html>