<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        .container-fluid {
            padding-left: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-top: 100px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary" id="navbar">
        <div class="container-fluid" id="navbar-container">
            <a href="index.php" class="navbar-brand"><img src="/pictures/hypelokal.png" id="logo" width="75px"></a>

            <!-- Navbar Items (visible on larger screens) -->
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-ltr" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-ltr" href="../shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-ltr" href="../contact.php">Contact</a>
                    </li>
                    
                </ul>

                <ul class="form-inline my-2 my-lg-0">
                    <i class="bi bi-search" style="font-size: 19px; cursor: pointer;" data-bs-toggle="modal"
                        data-bs-target="#exampleModal"></i>
                </ul>


                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php if (isset($_SESSION['firstname'])): ?>
                            <!-- If the user is logged in, link to the account page -->
                            <a href="../account.php"><i class="bi bi-person-circle"></i></a>
                        <?php else: ?>
                            <!-- If the user is not logged in, link to the login page -->
                            <a href="../login.php"><i class="bi bi-person-circle"></i></a>
                        <?php endif; ?>
                    </li>

                    <li class="nav-item">
                        <i class="bi bi-bag" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                            <span id="cart-count">(0)</span>
                        </i>
                    </li>
                </ul>
            </div>

            <!-- Burger Menu Button (Visible on small screens) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Offcanvas for Cart -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasCartLabel">Shopping Cart</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="cart-modal-body">
            <button class="btn btn-primary mt-3 w-100" onclick="window.location.href='../checkout.php'">Checkout</button>
            <!-- Add dynamic cart items here -->
        </div>
    </div>



    <!-- Search Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Added modal-lg class -->
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Search</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchInput" class="form-control" placeholder="What are you looking for?"
                        oninput="searchProducts(this.value)">
                    <div id="searchResults" style="margin-top: 20px;">
                        <!-- Real-time search results will appear here -->
                    </div>
                </div>
                
            </div>
        </div>
    </div>


    <script src="../js/navbar_shawdow.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>