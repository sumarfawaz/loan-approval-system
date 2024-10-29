<?php 

    session_start();
    $_SESSION['welcomelecname'];

    $username = $_SESSION['welcomelecname'];

    $usernameWithoutDots = str_replace('.', '', $username);
    $tld = substr($usernameWithoutDots, -2);  // Extract last 2 characters

    if($tld == 'mn'){
        $role = 'Manager';
    }else if ($tld == 'ac'){
        $role = 'Customer';
    }else if ($tld == 'ad'){
        $role = 'Admin';
    }

            // Remove "@" and characters after it
        $onlyFirstName = strstr($username, '@', true);

        // Check if "@" was found, if not, use the original username
        if ($onlyFirstName === false) {
            $onlyFirstName = $username;
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $role?> Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <style>
    /* Optional custom CSS for additional spacing */
    .form-group {
      margin-bottom: 20px;
    }
  </style>
  <script
  type="text/javascript"
  src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"
></script>
<script type="text/javascript">
  (function () {
    emailjs.init("S9QrG2ZnZLt5J5oDq");
  })();
</script>
<script src="index.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<style>
        body {
            background-color: #f8f9fa;
        }
        .container-fluid {
        }
        .sidebar {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            height: 100vh;
        }
        .sidebar-link {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: left;
        }
        .sidebar-link:hover {
            background-color: #495057;
        }
        .content {
            padding: 20px;
        }
        .advertisement {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
    </style>


</head>
<body>
    <h5 style="text-align:right;padding:10px;" class=""> <span style="text-transform:lowercase;"><?php echo $username;?></span> </h5>
    <h2 class="text-center" style="background-color:#343a40;color:white;padding:15px;">United Banking <?php echo $role?> Portal</h2>
    <!--<h3 style="text-align:center;">Role : <?php echo $role?> (The Dashboard is under development)</h3>-->

    <?php if ($role === 'Admin'): ?>
    <!-- Admin Creation Form -->
    <div class="container mt-5">
        <h2>Create Admin</h2>
        <form action="admin_creation_handler.php" method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="mb-3">
                <label for="national_id" class="form-label">National Identity Card Number</label>
                <input type="text" class="form-control" id="national_id" name="national_id" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <div class="mb-3">
                <label for="epf_number" class="form-label">EPF Number</label>
                <input type="text" class="form-control" id="epf_number" name="epf_number" required>
            </div>
            <div class="text-center"> <!-- Centered button container -->
                <button type="submit" class="btn btn-primary submit-btn">Create Admin</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <!--Client side dashboard rendering-->
    <?php if ($role === 'Customer' || 'Manager'): ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar shadow">
                <ul class="list-unstyled">
                    <?php if ($role === 'Customer'): ?>
                        <li><a href="loan-application.php" class="sidebar-link text-left">Loan Application</a></li>
                        <li><a href="loan_calculator.html" class="sidebar-link text-left">Loan Calculator</a></li>
                        <li><a href="loan-status.php" class="sidebar-link text-left">Loan Requests & Status</a></li>
                        <li><a href="pay-here.html" class="sidebar-link text-left">Pay Debt</a></li>
                    <?php endif; ?>

                    <?php if ($role === 'Manager'):?>
                        <li><a href="loan-status.php" class="sidebar-link text-left">Loan Requests & Status</a></li>

                    <?php endif; ?>
                </ul>
            </div>
            <!-- Content -->
            <div class="col-lg-10 content">
                <!-- Main content of your dashboard -->
                <div class="advertisement" id="advertisement-container">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="interest-rate.png" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="house-loan.png" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="personal-loan.png" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only"></span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only"></span>
  </a>
</div>
                </div>
            </div>
        </div>
    </div>

    

<script>
    // Dummy poster image filenames
    const posterImages = [
        "house-loan.png",
        "poster2.jpg",
        "poster3.jpg",
        // Add more image filenames as needed
    ];

    // Function to display a random poster image
    function displayRandomPoster() {
        const randomIndex = Math.floor(Math.random() * posterImages.length);
        const randomPosterImage = posterImages[randomIndex];

        // Update the image source in the container
        $("#poster-image").attr("src", randomPosterImage);
    }

    // Initial display of a random poster
    displayRandomPoster();

    // Optionally, update the poster every 30 seconds (30000 milliseconds)
    setInterval(displayRandomPoster, 30000);
</script>

    <?php endif; ?>

    
<script>
    function sendMail(event) {
        event.preventDefault(); // Prevent default form submission

        console.log("Function triggered");
  var params = {
    name: document.getElementById("name").value,
    national_id: document.getElementById("national_id").value
  };

  const serviceID = "service_s1ddnzs";
  const templateID = "template_evva7ar";

    emailjs.send(serviceID, templateID, params)
    .then(res=>{
        document.getElementById("name").value = "";
        document.getElementById("national_id").value = "";
        console.log(res);
        alert("Your message sent successfully!!")

    })
    .catch(err=>console.log(err));

}
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>



