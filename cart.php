<?php

require 'connect.php';

session_start();
// session_destroy();
#die();
$prod_count = 0;
$data = [];
$id_client = 0;
$first_name = '';
$last_name = '';
$total_sum = 0;
$item = 0;
$abc = 0;
$prices = [];

if (!empty($_COOKIE['login'])) {
    $id_client = $_COOKIE['login'];
    $first_name = $_SESSION['user'][$id_client]['firstname'];
    $last_name = $_SESSION['user'][$id_client]['lastname'];
}

if (isset($_GET['id']) && !isset($_POST['delete'])) {
    if (empty($_SESSION['user'][$id_client]['products'])) {
        $_SESSION['user'][$id_client]['products'] = array();
        $_SESSION['user'][$id_client]['products'][] = $_GET['id'];
        $_SESSION['user'][$id_client]['product_count'] = 1;
    } else {
        $itemExist = false;
        foreach ($_SESSION['user'][$id_client]['products'] as $value) {
            if ($value == $_GET['id']) {
                $itemExist = true;
                break;
            }
        }
        if (!$itemExist) {
            $_SESSION['user'][$id_client]['products'][] = $_GET['id'];
            $_SESSION['user'][$id_client]['product_count']++;
        }
    }
    $total_sum = TotalSum();
    $prod_count = $_SESSION['user'][$id_client]['product_count'];
    $data = $_SESSION['user'][$id_client]['products'];
} else if (!empty($_SESSION['user'][$id_client]['products']) && !isset($_POST['delete'])) {
    $prod_count = $_SESSION['user'][$id_client]['product_count'];
    $data = $_SESSION['user'][$id_client]['products'];
    $total_sum = TotalSum();
}

if (isset($_POST['delete'])) {
    $item = array_search($_POST['delete'], $_SESSION['user'][$id_client]['products']);
    $count = $_SESSION['user'][$id_client]['product_count'];
    unset($_SESSION['user'][$id_client]['products'][$item]);
    if ($count > 0) {
        $_SESSION['user'][$id_client]['product_count']--;
    }
    $prod_count = $_SESSION['user'][$id_client]['product_count'];
    $data = $_SESSION['user'][$id_client]['products'];
    $total_sum = TotalSum();
}

if (isset($_POST['exit_btn'])) {
    setcookie('login', $_POST['exit_btn'], time() - 3600, '/');
    unset($_COOKIE['login']);
}

function TotalSum()
{
    require 'connect.php';
    $total = 0;
    $products = $_SESSION['user'][$_COOKIE['login']]['products'];
    foreach ($products as $product) {
        $query = "SELECT price FROM product WHERE id_product = {$product}";
        $query_res = $mysql->query($query);
        $res = $query_res->fetch_assoc();
        $price = floatval($res['price']);
        $total += $price;
    }
    return $total;
}

$query_cat = "SELECT *FROM category";
$res_cat = $mysql->query($query_cat);

?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Single Product - ShopGrids Bootstrap 5 eCommerce HTML Template.</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .btn_action {
            margin-top: 20%;
        }
    </style>

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
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <!-- Start Header Logo -->
                        <a class="navbar-brand" href="index.php">
                            <img src="assets/images/logo/logo.svg" alt="Logo">
                        </a>
                        <!-- End Header Logo -->
                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">
                        <!-- Start Main Menu Search -->
                        <div class="main-menu-search">
                            <!-- navbar search start -->
                            <div class="navbar-search search-style-5">
                                <div class="search-input">
                                    <input type="text" placeholder="Search">
                                </div>
                                <div class="search-btn">
                                    <button><i class="lni lni-search-alt"></i></button>
                                </div>
                            </div>
                            <!-- navbar search Ends -->
                        </div>
                        <!-- End Main Menu Search -->
                    </div>
                    <div class="col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area">
                            <div class="nav-hotline">

                            </div>
                            <div class="navbar-cart">
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
        <!-- Start Header Bottom -->
    </header>
    <!-- End Header Area -->
    <!-- Start Main Section -->
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <h3 class="display-5 mb-2 text-center">Savatdagi mahsulotlar</h3>
                    <p class="mb-5 text-center">
                        <i class="text-info font-weight-bold"><?= $prod_count ?></i> ta product
                    </p>
                    <table id="shoppingCart" class="table table-condensed table-responsive">
                        <thead>
                            <tr>
                                <th style="width:60%">Product</th>
                                <th style="width:12%">Narxi</th>
                                <th style="width:10%">Soni</th>
                                <th style="width:16%">Savatdan olib tashlash</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $item) {
                                $query = "SELECT *FROM product WHERE id_product = {$item}";
                                $query_res = $mysql->query($query);
                                $res = $query_res->fetch_assoc();
                                $paths = explode(';', $res['photo']);
                                $path = $paths[0];

                                $query_brand = "SELECT brand_name FROM brand WHERE id_brand = {$res['id_brand']}";
                                $brand = $mysql->query($query_brand);
                                $res_brand = $brand->fetch_assoc();
                                $prices[] = $res['price'];

                                echo "<form action='cart.php' method='POST'>";
                                echo '<tr>';
                                echo    "<td data-th='Product'>";
                                echo        "<div class='row'>";
                                echo            "<div class='col-md-3 text-left'>";
                                echo                "<img src='{$path}' alt='' class='img-fluid'>";
                                echo            '</div>';
                                echo            "<div class='col-md-9 text-left mt-sm-2'>";
                                echo                "<h4 class='mb-2'>Mahsulot nomi</h4>";
                                echo                "<h5 class='mb-1'>{$res['product_name']}</h5>";
                                echo                "<p class='font-weight-light'>Brand nomi</p>";
                                echo                "<p class='font-weight-light'>{$res_brand['brand_name']}</p>";
                                echo            '</div>';
                                echo        '</div>';
                                echo    '</td>';
                                echo    "<td data-th='Price' name='price' class='middle_section'>{$res['price']}$</td>";
                                echo    "<td data-th='Quantity'>";
                                echo        "<input type='number' class='form-control form-control-lg text-center' min='1' value='1' name='count' id='count_product' onclick='Evaluate({$item},value)'>";
                                echo    '</td>';
                                echo    "<td class='actions' data-th=''>";
                                echo        "<div class='text-right'>";
                                echo            "<button class='btn btn-white border-secondary bg-white btn-md mb-2' style='margin-left: 40%;' name='delete' value='{$item}'>";
                                echo                "<i class='fas fa-trash'></i>";
                                echo            '</button>';
                                echo        '</div>';
                                echo    '</td>';
                                echo '</tr>';
                                echo '</form>';
                            }
                            ?>

                        </tbody>
                    </table>
                    <div class="float-right text-right">
                        <h4>Umumiy narx:</h4>
                        <h1 id="total_sum"><?= $total_sum ?>$</h1>
                    </div>
                </div>
            </div>
            <div class="row mt-4 d-flex align-items-center">
                <div class="col-sm-6 order-md-2 text-right">
                    <a href="order.php" class="btn btn-primary mb-4 btn-lg pl-5 pr-5">Buyurtma qilish</a>
                </div>
                <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                    <a href="catalog.html">
                        <i class="fas fa-arrow-left mr-2"></i> Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Section -->
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
    <script type="text/javascript">
        const current = document.getElementById("current");
        const opacity = 0.6;
        const imgs = document.querySelectorAll(".img");
        imgs.forEach(img => {
            img.addEventListener("click", (e) => {
                //reset opacity
                imgs.forEach(img => {
                    img.style.opacity = 1;
                });
                current.src = e.target.src;
                //adding class 
                //current.classList.add("fade-in");
                //opacity
                e.target.style.opacity = opacity;
            });
        });
    </script>
    <script>
        let products = <?php echo json_encode($data) ?>;
        let prices = <?php echo json_encode($prices) ?>;
        let counts = products.length;
        let element = new Map();
        let price = new Map();

        for (let i = 0; i < counts; i++) {
            element.set(products[i], 1);
            price.set(products[i], prices[i]);
        }

        function Evaluate(prod_id, count) {
            let total_sum = 0;
            let total = document.getElementById('total_sum');
            for (let [key, value] of element) {
                if (key == prod_id) {
                    element.set(key, count);
                }
                let narx = price.get(key);
                let soni = element.get(key);
                total_sum += narx * soni;
            }
            total.innerText = total_sum + "$";
        }
    </script>
</body>

</html>