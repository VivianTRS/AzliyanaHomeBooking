<?php
include '../../includes/config.php';

require_once '../../vendor/autoload.php';

//require __DIR__ . '\..\..\vendor\autoload.php';
use Twilio\Rest\Client;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sid    = "ACa9e8a488d69b25b379ab245a0fc329e1";
    $token  = "1e97d448e2d965a57bb79e0731079721";
    $twilio = new Client($sid, $token);
      
    $twilioNumber = '+18067314978';

    $sql = "SELECT 
                b.guest_name, 
                b.contact_number, 
                b.check_in_date, 
                b.check_out_date, 
                b.payment_status, 
                h.name_homestay 
            FROM tbl_bookings AS b
            JOIN tbl_homestays AS h ON b.homestay_id = h.homestay_id
            WHERE b.booking_id = $id";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Assign values from database to variables
        $recipientNumber = 'whatsapp:+6' . $row['contact_number'];
        $checkInDate = $row['check_in_date'];
        $checkOutDate = $row['check_out_date'];
        $paymentStatus = $row['payment_status'];
        $customerName = $row['guest_name'];
        $homestayName = $row['name_homestay'];
    }

    $body = "Hello $customerName!\n\n"; // Start with greeting
    $body .= "This is a reminder about your upcoming check-in.\n\n";
    $body .= "📅 *Date:* $checkInDate - $checkOutDate\n";
    $body .= "🏡 *Homestay Name:* $homestayName\n";
    $body .= "💳 *Payment Status:* $paymentStatus\n";

    $body .= "Please Note:\n";
    $body .= "1. Contact us in advance for any changes or requirements.\n";
    $body .= "2. Bring a valid ID for check-in verification.\n";
    $body .= "3. We offer a variety of amenities to make your stay comfortable.\n\n";
    $body .= "Safe travels, and we look forward to your stay!\n\n";
    $body .= "*Azliyana Homestay Booking*";


    try {
        $message = $twilio->messages->create(
            $recipientNumber,
            array(
                //"contentSid" => "HX98c062c826c75f626cfe1d284ddf20ad",
                /*"contentVariables" => '{
                "1":"'.$customerName.'",
                "2":"'.$checkInDate.'",
                "3":"'.$checkOutDate.'",
                "5":"'.$homestayName.'",
                "4":"'.$paymentStatus.'"
                }',*/
                'from' => 'whatsapp:' . $twilioNumber,
                'body' => $body,
            )
        );
        //print $message->sid;
        //print $message->body;

        echo "<script>alert('WhatsApp message sent successfully');'
        window.location.href = 'bookings_list.php;</script>";

    } catch (Exception $e) {
        echo "Error sending WhatsApp message: " . $e->getMessage();
    }

} else {
    echo "No booking ID provided.";
}
?>