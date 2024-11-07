<?php
function getHomestayById($conn, $homestay_id) {
    $sql = "SELECT * FROM tbl_homestays WHERE homestay_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $homestay_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
        } else {
            throw new Exception("Error executing query: " . $stmt->error);
        }
    } else {
        throw new Exception("Database query preparation failed.");
    }
}

function getAllHomestaysExcept($conn, $homestay_id) {
    $sql = "SELECT * FROM tbl_homestays WHERE homestay_id != ?"; // Adjust table name if necessary

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $homestay_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $homestays = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $homestays[] = $row;
        }
    }

    return $homestays;
}
?>