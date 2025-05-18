<?php
try {
    include('../vault_connect.php');

    // Check if user_id is set in the POST request
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Prepare the delete statement
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        // Execute the delete statement
        if ($stmt->execute()) {
            // Redirect back to the user list with a success message
            header("Location: dashboard.php?page=users&message=User deleted successfully");
            exit();
        } else {
            echo "Error deleting user.";
        }
    } else {
        echo "No user ID specified.";
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Close connection
$conn = null;
?>
