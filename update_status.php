<?php
// Include database configuration file
require_once("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];

    // Update loan status based on the action
    $status = ($action == 'accept') ? 'ACCEPTED' : 'REJECTED';
    $sql = "UPDATE loan_request SET loan_status = '$status' WHERE id = '$request_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Loan request status updated successfully.";
    } else {
        echo "Error updating loan request status: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
