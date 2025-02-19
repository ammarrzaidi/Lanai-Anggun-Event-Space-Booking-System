<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already started
}


include('../includes/dbconnection.php');
if ($_SESSION['role'] != 1) { 
    header("Location: index.php");

}

$heading = " Admin Dashboard";
?>
<!-- head component start -->
<?php include 'partials/header.php'; ?>
<!-- head component end -->
<!-- Icon Font Stylesheet -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/607f9bcbf8.js" crossorigin="anonymous"></script>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">

        <!-- spinner component start -->
        <?php //include 'partials/spinner.php'; 
        ?>
        <!-- spinner component end -->

        <!-- sidebar component start -->
        <?php include 'partials/sidebar.php';
        ?>
        <!-- sidebar component end -->

        <!-- Content Start -->
        <div class="content" style="width: 100%;">

            <!-- navbar component start -->
            <?php include 'partials/navbar.php'; ?>
            <!-- navbar component end -->

            <!-- Sale & Revenue Start -->
            <div style="margin-top: 5rem;" class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 shadow-md border border-dark">
                            <i class="fa-solid fa-users fa-2xl " style="color: #1d1d1d;"></i>
                            <div class="ms-3">
                                <?php
                                $countUser = "SELECT COUNT(*) AS total_user FROM tbluser WHERE role = 2";
                                $queryUser = mysqli_query($con, $countUser) or die("Query Failed");
                                $resultUser = mysqli_fetch_assoc($queryUser);
                                $totalUser = $resultUser['total_user'];
                                ?>
                                <p class="mb-2">Total Users</p>
                                <h6 class="mb-0"><?php echo $totalUser ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 shadow-md border border-dark">
                            <i class="fa-solid fa-calendar-check fa-2xl " style="color: #1d1d1d;"></i>
                            <div class="ms-3">
                                <?php
                                $countBooking = "SELECT COUNT(*) AS total_booking FROM tblbooking WHERE payment_stat = 1";
                                $queryBooking = mysqli_query($con, $countBooking) or die("Query Failed");
                                $resultBooking = mysqli_fetch_assoc($queryBooking);
                                $totalBooking = $resultBooking['total_booking'];
                                ?>
                                <p class="mb-2">Total Bookings</p>
                                <h6 class="mb-0"><?php echo $totalBooking ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 shadow-md border border-dark">
                            <i class="fa-solid fa-calendar-day fa-2xl " style="color: #1d1d1d;"></i>
                            <div class="ms-3">
                                <?php
                                $countCatalog = "SELECT COUNT(*) AS total_catelog FROM tblcatalog";
                                $queryCatalog = mysqli_query($con, $countCatalog) or die("Query Failed");
                                $resultCatalog = mysqli_fetch_assoc($queryCatalog);
                                $totalCatalog = $resultCatalog['total_catelog'];
                                ?>
                                <p class="mb-2">Total Catalogs</p>
                                <h6 class="mb-0"><?php echo $totalCatalog ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 shadow-md border border-dark">
                            <i class="fa-solid fa-sack-dollar fa-2xl" style="color: #1d1d1d;"></i>
                            <div class="ms-3">
                                <?php
                                $totalSalesQuery = "SELECT SUM(tblcatalog.price) AS totalSales 
                            FROM tblbooking 
                            INNER JOIN tblcatalog ON tblbooking.package = tblcatalog.package 
                            WHERE tblbooking.payment_stat = 1";
                                $queryUser = mysqli_query($con, $totalSalesQuery) or die("Query Failed");
                                $resultUser = mysqli_fetch_assoc($queryUser);
                                $totalUsers = $resultUser['totalSales'];
                                ?>
                                <p class="mb-2">Total Sales</p>
                                <h6 class="mb-0">RM<?php echo $totalUsers ?></h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Sale & Revenue End -->


            <!-- Video Upload Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Total Bookings</h6>
                                <!-- <a href="">Show All</a> -->
                            </div>
                            <canvas id="booking-chart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Total Users </h6>
                                <!-- <a href="">Show All</a> -->
                            </div>
                            <canvas id="user-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales Chart End -->


            <!-- Recent Users Start -->
            <div class="container-fluid pt-4 px-4" style="margin-bottom: 5rem;">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Users</h6>
                        <a href="viewUser.php">Show all</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <!-- <th scope="col"><input class="form-check-input" type="checkbox"></th> -->
                                    <!-- <th scope="col">Date</th> -->
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile Number</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM tbluser WHERE role = 2 ORDER BY id DESC LIMIT 10";
                                $query = mysqli_query($con, $sql);
                                if (mysqli_num_rows($query) > 0) {
                                    // Loop through each material and display them
                                    while ($row = mysqli_fetch_assoc($query)) {

                                ?>

                                        <tr>
                                            <!-- <td><input class="form-check-input" type="checkbox"></td> -->
                                            <td><?php echo $row['FullName'] ?></td>
                                            <td><?php echo $row['Email'] ?></td>
                                            <td><?php echo $row['MobileNumber'] ?></td>
                                            <td><?php echo $row['address'] ?></td>
                                            <!-- <td>Active</td> -->
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="<?php echo $base_url ?>/user-details?id=<?php echo $row['ID'] ?>">Profil</a>
                                                <a class="btn btn-sm btn-warning" href="<?php echo $base_url ?>/user-delete?id=<?php echo $row['ID'] ?>">Delete</a>
                                            </td>
                                        </tr>
                                <?php     }
                                } else {
                                    echo "No recent users";
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->


            <!-- Widgets Start -->
            <!-- <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">Messages</h6>
                                <a href="">Show All</a>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center pt-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Calender</h6>
                                <a href="">Show All</a>
                            </div>
                            <div id="calender"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">To Do List</h6>
                                <a href="">Show All</a>
                            </div>
                            <div class="d-flex mb-2">
                                <input class="form-control bg-transparent" type="text" placeholder="Enter task">
                                <button type="button" class="btn btn-primary ms-2">Add</button>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox" checked>
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span><del>Short task goes here...</del></span>
                                        <button class="btn btn-sm "  style="color: #1d1d1d;"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center pt-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Widgets End -->


        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-md-square btn-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    </div>
    <?php
    // SQL query to get frequency of bookings by event type (package)
    // SQL query to fetch all catalog entries
    $catalogQuery = "SELECT description FROM tblcatalog";
    $catalogResult = mysqli_query($con, $catalogQuery);

    // Initialize an array to store catalog names
    $catalogNames = [];

    // Fetch and process each row from the result set
    while ($row = mysqli_fetch_assoc($catalogResult)) {
        $package = $row['description'];

        // Extract the name before "-"
        $packageName = trim(substr($package, 0, strpos($package, '-')));

        // Add the name to the array if it doesn't exist already
        if (!in_array($packageName, $catalogNames)) {
            $catalogNames[] = $packageName;
        }
    }


    // Initialize an array to store the frequencies
    $catalogFrequencies = array_fill(0, count($catalogNames), 0);

    // SQL query to get the count of bookings for each catalog name
    $bookingFrequencyQuery = "SELECT tblcatalog.description, COUNT(*) AS booking_count
                          FROM tblbooking
                          INNER JOIN tblcatalog ON tblbooking.package = tblcatalog.package 
                            WHERE tblbooking.payment_stat = 1
                          GROUP BY tblcatalog.description";
    $bookingFrequencyResult = mysqli_query($con, $bookingFrequencyQuery);

    // Populate the frequencies array with actual data
    while ($row = mysqli_fetch_assoc($bookingFrequencyResult)) {
        $package = $row['description'];
        $packageName = trim(substr($package, 0, strpos($package, '-')));

        $bookingCount = intval($row['booking_count']);

        // Find the index of the package name in $catalogNames array
        $index = array_search($packageName, $catalogNames);

        // Increment the frequency count at the corresponding index
        if ($index !== false) {
            $catalogFrequencies[$index] = $bookingCount;
        }
    }


    $successQuery = "SELECT COUNT(*) AS total_success_booking, MONTH(booking_time) AS month FROM tblbooking WHERE payment_stat = 1 GROUP BY MONTH(booking_time)";
    $successResult = mysqli_query($con, $successQuery);

    $successData = array_fill(0, 12, 0); // Initialize array to store video data for each month

    while ($row = mysqli_fetch_assoc($successResult)) {
        $monthIndex = intval($row['month']) - 1;
        $successData[$monthIndex] = intval($row['total_success_booking']);
    }

    $countUser = "SELECT COUNT(*) AS total_user, MONTH(RegDate) AS month FROM tbluser GROUP BY MONTH(RegDate)";
    $queryUser = mysqli_query($con, $countUser);

    $userData = array_fill(0, 12, 0); // Initialize array to store comment data for each month

    while ($row = mysqli_fetch_assoc($queryUser)) {
        $monthIndex = intval($row['month']) - 1;
        $userData[$monthIndex] = intval($row['total_user']);
    }
    ?>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script type="text/javascript">
        var catalogFrequencies = <?php echo json_encode($catalogFrequencies); ?>;
        var successData = <?php echo json_encode($successData); ?>;
        var userData = <?php echo json_encode($userData); ?>;
        var catalogNames = <?php echo json_encode($catalogNames); ?>;
    </script>
    <script src="../js/main.js"></script>

</body>

</html>