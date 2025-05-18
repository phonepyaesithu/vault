<?php
session_start();
include("vault_connect.php");

// Function to check if the user exists in the 'users' table
function getUserByEmail($conn, $email)
{
    // Prepare the query to check for matching email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    // Fetch the user record
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to check if the admin exists in the 'admins' table
function getAdminByEmail($conn, $email)
{
    // Prepare the query to check for matching email
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$email]);

    // Fetch the admin record
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission
if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists with the provided email
    $user = getUserByEmail($conn, $email);

    if ($user && $password === $user['password']) { // Check plain text password
        // Set session variables with user information
        $_SESSION['email'] = $user['email'];
        $_SESSION['firstname'] = $user['firstname'];

        // Redirect to the account page after successful login
        header("Location: index.php");
        exit();
    } else {
        // If not a user, check if the admin exists with the provided email
        $admin = getAdminByEmail($conn, $email);

        if ($admin && $password === $admin['password']) { // Check plain text password
            // Set session variables with admin information
            $_SESSION['email'] = $admin['email'];
            $_SESSION['firstname'] = $admin['firstname'];
            $_SESSION['is_admin'] = true;  // This session variable can help differentiate admin access

            // Redirect to the admin dashboard after successful login
            header("Location: admin/dashboard.php");
            exit();
        } else {
            // Show an alert if both user and admin login fail
            echo "<script>alert('Invalid Email or Password.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="icon" type="image/png" href="pictures/hlogo.png">
    <title>Account - HYPELOKAL</title>
</head>

<body>

    <!-- nav bar -->
    <?php include('navbar.php') ?>

    <div id="spacer-div" style="height: 70px; background-color: aqua;"></div>

    <!-- Login Form -->
    <form class="login-form" method="post" action="">
        <h2>Login</h2>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
            <label for="email">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Sign in</button>

        <div class="login-link">
            <p><a href="signup.php">Create account</a></p>
        </div>
    </form>

    <?php include('burger_slider.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/search.js"></script>

</body>

</html>
