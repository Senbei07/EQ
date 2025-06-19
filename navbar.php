<link rel="stylesheet" href="css/navbar.css">
<style>
    body{
        width: 100vw;
        height: 100vh;
    }
</style>
<header>
    <a href="index.php" >
        <img src="img/spsm_logo.png" alt="โรงเรียนสาธิต มศว ประสานมิตร (ฝ่ายมัธยม)" class="logo" >

    </a>
    <div class="hbg">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
        <nav class="nav-bar">
            <ul>
                <li>
                    <a href="index.php">แบบทดสอบ</a>
                </li>
            </ul>
        </nav>
</header>
<script>
        var hbg = document.querySelector(".hbg");
        hbg.addEventListener('click',()=>{
            var navbar = document.querySelector(".nav-bar");
            if (navbar.classList.contains("active-nav")) {
                navbar.classList.remove("active-nav");
            }else{
                
                navbar.classList.add("active-nav");
            }
            
        })

</script>