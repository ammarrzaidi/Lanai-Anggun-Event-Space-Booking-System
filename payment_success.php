<?php
session_start();
include('includes/dbconnection.php');
?>
<?php include_once('partials/header.php'); ?>

<body>
    <?php //include_once('partials/spinner.php');
    ?>
    <?php include_once('partials/navbar.php'); ?>


    <!-- Hero Start -->
    <div class="container-fluid bg-light py-6 my-6 mt-0">
        <div class="container text-center animated bounceInDown">
            <!-- <h1 class="">Payment Successful</h1> -->
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="contact">
                            <h1 class="text-center display-1 mb-4">Payment Successful</h1>
                            <p class="text-center">Thank you for your payment. Your booking has been confirmed!</p>
                            <p class="text-center">We look forward to hosting your event.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <ol class="breadcrumb justify-content-center mb-0 animated bounceInDown">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Book</li>
                <li class="breadcrumb-item">Confirmation</li>
                <li class="breadcrumb-item">Payment</li>
                <li class="breadcrumb-item text-dark" aria-current="page">Payment Successful</li>
            </ol> -->
        </div>
    </div>
    <!-- Hero End -->




    <!-- footer -->
    <?php include_once('partials/footer.php'); ?>
    <!-- //footer -->
</body>

</html>