<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Message Us | Lanai Anggun</title>

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
    <style>
        /* Center the form 
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        */

        /* Style the form container */
        .form-container {
            max-width: 400px;
            width: 100%;
            text-align: center; /* Center the content inside the form container */
        }
    </style>

</head>

<body>
	<!-- banner -->
	<div class="banner jarallax">
		<div class="agileinfo-dot">
			<?php include_once('includes/header.php');?>
			<div class="wthree-heading">
				<h2>Message Us</h2>
			</div>
		</div>
	</div>
	<!-- //banner -->
	<!-- contact -->
    
	<div class="contact">
    <div class="container">

            <div class="agile-contact-form">
            <div class="col-md-6 contact-form-left">
				
                <div class="agileits-contact-address">
            <img src="images/leftImg.jpg" alt="" height="500" width="500">
                </div>
            </div>

        <!-- Allow users to input and submit their information -->
            <div class="col-md-6 contact-form-right">
        <!-- Display User Profile Information -->
            <div class="contact-form-top">
            <br>     
            <h3><p>Leave a message.</p></h3></p>          
                <!-- message.php -->
                <form method="post" action="process_form.php">
                    <div class="form-group row">
                        <p><label class="col-form-label col-md-4">Name</label></p>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-4">E-mail</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Comment</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="comment" rows="5" cols="40" required><?php echo $comment; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Gender</label>
                        <div class="col-md-10">
                            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value="female"> Female
                            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value="male"> Male
                            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "other") echo "checked"; ?> value="other"> Other
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
		    </div>
				
			<div class="clearfix"> </div>
	        </div>
	
		
	</div>
	</div>
	<!-- //contact -->

</body>

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
