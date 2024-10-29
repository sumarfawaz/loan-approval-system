<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnsubmit"])) {
    require_once("db_config.php");

    $stdusername = $_POST["username"];
    $stdpassword = $_POST["password"];

    // Sanitize user input for SQL query
    $stdusername = mysqli_real_escape_string($conn, $stdusername);

    $stmt = $conn->prepare("SELECT user_password FROM tbl_client WHERE client_username = ?");
    $stmt->bind_param("s", $stdusername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['user_password'];

        // Use password_verify to check hashed password
        if ($stdpassword === $storedPassword) {
            $_SESSION['login_status'] = "LoggedUser";
            $_SESSION['welcomelecname'] = $stdusername;
            header("location: dashboard.php");
            exit;
        } else {
            $signinerr = "Invalid username or password. Forgot password? Contact admin.";
        }
    } else {
        $signinerr = "Invalid username or password. Forgot password? Contact admin.";
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    $signinerr = "Please provide username and password.";
    // Redirect or display error message as needed
}
?>



<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Sign in</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        #signin {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 400px;
        }

        .login-key {
            background: #dc3545;
            padding: 15px 0;
            text-align: center;
            color: white;
            font-size: 2em;
        }

        .user-box {
            position: relative;
            margin-bottom: 25px;
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
    </style>
</head>
<body id="signin">
    <div class="login-box">
        <div class="col-lg-12 login-key">
            <i class="fa fa-key" aria-hidden="true"></i>
        </div>
        <h2 class="text-center mt-3 mb-4">Sign in</h2>
        <form class="px-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off" >
    <div class="form-group user-box">
        <input type="text" name="username" id="username" required autocomplete="off" value="">
        <label for="username">Username</label>
    </div>
    <div class="form-group user-box">
        <input type="password" name="password" id="pass" required autocomplete="off" value="">
        <label for="pass">Password</label>
    </div>
    <div class="form-check">
        <input type="checkbox" onclick="ShowPassword()" class="form-check-input" id="showpass">
        <label class="form-check-label" for="showpass">Show password</label>
    </div>
    <button type="submit" name="btnsubmit" value="Submit" class="btn btn-danger mt-3">Submit</button>
    <div class="col-12 text-center text-danger mt-3">
        <div id="nameHelp" class="form-text"><?php if(isset($signinerr)) echo $signinerr; ?></div>
    </div>
</form>
    </div>

    <!-- Bootstrap JS and dependencies (jQuery, Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-MCw98/SFnGE8fJT3SS6PvIajvV2uBY5zqz3Pz5nFv3ixpnbY6DhQpK2Os4WxW8E+" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        function ShowPassword() {
            var x = document.getElementById("pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>
