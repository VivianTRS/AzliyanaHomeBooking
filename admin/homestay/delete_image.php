<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $message = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve image ID and name from the POST request
        $homestay_id = $_POST['id'];
        $image_name = $_POST['image_name'];

        include '../../includes/config.php';

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch the homestay name to construct the full file path
        $homestayQuery = "SELECT name_homestay FROM tbl_homestays WHERE homestay_id='$homestay_id'";
        $homestayResult = mysqli_query($conn, $homestayQuery);

        if ($homestayResult && mysqli_num_rows($homestayResult) > 0) {
            $homestayData = mysqli_fetch_assoc($homestayResult);
            $homestay_name = $homestayData['name_homestay'];
            
            // Full file path
            $filePath = "../../img/home/" . $homestay_name . "/" . $image_name;

            // Check if the file exists and delete it
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    // Delete the image record from the database
                    $deleteQuery = "DELETE FROM tbl_homestay_images WHERE homestay_id='$homestay_id' AND image='$image_name'";
                    if (mysqli_query($conn, $deleteQuery)) {
                        $message = "Image deleted successfully!";
                    } else {
                        $message = "Error deleting record: " . mysqli_error($conn);
                    }
                } else {
                    $message = "Failed to delete image file.";
                }
            } else {
                $message = "Image file does not exist.";
            }
        } else {
            $message = "Homestay not found.";
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        $message = "Invalid request.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Image</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        p {
            color: #555;
            text-align: center;
            font-size: 1.2em;
        }

        a {
            text-decoration: none; /* Remove underline from the link */
        }

        button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px auto;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <h1>Delete Image</h1>
    <p><?php echo htmlspecialchars($message); ?></p>
    <a href="add_images.php?id=<?php echo $homestay_id; ?>"><button>Back to Add Images</button></a>
</body>
</html>
