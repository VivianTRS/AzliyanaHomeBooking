<?php 
include "../sidebar.php";
include '../../includes/config.php';

// Get the booking ID from the URL
$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the existing booking data
$sql = "SELECT 
    booking_id, 
    homestay_id, 
    guest_name, 
    NRIC_number, 
    contact_number, 
    email, 
    check_in_date, 
    check_out_date, 
    month,
    total_amount, 
    deposit, 
    bank, 
    bank_account_number,
    payment_status
    FROM tbl_bookings 
    WHERE booking_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<p>No booking found</p>";
    exit;
}
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
    <div class="container mt-4">
        <h2>Booking Details</h2>
        
        <div class="form-group">
            <label for="guest_name">Guest Name</label>
            <p id="guest_name"><?php echo htmlspecialchars($row['guest_name']); ?></p>
        </div>
        <div class="form-group">
            <label for="NRIC_number">NRIC Number</label>
            <p id="NRIC_number"><?php echo htmlspecialchars($row['NRIC_number']); ?></p>
        </div>
        <div class="form-group">
            <label for="contact_number">Contact Number</label>
            <p id="contact_number"><?php echo htmlspecialchars($row['contact_number']); ?></p>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <p id="email"><?php echo htmlspecialchars($row['email']); ?></p>
        </div>
        <div class="form-group">
            <label for="check_in_date">Check-In Date</label>
            <p id="check_in_date"><?php echo htmlspecialchars($row['check_in_date']); ?></p>
        </div>
        <div class="form-group">
            <label for="check_out_date">Check-Out Date</label>
            <p id="check_out_date"><?php echo htmlspecialchars($row['check_out_date']); ?></p>
        </div>
        <div class="form-group">
            <label for="month">Month</label>
            <p id="month"><?php echo htmlspecialchars($row['month']); ?></p>
        </div>
        <div class="form-group">
            <label for="total_amount">Total Payment</label>
            <p id="total_amount"><?php echo htmlspecialchars($row['total_amount']); ?></p>
        </div>
        <div class="form-group">
            <label for="deposit">Deposit</label>
            <p id="deposit"><?php echo htmlspecialchars($row['deposit']); ?></p>
        </div>
        <div class="form-group">
            <label for="bank">Bank</label>
            <p id="bank"><?php echo htmlspecialchars($row['bank']); ?></p>
        </div>
        <div class="form-group">
            <label for="bank_account_number">Bank Account Number</label>
            <p id="bank_account_number"><?php echo htmlspecialchars($row['bank_account_number']); ?></p>
        </div>
        <div class="form-group">
            <label for="payment_status">Payment Status</label>
            <p id="payment_status"><?php echo htmlspecialchars($row['payment_status']); ?></p>
        </div>
        <a href="bookings_list.php" class="btn btn-secondary">Back to Booking List</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>