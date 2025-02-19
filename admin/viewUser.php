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
    $deleteSql = "DELETE FROM tbluser WHERE ID = ?";

    $stmt = $con->prepare($deleteSql);
    $stmt->bind_param("i", $deleteId);

    if ($stmt->execute() === TRUE) {
        echo "<script>alert('User deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting user 2: " . $con->error . "');</script>";
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = intval($_POST['id']);
    $userName = $_POST['name'];
    $userEmail = $_POST['email'];
    $userPhone = $_POST['phone'];
    $userAddress = $_POST['address'];

    // Update user details in the database
    $sql = "UPDATE tbluser SET FullName = '$userName', Email = '$userEmail', MobileNumber = '$userPhone', Address = '$userAddress' WHERE ID = $userId";

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
                        <h2>All Users</h2>

                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">S.N.</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile Number</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $userSql = "SELECT ID, FullName, MobileNumber, Email, Address, RegDate FROM tbluser where role != 1;";
                                $userResult = $con->query($userSql);

                                if ($userResult === false) {
                                    echo "<tr><td colspan='5'>Error retrieving users: " . $con->error . "</td></tr>";
                                } else {
                                    if ($userResult->num_rows > 0) {
                                        $index = 1;
                                        while ($row = $userResult->fetch_assoc()) {
                                ?>
                                            <tr>
                                                <td><?= $index ?></td>
                                                <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                                                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                                <td><?php echo htmlspecialchars($row['MobileNumber']); ?></td>
                                                <td><?php echo htmlspecialchars($row['Address']); ?></td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#userProfileModal<?php echo $row['ID']; ?>" data-user-id="<?php echo $row['ID'] ?>">Profile</a>
                                                    <a class="btn btn-sm btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#editUserProfileModal<?php echo $row['ID']; ?>" data-user-id="<?php echo $row['ID'] ?>">Edit</a>
                                                    <a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="deleteUser(<?php echo $row['ID'] ?>)">Delete</a>
                                                </td>
                                            </tr>
                                            <!-- Modal Structure -->
                                            <div class="modal fade" id="userProfileModal<?php echo $row['ID']; ?>" tabindex="-1" aria-labelledby="userProfileModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="userProfileModalLabel">User Profile</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Profile Details Form -->
                                                            <form id="userProfileForm">
                                                                <div class="mb-3">
                                                                    <label for="userName" class="form-label text-start w-100">Name</label>
                                                                    <input type="text" class="form-control" id="userName" value="<?php echo htmlspecialchars($row['FullName']); ?>" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="userEmail" class="form-label text-start w-100">Email</label>
                                                                    <input type="email" class="form-control" id="userEmail" value="<?php echo htmlspecialchars($row['Email']); ?>" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="userPhone" class="form-label text-start w-100">Phone</label>
                                                                    <input type="text" class="form-control" id="userPhone" value="<?php echo htmlspecialchars($row['MobileNumber']); ?>" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="userRole" class="form-label text-start w-100">Address</label>
                                                                    <input type="text" class="form-control" id="userRole" value="<?php echo htmlspecialchars($row['Address']); ?>" readonly>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Structure -->
                                            <div class="modal fade" id="editUserProfileModal<?php echo $row['ID']; ?>" tabindex="-1" aria-labelledby="editUserProfileModalLabel<?php echo $row['ID']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editUserProfileModalLabel<?php echo $row['ID']; ?>">Edit Profile</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Edit Profile Form -->
                                                            <form id="editUserProfileForm<?php echo $row['ID']; ?>">
                                                                <div class="mb-3">
                                                                    <label for="editUserName<?php echo $row['ID']; ?>" class="form-label text-start w-100">Name</label>
                                                                    <input type="text" class="form-control" id="editUserName<?php echo $row['ID']; ?>" value="<?php echo htmlspecialchars($row['FullName']); ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="editUserEmail<?php echo $row['ID']; ?>" class="form-label text-start w-100">Email</label>
                                                                    <input type="email" class="form-control" id="editUserEmail<?php echo $row['ID']; ?>" value="<?php echo htmlspecialchars($row['Email']); ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="editUserPhone<?php echo $row['ID']; ?>" class="form-label text-start w-100">Phone</label>
                                                                    <input type="text" class="form-control" id="editUserPhone<?php echo $row['ID']; ?>" value="<?php echo htmlspecialchars($row['MobileNumber']); ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="editUserAddress<?php echo $row['ID']; ?>" class="form-label text-start w-100">Address</label>
                                                                    <input type="text" class="form-control" id="editUserAddress<?php echo $row['ID']; ?>" value="<?php echo htmlspecialchars($row['Address']); ?>" required>
                                                                </div>
                                                                <input type="hidden" id="editUserId<?php echo $row['ID']; ?>" value="<?php echo $row['ID']; ?>">
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="updateUser(<?php echo $row['ID']; ?>)">Save changes</button>
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
    function deleteUser(ID) {
        console.log(ID);
        if (confirm("Are you sure you want to delete this user?")) {
            $.ajax({
                url: "viewUser.php?delete=" + ID,
                method: "get",
                success: function(data) {
                    alert("User deleted Successfully");
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Error deleting user: " + error);
                }
            });
        }
    }
</script>
<script>
    function updateUser(userId) {
        var userName = $('#editUserName' + userId).val();
        var userEmail = $('#editUserEmail' + userId).val();
        var userPhone = $('#editUserPhone' + userId).val();
        var userAddress = $('#editUserAddress' + userId).val();

        // AJAX call to update user details
        $.ajax({
            url: 'viewUser.php', // Replace with your backend endpoint
            method: 'POST',
            data: {
                id: userId,
                name: userName,
                email: userEmail,
                phone: userPhone,
                address: userAddress
            },
            success: function(response) {
                // Handle success response, e.g., close modal, update UI, etc.
                $('#editUserProfileModal' + userId).modal('hide');
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
