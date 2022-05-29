<?php

require 'connect.php';
require 'session.php';
$prod_count = 0;
$id_client = 0;
$first_name = '';
$last_name = '';
$searchBtn = false;

if (!empty($_COOKIE['login'])) {
    $id_client = $_COOKIE['login'];
    $first_name = $_SESSION['user'][$id_client]['firstname'];
    $last_name = $_SESSION['user'][$id_client]['lastname'];
}
if (isset($_SESSION['user'][$id_client]['products'])) {
    $prod_count = $_SESSION['user'][$id_client]['product_count'];
}

if (isset($_POST['exit_btn'])) {
    setcookie('login', $_POST['exit_btn'], time() - 3600, '/');
    unset($_COOKIE['login']);
}

if (isset($_POST['searchField'])) {
    $searchBtn = true;
    $value = $_POST['searchField'];
    $query_search = "";


    $res_search = $mysql->query($query_search);
    while ($res = $res_search->fetch_assoc()) {
        echo $res['product_name'];
    }
}
$query_product = "SELECT *FROM product";
$query_cat = "SELECT *FROM category";
$query_brand = "SELECT *FROM brand";
$res_brand = $mysql->query($query_brand);
$res_cat = $mysql->query($query_cat);

if ($res_prod = $mysql->query($query_product)) : ?>

    <!DOCTYPE html>
    <html class="no-js" lang="zxx">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title>ShopGrids - Bootstrap 5 eCommerce HTML Template.</title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

        <!-- ========================= CSS here ========================= -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
        <link rel="stylesheet" href="assets/css/tiny-slider.css" />
        <link rel="stylesheet" href="assets/css/glightbox.min.css" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="./css/main.css" />
        <!-- <link rel="stylesheet" href="./bootstrap-5.1.3-dist/css/bootstrap.min.css"> -->
    </head>

    <body>
        <!-- Preloader -->
        <div class="preloader">
            <div class="preloader-inner">
                <div class="preloader-icon">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <!-- /End Preloader -->

        <!-- Start Header Area -->
        <header class="header navbar-area">
            <!-- Start Topbar -->
            <div class="topbar">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-4 col-12">
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="top-middle">
                                <ul class="useful-links">
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="about-us.html">About Us</a></li>
                                    <li><a href="contact.html">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="top-end" style="display: flex;">
                                <?php if (!empty($_COOKIE['login']) && $_COOKIE['login'] != '') : ?>
                                    <div class="user">
                                        <i class="lni lni-user mt-2"></i>
                                        Salom <?= $first_name . ' ' . $last_name ?>
                                    </div>
                                    <a href="edituser.php?id=<?= $id_client ?>" class="btn btn-primary">Edit</a>
                                    <form action="" method="POST">
                                        <input type="text" hidden name="exit_btn" value="<?= $_COOKIE['login'] ?>">
                                        <button type="submit" class="btn btn-danger" style="margin-left: 10%;">Chiqish</button>
                                    </form>
                                <?php else : ?>
                                    <ul class="user-login">
                                        <li>
                                            <a href="login.php" class="btn btn-primary">Login</a>
                                        </li>
                                        <li>
                                            <a href="register.php" class="btn btn-primary">Register</a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Topbar -->
            <!-- Start Header Middle -->
            <div class="header-middle">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-1 col-md-3 col-7">
                            <!-- Start Header Logo -->
                            <a class="navbar-brand" href="#">
                                <img src="assets/images/logo/logo.svg" alt="Logo">
                            </a>
                            <!-- End Header Logo -->
                        </div>
                        <div class="col-lg-2 col-md-7 d-xs-none">
                            <!-- Start Main Menu Search -->
                            <div class="main-menu-search">
                                <!-- navbar search start -->
                                <div class="navbar-search search-style-5">
                                    <div class="search-input">
                                        <input type="text" placeholder="Search">
                                    </div>
                                    <!-- <div class="search-btn">
                                        <button><i class="lni lni-search-alt"></i></button>
                                    </div> -->
                                </div>
                                <!-- navbar search Ends -->
                            </div>
                            <!-- End Main Menu Search -->
                        </div>
                        <div class="col-lg-1">
                            <h5 style="text-align: center;">Narxi:</h5>
                        </div>
                        <div class="col-lg-1">
                            <input type="number" min="1" placeholder="dan" class="form-control" name="form_price">
                        </div>
                        <div class="col-lg-1">
                            <input type="number" min="1" placeholder="gacha" class="form-control" name="form_price">
                        </div>
                        <div class="col-lg-1">
                            <h5 style="text-align: center;">Kategoriya</h5>
                        </div>
                        <div class="col-lg-1">
                            <select name="category" class="form-control">
                                <option value=""></option>
                                <?php while ($row = $res_cat->fetch_assoc()) : ?>
                                    <option value="<?= $row['id_category'] ?>"><?= $row['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <h5 style="text-align: center;">Brand</h5>
                        </div>
                        <div class="col-lg-1">
                            <select name="category" class="form-control">
                                <option value=""></option>
                                <?php while ($row = $res_brand->fetch_assoc()) : ?>
                                    <option value="<?= $row['id_brand'] ?>"><?= $row['brand_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        <div class="col-lg-1 col-md-2 col-5">
                            <div class="middle-right-area">
                                <div class="navbar-cart" style="margin-left: 40%;">
                                    <div class="cart-items">
                                        <a href="javascript:void(0)" class="main-btn">
                                            <i class="lni lni-cart"></i>
                                            <span class="total-items"><?= $prod_count ?></span>
                                        </a>
                                        <!-- Shopping Item -->
                                        <div class="shopping-item">
                                            <div class="dropdown-cart-header">
                                                <span><?= $prod_count ?> Items</span>
                                                <a href="cart.php">View Cart</a>
                                            </div>
                                        </div>
                                        <!--/ End Shopping Item -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Header Middle -->
            <!-- Start Header Bottom -->
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-6 col-12">
                        <div class="nav-inner">
                            <!-- Start Mega Category Menu -->
                            <div class="mega-category-menu">
                                <span class="cat-button"><i class="lni lni-menu"></i>All Categories</span>
                                <ul class="sub-category">
                                    <?php while ($row = $res_cat->fetch_assoc()) : ?>
                                        <li><a href="#"><?= $row['name'] ?></a></li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                            <!-- End Mega Category Menu -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Start Nav Social -->
                        <div class="nav-social">
                            <h5 class="title">Follow Us:</h5>
                            <ul>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-skype"></i></a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Nav Social -->
                    </div>
                </div>
            </div>
            <!-- End Header Bottom -->
        </header>
        <!-- End Header Area -->



        <!-- Start Trending Product Area -->
        <section class="trending-product section" style="margin-top: 12px;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h2>Do'kondagi mahsulotlar</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php while ($row = $res_prod->fetch_assoc()) : ?>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Start Single Product -->
                            <div class="single-product">
                                <div class="product-image">
                                    <img src="<?php $path = $row['photo'];
                                                $item = explode(';', $path);
                                                echo $item[0] ?>" alt="#">
                                    <div class="button">
                                        <a href="cart.php?id=<?= $row['id_product'] ?>" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <span class="category" style="text-align: center;">
                                        <?php
                                        $query_cat = "SELECT *FROM category WHERE id_category = {$row['id_category']};";
                                        $res = $mysql->query($query_cat);
                                        $res = $res->fetch_assoc();
                                        echo $res['name'];
                                        ?>
                                    </span>
                                    <h4 class="title"><?= $row['product_name'] ?></h4>
                                    <div class="price">
                                        <span>$<?= $row['price'] ?></span>
                                    </div>
                                    <a href="details.php?id=<?= $row['id_product'] ?>" class="btn btn-primary" style="margin-top: 5%; margin-left: 25%;">To'liq ma'lumot</a>
                                </div>
                            </div>
                            <!-- End Single Product -->
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            </div>
        </section>
        <!-- End Trending Product Area -->

        <!-- Start Footer Area -->
        <footer class="footer">
            <!-- Start Footer Middle -->
            <div class="footer-middle">
                <div class="container">
                    <div class="bottom-inner">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-12">
                                <!-- Single Widget -->
                                <div class="single-footer f-contact">
                                    <h3>Get In Touch With Us</h3>
                                    <p class="phone">Phone: +1 (900) 33 169 7720</p>
                                    <ul>
                                        <li><span>Monday-Friday: </span> 9.00 am - 8.00 pm</li>
                                        <li><span>Saturday: </span> 10.00 am - 6.00 pm</li>
                                    </ul>
                                    <p class="mail">
                                        <a href="mailto:support@shopgrids.com">support@shopgrids.com</a>
                                    </p>
                                </div>
                                <!-- End Single Widget -->
                            </div>
                            <div class="col-lg-3 col-md-6 col-12">
                                <!-- Single Widget -->
                                <div class="single-footer our-app">
                                    <h3>Our Mobile App</h3>
                                    <ul class="app-btn">
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="lni lni-apple"></i>
                                                <span class="small-title">Download on the</span>
                                                <span class="big-title">App Store</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="lni lni-play-store"></i>
                                                <span class="small-title">Download on the</span>
                                                <span class="big-title">Google Play</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End Single Widget -->
                            </div>
                            <div class="col-lg-3 col-md-6 col-12">
                                <!-- Single Widget -->
                                <div class="single-footer f-link">
                                    <h3>Information</h3>
                                    <ul>
                                        <li><a href="javascript:void(0)">About Us</a></li>
                                        <li><a href="javascript:void(0)">Contact Us</a></li>
                                        <li><a href="javascript:void(0)">Downloads</a></li>
                                        <li><a href="javascript:void(0)">Sitemap</a></li>
                                        <li><a href="javascript:void(0)">FAQs Page</a></li>
                                    </ul>
                                </div>
                                <!-- End Single Widget -->
                            </div>
                            <div class="col-lg-3 col-md-6 col-12">
                                <!-- Single Widget -->
                                <div class="single-footer f-link">
                                    <h3>Shop Departments</h3>
                                    <ul>
                                        <li><a href="javascript:void(0)">Computers & Accessories</a></li>
                                        <li><a href="javascript:void(0)">Smartphones & Tablets</a></li>
                                        <li><a href="javascript:void(0)">TV, Video & Audio</a></li>
                                        <li><a href="javascript:void(0)">Cameras, Photo & Video</a></li>
                                        <li><a href="javascript:void(0)">Headphones</a></li>
                                    </ul>
                                </div>
                                <!-- End Single Widget -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer Middle -->
            <!-- Start Footer Bottom -->
            <div class="footer-bottom">
                <div class="container">
                    <div class="inner-content">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-12">
                                <div class="payment-gateway">
                                    <span>We Accept:</span>
                                    <img src="assets/images/footer/credit-cards-footer.png" alt="#">
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="copyright">
                                    <p>Designed and Developed by<a href="#">GrayGrids</a></p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <ul class="socila">
                                    <li>
                                        <span>Follow Us On:</span>
                                    </li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-instagram"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-google"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer Bottom -->
        </footer>
        <!--/ End Footer Area -->

        <!-- ========================= scroll-top ========================= -->
        <a href="#" class="scroll-top">
            <i class="lni lni-chevron-up"></i>
        </a>

        <!-- ========================= JS here ========================= -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/tiny-slider.js"></script>
        <script src="assets/js/glightbox.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="./bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/extention/choices.js"></script>
        <script src="js/extention/flatpickr.js"></script>
        <script type="text/javascript">
            //========= Hero Slider 
            tns({
                container: '.hero-slider',
                slideBy: 'page',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 0,
                items: 1,
                nav: false,
                controls: true,
                controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
            });

            //======== Brand Slider
            tns({
                container: '.brands-logo-carousel',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 15,
                nav: false,
                controls: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    540: {
                        items: 3,
                    },
                    768: {
                        items: 5,
                    },
                    992: {
                        items: 6,
                    }
                }
            });
        </script>

    <?php endif; ?>