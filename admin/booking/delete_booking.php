<?php
    include '../../includes/config.php';


// Check if the homestay_id parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the homestay ID
    $bookingId = $_GET['id'];

    // Prepare the SQL delete query
    $sql = "DELETE FROM tbl_bookings WHERE booking_id = '$bookingId'";

    // Execute the query and check if the deletion was successful
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Booking deleted successfully'); 
        window.location.href = 'bookings_list.php';</script>";
    } else {
        echo "Error deleting booking: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request. No booking ID provided.";
}
?>