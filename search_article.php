<?php
    include 'dbconfig.php';
    if(isset($_POST["query"]) || $_POST["query"]==""){
        $search = mysqli_real_escape_string($conn, $_POST["query"]);
        $s = "SELECT * FROM articles WHERE title LIKE '%".$search."%'";
    }
    else{
        $s = " SELECT * FROM articles ORDER BY artid";
    }
    $result = mysqli_query($conn, $s);
    while($row = mysqli_fetch_array($result)){
        $userid = $row['userid'];
        $artid = $row['artid'];
        $title = $row['title'];
        $time = substr($row['time'],0,19);
        $search_name = "SELECT * FROM accounts WHERE userid = '$userid'";
        $output = mysqli_query($conn, $search_name);
        $output_row =  mysqli_fetch_array($output);
        $username = $output_row['username'];
        $return_arr[] = array(  "artid" => $artid,
                                "username" => $username,
                                "title" => $title,
                                "time" => $time);
    }
    echo json_encode($return_arr);
?>