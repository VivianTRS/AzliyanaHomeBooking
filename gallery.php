<?php
include 'includes/config.php';

// Fetch the images for the slider with homestay name
$query = "
    SELECT h.homestay_id, h.name_homestay, hi.image 
    FROM tbl_homestays h 
    JOIN tbl_homestay_images hi ON h.homestay_id = hi.homestay_id 
    WHERE h.homestay_id = '$homestay_id'
";
$result = mysqli_query($conn, $query);

// Fetch homestay folders from the database
$homestayFolders = [];
$folderQuery = "SELECT homestay_id, name_homestay FROM tbl_homestays";
$folderResult = mysqli_query($conn, $folderQuery);

while ($folderData = mysqli_fetch_assoc($folderResult)) {
    $homestayFolders[$folderData['homestay_id']] = $folderData['name_homestay'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Slider</title>
    <style>
        /* Basic slider styling */
        .slider {
            width: 1100px;
            position: relative;
            overflow: hidden;
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slides img {
            width: 600px;
            height: 400px;
        }

        .navigation {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .navigation button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="slider">
    <div class="slides">
        <?php
        while ($data = mysqli_fetch_assoc($result)) {
            $imageId = $data['homestay_id'];

            // Check if the homestay_id exists in the array
            $imageFolder = isset($homestayFolders[$imageId]) ? $homestayFolders[$imageId] : 'default-house'; // Default if not found

            // Define the image path
            $imagePath = "img/home/" . $imageFolder . "/" . $data['image'];

            echo "<img src='$imagePath' alt='Homestay Image'>";
        }
        ?>
    </div>
    <div class="navigation">
        <button id="prev">Previous</button>
        <button id="next">Next</button>
    </div>
</div>

<script>
    // JavaScript to enable slider functionality
    const slides = document.querySelector('.slides');
    const images = document.querySelectorAll('.slides img');
    let index = 0;

    function showSlide() {
        // Calculate the offset based on the current index
        slides.style.transform = 'translateX(' + (-index * 600) + 'px)';
    }

    // Next button event
    document.getElementById('next').addEventListener('click', () => {
        index++;
        if (index >= images.length) index = 0;
        showSlide();
    });

    // Previous button event
    document.getElementById('prev').addEventListener('click', () => {
        index--;
        if (index < 0) index = images.length - 1;
        showSlide();
    });

    // Auto-slide every 5 seconds (optional)
    setInterval(() => {
        index++;
        if (index >= images.length) index = 0;
        showSlide();
    }, 5000);
</script>

</body>
</html>

<?php mysqli_close($conn); ?>
