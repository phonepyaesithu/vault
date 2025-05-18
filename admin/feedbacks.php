<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
include('../vault_connect.php');

// Fetch feedback
$stmt = $conn->prepare("SELECT email, feedback FROM feedback");
$stmt->execute();
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedbacks</title>
</head>
<body>
    <h1>Feedbacks</h1>
    <table border="1">
        <tr>
            <th>Email</th>
            <th>Feedback</th>
        </tr>
        <?php foreach ($feedbacks as $feedback): ?>
            <tr>
                <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                <td><?php echo htmlspecialchars($feedback['feedback']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
