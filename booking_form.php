<?php
// booking_form.php
include 'includes/config.php';

$homestay_id = isset($_GET['homestay_id']) ? intval($_GET['homestay_id']) : 0;
$homestay_name = '';
$price_per_night = 0;

// Fetch the homestay details from the database
if ($homestay_id > 0) {
    $sql_homestay = "SELECT price, deposit,name_homestay FROM tbl_homestays WHERE homestay_id = ?";
    $stmt_homestay = $conn->prepare($sql_homestay);
    $stmt_homestay->bind_param("i", $homestay_id);
    $stmt_homestay->execute();
    $stmt_homestay->bind_result($price_per_night,$deposit,$homestay_name);
    $stmt_homestay->fetch();
    $stmt_homestay->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div id="booking" class="section mb-4 mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>Book Your Homestay</h3>
                        </div>
                        <div class="card-body">
                            <form id="bookingForm" action="process_payment.php" method="POST">
                                <!-- User Information Fields -->
                                <div class="form-group row">
                                    <label for="full_name" class="col-md-4 col-form-label">Full Name</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nric_number" class="col-md-4 col-form-label">NRIC Number</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="nric_number" name="nric_number" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone_number" class="col-md-4 col-form-label">Phone Number</label>
                                    <div class="col-md-8">
                                        <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label">Email</label>
                                    <div class="col-md-8">
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bank_account_number" class="col-md-4 col-form-label">Account Number</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bank" class="col-md-4 col-form-label">Bank</label>
                                    <div class="col-md-8">
                                        <select class="form-control" id="bank" name="bank" required>
                                            <option value="" disabled selected>Select Bank</option>
                                            <option value="maybank">Maybank</option>
                                            <option value="cimb">CIMB Bank</option>
                                            <option value="publicbank">Public Bank</option>
                                            <option value="rhb">RHB Bank</option>
                                            <option value="hongleong">Hong Leong Bank</option>
                                            <option value="bankislam">Bank Islam</option>
                                            <option value="ambank">AmBank</option>
                                            <option value="bankrakyat">Bank Rakyat</option>
                                            <option value="hsbc">HSBC Bank</option>
                                            <option value="uob">UOB Bank</option>
                                            <option value="ocbc">OCBC Bank</option>
                                            <option value="standardchartered">Standard Chartered</option>
                                            <option value="alliance">Alliance Bank</option>
                                            <!-- Add more banks as needed -->
                                        </select>
                                    </div>
                                </div>

                                <!-- Homestay and Date Fields -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="homestay_name">Homestay Name</label>
                                            <input type="text" class="form-control" id="homestay_name" value="<?php echo htmlspecialchars($homestay_name); ?>" readonly>
                                            <input type="hidden" name="homestay_id" id="homestay_id" value="<?php echo $homestay_id; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="check_in_date">Check In</label>
                                            <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="check_out_date">Check Out</label>
                                            <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden Fields for Price and Deposit -->
                                <input type="hidden" name="price_per_night" id="price_per_night" value="<?php echo $price_per_night; ?>">
                                <input type="hidden" name="deposit" id="deposit" value="<?php echo $deposit; ?>">
                                <input type="hidden" name="total_amount" id="total_amount" value="">
                                <input type="hidden" name="homestay_name" id="homestay_name" value="<?php echo htmlspecialchars($homestay_name); ?>">

                                <p id="availability_message"></p>
                                <button type="button" id="btnConfirm" class="btn btn-primary" data-toggle="modal" data-target="#bookingSummaryModal" disabled>Confirm</button>
                                <button type="submit" id="btnPayment" class="btn btn-primary">Pay Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Summary Modal -->
    <div class="modal fade" id="bookingSummaryModal" tabindex="-1" aria-labelledby="bookingSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Summary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="summaryContent"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Include necessary scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to enable the confirm button only when availability is confirmed
            function toggleConfirmButton(isAvailable) {
                if (isAvailable) {
                    $("#availability_message").text("Homestay is available!").css("color", "green");
                    $("#btnConfirm").prop("disabled", false);
                } else {
                    $("#availability_message").text("Homestay is not available on the selected dates.").css("color", "red");
                    $("#btnConfirm").prop("disabled", true);
                }
            }

            // Check availability when dates change
            $("#check_in_date, #check_out_date").on("change", function() {
                var homestay_id = $("#homestay_id").val();
                var check_in_date = $("#check_in_date").val();
                var check_out_date = $("#check_out_date").val();
                var total_amount = calculateTotalAmount(check_in_date, check_out_date);
                $("#total_amount").val(total_amount.toFixed(2));

                // Validate that check-out date is after check-in date
                if (check_in_date && check_out_date && new Date(check_out_date) <= new Date(check_in_date)) {
                    $("#availability_message").text("Check-out date must be after the check-in date.").css("color", "red");
                    $("#btnConfirm").prop("disabled", true);
                    return; // Exit the function to prevent AJAX call
                }

                if (homestay_id && check_in_date && check_out_date) {
                    $.ajax({
                        url: "check_availability.php",
                        type: "POST",
                        data: {
                            homestay_id: homestay_id,
                            check_in_date: check_in_date,
                            check_out_date: check_out_date
                        },
                        success: function(response) {
                            try {
                                var result = JSON.parse(response);
                                if (result.status === "available") {
                                    toggleConfirmButton(true);
                                } else {
                                    toggleConfirmButton(false);
                                }
                            } catch (e) {
                                console.error("JSON Parse Error:", e);
                                $("#availability_message").text("Invalid response from server.").css("color", "red");
                                $("#btnConfirm").prop("disabled", true);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", error);
                            $("#availability_message").text("An error occurred while checking availability.").css("color", "red");
                            $("#btnConfirm").prop("disabled", true);
                        }
                    });
                }
            });

            // Handle confirm button click to show summary
            $("#btnConfirm").on("click", function() {
                var homestay_name = $("#homestay_name").val();
                var price_per_night = parseFloat($("#price_per_night").val());
                var deposit = parseFloat($("#deposit").val());
                var check_in_date = $("#check_in_date").val();
                var check_out_date = $("#check_out_date").val();
                var total_amount = calculateTotalAmount(check_in_date, check_out_date);

                var full_name = $("#full_name").val().trim();
                var nric_number = $("#nric_number").val().trim();
                var phone_number = $("#phone_number").val().trim();
                var email = $("#email").val().trim();
                var bank_account_number = $("#bank_account_number").val().trim();
                var bank = $("#bank").val().trim();

                // Validate form fields (additional server-side validation is recommended)
                if (full_name === "" || nric_number === "" || phone_number === "" || email === "" || bank_account_number === "" || bank === "") {
                    alert("Please fill out all required fields.");
                    return;
                }

                // Check NRIC format
                var nricPattern = /^[0-9]{12}$/;
                if (!nricPattern.test(nric_number)) {
                    alert("Please enter a valid 12-digit NRIC number.");
                    return;
                }

                // Check email format
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    alert("Please enter a valid email address.");
                    return;
                }

                $("#summaryContent").html(`
                    <strong>Homestay Name:</strong> ${homestay_name}<br>
                    <strong>Full Name:</strong> ${full_name}<br>
                    <strong>NRIC Number:</strong> ${nric_number}<br>
                    <strong>Phone Number:</strong> ${phone_number}<br>
                    <strong>Email:</strong> ${email}<br>
                    <strong>Bank Account Number:</strong> ${bank_account_number}<br>
                    <strong>Bank:</strong> ${bank}<br>
                    <strong>Check-In Date:</strong> ${check_in_date}<br>
                    <strong>Check-Out Date:</strong> ${check_out_date}<br>
                    <strong>Deposit:</strong> MYR ${deposit.toFixed(2)}<br>
                    <strong>Price per night:</strong> MYR ${price_per_night.toFixed(2)}<br>
                    <strong>Total Amount:</strong> MYR ${total_amount.toFixed(2)}<br>
                `);
                // Show the modal
                $("#bookingSummaryModal").modal('show');
            });

            // Function to calculate total amount
            function calculateTotalAmount(check_in_date, check_out_date) {
                var price_per_night = parseFloat($("#price_per_night").val());
                var deposit = parseFloat($("#deposit").val());
                var checkInDate = new Date(check_in_date);
                var checkOutDate = new Date(check_out_date);
                var timeDiff = checkOutDate - checkInDate;
                var numNights = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

                if (numNights > 0) {
                    return (numNights * price_per_night) + deposit;
                } else {
                    return 0;
                }
            }
        });
    </script>
</body>
</html>