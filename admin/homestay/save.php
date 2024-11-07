<?php
// Database connection
include "../../admin/sidebar.php"; 
include '../../includes/config.php';

function save_homestay($conn, $is_update, $params) {
    $sql = $is_update 
        ? "UPDATE tbl_homestays SET 
            name_homestay = ?, max_guest = ?, num_room = ?, price = ?, deposit = ?, 
            check_in_time = ?, check_out_time = ?, location = ?, description = ?, rules = ?, 
            amenities = ?, contact_person = ?, contact_number = ?, alternate_contact_person = ?, 
            alternate_contact_number = ?, image = ? WHERE homestay_id = ?"
        : "INSERT INTO tbl_homestays (
            name_homestay, max_guest, num_room, price, deposit, check_in_time, 
            check_out_time, location, description, rules, amenities, contact_person, 
            contact_number, alternate_contact_person, alternate_contact_number, image
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Adjust type definition based on insert or update
    $types = $is_update ? 'siiidsssssssssssi' : 'siiidsssssssssss';

    $stmt->bind_param($types, ...$params);
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $homestay_id = $_POST['homestay_id'] ?? null;
    $name_homestay = $_POST['name_homestay'] ?? '';
    $max_guest = $_POST['max_guest'] ?? 0; // Assuming 0 if not provided
    $num_room = $_POST['num_room'] ?? 0; // Assuming 0 if not provided
    $price_per_night = $_POST['price_per_night'] ?? 0.0; // Assuming 0.0 if not provided
    $deposit = $_POST['deposit'] ?? 0.0; // Assuming 0.0 if not provided
    $check_in_time = $_POST['check_in_time'] ?? '';
    $check_out_time = $_POST['check_out_time'] ?? '';
    $location = $_POST['location'] ?? '';
    
    $description = null;
    if (isset($_POST['description'])) {
        $description = $_POST['description'];
    }
    
    $rules = null;
    if (isset($_POST['rules'])) {
        $rules = $_POST['rules'];
    }
    
    $amenities = null;
    if (isset($_POST['amenities'])) {
        $amenities = $_POST['amenities'];
    }
    
    $contact_person = $_POST['contact_person'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $alternate_contact_person = $_POST['alternate_contact_person'] ?? '';
    $alternate_contact_number = $_POST['alternate_contact_number'] ?? '';
    
    // Handle image upload
    $image_name = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_path = '../../img/home/' . $image_name;
        move_uploaded_file($image_tmp_name, $image_path);
    } else {
        $image_name = $_POST['current_image'] ?? null;
    }

    // Prepare params for bind_param
    $params = [
        $name_homestay, $max_guest, $num_room, $price_per_night, $deposit, 
        $check_in_time, $check_out_time, $location, $description, $rules, 
        $amenities, $contact_person, $contact_number, $alternate_contact_person, 
        $alternate_contact_number, $image_name
    ];

    if ($homestay_id) {
        $params[] = $homestay_id;  // Add homestay_id for the update
    }

    $is_update = !empty($homestay_id);
    if (save_homestay($conn, $is_update, $params)) {
        header("Location:view_homestay.php");

        echo "Homestay saved successfully!";
    } else {
        echo "Error saving homestay: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../admin/assets/css/style.css">
</head>
<body>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>