<?php

    require 'connect.php';
    $query = "DELETE FROM product WHERE id_product = {$_GET['id']}";
    if($mysql->query($query)){
        require 'admin.php';
    }
