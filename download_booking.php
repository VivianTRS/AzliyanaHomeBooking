<?php 
require_once(__DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php');

include "includes/config.php";

// Get booking_id from the URL and validate it
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 1;

// Fetch booking details
$result = mysqli_query($conn, "
    SELECT b.guest_name, b.nric_number, b.contact_number, b.email, 
           h.name_homestay, b.check_in_date, b.check_out_date, b.total_amount, 
           b.deposit, b.bank, b.bank_account_number 
    FROM tbl_bookings b 
    JOIN tbl_homestays h ON b.homestay_id = h.homestay_id 
    WHERE b.booking_id = '$booking_id'");

if (mysqli_num_rows($result) > 0) {
    $booking = mysqli_fetch_assoc($result);
} else {
    die("Booking not found.");
}

// Create a new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('Booking Receipt');
$pdf->SetSubject('Booking Details');
$pdf->SetKeywords('TCPDF, PDF, booking, receipt');

// Set header data (hide logo by passing an empty string)
$pdf->SetHeaderData('', 0, 'Booking Receipt', 'Generated on ' . date('Y-m-d'));

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();

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
$html .= '<tr><td>Total Amount</td><td>' . htmlspecialchars($booking['total_amount']) . '</td></tr>';
$html .= '<tr><td>Deposit</td><td>' . htmlspecialchars($booking['deposit']) . '</td></tr>';
$html .= '<tr><td>Bank</td><td>' . htmlspecialchars($booking['bank']) . '</td></tr>';
$html .= '<tr><td>Bank Account Number</td><td>' . htmlspecialchars($booking['bank_account_number']) . '</td></tr>';
$html .= '</table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('booking_receipt_' . $booking_id . '.pdf', 'D');
exit();
?>