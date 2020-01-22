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

    <title>重設密碼</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Forgot password</h2>

                    <p>
                        Enter your email address and your password will be reset and emailed to you.
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                        <form class="m-t" role="form" action="./check_forget_password_reset.php" method="post" id="resetpwd">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="驗證碼" required="" name="token">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="輸入密碼" required="" name="password1">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="確認密碼" required="" name="password2">
                            </div>
                            <div class="form-group mt-4" id="selectVendor">
                                <label for="selectVendor">選擇帳號</label>
                                <small class="d-block">我們偵測到您有多組帳號，請選擇您要修改密碼的帳號屬於哪一間廠商</small>
                                <select id="vendorList" class="form-control" name="vendor">
                                </select>
                            </div>
                            <div class="mb-3">
                                <small id="message" class="text-warning"></small>
                            </div>
                            <input type="hidden" name="email" value="<?php echo $email ?>">
                            <input type="hidden" name="hash" value="<?php echo $hash ?>">
                            <button type="submit" class="btn btn-primary block full-width m-b">確定</button>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright Example Company
            </div>
            <div class="col-md-6 text-right">
               <small>© 2014-2015</small>
            </div>
        </div>
    </div>

<script src="../js/jquery-3.1.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script>

var request;

$("#selectVendor").hide();


$('body').on('submit', '#resetpwd', function(event){

    event.preventDefault();

    if(request){
        request.abort();
    }

    var $form = $("#resetpwd");

    var $inputs = $form.find('input, button');

    var serializedData = $form.serialize();

    $inputs.prop("disabled", true);

    request = $.ajax({
        url : "./check_forget_password_reset.php",
        type: "post",
        data: serializedData
    });

    request.done(function(response, textStatus, jqXHR){
        if(response.startsWith('<option')){
            $("#selectVendor").show(200);
            $('#vendorList').html(response);
            $("#vendorList").attr("required","");

            $form.attr('id','resetpwd2');
            $form.attr("action", "./check_forget_password_reset2.php");
            
        }else if(response === 'success'){
            window.location = './forget_password_success.php';
        }else{
            $("#message").text(response);
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

})


$('body').on('submit', '#resetpwd2', function(event){
    
    event.preventDefault();

    if(request){
        request.abort();
    }

    var $form = $("#resetpwd2");

    var $inputs = $form.find('input, button');

    var serializedData = $form.serialize();

    request = $.ajax({
        url : "./check_forget_password_reset2.php",
        type: "post",
        data: serializedData
    });

    request.done(function(response, textStatus, jqXHR){
        if(response == 'success'){
            window.location = './login.php';
        }else{
            $("#message").text(response);
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
        $button.prop("disabled", false);
    });
})
</script>
</body>

</html>
