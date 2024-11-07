<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homestay Details</title>
    <link rel="icon" href="img/favic.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/homestay_details.css">

    <style>
        .card {
            transition: transform 0.2s; /* Smooth hover effect */
        }

        .card:hover {
            transform: translateY(-5px); /* Lift effect on hover */
        }

        .card-body {
            text-align: left; /* Align text to the left for a cleaner look */
        }

        .btn-primary {
            background-color: #158e49;
            border: none; /* Remove default border */
        }

        .btn-primary:hover {
            background-color: green;
        }
    </style>

</head>
<body>
<?php
    include 'includes/config.php';
    include 'get_homestay.php';

    $homestay_id = isset($_GET['homestay_id']) ? intval($_GET['homestay_id']) : 0;
    $homestay = null;

    try {
        $homestay = getHomestayById($conn, $homestay_id);
        $homestayOptions = getAllHomestaysExcept($conn, $homestay_id);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
?>
    <div class="container">
        <div class="list-container">
            <?php if ($homestay): ?>
                <div class="left-col">
                    <div class="form-header">
                        <h1><?= htmlspecialchars($homestay['name_homestay']); ?></h1>
                    </div>

                    <!-- Image Slider -->
                    <div class="house-choosen-img">
                        <?php include "gallery.php"; ?>
                    </div>

                    <!-- Homestay Information Below Image Slider -->
                    <div class="choosen-house-info">
                        <p>
                            <strong>Location:</strong> <?= htmlspecialchars($homestay['location']); ?><br>
                            <strong>Rooms:</strong> <?= htmlspecialchars($homestay['num_room']); ?><br>
                            <strong>Max Guests:</strong> <?= htmlspecialchars($homestay['max_guest']); ?><br>
                            <strong>Price per Night:</strong> RM <?= htmlspecialchars($homestay['price']); ?><br>
                            <strong>Deposit:</strong> RM <?= htmlspecialchars($homestay['deposit']); ?><br>
                            <strong>Check-in Time:</strong> <?= htmlspecialchars($homestay['check_in_time']); ?><br>
                            <strong>Check-out Time:</strong> <?= htmlspecialchars($homestay['check_out_time']); ?><br>
                        </p>

                        <?php if (!empty($homestay['description'])): ?>
                            <h3>Description</h3>
                            <p><?= nl2br(htmlspecialchars($homestay['description'])); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($homestay['amenities'])): ?>
                            <h3>Amenities</h3>
                            <ul>
                                <?php
                                    $amenitiesArray = explode("\n", $homestay['amenities']);
                                    foreach ($amenitiesArray as $amenity) {
                                        $trimmedAmenity = trim($amenity);
                                        if (!empty($trimmedAmenity)) {
                                            echo '<li><i class="fas fa-star"></i> ' . htmlspecialchars($trimmedAmenity) . "</li>";
                                        }
                                    }
                                ?>
                            </ul>
                        <?php endif; ?>

                        <?php if (!empty($homestay['rules'])): ?>
                            <h3>Rules</h3>
                            <ul>
                                <?php
                                    $rulesArray = explode("\n", $homestay['rules']);
                                    foreach ($rulesArray as $rule) {
                                        $trimmedRule = trim($rule);
                                        if (!empty($trimmedRule)) {
                                            echo '<li><i class="fas fa-star"></i> ' . htmlspecialchars($trimmedRule) . '</li>';
                                        }
                                    }
                                ?>
                            </ul>
                        <?php endif; ?>

                        <h3>Contact Information</h3>
                        <p>
                            <strong>Contact Person:</strong> <?= htmlspecialchars($homestay['contact_person']); ?><br>
                            <strong>Contact Number:</strong> <?= htmlspecialchars($homestay['contact_number']); ?>
                        </p>
                        
                        <?php if (!empty($homestay['alternate_contact_person'])): ?>
                            <p>
                                <strong>Alternate Contact Person:</strong> <?= htmlspecialchars($homestay['alternate_contact_person']); ?><br>
                                <strong>Alternate Contact Number:</strong> <?= htmlspecialchars($homestay['alternate_contact_number']); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Reserve and Back Buttons -->
                        <a class="btn btn-primary" href="booking_form.php?homestay_id=<?= htmlspecialchars($homestay['homestay_id']); ?>">Reserve</a>
                        <a class="btn btn-secondary" href="homestays.php">Back</a>
                    </div>
                </div>

                <!-- Homestay Options Section -->
                <h3>Available Homestays</h3>
                <div class="row">
                    <?php if ($homestayOptions): ?>
                        <?php foreach ($homestayOptions as $option): ?>
                            <div class="col-md-4 mb-4">
                                <a href="homestay_details.php?homestay_id=<?= htmlspecialchars($option['homestay_id']); ?>" class="text-decoration-none">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($option['name_homestay']); ?></h5>
                                            <p class="card-text">
                                                <strong>Location:</strong> <?= htmlspecialchars($option['location']); ?><br>
                                                <strong>Price per Night:</strong> RM <?= htmlspecialchars($option['price']); ?>
                                            </p>
                                            <a href="homestay_details.php?homestay_id=<?= htmlspecialchars($option['homestay_id']); ?>" class="btn btn-primary">View</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No homestays available</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p>Homestay not found.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>
    <script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>

</body>
</html>