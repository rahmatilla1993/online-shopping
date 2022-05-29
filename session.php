<?php

require 'connect.php';
session_start();

if (empty($_SESSION['user'])) {
    $_SESSION['user'] = array();
    addUsersToSession();
}
function addUsersToSession()
{
    require 'connect.php';
    $query = "SELECT *FROM client";
    $query_res = $mysql->query($query);
    while ($row = $query_res->fetch_assoc()) {
        $_SESSION['user'][$row['id_client']] = array();
        $_SESSION['user'][$row['id_client']]['firstname'] = $row['first_name'];
        $_SESSION['user'][$row['id_client']]['lastname'] = $row['last_name'];
        $_SESSION['user'][$row['id_client']]['product_count'] = 0;
    }
}

// session_destroy();

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
