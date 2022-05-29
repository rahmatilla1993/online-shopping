<?php

require 'connect.php';

$query_cat = "SELECT *FROM category";
$query_brand = "SELECT *FROM brand";
$query_prod_id = "SELECT *FROM product WHERE id_product = {$_GET['id']}";

$res_cat = $mysql->query($query_cat);
$res_brand = $mysql->query($query_brand);
$res_id = $mysql->query($query_prod_id);

$result_query = false;
$result_string = '';
$done = true;
$isPressed = false;

if (isset($_POST['exit_btn'])) {
    setcookie('login', $_POST['exit_btn'], time() - 3600, '/');
    unset($_COOKIE['login']);
    header('location:index.php');
}


$res = $res_id->fetch_assoc();

if (isset($_POST['product_name'])) {
    $isPressed = true;
    $prod_name = $_POST['product_name'];
    $prod_category = $_POST['category'];
    $prod_brand = $_POST['brand'];
    $prod_count = $_POST['prod_count'];
    $price = $_POST['price'];
    $description = $_POST['product_description'];
    $date_delivery = $_POST['date_delivery'];
    $date_validate = $_POST['date_validate'];
    $isActive = $_POST['status'];
    $paths = '';
    $count = 0;

    if (strlen($prod_name) == 0) {
        $done = false;
        $result_string = 'Product nomi kiritilmadi!';
    } else if ($prod_count > 1000) {
        $done = false;
        $result_string = "Mahsulotlar soni mavjud qiymatdan oshib ketti!";
    } else if ($price > 10000) {
        $done = false;
        $result_string = 'Juda yuqori narx!';
    } else if (strlen($date_delivery) == 0) {
        $done = false;
        $result_string = 'Ishlab chiqarish sanasi kiritilmadi!';
    } else if (strlen($date_validate) == 0) {
        $done = false;
        $result_string = 'Yaroqlilik sanasi kiritilmadi!';
    } else if ($isActive == 'no') {
        $done = false;
        $result_string = 'Mahsulot holati belgilanmadi!';
    }

    if ($done) {

        foreach ($_FILES['files']['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['files']['tmp_name'][$key];
                $name = $_FILES['files']['name'][$key];
                $path = "images\\{$name}";
                $path = $mysql->real_escape_string($path);
                $paths .= $path . ';';
                move_uploaded_file($tmp_name, $path);
                $count++;
            }
        }
        if ($count != 4) {
            $done = false;
            $result_string = "Product rasmlari 4 ta bo'lishi kerak";
        } else {

            $query = "UPDATE product SET product_name = '{$prod_name}',date_of_delivery = '{$date_delivery}',validate_date = '{$date_validate}',
                        status = $isActive,price = $price,prod_count = $prod_count,description = '$description',
                        id_category = $prod_category,id_brand = '$prod_brand' WHERE id_product = {$_GET['id']}";
            if ($mysql->query($query)) {
                $result_query = true;
                $result_string = "Ma'lumotlar yangilandi!";
            } else {
                $result_string = 'Error';
            }
            $result_string = "Ma'lumotlar yangilandi!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Bosh sahifa</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrator</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12" style="margin-left: 23%;">
                            <h3 style="margin-left: 20%;">Mahsulotni yangilash</h3>
                            <div class="col-md-6">
                                <?php
                                if ($isPressed) {
                                    if ($result_query) {
                                        echo "<div class='alert alert-success'>{$result_string}</div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>{$result_string}</div>";
                                    }
                                }
                                ?>
                            </div>
                            <form class="form-horizontal" enctype="multipart/form-data" action="" method="POST">
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="product_name">NOMI</label>
                                        <div class="col-md-6">
                                            <input id="product_name" name="product_name" class="form-control input-md" required type="text" value="<?= $res['product_name'] ?>">
                                        </div>
                                    </div>

                                    <!-- Select Basic -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="category">KATEGORIYASI</label>
                                        <div class="col-md-6">
                                            <select id="product_categorie" name="category" class="form-control">
                                                <?php while ($row = $res_cat->fetch_assoc()) {
                                                    if ($row['id_category'] == $res['id_category']) {
                                                        echo "<option value={$row['id_category']} selected>{$row['name']}</option>";
                                                    } else {
                                                        echo "<option value={$row['id_category']}>{$row['name']}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Select Basic -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="brand">BRAND</label>
                                        <div class="col-md-6">
                                            <select id="product_categorie" name="brand" class="form-control">
                                                <?php while ($row = $res_brand->fetch_assoc())
                                                    if ($row['id_brand'] == $res['id_brand']) {
                                                        echo "<option value={$row['id_brand']} selected>{$row['brand_name']}</option>";
                                                    } else {
                                                        echo "<option value={$row['id_brand']}>{$row['brand_name']}</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="prod_count">MAHSULOT SONI</label>
                                        <div class="col-md-6">
                                            <input id="available_quantity" name="prod_count" class="form-control input-md" required type="number" min="1" value="<?= $res['prod_count'] ?>">
                                        </div>
                                    </div>

                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="price">MAHSULOT NARXI</label>
                                        <div class="col-md-4">
                                            <input id="available_quantity" name="price" class="form-control input-md" required type="number" min="1" value="<?= $res['price'] ?>">
                                        </div>
                                    </div>

                                    <!-- Textarea -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="editor">MAHSULOT XARAKTERISTIKASI</label>
                                        <div class="col-md-6">
                                            <label for="formFile" class="mb-2">Full description</label><a href="javascript: demo()"> add template</a>
                                            <textarea class="form-control" id="editor" name="product_description"><?= $res['description'] ?></textarea>
                                        </div>
                                    </div>

                                    <!-- Search input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="date_delivery">ISHLAB CHIQARILGAN SANA</label>
                                        <div class="col-md-6">
                                            <input id="tutorial" name="date_delivery" class="form-control input-md" required type="date" value="<?= $res['date_of_delivery'] ?>">
                                        </div>
                                    </div>

                                    <!-- Search input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="date_validate">YAROQLILIK MUDDATI</label>
                                        <div class="col-md-6">
                                            <input id="tutorial_fr" name="date_validate" class="form-control input-md" required type="date" value="<?= $res['validate_date'] ?>">
                                        </div>
                                    </div>

                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="enable_display">MAHSULOT RASMLARI</label>
                                        <div class="col-md-6">
                                            <input id="enable_display" name="files[]" class="form-control input-md" required type="file" multiple>
                                        </div>
                                    </div>

                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="comment">MAHSULOT HOLATI</label>
                                        <div class="active" style="margin-left: 5%;">
                                            <input name="status" class="form-check-input" id="active" required type="radio" checked value="true">
                                            <label for="active">Active</label>
                                        </div>
                                        <div class="no-active" style="margin-left: 5%;">
                                            <input name="status" class="form-check-input" id="noactive" required type="radio" value="false">
                                            <label for="noactive">NoActive</label>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" style="margin-left: 20%;">Qo'shish</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Joriy sessiyani yakunlamoqchimisiz?</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <form action="" method="POST">
                                    <input type="text" hidden name="exit_btn" value="<?= $_COOKIE['login'] ?>">
                                    <button type="submit" class="btn btn-danger">Chiqish</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <script src="./bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="./ckeditor5/build/ckeditor.js"></script>
    <script src="./bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-ea /jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script>
        const myeditor = ClassicEditor
            .create(document.querySelector('#editor'), {

                licenseKey: '',

            })
            .then(editor => {
                window.editor = editor;

            })
            .catch(error => {
                console.error('Oops, something went wrong!');
                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                console.warn('Build id: ahxvjmm3d1f9-38ma0amc37ly');
                console.error(error);
            });

        function demo() {

            let template = "";
            template = template + "<p><b>Brand:</b>&nbsp;</p>";
            template = template + "<p><b>Color:</b>&nbsp;</p>";
            template = template + "<p><b>Dimension:</b>&nbsp;</p>";
            template = template + "<p><b>Weight:</b>&nbsp;</p>";
            template = template + "<p><b>Bluetooth:</b>&nbsp;</p>";
            template = template + "<p><b>USB:</b>&nbsp;</p>";
            template = template + "<p><b>NFC:</b>&nbsp;</p>";
            template = template + "<p><b>Processor:</b>&nbsp;</p>";
            editor.data.set(template);

        }
    </script>
</body>

</html>