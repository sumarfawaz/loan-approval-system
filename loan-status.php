<?php error_reporting (E_ALL ^ E_NOTICE); ?> 



<?php
session_start();
$_SESSION['welcomelecname'];

$applicant_username = $_SESSION['welcomelecname'];

$usernameWithoutDots = str_replace('.', '', $applicant_username);
$tld = substr($usernameWithoutDots, -2);  // Extract last 2 characters

require_once("db_config.php");

if ($tld == 'mn') {
    $role = 'Manager';
    $sql = "SELECT id, username, name, email, message, loan_type, loan_status, attachment FROM loan_request";
} else if ($tld == 'ac') {
    $role = 'Customer';
    $sql = "SELECT id, username, name, email, message, loan_type, loan_status, attachment FROM loan_request WHERE username='$applicant_username'";
} else if ($tld == 'ad') {
    $role = 'Admin';
    $sql = "SELECT id, username, name, email, message, loan_type, loan_status, attachment FROM loan_request";
}

// Remove "@" and characters after it
$onlyFirstName = strstr($applicant_username, '@', true);

// Check if "@" was found, if not, use the original username
if ($onlyFirstName === false) {
    $onlyFirstName = $applicant_username;
}
require_once("db_config.php");

// Fetch all loan requests from the database

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Loan Requests</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
            .actions {
                display: flex;
                gap: 10px;
            }
        </style>
    </head>
    <body>
    <?php
if ($role === 'Customer') {
    echo "<h2 style='text-align:center;'>Your Loan Requests</h2>";
} else {
    echo "<h2 style='text-align:center;'>Loan Requests</h2>";
}
?>

        <table>
            <thead>
                <tr>
                    
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Loan Type</th>
                    <th>Status</th>
                    <th>Attachment</th>
                    <?php if ($role === 'Manager'): ?>
                    <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['message']}</td>";
                    echo "<td>{$row['loan_type']}</td>";
                    echo "<td>{$row['loan_status']}</td>";
                    echo "<td><a href='view_pdf.php?id={$row['id']}' target='_blank'>View Attachment</a></td>";
                     if ($role === 'Manager'){
                    echo "<td class='actions'>
                            <form method='post' action='update_status.php'>
                                <input type='hidden' name='request_id' value='{$row['id']}'>
                                <button type='submit' name='action' value='accept'>Accept</button>
                                <button type='submit' name='action' value='reject'>Reject</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                }
                ?>
            </tbody>
        </table>
    </body>
    </html>
    <?php
} else {
    echo "No loan requests found.";
}

// Close the database connection
$conn->close();
?>
