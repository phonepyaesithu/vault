<?php
session_start();

function isUserExists($conn, $email)
{
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $count = $stmt->fetchColumn();
    return $count > 0;
}

if (isset($_POST["submit"])) {
    include("vault_connect.php");
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isUserExists($conn, $email)) {
        echo "<script>alert('User with $email already exists.')</script>";
    } else {
        // Storing the plain-text password directly (not recommended for security reasons)
        $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':password' => $password, // Directly store the plain-text password
        ]);

        // Set session variables after successful account creation
        $_SESSION['email'] = $email;
        $_SESSION['firstname'] = $firstname;

        // Redirect the user to their account page
        echo "<script>alert('Account created successfully.'); window.location.href='index.php';</script>";
        exit();
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
    <link rel="stylesheet" href="./css/signup.css">
    <link rel="icon" type="image/png" href="pictures/hlogo.png">
    <title>Create Account - HYPELOKAL</title>
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div id="spacer-div" style="height: 70px; background-color: aqua;"></div>

    <form class="signup-form" method="post" action="">
        <h2>Create account</h2>

        <div class="name-row">
            <div class="form-floating form-group">
                <input type="text" class="form-control" id="firstName" name="fname" placeholder="First Name" required>
                <label for="firstName">First Name</label>
            </div>
            <div class="form-floating form-group">
                <input type="text" class="form-control" id="lastName" name="lname" placeholder="Last Name" required>
                <label for="lastName">Last Name</label>
            </div>
        </div>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
            <label for="email">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>

        <button type="submit" name="submit">Create</button>

        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </form>

    <?php include('burger_slider.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/search.js"></script>

</body>

</html>
