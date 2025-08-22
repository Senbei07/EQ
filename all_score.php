<?php
    include('config.php');

    

    $eq_score = $_SESSION['eq_score']; // session เก็บค่าคะแนนบททดสอบ EQ แต่ละด้านย่อย
    print_r($eq_score);

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
    <title>Document</title>
    <link rel="stylesheet" href="css/sum_score.css">
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <section>
        <div class="scale-con">
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
                                    $score_result = 'over';
                                }else{
                                    $score_result = 'normal';
                                }
                        ?>
                                
                                <div class="type-scale-con">
                                    <div class="straw">
                                        <div class="icon-group">
                                            <div class="icon"></div>
                                            
                                        </div>
                                        <div class="scale-max <?php echo $sub_class[$i-1]; ?>" id="<?php echo $sub_class[$i-1]; ?>">
                                            <div class="scale-score <?php echo $sub_class[$i-1]; echo ' '.$score_result; ?> " id="<?php echo $sub_class[$i-1]; ?>">
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
        </div>
        <div class="eq-info">
            
        </div>
    </section>
    <script>

        const all_score = <?php echo json_encode($eq_score);?>;
        console.log(all_score);
        


        var scale_max = document.querySelectorAll('.scale-max');
        let i = 1;
        scale_max.forEach(scale => {
            var scale_value = document.querySelector(`div.scale-score#${scale.id}`);
            const max = [21,22,23,24,24,24,16,24,24]
            score = (all_score[i] / max[i-1]) * 100
            console.log(all_score[i]);
            console.log(max[i-1]);
            console.log(score);
            console.log('----------------------------');

            if (scale_value.classList.contains('normal')) {
                scale_value.style.backgroundColor = '#75c095';
            }else if(scale_value.classList.contains('over')){
                scale_value.style.backgroundColor = '#dc493f';
            }else if(scale_value.classList.contains('Less')){
                scale_value.style.backgroundColor = '#789cce';
            }

            scale_value.style.width = score + '%';
            i++;
        });
    </script>
</body>
</html>
