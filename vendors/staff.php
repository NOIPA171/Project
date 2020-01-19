<?php
    require_once('./check/checkSession.php');
    require_once('../db.inc.php');
    require_once('./check/getInfo.php');
    require_once('./check/checkActive.php');
    $pagePrm = 'prmV00';
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

        var $modal = $('#editor-modal'),
	$editor = $('#editor'),
	$editorTitle = $('#editor-title'),
	// the below initializes FooTable and returns the created instance for later use
	ft = FooTable.init('#editing-example', {
		editing: {
			enabled: true,
			addRow: ...,
			editRow: ...,
			deleteRow: ...
		}
	}),
	// this example does not send data to the server so this variable holds the integer to use as an id for newly
	// generated rows. In production this value would be returned from the server upon a successful ajax call.
    uid = 10;
    

    editRow: function(row){
	var values = row.val();
	// we need to find and set the initial value for the editor inputs
	$editor.find('#id').val(values.id);
	$editor.find('#firstName').val(values.firstName);
	$editor.find('#lastName').val(values.lastName);
	$editor.find('#jobTitle').val(values.jobTitle);
	$editor.find('#startedOn').val(values.startedOn.format('YYYY-MM-DD'));
	$editor.find('#dob').val(values.dob.format('YYYY-MM-DD'));

	$modal.data('row', row); // set the row data value for use later
	$editorTitle.text('Edit row #' + values.id); // set the modal title
	$modal.modal('show'); // display the modal
}

// the deleteRow callback is supplied the FooTable.Row object for deleting as the first argument.
deleteRow: function(row){
	// This example displays a confirm popup and then simply removes the row but you could just
	// as easily make an ajax call and then only remove the row once you retrieve a response.
	if (confirm('Are you sure you want to delete the row?')){
		row.delete();
	}
}

$editor.on('submit', function(e){
	if (this.checkValidity && !this.checkValidity()) return; // if validation fails exit early and do nothing.
	e.preventDefault(); // stop the default post back from a form submit
	var row = $modal.data('row'), // get any previously stored row object
		values = { // create a hash of the editor row values
			id: $editor.find('#id').val(),
			firstName: $editor.find('#firstName').val(),
			lastName: $editor.find('#lastName').val(),
			jobTitle: $editor.find('#jobTitle').val(),
			startedOn: moment($editor.find('#startedOn').val(), 'YYYY-MM-DD'),
			dob: moment($editor.find('#dob').val(), 'YYYY-MM-DD')
		};

	if (row instanceof FooTable.Row){ // if we have a row object then this is an edit operation
		// here you can execute an ajax call to the server and then only update the row once the result is
		// retrieved. This example simply updates the row straight away.
		row.val(values);
	} else { // otherwise this is an add operation
		// here you can execute an ajax call to the server to save the values and get the new row id and then
		// only add the row once the result is retrieved. This example simply adds the row straight away using
		// a basic integer id.
		values.id = uid++;
		ft.rows.add(values);
	}
	$modal.modal('hide');
});

    </script>

</body>

</html>
