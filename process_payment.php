<?php
include 'includes/config.php';
require_once 'Toyyibpay.php';
$paymentGateway = new ToyyibPay($toyyibpay_secret_key);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $homestay_id = intval($_POST['homestay_id']);
    $full_name = filter_var($_POST['full_name'], FILTER_SANITIZE_STRING);
    $nric_number = filter_var($_POST['nric_number'], FILTER_SANITIZE_STRING);
    $phone_number = filter_var($_POST['phone_number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $bank_account_number = filter_var($_POST['bank_account_number'], FILTER_SANITIZE_STRING);
    $bank = filter_var($_POST['bank'], FILTER_SANITIZE_STRING);
    $check_in_date = filter_var($_POST['check_in_date'], FILTER_SANITIZE_STRING);
    $check_out_date = filter_var($_POST['check_out_date'], FILTER_SANITIZE_STRING);
    $deposit = filter_var($_POST['deposit'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $total_amount = filter_var($_POST['total_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $month = (int)date('m', strtotime($check_in_date));
    $payment_status = "-";

    // Check for duplicate booking within the last week
    $sql_check = "SELECT COUNT(*) AS count FROM `tbl_bookings` 
                  WHERE `homestay_id` = ? 
                  AND `nric_number` = ? 
                  AND `check_in_date` BETWEEN DATE_SUB(?, INTERVAL 7 DAY) AND ? 
                  AND `payment_status` = 'Paid'";
    
    $stmt_check = $conn->prepare($sql_check);
    if ($stmt_check === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt_check->bind_param("isss", $homestay_id, $nric_number, $check_in_date, $check_in_date);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row = $result_check->fetch_assoc();

    if ($row['count'] > 0) {
        echo "<script>
            alert('You have already booked this homestay within the past week.');
            window.location.href = 'homestays.php';
        </script>";
        exit;
    }

    $sql = "INSERT INTO `tbl_bookings`(`homestay_id`, `guest_name`, `nric_number`, 
    `contact_number`, `email`, `check_in_date`, `check_out_date`, `month`, 
    `total_amount`, `deposit`, `bank`, `bank_account_number`, `payment_status`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("issssssiddsss", 
        $homestay_id, 
        $full_name, 
        $nric_number,
        $phone_number, 
        $email,
        $check_in_date, 
        $check_out_date, 
        $month,
        $total_amount,
        $deposit,
        $bank, 
        $bank_account_number,
        $payment_status
    );

    $stmt->execute();

    $last_id = $conn->insert_id;

    $rmx100 = ($total_amount);

    $content = "Dear $full_name, 
    \n\nThank you for your booking. Your booking ID is $last_id. 
    \n\nBooking Details:
    \nCheck-In Date: $check_in_date
    \nCheck-Out Date: $check_out_date
    \nTotal Amount: RM$total_amount
    \nDeposit: RM$deposit
    \n\nPlease note that you will need to pay RM$rmx100 at the ToyyibPay portal for your booking to be confirmed. 
    \n\nBest regards, 
    \nAzliyana";

	$bill = $paymentGateway->createBill( $category_code, "Payment For Homestay Booking", 'Bayaran Homestay sebanyak RM' . number_format($rmx100, 2), $last_id)
							->payer( "$full_name", "$email", "$phone_number" )
							->amount( $rmx100 )
							->chargeToCustomer( 2 )
							->callbackUrl( "{$base_url}toyyibpay_callback.php?id=$last_id")
							->emailContent($content);

	$bill->redirectToPaymentUrl();
}
?>