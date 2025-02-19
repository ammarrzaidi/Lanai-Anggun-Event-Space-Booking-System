<style>
   
        /* @media (max-width: 768px) {
            .banner {
                height: 50vh;
            }
        } */
        .bg-hero img {
            height: 100%;
            max-height: 80vh;
            margin: 0 auto;
        }
        @media (max-width: 768px) {
            .bg-hero img {
                max-height: 50vh;
            }
            .container-hero{
                max-height: 50vh;

            }
        }
</style>

<!-- Hero Start -->
<div class="banner jarallax">
    <div class="agileinfo-dot">
        <?php // include_once('includes/header.php');
        ?>
        <div class="w3layouts-banner">
            <div class="container-hero" style="height: 100vh;">
                <div  class="bg-hero d-flex" >

                <img src="images/hero.png" style="height: 80vh; margin: 0 auto;">
                </div>
                <!-- <div class="w3-banner-info">
                    <div class="w3l-banner-text">
                        <h2>Lanai Anggun at EcoSky</h2>
                        <p>Realize your dream event here!</p>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="w3ls-banner-info-bottom" style="color: white;">
            <div class="container">
                <div class="banner-address">
                    <?php
                    $sql = "SELECT * from tblpage where PageType='contactus'";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                        foreach ($results as $row) { ?>
                            <div class="container text-center">
                                <div class="row">
                                    <div class="col-md-4 mx-auto banner-address-left">
                                        <p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo htmlentities($row->PageDescription); ?></p>
                                    </div>
                                    <div class="col-md-4 mx-auto banner-address-left">
                                        <p><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo htmlentities($row->Email); ?></p>
                                    </div>
                                    <div class="col-md-4 mx-auto banner-address-left">
                                        <p><i class="fa fa-phone" aria-hidden="true"></i> +<?php echo htmlentities($row->MobileNumber); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"> </div>
                    <?php $cnt = $cnt + 1;
                        }
                    } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->