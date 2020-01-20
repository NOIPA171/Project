<?php
    require_once('./check/checkSession.php');
    require_once('../db.inc.php');
    require_once('./check/getInfo.php');
    require_once('./check/checkActive.php');
    $pagePrm = 'prmA00';
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
                        <?php require_once('./check/checkPrm.php'); ?>
                        <form method="post" action="./check/check_staff_add.php">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    基本資訊 <br>
                                    <small class="text-muted">寄信邀請新人員一起管理您的後台。</small>
                                </label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6 m-b"><input type="text" name="Lname" placeholder="姓 *" class="form-control" required></div>
                                        <div class="col-sm-6 m-b"><input type="text" name="Fname" placeholder="名 *" class="form-control" required></div>
                                        <div class="col-md-12 m-b"><input type="email" name ="email" placeholder="Email *" class="form-control" required></div>
                                        <div class="col-md-12 m-b"><input type="text" name ="notes" placeholder="備註" class="form-control"></div>  
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="i-checks mt-2">
                                                        <label id="staff"> 
                                                            <input type="radio" value="staff" name="title" checked> 
                                                            <i></i> 賦予工作人員權限 
                                                            <small class="text-muted"></small>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="i-checks mt-2">
                                                        <label id="owner"> 
                                                            <input type="radio" value="owner" name="title"> 
                                                            <i></i> 賦予管理員權限 <br>
                                                            <small class="text-muted" style="margin-left: 1.6rem;">管理所有頁面（包含工作人員管理）</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <hr>
                                            <div class="edit_permissions">
                                                <label class="col-form-label mb-2">編輯權限</label>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" value="vendors" checked="" name="staffPrm[]"> 
                                                    <i></i> 廠商 </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" value="charts" checked="" name="staffPrm[]"> 
                                                    <i></i> 報表 </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" value="users" checked="" name="staffPrm[]"> 
                                                    <i></i> 會員 </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" value="comments" checked="" name="staffPrm[]"> 
                                                    <i></i> 評論 </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm" type="submit">寄送邀請</button>
                                    </div>
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
                
            });
    </script>
</body>

</html>
