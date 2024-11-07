<?php
session_start();
require '../includes/config.php';

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL query to prevent SQL injection
    $query = "SELECT * FROM tbl_users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found
        $logged_in_user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $logged_in_user['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $logged_in_user['username'];  // Corrected line
            $_SESSION['user'] = $logged_in_user;

            // Redirect based on user type
            if ($logged_in_user['user_type'] == 'Admin') {
                header("Location: index.php");
                exit();
            } elseif ($logged_in_user['user_type'] == 'Guest') {
                header("Location: ../guest/index.php");
                exit();
            } else {
                $errors[] = "Unknown user type.";
            }
        } else {
            $errors[] = "Invalid email or password.";
        }
    } else {
        $errors[] = "Invalid email or password.";
    }

    // Display errors if any
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: login.php");
        exit();
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
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['errors'])) {
                            foreach ($_SESSION['errors'] as $error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                            unset($_SESSION['errors']);
                        }
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" name="btn_login" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>Forgot your password? <a href="../admin/user/forget_password.php">Reset it here</a></small>
                        <br>
                        <a href="../index.php" class="btn btn-secondary mt-3">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>