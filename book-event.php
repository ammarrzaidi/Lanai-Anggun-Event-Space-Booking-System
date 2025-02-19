<?php
include('includes/dbconnection.php');
session_start();
error_reporting(E_ALL); // Enable all error reporting for debugging

// Debugging: Check if headers have already been sent
if (headers_sent()) {
    die('Headers already sent');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_booking'])) {
    // Retrieve and sanitize form data
    $clientName = htmlspecialchars(trim($_POST['client_name']));
    $mobileNumber = htmlspecialchars(trim($_POST['mobile_number']));
    $eventDate = htmlspecialchars(trim($_POST['event_date']));
    $eventTime = htmlspecialchars(trim($_POST['event_time']));
    $package = htmlspecialchars(trim($_POST['package']));

    // Generate booking ID and booking time
    $bookingID = uniqid(); // Generates a unique booking ID
    $bookingTime = date("Y-m-d H:i:s"); // Current date and time

    try {
        // Check date availability
        $sqlAvailability = "SELECT * FROM tblbooking WHERE event_date = :eventDate";
        $queryAvailability = $dbh->prepare($sqlAvailability);
        $queryAvailability->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
        $queryAvailability->execute();

        if ($queryAvailability->rowCount() > 0) {
            echo "<script>alert('The selected date is not available. Please choose another date.');</script>";
        } else {
            // Insert the booking details into the database
            $sqlInsertBooking = "INSERT INTO tblbooking (booking_id, booking_time, client_name, mobile_number, event_date, event_time, package) 
                                 VALUES (:bookingID, :bookingTime, :clientName, :mobileNumber, :eventDate, :eventTime, :package)";
            $queryInsertBooking = $dbh->prepare($sqlInsertBooking);
            $queryInsertBooking->bindParam(':bookingID', $bookingID, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':bookingTime', $bookingTime, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':clientName', $clientName, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':mobileNumber', $mobileNumber, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':eventTime', $eventTime, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':package', $package, PDO::PARAM_STR);

            if ($queryInsertBooking->execute()) {
                // Store booking information in session
                $_SESSION['booking_info'] = array(
                    'booking_id' => $bookingID,
                    'booking_time' => $bookingTime,
                    'client_name' => $clientName,
                    'mobile_number' => $mobileNumber,
                    'event_date' => $eventDate,
                    'event_time' => $eventTime,
                    'package' => $package
                );

                // Debugging output
                echo "<script>console.log('Booking inserted successfully. Redirecting...');</script>";
                // Log message to PHP error log
                error_log('Booking inserted successfully. Redirecting...');

                // Redirect to confirmation page after successful booking
                header("Location: confirmation.php");
                exit(); // Immediately stop script execution after redirection
            } else {
                // Handle booking insertion failure
                echo "<script>alert('Booking failed. Please try again.');</script>";
                error_log('Booking failed during database insertion.');
            }
        }
    } catch (PDOException $e) {
        // Catch any PDO exceptions and display the error message for debugging
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        error_log('Database error: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Event | Lanai Anggun</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- Font Awesome -->
    <link href="css/font-awesome.css" rel="stylesheet"> 
    <!-- Google Fonts -->
    <link href="//fonts.googleapis.com/css?family=Josefin+Sans:100,100i,300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300italic,300' rel='stylesheet' type='text/css'>
    <!-- jQuery -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.js"></script>
</head>

<body>
    <!-- Banner -->
    <div class="banner jarallax">
        <div class="agileinfo-dot">
            <?php include_once('includes/header.php');?>
            <div class="wthree-heading">
                <h2>Book an Event</h2>
            </div>
        </div>
    </div>
    <!-- Contact -->
    <div class="contact">
        <div class="container">
            <div class="agile-contact-form">
                <div class="col-md-6 contact-form-left">
                    <div class="agileits-contact-address">
                        <img src="images/3.jpg" alt="" height="500" width="500">
                    </div>
                </div>
                <div class="booking-form">
                    <div class="col-md-6 wthree-bottom-grid">
                        <div class="contact-form-top">
                            <h3>Book your dream event!</h3>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                <p>
                                    <label for="client_name">Client Name:</label>
                                    <input type="text" name="client_name" required>
                                </p>
                                <p>
                                    <label for="mobile_number">Mobile Number:</label>
                                    <input type="text" name="mobile_number" required>
                                </p>
                                <p>
                                    <label for="event_date">Event Date:</label>
                                    <input type="date" name="event_date" required>
                                </p>
                                <p>
                                    <label for="event_time">Event Time:</label>
                                    <select name="event_time">
                                        <option value="Morning">Morning Event (11am - 4pm)</option>
                                        <option value="Night">Night Event (7pm - 11pm)</option>
                                    </select>
                                </p>
                                <p>Check event packages in the Services > Catalog</p>
                                <p>
                                    <label for="package">Choose a Package:</label>
                                    <select name="package">
                                        <option value="sanding1">PS1 - Package Sanding RM22,900.00 /800pax</option>
                                        <option value="sanding2">PS2 - Package Sanding RM25,900.00 /1000pax</option>
                                        <option value="sanding3">PS3 - Package Sanding RM17,900.00 /500pax</option>
                                        <option value="nikahsanding1">PP1 - Package Premium: Nikah & Sanding RM24,900.00 /500pax</option>
                                        <option value="nikahsanding2">PP2 - Package Premium: Nikah & Sanding RM29,900.00 /800pax</option>
                                        <option value="nikah1">PLN1 - Package Lengkap Nikah RM17,900.00 /500pax</option>
                                        <option value="nikah2">PLN2 - Package Lengkap Nikah RM17,900.00 /300pax</option>
                                        <option value="nikah3">PLN3 - Package Lengkap Nikah RM17,900.00 /300pax</option>
                                        <option value="corporate">PCE - Package Corporate Event RM7,900 /100pax</option>
                                    </select>
                                </p>
                                <p>Deposit Payment has to be made to confirm your booking</p>
                                <p>
                                    <input type="submit" name="submit_booking" value="Confirm Booking">
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
  <!-- Footer -->
  <?php include_once('includes/footer.php');?>
    <!-- Jarallax -->
    <script src="js/jarallax.js"></script>
    <!-- Smooth Scroll -->
    <script src="js/SmoothScroll.min.js"></script>
    <script type="text/javascript">
        $('.jarallax').jarallax({
            speed: 0.5,
            imgWidth: 1366,
            imgHeight: 768
        });
    </script>
    <script src="js/SmoothScroll.min.js"></script>
    <script type="text/javascript" src="js/move-top"></script>
</body>
</html>