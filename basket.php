<?php

// session_destroy();
session_start();
$session_name = 'cart';
$session_count = 'count';

if (empty($_SESSION[$session_name])) {
    $_SESSION[$session_name] = $_GET['id'];
    $_SESSION[$session_count] = 1;
} else {
    $items = explode(',', $_SESSION[$session_name]);
    $itemExist = false;
    foreach ($items as $item) {
        if ($item == $_GET['id']) {
            $itemExist = true;
        }
    }
    if (!$itemExist) {
        $_SESSION[$session_name] = $_SESSION[$session_name] . ',' . $_GET['id'];
        $_SESSION[$session_count]++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
    <style>
        .img-fluid {
            width: 100px;
            height: 120px;
        }
    </style>
</head>

<body>
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <h3 class="display-5 mb-2 text-center">Savatdagi mahsulotlar</h3>
                    <p class="mb-5 text-center">
                        <i class="text-info font-weight-bold">3</i> ta product
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
                            <form action="" method="POST">
                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-md-3 text-left">
                                                <img src="./images/8H4Y1PvwwZntgmdBwLliRimzAlSRcrQK0RUjX6FElNWxvu4S9NYJJTcLDhDS.jpeg" alt="" class="img-fluid">
                                            </div>
                                            <div class="col-md-9 text-left mt-sm-2">
                                                <h4>Product Name</h4>
                                                <p class="font-weight-light">Brand &amp; Name</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Price" class="middle_section">$49.00</td>
                                    <td data-th="Quantity">
                                        <input type="number" class="form-control form-control-lg text-center" min="1" value="1">
                                    </td>
                                    <td class="actions" data-th="">
                                        <div class="text-right">
                                            <button class="btn btn-white border-secondary bg-white btn-md mb-2" style="margin-left: 40%;" name="delete" value="delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    <div class="float-right text-right">
                        <h4>Subtotal:</h4>
                        <h1>$99.00</h1>
                    </div>
                </div>
            </div>
            <div class="row mt-4 d-flex align-items-center">
                <div class="col-sm-6 order-md-2 text-right">
                    <a href="catalog.html" class="btn btn-primary mb-4 btn-lg pl-5 pr-5">Checkout</a>
                </div>
                <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                    <a href="catalog.html">
                        <i class="fas fa-arrow-left mr-2"></i> Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>

    <script src="./bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>