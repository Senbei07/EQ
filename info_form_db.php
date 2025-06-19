
<?php
    include('config.php');


    if(isset($_POST['info'])){
        
        $student_id = $_POST['student_id'];
        $grade = $_POST['grade'];
        $class = $_POST['class'];
        $title_name = $_POST['title_name'];
        $name = $_POST['name'];
        $sur_name = $_POST['sur_name'];

        
        if(empty($student_id)){
            $_SESSION['error'] = "กรุณากรอกรหัสประจำตัว";
            header("location: info_form.php");
        }elseif(empty($grade)){
            $_SESSION['error'] = "กรุณากรอกระดับชั้น";
            header("location: info_form.php");
        }elseif(empty($class)){
            $_SESSION['error'] = "กรุณากรอกห้อง หรือ วิชาเอก";
            header("location: info_form.php");
        }elseif(empty($title_name)){
            $_SESSION['error'] = "กรุณากรอกคำนำหน้า";
            header("location: info_form.php");
        }elseif(empty($name)){
            $_SESSION['error'] = "กรุณากรอกชื่อ";
            header("location: info_form.php");
        }elseif(empty($sur_name)){
            $_SESSION['error'] = "กรุณากรอกนามสกุล";
            header("location: info_form.php");
        }else{
            
            $sql_stu_chk = "SELECT * FROM student  WHERE s_student_id = '$student_id' ";
            $result_stu_chk = mysqli_query($conn, $sql_stu_chk);
            if(mysqli_num_rows($result_stu_chk) == 1){
                
                $sql_update_score = "UPDATE `student` 
                                     SET `s_title_name`=$title_name,
                                     `s_name`='$name',
                                     `s_sur_name`='$sur_name',
                                     `s_grade`='$grade',
                                     `s_room`='$class'
                                      WHERE s_student_id = $student_id";
                $result = mysqli_query($conn,$sql_update_score);
                if($result){
                    echo 'aaa';
                }else{
                            
                }
                $_SESSION['stu_id'] = $student_id;
                header("location: eq_que.php");
            }else{
                
                $sql_insert_stu = "INSERT INTO 
                            `student`(`s_student_id`, `s_title_name`, `s_name`, `s_sur_name`, `s_grade`, `s_room`) 
                            VALUES ('$student_id','$title_name','$name','$sur_name','$grade','$class')";
                $result_insert_stu = mysqli_query($conn, $sql_insert_stu);

                $_SESSION['stu_id'] = $student_id;
                header("location: eq_que.php");
            }

            
        }
    }else{
        header("location: info_form.php");
    }
?>