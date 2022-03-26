<?php
    $conn = mysqli_init();
        if(!$conn){
            die("mysqli_init failed");
        }
        if(!mysqli_real_connect($conn, "localhost","root","root","hw4_db","8890")){
            die("Connect Error: ".mysqli_connect_error());
        }
?>