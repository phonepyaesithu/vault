<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../admin_styles.css">


</head>

<body>

    <?php include('../admin_navbar.php'); ?>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-box-seam"></i> Products
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?page=add_product">Add Product</a></li>
                                <li><a class="dropdown-item" href="?page=display_products">Display Products</a></li>
                                <li><a class="dropdown-item" href="?page=manage_products">Manage Products</a></li>
                                <li><a class="dropdown-item" href="?page=manage_stock">Manage Stock</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-gear"></i> Manage Other
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?page=users">Users</a></li>
                                <li><a class="dropdown-item" href="?page=feedbacks">Feedbacks</a></li>
                                <!-- <li><a class="dropdown-item" href="?page=admins">Admins</a></li> -->
                                <!-- <li><a class="dropdown-item" href="?page=orders">Orders</a></li> -->
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="row">
                    <?php
                    if (isset($_GET['page'])) {
                        // Dynamically include the page based on the 'page' parameter
                        $page = $_GET['page'];

                        // Only include the page once based on the condition
                        if ($page === 'add_product') {
                            include('add_product.php');
                        } elseif ($page === 'display_products') {
                            include('display_products.php');
                        } elseif ($page === 'manage_products') {
                            include('manage_products.php');
                        } elseif ($page == 'manage_stock') {
                            include('manage_stock.php');
                        } elseif ($page == 'edit_product') {
                            include('edit_product.php');
                        } elseif ($page == 'users') {  // Correct the condition for users.php
                            include('users.php');

                        } elseif ($page == 'feedbacks') {
                            include('feedbacks.php');
                        }
                        // } elseif ($page == 'orders.php') {
                        // //     include('orders.php');
                        // }
                    
                    } else {
                        // Default page if no 'page' parameter is set
                        include('display_products.php');
                    }
                    ?>
                </div>
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/navbar_shawdow.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>