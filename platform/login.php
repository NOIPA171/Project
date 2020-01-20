<?php
    session_start();
    if(isset($_SESSION['name'])){
        echo "you've already logged in";
        header('Refresh: 5 ; url = admin.php');
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
            <h3>Welcome to IN+</h3>
            <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
            </p>
            <p>Login in. To see it in action.</p>
            <form class="m-t" role="form" action="./check_login.php" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required="" name="email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" name="password">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                <div class="mt-2">
                    <small id="message" class="text-warning"></small>
                </div>
                <a href="#"><small>Forgot password?</small></a>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.js"></script>
<script>
$(document).ready(function(){
    var request;
    $('form').submit(function(event){
        event.preventDefault();

        if (request) {
            request.abort();
        }
        var $form = $(this);

        var $inputs = $form.find("input, button");

        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);

        request = $.ajax({
            url: "./check_login.php",
            type: "post",
            data: serializedData
        });

        request.done(function (response, textStatus, jqXHR){
            if(response == 'success'){
                window.location = "./admin.php";
            }else{
                $("#message").text(response);
            };
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });

        request.always(function () {
            $inputs.prop("disabled", false);
        });

        
    })
});
</script>
</body>

</html>
