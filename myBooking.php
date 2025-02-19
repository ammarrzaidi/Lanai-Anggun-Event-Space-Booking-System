<?php include('includes/dbconnection.php'); ?>
<?php session_start(); ?>
<?php include_once('partials/header.php'); ?>

<?php

/// Handle delete action if a booking ID is provided
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    
    try {
        // Update payment_stat to 'cancelled'
        $sqlUpdate = "UPDATE tblbooking SET payment_stat = 3 WHERE booking_id = :booking_id";
        $stmt = $dbh->prepare($sqlUpdate);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect to same page after update
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        error_log('Database error: ' . $e->getMessage());
    }
}

$currentUser = $_SESSION['login'];
try {
    // Fetch upcoming bookings
    $sqlUpcoming = "SELECT * FROM tblbooking WHERE email = :email AND event_date >= CURDATE() ORDER BY event_date ASC";
    $queryUpcoming = $dbh->prepare($sqlUpcoming);
    $queryUpcoming->bindParam(':email', $currentUser, PDO::PARAM_STR);
    $queryUpcoming->execute();
    $upcomingBookings = $queryUpcoming->fetchAll(PDO::FETCH_ASSOC);

    // Fetch past bookings
    $sqlPast = "SELECT * FROM tblbooking WHERE email = :email AND event_date < CURDATE() ORDER BY event_date DESC";
    $queryPast = $dbh->prepare($sqlPast);
    $queryPast->bindParam(':email', $currentUser, PDO::PARAM_STR);
    $queryPast->execute();
    $pastBookings = $queryPast->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    error_log('Database error: ' . $e->getMessage());
}
?>
<style>
        /* Custom CSS to adjust dropdown z-index */
        .dropdown-menu {
            z-index: 1000; /* Ensure dropdown appears above other content */
            position: absolute; /* Position dropdown absolutely */
            top: 100%; /* Align dropdown below button */
        }
    </style>
<body>

    <?php include_once('partials/navbar.php'); ?>

    <!-- Hero Start -->
    <div class="container-fluid bg-light py-6 my-6 mt-0">
        <div class="container text-center animated bounceInDown">
            <h1 class="display-1 mb-4">My Bookings</h1>
            <ol class="breadcrumb justify-content-center mb-0 animated bounceInDown">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item text-dark" aria-current="page">My Bookings</li>
            </ol>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Book Us Start -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Your Bookings</h2>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">Upcoming Bookings</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="past-tab" data-bs-toggle="tab" href="#past" role="tab" aria-controls="past" aria-selected="false">Past Bookings</a>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content" id="bookingTabsContent">
            <!-- Upcoming Bookings Tab -->
            <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                <div class="table-responsive mt-3">
                    <table style="min-height: 200px" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Booking Time</th>
                                <th>Client Name</th>
                                <th>Mobile Number</th>
                                <th>Event Date</th>
                                <th>Event Time</th>
                                <th>Package</th>
                                <th>Status</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($upcomingBookings)) { ?>
                                <?php foreach ($upcomingBookings as $booking) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['booking_id']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['booking_time']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['client_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['mobile_number']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['event_date']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['event_time']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['package']); ?></td>
                                        <td>
                                            <?php
                                            if ($booking['payment_stat'] == 0) {
                                                echo '<span class="badge bg-warning">Unpaid</span>';
                                            } elseif ($booking['payment_stat'] == 1) {
                                                echo '<span class="badge bg-success">Paid</span>';
                                            } elseif ($booking['payment_stat'] == 3) {
                                                echo '<span class="badge bg-danger">Cancelled</span>';
                                            } else {
                                                echo '<span class="badge bg-secondary">Unknown</span>'; // Handle any other cases if needed
                                            }
                                            ?>
                                        </td>
                                        <!-- <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                                    <li><a class="dropdown-item" href="#">Details</a></li>
                                                    <?php
                                            if (!$booking['payment_stat'] == 3) { ?>
                                                    <li><a class="dropdown-item" href="?action=delete&booking_id=<?php echo $booking['booking_id']; ?>">Delete</a></li>
                                                    <?php }?>
                                                </ul>
                                            </div>
                                        </td> -->
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="9" class="text-center">No upcoming bookings</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Past Bookings Tab -->
            <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
                <div class="table-responsive mt-3">
                    <table style="min-height: 170px" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Booking Time</th>
                                <th>Client Name</th>
                                <th>Mobile Number</th>
                                <th>Event Date</th>
                                <th>Event Time</th>
                                <th>Package</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pastBookings)) { ?>
                                <?php foreach ($pastBookings as $booking) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['booking_id']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['booking_time']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['client_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['mobile_number']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['event_date']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['event_time']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['package']); ?></td>
                                        <td>
                                            <?php
                                            if ($booking['payment_stat'] == 0) {
                                                echo '<span class="badge bg-warning">Unpaid</span>';
                                            } elseif ($booking['payment_stat'] == 1) {
                                                echo '<span class="badge bg-success">Paid</span>';
                                            } elseif ($booking['payment_stat'] == 3) {
                                                echo '<span class="badge bg-danger">Cancelled</span>';
                                            } else {
                                                echo '<span class="badge bg-secondary">Unknown</span>'; // Handle any other cases if needed
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                                    <li><a class="dropdown-item" href="#">Details</a></li>
                                                    <!-- <li><a class="dropdown-item" href="#">Delete</a></li> -->
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="9" class="text-center">No past bookings</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Book Us End -->

    <?php include_once('partials/footer.php'); ?>

</body>

</html>
