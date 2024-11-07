<?php 
    include "../sidebar.php"; 
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">

</head>
<body>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2>View Booking</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Homestay Name</th>
                    <th>Total Payment (MYR)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../../includes/config.php';

                $sql = "SELECT b.*, h.name_homestay 
                FROM tbl_bookings b 
                JOIN tbl_homestays h ON b.homestay_id = h.homestay_id
                ORDER BY 
                    CASE 
                        WHEN b.check_in_date >= CURDATE() THEN 0 
                        ELSE 1 
                    END, 
                    b.check_in_date ASC;";
                
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['guest_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['contact_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['check_in_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['check_out_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name_homestay']) . "</td>"; // Using the homestay name from the join
                        echo "<td>RM" . number_format($row['total_amount'], 2) . "</td>";
                        echo "<td>
                                <a href='booking_details.php?id=" . $row['booking_id'] . "' 
                                    class='btn btn-warning btn-sm' aria-label='View Booking'>
                                    <i class='fas fa-eye'></i> View
                                </a><br>

                                <a href='delete_booking.php?id=" . $row['booking_id'] . "' 
                                class='btn btn-danger btn-sm' aria-label='Delete Booking' 
                                onclick=\"return confirm('Are you sure you want to delete this booking?');\">
                                <i class='fas fa-trash'></i> Delete</a><br>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No bookings found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>