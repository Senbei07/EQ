<?php
include("config.php");

$grade = isset($_GET['grade']) ? $_GET['grade'] : '';
$room = isset($_GET['room']) ? $_GET['room'] : '';


$eq_score_sql = "SELECT *,
    (ss_control + ss_empat + ss_respons) AS good, 
    (ss_moti + ss_deci + ss_relat) AS smart,
    (ss_esteem + ss_satis + ss_peace) AS happy
FROM stu_score  
LEFT JOIN student ON stu_score.stu_id = student.s_student_id
LEFT JOIN title_name ON student.s_title_name = title_name.title_id
LEFT JOIN middle_school_classes ON (student.s_room = middle_school_classes.msc_id AND student.s_grade BETWEEN 1 AND 3)  -- เฉพาะ ม.ต้น
LEFT JOIN high_school_majors ON (student.s_room = high_school_majors.hsm_id AND student.s_grade BETWEEN 4 AND 6) -- เฉพาะ ม.ปลาย
LEFT JOIN stu_grade ON student.s_grade = stu_grade.g_id
WHERE (student.s_grade = '$grade') 
AND (
        (student.s_grade BETWEEN 1 AND 3 AND middle_school_classes.msc_id = '$room') 
        OR 
        (student.s_grade BETWEEN 4 AND 6 AND high_school_majors.hsm_id = '$room') 
        OR 
        ('$room' = '')
    );";

$eq_score_result = mysqli_query($conn, $eq_score_sql);

$major_sql = "SELECT hsm_id,hsm_abbre_name FROM `high_school_majors` ORDER BY hsm_abbre_name";
$major_result = mysqli_query($conn, $major_sql);

$class_sql = "SELECT * FROM `middle_school_classes` ORDER BY msc_id";
$class_result = mysqli_query($conn, $class_sql);

$type_min = [48,45,42];
$type_max = [58,59,56];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student EQ Scores</title>
    <link rel="stylesheet" href="css/eq_score.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * { font-size: small; }
        td { text-align: center; }
    </style>
</head>
<body>
    
<script>
$(document).ready(function() {
    var grade = <?php echo json_encode($grade); ?>;
    

    var table = $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
    {
        extend: 'excelHtml5',
        text: 'Excel',
        filename: function() {
                // ใช้ template literals เพื่อสร้างชื่อไฟล์
                return `ผลแบบทดสอบ EQ ชั้น ม.${grade} ห้อง${room}`;
            },
        title: 'ผลแบบทดสอบ EQ',
        messageTop: `มัธยมศึกษาปีที่ ${grade} ห้อง${room}`
    }
],
        "rowCallback": function(row, data, index) {
            var info = this.api().page.info();
            var seq = info.page * info.length + (index + 1);
            $('td:eq(0)', row).html(seq);
        }
    });

    $('#gradeFilter').on('change', function() {
        var gradeValue = this.value;
        console.log("เลือกชั้น:", gradeValue);  
        table.column(3).search(gradeValue).draw();

        // ปรับ dropdown ห้องตามเกรดที่เลือก
        if (gradeValue >= 1 && gradeValue <= 3) {
            $('#roomFilter').html(`
                <option value="">เลือกห้อง</option>
                <?php while($class_row = mysqli_fetch_assoc($class_result)) { ?>
                    <option value="<?php echo $class_row['msc_id'] ?>"><?php echo $class_row['msc_name'] ?></option>
                <?php } ?>
            `);
        } else if (gradeValue >= 4 && gradeValue <= 6) {
            $('#roomFilter').html(`
                <option value="">เลือกห้อง</option>
                <?php while($major_row = mysqli_fetch_assoc($major_result)) { ?>
                    <option value="<?php echo $major_row['hsm_id'] ?>"><?php echo $major_row['hsm_abbre_name'] ?></option>
                <?php } ?>
            `);
        } else {
            $('#roomFilter').html('<option value="">เลือกห้อง</option>');
        }
    });

    $('#roomFilter').on('change', function() {
        var roomValue = this.value;
        console.log("เลือกห้อง:", roomValue); 
        table.column(4).search(roomValue).draw(); 
    });
});
</script>



    <section>
        <div class="container mt-4">
            <div class="mb-3">
            <form method="GET" action="eq_score.php">
    <label for="gradeFilter">ระดับชั้น:</label>
    <select id="gradeFilter" name="grade">
        <option value="">เลือกระดับชั้น</option>
        <option value="1">ระดับชั้น 1</option>
        <option value="2">ระดับชั้น 2</option>
        <option value="3">ระดับชั้น 3</option>
        <option value="4">ระดับชั้น 4</option>
        <option value="5">ระดับชั้น 5</option>
        <option value="6">ระดับชั้น 6</option>
    </select>

    <label for="roomFilter">ห้อง:</label>
    <select id="roomFilter" name="room">
        <option value="">เลือกห้อง</option>
        <!-- ตัวเลือกห้องจะถูกโหลดโดย JavaScript -->
    </select>

    <input type="submit" value="Submit">
</form>

            </div>

            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>เลขประจำตัว</th>
                            <th>คำนำหน้า</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>ชั้น</th>
                            <th>ห้อง</th>
                            <th>คะแนนดี</th>
                            <th>แปลผลดี</th>
                            <th>คะแนนเก่ง</th>
                            <th>แปลผลเก่ง</th>
                            <th>คะแนนสุข</th>
                            <th>แปลผลสุข</th>
                            <th>คะแนนรวม</th>
                            <th>แปลผลรวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            while ($eq_score_row = mysqli_fetch_assoc($eq_score_result)) { ?>
                            <tr>
                                <td></td>
                                <td><?php echo '0'.$eq_score_row['stu_id']; ?></td>
                                <td><?php echo $eq_score_row['title_name']?></td>
                                <td><?php echo $eq_score_row['s_name'] . " " . $eq_score_row['s_sur_name']; ?></td>
                                <td><?php echo $eq_score_row['g_name']; ?></td>
                                <td><?php if($eq_score_row['g_id'] <= 3){
                                            $s_room =  $eq_score_row['msc_name'];
                                        }else{
                                            $s_room =   $eq_score_row['hsm_abbre_name'];
                                        } 
                                        echo $s_room;
                                        ?></td>
                                <script>var room = <?php echo json_encode($s_room); ?>;</script>
                                <td><?php echo $eq_score_row['good']; ?></td>
                                <td>
                                    <?php 
                                        if($eq_score_row['good'] < $type_min[0]){
                                            echo "ต่ำกว่าปกติ";
                                        }else if($eq_score_row['good'] > $type_max[0]){
                                            echo "สูงกว่าปกติ";
                                        }else{
                                            echo "ปกติ";
                                        }
                                    ?>
                                </td>
                                <td><?php echo $eq_score_row['smart']; ?></td>
                                <td>
                                    <?php 
                                        if($eq_score_row['smart'] < $type_min[1]){
                                            echo "ต่ำกว่าปกติ";
                                        }else if($eq_score_row['smart'] > $type_max[1]){
                                            echo "สูงกว่าปกติ";
                                        }else{
                                            echo "ปกติ";
                                        }
                                    ?>
                                </td>
                                <td><?php echo $eq_score_row['happy']; ?></td>
                                <td>
                                    <?php 
                                        if($eq_score_row['happy'] < $type_min[2]){
                                            echo "ต่ำกว่าปกติ";
                                        }else if($eq_score_row['happy'] > $type_max[2]){
                                            echo "สูงกว่าปกติ";
                                        }else{
                                            echo "ปกติ";
                                        }
                                    ?>
                                </td>
                                <td><?php echo $sum = $eq_score_row['smart'] + $eq_score_row['good'] + $eq_score_row['happy']; ?></td>
                                                                <td>
                                    <?php 
                                        if($sum < 138){
                                            echo "ต่ำกว่าปกติ";
                                        }else if($sum > 170){
                                            echo "สูงกว่าปกติ";
                                        }else{
                                            echo "ปกติ";
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
