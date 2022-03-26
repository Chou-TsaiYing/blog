<?php
    session_start();
    //reset SEESION
    session_destroy();
    header("refresh:5 ; url=index.php")
?>

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link href="/css/logout_style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
      <div class="text">
        <h1>You will be signed out after five seconds.</h1>
        <a herf=index.php >If you are not successfully logged out, please click here.</a>
     </div>
    </body>
</html>