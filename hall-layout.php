<?php
session_start();
error_reporting(E_ALL);

include('includes/dbconnection.php');

// Fetch all image data from tblhall_layout
$query = "SELECT hall_id, img, hall_name FROM tblhall_layout";

try {
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $imageDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error in SQL query: ' . $e->getMessage() . '<br>Query: ' . $query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hall Layout | Lanai Anggun</title>

    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- bootstrap-css -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <!--// bootstrap-css -->
    <!-- css -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--// css -->
    <!-- font-awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome icons -->
    <!-- font -->
    <link href='//fonts.googleapis.com/css?family=Josefin+Sans:100,100i,300,300i,400,400i,600,600i,700,700i' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300italic,300' rel='stylesheet' type='text/css'>
    <!-- //font -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event) {
                event.preventDefault();
                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1000);
            });
        });
    </script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <!-- banner -->
    <div class="banner jarallax">
        <div class="agileinfo-dot">
            <?php include_once('includes/header.php'); ?>
            <div class="wthree-heading">
                <h2>Hall Layout</h2>
            </div>
        </div>
    </div>
    <!-- //banner -->
    <!-- contact -->
    <div class="contact">
        <div class="container">
            <div class="agile-contact-form">
                <?php foreach ($imageDataArray as $imageData) : ?>
                    <div class="col-md-6 contact-form-left">
                        <div class="agileits-contact-address">
                            <!-- Display each image with zoom feature -->
                            <a href="#" data-toggle="modal" data-target="#imageModal<?php echo $imageData['hall_id']; ?>">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($imageData['img']); ?>" alt="<?php echo $imageData['hall_name']; ?>" height="750" width="550">
                            </a>
                            <p><?php echo $imageData['hall_name']; ?></p>
                        </div>
                    </div>

                    <!-- Modal for zoomed image -->
                    <div class="modal fade" id="imageModal<?php echo $imageData['hall_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel<?php echo $imageData['hall_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel<?php echo $imageData['hall_id']; ?>"><?php echo $imageData['hall_name']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($imageData['img']); ?>" alt="<?php echo $imageData['hall_name']; ?>" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="booking-form">
                    <div class="col-md-6 wthree-bottom-grid">
                        <div class="contact-form-top">
                            <!-- ... (your existing form content) ... -->
                        </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <!-- //contact -->

    <?php include_once('includes/footer.php'); ?>
    <!-- jarallax -->
    <script src="js/jarallax.js"></script>
    <script src="js/SmoothScroll.min.js"></script>
    <script type="text/javascript">
        /* init Jarallax */
        $('.jarallax').jarallax({
            speed: 0.5,
            imgWidth: 1366,
            imgHeight: 768
        })
    </script>
    <!-- //jarallax -->
    <script src="js/SmoothScroll.min.js"></script>
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <!-- here stars scrolling icon -->
    <script type="text/javascript">
        $(document).ready(function() {
            $().UItoTop({
                easingType: 'easeOutQuart'
            });
        });
    </script>
    <!-- //here ends scrolling icon -->
    <script src="js/modernizr.custom.js"></script>

</body>
</html>
