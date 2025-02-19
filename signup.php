<?php
include('includes/dbconnection.php');

session_start();

if (isset($_SESSION['auth'])) {
	$_SESSION['message'] = "You are already logged in";
	header('Location: index.php');
	exit();
}
if (isset($_POST['signup'])) {
	$fullName = $_POST['fullName'];
	$mobileNumber = $_POST['mobileNumber'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$regDate = date("Y-m-d H:i:s");

	// Check if the email already exists
	$checkEmail = "SELECT * FROM tbluser WHERE Email = :email";
	$checkQuery = $dbh->prepare($checkEmail);
	$checkQuery->bindParam(':email', $email, PDO::PARAM_STR);
	$checkQuery->execute();

	if ($checkQuery->rowCount() > 0) {
		echo "<script>alert('Email already exists. Please use a different email.');</script>";
	} else {
		$sql = "INSERT INTO tbluser (FullName, MobileNumber, Email, Password, RegDate, role) VALUES (:fullName, :mobileNumber, :email, :password, :regDate, 2)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':fullName', $fullName, PDO::PARAM_STR);
		$query->bindParam(':mobileNumber', $mobileNumber, PDO::PARAM_STR);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->bindParam(':password', $password, PDO::PARAM_STR);
		$query->bindParam(':regDate', $regDate, PDO::PARAM_STR);

		if ($query->execute()) {
			// echo "<script>alert('Registration successful. You can now login.');</script>";
			$_SESSION['message'] = "Registration successful. You can now login.";
            // Redirect to login page with error message
            header("Location: login.php");
            exit();
		} else {
			echo "<script>alert('Error in registration');</script>";
		}
	}
}
?>
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
<?php include 'partials/header.php'; ?>


<body>
	<?php include 'partials/navbar.php'; ?>
	<!-- MDB -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
	<section class="h-100 gradient-form" margin-top: 3rem;">
		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<section class="vh-100">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6 text-black" style="margin-top: 12rem;">
								<div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

									<form action="#" method="post" name="signup" style="width: 23rem;">

										<h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Create an Account</h3>

										<div data-mdb-input-init class="form-outline mb-4">
											<label class="form-label" for="form2Example18">Full Name</label>
											<input type="text" name="fullName" id="form2Example18" style="border: 1px solid grey;" class="form-control form-control-lg" required />
										</div>

										<div data-mdb-input-init class="form-outline mb-4">
											<label class="form-label" for="form2Example18">Mobile Number</label>
											<input type="tel" name="mobileNumber" id="form2Example18" style="border: 1px solid grey;" class="form-control form-control-lg" required />
										</div>

										<div data-mdb-input-init class="form-outline mb-4">
											<label class="form-label" for="form2Example18">Email address</label>
											<input type="email" name="email" id="form2Example18" style="border: 1px solid grey;" class="form-control form-control-lg" required />
										</div>

										<div data-mdb-input-init class="form-outline mb-4">
											<label class="form-label" for="form2Example28">Password</label>
											<input type="password" name="password" id="form2Example28" style="border: 1px solid grey;" class="form-control form-control-lg" required />
										</div>

										<div class="pt-1 mb-4">
											<button type="submit" name="signup" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="button">Submit</button>
										</div>

										<p class="small mb-5 pb-lg-2"><a class="text-muted" href="forgot_password.php">Forgot password?</a></p>
										<p>Already had an account? <a href="login.php" class="link-info">Login here</a></p>

									</form>

								</div>

							</div>
							<div class="col-sm-6 px-0 d-none d-sm-block">
								<img src="images/wed.jpg" alt="Login image" style="width: 100%; height: 100%; object-fit: cover; object-position: left;">
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</section>
	<?php include('partials/footer.php'); ?>

	<style>
		.gradient-custom-2 {
			/* fallback for old browsers */
			background: #fccb90;

			/* Chrome 10-25, Safari 5.1-6 */
			background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

			/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
			background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
		}

		@media (min-width: 768px) {
			.gradient-form {
				height: 100vh !important;
			}
		}

		@media (min-width: 769px) {
			.gradient-custom-2 {
				border-top-right-radius: .3rem;
				border-bottom-right-radius: .3rem;
			}
		}

		.navbar {
			--mdb-navbar-box-shadow: none !important;
		}
	</style>
	<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

	<script>
		alertify.set('notifier', 'position', 'top-right');
		<?php
		if (isset($_SESSION['message'])) { ?>

			alertify.success('<?= $_SESSION['message'] ?>');
		<?php
			unset($_SESSION['message']);
		} ?>
	</script>