<?php

session_start();

// Database connection setup
include('vault_connect.php');

// Getting the product ID from GET request
$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 1;

// Fetching product details
$stmt = $conn->prepare("SELECT * FROM products WHERE pid = :pid");
$stmt->execute(['pid' => $pid]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if product exists
if (!$product) {
    echo "Product not found!";
    exit; // Exit the script or redirect to another page
}

// Fetching random products for "You may also like", excluding the current product
$randomStmt = $conn->prepare("SELECT * FROM products WHERE pid != :pid ORDER BY RAND() LIMIT 4");
$randomStmt->execute(['pid' => $pid]);
$randomProducts = $randomStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetching product stock details
$stock_stmt = $conn->prepare("SELECT * FROM stock WHERE pid = :pid");
$stock_stmt->execute(['pid' => $pid]);
$product_stock = $stock_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($product['product_name']); ?> - HYPELOKAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/product.css">
    <link rel="icon" type="image/png" href="pictures/hlogo.png">

    <!-- Add other head elements and styles here -->
</head>

<body>
    <?php include('navbar.php') ?>

    <div id="spacer-div" style="height: 70px; background-color: white;"></div>

    <div class="container mt-3">
        <div class="row">
            <!-- Product Image and Slider -->

            <div class="col-md-6" id="productpage-img">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['product_img']); ?>"
                    alt="<?php echo htmlspecialchars($product['product_name']); ?>" style="width:100%;">
                <!-- Slider for other images would go here -->
            </div>


            <!-- Product Information -->
            <div class="col-md-6" id="product-info">
                <p style="font-size:14px;"><?php echo htmlspecialchars($product['brand']); ?></p>
                <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
                <p style="letter-spacing: 1px;">$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?>
                </p>

                <!-- Stock availability -->
                <?php if ($product_stock && $product_stock['stock'] > 0): ?>
                    <div class="addtocart-btn">
                        <button type="button" name="addtocart-button" class="btn btn-primary" style="letter-spacing: 1.5px;"
                            onclick="addToCart(<?php echo $pid; ?>, <?php echo htmlspecialchars($product['price']); ?>, '<?php echo addslashes($product['product_name']); ?>', '<?php echo base64_encode($product['product_img']); ?>', <?php echo $product_stock['stock']; ?>)">
                            <i class="bi bi-bag" style="color:white"></i> ADD TO CART
                        </button>


                    </div>
                <?php else: ?>
                    <div class="out-of-stock">
                        <button type="button" class="btn btn-secondary" disabled>
                            OUT OF STOCK
                        </button>
                    </div>
                <?php endif; ?>

                <p><?php echo htmlspecialchars($product['description']); ?></p>

                <hr class="dropdown-divider">

                <p class="d-inline-flex gap-1">
                    <button class="btn btn-link text-decoration-none"
                        style="color: black; font-family:SFBold; padding:0" data-bs-toggle="collapse"
                        href="#collapseMaterials" role="button" aria-expanded="false" aria-controls="collapseMaterials">
                        Materials
                        <span class="text-muted"><i class="bi bi-chevron-down" id="chevron"></i></span>
                    </button>
                </p>
                <div class="collapse" id="collapseMaterials">
                    <div class="card-body" style="text-align:justify; padding:0;">
                        <p><?php echo htmlspecialchars($product['materials']); ?></p>
                    </div>
                </div>

                <hr class="dropdown-divider">

                <p class="d-inline-flex gap-1">
                    <button class="btn btn-link text-decoration-none"
                        style="color: black; font-family:SFBold; padding:0" data-bs-toggle="collapse"
                        href="#collapseCare" role="button" aria-expanded="false" aria-controls="collapseCare">
                        Care Instructions
                        <span class="text-muted"><i class="bi bi-chevron-down" id="chevron"></i></span>
                    </button>
                </p>
                <div class="collapse" id="collapseCare">
                    <div class="card-body" style="text-align:justify; padding:0;">
                        <p><?php echo htmlspecialchars($product['care']); ?></p>
                    </div>
                </div>

                <hr class="dropdown-divider">

                <p style="text-decoration:underline; font-size:10px; letter-spacing:1.5px"><a
                        href="refundpolicy.php">SHIPPING & RETURNS</a> </p>

            </div>

        </div>

        <!-- You May Also Like Section -->
        <div class="row mt-3 d-flex justify-content-center align-items-stretch">
            <p
                style="text-decoration: underline; font-size:13px; text-align: center; width: 100%; padding-bottom: 30px;">
                YOU MAY ALSO LIKE
            </p>
            <?php foreach ($randomProducts as $randomProduct) { ?>
                <div class="col-md-3 d-flex">
                    <a href="product.php?pid=<?php echo $randomProduct['pid']; ?>"
                        style="text-decoration: none; color: inherit; width: 100%;">
                        <div class="card" style="width:fit-content; display: flex; flex-direction: column; border:none">
                            <div class="img-container"
                                style="flex-grow: 1; display: flex; justify-content: center; align-items: center;">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($randomProduct['product_img']); ?>"
                                    class="card-img-top normal-img"
                                    alt="<?php echo htmlspecialchars($randomProduct['product_name']); ?>"
                                    style="width: 78%; height: auto; transition: opacity 0.5s ease;">
                                <!-- Original image -->
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($randomProduct['product_img_hover']); ?>"
                                    class="card-img-top hover-img"
                                    alt="<?php echo htmlspecialchars($randomProduct['product_name']); ?>"
                                    style="width: 83%; height: auto; transition: opacity 0.5s ease;"> <!-- Hover image -->
                            </div>
                            <div class="card-body" style="font-size:15px">
                                <h5 class="card-title" style="font-size:15px">
                                    <?php echo htmlspecialchars($randomProduct['product_name']); ?>
                                </h5>
                                <p class="card-text">
                                    $<?php echo htmlspecialchars(number_format($randomProduct['price'], 2)); ?></p>

                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>


    </div>
    </div>

    <?php include('burger_slider.php') ?>

    <?php include('footer.php') ?>

    <script>
        let cartItems = [];

        // Add product to cart
        function addToCart(productId, productPrice, productName, productImage, productStock) {
            let item = cartItems.find(item => item.id === productId);

            if (item) {
                if (item.quantity < item.stock) {
                    item.quantity++;
                } else {
                    alert(`Only ${item.stock} items available in stock.`);
                    return;
                }
            } else {
                cartItems.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    quantity: 1,
                    stock: productStock // Pass the correct stock value
                });
            }

            updateCart();
        }



        // Update cart modal
        function updateCart() {
            let cartBody = document.getElementById('cart-modal-body');
            let cartCount = document.getElementById('cart-count');

            if (cartItems.length === 0) {
                cartBody.innerHTML = '<p>Your cart is currently empty.</p>';
                cartCount.textContent = '(0)';
                return;
            }

            let cartHtml = '<ul class="list-group">';
            let totalQuantity = 0;

            cartItems.forEach(item => {
                totalQuantity += item.quantity;

                cartHtml += `
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <img src="data:image/jpeg;base64,${item.image}" alt="${item.name}" style="width: 50px; height: 50px;"/>
            <span>${item.name}</span>
            <span>$${item.price}</span>
            <div>
                <button class="btn btn-sm btn-light" onclick="decreaseQuantity(${item.id})">-</button>
                <span>${item.quantity}</span>
                <button class="btn btn-sm btn-light" onclick="increaseQuantity(${item.id})">+</button>
            </div>
            <button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Remove</button>
        </li>
        `;
            });

            // Add a form for checkout and a hidden input field for passing cart data
            cartHtml += `
        </ul>
        <form action="../checkout.php" method="POST" id="checkout-form">
            <input type="hidden" name="cartData" id="cartData" value=''>
            <button type="submit" class="btn btn-primary mt-3 w-100">Checkout</button>
        </form>
    `;

            cartBody.innerHTML = cartHtml;

            // Update the cart count in the navbar
            cartCount.textContent = `(${totalQuantity})`;

            // Set the hidden input field value with the cart items in JSON format
            document.getElementById('cartData').value = JSON.stringify(cartItems);

            // Check if user is logged in before allowing checkout
            <?php if (!isset($_SESSION['email'])): ?>
                alert("You need to log in before proceeding to checkout.");
                window.location.href = "login.php";  // Redirect to login page if not logged in
            <?php endif; ?>
        }


        // Increase quantity
        function increaseQuantity(productId) {
            let item = cartItems.find(item => item.id === productId);

            if (item.quantity < item.stock) {
                item.quantity++;
            } else {
                alert(`Only ${item.stock} items available in stock.`);
            }

            updateCart();
        }

        // Decrease quantity
        function decreaseQuantity(productId) {
            let item = cartItems.find(item => item.id === productId);

            if (item.quantity > 1) {
                item.quantity--;
            } else {
                removeFromCart(productId);
            }

            updateCart();
        }

        // Remove item from cart
        function removeFromCart(productId) {
            cartItems = cartItems.filter(item => item.id !== productId);
            updateCart();
        }

    </script>



    <script src="../js/search.js"></script>

    <!-- Include Bootstrap JS and any other scripts. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>







</body>

</html>