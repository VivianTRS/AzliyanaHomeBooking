<?php 
    include "../../admin/sidebar.php"; 
    include '../../includes/config.php';
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM tbl_homestays WHERE homestay_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $homestay = $result->fetch_assoc();
    }    
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_GET['id']) ? 'Update Homestay' : 'Add New Homestay'; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/form.css">

</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo isset($_GET['id']) ? 'Update' : 'Add'; ?> Homestay</h1>
        <form action="save.php" method="post" enctype="multipart/form-data">
            <!-- Hidden field for homestay_id (if updating) -->
            <input type="hidden" name="homestay_id" 
                value="<?php echo isset($homestay['homestay_id']) ? htmlspecialchars($homestay['homestay_id']) : ''; ?>">

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="name_homestay">Homestay Name:</label>
                    <input type="text" class="form-control" id="name_homestay" name="name_homestay" 
                        value="<?php echo isset($homestay['name_homestay']) ? htmlspecialchars($homestay['name_homestay']) : ''; ?>" required>
                </div>

            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="max_guest">Max Guests:</label>
                    <input type="number" class="form-control" id="max_guest" name="max_guest" 
                        value="<?php echo isset($homestay['max_guest']) ? htmlspecialchars($homestay['max_guest']) : ''; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="num_room">Number of Rooms:</label>
                    <input type="number" class="form-control" id="num_room" name="num_room" 
                        value="<?php echo isset($homestay['num_room']) ? htmlspecialchars($homestay['num_room']) : ''; ?>" required>
                </div>

            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="price_per_night">Price per Night:</label>
                    <input type="number" step="0.01" class="form-control" id="price_per_night" name="price_per_night" 
                        value="<?php echo isset($homestay['price']) ? htmlspecialchars($homestay['price']) : ''; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="deposit">Deposit:</label>
                    <input type="number" step="0.01" class="form-control" id="deposit" name="deposit" 
                        value="<?php echo isset($homestay['deposit']) ? htmlspecialchars($homestay['deposit']) : ''; ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="check_in_time">Check-In Time:</label>
                    <input type="time" class="form-control" id="check_in_time" name="check_in_time" 
                        value="<?php echo isset($homestay['check_in_time']) ? htmlspecialchars($homestay['check_in_time']) : ''; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="check_out_time">Check-Out Time:</label>
                    <input type="time" class="form-control" id="check_out_time" name="check_out_time" 
                        value="<?php echo isset($homestay['check_out_time']) ? htmlspecialchars($homestay['check_out_time']) : ''; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" 
                    value="<?php echo isset($homestay['location']) ? htmlspecialchars($homestay['location']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4">
                    <?php echo isset($homestay['description']) ? htmlspecialchars($homestay['description']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="rules">Rules:</label>
                <textarea class="form-control" id="rules" name="rules" rows="4">
                    <?php echo isset($homestay['rules']) ? htmlspecialchars($homestay['rules']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="amenities">Amenities:</label>
                <textarea class="form-control" id="amenities" name="amenities" rows="4">
                    <?php echo isset($homestay['amenities']) ? htmlspecialchars($homestay['amenities']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="contact_person">Contact Person:</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" 
                    value="<?php echo isset($homestay['contact_person']) ? htmlspecialchars($homestay['contact_person']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" 
                    value="<?php echo isset($homestay['contact_number']) ? htmlspecialchars($homestay['contact_number']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="alternate_contact_person">Alternate Contact Person:</label>
                <input type="text" class="form-control" id="alternate_contact_person" name="alternate_contact_person" 
                    value="<?php echo isset($homestay['alternate_contact_person']) ? htmlspecialchars($homestay['alternate_contact_person']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="alternate_contact_number">Alternate Contact Number:</label>
                <input type="text" class="form-control" id="alternate_contact_number" name="alternate_contact_number" 
                    value="<?php echo isset($homestay['alternate_contact_number']) ? htmlspecialchars($homestay['alternate_contact_number']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image">

                <?php if (isset($homestay['image']) && $homestay['image']): ?>
                    <div class="mb-3">
                        <img src="../../img/home/<?php echo htmlspecialchars($homestay['image']); ?>" alt="Homestay Image" class="img-thumbnail" width="150">
                        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($homestay['image']); ?>">
                    </div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block"><?php echo isset($_GET['id']) ? 'Update' : 'Add'; ?> Homestay</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>