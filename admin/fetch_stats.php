<?php
// Include database connection
include('../includes/config.php');

$year = $_POST['year'] ?? null;
$month = $_POST['month'] ?? null;

// Prepare SQL query based on year and month filters
$totalBookingsQuery = "SELECT COUNT(*) as total_bookings FROM tbl_bookings";
$totalIncomeQuery = "SELECT SUM(total_amount) as total_income FROM tbl_bookings";

// Filter for year and month if provided
if ($year !== 'all') {
    $totalBookingsQuery .= " WHERE YEAR(check_in_date) = '$year'";
    $totalIncomeQuery .= " WHERE YEAR(check_in_date) = '$year'";
    if ($month !== 'all') {
        $totalBookingsQuery .= " AND MONTH(check_in_date) = '$month'";
        $totalIncomeQuery .= " AND MONTH(check_in_date) = '$month'";
    }
}

// Execute queries
$totalBookingsResult = mysqli_query($conn, $totalBookingsQuery);
$totalIncomeResult = mysqli_query($conn, $totalIncomeQuery);

// Get results
$totalBookingsData = mysqli_fetch_assoc($totalBookingsResult);
$totalIncomeData = mysqli_fetch_assoc($totalIncomeResult);

// Prepare response
$response = [
    'total_bookings' => $totalBookingsData['total_bookings'] ?? 0,
    'total_income' => $totalIncomeData['total_income'] ?? 0.00
];

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);