<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="img/front.jpg" type="image/jpg">
  <link rel="icon" href="img/front.jpg" type="image/jpg">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../css/styles.css">

  <style>
    /* Reduce the size of the logo */
    #logo img {
        width: 80px; /* Adjusted to a smaller size */
        height: auto;
    }

    /* Remove default focus outline for clicked links */
    .nav-link:focus {
        outline: none;
    }

    /* Default state for navigation links (no underline) */
    .nav.navbar-nav.menu_nav .nav-item .nav-link {
        font-size: 1.2rem; /* Increased font size */
        color: #fdfefe; /* All links black */
        padding: 10px 15px; /* Adjusted padding for links */
        text-decoration: none; /* No underline by default */
    }

    /* Underline effect on hover */
    .nav.navbar-nav.menu_nav .nav-item .nav-link:hover {
        text-decoration: underline; /* Underline when hovered */
        text-decoration-color: #fdfefe; /* Color of the underline */
    }

    /* Remove hover effect for navigation links */
    .navbar-nav .nav-item .nav-link:hover {
        color: #fdfefe; /* Keep color black on hover */
        background-color: transparent; /* No background change on hover */
    }

    /* Smooth transition for underline and scroll effect */
    .navbar-nav .nav-item .nav-link {
        transition: color 0.3s ease, background-color 0.3s ease, text-decoration-color 0.3s ease; /* Added transition for underline color */
    }

    /* Align logo properly in the navbar */
    .navbar-nav {
        align-items: center;
    }

    /* Make the main menu smaller */
    .main_menu {
        padding: 5px 0; /* Reduced padding for the main menu */
    }

    /* Reduce the size of the social icons */
    .social-icons li a {
        font-size: 0.8rem; /* Reduced font size for social icons */
        padding: 5px; /* Reduced padding around social icons */
    }

    /* Reduce margin around navbar-toggler */
    .navbar-toggler {
        padding: 3px 5px; /* Reduced padding for the toggler */
    }

    /* Keep original case for the links */
    .nav-link {
        text-transform: none !important; /* Keep original case */
    }

    /* Increase the size of the social icons */
    .social-icons li a {
        font-size: 20px; /* Increased font size for social icons */
        margin-bottom: -7px;
    }
  </style>
</head>
<body>

<header class="header_area">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                </button>

                <!-- Place logo inside the navbar -->
                <div id="logo" class="navbar-brand">
                    <a href="index.php"><img src="img/logo.png" alt="Logo" title="Home" /></a>
                </div>
                
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="homestays.php">Booking</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="about_us.php">About Us</a></li>
                    </ul>
                    <ul class="social-icons ml-auto"> <!-- Use ml-auto to push this list to the right -->
                        <li class="nav-item">
                            <a href="admin/login.php"><i class="fas fa-user-tie"></i> Admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

<script>
    // JavaScript to change navbar background color when scrolling
    window.onscroll = function() {
        var navbar = document.querySelector('.navbar');
        if (window.pageYOffset > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    };
</script>

</body>
</html>
