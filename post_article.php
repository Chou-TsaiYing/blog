<?php
    header('Content-Type: application/json; charset=UTF-8'); 
    include 'dbconfig.php';

    if($_POST['action']=="post"){
        $userid = $_POST['userid'];
        $title = $_POST['title'];
        $text = $_POST['text'];
        $current_user = $_POST['current_user'];
        
        $s = "SELECT MAX(artid) FROM articles";
        $result = mysqli_query($conn, $s);
        $row = mysqli_fetch_array($result);
        $artid = $row['MAX(artid)'] + 1;
        
        $s = "insert into articles(artid,userid,title,text) values ('$artid','$userid','$title','$text')";
        mysqli_query($conn, $s);
    
        $output_article = "SELECT * FROM articles WHERE artid = '$artid'";
        $result = mysqli_query($conn, $output_article);
        $row = mysqli_fetch_array($result);
        
        $s = "SELECT * FROM prize WHERE userid = '$userid'";
        $result = mysqli_query($conn, $s);
        $prize = mysqli_fetch_array($result);
        $ticket = $prize['ticket'];
        $ticket = $ticket + 5;
        $update_ticket = "UPDATE prize SET ticket = '$ticket' WHERE userid = '$userid'";
        mysqli_query($conn, $update_ticket);

        $data= array("title" => $row['title'], "text" => $row['text'], "time" => substr($row['time'],0,19), "artid" => $artid, "current_user" => $current_user, "ticket" => $ticket);
        echo json_encode($data);
    }
    else if($_POST['action'] == "Comment" && $_POST['comment']!="" ){
        $comment = $_POST['comment'];
        $username = $_POST['username'];
        $artid = $_POST['artid'];

        $s = "SELECT * FROM accounts WHERE username = '$username'";
        $result = mysqli_query($conn, $s);
        $row = mysqli_fetch_array($result);
        $userid = $row['userid'];

        $s = "SELECT MAX(commentid) FROM comments";
        $result = mysqli_query($conn, $s);
        $row = mysqli_fetch_array($result);
        $commentid = $row['MAX(commentid)'] + 1;

        $insert_comment = "insert into comments(commentid,userid,artid,comment) values ('$commentid','$userid','$artid','$comment')";
        mysqli_query($conn, $insert_comment);

        $output_comment = "SELECT * FROM comments WHERE commentid = '$commentid'";
        $result = mysqli_query($conn, $output_comment);
        $row = mysqli_fetch_array($result);

        $s = "SELECT * FROM comments WHERE artid = '$artid'";
        $result = mysqli_query($conn, $s);
        $num = mysqli_num_rows($result);

        $data = array( "name" => $username, "comment" => $comment, "time" => substr($row['time'],0,19), "num" => strval($num));
        echo json_encode($data);
    }
    else if($_POST['action'] == "edit"){
        $artid = $_POST['artid'];
        $edit_title = $_POST['edit_title'];
        $edit_text = $_POST['edit_text'];

        if(isset($edit_title) && $edit_title != ""){
            $update_title = "UPDATE articles SET title = '$edit_title' WHERE artid = '$artid'";
            mysqli_query($conn, $update_title);
        }
        if(isset($edit_text) && $edit_text != "" ){
            $update_text = "UPDATE articles SET text = '$edit_text' WHERE artid = '$artid'";
            mysqli_query($conn, $update_text);
        }
        $data = array("newtitle" => $edit_title, "newtext" => $edit_text);
        echo json_encode($data); 
    }
    else if($_POST["action"] == "delete"){
        $artid = $_POST['artid'];

        $delete_article = "DELETE FROM articles WHERE artid = '$artid'";
        mysqli_query($conn, $delete_article);

        $delete_comment = "DELETE FROM comments WHERE artid = '$artid'";
        mysqli_query($conn, $delete_comment);

        $delete_like = "DELETE FROM likes WHERE artid = '$artid'";
        mysqli_query($conn, $delete_);

        $data = array( "message" => "success");
        echo json_encode($data);
    }
    else if($_POST["action"] == "like" && $_POST["username"]!=""){
        $artid = $_POST['artid'];
        $username = $_POST['username'];

        $s = "SELECT * FROM accounts WHERE username = '$username'";
        $result = mysqli_query($conn, $s);
        $row = mysqli_fetch_array($result);
        $userid = $row['userid'];

        $like = "insert into likes(userid,artid) values ('$userid','$artid')";
        mysqli_query($conn, $like);
        $data = array("message" => "success");
        echo json_encode($data);
    }
    else if ($_POST["action"] == "unlike"){
        $artid = $_POST['artid'];
        $username = $_POST['username'];

        $s = "SELECT * FROM accounts WHERE username = '$username'";
        $result = mysqli_query($conn, $s);
        $row = mysqli_fetch_array($result);
        $userid = $row['userid'];

        $unlike = "DELETE FROM likes WHERE artid = '$artid' AND userid = '$userid'";
        mysqli_query($conn, $unlike);
        $data = array("message" => "success");
        echo json_encode($data);
        
    }
    else if($_POST["action"] == "getPrize"){
        $userid = $_POST['userid'];
        $prize = $_POST['prize'];

        $s = "SELECT * FROM prize WHERE userid = '$userid'";
        $result = mysqli_query($conn, $s);
        $row = mysqli_fetch_array($result);
        $ticket = $row['ticket'];
        $account = $row['account'];
        if($ticket > 0) $ticket = $ticket - 1;
        $account = $account + $prize;

        $update_ticket = "UPDATE prize SET ticket = '$ticket' WHERE userid = '$userid'";
        mysqli_query($conn, $update_ticket);

        $update_account = "UPDATE prize SET account = '$account' WHERE userid = '$userid'";
        mysqli_query($conn, $update_account);

        $data = array("ticket" => $ticket, "account" => $account);
        echo json_encode($data);
    }
?>