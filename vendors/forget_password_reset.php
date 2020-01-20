<?php

    if(isset($_GET['hash']) && isset($_GET['email'])){
        $email = $_GET['email'];
        $hash = $_GET['hash'];
    }else{
        echo "invalid access";
        exit();
    }
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">IN+</h1>

            </div>
            <h3>請重新輸入新密碼</h3>
            <!-- <p>請重新輸入新密碼</p> -->
            <form class="m-t" role="form" action="./check_forget_password_reset.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="驗證碼" required="" name="token">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="輸入密碼" required="" name="password1">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="確認密碼" required="" name="password2">
                </div>
                <div class="mb-3">
                    <small id="message"></small>
                </div>
                <input type="hidden" name="email" value="<?php echo $email ?>">
                <input type="hidden" name="hash" value="<?php echo $hash ?>">
                <button type="submit" class="btn btn-primary block full-width m-b" disabled>成立帳號</button>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.js"></script>

</body>

<script>
    var pwd1 = $('input[name="password1"]');
    var pwd2 = $('input[name="password2"]');
    $('input[type="password"]').keyup(function(){
        if(pwd1.val()!=="" && pwd2.val()!==""){
            if(pwd1.val() !== pwd2.val()){
                $("#message").attr('class','text-warning');
                $("#message").text("密碼不一致");
                $('button[type="submit"]').attr("disabled",'');
            }else{
                $("#message").attr('class','text-navy');
                $("#message").text("ok!");
                $('button[type="submit"]').removeAttr("disabled");
            }
        }else{
            $("#message").text("");
            $('button[type="submit"]').attr("disabled",'');
        }
    })
</script>

</html>
