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

    <title><?php echo $arrGetInfo['vName'] ?></title>

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
                            <a href="index.html">首頁</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>設定</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>你的團隊</strong>
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
                            <h5>瀏覽/修改團員資訊</h5>
                        </div>
                        <div class="ibox-content">

                            <?php 
                            require_once('./checkPrm.php');
                            require_once('./checkVerify.php');
                            require_once('./checkVerifyEcho.php');
                            require_once('./contents/staffList.php'); 
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

        $("a[data-func='delete']").on('click', $(this), function(event){
            event.preventDefault();
            var el = $(this).parents('tr');
            var id = $(this).attr("data-id");
            
            var answer = confirm("確定要刪除該使用者？");
            if(answer == true){
                data = $(this).attr("data-id");
                $.ajax({
                    url: "./check_staff_delete.php",
                    type: "post",
                    data: "id="+id
                })
                .done(function(response, textStatus, jqXHR){
                    if(response == 'success'){
                        el.remove();
                        $('#edit-table tr[class="footable-even"]').attr('class','footable-odd');
                        $('#edit-table tr[class="footable-odd"]').attr('class','footable-even');
                        
                    }else{
                        console.log(response);
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown){
                    console.error(
                        "The following error occurred: "+
                        textStatus, errorThrown
                    );
                });
            }else{
                console.log("no");
            }
        });

        //自己加的
        //modal for edit
        var modal = $('#editor-modal');
        var table = $('#edit-table');
        
        // var edit = $("a[data-func='edit']");
        $("a[data-func='edit']").on('click', function(){
            let vaId = $(this).data("id");
            $.ajax({
                url : "./check_staff_edit_current.php",
                type: "post",
                data: "vaId="+vaId
            })
            .done(function(response){
                response = JSON.parse(response);
                console.log(response);
                $("#editor-title span").text(response.vaFName+" "+response.vaLName);
                $("#editor-modal #active").find(":select");
            })
            .fail(function(err){
                console.log(JSON.stringify(err));
            })
            .always(function(){
                console.log("ajax complete");
            })
        })

var request;

var $rows = $("#edit-table tbody").find('tr');
var row = getId($rows);

// $("#edit-table tbody").find('tr').eq(1).hide();

$("#mysqlFilter").on('keyup', $(this), function(event){
    event.preventDefault();

    if (request) {
        request.abort();
    }
    var input = $(this).val();

    request = $.ajax({
        url: "./check_staff_filter.php",
        type: "post",
        data: input
    });

    request.done(function (response, textStatus, jqXHR){

        console.log(row);
        if($("#mysqlFilter").val()==''){
            $("#edit-table tbody").find('tr').show();
        }else if(response !== ''){
            var r = JSON.parse(response);

            //看看有沒有對上的id，有則show，無則hide
            var flag = false;
            for(var i = 0 ; i < row.length ; i++){
                for(var j = 0 ; j < r.length ; j++){
                    if(row[i] == r[j]){
                        flag = true;
                    }
                }
                if(flag){
                    $("#edit-table tbody").find('tr').eq(i).show();
                }else if(!flag){
                    $("#edit-table tbody").find('tr').eq(i).hide();
                }
            }       
        }else{
            $("#edit-table tbody").find('tr').hide();
        }
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
    });
})


function getId($el){
    var results = [];
    for(var i = 0 ; i < $el.length ; i++){
        if($el.eq(i).attr('id') !== undefined){
            var id = $el.eq(i).attr('id').replace('vaId','');
            results.push(parseInt(id));
        }
    }
    return results;
}
    </script>

</body>

</html>
