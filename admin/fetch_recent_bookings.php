<?php
include('../includes/config.php');

$year = $_POST['year'] ?? 'all';
$month = $_POST['month'] ?? 'all';

// Start the query for recent bookings
$query = "SELECT tbl_bookings.booking_id, 
                 tbl_homestays.name_homestay AS homestay_name, 
                 tbl_bookings.check_in_date, 
                 tbl_bookings.check_out_date, 
                 tbl_bookings.total_amount 
          FROM tbl_bookings 
          JOIN tbl_homestays ON tbl_bookings.homestay_id = tbl_homestays.homestay_id";

// Filter by year and month if selected
$conditions = [];
if ($year !== 'all') {
    $conditions[] = "YEAR(tbl_bookings.check_in_date) = '$year'";
}
if ($month !== 'all') {
    $conditions[] = "MONTH(tbl_bookings.check_in_date) = '$month'";
}
if ($conditions) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

$result = mysqli_query($conn, $query);
$bookings = [];

while ($row = mysqli_fetch_assoc($result)) {
    $bookings[] = $row;
}

echo json_encode(['recent_bookings' => $bookings]);
?>
