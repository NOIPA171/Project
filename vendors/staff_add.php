<?php
    require_once('./checkSession.php');
    require_once('../db.inc.php');
    require_once('./getInfo.php');
    require_once('./checkActive.php');
    $pagePrm = 'prmV00';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Basic Form</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/myStyle.css" rel="stylesheet">

    <link href="../css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

    <?php require_once('./template/sidenav.php') ?>

        <div id="page-wrapper" class="gray-bg">
            <?php require_once('./template/topnav.php') ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>新增人員</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="./admin.php">首頁</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>設定</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>新增人員</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>All form elements <small>With custom checbox and radion elements.</small></h5>
                        </div>
                    <div class="ibox-content">

                    <?php
                    require_once('./checkPrm.php');
                    require_once('./checkVerify.php');
                    require_once('./checkVerifyEcho.php');
                    require_once('./contents/staffAdd.php');
                    ?>

                    </div>
                </div>
            </div>
        </div>


    </div>
        <?php require_once('./template/footer.php'); ?>

    </div>


    <!-- Mainly scripts -->
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../js/inspinia.js"></script>
    <script src="../js/plugins/pace/pace.min.js"></script>

    <!-- iCheck -->
    <script src="../js/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

                //自己加的
                $('.edit_permissions').hide();

                if($(".iradio_square-green:last-child").hasClass('checked')){
                    $('.edit_permissions').hide();
                }else{
                    $('.edit_permissions').show();
                }
            
                $("#staff, #staff ins").click(function(){
                    $('.edit_permissions').show(300);
                });
                $("#owner, #owner ins").click(function(){
                    $('.edit_permissions').hide(300);
                })


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
                        url: "./check_staff_add.php",
                        type: "post",
                        data: serializedData
                    });

                    request.done(function (response, textStatus, jqXHR){
                        if(response == 'success'){
                            window.location = "./staff.php";
                        }else{
                            $("#message").text(response);
                        };
                    });

                    request.fail(function (jqXHR, textStatus, errorThrown){
                        // Log the error to the console
                        console.error(
                            "The following error occurred: "+
                            textStatus, errorThrown
                        );
                    });

                    // Callback handler that will be called regardless
                    // if the request failed or succeeded
                    request.always(function () {
                        // Reenable the inputs
                        $inputs.prop("disabled", false);
                    });
                })
                
            });
    </script>
</body>

</html>
