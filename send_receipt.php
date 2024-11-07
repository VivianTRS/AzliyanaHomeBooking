<?php
include "includes/config.php"; 
require_once "includes/email.php";

require_once(__DIR__ . '/vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fetch the maximum booking_id
$result_max_id = mysqli_query($conn, "SELECT MAX(booking_id) AS max_booking_id FROM tbl_bookings");
$row_max_id = mysqli_fetch_assoc($result_max_id);
$booking_id = $row_max_id['max_booking_id'];

// Ensure booking_id is not null
if ($booking_id === null) {
    die("No booking found.");
}

// Prepare the SQL statement
$sql = "
    SELECT b.guest_name, b.nric_number, b.contact_number, b.email, 
           h.name_homestay, b.check_in_date, b.check_out_date, b.total_amount, 
           b.deposit, b.bank, b.bank_account_number 
    FROM tbl_bookings b 
    JOIN tbl_homestays h ON b.homestay_id = h.homestay_id 
    WHERE b.booking_id = ?";

$stmt = $conn->prepare($sql);  // Prepare the statement
if ($stmt === false) {
    die("Error preparing statement: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $booking_id); // Bind the booking_id parameter
$stmt->execute(); // Execute the statement

$result = $stmt->get_result(); // Get the result set
if (mysqli_num_rows($result) > 0) {
    $booking = $result->fetch_assoc(); // Fetch the booking data
} else {
    die("Booking not found.");
}

// Initialize TCPDF and create the PDF
$pdf = new TCPDF();
$pdf->AddPage(); // Only one AddPage() call here

// Set PDF metadata
$pdf->SetTitle('Booking Receipt');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Azliyana Home Booking');
$pdf->SetSubject('Booking Details');
$pdf->SetKeywords('TCPDF, PDF, booking, receipt');

// Set header data (hide logo by passing an empty string)
$pdf->SetHeaderData('', 0, 'Booking Receipt', 'Generated on ' . date('Y-m-d'));

// Set header and footer fonts
$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

// Set default monospaced font and margins
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add booking details
$html = '<h2>Your Booking Receipt</h2>';
$html .= '<p>Thank you for your booking! Here are the details of your reservation.</p>';
$html .= '<table border="1" cellpadding="5">';
$html .= '<tr><th>Field</th><th>Details</th></tr>';
$html .= '<tr><td>Guest Name</td><td>' . htmlspecialchars($booking['guest_name']) . '</td></tr>';
$html .= '<tr><td>NRIC Number</td><td>' . htmlspecialchars($booking['nric_number']) . '</td></tr>';
$html .= '<tr><td>Contact Number</td><td>' . htmlspecialchars($booking['contact_number']) . '</td></tr>';
$html .= '<tr><td>Email</td><td>' . htmlspecialchars($booking['email']) . '</td></tr>';
$html .= '<tr><td>Homestay</td><td>' . htmlspecialchars($booking['name_homestay']) . '</td></tr>';
$html .= '<tr><td>Check In Date</td><td>' . htmlspecialchars($booking['check_in_date']) . '</td></tr>';
$html .= '<tr><td>Check Out Date</td><td>' . htmlspecialchars($booking['check_out_date']) . '</td></tr>';
$html .= '<tr><td>Total Amount</td><td>' . htmlspecialchars(number_format($booking['total_amount'], 2)) . '</td></tr>';
$html .= '<tr><td>Deposit</td><td>' . htmlspecialchars(number_format($booking['deposit'], 2)) . '</td></tr>';
$html .= '<tr><td>Bank</td><td>' . htmlspecialchars($booking['bank']) . '</td></tr>';
$html .= '<tr><td>Bank Account Number</td><td>' . htmlspecialchars($booking['bank_account_number']) . '</td></tr>';
$html .= '</table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Create folder if it doesn't exist
if (!file_exists('booking_receipt')) {
    mkdir('booking_receipt', 0777, true);
}

// Define path to save the PDF file
$pdf_path = __DIR__ . '/booking_receipt/receipt_' . $booking_id . '.pdf';
$pdf->Output($pdf_path, 'F'); // Save the PDF file to the specified path

// Email content
$message = "Dear {$booking['guest_name']},\n\n";
$message .= "Thank you for your booking. Please find attached your booking receipt.\n\n";
$message .= "Booking Details:\n";
$message .= "Check-In Date: {$booking['check_in_date']}\n";
$message .= "Check-Out Date: {$booking['check_out_date']}\n";
$message .= "Total Payment: RM {$booking['total_amount']}\n\n";
$message .= "Best Regards,\n";
$message .= "Azliyana Home Booking";

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->setLanguage(CONTACTFORM_LANGUAGE);
    $mail->SMTPDebug = CONTACTFORM_PHPMAILER_DEBUG_LEVEL;
    $mail->isSMTP();
    $mail->Host = CONTACTFORM_SMTP_HOSTNAME;
    $mail->SMTPAuth = true;
    $mail->Username = CONTACTFORM_SMTP_USERNAME;
    $mail->Password = CONTACTFORM_SMTP_PASSWORD;
    $mail->SMTPSecure = CONTACTFORM_SMTP_ENCRYPTION;
    $mail->Port = CONTACTFORM_SMTP_PORT;
    $mail->CharSet = CONTACTFORM_MAIL_CHARSET;
    $mail->Encoding = CONTACTFORM_MAIL_ENCODING;

    // Recipients
    $mail->setFrom('your-email@email.com', 'Azliyana Home Booking');
    $mail->addAddress($booking['email']);

    // Attach the receipt
    $mail->addAttachment($pdf_path);

    // Email content
    $mail->isHTML(false);
    $mail->Subject = 'Your Booking Receipt';
    $mail->Body = $message;

    $mail->send();
    echo 'Receipt has been sent to the guest.';

    // Delete the PDF file after sending
    if (file_exists($pdf_path)) {
        unlink($pdf_path);
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>