
<?php
include("config.php");

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == 'eq_que') {
        $data = json_decode(file_get_contents('php://input'), true);

        // แยกข้อมูลจาก data_list
        $forminfo = $data['forminfo'];
        $score = $data['score'];

        // เก็บข้อมูลคะแนนใน session
        $_SESSION['eq_score'] = $score;
        $_SESSION['info'] = $forminfo;

        // เก็บข้อมูลคะแนนในตัวแปร
        $control = $score['1'];
        $empat = $score['2'];
        $respons = $score['3'];
        $moti = $score['4'];
        $deci = $score['5'];
        $relat = $score['6'];
        $esteem = $score['7'];
        $satis = $score['8'];
        $peace = $score['9'];

        // ตัวอย่างการเก็บข้อมูลส่วนตัวจาก forminfo

        $student_id = $_SESSION['stu_id'];
        


        // เก็บข้อมูลในฐานข้อมูล
        $sql_stu_chk = "SELECT * FROM stu_score  WHERE stu_id = '$student_id' ";
        $result_stu_chk = mysqli_query($conn, $sql_stu_chk);
        if(mysqli_num_rows($result_stu_chk) == 1){
            $sql_update_score = "UPDATE `stu_score` 
                                SET `ss_control`='$control',
                                `ss_empat`='$empat',
                                `ss_respons`='$respons',
                                `ss_moti`='$moti',
                                `ss_deci`='$deci',
                                `ss_relat`='$relat',
                                `ss_esteem`='$esteem',
                                `ss_satis`='$satis',
                                `ss_peace`='$peace' ,
                                `ss_date`= NOW()
                                WHERE `stu_id` = $student_id";
            $result = mysqli_query($conn,$sql_update_score);
        }else{
            $sql_insert_score = "INSERT INTO `stu_score` (`stu_id`, `ss_control`, `ss_empat`, `ss_respons`, `ss_moti`, `ss_deci`, `ss_relat`, `ss_esteem`, `ss_satis`, `ss_peace`,`ss_date`)
                                VALUES ('$student_id', '$control', '$empat', '$respons', '$moti', '$deci', '$relat', '$esteem', '$satis', '$peace',NOW())";
            $result_insert_score = mysqli_query($conn, $sql_insert_score);
        }
        
    }
} elseif (isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type == 'middle') {
        $sql = "SELECT * FROM middle_school_classes ORDER BY msc_name";
        $result = mysqli_query($conn, $sql);

        $option = [];
        $option_id = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $option[] = $row['msc_name'];
            $option_id[] = $row['msc_id'];
        }

        echo json_encode(['option' => $option, 'option_id' => $option_id]);
    } else {
        $sql = "SELECT * FROM high_school_majors ORDER BY hsm_abbre_name";
        $result = mysqli_query($conn, $sql);

        $option = [];
        $option_id = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $option[] = $row['hsm_abbre_name'];
            $option_id[] = $row['hsm_id'];
        }

        echo json_encode(['option' => $option, 'option_id' => $option_id]);
    }
}
?>
