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

    <title>INSPINIA | FooTable</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- FooTable -->
    <link href="../css/plugins/footable/footable.core.css" rel="stylesheet">

    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
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
                    <h2>FooTable</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Tables</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>FooTable</strong>
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
                            <h5>FooTable with row toggler, sorting and pagination</h5>

                            <!-- <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#" class="dropdown-item">Config option 1</a>
                                    </li>
                                    <li><a href="#" class="dropdown-item">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div> -->
                        </div>
                        <div class="ibox-content">

                            <?php 
                            require_once('./check/checkPrm.php');
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
