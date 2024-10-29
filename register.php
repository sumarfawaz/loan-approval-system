<?php
session_start();

$user_created = ""; // Initialize the variable at the beginning
$username = ""; // Initialize the $username variable

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("db_config.php");
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['user_password'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password_confirmation = $_POST['confirm_password'];
    
    // SQL query to check if the username exists
    $sqlRead = "SELECT client_username FROM tbl_client WHERE client_username='$username'";
    $result = $conn->query($sqlRead);
    $sqlReadEmail = "SELECT email FROM tbl_client WHERE email='$email'";
    $resultEmail = $conn->query($sqlReadEmail);
    $sqlReadPhone = "SELECT phone_number FROM tbl_client WHERE phone_number='$phone_number'" ;
    $resultPhone = $conn->query($sqlReadPhone);

    if ($result->num_rows > 0) {
        // Username exists, display an error message
        $user_created = "Username already exists. Please choose a different username.";
        $username = ""; // Reset $username to empty string
    }else if($resultEmail->num_rows > 0){

        $user_created = "The email you entered belongs to some other user, please re-check your email or contact the admin and report the problem";
    } 
    else if ($resultPhone->num_rows > 0){
        $user_created = "The phone number you entered belongs to some other user, please re-check your phone number or contact the admin and report the problem" ;

    }else if ( $password != $password_confirmation){

        $user_created = "Passwords don't match";

    } else if ( strlen($phone_number) != 10 ){

        $user_created = "Invalid Phone Number, you have exceeded the phone number length";

    }else {
        // Username doesn't exist, proceed with insertion
        $sql = "INSERT INTO tbl_client (client_username, user_password, email, phone_number)
                VALUES ('$username', '$password', '$email', '$phone_number')";

        // Perform the insert query, check for errors
        if ($conn->query($sql) === TRUE) {
            $user_created = "User created: '$username'";
            header("location: signin.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Registration</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        #registration {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .registration-box {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 400px;
        }

        .registration-key {
            background: #dc3545;
            padding: 15px 0;
            text-align: center;
            color: white;
            font-size: 2em;
        }

        .user-box {
        /* Existing styles for the user-box */
        position: relative;
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px; /* Adjust as needed */
        position: absolute;
        bottom: -20px; /* Adjust as needed */
        left: 0;
    }
        .user-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #333;
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid #ccc;
            outline: none;
            background: transparent;
        }

        .user-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 16px;
            color: #333;
            pointer-events: none;
            transition: 0.5s;
        }

        .user-box input:focus ~ label,
        .user-box input:valid ~ label {
            top: -20px;
            font-size: 14px;
            color: #dc3545;
        }

        .btn-register {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-register:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        
    </style>
</head>
<body id="registration">
    <div class="registration-box">
        <div class="col-lg-12 registration-key">
            <i class="fa fa-user-plus" aria-hidden="true"></i>
        </div>
        <h2 class="text-center mt-3 mb-4">Register</h2>
        <form class="px-4" method="POST" action="register.php" >
        <!-- Inside your HTML form -->
            <div class="form-group user-box <?php echo ($user_created !== '' && $username === '') ? 'highlight' : ''; ?>">
                <input type="text" name="username" id="username" required autocomplete="off" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                <label for="username">Username</label>
                <?php if ($user_created !== '' && $username === '') : ?>
                    <p style="color:red;" class="error-message">Username is required</p>
                <?php endif; ?>
            </div>

            <div class="form-group user-box">
            <input type="password" name="user_password" id="password" required autocomplete="off" value="<?php echo isset($_POST['user_password']) ? htmlspecialchars($_POST['user_password']) : ''; ?>">
                <label for="user_password">Password</label>
            </div>
            <div class="form-group user-box">
            <input type="password" name="confirm_password" id="confirm_password" required autocomplete="off" value="<?php echo isset($_POST['confirm_password']) ? htmlspecialchars($_POST['confirm_password']) : ''; ?>">
                <label for="confirm_password">Confirm Password</label>
            </div>
            <div class="form-group user-box">
            <input type="email" name="email" id="email" required autocomplete="off" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <label for="email">Email</label>
            </div>
            <div class="form-group user-box">
            <input type="tel" name="phone_number" id="phone_number" required autocomplete="off" value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>">
                <label for="phone_number">Phone Number</label>
            </div>

            <p style="text-align:center;color:red;" >
            <?php
            if (!empty($user_created)) {
                echo $user_created;
            }
            ?>
            </p>

            <button type="submit" class="btn btn-register btn-block">Register</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies (jQuery, Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-MCw98/SFnGE8fJT3SS6PvIajvV2uBY5zqz3Pz5nFv3ixpnbY6DhQpK2Os4WxW8E+" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
