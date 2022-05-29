<?php

require 'connect.php';
if (isset($_GET['id'])) {
    $query_by_id = "SELECT *FROM client WHERE id_client = {$_GET['id']}";
    $res_query = $mysql->query($query_by_id);
    $res = $res_query->fetch_assoc();
}

require 'session.php';
$isSuccess = true;
$res_string = '';

if (
    isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username'])
    && isset($_POST['password']) && isset($_POST['re_password']) && isset($_POST['id_user'])
) {
    $id_user = $_POST['id_user'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    if (strlen($firstname) < 3) {
        $isSuccess = false;
        $res_string = "Ism uzunligi 3 tadan kam bo'lmasin!";
    } else if (strlen($lastname) < 5) {
        $isSuccess = false;
        $res_string = "Familiya uzunligi 5 tadan kam bo'lmasin!";
    } else if (hasUsername($username, $id_user)) {
        $isSuccess = false;
        $res_string = "Bunday usernameli user bor!";
    } else if (strlen($password) < 5) {
        $isSuccess = false;
        $res_string = "Parol uzunligi 5 tadan kam bo'lmasin!";
    } else if ($password != $re_password) {
        $isSuccess = false;
        $res_string = 'Parollar mos kelmadi!';
    }
    if ($isSuccess) {
        if (updateClient($firstname, $lastname, $username, $password, $id_user)) {
            $res_string = "Foydalanuvchi ma'lumotlari o'zgartirildi!";
            addUsersToSession();
            setcookie('login', getUserIdByUsername($username), time() + 3600, '/');
        } else {
            $res_string = "Xatolik!!!";
        }
    }
}

function getUserIdByUsername($username)
{
    require 'connect.php';
    $query = "SELECT id_client FROM client WHERE username = '{$username}'";
    $res_query = $mysql->query($query);
    $res = $res_query->fetch_assoc();
    return $res['id_client'];
}

function updateClient($firstname, $lastname, $username, $password, $id_user)
{

    require 'connect.php';
    $firstname = $mysql->real_escape_string($firstname);
    $lastname = $mysql->real_escape_string($lastname);
    $password = $mysql->real_escape_string($password);
    $username = $mysql->real_escape_string($username);
    $pass = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE client SET first_name = '{$firstname}',last_name = '{$lastname}'
                ,username = '{$username}',password = '{$pass}' WHERE id_client = {$id_user}";

    return $mysql->query($query);
}

function hasUsername($username, $id_user)
{
    $hasUser = false;
    require 'connect.php';

    $query = "SELECT username FROM client WHERE id_client != {$id_user}";
    $query_res = $mysql->query($query);
    while ($row = $query_res->fetch_assoc()) {
        if ($row['username'] == $username) {
            $hasUser = true;
            break;
        }
    }
    return $hasUser;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
                    <div class="col-8 offset-2">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Change account!</h1>
                            </div>
                            <form class="user" action="" method="POST">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" placeholder="Ismi" name="firstname" value="<?= $res['first_name'] ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" placeholder="Familiyasi" name="lastname" value="<?= $res['last_name'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" placeholder="Username" name="username" value="<?= $res['username'] ?>">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" placeholder="Parol" name="password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" placeholder="Parolni qayta kiriting" name="re_password">
                                    </div>
                                    <input type="number" hidden name="id_user" value="<?= $_GET['id'] ?>">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Edit account</button>
                                <hr>
                            </form>
                            <hr>
                            <h3><?= $res_string; ?></h3>
                            <div class="text-center">
                                <a href="index.php" class="btn btn-primary">Bosh sahifaga o'tish</a><br>
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>