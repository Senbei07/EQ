<?php
    session_start();
    $conn = mysqli_connect("localhost","root","","eq_test");
    // if($conn){
    //     echo "yes";
    // }

    function tit_name($conn,$tit){
        $sql_tit = "SELECT * FROM tit_name WHERE tit_name = '$tit'";
        $result_tit = mysqli_query($conn , $sql_tit);
        if(mysqli_num_rows($result_tit) > 0){
            $row_tit = mysqli_fetch_assoc($result_tit);
            $tit_id = $row_tit['tit_ID'];
            return $tit_id;
        }else{
            $sql_addtit = "INSERT INTO tit_name(tit_name) VALUES('$tit')";
            $result_addtit = mysqli_query($conn,$sql_addtit);
            if($result_addtit){
                $tit_id = mysqli_insert_id($conn);
                return $tit_id;
            }
        }
    }
?>