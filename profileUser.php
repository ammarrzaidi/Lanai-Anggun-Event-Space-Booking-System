<?php include('includes/dbconnection.php'); ?>
<?php session_start(); ?>
<?php include_once('partials/header.php'); ?>

<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = intval($_POST['id']);
    $userName = $_POST['name'];
    $userEmail = $_POST['email'];
    $userPhone = $_POST['phone'];
    $userAddress = $_POST['address'];
    $userPassword = $_POST['password'];

    // Base SQL for updating user details
    $sql = "UPDATE tbluser SET FullName = ?, Email = ?, MobileNumber = ?, Address = ?";
    
    // Append password update if provided
    if (!empty($userPassword)) {
        $hashedPassword = md5($userPassword);
        $sql .= ", Password = ?";
    }

    $sql .= " WHERE ID = ?";
    
    $stmt = $con->prepare($sql);

    if ($stmt) {
        // Bind parameters, including the password if provided
        if (!empty($userPassword)) {
            $stmt->bind_param("sssssi", $userName, $userEmail, $userPhone, $userAddress, $hashedPassword, $userId);
        } else {
            $stmt->bind_param("ssssi", $userName, $userEmail, $userPhone, $userAddress, $userId);
        }

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error updating user']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing the statement']);
    }
}
?>
<style>
    /* Custom CSS to adjust dropdown z-index */
    .dropdown-menu {
        z-index: 1000;
        /* Ensure dropdown appears above other content */
        position: absolute;
        /* Position dropdown absolutely */
        top: 100%;
        /* Align dropdown below button */
    }
</style>

<body>

    <?php include_once('partials/navbar.php'); ?>

    

    <div class="container-fluid contact py-6 wow bounceInUp" data-wow-delay="0.1s" id="bookUs">
        <div class="container">
            <div class="row g-0">
                <div class="col-1">
                    <img src="images/3.jpg" class="img-fluid h-100 w-100 rounded-start" style="object-fit: cover; opacity: 0.7;" alt="">
                </div>
                <div class="col-10">
                    <div class="border-bottom border-top border-primary bg-light py-5 px-4">
                        <div class="text-center">
                            <small class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Profile</small>
                            <h1 class="display-5 mb-5">My Profile</h1>
                        </div>
                        <?php

                        $currentEmail = $_SESSION['login'];
                        $userSql = "SELECT * FROM tbluser WHERE email = ?";
                        $stmt = $con->prepare($userSql);

                        if ($stmt) {
                            $stmt->bind_param("s", $currentEmail); // Bind parameters
                            $stmt->execute(); // Execute statement
                            $userResult = $stmt->get_result(); // Get result
                            if ($userResult->num_rows > 0) {
                                $userRow = $userResult->fetch_assoc(); // Fetch associative array
                                // Use $userRow to access user details
                            } else {
                                echo "No user found with the email: $currentEmail";
                            }
                            $stmt->close(); // Close statement
                        } else {
                            echo "Error preparing the statement: " . $con->error;
                        }
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                            <div class="row g-4 form">
                                <div class="col-lg-4 col-md-6">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" id="editUserName<?php echo $userRow['ID']; ?>" name="FullName" class="form-control border-primary p-2" value="<?php echo htmlspecialchars($userRow['FullName']); ?>" required>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label for="contact" class="form-label">Your Contact No.</label>
                                    <input type="mobile" id="editUserPhone<?php echo $userRow['ID']; ?>" name="MobileNumber" class="form-control border-primary p-2" value="<?php echo htmlspecialchars($userRow['MobileNumber']); ?>" required>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label for="date" class="form-label">Your Email</label>
                                    <input type="email" id="editUserEmail<?php echo $userRow['ID']; ?>" name="Email" class="form-control border-primary p-2" value="<?php echo htmlspecialchars($userRow['Email']); ?>" required>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label for="date" class="form-label">Your Password</label>
                                    <input type="password" id="editUserPassword<?php echo $userRow['ID']; ?>" name="Password" class="form-control border-primary p-2" value="" required>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label for="date" class="form-label">Your Address</label>
                                    <input type="text" id="editUserAddress<?php echo $userRow['ID']; ?>" name="address" class="form-control border-primary p-2" value="<?php echo htmlspecialchars($userRow['address']); ?>" required>
                                </div>

                                <div class="col-12 text-center">

                                    <!-- <button type="submit" name="submit-booking" >Confirm Booking</button> -->
                                    <button type="button" class="btn btn-primary px-5 py-3 rounded-pill" onclick="updateUser(<?php echo $userRow['ID']; ?>)">Update</button>

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

    <?php include_once('partials/footer.php'); ?>

</body>

<script>
    function updateUser(userId) {
        var userName = $('#editUserName' + userId).val();
        var userEmail = $('#editUserEmail' + userId).val();
        var userPhone = $('#editUserPhone' + userId).val();
        var userPassword = $('#editUserPassword' + userId).val();
        var userAddress = $('#editUserAddress' + userId).val();

        // AJAX call to update user details
        $.ajax({
            url: 'profileUser.php', // Replace with your backend endpoint
            method: 'POST',
            data: {
                id: userId,
                name: userName,
                password: userPassword,
                email: userEmail,
                phone: userPhone,
                address: userAddress
            },
            success: function(response) {
                // Handle success response, e.g., close modal, update UI, etc.
                $('#editUserProfileModal' + userId).modal('hide');
                alert('Profile updated successfully.');
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