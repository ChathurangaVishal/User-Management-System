<?php
    $connection = mysqli_connect('localhost', 'root', '', 'U_M_S');

    if(mysqli_connect_errno()){
        die('Database connection faild' . mysqli_connect_error());
    }else{
        //echo "connection successful";
    }