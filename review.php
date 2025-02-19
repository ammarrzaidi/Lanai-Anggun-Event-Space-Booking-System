<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');
?>

<?php include_once('partials/header.php'); ?>


<body>
    <?php //include_once('partials/spinner.php');
    ?>
    <?php include_once('partials/navbar.php'); ?>

	<!-- banner -->
	<!-- Hero Start -->
    <div class="container-fluid bg-light py-6 my-6 mt-0">
            <div class="container text-center animated bounceInDown">
                <h1 class="display-1 mb-4">Reviews</h1>
                <ol class="breadcrumb justify-content-center mb-0 animated bounceInDown">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item text-dark" aria-current="page">Reviews</li>
                </ol>
            </div>
        </div>
        <!-- Hero End -->
	<!-- //banner -->
	<!-- contact -->
    <div class="container">
        <div class='sk-ww-google-reviews' data-embed-id='252836'></div><script src='https://widgets.sociablekit.com/google-reviews/widget.js' async defer></script>    
    </div>            
	<!-- //contact -->

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
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/
								
			$().UItoTop({ easingType: 'easeOutQuart' });
								
			});
	</script>
<!-- //here ends scrolling icon -->
<script src="js/modernizr.custom.js"></script>
<?php include_once('partials/footer.php');?>

