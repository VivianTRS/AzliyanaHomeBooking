<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $msg = "";
    $homestay_id = $_GET['id'];

    include '../../includes/config.php';

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch homestay name based on homestay_id
    $homestayQuery = "SELECT name_homestay FROM tbl_homestays WHERE homestay_id='$homestay_id'";
    $homestayResult = mysqli_query($conn, $homestayQuery);
    $homestayData = mysqli_fetch_assoc($homestayResult);
    $homestay_name = $homestayData['name_homestay'];

    // If upload button is clicked ...
    if (isset($_POST['upload'])) {
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];

        // Define the folder path based on homestay name
        $homestayFolder = "../../img/home/" . $homestay_name;

        // Check if the folder exists, if not, create it
        if (!is_dir($homestayFolder)) {
            mkdir($homestayFolder, 0777, true);
        }

        // Construct new filename using homestay name and a unique ID
        $newFilename = $homestay_name . "_" . uniqid() . "_" . $filename;
        $folder = $homestayFolder . "/" . $newFilename;

        // Sanitize input to avoid SQL injection
        $newFilename = mysqli_real_escape_string($conn, $newFilename);

        // Insert image path and homestay ID into the database
        $sql = "INSERT INTO `tbl_homestay_images`(`homestay_id`, `image`) VALUES ('$homestay_id', '$newFilename')";

        // Execute query
        if (mysqli_query($conn, $sql)) {
            if (move_uploaded_file($tempname, $folder)) {
                echo "<h3>&nbsp; Image uploaded successfully!</h3>";
            } else {
                echo "<h3>&nbsp; Failed to upload image!</h3>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/gallery.css">
</head>
<body>
    <div id="content">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <input class="form-control" type="file" name="uploadfile" required />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
                <a href="view_homestay.php" class="btn btn-secondary">BACK</a>
            </div>
        </form>
    </div>

    <div id="display-image">
    <?php
    // Fetch the images for the homestay
    $query = "SELECT homestay_id, image FROM `tbl_homestay_images` WHERE homestay_id='$homestay_id'";
    $result = mysqli_query($conn, $query);

    while ($data = mysqli_fetch_assoc($result)) {
        $imagePath = "../../img/home/" . $homestay_name . "/" . $data['image'];
        ?>
        <img src="<?php echo $imagePath; ?>" alt="Homestay Image" style="width: 150px; height: 150px; margin: 10px;" 
             onclick="confirmDelete(<?php echo $data['homestay_id']; ?>, '<?php echo $data['image']; ?>')">
    <?php
    }
    mysqli_close($conn);
    ?>
    </div>

    <script>
    function confirmDelete(imageId, imageName) {
        if (confirm("Are you sure you want to delete this photo?")) {
            // Create a form to submit the delete request
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'delete_image.php';

            var idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = imageId;

            var nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'image_name';
            nameInput.value = imageName;

            form.appendChild(idInput);
            form.appendChild(nameInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
    </script>

</body>
</html>