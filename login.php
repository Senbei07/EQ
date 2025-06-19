<?php
    session_start();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        h2{
            font-size: 50px;
            color: red;
        }
        h3{
            font-size: 40px;
        }
    </style>
</head>
<body>
    
    <div class="container">
            <div class="con-input">
                <div class="Login">
                    <h1 class="login">Login</h1>
                    <div class="error">
                        <?php if(isset($_SESSION['error'])){ ?>
                        <p><?php echo $_SESSION['error'];?></p>
                        <?php unset($_SESSION['error']); }?>
                    </div>
                    <div  class="con-login">
                        <form action="login_db.php" method="post">
                            <div class="input">
                                <input type="text" name="user" required>
                                <label for="">Username</label>
                            </div>
                            <div class="input">
                                <input type="password" name="password" required>
                                <label for="">Password</label>
                            </div>
                            <div class="submit">
                                <button type="submit" name="signin" class="Signin">Login</button>
                            </div>
                            <div class="sign-up">
                                <p>สมัครสมชิกใหม่ <a href="#" class="signup"> Sign up</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="Signup">
                <h1 class="signup">Sign-Up</h1>
                    <div class="error">
                        <?php if(isset($_SESSION['error'])){ ?>
                        <p><?php echo $_SESSION['error'];?></p>
                        <?php unset($_SESSION['error']); }?>
                    </div>
                    <div  class="con-signup">
                        <form action="sign_db.php" method="post">
                            <div class="input">
                                <input type="text" name="username" required>
                                <label for="">Username</label>
                            </div>
                            <div class="input">
                                <input type="password" name="password" required>
                                <label for="">Password</label>
                            </div>
                            <div class="input">
                                <input type="password" name="con_password" required>
                                <label for="">Confirm password</label>
                            </div>
                            <div class="input">
                                
                                <label for="">เพศ</label>
                                <select name="gender" id="">
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                    <option value="3">อื่นๆ</option>
                                </select>
                            </div>
                            <div class="input">
                                <input type="date" name="date" required>
                                <label for=""></label>
                            </div>
                            <div class="submit">
                                <button type="submit" name="signup" class="Signup">Sign up</button>
                            </div>
                            <div class="sign-up">
                                <p>เป็นสมาชิกแล้ว ต้องการ <a href="#" class="signin"> Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                <script src="js/login.js"></script>
            </div>
        
    </div>
</body>
<script>
    const signin=document.querySelector('.signin')
const signup=document.querySelector('.signup')
const Login=document.querySelector('.Login')
const Signup=document.querySelector('.Signup')
const input = document.querySelector('input');

window.onload = function reload(){
    input.value = "";
}

signup.addEventListener('click',()=>{
    Login.classList.add('active')
    Signup.classList.add('active')
    input.value = "";
})
signin.addEventListener('click',()=>{
    Signup.classList.remove('active')
    Login.classList.remove('active')
    input.value = "";
})
</script>
</html>