<html>
    <head>
        <title>article</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/css/index_style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar navbar-dark bg-white border-bottom shadow-sm rounded">
            <h4 class="my-0 mr-md-auto font-weight-normal">Article Page</h4>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Artical</a>
                </li>
                <?php
                
                    session_start();
                    if(isset($_SESSION['email'])){
                        include 'dbconfig.php';
                        $email = $_SESSION['email'];
                        $s = "select userid FROM accounts where email = '$email'";
                        $result = mysqli_query($conn, $s);
                        $row = mysqli_fetch_array($result);
                        $userid = $row['userid'];
                        echo'
                        <li class="nav-item">
                        <a class="nav-link" href="profile.php?userid='.$userid.'">Main page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                        ';
                    }
                    else{
                        echo'
                        <li class="nav-item">
                        <a class="nav-link" href="login.html">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.html">Register</a>
                        </li>
                        ';
                    }
                ?>
            </ul>
        </nav>
        <div class="container">
            <div class="card border-bottom shadow-sm rounded" style="width: 100%; margin-top: 50px;">
                <div class="card-body">
                    <h5 style=" font-family: Comic Sans MS, Comic Sans, cursive; color: #717D7E;">Articles</h5>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="search_text" id="search_text" placeholder="Search" class="form-control"/>
                    </div>
                </div>
                <br/>
                <table class="table table-hover search_table" style="table-layout:fixed;">
                    <thead>
                        <tr>
                            <th>Author</th>
                            <th>Title</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody id="result">
                    </toby>
                </table>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
$(document).ready(function(){
    load_article();

    function load_article(query){
        $.ajax({
            url: "search_article.php",
            method: "POST",
            dataType: "json",
            data: {
                query: query
            },
            success: function(data){
                console.log(data);
                $('#result').html('');
                show_table(data);
            }
        });
    }
    function show_table(data){
        var num = data.length;
        console.log(num);
        for(var i=0; i<num; i++){
           $('#result').append('<tr><td>'+ data[i].username +
                             '</td><td><a href="profile_article.php?artid=' + data[i].artid + '">'+ data[i].title +
                             '</a></td><td>'+ data[i].time +'</td></tr>');
        }
    }
    $('#search_text').keyup(function(){
        var search = $(this).val();
        if(search != ''){
            load_article(search);
        }
        else{
            load_article();
        }
    });

});
</script>