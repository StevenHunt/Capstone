<?php
    $db_conx = mysqli_connect("localhost", "uname", "password", "test");

    if (mysqli_connect_errno()) {
        echo mysqli_connect_error();
        exit();
    }
?>
