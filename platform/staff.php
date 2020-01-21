<?php
    require_once('./checkSession.php');
    require_once('../db.inc.php');
    require_once('./getInfo.php');
    require_once('./checkActive.php');
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
                        </div>
                        <div class="ibox-content">

                            <?php 
                            require_once('./checkVerify.php');
                            require_once('./checkPrm.php');
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

        $("a[data-func='edit']").click(function(){
            var $tds = $(this).closest('td').siblings();
            // var name = $tds.eq(0).text();
            // var email = $tds.eq(1).text();
            var title = $tds.eq(2).text();
            var active = $tds.eq(3).text();
            var permissions = $tds.eq(5).text();
            var notes = $tds.eq(6).text();
            var id = $tds.eq(7).text();

            // var Fname = name.split(' ')[0];
            // var Lname = name.split(' ')[1];
            // modal.find('#firstName').val(Fname);
            // modal.find('#lastName').val(Lname);
            
            //先移除再加上去
            modal.find("#active option").removeAttr('selected');
            modal.find("#active option[value="+active+"]").attr('selected','selected');

            //此人擁有的permissions
            var permissionsArr = permissions.split(', ');
            //需要改動的modal欄位
            var allPrmInputs = modal.find('#permissions').find('input');
            
            var allPrms = [];  //所有的permission
            for(let i = 0 ; i < allPrmInputs.length ; i++){
                allPrms.push(modal.find('#permissions').find('input')[i]['value']);
            }
            
            for(let i = 0 ; i < allPrms.length ; i++){
                var flag = false;
                for(let j = 0 ; j < permissionsArr.length ; j++){
                    if(allPrms[i].indexOf(permissionsArr[j])>=0){
                        flag = true;
                    }
                }
                if(flag){
                    modal.find("#permissions").find('input').eq(i).attr("checked","");
                }else{
                    modal.find("#permissions").find('input').eq(i).removeAttr("checked");
                }
            }
            modal.find("#noteText").text(notes);
            modal.find("#id").val(id);
        })

        $()

    </script>

</body>

</html>
