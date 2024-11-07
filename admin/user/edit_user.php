<?php
// Include database connection and sidebar
include "../../admin/sidebar.php"; 
include '../../includes/config.php';

$errors = [];
$admin = []; // Initialize $admin to avoid undefined variable warnings

// Check if the admin ID is passed via GET
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    // Fetch the admin's data
    $query = "SELECT * FROM tbl_users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the admin exists
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
    } else {
        $_SESSION['errors'] = ['Admin not found'];
        header("Location: manage_admins.php");
        exit();
    }

    $stmt->close();
}

// Handle form submission for editing admin details
if (isset($_POST['btn_edit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

    // Check if passwords match, only if user intends to change the password
    if (!empty($password_1) && $password_1 !== $password_2) {
        $errors[] = "Passwords do not match";
    }

    // Check if the email has been changed and if it already exists in the database
    if ($email !== $admin['email']) {
        $user_check_query = "SELECT * FROM tbl_users WHERE email = ? AND user_id != ?";
        $stmt = $conn->prepare($user_check_query);
        $stmt->bind_param("si", $email, $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Email already exists";
        }

        $stmt->close();
    }

    // If no errors, update the admin details
    if (count($errors) == 0) {
        if (!empty($password_1)) {
            // Hash the new password if provided
            $hashedPassword = password_hash($password_1, PASSWORD_DEFAULT);
            $query = "UPDATE tbl_users SET username = ?, email = ?, password = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $username, $email, $hashedPassword, $admin_id);
        } else {
            // Update without changing the password
            $query = "UPDATE tbl_users SET username = ?, email = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $username, $email, $admin_id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Admin details updated successfully!');</script>";
            header("Location: users_list.php"); // Redirect to the same page with admin ID
            exit();
        } else {
            $errors[] = "Failed to update admin details. Please try again.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>

    </style>
</head>
<body>
    <div class="container mt-5">
        <h4>Edit Admin</h4>

        <!-- Display errors -->
        <?php
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            unset($_SESSION['errors']);
        }
        ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$admin_id"); ?>" method="POST">
            <div class="form-group row">
                <label for="username" class="col-sm-4 col-form-label">Username:</label>
                <div class="col-sm-8">
                    <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($admin['username']) ? htmlspecialchars($admin['username']) : ''; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label">Email address:</label>
                <div class="col-sm-8">
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($admin['email']) ? htmlspecialchars($admin['email']) : ''; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="password_1" class="col-sm-4 col-form-label">New Password (leave blank if not changing):</label>
                <div class="col-sm-8 input-group">
                    <input type="password" name="password_1" id="password_1" class="form-control" placeholder="Enter new password">
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
                    <input type="password" name="password_2" id="password_2" class="form-control" placeholder="Confirm new password">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword2">
                        <i class="fa fa-eye" id="eyeIcon2"></i>
                    </button>
                </div>
            </div>

            <div class="form-group row text-center">
                <div class="col-sm-12">
                    <button type="submit" name="btn_edit" class="btn btn-primary">Update Admin</button>
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