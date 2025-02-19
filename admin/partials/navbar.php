<!-- Navbar start -->
<div class="container-fluid nav-bar" style="background-color: #3b3131;">
    <div class="container">
        <nav class="navbar navbar-light navbar-expand-lg py-3">
            <?php
            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] != 1) { ?>
                    <a href="index.php" class="navbar-brand">
                        <h1><a><img src="images/logo.jpg" alt="logo" width="100" height="65"></a></h1>
                    </a>
                <?php
                }
            } else { ?>
                <a href="index.php" class="navbar-brand">
                    <h1><a><img src="images/logo.jpg" alt="logo" width="100" height="65"></a></h1>
                </a>
            <?php } ?>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="../index.php" class="nav-item nav-link <?php if ($_SERVER['PHP_SELF'] == '/index.php') echo 'active'; ?>">Home</a>

                    <?php
                    // Check if user is authenticated
                    if (!isset($_SESSION['auth'])) {
                    ?>
                        <a href="../index.php#catalog" class="nav-item nav-link">Catalog</a>
                        <a href="../index.php#hallLayout" class="nav-item nav-link">Hall Layout</a>
                        <a href="../message-us.php" class="nav-item nav-link">Message Us</a>
                        <a href="../review.php" class="nav-item nav-link">Reviews</a>
                        <a href="../login.php" class="nav-item nav-link">Login</a>
                        <a href="../signup.php" class="nav-item nav-link">Register</a>
                    <?php } else { ?>
                        <a href="../index.php#catalog" class="nav-item nav-link">Catalog</a>
                        <a href="../index.php#hallLayout" class="nav-item nav-link">Hall Layout</a>
                        <a href="../index.php#messageUs" class="nav-item nav-link">Message Us</a>
                        <a href="../review.php" class="nav-item nav-link">Reviews</a>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">My Account</a>
                            <div class="dropdown-menu bg-light">
                                <a href="profileAdmin.php" class="dropdown-item">Profile</a>
                                <a href="../logout.php" class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <a href="index.php#bookUs" class="btn btn-primary py-2 px-4 d-none d-xl-inline-block rounded-pill">Book an Event</a>
            </div>
        </nav>
    </div>
</div>
<?php

// Check if there is a session message to display

if (isset($_SESSION['message'])) {
    // Display Bootstrap alert based on session message
?>
    <div id="alertMessage" class="alert alert-<?php echo ($_SESSION['message_type'] ?? 'warning'); ?> alert-dismissible fade show" role="alert" style="margin-bottom: 0px;">
        <strong><?php echo ($_SESSION['message_title'] ?? 'Message'); ?></strong> <?php echo $_SESSION['message']; ?>

    </div>
    <?php
    // Unset the session message after 10 seconds using JavaScript
    ?>
    <script>
        setTimeout(function() {
            var alertMessage = document.getElementById('alertMessage');
            alertMessage.parentNode.removeChild(alertMessage);
            <?php
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            unset($_SESSION['message_title']);?>
        }, 3000); // 5 seconds in milliseconds
    </script>
<?php
    // Unset the session message to prevent displaying it again

}
?>
<!-- Navbar End -->