<?php
    include 'includes/config.php'; // Database configuration
    $sql = 'SELECT * FROM tbl_homestays';
    $result = $conn->query($sql);
    $homestays = []; // Initialize an empty array

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $homestays[] = $row; // Populate the array with database rows
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accommodation</title>
    <link rel="icon" href="img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/blog.css">
    <style>
        .card-explore {
            border: 1px solid #e0e0e0; /* Light grey border */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            transition: transform 0.3s, box-shadow 0.3s; /* Smooth hover effect */
        }

        .card-explore:hover {
            transform: translateY(-5px); /* Slight lift on hover */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Stronger shadow on hover */
        }

        .card-explore__img {
            width: 100%;
            height: 200px; 
            overflow: hidden;
        }

        .card-explore__img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .homestay-image {
            width: 100%; /* Make the image take the full width of its container */
            height: 100%; /* Maintain aspect ratio */
            object-fit: cover; /* Ensure the image covers the entire area without distortion */
        }

        .card-body {
            padding: 15px; /* Add padding to the card body */
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    <?php include 'includes/header.php';?>
    
    <!-- ================ Start Banner Area ================= -->  
    <section class="blog-banner-area" id="about">
        <div class="container h-50">
        <div class="banner-content">
            <h1>Homestay</h1>
            <div class="breadcrumb-container">
            <nav aria-label="breadcrumb" class="banner-breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Homestay</li>
                </ol>
            </nav>
            </div>
        </div>
        </div>
    </section>
    <!-- ================ End Banner Area ================= -->

    <!-- ================ start homestay listing area ================= -->
    <section class="section-margin section-margin--small">
        <div class="container">
            <div class="section-intro text-center pb-80px">
                <div class="section-intro__style">
                    <img src="img/home/bed-icon.png" alt="">
                    <p><?php echo count($homestays); ?> Options</p>
                </div>
                <h2>Explore Available Homestay</h2>
            </div>

            <div class="row pb-4">
                <?php
                if (!empty($homestays)):
                    foreach ($homestays as $homestay):
                ?>
                    <div class="col-md-6 col-xl-4 mb-5">
                        <div class="card card-explore">
                            <div class="card-explore__img">
                                <img class="card-img" src="img/home/<?php echo htmlspecialchars($homestay['image']); ?>" alt="<?php echo htmlspecialchars($homestay['name_homestay']); ?>">
                            </div>
                            <div class="card-body">
                                <h3 class="card-explore__price">RM<?php echo htmlspecialchars($homestay['price']); ?> <sub>/ Night</sub></h3>
                                <h4 class="card-explore__title">
                                    <a href="homestay_details.php?homestay_id=<?php echo $homestay['homestay_id']; ?>"><?php echo htmlspecialchars($homestay['name_homestay']); ?></a>
                                </h4>
                                <a class="card-explore__link" href="homestay_details.php?homestay_id=<?php echo $homestay['homestay_id']; ?>">Book Now <i class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php
                    endforeach; // End of foreach loop
                else:
                    echo "<p>No homestays available at this time.</p>";
                endif; // End of if condition
                ?>
            </div>
        </div>
    </section>
    <!-- ================ end homestay listing area ================= -->

    <?php include "includes/footer.php"; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-whatever" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>