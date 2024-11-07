<?php
session_start();
include 'includes/config.php';

$id = $_GET['id'];
$status = $_GET['status_id'] ?? null;
$transaction_id = $_GET['transaction_id'] ?? null;

// Determine success or failure message
$x = ($status == 1) ? 'Success' : 'Failed';

if ($status == 1) {
    // Update query for successful payment
    $update = "UPDATE `tbl_bookings` SET `payment_status` = 'paid' WHERE booking_id = ?";
    
    $stmt = $conn->prepare($update);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>
            alert('Yay! Booking has been Confirmed!');
            setTimeout(function() {
                window.location.href = 'send_receipt.php';
            }, 1000);
            setTimeout(function() {
                window.location.href = 'booking_details.php';
            }, 3000);
        </script>";
    } else {
        die("Error saving booking: " . $stmt->error);
    }
    $stmt->close();
} else {
    // Delete query for failed payment
    $delete = "DELETE FROM `tbl_bookings` WHERE booking_id = ?";
    $stmt = $conn->prepare($delete);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo ("<script>
            alert('Whoops! Payment Failed! Please try again!');
            window.location.href = 'homestays.php';
        </script>");
    } else {
        die("Error deleting booking: " . $stmt->error);
    }
    $stmt->close();
}
$conn->close();
?>