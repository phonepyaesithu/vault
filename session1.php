<?php
session_start();
include('vault_connect.php');

// Fetching the users from the database
$sql = "SELECT firstname, lastname, email FROM users";
$stmt = $conn->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Assuming the email was posted via a form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['email'] = $_POST['email'];

    // Check if the email exists in the users table and store the firstname and lastname in session
    foreach ($users as $user) {
        if ($user['email'] === $_SESSION['email']) {
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['logged_in'] = true;
            break;
        }
    }

    // Redirect to index.php after setting the session
    header("Location: index.php");
    exit();
}
?>
