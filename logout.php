<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<body>

    <script>
        // Redirect to login page
        window.location.href = "login.php";
    </script>

</body>
</html>
