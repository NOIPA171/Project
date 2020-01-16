<?php

require_once('./check/checkPSession.php');
require_once('./check/db.inc.php');
require_once('./template/tpl-html-head.php');

require_once('./template/sidenav.php');

require_once('./template/tpl-content-wrapper.html');
require_once('./template/topnav.html');

$flag = false;
for($i = 0 ; $i < count($_SESSION['permission']) ; $i++){
    if($_SESSION['permission'][$i] === 'prmA00'){
        $flag = true;
    }
}
if($flag){
    echo "you are free to pass";
    echo "<br>";
}else{
    echo "you may not pass";
    exit();
}

?>
    WELCOME TO PLATFORM PAGE <br>
    Please enter the following info to allow other staff members to access to your website. <br>
    An email will be sent for verification to the user <br>

    <div class="row animated fadeInRight">
                <div class="col-lg-12">
                    <div class="ibox p-md">
                        <!-- <div class="ibox-title">
                            <h5>All form elements <small>With custom checbox and radion elements.</small></h5>
                            <div class="ibox-tools">
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
                            </div>
                        </div> -->
                        <div class="ibox-content">
                            <form action="./addPlatformAdmin" method="post">
                                 <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" placeholder="Name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" placeholder="Email" class="form-control">
                                </div>
                                <h5>選擇權限</h5>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="inlineCheckbox1" value="owner" name="permission">
                                    <label class="form-check-label" for="inlineCheckbox1">管理員</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="inlineCheckbox2" value="allAccess" name="permission">
                                    <label class="form-check-label" for="inlineCheckbox2">工作人員</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<?php
require_once('./template/footer.html');
require_once('./template/tpl-content-close.html');

require_once('./template/tpl-html-foot.php');
?>