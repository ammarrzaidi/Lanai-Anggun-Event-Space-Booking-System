<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');
?>

<?php include_once('partials/header.php'); ?>


<body>
    <?php //include_once('partials/spinner.php');
    ?>
    <?php include_once('partials/navbar.php'); ?>

    <!-- banner -->
    <!-- Hero Start -->
    <div class="container-fluid bg-light py-6 my-6 mt-0">
        <div class="container text-center animated bounceInDown">
            <h1 class="display-1 mb-4">Message Us</h1>
            <ol class="breadcrumb justify-content-center mb-0 animated bounceInDown">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item text-dark" aria-current="page">Message Us</li>
            </ol>
        </div>
    </div>
    <!-- Hero End -->
    <section class="h-100 gradient-form">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <section class="vh-100">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6 px-0 d-none d-sm-block">
                                <img src="images/leftImg.jpg" alt="Login image" style="width: 100%; height: 100%; object-fit: cover; object-position: left;">
                            </div>
                            <div class="col-sm-6 text-black" style="margin-top: 12rem;">
                                <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

                                    <form action="process_form.php" method="post" style="width: 23rem;">

                                        <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Leave a message.</h3>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="form2Example18">Name*</label>
                                            <input type="text" name="name" id="form2Example18" style="border: 1px solid grey;" class="form-control form-control-lg" required />
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="form2Example28">Email*</label>
                                            <input type="email" name="email" id="form2Example28" style="border: 1px solid grey;" class="form-control form-control-lg" required />
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="form2Example28">Comments*</label>
                                            <textarea class="form-control" name="comment" rows="5" cols="40" required></textarea>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-md-4">Gender</label>
                                            <div class="col-md-10">
                                                <input type="radio" name="gender" value="female"> Female
                                                <input type="radio" name="gender" value="male"> Male
                                                <input type="radio" name="gender" value="other"> Other
                                            </div>
                                        </div>
                                        <div class="pt-1 mb-4 mt-3">
                                            <button type="submit" name="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="button">Submit</button>
                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <?php include_once('partials/footer.php'); ?>