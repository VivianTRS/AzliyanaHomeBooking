<?php
// Include database configuration
include "includes/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data from the request
    $homestay_id = $_POST['homestay_id'];
    $check_in = $_POST['check_in_date'];
    $check_out = $_POST['check_out_date'];

    // Debugging output for server logs
    error_log("Homestay ID: " . $homestay_id);
    error_log("Check-in Date: " . $check_in);
    error_log("Check-out Date: " . $check_out);

    // Validate that the check-in date is before the check-out date
    if (strtotime($check_in) >= strtotime($check_out)) {
        echo json_encode(['status' => 'error', 'message' => 'Check-out date must be later than check-in date.']);
        exit;
    }

    // Query to check for any existing bookings that overlap with the given dates
    $sql = "SELECT * FROM tbl_bookings 
            WHERE homestay_id = ? 
            AND (check_in_date < ? AND check_out_date > ?)";
    // Explanation: This query checks if there's any booking where the existing 
    // check_in_date is before the new check_out date, and the existing check_out_date is after the new check_in date.
    
    // Prepare and bind the query parameters to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $homestay_id, $check_out, $check_in); // Bind homestay_id, check_out, and check_in
    $stmt->execute(); // Execute the query

    // Fetch the result of the query
    $result = $stmt->get_result();

    // Debugging output to check how many bookings were found
    error_log("Number of Rows: " . $result->num_rows);

    // If there are rows returned, the homestay is unavailable for the requested dates
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'unavailable', 'message' => 'The selected homestay is unavailable for the given dates.']);
    } else {
        // If no rows are returned, the homestay is available for booking
        echo json_encode(['status' => 'available', 'message' => 'The homestay is available for booking.']);
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>