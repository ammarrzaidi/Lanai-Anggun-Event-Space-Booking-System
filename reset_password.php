<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists in the database
    $sql = "SELECT ID, Email FROM tbluser WHERE reset_token=:token";
    try {
        $query = $dbh->prepare($sql);
        $query->bindParam(':token', $token, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "<script>alert('Invalid or expired token. Please try again.');</script>";
            exit;
        }
    } catch (PDOException $e) {
        die('Error in SQL query: ' . $e->getMessage() . '<br>Query: ' . $sql);
    }

    if (isset($_POST['update_password'])) {
        $password = md5($_POST['password']);

        // Update password and clear reset token
        $sqlUpdate = "UPDATE tbluser SET Password = :password, reset_token = NULL WHERE ID = :id";
        try {
            $stmt = $dbh->prepare($sqlUpdate);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':id', $user['ID'], PDO::PARAM_INT);
            $stmt->execute();

            echo "<script>alert('Password updated successfully.');</script>";
            header("Location: login.php");

            exit;
        } catch (PDOException $e) {
            die('Error in SQL query: ' . $e->getMessage() . '<br>Query: ' . $sqlUpdate);
        }
    }
} else {
    echo "<script>alert('Token not found. Please request a new password reset.');</script>";
    echo "<script>window.location.href='forgot_password.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Reset Password</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="update_password">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
