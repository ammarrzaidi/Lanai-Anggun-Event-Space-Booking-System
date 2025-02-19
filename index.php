<?php

session_start();
if (isset($_SESSION['login'])) {
    $email = $_SESSION['login'];
}
error_reporting(E_ALL);
include('includes/dbconnection.php');

// Fetch promotion data from tblpromo
$query = "SELECT promo_id, promo_name, promo FROM tblpromo";

try {
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $promoDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error in SQL query: ' . $e->getMessage() . '<br>Query: ' . $query);
}

$queryCatelog = "SELECT DISTINCT category FROM tblcatalog";
$categories = mysqli_query($con, $queryCatelog);

$queryHall = "SELECT DISTINCT hall_name FROM tblhall_layout";
$halls = mysqli_query($con, $queryHall);

// try {
//     $stmt = $dbh->prepare($queryCatelog);
//     $stmt->execute();
//     $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
// } catch (PDOException $e) {
//     die('Error in SQL query: ' . $e->getMessage() . '<br>Query: ' . $query);
// }

// print_r($imageDataArray);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_booking'])) {
    // Retrieve and sanitize form data
    $clientName = htmlspecialchars(trim($_POST['client_name']));
    $mobileNumber = htmlspecialchars(trim($_POST['mobile_number']));
    $eventDate = htmlspecialchars(trim($_POST['event_date']));
    $eventTime = htmlspecialchars(trim($_POST['event_time']));
    $package = htmlspecialchars(trim($_POST['package']));

    // Generate booking ID and booking time
    // $bookingID = uniqid(); // Generates a unique booking ID
    $bookingTime = date("Y-m-d H:i:s"); // Current date and time

    try {
        // Check date availability
        $sqlAvailability = "SELECT * FROM tblbooking WHERE event_date = :eventDate";
        $queryAvailability = $dbh->prepare($sqlAvailability);
        $queryAvailability->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
        $queryAvailability->execute();

        if ($queryAvailability->rowCount() > 0) {
            
            $_SESSION['message'] = "The selected date is not available. Please choose another date.";
            header("Location: index.php");
            exit(); // Stop script execution after redirection
        } else {
            // Insert the booking details into the database
            $sqlInsertBooking = "INSERT INTO tblbooking ( booking_time, client_name, mobile_number, event_date, event_time, package, email) 
                                 VALUES (:bookingTime, :clientName, :mobileNumber, :eventDate, :eventTime, :package, :email)";
            $queryInsertBooking = $dbh->prepare($sqlInsertBooking);
            // $queryInsertBooking->bindParam(':bookingID', $bookingID, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':bookingTime', $bookingTime, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':clientName', $clientName, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':mobileNumber', $mobileNumber, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':eventTime', $eventTime, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':package', $package, PDO::PARAM_STR);
            $queryInsertBooking->bindParam(':email', $email, PDO::PARAM_STR);

            if ($queryInsertBooking->execute()) {
                $bookingID = $dbh->lastInsertId();

                // Store booking information in session
                $_SESSION['booking_info'] = array(
                    'booking_id' => $bookingID,
                    'booking_time' => $bookingTime,
                    'client_name' => $clientName,
                    'mobile_number' => $mobileNumber,
                    'event_date' => $eventDate,
                    'event_time' => $eventTime,
                    'package' => $package,
                    'email' => $email
                );

                // Debugging output
                // Display success message and redirect
                $_SESSION['message'] = "Booking inserted successfully";
                header("Location: confirmation.php");
                exit(); // Stop script execution after redirection
            } else {
                // Handle booking insertion failure
                $_SESSION['message'] = "Booking failed. Please try again.";
                header("Location: index.php");
                exit(); // Stop script execution after redirection
            }
        }
    } catch (PDOException $e) {
        // Catch any PDO exceptions and display error message
        $_SESSION['message'] = "Database error: " . $e->getMessage();
        error_log('Database error: ' . $e->getMessage());
        header("Location: index.php");
        exit(); // Stop script execution after redirection
    }
}
?>
<?php include_once('partials/header.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.testimonial-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1 // Adjust the number of items to show at different breakpoints
                },
                1000: {
                    items: 1 // Adjust to make the items wider
                }
            }
        });
    });
</script>

<body>
    <?php //include_once('partials/spinner.php');
    ?>
    <?php include_once('partials/navbar.php'); ?>
    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control bg-transparent p-3" placeholder="keywords" aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->


    <?php include_once('partials/hero.php');
    ?>
<!--
    <div class="container-fluid py-6">
        <div class="container">
            <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                <small class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Events</small>
                <h1 class="display-5 mb-5">Limited Promotions</h1>
            </div>
            <div class="owl-carousel owl-theme testimonial-carousel testimonial-carousel-1 mb-4 wow bounceInUp" data-wow-delay="0.1s">
                <?php foreach ($promoDataArray as $promo) { ?>
                    <div class="testimonial-item rounded" style="background-image: url('data:image/jpeg;base64,<?= base64_encode($promo['promo']) ?>');">

                    </div>

                <?php } ?>
                <?php foreach ($promoDataArray as $promo) { ?>
                    <div class="testimonial-item rounded" style="background-image: url('data:image/jpeg;base64,<?= base64_encode($promo['promo']) ?>');">

                    </div>

                <?php } ?>
            </div>

        </div>
    </div>
                -->

    <!-- Events Start -->
    <div class="container-fluid event py-6">
        <div class="container" id="catalog">
            <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                <small class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Latest Events</small>
                <h1 class="display-5 mb-5">Our Package Catelog</h1>
            </div>
            <div class="tab-class text-center">
                <ul class="nav nav-pills d-inline-flex justify-content-center mb-5 wow bounceInUp" data-wow-delay="0.1s">
                    <?php
                    // Fetch distinct categories from tblcatalog
                    $queryCategories = "SELECT DISTINCT category FROM tblcatalog";
                    $categoryResult = mysqli_query($con, $queryCategories);

                    if (!$categoryResult) {
                        die('Error fetching categories: ' . mysqli_error($con));
                    }

                    $firstCategory = true; // Variable to track the first category

                    // Display navigation tabs for each category
                    while ($row = mysqli_fetch_assoc($categoryResult)) {
                        $category = $row['category'];
                        // Sanitize category for use in ID
                        $sanitizedCategory = preg_replace('/[^a-zA-Z0-9]/', '_', $category);
                    ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php echo $firstCategory ? 'active' : ''; ?>" id="pills-<?php echo $sanitizedCategory; ?>-tab" data-bs-toggle="pill" href="#pills-<?php echo $sanitizedCategory; ?>" role="tab" aria-controls="pills-<?php echo $sanitizedCategory; ?>" aria-selected="<?php echo $firstCategory ? 'true' : 'false'; ?>"><?php echo $category; ?></a>
                        </li>
                    <?php
                        $firstCategory = false; // After the first category, set to false
                    }
                    mysqli_free_result($categoryResult);
                    ?>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <?php
                    // Reset the variable to true for tab panes
                    $firstCategory = true;

                    // Fetch events for each category and display them in respective tabs
                    $categoryResult = mysqli_query($con, $queryCategories);
                    while ($row = mysqli_fetch_assoc($categoryResult)) {
                        $category = $row['category'];
                        $escapedCategory = mysqli_real_escape_string($con, $category);
                        // Sanitize category for use in ID
                        $sanitizedCategory = preg_replace('/[^a-zA-Z0-9]/', '_', $category);
                        $queryEvents = "SELECT * FROM tblcatalog WHERE category='$escapedCategory'";
                        $eventsResult = mysqli_query($con, $queryEvents);

                        if (!$eventsResult) {
                            die('Error fetching events for category ' . $category . ': ' . mysqli_error($con));
                        }

                    ?>
                        <div class="tab-pane fade <?php echo $firstCategory ? 'show active' : ''; ?>" id="pills-<?php echo $sanitizedCategory; ?>" role="tabpanel" aria-labelledby="pills-<?php echo $sanitizedCategory; ?>-tab">
                            <div class="row g-4">
                                <?php
                                while ($event = mysqli_fetch_assoc($eventsResult)) {
                                ?>
                                    <div class="col-md-4 wow bounceInUp" data-wow-delay="0.1s">
                                        <div class="event-img position-relative">
                                            <a href="data:image/jpeg;base64,<?php echo base64_encode($event['img']); ?>" data-lightbox="<?php echo 'event-' . $event['img_id']; ?>" class="my-auto">
                                                <img class="lazy" style="height: 500px; width: 100%;" data-src="data:image/jpeg;base64,<?php echo base64_encode($event['img']); ?>" alt="<?php echo htmlspecialchars($event['package']); ?>">
                                                <div class="event-overlay d-flex flex-column p-4">
                                                    <h4 class="me-auto"><?php echo htmlspecialchars($event['description']); ?></h4>
                                                    <i class="fas fa-search-plus text-dark fa-2x"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                }
                                mysqli_free_result($eventsResult);
                                ?>
                            </div>
                        </div>
                    <?php
                        $firstCategory = false; // After the first category, set to false
                    }
                    mysqli_free_result($categoryResult);
                    ?>
                </div>

            </div>
        </div>
    </div>
    <!-- Events End -->

    <!-- Halls Start -->
    <div class="container-fluid event py-6">
        <div class="container" id="hallLayout">
            <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                <small class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Hall</small>
                <h1 class="display-5 mb-5">Hall Layout</h1>
            </div>
            <div class="tab-class text-center">
                <ul class="nav nav-pills d-inline-flex justify-content-center mb-5 wow bounceInUp" data-wow-delay="0.1s">
                    <?php
                    // Fetch distinct hall names from tblhall_layout
                    $queryHalls = "SELECT DISTINCT hall_name FROM tblhall_layout";
                    $hallResult = mysqli_query($con, $queryHalls);

                    if (!$hallResult) {
                        die('Error fetching halls: ' . mysqli_error($con));
                    }

                    $firstHall = true; // Variable to track the first hall

                    // Display navigation tabs for each hall
                    while ($row = mysqli_fetch_assoc($hallResult)) {
                        $hall = $row['hall_name'];
                        // Sanitize hall name for use in ID
                        $sanitizedHall = preg_replace('/[^a-zA-Z0-9]/', '_', $hall);
                    ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php echo $firstHall ? 'active' : ''; ?>" id="pills-<?php echo $sanitizedHall; ?>-tab" data-bs-toggle="pill" href="#pills-<?php echo $sanitizedHall; ?>" role="tab" aria-controls="pills-<?php echo $sanitizedHall; ?>" aria-selected="<?php echo $firstHall ? 'true' : 'false'; ?>"><?php echo $hall; ?></a>
                        </li>
                    <?php
                        $firstHall = false; // After the first hall, set to false
                    }
                    mysqli_free_result($hallResult);
                    ?>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <?php
                    // Reset the variable to true for tab panes
                    $firstHall = true;

                    // Fetch events for each hall and display them in respective tabs
                    $hallResult = mysqli_query($con, $queryHalls);
                    while ($row = mysqli_fetch_assoc($hallResult)) {
                        $hall = $row['hall_name'];
                        $escapedHall = mysqli_real_escape_string($con, $hall);
                        // Sanitize hall name for use in ID
                        $sanitizedHall = preg_replace('/[^a-zA-Z0-9]/', '_', $hall);
                        $queryHallLayouts = "SELECT * FROM tblhall_layout WHERE hall_name='$escapedHall'";
                        $hallLayoutsResult = mysqli_query($con, $queryHallLayouts);

                        if (!$hallLayoutsResult) {
                            die('Error fetching layouts for hall ' . $hall . ': ' . mysqli_error($con));
                        }

                    ?>
                        <div class="tab-pane fade <?php echo $firstHall ? 'show active' : ''; ?>" id="pills-<?php echo $sanitizedHall; ?>" role="tabpanel" aria-labelledby="pills-<?php echo $sanitizedHall; ?>-tab">
                            <div class="row g-4">
                                <?php
                                while ($hallLayout = mysqli_fetch_assoc($hallLayoutsResult)) {
                                ?>
                                    <div class="col-md-4 wow bounceInUp" data-wow-delay="0.1s">
                                        <div class="event-img position-relative">
                                            <a href="data:image/jpeg;base64,<?php echo base64_encode($hallLayout['img']); ?>" data-lightbox="<?php echo 'hall-' . $hallLayout['hall_id']; ?>" class="my-auto">
                                                <img class="lazy" style="height: 500px; width: 100%;" data-src="data:image/jpeg;base64,<?php echo base64_encode($hallLayout['img']); ?>" alt="<?php echo htmlspecialchars($hallLayout['hall_name']); ?>">
                                                <div class="event-overlay d-flex flex-column p-4">
                                                    <h4 class="me-auto"><?php echo htmlspecialchars($hallLayout['hall_name']); ?></h4>
                                                    <i class="fas fa-search-plus text-dark fa-2x"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                }
                                mysqli_free_result($hallLayoutsResult);
                                ?>
                            </div>
                        </div>
                    <?php
                        $firstHall = false; // After the first hall, set to false
                    }
                    mysqli_free_result($hallResult);
                    ?>
                </div>

            </div>
        </div>
    </div>
    <!-- Halls End -->

    <!-- Book Us Start -->
    <div class="container-fluid contact py-6 wow bounceInUp" data-wow-delay="0.1s" id="bookUs">
        <div class="container">
            <div class="row g-0">
                <div class="col-1">
                    <img src="images/3.jpg" class="img-fluid h-100 w-100 rounded-start" style="object-fit: cover; opacity: 0.7;" alt="">
                </div>
                <div class="col-10">
                    <div class="border-bottom border-top border-primary bg-light py-5 px-4">
                        <div class="text-center">
                            <small class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Book Us</small>
                            <h1 class="display-5 mb-5">Book your dream event!</h1>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                            <div class="row g-4 form">
                                <div class="col-lg-4 col-md-6">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" id="name" name="client_name" class="form-control border-primary p-2" placeholder="Full Name" required>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label for="contact" class="form-label">Your Contact No.</label>
                                    <input type="mobile" id="contact" name="mobile_number" class="form-control border-primary p-2" placeholder="Phone Number" required>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label for="date" class="form-label">Event Date</label>
                                    <input type="date" id="date" name="event_date" class="form-control border-primary p-2" placeholder="" required>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label for="event-time" class="form-label">Event Time</label>
                                    <select id="event-time" name="event_time" class="form-select border-primary p-2" aria-label="Default select example" required>
                                        <option selected>Select an Event Time</option>
                                        <option value="Morning">Morning Event (11am - 4pm)</option>
                                        <option value="Night">Night Event (7pm - 11pm)</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label for="package" class="form-label">Choose a Package</label>
                                    <select id="package" name="package" class="form-select border-primary p-2" aria-label="Default select example" required>
                                        <option selected>Select a package</option>
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
                                </div>

                                <div class="col-12 text-center">
                                    <div>
                                        <label for="package" class="form-label">*Deposit Payment has to be made to confirm your booking</label>

                                    </div>

                                    <!-- <button type="submit" name="submit-booking" >Confirm Booking</button> -->
                                    <input type="submit" name="submit_booking" class="btn btn-primary px-5 py-3 rounded-pill" value="Confirm Booking">

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-1">
                    <img src="images/3.jpg" class="img-fluid h-100 w-100 rounded-end" style="object-fit: cover; opacity: 0.7;" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Book Us End -->


    <?php include_once('partials/footer.php'); ?>

    <script>
        // Lazy loading images
        document.addEventListener("DOMContentLoaded", function() {
            let lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

            if ("IntersectionObserver" in window) {
                let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            let lazyImage = entry.target;
                            lazyImage.src = lazyImage.dataset.src;
                            lazyImage.classList.remove("lazy");
                            lazyImageObserver.unobserve(lazyImage);
                        }
                    });
                });

                lazyImages.forEach(function(lazyImage) {
                    lazyImageObserver.observe(lazyImage);
                });
            } else {
                // Fallback for older browsers
                let active = false;

                const lazyLoad = function() {
                    if (active === false) {
                        active = true;

                        setTimeout(function() {
                            lazyImages.forEach(function(lazyImage) {
                                if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
                                    lazyImage.src = lazyImage.dataset.src;
                                    lazyImage.classList.remove("lazy");

                                    lazyImages = lazyImages.filter(function(image) {
                                        return image !== lazyImage;
                                    });

                                    if (lazyImages.length === 0) {
                                        document.removeEventListener("scroll", lazyLoad);
                                        window.removeEventListener("resize", lazyLoad);
                                        window.removeEventListener("orientationchange", lazyLoad);
                                    }
                                }
                            });

                            active = false;
                        }, 200);
                    }
                };

                document.addEventListener("scroll", lazyLoad);
                window.addEventListener("resize", lazyLoad);
                window.addEventListener("orientationchange", lazyLoad);
            }
        });
    </script>
    <!-- Include Alertify JS library -->
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>

    <script>
        alertify.set('notifier', 'position', 'top-right');

        <?php
        // Start session to access session variables
        session_start();

        // Check if there is a session message to display
        if (isset($_SESSION['message'])) {
            // Output success message using alertify
        ?>
            alertify.success('<?= $_SESSION['message'] ?>');
        <?php
            // Unset the session message to prevent displaying it again
            unset($_SESSION['message']);
        } else {
            // If no session message, display an alert for invalid details
        ?>
            alertify.error('Invalid Details');
        <?php
        }
        ?>
    </script>