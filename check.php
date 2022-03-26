<head>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
</head>
<?php

    session_start();
    //header('location:index.php');
    include 'dbconfig.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $s = "select * FROM accounts where email = '$email' && password = '".md5($password)."'";
    $result = mysqli_query($conn, $s);
    $num = mysqli_num_rows($result);

    if($num == 1){
        $s = "select userid FROM accounts where email = '$email'";
        $result = mysqli_query($conn, $s);
        $row = mysqli_fetch_array($result);
        $_SESSION['email'] = $email;
        header('location:profile.php?userid='. $row['userid']);
    }
    else{
        echo '
        <script type="text/javascript">

        $(document).ready(function(){

        Swal.fire({
            icon: "error",
            title: "Failed Login!",
            showConfirmButton: true,
            }).then(function (result) {
                window.location.href = "login.html";
            }); 
        });

        </script>
        ';
    }
    
?>