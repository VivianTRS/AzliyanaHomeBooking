<?php 
    include "../../admin/sidebar.php"; 
    include '../../includes/config.php';
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Homestay</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>
<body>
    <!-- Main Content -->
    <div class="container">
        <h2>View Homestay</h2>
        <a href="add_homestay.php" class="btn btn-success mb-3">Add Homestay</a> <!-- Add this line -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Homestay Name</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Fetch homestay records from the database
                $sql = "SELECT * FROM tbl_homestays";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['homestay_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name_homestay']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                        echo "<td>
                        <a href='add_homestay.php?id=" 
                        . htmlspecialchars($row['homestay_id']) 
                        . "' class='btn btn-warning btn-sm'>
                        <i class='fas fa-edit'></i> Edit</a>
                        
                        <a href='javascript:void(0);' onclick='confirmDelete(" 
                        . htmlspecialchars($row['homestay_id']) 
                        . ")' class='btn btn-danger btn-sm'>
                        <i class='fas fa-trash'></i> Delete</a>

                        <a href='add_images.php?id=" 
                        . htmlspecialchars($row['homestay_id']) 
                        . "' class='btn btn-warning btn-sm'> Add Image</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    
    <script>
        // JavaScript function to confirm deletion
        function confirmDelete(homestayId) {
            if (confirm("Are you sure you want to delete this homestay?")) {
                window.location.href = "delete_homestay.php?id=" + homestayId;
            }
        }
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>