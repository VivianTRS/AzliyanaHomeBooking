<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .footer-area {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0; /* Further reduced padding */
        }

        .footer-item h4 {
            font-size: 1rem; /* Smaller font size */
            margin-bottom: 0.5rem; /* Further reduced margin */
        }

        .footer-item a {
            color: #b0b0b0;
            text-decoration: none;
            margin-bottom: 0.3rem; /* Further reduced margin */
            display: block;
            font-size: large;
        }

        .footer-item a:hover {
            color: #fff;
        }

        .footer-bottom {
            background-color: #23272b;
            padding: 5px 0; /* Further reduced padding */
            margin-top: 10px; /* Further reduced margin */
        }

        .footer-bottom p {
            color: #b0b0b0;
            font-size: 0.8rem; /* Smaller font size */
        }

        .footer-bottom a {
            color: #fff;
            text-decoration: none;
        }

        .footer-bottom a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <footer class="footer-area section-gap py-5">
        <div class="container">
            <!-- Footer Main Section -->
            <div class="container-fluid footer">
                <div class="container py-2"> <!-- Further reduced padding -->
                    <div class="row g-2"> <!-- Further reduced gap -->
                        <!-- Contact Section -->
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="footer-item d-flex flex-column">
                                <h4 class="mb-2 text-white">Get In Touch</h4> <!-- Further reduced margin -->
                                <a href="tel:+60194561507"><i class="fas fa-phone me-1"></i> +019 456 1507 - Azhar</a>
                                <a href="tel:+60137288172" class="mb-1"><i class="fas fa-print me-1"></i> +013 728 8172 - Alice</a>
                            </div>
                        </div>

                        <!-- Company Section -->
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="footer-item d-flex flex-column">
                                <h4 class="mb-2 text-white">Company</h4> <!-- Further reduced margin -->
                                <a href="homestays.php"><i class="fas fa-angle-right me-1"></i> Booking</a>
                                <a href="contact.php"><i class="fas fa-angle-right me-1"></i> Contact</a>
                                <a href="about_us.php"><i class="fas fa-angle-right me-1"></i> About Us</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Bottom Section -->
                <div class="footer-bottom row align-items-center text-center">
                    <p class="footer-text m-0 col-lg-8 col-md-12 text-white">
                        &copy; <script>document.write(new Date().getFullYear());</script> 
                        <a href="#" target="_blank" class="text-white">Azliyana Homestay</a>, All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>