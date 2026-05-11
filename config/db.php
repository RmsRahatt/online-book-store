<?php

    $host       = "127.0.0.1";
    $dbuser     = "root";
    $dbpassword = "";
    $dbname     = "book_store";

    function getConnection(){
        global $host, $dbuser, $dbpassword, $dbname;
        $con = mysqli_connect($host, $dbuser, $dbpassword, $dbname);
        if(!$con){
            die("Connection failed: " . mysqli_connect_error());
        }
        return $con;
    }

?>