<?php
session_start();
include('includes/dbconnection.php');

// Check if booking information is stored in session
if (!isset($_SESSION['booking_info'])) {
    header("Location: index.php"); // Redirect to index page if no booking information is found
    exit();
}

// Retrieve booking information from session
$bookingInfo = $_SESSION['booking_info'];

// Retrieve package details including image name from tblcatalog
$sqlPackage = "SELECT img FROM tblcatalog WHERE package = :package";
$queryPackage = $dbh->prepare($sqlPackage);
$queryPackage->bindParam(':package', $bookingInfo['package'], PDO::PARAM_STR);
$queryPackage->execute();
$packageDetails = $queryPackage->fetch(PDO::FETCH_ASSOC);

if ($packageDetails === false) {
    // Handle the case where no package details are found
    echo "<script>alert('Package details not found.');</script>";
    exit();
}

// Get the image data
$imageData = $packageDetails['img'];
?>

<?php include_once('partials/header.php'); ?>

<body>
    <?php //include_once('partials/spinner.php');
    ?>
    <?php include_once('partials/navbar.php'); ?>


    <!-- Hero Start -->
    <div class="container-fluid bg-light pt-5 my-6 mt-0">
        <div class="container text-center animated bounceInDown">
            <h1 class="display-1 mb-4">Booking Confirmation</h1>
            <p class="text-center">Thank you for your booking! Please review the details below:</p>

            <ol class="breadcrumb justify-content-center mb-0 animated bounceInDown">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Book</li>
                <li class="breadcrumb-item text-dark" aria-current="page">Confirmation</li>
            </ol>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Booking Confirmation Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="contact">
                    <!-- <h2 class="text-center">Booking Confirmation</h2> -->

                    <div class="confirmation-details">
                        <p><strong>Client Name:</strong> <?php echo htmlspecialchars($bookingInfo['client_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($bookingInfo['mobile_number'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Event Date:</strong> <?php echo htmlspecialchars($bookingInfo['event_date'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Event Time:</strong> <?php echo htmlspecialchars($bookingInfo['event_time'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Package:</strong> <?php echo htmlspecialchars($bookingInfo['package'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>

                    <!-- Display the image associated with the package -->
                    <?php if ($imageData) : ?>
                        <div class="text-center mt-4 mb-4">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($imageData); ?>" alt="<?php echo htmlspecialchars($bookingInfo['package'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid">
                        </div>
                    <?php endif; ?>

                    <p class="text-center">Please confirm the details above. If everything looks correct, proceed to make the deposit payment.</p>

                    <!-- Add a button or link to proceed to payment -->
                    <div class="text-center">
                        <a href="payment.php" class="btn btn-primary">Proceed to Payment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- //Booking Confirmation Content -->

    <!-- footer -->
    <?php include_once('partials/footer.php'); ?>
    <!-- //footer -->
</body>

</html>