<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<?php
    
    session_start();
    //header('location:index.php');
    include 'dbconfig.php';    

    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    
    $s = "select * FROM accounts where email = '$email'";
    $result = mysqli_query($conn, $s);
    $num = mysqli_num_rows($result);

    if($num > 0 && $password!=NULL) {
        echo '
        <script type="text/javascript">

        $(document).ready(function(){

        Swal.fire({
            icon: "error",
            title: "Duplicate email address!",
            text: "The email address already exists.",
            showConfirmButton: true,
            }).then(function (result) {
                window.location.href = "register.html";
            }); 
        });

        </script>
        ';
    }
    else if($name == NULL || $password == NULL || $email == NULL){
        echo '
        <script type="text/javascript">

        $(document).ready(function(){

        Swal.fire({
            icon: "error",
            title: "Registration errors!",
            text: "Your email,username or password and cannot be empty.",
            showConfirmButton: true,
            }).then(function (result) {
                window.location.href = "register.html";
            }); 
        });

        </script>
        ';
    }
    else if(strcmp($password, $confirm_password)!=0){
        echo '
        <script type="text/javascript">

        $(document).ready(function(){

        Swal.fire({
            icon: "error",
            title: "Registration errors!",
            text: "Password and confirm password fields were not matched.",
            showConfirmButton: true,
            }).then(function (result) {
                window.location.href = "register.html";
            }); 
        });

        </script>
        ';
    }
    else{
        
        $s = "select * FROM accounts";
        $result = mysqli_query($conn, $s);
        $num = mysqli_num_rows($result);
        $num = $num + 1;
        $reg = "insert into accounts(userid,email,username,password) values ('$num','$email','$name','".md5($password)."')";
        mysqli_query($conn, $reg);
        echo '
        <script type="text/javascript">

        $(document).ready(function(){

        Swal.fire({
            icon: "success",
            title: "Regist Success!",
            text: "Please login to gain access to blog.",
            showConfirmButton: true,
            }).then(function (result) {
                window.location.href = "index.php";
            }); 
        });

        </script>
        ';
    }


?>