<?php
try {
    include('../vault_connect.php');
    $sql = "SELECT user_id, firstname, lastname, email FROM users";
    $stmt = $conn->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>

<head>
    <style>
        .user-table {
            border-collapse: collapse;
            border: 1px solid #ccc;
            width: 80%;
        }

        .user-table th,
        .user-table td {
            background-color: white;
            padding: 1px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .user-table th {
            background-color: #f2f2f2;
        }

        .delete-button {
            color: white;
            background-color: red;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

<div class="container">
    <?php
    // Display success message if it exists
    if (isset($_GET['message'])) {
        echo "<p class='message'>" . htmlspecialchars($_GET['message']) . "</p>";
    }
    ?>
    <table class="user-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Action</th> <!-- New column for the action -->
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($users as $user) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                    <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <form method="post" action="delete_user.php"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php
            } ?>
        </tbody>
    </table>
</div>

<?php
// Close connection
$conn = null;
?>