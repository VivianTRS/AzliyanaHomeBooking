<?php
session_start();
// Include database connection
include '../../includes/config.php';

$errors = [];
$success_message = '';

if (isset($_POST['btn_reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists in the database
    $user_check_query = "SELECT * FROM tbl_users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($user_check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $errors[] = "Email not found in the database.";
    } else {
        // Generate a unique token for password reset
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", strtotime('+1 day'));

        // Store token and expiration in the database
        $query = "INSERT INTO tbl_password_resets (email, token, expires) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $email, $token, $expires);
        
        if ($stmt->execute()) {
            // Prepare reset link
            $resetLink = "{$base_url}admin/user/reset_password.php?token=" . $token;
            $success_message = "Password reset link has been generated. Please copy the link below:\n\n" . $resetLink;
        } else {
            $errors[] = "Failed to create reset token. Please try again.";
        }
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h4>Forget Password</h4>

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

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label">Email address:</label>
                <div class="col-sm-8">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-group row text-center">
                <div class="col-sm-12">
                    <button type="submit" name="btn_reset" class="btn btn-primary">Reset Password</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>