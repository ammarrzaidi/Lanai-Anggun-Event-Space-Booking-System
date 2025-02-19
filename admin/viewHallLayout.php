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

            // Handle image deletion
            if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
                $deleteId = $_GET['delete'];
                $deleteSql = "DELETE FROM tblhall_layout WHERE hall_id = $deleteId";
                if ($con->query($deleteSql) === TRUE) {
                    echo "<script>alert('Image deleted successfully.');</script>";
                } else {
                    echo "<script>alert('Error deleting image: " . $con->error . "');</script>";
                    error_log("Error deleting image with ID $deleteId: " . $con->error);
                }
            }

            // Handle image upload
            $uploadSuccess = false;
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
                $image = file_get_contents($_FILES["image"]["tmp_name"]);
                $image = $con->real_escape_string($image);
                $hallname = $con->real_escape_string($_POST['hall_name']);

                $uploadSql = "INSERT INTO tblhall_layout (img, hall_name) VALUES ('$image', '$hallname')";

                if ($con->query($uploadSql) === TRUE) {
                    $uploadSuccess = true;
                } else {
                    echo "<script>alert('Error uploading image: " . $con->error . "');</script>";
                    error_log("Error uploading image: " . $con->error);
                }
            }

            // Check for successful image upload and redirect
            if ($uploadSuccess) {
                echo "<script>alert('Image uploaded successfully.');</script>";
                echo "<script>window.location.href = 'http://localhost/obbs/admin/adminindex.php#catalog';</script>";
                exit();
            }

            // Retrieve and display images
            $imageSql = "SELECT hall_id, img, hall_name FROM tblhall_layout";
            $imageResult = $con->query($imageSql);
            ?>

            <div class="container-fluid pt-4 px-4" style="margin-bottom: 5rem;">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2>Hall Layout Management</h2>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadImageModal">
                            Create new Hall Layout
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th class="text-center">S.N.</th>
                                    <th class="text-center">Hall Name</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($imageResult->num_rows > 0) {
                                    $count = 1;
                                    while ($imageRow = $imageResult->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td class="text-center"><?php echo $count; ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($imageRow["hall_name"]); ?></td>
                                            <td class="text-center"><img src="data:image/jpeg;base64,<?php echo base64_encode($imageRow["img"]); ?>" alt="Image" style="width: 100px; height: auto;"></td>
                                            <td class="text-center"><a href="javascript:void(0);" onclick="deleteImage(<?php echo $imageRow["hall_id"]; ?>)">Delete</a></td>
                                        </tr>
                                <?php
                                        $count++;
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No images found.</td></tr>";
                                }
                                $con->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadImageModalLabel">Upload Hall Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for image upload -->
                            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="hall_name" class="form-label">Enter hall name</label>
                                    <input type="text" class="form-control" name="hall_name" id="hall_name" placeholder="Enter hall name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Choose Image</label>
                                    <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary" value="Upload">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Back to Top -->
        <a href="#" class="btn btn-md-square btn-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


</body>
<script>
    function deleteImage(ID) {
        console.log(ID);
        if (confirm("Are you sure you want to delete this hall layout?")) {
            $.ajax({
                url: "viewHallLayout.php?delete=" + ID,
                method: "get",
                success: function(data) {
                    alert("This hall layout deleted Successfully");
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Error hall layout : " + error);
                }
            });
        }
    }
</script>