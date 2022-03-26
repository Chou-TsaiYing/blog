<?php
    session_start();
    include 'dbconfig.php';
    $artid = $_GET['artid'];
    //echo $artid;

    //get userid
    $s = " SELECT * FROM articles WHERE artid = '$artid'";
    $result = mysqli_query($conn, $s);
    $row = mysqli_fetch_array($result);
    $userid = $row['userid'];
    //echo $userid;

    //get username
    $search_name = "SELECT * FROM accounts WHERE userid = '$userid'";
    $output = mysqli_query($conn, $search_name);
    $output_row =  mysqli_fetch_array($output);
    $profile_user = $output_row['username'];

    $email = $_SESSION['email'];
    $s = "SELECT * FROM accounts WHERE email = '$email'";
    $result = mysqli_query($conn, $s);
    $row = mysqli_fetch_array($result);
    $current_user = $row['username'];
    $current_userid = $row['userid'];
    //echo $current_user;

?>
<html>
    <head>
        <title>main page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/css/profile_style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script type="text/javascript" src="/js/profile_article_js.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://kit.fontawesome.com/1adb36c0ef.js" crossorigin="anonymous"></script>
    </head>
    <body>
      <div class = "container-fluid" id="main-page">
        <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm rounded">
            <h4 class="my-0 mr-md-auto font-weight-normal">Main Page</h4>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Artical</a>
                </li>
                <?php
                    if(isset($current_user))
                        echo'<li class="nav-item">
                                <a class="nav-link" href="logout.php">logout</a>
                            </li>';
                ?>
            </ul>
        </nav>
        <div class = "row gutters-sm " style="margin-top: 15px;">
            <div class = "col-md-4 col-sm-4">
                <div class = "card shadow-sm rounded" style="max-width: 500px;">
                    <div class = "card-body user-card">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="/image/user.jpg" alt="Admin" class="rounded-circle" width="150">
                            <h4><a href="profile.php?userid=<?php echo $userid; ?>"><?php echo $profile_user; ?></a></h4>
                            <div id="article_modal" class="modal fade artical-modal-lg" tabindex="-1" role="dialog" aria-labelledby="Modal-postLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="Modal-postLabel">Post</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="post_form" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <p class="text-left font-weight-bold modal-label">Title</p>
                                                    <input type="text" class="form-control" name="title" id="title">
                                                    <input type="hidden" class="form-control" name="userid" id="userid" value="<?php echo $userid ?>">  
                                                </div>
                                                <div class="form-group">
                                                    <p class="text-left font-weight-bold modal-label">Cotent</p>
                                                    <textarea class="form-control" name="text" id="text" style="height:500px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                    <button type="button" class="btn" data-dismiss="modal" style="background-color: #717D7E; color:white; ">Close</button>
                                                    <button type="submit" name="submit" id="submit" class="btn" data-dismiss="modal" style="background-color: #7EB1B1; color:white;">Create</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "card mt-3" style="max-width: 500px; background-color: #7EB1B1;">
                    <div class="card-body text-center information-header">
                        <h5 class="card-title">Information</h5>
                    </div>
                </div>
                <div class="card" style="max-width:500px;">
                     <div class="card-body text-center information-body">
                        <?php
                             $search = "SELECT * FROM articles WHERE userid = '$userid'";
                             $update = mysqli_query($conn, $search);
                             $article_num = mysqli_num_rows($update);
                             echo'  
                                 <h5>Number of articles: '.$article_num.'</h5>
                             ';
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="card shadow-sm rounded ">
                    <div class="card-header header" style="background-color: #7EB1B1; width:120px;">Articles</div>
                </div>
                <div class ="card shadow-sm rounded">
                    <div class="card-body" id="post_area">
                        <?php
                             $search = "SELECT * FROM articles WHERE artid = '$artid'";
                             $show = mysqli_query($conn, $search);
                             $row = mysqli_fetch_array($show);
                             $title = $row['title'];
                             $text = $row ['text'];
                             $artid = $row['artid'];
                             $time = substr($row['time'],0,19);

                             $search_comment = "SELECT * FROM comments WHERE artid = '$artid'";
                             $insert = mysqli_query($conn, $search_comment);
                             $comment_num = mysqli_num_rows($insert);

                             $search_likes = "SELECT * FROM likes WHERE userid = '$current_userid' AND artid = '$artid'";
                             $like = mysqli_query($conn, $search_likes);
                             $like_num = mysqli_num_rows($like);

                             $search_likes = "SELECT * FROM likes WHERE artid = '$artid'";
                             $like = mysqli_query($conn, $search_likes);
                             $article_likenum = mysqli_num_rows($like);
                             //echo $like_num;
                             if($like_num == 0){
                                 $str_like = "like";
                             }
                             else{
                                 $str_like = "unlike";
                            }
                             echo '
                                 <div class="container" id="container_'.$artid.'">
                                     <div class="container">
                                         <div class="row justify content around">
                                             <div class="col 8-offset">
                                                 <h5 id="title_'.$artid.'">'.$title.'</h5>
                                             </div>';
                              if(strcmp($current_user,$profile_user)==0){ 

                                     echo '   <button class="btn far fa-edit btn-post" id="edit_'.$artid.'" data-toggle="modal" data-target=".edit-modal-lg"style="background-color: white;" onClick=edit_article('.$artid.')></button>
                                              <button class="btn far fa-trash-alt" id="delete_'.$artid.'" style="background-color: white;" onClick=remove_article('.$artid.')></button>
                                          ';
                             }
                             echo        '</div>
                                     </div>
                                     </br>
                                     <p style="font-size:14px; margin-left:20px;">'.$time.'</p>
                                     <hr>
                                     <p id="text_'.$artid.'"style="font-size:17px; margin-left:20px;">'.$text.'</p>
                                     <hr>
                                     <div class="row">
                                        <div class="col 8-offset">';
                                        if(strcmp($str_like,"like")==0){
                                            echo '<button id="like_'.$artid.'" class="btn btn-outline-info"  onClick=add_like("'.$artid.'","'.$str_like.'","'.$current_user.'") style="margin-left:20px;" ><i class="far fa-thumbs-up"></i> Like</button>';
                                        }
                                        else if(strcmp($str_like,"unlike")==0){
                                            echo '<button id="like_'.$artid.'" class="btn btn-outline-info"  onClick=add_like("'.$artid.'","'.$str_like.'","'.$current_user.'") style="margin-left:20px;" ><i class="fas fa-thumbs-up"></i> Like</button>';
                                        }
                            echo       '</div>
                                         <span id="likenum_'.$artid.'">'.$article_likenum.'</span> - likes <span> <span id="commentnum_'.$artid.'" style="margin-left:10px;">'.$comment_num.'</span> - comments<span>
                                     </div>
                                     <div class="container bg-light">
                                         </br>';
                                     if(isset($_SESSION['email'])){
                                         echo'  <div class="comment">
                                                     <input type="text" id="comment_'.$current_user.'_'.$artid.'" class="form-control" placeholder="Type a comment"></input>
                                                     <input type="button" class="btn comment_submit" id="comment_submit"  value ="Comment" onClick = comment("'.$artid.'","'.$current_user.'") style="color:#7EB1B1; margin-top:10px;"></input>
                                                </div>';
                                     }
                                 echo    '<hr>
                                         <div id = "'.$artid.'_comment">';
                             while($rowrow = mysqli_fetch_array($insert)){
                                     $comment_time = substr($rowrow['time'],0,19);
                                     $comment = $rowrow['comment'];
                                     $comment_userid = $rowrow['userid'];

                                     $output = "SELECT * FROM accounts WHERE userid = '$comment_userid'";
                                     $result = mysqli_query($conn, $output);
                                     $get = mysqli_fetch_array($result);
                                     $name = $get['username'];
                                     echo'<div class="row justify content around">
                                             <div class="col 8-offset">
                                                 <h5 style="font-size:14px; color:#717D7E; margin-left:20px;" >'.$name.'</h5>
                                             </div>
                                             <p style="font-size:14px; color: #717D7E; margin-right:20px;">'.$comment_time.'</p>
                                         </div>
                                         <p style="font-size:14px; color: #717D7E; margin-left:20px;">'.$comment.'</p>
                                         </br>
                                         ';
                                 }
                                 echo'</div></div><hr></br></div>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    </body>
</html>