<?php

require_once('./check/checkSession.php');
require_once('../db.inc.php');
require_once('./check/getInfo.php');


?>

<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Platform</title>

<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

<link href="../css/animate.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">

</head>

<body>

<div id="wrapper">
    <!-- 左側選單 -->
    <?php require_once('./template/sidenav.php') ?>
    <!-- Body -->
    <div id="page-wrapper" class="gray-bg">
        <!-- 上側選單 -->
        <?php require_once('./template/topnav.php') ?>
        <!-- 標題 -->
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-9">
                <h2>Platform Page</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        Extra Pages
                    </li>
                    <li class="breadcrumb-item active">
                        <strong> Search Page</strong>
                    </li>
                </ol>
            </div>
        </div>
        <!-- 內文 -->
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <div class="footer">
        <div class="float-right">
            10GB of <strong>250GB</strong> Free.
        </div>
        <div>
            <strong>Copyright</strong> Example Company &copy; 2014-2018
        </div>
    </div>

</div>
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


</body>

</html>