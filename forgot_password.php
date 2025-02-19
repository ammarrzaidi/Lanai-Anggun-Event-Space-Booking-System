<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);

if (isset($_POST['reset_password'])) {
    $email = $_POST['email'];

    // Check if email exists in the database
    $sql = "SELECT ID, Email FROM tbluser WHERE Email=:email";
    try {
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Generate a unique token
            $token = bin2hex(random_bytes(32));

            // Store token in the database with user's email
            $sqlInsertToken = "UPDATE tbluser SET reset_token = :token WHERE Email = :email";
            $stmt = $dbh->prepare($sqlInsertToken);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Redirect to reset password page with token
            header("Location: reset_password.php?token=" . $token);
            exit();
        } else {
            echo "<script>alert('Email not found in our database.');</script>";
        }
    } catch (PDOException $e) {
        die('Error in SQL query: ' . $e->getMessage() . '<br>Query: ' . $sql);
    }
}
?>

<style>
    body {
        background-color: #fafafa;
    }

    .card {
        margin-top: 50px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .card-header {
        background-color: #fff;
        border-bottom: none;
        font-size: 24px;
        text-align: center;
        padding: 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #3897f0;
        border: none;
    }

    .btn-primary:hover {
        background-color: #2684e1;
    }
</style>
<?php include 'partials/header.php'; ?>


<body>
    <?php include 'partials/navbar.php'; ?>
    <section class="bg-light p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xxl-11">
                    <div class="card border-light-subtle shadow-sm">
                        <div class="row g-0">
                            <div class="col-12 col-md-6">
                                <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy" src="images/3.jpg" alt="Welcome back you've been missed!">
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                                <div class="col-12 col-lg-11 col-xl-10">
                                    <div class="card-body p-3 p-md-4 p-xl-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-5">
                                                    <div class="text-center mb-4">
                                                        <a href="#!">
                                                            <img src="images/logo.jpg" alt="BootstrapBrain Logo" width="175" height="57">
                                                        </a>
                                                    </div>
                                                    <h2 class="h4 text-center">Forgot Password</h2>
                                                    <h3 class="h4 fs-6 fw-normal text-secondary text-center m-0">Provide the email address associated with your account to recover your password.</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="post">

                                            <div class="row gy-3 overflow-hidden">
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="email" class="form-control" id="inputIdentifier" name="email" placeholder="Email" required>
                                                        <label for="email" class="form-label">Email</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-primary btn-block" name="reset_password">Reset Password</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                                                    <a href="login.php" class="link-secondary text-decoration-none">Login</a>
                                                    <a href="signup.php" class="link-secondary text-decoration-none">Register</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>