<!-- Footer Start -->
<div class="container-fluid footer py-6 my-6 mb-0 wow bounceInUp" data-wow-delay="0.1s" style="background-color: #1d1d1d;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <img src="images/logo.jpg" alt="logo" width="100" height="65" class="mb-3">
                    <p class="lh-lg mb-4">REALIZE YOUR DREAM EVENT HERE!</p>
                    <div class="footer-icon d-flex">
                        <a class="btn btn-primary btn-sm-square me-2 rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-primary btn-sm-square me-2 rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-primary btn-sm-square me-2 rounded-circle"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-primary btn-sm-square rounded-circle"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="mb-4" style="color: white;">Our Services</h4>
                    <div class="d-flex flex-column align-items-start">
                        <a class="text-body mb-3" href="index.php#catalog"><i class="fa fa-check text-primary me-2"></i>Catalog</a>
                        <a class="text-body mb-3" href="index.php#hallLayout"><i class="fa fa-check text-primary me-2"></i>Hall Layout</a>
                        <a class="text-body mb-3" href="index.php#messageUs"><i class="fa fa-check text-primary me-2"></i>Message Us</a>
                        <a class="text-body mb-3" href="index.php#reviews"><i class="fa fa-check text-primary me-2"></i>Reviews</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <?php
                    // Fetch contact information from tblpage where pagetype is 'contactus'
                    $queryContact = "SELECT * FROM tblpage WHERE pagetype='contactus'";
                    $contactResult = mysqli_query($con, $queryContact);

                    if (!$contactResult) {
                        die('Error fetching contact information: ' . mysqli_error($con));
                    }

                    // Store the contact information in variables
                    $contactInfo = mysqli_fetch_assoc($contactResult);
                    $address = $contactInfo['PageDescription']; // Assuming the address is stored in the 'address' column
                    $phone = $contactInfo['MobileNumber']; // Assuming the phone number is stored in the 'phone' column
                    $email = $contactInfo['Email']; // Assuming the email is stored in the 'email' column
                    mysqli_free_result($contactResult);
                    ?>

                    <!-- Contact Us Start -->
                    <h4 class="mb-4" style="color: white;">Contact Us</h4>
                    <div class="d-flex flex-column align-items-start">
                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i> <?php echo htmlspecialchars($address); ?></p>
                        <p><i class="fa fa-phone-alt text-primary me-2"></i> <?php echo htmlspecialchars($phone); ?></p>
                        <p><i class="fas fa-envelope text-primary me-2"></i> <?php echo htmlspecialchars($email); ?></p>
                    </div>
                    <!-- Contact Us End -->

                </div>
            </div>
            <?php
            // Fetch the latest 6 images from tblcatalog
            $queryLatestImages = "SELECT img FROM tblcatalog ORDER BY img_id DESC LIMIT 6"; // Assuming there is a 'created_at' column to determine the latest entries
            $latestImagesResult = mysqli_query($con, $queryLatestImages);

            if (!$latestImagesResult) {
                die('Error fetching latest images: ' . mysqli_error($con));
            }

            // Store the images in an array
            $latestImages = [];
            while ($row = mysqli_fetch_assoc($latestImagesResult)) {
                $latestImages[] = $row['img'];
            }
            mysqli_free_result($latestImagesResult);
            ?>

            <!-- Events Gallery Start -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="mb-4" style="color: white;">Our Events Gallery</h4>
                    <div class="row g-2">
                        <?php
                        // Display the latest 6 images
                        foreach ($latestImages as $img) {
                        ?>
                            <div class="col-4">
                                <img style="height: 100px; width: 100px;" src="data:image/jpeg;base64,<?php echo base64_encode($img); ?>" class="img-fluid rounded-circle border border-primary p-2" alt="">
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div id="google_translate_element"></div>
                <script type="text/javascript">// <![CDATA[
                function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                }
                // ]]></script>
                <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script>
            <!-- Events Gallery End -->

        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Lanai Anggun</a>, All right reserved.</span>
            </div>
            <div class="col-md-6 my-auto text-center text-md-end text-white">
                Designed By <a class="border-bottom">Lanai Anggun</a>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->


<!-- Back to Top -->
<a href="#" class="btn btn-md-square btn-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>

</body>

</html>