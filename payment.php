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

// Retrieve package details including price from tblcatalog
$sqlPackage = "SELECT * FROM tblcatalog WHERE package = :package";
$queryPackage = $dbh->prepare($sqlPackage);
$queryPackage->bindParam(':package', $bookingInfo['package'], PDO::PARAM_STR);
$queryPackage->execute();
$packageDetails = $queryPackage->fetch(PDO::FETCH_ASSOC);

if ($packageDetails === false) {
    // Handle the case where no package details are found
    echo "<script>alert('Package details not found.');</script>";
    exit();
}

// Retrieve the package price
$packagePrice = $packageDetails['price'];
?>


<?php include_once('partials/header.php'); ?>

<body>
    <?php //include_once('partials/spinner.php');
    ?>
    <?php include_once('partials/navbar.php'); ?>


    <!-- Hero Start -->
    <div class="container-fluid bg-light pt-5 my-6 mt-0">
        <div class="container text-center animated bounceInDown">
            <h1 class="display-1 mb-4">Payment</h1>
            <p class="text-center">Please review your booking details and proceed with the payment.</p>

            <ol class="breadcrumb justify-content-center mb-0 animated bounceInDown">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Book</li>
                <li class="breadcrumb-item">Confirmation</li>
                <li class="breadcrumb-item text-dark" aria-current="page">Payment</li>
            </ol>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Payment Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="contact">
                    <!-- <h2 class="text-center">Payment</h2> -->

                    <div class="confirmation-details">
                        <p><strong>Client Name:</strong> <?php echo htmlspecialchars($bookingInfo['booking_id'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Client Name:</strong> <?php echo htmlspecialchars($bookingInfo['client_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($bookingInfo['mobile_number'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Event Date:</strong> <?php echo htmlspecialchars($bookingInfo['event_date'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Event Time:</strong> <?php echo htmlspecialchars($bookingInfo['event_time'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Package:</strong> <?php echo htmlspecialchars($bookingInfo['package'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Total Price (10% of Package Price):</strong> RM<?php echo number_format($packagePrice, 3); ?></p>
                    </div>

                    <!-- Payment Form -->
                    <form action="process_payment.php" method="post">
                        <div class="form-group">
                            <label for="card_name">Cardholder Name:</label>
                            <input type="text" name="card_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="card_number">Card Number:</label>
                            <input type="text" name="card_number" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date:</label>
                            <input type="month" name="expiry_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV:</label>
                            <input type="text" name="cvv" class="form-control" required>
                        </div>
                        <input type="hidden" name="total_price" value="<?php echo $packagePrice; ?>">
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Pay Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- //Payment Content -->

    <!-- footer -->
    <?php include_once('partials/footer.php'); ?>
    <!-- //footer -->
</body>

</html>