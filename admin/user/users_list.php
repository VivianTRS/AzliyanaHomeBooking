<?php
// Include database connection and sidebar
include "../../admin/sidebar.php"; 
include '../../includes/config.php';

// Fetch Users
$usersQuery = "SELECT * FROM tbl_users";
$usersResult = mysqli_query($conn, $usersQuery);
if (!$usersResult) {
    die("Error fetching users: " . mysqli_error($conn));
}

// Delete User
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    
    $stmt = $conn->prepare("DELETE FROM tbl_users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        echo "<script>alert('Users deleted successfully'); </script>";
        header('Location: users_list.php');
        exit();
    } else {
        die("Error deleting user: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Users</h2>
        <a href="add_admin.php" class="btn btn-success mb-3">Add User</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($usersResult) > 0) { ?>
                    <?php while ($user = mysqli_fetch_assoc($usersResult)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="users_list.php?delete=<?php echo $user['user_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center">No users found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>