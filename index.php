<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Azliyana Homestay</title>
  <link rel="icon" href="img/logo.png" type="image/jpg">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/slider.css">
  <link rel="stylesheet" href="css/styles.css">

  <style>
    .welcome-content {
      display: flex;
      flex-direction: column;
      align-items: center; /* Center horizontally */
      text-align: center; /* Center text if needed */
    }
    .image-slider {
      position: relative;
      max-width: 100%;
      overflow: hidden;
      margin: 20px 0;
    }

    .slider {
      display: flex;
      transition: transform 0.5s ease;
    }

    .slider img {
      width: 100%; /* Set to 100% to fill the container */
      height: auto; /* Maintain aspect ratio */
      max-height: 400px; /* Set a maximum height to enforce landscape orientation */
      object-fit: cover; /* Ensure the image covers the container */
    }

    .prev, .next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(255, 255, 255, 0.7);
      border: none;
      cursor: pointer;
      padding: 10px;
      z-index: 10;
    }

    .prev {
      left: 10px;
    }

    .next {
      right: 10px;
    }

    .hero .slider img {
      max-height: 400px; /* Adjust hero image height similarly */
    }
  </style>
</head>
<body>
  <?php   
    include "includes/header.php"; 
  ?>
  <main class="site-main">
    <!-- Hero Section with Slider -->
    <div class="hero">
      <div class="slider">
        <img src="img/slider/image1.jpg" alt="Image 1">
        <img src="img/slider/image2.jpg" alt="Image 2">
        <img src="img/slider/image3.jpg" alt="Image 3">
        <img src="img/slider/image4.jfif" alt="Image 4">
        <img src="img/slider/image5.jfif" alt="Image 5">
        <img src="img/slider/image5.jfif" alt="Image 6">
      </div>

      <div class="hero-text">
        <h2>Comfort and Quality Are Our Priorities</h2>
        <p>Discover the nature of new travel</p>
        <button class="btn" onclick="location.href='homestays.php'">Discover More</button>
      </div>

      <!-- Previous and Next buttons -->
      <button class="prev" onclick="moveSlider(-1)">&#10094;</button>
      <button class="next" onclick="moveSlider(1)">&#10095;</button>
    </div>
    
    <!-- ================ welcome section start ================= --> 
    <section class="welcome">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5 mb-4 mb-lg-0">
            <!-- Image Slider Section -->
            <div class="image-slider">
              <div class="slider">
                <img src="img/index/ruangtamu1.jpg" alt="Room Image 1">
                <img src="img/index/ruangtamu2.jpg" alt="Room Image 2">
                <img src="img/index/ruangtamu3.jpg" alt="Room Image 3">
                <img src="img/index/ruangtamu4.jpg" alt="Room Image 4">
                <img src="img/index/ruangtamu5.jpg" alt="Room Image 5">
                <img src="img/index/ruangtamu6.jpg" alt="Room Image 6">
                <img src="img/index/ruangtamu7.jpg" alt="Room Image 7">
                <img src="img/index/ruangtamu8.jpg" alt="Room Image 8">
                <img src="img/index/ruangtamu9.jpg" alt="Room Image 9">
                <img src="img/index/ruangtamu10.jpg" alt="Room Image 10">
                <img src="img/index/ruangtamu11.jpg" alt="Room Image 11">
                <img src="img/index/ruangtamu12.jpg" alt="Room Image 12">
                <img src="img/index/ruangtamu13.jpg" alt="Room Image 13">
                <img src="img/index/ruangtamu14.jpg" alt="Room Image 14">
                <img src="img/index/ruangtamu15.jpg" alt="Room Image 15">
                <img src="img/index/ruangtamu16.jpg" alt="Room Image 16">
                <img src="img/index/ruangtamu18.jpg" alt="Room Image 18">
                <img src="img/index/ruangtamu19.jpg" alt="Room Image 19">
                <img src="img/index/ruangtamu20.jpg" alt="Room Image 20">
                <img src="img/index/ruangtamu21.jpg" alt="Room Image 21">
                <img src="img/index/ruangtamu22.jpg" alt="Room Image 22">
                <img src="img/index/ruangtamu23.jpg" alt="Room Image 23">
                <img src="img/index/ruangtamu24.jpg" alt="Room Image 24">
                <img src="img/index/ruangtamu25.jpg" alt="Room Image 25">
                <img src="img/index/ruangtamu26.jpg" alt="Room Image 26">
                <img src="img/index/ruangtamu27.jpg" alt="Room Image 27">
                <img src="img/index/ruangtamu28.jpg" alt="Room Image 28">
                <img src="img/index/ruangtamu29.jpg" alt="Room Image 29">
                <img src="img/index/ruangtamu30.jpg" alt="Room Image 30">
                <img src="img/index/ruangtamu31.jpg" alt="Room Image 31">
                <img src="img/index/ruangtamu32.jpg" alt="Room Image 32">
                <img src="img/index/ruangtamu33.jpg" alt="Room Image 33">
                <img src="img/index/ruangtamu34.jpg" alt="Room Image 34">
                <img src="img/index/ruangtamu35.jpg" alt="Room Image 35">
                <img src="img/index/ruangtamu36.jpg" alt="Room Image 36">
                <img src="img/index/ruangtamu37.jpg" alt="Room Image 37">
                <img src="img/index/ruangtamu38.jpg" alt="Room Image 38">
                <img src="img/index/ruangtamu39.jpg" alt="Room Image 39">
                <img src="img/index/ruangtamu40.jpg" alt="Room Image 40">
                <img src="img/index/ruangtamu41.jpg" alt="Room Image 41">
                <img src="img/index/ruangtamu42.jpg" alt="Room Image 42">
                <img src="img/index/ruangtamu43.jpg" alt="Room Image 43">
                <img src="img/index/ruangtamu44.jpg" alt="Room Image 44">
                <img src="img/index/ruangtamu45.jpg" alt="Room Image 45">
              </div>
              <button class="prev" onclick="moveImage(-1)">&#10094;</button>
              <button class="next" onclick="moveImage(1)">&#10095;</button>
            </div>
          </div>
          <div class="col-lg-7">
              <div class="welcome-content" style="display: flex; flex-direction: column; align-items: center;">
                <h2 class="mb-4"><span class="d-block">Welcome</span> to Azliyana Homestay</h2>
                <p>At Azliyana Homestay, we invite you to experience the warmth of home in the heart of nature. Our cozy accommodations are designed to provide you with comfort and relaxation, making your stay a memorable one. Enjoy our beautifully curated spaces, where every detail is crafted to make you feel at home.</p>
                <p>Whether you’re seeking a peaceful retreat or an adventure-filled getaway, our homestay is the perfect base for your journey. Discover the charm of local culture, indulge in delicious home-cooked meals, and create unforgettable memories with your loved ones. We look forward to welcoming you!</p>
                <a class="button button--active home-banner-btn mt-4" href="about_us.php">Learn More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ================ welcome section end ================= --> 
  </main>

  <?php 
    include "facilities.php";
    include "includes/footer.php"; 
  ?>

  <!-- JavaScript for sliders -->
  <script>
    // Hero Slider JavaScript
    let currentIndex = 0;
    const heroSlides = document.querySelectorAll('.hero .slider img');
    const totalHeroSlides = heroSlides.length;

    function moveSlider(step) {
      currentIndex += step;

      // Ensure currentIndex wraps around within bounds
      if (currentIndex >= totalHeroSlides) {
        currentIndex = 0;
      } else if (currentIndex < 0) {
        currentIndex = totalHeroSlides - 1;
      }

      // Calculate translateX percentage
      const heroSlider = document.querySelector('.hero .slider');
      heroSlider.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    // Auto-slide every 5 seconds
    setInterval(() => moveSlider(1), 5000);

    // Image Slider JavaScript
    let currentImageIndex = 0;
    const imageSlides = document.querySelectorAll('.image-slider .slider img');
    const totalImageSlides = imageSlides.length;

    function moveImage(step) {
      currentImageIndex += step;

      // Ensure currentImageIndex wraps around within bounds
      if (currentImageIndex >= totalImageSlides) {
        currentImageIndex = 0;
      } else if (currentImageIndex < 0) {
        currentImageIndex = totalImageSlides - 1;
      }

      // Calculate translateX percentage
      const imageSlider = document.querySelector('.image-slider .slider');
      imageSlider.style.transform = `translateX(-${currentImageIndex * 100}%)`;
    }

    // Auto-slide every 5 seconds for images
    setInterval(() => moveImage(1), 5000);
  </script>
</body>
</html>
