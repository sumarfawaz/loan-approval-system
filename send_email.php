<?php

session_start();
$_SESSION['welcomelecname'];

$applicant_username = $_SESSION['welcomelecname'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/PHPMailer-master/src/SMTP.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database configuration file
    require_once("db_config.php");

    // Retrieve form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    $loan_type = $conn->real_escape_string($_POST['loan-type']);

    // File handling
    $file_data = null;
    if (!empty($_FILES['attachment']['tmp_name'])) {
        $file_name = $_FILES['attachment']['name'];
        $file_data = file_get_contents($_FILES['attachment']['tmp_name']);
    }

    // SQL query to insert form data and file content into a table
    $sql = "INSERT INTO loan_request(username, name, email, message, loan_type, loan_status, attachment) VALUES ('$applicant_username', '$name', '$email', '$message', '$loan_type', 'PENDING', ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('b', $file_data);

    if ($stmt->execute()) {
        // Email details
        $to = "amna.united.mn@gmail.com"; // Replace with the recipient email address
        $subject = "New Inquiry";

        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = ''; // Replace with your SMTP username
            $mail->Password = ''; // Replace with your SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            // Sender and recipient
            $mail->setFrom($email, $name);
            $mail->addAddress($to);

            // Email content
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = "Name: $name\nEmail: $email\nLoan Type: $loan_type\nMessage: $message";

            // Attachment details
            if (!empty($_FILES['attachment']['tmp_name'])) {
                $file_name = $_FILES['attachment']['name'];
                $mail->addAttachment($_FILES['attachment']['tmp_name'], $file_name);
            }

            // Send email
            if ($mail->send()) {
                echo 'Your request was sent successfully, we will get back to you in three working days!';
            } else {
                echo "Failed to send email. Error: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $stmt->close();
    $conn->close();
}
?>
