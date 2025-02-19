<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already started
}
$heading = "View User";
include('../includes/dbconnection.php');
if ($_SESSION['role'] != 1) {
    header("Location: index.php");
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $deleteSql = "DELETE FROM tblbooking WHERE booking_id = ?";

    $stmt = $con->prepare($deleteSql);
    $stmt->bind_param("i", $deleteId);

    if ($stmt->execute() === TRUE) {
        echo "<script>alert('Booking deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting Booking: " . $con->error . "');</script>";
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookingId'])) {
    $bookingId = intval($_POST['bookingId']);
    $userName = $_POST['name'];
    $userEmail = $_POST['email'];
    $userPhone = $_POST['phone'];
    $userAddress = $_POST['address'];

    $bookingEventDate = $_POST['bookingEventDate'];
    $bookingEventTime = $_POST['bookingEventTime'];
    $bookingEventPackage = $_POST['bookingEventPackage'];
    $bookingEventStatus = $_POST['bookingEventStatus'];

    // Update user details in the database
    // $sql = "UPDATE tbluser SET FullName = '$userName', Email = '$userEmail', MobileNumber = '$userPhone', Address = '$userAddress' WHERE ID = $userId";
    $sql = "UPDATE tblbooking SET client_name = '$userName', email = '$userEmail', mobile_number = '$userPhone', event_date = '$bookingEventDate', event_time = '$bookingEventTime', package = '$bookingEventPackage', payment_stat = '$bookingEventStatus' WHERE booking_id = $bookingId";

    if ($con->query($sql) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating user']);
    }
}

?>

<?php include 'partials/header.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<body>
    <div class="container-fluid position-relative bg-white d-flex p-0" style="height: 100vh;">

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

            <div class="container-fluid pt-4 px-4" style="margin-bottom: 5rem;">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2>All Bookings</h2>

                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">S.N.</th>
                                    <th scope="col">Booking ID</th>
                                    <th scope="col">Booking Time</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile Number</th>
                                    <th scope="col">Event Date</th>
                                    <th scope="col">Event Time</th>
                                    <th scope="col">Package</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $bookingSql = "SELECT * FROM tblbooking";
                                $bookingResult = $con->query($bookingSql);

                                if ($bookingResult === false) {
                                    echo "<tr><td colspan='5'>Error retrieving users: " . $con->error . "</td></tr>";
                                } else {
                                    if ($bookingResult->num_rows > 0) {
                                        $index = 1;
                                        while ($row = $bookingResult->fetch_assoc()) {
                                ?>
                                            <tr>
                                                <td><?= $index ?></td>
                                                <td>#<?php echo htmlspecialchars($row['booking_id']); ?></td>
                                                <td><?php echo htmlspecialchars($row['booking_time']); ?></td>
                                                <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                <td><?php echo htmlspecialchars($row['mobile_number']); ?></td>
                                                <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                                                <td><?php echo htmlspecialchars($row['event_time']); ?></td>
                                                <td><?php echo htmlspecialchars($row['package']); ?></td>
                                                <td>
                                                    <?php
                                                    if ($row['payment_stat'] == 1) {
                                                        echo '<span class="badge btn-primary" style="color: black;">Paid</span>';
                                                    } else {
                                                        echo '<span class="badge btn-warning" style="color: black;">Unpaid</span>';
                                                    }
                                                    ?>
                                                <td>
                                                    <a class="btn btn-sm btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#BookingDetailsModal<?php echo $row['booking_id']; ?>" data-user-id="<?php echo $row['booking_id'] ?>">Details</a>
                                                    <a class="btn btn-sm btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#editBookingDetailsModal<?php echo $row['booking_id']; ?>" data-user-id="<?php echo $row['booking_id'] ?>">Edit</a>
                                                    <a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="deleteBooking(<?php echo $row['booking_id'] ?>)">Delete</a>
                                                </td>
                                            </tr>
                                            <!-- Modal Structure -->
                                            <div class="modal fade" id="BookingDetailsModal<?php echo $row['booking_id']; ?>" tabindex="-1" aria-labelledby="BookingDetailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="BookingDetailsModalLabel">Booking Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- User Details Section -->
                                                                <div class="col-md-6">
                                                                    <h6>User Details</h6>
                                                                    <form id="userProfileForm">
                                                                        <div class="mb-3">
                                                                            <label for="userName" class="form-label text-start w-100">Name</label>
                                                                            <input type="text" class="form-control" id="userName" value="<?php echo htmlspecialchars($row['client_name']); ?>" readonly>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="userEmail" class="form-label text-start w-100">Email</label>
                                                                            <input type="email" class="form-control" id="userEmail" value="<?php echo htmlspecialchars($row['email']); ?>" readonly>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="userPhone" class="form-label text-start w-100">Phone</label>
                                                                            <input type="text" class="form-control" id="userPhone" value="<?php echo htmlspecialchars($row['mobile_number']); ?>" readonly>
                                                                        </div>

                                                                    </form>
                                                                </div>
                                                                <!-- Booking Details Section -->
                                                                <div class="col-md-6">
                                                                    <h6>Booking Details</h6>
                                                                    <form id="bookingDetailsForm">
                                                                        <div class="mb-3">
                                                                            <label for="bookingID" class="form-label text-start w-100">Booking ID</label>
                                                                            <input type="text" class="form-control" id="bookingID" value="#<?php echo htmlspecialchars($row['booking_id']); ?>" readonly>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="bookingTime" class="form-label text-start w-100">Booking Time</label>
                                                                            <input type="text" class="form-control" id="bookingTime" value="<?php echo htmlspecialchars($row['booking_time']); ?>" readonly>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="eventDate" class="form-label text-start w-100">Event Date</label>
                                                                            <input type="date" class="form-control" id="eventDate" value="<?php echo htmlspecialchars($row['event_date']); ?>" readonly>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="eventTime" class="form-label text-start w-100">Event Time</label>
                                                                            <input type="text" class="form-control" id="eventTime" value="<?php echo htmlspecialchars($row['event_time']); ?>" readonly>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="package" class="form-label text-start w-100">Package</label>
                                                                            <input type="text" class="form-control" id="package" value="<?php echo htmlspecialchars($row['package']); ?>" readonly>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--EDIT Modal Structure -->
                                            <div class="modal fade" id="editBookingDetailsModal<?php echo $row['booking_id']; ?>" tabindex="-1" aria-labelledby="editBookingDetailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editBookingDetailsModalLabel">Booking Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <form method="post" action="viewBookings.php">
                                                                    <!-- User Details Section -->
                                                                    <div class="col-md-6">
                                                                        <h6>User Details</h6>
                                                                        <div id="userProfileForm">
                                                                            <div class="mb-3">
                                                                                <label for="userName" class="form-label text-start w-100">Name</label>
                                                                                <input type="text" class="form-control" id="editUserName<?php echo $row['booking_id']; ?>" value="<?php echo htmlspecialchars($row['client_name']); ?>">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="userEmail" class="form-label text-start w-100">Email</label>
                                                                                <input type="email" class="form-control" id="editUserEmail<?php echo $row['booking_id']; ?>" value="<?php echo htmlspecialchars($row['email']); ?>">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="userPhone" class="form-label text-start w-100">Phone</label>
                                                                                <input type="text" class="form-control" id="editUserPhone<?php echo $row['booking_id']; ?>" value="<?php echo htmlspecialchars($row['mobile_number']); ?>">
                                                                            </div>
                                                                            <!-- <div class="mb-3">
                                                                                <label for="userAddress" class="form-label text-start w-100">Address</label>
                                                                                <input type="text" class="form-control" id="editUserAddress<?php echo $row['booking_id']; ?>" value="<?php echo htmlspecialchars($row['address']); ?>">
                                                                            </div> -->
                                                                        </div>
                                                                    </div>
                                                                    <!-- Booking Details Section -->
                                                                    <div class="col-md-6">
                                                                        <h6>Booking Details</h6>
                                                                        <div id="bookingDetailsForm">
                                                                            <div class="mb-3">
                                                                                <label for="bookingID" class="form-label text-start w-100">Booking ID</label>
                                                                                <input type="text" class="form-control" id="bookingID<?php echo $row['booking_id']; ?>" value="#<?php echo htmlspecialchars($row['booking_id']); ?>" readonly>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="bookingTime" class="form-label text-start w-100">Booking Time</label>
                                                                                <input type="text" class="form-control" id="bookingTime<?php echo $row['booking_id']; ?>" value="<?php echo htmlspecialchars($row['booking_time']); ?>" readonly>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="eventDate" class="form-label text-start w-100">Event Date</label>
                                                                                <input type="text" class="form-control" id="editEventDate<?php echo $row['booking_id']; ?>" value="<?php echo htmlspecialchars($row['event_date']); ?>">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="eventTime" class="form-label text-start w-100">Event Time</label>
                                                                                <select id="editEventTime<?php echo $row['booking_id']; ?>" name="event_time" class="form-select border-primary p-2" aria-label="Default select example" required>
                                                                                    <option value="<?php echo $row['event_time']; ?>"><?php echo $row['event_time']; ?></option>
                                                                                    <option value="Morning">Morning Event (11am - 4pm)</option>
                                                                                    <option value="Night">Night Event (7pm - 11pm)</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="package" class="form-label text-start w-100">Package</label>
                                                                                <select id="editPackage<?php echo $row['booking_id']; ?>" name="package" class="form-select border-primary p-2" aria-label="Default select example" required>
                                                                                    <option value="<?php echo $row['package']; ?>"><?php echo $row['package']; ?></option>
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
                                                                            <div class="mb-3">
                                                                                <label for="eventTime" class="form-label text-start w-100">Status</label>
                                                                                <select id="editEventStatus<?php echo $row['booking_id']; ?>" name="status" class="form-select border-primary p-2" aria-label="Default select example" required>
                                                                                    <option value="<?php echo $row['payment_stat']; ?>"><?php if($row['payment_stat'] == 1){ echo "Paid"; } else { echo "Unpaid"; }  ?></option>
                                                                                    <option value="0">Unpaid</option>
                                                                                    <option value="1">Paid</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="updateBooking(<?php echo $row['booking_id']; ?>)">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                <?php
                                            $index++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No users found.</td></tr>";
                                    }
                                }


                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Back to Top -->
        <a href="#" class="btn btn-md-square btn-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    </div>

</body>
<script>
    function deleteBooking(ID) {
        console.log(ID);
        if (confirm("Are you sure you want to delete this booking?")) {
            $.ajax({
                url: "viewBookings.php?delete=" + ID,
                method: "get",
                success: function(data) {
                    alert("Booking deleted Successfully");
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Error deleting Booking: " + error);
                }
            });
        }
    }
</script>
<script>
    function updateBooking(bookingId) {
        var userName = $('#editUserName' + bookingId).val();
        var userEmail = $('#editUserEmail' + bookingId).val();
        var userPhone = $('#editUserPhone' + bookingId).val();
        var userAddress = $('#editUserAddress' + bookingId).val();

        var bookingEventDate = $('#editEventDate' + bookingId).val();
        var bookingEventTime = $('#editEventTime' + bookingId).val();
        var bookingEventPackage = $('#editPackage' + bookingId).val();
        var bookingEventStatus = $('#editEventStatus' + bookingId).val();

        // AJAX call to update user details
        $.ajax({
            url: 'viewBookings.php', // Replace with your backend endpoint
            method: 'POST',
            data: {
                bookingId: bookingId,
                name: userName,
                email: userEmail,
                phone: userPhone,
                address: userAddress,
                bookingEventDate: bookingEventDate,
                bookingEventTime: bookingEventTime,
                bookingEventPackage: bookingEventPackage,
                bookingEventStatus: bookingEventStatus,
            },
            success: function(response) {
                // Handle success response, e.g., close modal, update UI, etc.
                $('#editUserProfileModal' + bookingId).modal('hide');
                alert('User updated successfully.');
                // Reload or update user list if needed
                location.reload();

            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error updating user:', error);
                alert('Failed to update user. Please try again.');
            }
        });
    }
</script>