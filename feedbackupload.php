<?php
include('vault_connect.php');
if (isset($_POST["submit-btn"])) {
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];

    if (!empty($email) && !empty($feedback)) {
        $sql = "INSERT INTO feedback (email, feedback) VALUES (:email, :feedback)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':feedback' => $feedback,
        ]);
        echo "<script>
                alert('Feedback Sent.');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Both fields are required.');
                window.location.href = 'index.php';
              </script>";
    }
}
?>
