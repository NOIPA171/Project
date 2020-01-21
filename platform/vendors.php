<?php
    require_once('./checkSession.php');
    require_once('../db.inc.php');
    require_once('./getInfo.php');
    require_once('./checkActive.php');
    $pagePrm = 'prmA01';
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>廠商</title></title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- FooTable -->
    <link href="../css/plugins/footable/footable.core.css" rel="stylesheet">

    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/myStyle.css" rel="stylesheet">
    <style>
        .footable > thead > tr > th[data-sortable="false"]{
            pointer-events: none;
        }
        .footable > thead > tr > th[data-sortable="false"] > span.footable-sort-indicator:before{
            display: none;
        }
        .footable-row-detail-inner{
            width: 100%;
        }
        tr.footable-odd + tr.footable-row-detail{
            background-color: #f7f7f7;
        }
        
    </style>
</head>

<body>

    <div id="wrapper">

    <?php require_once('./template/sidenav.php') ?>

        <div id="page-wrapper" class="gray-bg">
        
        <?php require_once('./template/topnav.php') ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>廠商</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="./admin.php">首頁</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>廠商</a>
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
                            <h5>廠商資訊</h5>
                        </div>
                        <div class="ibox-content">

                            <?php 
                            require_once('./checkVerify.php');
                            require_once('./checkVerifyEcho.php');
                            require_once('./checkPrm.php');
                            require_once('./contents/vendorList.php'); 
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once('./template/footer.php') ?>

        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- FooTable -->
    <script src="../js/plugins/footable/footable.all.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../js/inspinia.js"></script>
    <script src="../js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();
        });

        $("a[data-func='ban']").click(function(){
            return confirm("確定要將此廠商停用？");
        });
        $("a[data-func='activate']").click(function(){
            return confirm("確定要將此廠商啟用？");
        });


    </script>

</body>

</html>
