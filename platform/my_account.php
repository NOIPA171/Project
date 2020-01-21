<?php
    require_once('./checkSession.php');
    require_once('../db.inc.php');
    require_once('./getInfo.php');
    require_once('./checkActive.php');
    $pagePrm = "all";
?>



<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>我的帳號</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

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
                            <h5>邀請新人員一起管理您的後台</h5>
                    </div>
                    <div class="ibox-content">
                        <?php 
                        require_once('./checkVerify.php');
                        require_once('./checkPrm.php'); 
                        ?>
                        <form method="post" action="./check_my_account.php">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    基本資訊 <br>
                                    <!-- <small class="text-muted">寄信邀請新人員一起管理您的後台。</small> -->
                                </label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6 m-b">
                                            <input type="text" name="Lname" placeholder="姓 *" class="form-control" required value="<?php echo $arrGetInfo['aLName'] ?>">
                                        </div>
                                        <div class="col-sm-6 m-b">
                                            <input type="text" name="Fname" placeholder="名 *" class="form-control" required value="<?php echo $arrGetInfo['aFName'] ?>">
                                        </div>
                                        <div class="col-md-12 m-b">
                                            <input type="email" name ="email" placeholder="Email *" class="form-control" required value="<?php echo $arrGetInfo['aEmail'] ?>">
                                        </div>
                                        <div class="col-md-12 m-b">
                                            <input type="text" name ="notes" placeholder="備註" class="form-control" value="<?php echo $arrGetInfo['aNotes'] ?>">
                                        </div>  
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    安全資訊 <br>
                                </label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-4 m-b">
                                            <a href="./my_account_password.php">
                                                <button id="changepwd" class="btn btn-w-m btn-default" type="button">更改密碼</button>
                                            </a>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm" type="submit">更改</button>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-2">
                                    <small id="message" class="text-navy"></small>
                                </div>
                            </form>
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
                        url: "./check_my_account.php",
                        type: "post",
                        data: serializedData
                    });

                    request.done(function (response, textStatus, jqXHR){
                        if(response == 'success'){
                            $("#message").text('更新成功!');
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
                });

            });

            //好麻煩，先註解掉
            
            // $('#changepwd').click(function(){
            //     var $parent = $(this).parent('div');
            //     var inputHtml = "<input type='text' name='checkpwd' class='form-control' placeholder='請輸入目前的密碼確認' id='checkpwd'>";
            //     var buttonHtml = "<button class='btn btn-w-m btn-default' id='confirmpwd'>確認</button>";
            //     var msgHtml = "<div class='mt-2'><small id='message' class='text-warning'></small></div>";

            //     var $submit = $('button[type="submit"]')

            //     $parent.html(inputHtml+"<br>"+buttonHtml+"<br>"+msgHtml);

            //     $submit.prop("disabled", true);

            //     $('form').attr('action','./check_my_account_password.php');

            // })

            // $("#confirmpwd").on("submit", $(this), function(events){
            //     events.preventDefault();
            //     var data = $("#checkpwd").val();

            //     $.ajax({
            //         url: "./check_my_account_password.php",
            //         type: "post",
            //         data: "pwd="+data
            //     })
            //     .done(function (response, textStatus, jqXHR){
            //         if(response == 'success'){
            //             console.log("yes");
            //         }else{
            //             $("#message").text(response);
            //         };
            //     })
            //     .fail(function (jqXHR, textStatus, errorThrown){
            //         console.error(
            //             "The following error occurred: "+
            //             textStatus, errorThrown
            //         );
            //     })
            // })
    </script>
</body>

</html>
