<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already started
}
$heading = "View User";
include('../includes/dbconnection.php');
if ($_SESSION['role'] != 1) {
    header("Location: index.php");
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

            <?php


            // Check if delete request is submitted
            if (isset($_GET['delete']) && isset($_GET['delete'])) {
                $deleteId = $_GET['delete'];
                $deleteSql = "DELETE FROM message WHERE messageID = $deleteId";
                if ($con->query($deleteSql) === TRUE) {
                    echo "<script>alert('message deleted successfully.');</script>";
                } else {
                    echo "<script>alert('Error deleting image: " . $con->error . "');</script>";
                    error_log("Error deleting message with ID $deleteId: " . $con->error);
                }
            }

            // Retrieve and display messages
            $messageSql = "SELECT messageid, name, comment, email, gender FROM message";
            $messageResult = $con->query($messageSql);
            ?>

            <div class="container-fluid pt-4 px-4" style="margin-bottom: 5rem;">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2>All Messages</h2>

                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th class="text-center">S.N.</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Comment</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Gender</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($messageResult === false) {
                                    echo "<tr><td colspan='6' class='text-center'>Error executing query: " . $con->error . "</td></tr>";
                                } elseif ($messageResult->num_rows > 0) {
                                    $count = 1;
                                    while ($messageRow = $messageResult->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td class="text-center"><?php echo $count; ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($messageRow["name"]); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($messageRow["comment"]); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($messageRow["email"]); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($messageRow["gender"]); ?></td>
                                            <td class="text-center"><a href="javascript:void(0);" onclick="deleteMessage(<?php echo $messageRow["messageid"]; ?>)">Delete</a></td>
                                        </tr>
                                <?php
                                        $count++;
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No messages found.</td></tr>";
                                }
                                $con->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Back to Top -->
    <a href="#" class="btn btn-md-square btn-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

</body>

<script>
    function deleteMessage(ID) {
        console.log(ID);
        if (confirm("Are you sure you want to delete this message?")) {
            $.ajax({
                url: "viewMessage.php?delete=" + ID,
                method: "get",
                success: function(data) {
                    alert("This message deleted Successfully");
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Error message : " + error);
                }
            });
        }
    }
</script>