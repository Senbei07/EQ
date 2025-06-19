<?php
    include("config.php");
    


    $eq_sql = "SELECT * FROM `eq_question`";
    $eq_result = mysqli_query($conn,$eq_sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบทดสอบวัด EQ</title>
    <link rel="stylesheet" href="css/eq_que.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
        <?php
            include("navbar.php");
        ?>
    <section>
        <div class="content">
            <div class="header-img">
                <h1>แบบทดสอบวัด EQ</h1>
            </div>
            <?php

            for ($i=1; $i <= 4 ; $i++) { 
                $j =1;
                $num = 1;
            ?>
                <div class="que-all <?php echo "que-con-"."$i"; if($i == 1){echo " active";}else{echo " inactive";}?>" id="<?php echo $i; ?>" >
                    <?php while($j <= 13){
                        $row = mysqli_fetch_assoc($eq_result);
                        $no = $row['value_group'];
                        if($row['value_group'] == 1){
                            $value1 = 1;
                            $value2 = 2;
                            $value3 = 3;
                            $value4 = 4;
                        }else{
                            $value1 = 4;
                            $value2 = 3;
                            $value3 = 2;
                            $value4 = 1;
                        }
                    ?>
                                <div class="con">
                                        <p class="question" name="<?php echo $row['eq_id']; ?>" ><?php echo $row['eq_id'].". ".$row['eq_que']; ?></p>
                                    <div class="ans">
                                        
                                        <input type="radio" class="a0" name="<?php echo $row['eq_id']; ?>" id="<?php echo $row['est_id']; ?>" value="<?php echo $value1; ?>" >
                                        <input type="radio" class="a1" name="<?php echo $row['eq_id']; ?>" id="<?php echo $row['est_id']; ?>" value="<?php echo $value2; ?>">
                                        <input type="radio" class="a2" name="<?php echo $row['eq_id']; ?>" id="<?php echo $row['est_id']; ?>" value="<?php echo $value3; ?>" >
                                        <input type="radio" class="a3" name="<?php echo $row['eq_id']; ?>" id="<?php echo $row['est_id']; ?>" value="<?php echo $value4; ?>" >
                                        
                                    </div>
                                </div>
                        <?php
                        $j++;
                            }
                        ?>
                        <div class="con page">
                            <?php
                            if($i > 1){
                                echo '<button  class="previous btn" id="'."$i".'">ก่อนหน้า</button>';
                            }
                            if($i < 4){
                                echo '<button  class="next btn" id="'."$i".'">ต่อไป</button>';
                            }else{
                                echo '<button  class="sub btn" >submit</button>';
                            }
                            ?>
                        </div>
                </div>
            <?php
            }  ?>
        </div>

    </section>

    <script>
        
        var btnElements = document.querySelectorAll('.btn');
        var submit = document.querySelector('.sub');
        var nextElements = document.querySelectorAll('.next');
        var previousElements = document.querySelectorAll('.previous');
        var radioInputs = document.querySelectorAll('input[type="radio"]');


        

    radioInputs.forEach(radio => {
        radio.addEventListener('click', () => {
            var raque = radio.name;
            var in_hid = document.querySelector(`p[name="${raque}"]`);

            if (!in_hid.classList.contains('checked')) {
                in_hid.classList.add('checked');
            }
            
            var allPs = document.querySelectorAll('p[name]');
            var currentIndex = Array.from(allPs).indexOf(in_hid);
            
            // เลือก <p> ถัดไปจากตำแหน่งที่พบ
            var nextIndex = currentIndex + 1;
            if (nextIndex < allPs.length) {
                var nextP = allPs[nextIndex];
                
                // เลื่อนให้ <p> ถัดไปอยู่กลางหน้าจอ
                nextP.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'  // 'center' จะทำให้ <p> อยู่กลางหน้าจอ
                });
            }
        });
    });


        nextElements.forEach(next => {
            next.addEventListener('click', () => {
                console.log(111);
                
                // ดึงค่า ID ของ elements ที่ถูกคลิก
                var next_id = next.id;

                // ดึง elements ที่มี class 'active'
                var div_old = document.querySelector('.active');

                // คำนวณ ID ของ elements ที่ต้องการแสดง
                var new_id = parseInt(next_id) + 1;

                // ดึง elements ที่มี ID ตามที่คำนวณได้
                var div_new = document.querySelector(`.que-all[id="${new_id}"]`);

                
                // ถ้ามี elements ที่มี class 'active' ให้ลบคลาสนั้นออก
                if (div_old) {
                    div_old.classList.remove('active');
                    div_old.classList.add('inactive');
                }

                // เพิ่มคลาส 'active' ให้กับ elements ที่ต้องการแสดง
                div_new.classList.remove('inactive');
                div_new.classList.add('active');

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // ใช้ 'auto' ถ้าไม่ต้องการให้มี animation
                });
            });
        });

        previousElements.forEach(previous => {
            previous.addEventListener('click', () => {
                console.log(111);
                
                // ดึงค่า ID ของ elements ที่ถูกคลิก
                var previous_id = previous.id;

                // ดึง elements ที่มี class 'active'
                var div_old = document.querySelector('.active');

                // คำนวณ ID ของ elements ที่ต้องการแสดง
                var new_id = parseInt(previous_id) - 1;

                // ดึง elements ที่มี ID ตามที่คำนวณได้
                var div_new = document.querySelector(`.que-all[id="${new_id}"]`);


                // ถ้ามี elements ที่มี class 'active' ให้ลบคลาสนั้นออก
                if (div_old) {
                    div_old.classList.remove('active');
                    div_old.classList.add('inactive');
                }

                // เพิ่มคลาส 'active' ให้กับ elements ที่ต้องการแสดง
                div_new.classList.remove('inactive');
                div_new.classList.add('active');

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // ใช้ 'auto' ถ้าไม่ต้องการให้มี animation
                });
            });
        });



        submit.addEventListener('click', () =>{
            console.log('22')
            // Objeect สำหรับเก็บค่าคะแนนของแบบทดสอบในแต่ละด้านย่อย
            var score = {'1': 0,'2': 0,'3': 0,'4': 0,'5': 0,'6': 0,'7': 0,'8': 0,'9':0};
            
            var forminfo = {
                student_id: <?php echo json_encode($_SESSION['stu_id']); ?>
        };
            radioInputs.forEach((input)=>{
                console.log('222')
                if(input.checked){
                    var id = input.id;
                    var value = parseInt(input.value);

                    if(!score.hasOwnProperty(id)){
                        score[id] = 0;
                    }

                    score[id] += value;
                }
            });
            // console.log(score);

            var data_list = {forminfo: forminfo, score: score};

            // ส่งคะแนนใน score ไปยังหน้า get_value.php
            fetch('get_value.php?page=eq_que', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data_list)
            })
            .then(response => response.text())
            .then(result => {
            console.log(result);
            console.log(666);

            // ไปที่หน้า eq_sum.php
            window.location.href = 'eq_sum.php';

            })
            .catch(error => {
            console.error('Error:', error);
            });
            
                
                
        })

    </script>
</body>
</html>