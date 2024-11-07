<?php 
    include "includes/config.php"; 

    // Fetch the maximum booking_id
    $result_max_id = mysqli_query($conn, "SELECT MAX(booking_id) AS max_booking_id FROM tbl_bookings");
    $row_max_id = mysqli_fetch_assoc($result_max_id);
    $booking_id = $row_max_id['max_booking_id'];

    // Fetch booking details using the maximum booking_id
    $result = mysqli_query($conn, "
        SELECT b.guest_name, b.nric_number, b.contact_number, b.email, 
            h.name_homestay, b.check_in_date, b.check_out_date, b.total_amount, 
            b.deposit, b.bank, b.bank_account_number 
        FROM tbl_bookings b 
        JOIN tbl_homestays h ON b.homestay_id = h.homestay_id 
        WHERE b.booking_id = '$booking_id'");

    // Check if the result is valid and fetch the booking details
    if ($result && mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);
    } else {
        echo "No booking details found.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container mt-5">
    <h2>Your Booking Receipt</h2>
    <p>Thank you for your booking! Here are the details of your reservation.</p>
    
    <table class="table">
        <tr>
            <th>Guest Name:</th>
            <td><?php echo htmlspecialchars($booking['guest_name']); ?></td>
        </tr>
        <tr>
            <th>NRIC Number:</th>
            <td><?php echo htmlspecialchars($booking['nric_number']); ?></td>
        </tr>
        <tr>
            <th>Contact Number:</th>
            <td><?php echo htmlspecialchars($booking['contact_number']); ?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?php echo htmlspecialchars($booking['email']); ?></td>
        </tr>
        <tr>
            <th>Homestay:</th>
            <td><?php echo htmlspecialchars($booking['name_homestay']); ?></td>
        </tr>
        <tr>
            <th>Check In Date:</th>
            <td><?php echo htmlspecialchars($booking['check_in_date']); ?></td>
        </tr>
        <tr>
            <th>Check Out Date:</th>
            <td><?php echo htmlspecialchars($booking['check_out_date']); ?></td>
        </tr>
        <tr>
            <th>Total Amount:</th>
            <td><?php echo htmlspecialchars($booking['total_amount']); ?></td>
        </tr>
        <tr>
            <th>Deposit:</th>
            <td><?php echo htmlspecialchars($booking['deposit']); ?></td>
        </tr>
        <tr>
            <th>Bank:</th>
            <td><?php echo htmlspecialchars($booking['bank']); ?></td>
        </tr>
        <tr>
            <th>Bank Account Number:</th>
            <td><?php echo htmlspecialchars($booking['bank_account_number']); ?></td>
        </tr>
        <tr>
            <td>
                <a href="download_booking.php?booking_id=<?php echo $booking_id; ?>" class="btn btn-success">Download Receipt as PDF</a>
                <a href="index.php" class="btn btn-primary">Back to home</a>
            </td>
        </tr>
    </table>
</div>
</body>
</html>