<?php
    $pass = "AjharAnjum2427";
    $hashed = password_hash($pass, PASSWORD_DEFAULT);
    echo $hashed;
?>