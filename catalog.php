<?php
session_start();
error_reporting(E_ALL);

include('includes/dbconnection.php');

// Fetch all image data from tblcatalog
$query = "SELECT img_id, img, package, description FROM tblcatalog";

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
    <title>Package Catalog | Lanai Anggun</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .image-container {
            position: relative;
            margin-bottom: 30px;
        }

        .image-container img {
            display: block;
            width: 100%;
            height: auto;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .image-container img.expanded {
            transform: scale(1.5);
            z-index: 10;
            position: absolute; 
        }

        .image-description {
            position: absolute;
            bottom: 10px; 
            left: 10px; 
            background-color: rgba(255, 255, 255, 0.7);
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 2;
            width: calc(100% - 20px);
        }
    </style>
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
    <div class="banner jarallax">
        <div class="agileinfo-dot">
            <?php include_once('includes/header.php');?>
            <div class="wthree-heading">
                <h2>Package Catalog</h2>
            </div>
        </div>
    </div>

    <div class="contact">
        <div class="container">
            <?php
            // Display images and descriptions
            foreach ($imageDataArray as $imageData) {
                echo '<div class="col-md-6 contact-form-left">';
                echo '<div class="agileits-contact-address">';
                echo '<div class="image-container">';
                // Display image
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData['img']) . '" alt="' . $imageData['package'] . '" onclick="expandImage(this)">';
                // Display description
                echo '<div class="image-description">' . $imageData['description'] . '</div>';
                echo '</div>'; // Close image-container
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <?php include_once('includes/footer.php');?>
    <script>
        function expandImage(img) {
            img.classList.toggle("expanded");
        }
    </script>
    <script src="js/jarallax.js"></script>
    <script src="js/SmoothScroll.min.js"></script>
</body>

</html>
