<?php
// Include database connection file
require_once 'vault_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form inputs
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    try {
        // Prepare an SQL statement to insert form data
        $stmt = $conn->prepare("INSERT INTO contact (firstname, lastname, email, message) VALUES (:firstname, :lastname, :email, :message)");

        // Bind parameters
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>
                alert('Message sent successfully!');
                window.location.href = 'contact.php';
              </script>";
        } else {
            echo "<script>
                alert('Error. Could not send message!');
                window.location.href = 'contact.php';
              </script>";
        }
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
}
?>