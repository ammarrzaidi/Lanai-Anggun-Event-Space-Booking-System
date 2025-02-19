<?php
session_start();
include('includes/dbconnection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve user details
$sqlUser = "SELECT * FROM tbluser WHERE ID = :user_id";
$queryUser = $dbh->prepare($sqlUser);
$queryUser->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$queryUser->execute();
$userDetails = $queryUser->fetch(PDO::FETCH_ASSOC);

if ($userDetails === false) {
    // Handle the case where no user details are found
    echo "<script>alert('User details not found.');</script>";
    exit();
}

// Retrieve confirmed bookings
$sqlBookings = "SELECT * FROM tblbooking WHERE UserID = :user_id AND payment_status = 'paid'";
$queryBookings = $dbh->prepare($sqlBookings);
$queryBookings->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$queryBookings->execute();
$bookings = $queryBookings->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Lanai Anggun</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- Font Awesome Icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="//fonts.googleapis.com/css?family=Josefin+Sans:100,100i,300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300italic,300' rel='stylesheet' type='text/css'>
    <!-- jQuery -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.js"></script>
    <!-- Smooth Scroll -->
    <script src="js/SmoothScroll.min.js"></script>
    <!-- Custom JS for smooth scrolling -->
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){      
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
        });
    </script> 
    <!-- Scroll to top -->
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $().UItoTop({ easingType: 'easeOutQuart' });
        });
    </script>
    <!-- Jarallax -->
    <script src="js/jarallax.js"></script>
    <script type="text/javascript">
        /* init Jarallax */
        $('.jarallax').jarallax({
            speed: 0.5,
            imgWidth: 1366,
            imgHeight: 768
        })
    </script>
    <!-- Modernizr -->
    <script src="js/modernizr.custom.js"></script>
</head>
<body>
    <!-- header -->
    <?php include_once('includes/header.php'); ?>
    <!-- //header -->

    <!-- banner -->
    <div class="banner jarallax">
        <div class="agileinfo-dot">
            <div class="wthree-heading">
                <h2>User Profile</h2>
            </div>
        </div>
    </div>
    <!-- //banner -->

    <!-- Profile Content -->
    <div class="contact">
        <div class="container">
            <h2>User Profile</h2>
            <p>Welcome, <?php echo htmlspecialchars($userDetails['FullName'], ENT_QUOTES, 'UTF-8'); ?>!</p>

            <h3>Personal Details</h3>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($userDetails['FullName'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userDetails['Email'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($userDetails['MobileNumber'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($userDetails['Address'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Registration Date:</strong> <?php echo htmlspecialchars($userDetails['RegDate'], ENT_QUOTES, 'UTF-8'); ?></p>

            <h3>Confirmed Bookings</h3>
            <?php if (count($bookings) > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Booking Time</th>
                            <th>Event Date</th>
                            <th>Event Time</th>
                            <th>Package</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['booking_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($booking['booking_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($booking['event_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($booking['event_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($booking['event_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($booking['payment_status'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No confirmed bookings found.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- //Profile Content -->

    <!-- footer -->
    <?php include_once('includes/footer.php'); ?>
    <!-- //footer -->
</body>    
</html>
