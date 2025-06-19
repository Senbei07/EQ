<?php
    include('config.php');



    $eq_score = $_SESSION['eq_score']; // session เก็บค่าคะแนนบททดสอบ EQ แต่ละด้านย่อย
    print_r($eq_score);
    $eq_info = $_SESSION['info']; // session เก็บค่าคะแนนบททดสอบ EQ แต่ละด้านย่อย
    print_r($eq_info);

    $good = $eq_score[1] + $eq_score[2] + $eq_score[3]; // รวมคะแนนในด้านดี
    $smart = $eq_score[4] + $eq_score[5] + $eq_score[6]; // รวมคะแนนในด้านเก่ง
    $happy = $eq_score[7] + $eq_score[8] + $eq_score[9]; // รวมคะแนนในด้านสุข

    $type_score = [$good,$smart,$happy];
    $type = ['ดี','เก่ง','สุข'];

    $sql = "SELECT * FROM eq_sub_type";
    $sql_result = mysqli_query($conn,$sql);

    $sql_eq_type = "SELECT * FROM eq_type";
    $result_eq_type = mysqli_query($conn,$sql_eq_type);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลแบบทดสอบ EQ</title>
    <link rel="stylesheet" href="css/sum_score.css">
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <section>
        <div class="scale-con">
            <div class="score-sum">
                <div class="sum-left">
                    <p>คะแนนรวม</p>
                    <h1><?php echo $sum = array_sum($type_score); ?></h1>
                    <p><?php 
                        if($sum < 138 ){
                            echo "คะแนนน้อยกว่า 138 อยู่ในช่วง น้อยกว่าปกติ";
                        }elseif($sum > 170 ){
                            echo "คะแนนมากกว่า 170 อยู่ในช่วง มากกว่าปกติ";
                        }else{
                            echo "คะแนน 138 - 170 อยู่ในช่วง ปกติ";
                        }
                    ?></p>
                </div>
                <div class="sum-right">
                    <div class="circular-progress" style="--i:85;--clr:#ec1515">
                        <div class="inner-circle"></div>
                        <div class="progress-value">
                            <p class="progress-value-p">0</p>
                            <h4>ดี</h4>
                        </div>
                        
                    </div>
                    <div class="circular-progress" style="--i:95;--clr:#ec1515">
                        <div class="inner-circle"></div>
                        <div class="progress-value">
                            <p class="progress-value-p">0</p>
                            <h4>เก่ง</h4>
                        </div>
                        
                    </div>
                    <div class="circular-progress sclae-Less" style="--i:25;--clr:#ec1515">
                        <div class="inner-circle"></div>
                        <div class="progress-value">
                            <p class="progress-value-p">0</p>
                            <h4>สุข</h4>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php
                $i =1;
                $sub_class = ['control','empat','respons','moti','deci','relat','esteem','satis','peace'];
                while($row_eq_type = mysqli_fetch_array($result_eq_type)){
                    ?>
                    <div class="con <?php echo $row_eq_type['et_type_eng']; ?>">
                        <h1><?php echo $row_eq_type['et_type_th']; ?></h1>
                        <?php
                            while($row_eq_sub = mysqli_fetch_array($sql_result)){

                                if($eq_score[$i] < $row_eq_sub['min_value']){
                                    $score_result = 'Less';
                                }else if($eq_score[$i] > $row_eq_sub['max_value']){
                                    $score_result = 'Over';
                                }else{
                                    $score_result = 'Normal';
                                }
                        ?>
                                
                                <div class="type-scale-con">
                                    <div class="straw">
                                        <div class="icon-group">
                                            <div class="icon <?php echo 'icon-'.$sub_class[$i-1]; ?>">
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="scale-max <?php echo $sub_class[$i-1]; ?>" id="<?php echo $sub_class[$i-1]; ?>">
                                            <div class="scale-score <?php echo $sub_class[$i-1]; echo ' '.$score_result; ?> " id="<?php echo $sub_class[$i-1]; ?>">
                                                <p class="level"><?php echo $score_result; ?></p>
                                                <p class="score"><?php echo $eq_score[$i]; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="sub_type"><?php echo $row_eq_sub['est_type_th'] ?></p>
                                </div>
                        <?php
                                $i++;
                                if(($i-1)%3 == 0){
                                    break;
                                }
                            }
                        ?>
                    </div>
            <?php
                }
            ?>
        </div>

    </section>
    <footer>
        
    </footer>
    <script>

        const all_score = <?php echo json_encode($eq_score);?>;
        console.log(all_score);
        


        var scale_max = document.querySelectorAll('.scale-max');
        let i = 1;
        scale_max.forEach(scale => {
            var scale_value = document.querySelector(`div.scale-score#${scale.id}`);
            const max = [21,22,23,24,24,24,16,24,24]
            score = (all_score[i] / max[i-1]) * 100
            // console.log(all_score[i]);
            // console.log(max[i-1]);
            // console.log(score);
            // console.log('----------------------------');



            scale_value.style.width = score + '%';
            i++;
        });



        const progressBars = document.querySelectorAll('.circular-progress');
        const progressValues = document.querySelectorAll('.progress-value-p');

        // กำหนดค่า progressEndValue ที่แตกต่างกันสำหรับแต่ละ Progress Bar
        const progressEndValues = <?php  echo json_encode($type_score); ?>;// ค่าเป้าหมายสำหรับแต่ละ Progress Bar
        const type_min = [48,45,42];
        const type_max = [58,59,56];
        const type_maxx = [61,59,56];
        progressBars.forEach((circle, index) => {
            let progressStartValue = 0;
            let Value = progressEndValues[index] * 100 / type_maxx[index]; // ใช้ค่าที่กำหนดไว้ในอาร์เรย์
            let progressEndValue = progressEndValues[index]; // ใช้ค่าที่กำหนดไว้ในอาร์เรย์
            let speed = 10;

            let progress = setInterval(() => {
                progressStartValue++;

                progressValues[index].textContent = `${progressStartValue}`;
                if(progressEndValues[index] < type_min[index]){
                    circle.style.background = `conic-gradient(#ffd673 ${Value * 3.6}deg, #ededed 0deg)`;
                }else if(progressEndValues[index] > type_max[index]){
                    circle.style.background = `conic-gradient(#e59baf ${Value * 3.6}deg, #ededed 0deg)`;
                }else{
                    circle.style.background = `conic-gradient(#bed7ec ${Value * 3.6}deg, #ededed 0deg)`;
                }
                

                if (progressStartValue === progressEndValue) {
                    clearInterval(progress);
                }
            }, speed);
        });




    </script>
</body>
</html>
