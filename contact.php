<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/includes/config.php';

session_start();

if (!empty($_SESSION['_contact_form_error'])) {
    $error = $_SESSION['_contact_form_error'];
    unset($_SESSION['_contact_form_error']);
}

if (!empty($_SESSION['_contact_form_success'])) {
    $success = true;
    unset($_SESSION['_contact_form_success']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact</title>
  <link rel="icon" href="img/logo.png" type="image/jpg">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/blog.css">
  <style>
    .contact-info-box {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .contact-info-box h1 {
        color: white;
    }
    .contact-card {
        border: 2px solid transparent;
        transition: border-color 0.3s ease, transform 0.3s ease;
        cursor: pointer;
        text-align: center;
    }
    .contact-card:hover {
        border-color: #228500;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    .contact-card {
        flex: 1 1 20%;
        margin: 10px;
        max-width: 300px;
    }
    @media (max-width: 768px) {
        .contact-card {
          flex: 1 1 100%;
          max-width: none;
        }
    }
    .contact-card a {
        text-decoration: none;
    }
    .contact-card a:hover {
        color: #228500;
    }
    .connect-border {
      border: 2px solid #228500;
      border-radius: 8px;
      background-color: white;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
  <?php include "includes/header.php"; ?>

  <!-- Banner Area -->  
  <section class="blog-banner-area" id="about">
    <div class="container h-50">
      <div class="banner-content">
        <h1>Contact Us</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
          </ol>
        </nav>
      </div>
    </div>
  </section>

  <!-- Contact Information Section -->
  <div class="container-fluid contact bg-light py-5">
    <div class="container py-5">
      <div class="text-center mb-5 connect-border">
        <h1>Connect With Us</h1>
      </div>
      <div class="contact-info-box">
        <div class="row g-5 align-items-center justify-content-center">
          <!-- Address Card -->
          <div class="contact-card text-center mb-4">
            <i class="fa fa-map-marker-alt fa-3x text-primary"></i>
            <h4 class="text-primary">Address</h4>
            <p>Jalan Nuri 1, Bandar Putra, 81000 Kulai, Johor</p>
          </div>
          <!-- Mobile Card -->
          <div class="contact-card text-center mb-4">
            <i class="fas fa-phone fa-3x text-primary"></i>
            <h4 class="text-primary">Mobile</h4>
            <a href="tel:+60194561507">019-4561507 - Azhar</a><br>
            <a href="tel:+6011265282">011-265282 - Alice</a>
          </div>
          <!-- Email Card -->
          <div class="contact-card text-center mb-4">
            <i class="fa fa-envelope-open fa-3x text-primary"></i>
            <h4 class="text-primary">Email</h4>
            <a href="mailto:azliyana@gmail.com.my">azliyana@gmail.com.my</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Form Section -->
  <div class="container-fluid contact bg-light py-5">
    <div class="container py-5">
      <div class="text-center mb-5">
        <h1>Contact For Any Query</h1>
      </div>
      <div class="row g-5 align-items-center justify-content-center">
        <!-- Form Column -->
        <div class="col-lg-6"> <!-- Adjusted column width for centering -->
          <p>We'd love to hear from you. Please fill out the form below and we'll get back to you as soon as possible.</p>
          <p class="text-danger" id="error-message"></p>
          <div id="success-message" class="text-success d-none">Your message has been sent successfully.</div>
          <?php
                    if (!empty($success)) {
                        ?>
                        <div class="alert alert-success">Your message was sent successfully!</div>
                        <?php
                    }
                    ?>

                    <?php
                    if (!empty($error)) {
                        ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                        <?php
                    }
          ?>
          <form action="contact_process.php" method="post" class="text-center">
            <div class="row g-3">
              <div class="col-md-12 mb-3">
                <input type="text" class="form-control border-0" name="name" placeholder="Your Name" required>
              </div>
              <div class="col-md-12 mb-3">
                <input type="email" class="form-control border-0" name="email" placeholder="Your Email" required>
              </div>
              <div class="col-12 mb-3">
                <input type="text" class="form-control border-0" name="subject" placeholder="Subject" required>
              </div>
              <div class="col-12 mb-4">
                <textarea class="form-control border-0" name="message" placeholder="Leave a message here" style="height: 160px" required></textarea>
              </div>
              
              <div class="col-12 text-center">
                <button class="btn btn-primary btn-block">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <?php include "includes/footer.php"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-whatever" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>