<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>About Us</title>
  <link rel="icon" href="img/logo.png" type="image/jpg">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/blog.css">
</head>
<body>
  <?php
      include "includes/config.php";
      include "includes/header.php";
  ?>
  <!-- ================ Start Banner Area ================= -->  
  <section class="blog-banner-area" id="about">
    <div class="container h-50">
      <div class="banner-content">
        <h1>About Us</h1>
        <div class="breadcrumb-container">
          <nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!-- ================ End Banner Area ================= -->
   
  <!-- ================ About Section Start ================= --> 
  <section class="about">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5 mb-4 mb-lg-0">
          <div class="row no-gutters">
            <div class="col-12 mb-3"> <!-- Full width for the first image -->
              <div class="card image-container">
                <img src="img/web_vission.png" alt="Living Room 2">
              </div>
            </div>
            <div class="col-12"> <!-- Full width for the second image -->
              <div class="card image-container">
                <img src="img/web_mission.jfif" alt="Welcome Banner">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="about-content">
            <div class="vision-box mb-4">
              <h2 class="mb-4">Vision</h2>
              <p>To provide high-quality amenities and a comfortable stay experience, ensuring guests receive the best value for their money while enjoying a memorable and relaxing environment.</p>
            </div>

            <div class="mission-box">
              <h2 class="mb-4">Mission</h2>
              <p>Our mission is to offer guests a cozy and affordable stay with top-quality amenities, ensuring comfort and satisfaction. We aim to create a welcoming environment that allows our guests to relax, experience local hospitality, and leave with lasting memories of their stay.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ================ About Section End ================= -->

  <?php 
    include "includes/footer.php"; 
  ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script> 
</body>
</html>
