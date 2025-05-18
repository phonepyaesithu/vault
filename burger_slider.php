<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Off-canvas (Slider Modal) -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Blog</a>
                </li> -->
                <li class="nav-item">
                    <?php if (isset($_SESSION['firstname'])): ?>
                        <!-- If the user is logged in, link to the account page -->
                        <a class="nav-link" href="../account.php">Account</a>
                    <?php else: ?>
                        <!-- If the user is not logged in, link to the login page -->
                        <a class="nav-link" href="../login.php">Account</a>
                    <?php endif; ?>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#">Cart</a>
                </li>
            </ul>
        </div>
    </div>

</body>

</html>