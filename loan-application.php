<?php
session_start();
$_SESSION['welcomelecname'];

$username = $_SESSION['welcomelecname'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">

            <div class="col-md-6 offset-md-3">
                <h5>Download the application from here and submit the requested documents</h5>
                <a href="dummy.pdf" download="example.pdf">Download PDF</a>

        <h4>Fill the Loan Application Form</h4>

                <form action="send_email.php"  method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nic_number" placeholder="Enter your NIC Number" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                    </div>
                    <!--<div class="mb-3">
                        <label for="nationality" class="form-label">Nationality</label>
                        <select class="form-select" id="nationality" name="nationality">
                            <option value="USA">USA</option>
                            <option value="UK">UK</option>
                            <option value="Canada">Canada</option>
                            
                        </select>
                    </div>-->
                    <!--<div class="mb-3">
                        <input type="text" class="form-control" name="address" placeholder="Enter your address" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="client_phone_number" placeholder="Enter your phone number" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>-->
                    <div class="mb-3">
                        <label for="loan-type" class="form-label">Loan Type</label>
                        <select class="form-select" id="loan-type" name="loan-type">
                            <option value="Personal Loan">Personal Loan</option>
                            <option value="Home Loan">Home Loan</option>
                            <option value="Car Loan">Car Loan</option>
                            <!-- Add more loan types as needed -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="message" placeholder="Your Message" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="file" class="form-control" name="attachment">
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn btn-primary col-12">Submit</button>
                    </div>
                    <?php if (isset($successMessage)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $successMessage; ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

    </div>
    
    
</body>
</html>