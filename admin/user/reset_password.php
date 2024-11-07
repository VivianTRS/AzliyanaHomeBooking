<?php
session_start();
include '../../includes/config.php';

$errors = [];
$success_message = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate the token
    $query = "SELECT email FROM tbl_password_resets WHERE token = ? AND expires > NOW() LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $errors[] = "Invalid or expired token.";
    } else {
        // Token is valid, proceed to reset the password
        if (isset($_POST['btn_update'])) {
            $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $email = $result->fetch_assoc()['email'];

            // Update the password in the database
            $update_query = "UPDATE tbl_users SET password = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ss", $hashedPassword, $email);
            if ($update_stmt->execute()) {
                $success_message = "Password has been updated successfully.";
                // Optionally, delete the token from the database
                $delete_query = "DELETE FROM tbl_password_resets WHERE token = ?";
                $delete_stmt = $conn->prepare($delete_query);
                $delete_stmt->bind_param("s", $token);
                $delete_stmt->execute();
            } else {
                $errors[] = "Failed to update password. Please try again.";
            }
        }
    }
} else {
    $errors[] = "No token provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h4>Reset Password</h4>

        <!-- Display success message -->
        <?php
        if (!empty($success_message)) {
            echo "<div class='alert alert-success'>$success_message</div>";
        }
        ?>

        <!-- Display errors -->
        <?php
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?token=' . $token); ?>" method="POST">
            <div class="form-group row">
                <label for="new_password" class="col-sm-4 col-form-label">New Password:</label>
                <div class="col-sm-8">
                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password" required>
                </div>
            </div>

            <div class="form-group row text-center">
                <div class="col-sm-12">
                    <button type="submit" name="btn_update" class="btn btn-primary">Update Password</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>