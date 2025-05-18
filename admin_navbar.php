<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" type="image/png" href="pictures/hlogo.png">
    <style>
        .container-fluid {
            padding-left: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-top: 100px;
        }

        /* Center logo in the navbar */
        .navbar-brand {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Style the account icon to the right */
        .account-icon {
            margin-left: auto;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary" id="navbar">
        <div class="container-fluid" id="navbar-container">
            <!-- Centered Logo -->
            <a href="dashboard.php" class="navbar-brand"><img src="/pictures/hypelokal.png" id="logo" width="200px"></a>

            <!-- Account Icon (right aligned) -->
            <ul class="navbar-nav account-icon">
                <li class="nav-item">
                    <!-- <?php if (isset($_SESSION['firstname'])): ?>
                        <a href="../account.php"><i class="bi bi-person-circle"></i></a>
                    <?php else: ?>
                        <a href="../login.php"><i class="bi bi-person-circle"></i></a>
                    <?php endif; ?> -->
                    <a href="../logout.php"><i class="bi bi-box-arrow-right"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>