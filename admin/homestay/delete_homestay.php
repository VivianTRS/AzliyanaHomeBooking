<?php
include '../../includes/config.php';

// Check if the homestay_id parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the homestay ID
    $homestayId = $_GET['id'];

    // Prepare the SQL delete query
    $sql = "DELETE FROM tbl_homestays WHERE homestay_id = '$homestayId'";

    // Execute the query and check if the deletion was successful
    if ($conn->query($sql) === TRUE) {
        // Fetch the name of the homestay to determine the folder path
        $homestayQuery = "SELECT name_homestay FROM tbl_homestays WHERE homestay_id = '$homestayId'";
        $result = $conn->query($homestayQuery);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $homestay_name = $row['name_homestay'];
            $homestayFolder = "../../img/home/" . $homestay_name; // 确保这里是正确的路径

            // Delete the directory
            if (is_dir($homestayFolder)) {
                // Delete all files in the directory
                $files = glob("$homestayFolder/*"); // Get all file names

                foreach ($files as $file) {
                    if (is_file($file)) {
                        if (unlink($file)) {
                            echo "Deleted file: $file<br>"; // Debug message
                        } else {
                            echo "Failed to delete file: $file<br>"; // Debug message
                        }
                    }
                }

                // Now remove the directory
                if (rmdir($homestayFolder)) {
                    echo "<script>alert('Homestay folder deleted successfully.');</script>";
                } else {
                    echo "<script>alert('Failed to delete homestay folder.');</script>";
                }
            } else {
                echo "<script>alert('Homestay folder does not exist.');</script>";
            }
        }

        echo "<script>alert('Homestay deleted successfully'); 
        window.location.href = 'view_homestay.php';</script>";
    } else {
        echo "Error deleting homestay: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "<script>alert('Invalid request. No homestay ID provided.'); 
    window.location.href = 'view_homestay.php';</script>";
}
?>