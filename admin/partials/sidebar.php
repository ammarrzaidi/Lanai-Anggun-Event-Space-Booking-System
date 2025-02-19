<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already started
}


?>
<style>
    .sidebar {
        background-color: #2F2E2E;
        position: fixed;
        top: 0;
        bottom: 0;
        overflow-y: auto;
    }

    .content {
        margin-left: 18rem;
        flex: 1;
    }
</style>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/607f9bcbf8.js" crossorigin="anonymous"></script>

<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3" style="width: 18rem; background-color: #1d1d1d;">
    <nav class="navbar" style="margin-top: 5rem; ">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <?php
            if ($_SESSION['role'] == 1) {
            ?>
                <div class="align-items-center ms-4 position-relative">
                    <img class="rounded-circle" src="../images/logo.jpg" alt="" style="width: 120px;">
                </div>
            <?php } else { ?>
                <h3 class="text-primary" style="color: #fff !important;">@<?php echo $_SESSION['username'] ?></h3>
            <?php } ?>
        </a>
        <div class="text-center align-items-center ms-4 mb-4">
            <div class="ms-3">
                <h3 class="text-primary" style="color: #fff !important;">Admin</h3>
                <h5 class="mb-0" style="color: #fff !important;">Lanai Anggun</h5>
            </div>
        </div>
        <div class="navbar-nav w-100" style="margin-left: 25px;">
            <?php
            // Get the current script name
            $currentFile = basename($_SERVER['SCRIPT_NAME']);

            // Define active class based on the current URL
            $homeActive = $currentFile == 'adminindex.php' ? 'active' : '';
            $userActive = $currentFile == 'viewUser.php' ? 'active' : '';
            $uploadActive = $currentFile == 'viewCatalog.php' ? 'active' : '';
            $hallLayoutActive = $currentFile == 'viewHallLayout.php' ? 'active' : '';
            $uploadURLActive = $currentFile == 'upload-by-url' ? 'active' : '';
            $bookingsActive = $currentFile == 'viewBookings.php' ? 'active' : '';
            $messagesActive = $currentFile == 'viewMessage.php' ? 'active' : '';
            ?>

            <?php if ($_SESSION['role'] == 1) { ?>
                <a href="adminindex.php" class="nav-item nav-link <?php echo $homeActive ?>"><i class="fa fa-tachometer-alt me-2" style="margin-right: 1.5rem !important;"></i><span style="color: #fff !important;">Dashboard</span></a>
                <a href="viewUser.php" class="nav-item nav-link <?php echo $userActive ?>"><i class="fa-solid fa-users-gear" style="margin-right: 1.5rem !important;"></i><span style="color: #fff !important;">Users List</span></a>
                <a href="viewCatalog.php" class="nav-item nav-link <?php echo $uploadActive ?>"><i class="fa-solid fa-calendar-day" style="margin-right: 1.5rem !important;"></i><span style="color: #fff !important;">Catalog</span></a>
                <a href="viewHallLayout.php" class="nav-item nav-link <?php echo $hallLayoutActive ?>"><i class="fa-solid fa-building" style="margin-right: 1.5rem !important;"></i><span style="color: #fff !important;">Hall Layout</span></a>
                <a href="viewBookings.php" class="nav-item nav-link <?php echo $bookingsActive ?>"><i class="fa-solid fa-calendar-check" style="margin-right: 1.5rem !important;"></i><span style="color: #fff !important;">Bookings</span></a>
                <a href="viewMessage.php" class="nav-item nav-link <?php echo $messagesActive ?>"><i class="fa-solid fa-comments" style="margin-right: 1.5rem !important;"></i><span style="color: #fff !important;">Messages</span></a>
            <?php } ?>
        </div>
    </nav>
</div>
<!-- Sidebar End -->