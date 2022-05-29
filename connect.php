<?php

$mysql = new mysqli('localhost', 'root', '', 'online-shopping');
if ($mysql->connect_errno) {
    echo "Connection failed: {$mysql->connect_errno}";
    exit();
}
