<?php

// Include database connection and sidebar
include "../../admin/sidebar.php"; 
include '../../includes/config.php';

$errors = [];

if (isset($_POST['btn_signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

    // Check if passwords match
    if ($password_1 !== $password_2) {
        $errors[] = "Passwords do not match";
    }

    // Check if email already exists
    $user_check_query = "SELECT * FROM tbl_users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($user_check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = "Email already exists";
    }

    // Register the user if there are no errors
    if (count($errors) == 0) {
        // Hash the password
        $hashedPassword = password_hash($password_1, PASSWORD_DEFAULT);

        // Insert user into the database
        $query = "INSERT INTO tbl_users (username, email, password, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            // Set session variables and redirect to the home page
            $_SESSION['email'] = $email;
            $_SESSION['user'] = $stmt->insert_id; // Storing user ID or other relevant info

            header("Location: ../index.php");
            exit();
        } else {
            $errors[] = "Failed to register user. Please try again.";
        }
    }

    // Display errors if any
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location: add_admin.php");
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
    <title>Signup</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h4>Add Admin</h4>

        <!-- Display errors -->
        <?php
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            unset($_SESSION['errors']);
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group row">
                <label for="username" class="col-sm-4 col-form-label">Username:</label>
                <div class="col-sm-8">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label">Email address:</label>
                <div class="col-sm-8">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="password_1" class="col-sm-4 col-form-label">Password:</label>
                <div class="col-sm-8 input-group">
                    <input type="password" name="password_1" id="password_1" class="form-control" placeholder="Enter password" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword1">
                            <i class="fa fa-eye" id="eyeIcon1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="password_2" class="col-sm-4 col-form-label">Confirm Password:</label>
                <div class="col-sm-8 input-group">
                    <input type="password" name="password_2" id="password_2" class="form-control" placeholder="Confirm password" required>

                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword2">
                            <i class="fa fa-eye" id="eyeIcon2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group row text-center">
                <div class="col-sm-12">
                    <button type="submit" name="btn_signup" class="btn btn-primary">Add Admin</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('togglePassword1').addEventListener('click', function () {
            const passwordField = document.getElementById('password_1');
            const eyeIcon = document.getElementById('eyeIcon1');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        document.getElementById('togglePassword2').addEventListener('click', function () {
            const passwordField = document.getElementById('password_2');
            const eyeIcon = document.getElementById('eyeIcon2');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>