<?php
    include("config.php");
    


    $eq_sql = "SELECT * FROM `eq_question`";
    $eq_result = mysqli_query($conn,$eq_sql);

?>
<script>
    const middle_classes = <?php echo json_encode($middle_classes); ?>;
    const middle_classes_id = <?php echo json_encode($middle_classes_id); ?>;
    const highMajors = <?php echo json_encode($high_majors); ?>;
    const highMajors_id = <?php echo json_encode($high_majors_id); ?>;
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบทดสอบวัด EQ</title>
    <link rel="stylesheet" href="css/in_form.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <section>
        <div class="con">
            <div class="header-img">
                <h1>แบบทดสอบวัด EQ</h1>
            </div>
            <div class="info-con ">
                <p class="question" >ข้อมูลส่วนตัว</p>
                <form id="myForm" action="info_form_db.php" method="post">
                    <div class="all-info">
                        <div class="input-info">
                            <label for="student_id">เลขประจำตัวนักเรียน</label>
                            <input type="text"  name="student_id" id="student_id" pattern=".{5,6}"  required>
                        </div>
                        <div class="input-info">
                            <label for="grade">ระดับชั้น</label>
                            <select id="grade" class="grade" name="grade" style="width:200px" required>
                                <option value="">--เลือก--</option>
                                <option value="1">ม.1</option>
                                <option value="2">ม.2</option>
                                <option value="3">ม.3</option>
                                <option value="4">ม.4</option>
                                <option value="5">ม.5</option>
                                <option value="6">ม.6</option>
                            </select>
                        </div>
                        <div class="input-info">
                            <label for="class">ห้อง</label>
                            <select id="class" class="searchable-select" name="class" style="width:200px" required>
                            </select>
                        </div>
                        <div class="input-info">
                            <label for="title_name">คำนำหน้า</label>
                            <select id="title_name" class="searchable-select" name="title_name" style="width:200px" required>
                                <option value="">--เลือก--</option>
                                <option value="1">เด็กชาย</option>
                                <option value="2">เด็กหญิง</option>
                                <option value="3">นาย</option>
                                <option value="4">นางสาว</option>
                            </select>
                        </div>
                        <div class="input-info">
                            <label for="name">ชื่อ</label>
                            <input type="text" class=""  name="name" id="name" required>
                        </div>
                        <div class="input-info">
                            <label for="sur_name">นามสกุล</label>
                            <input type="text"  name="sur_name" id="sur_name" required>
                        </div>
                    </div>
                    <div class="con-submit">
                        <input type="submit" class="btn" value="submit" name="info">
                    </div>
                </form>
            </div>
        </div>
    </section>



    <script>
        document.getElementById('grade').addEventListener('change', function() {
            var selectedValue = this.value;
            var classSelect = document.getElementById('class');

            // Clear existing options in class select
            classSelect.innerHTML = '';

            // กำหนด type ตามค่า selectedValue
            var type = (selectedValue < 4) ? 'middle' : 'high';

            fetch(`get_value.php?type=${type}`)
                .then(response => response.json())
                .then(data => {
                    var classOptions = data.option;
                    var classOptionsId = data.option_id;

                    classOptions.forEach(function(optionValue, index) {
                        var option = document.createElement('option');
                        option.value = classOptionsId[index];
                        option.text = optionValue;
                        classSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        });

            $(document).ready(function() {
            $('.searchable-select').select2({
                placeholder: "ค้นหาตัวเลือก",
                allowClear: true
            });
        });
    </script>
</body>
</html>