<?php

require_once('./check/checkSession.php');
require_once('./check/db.inc.php');
require_once('./template/tpl-html-head.php');

require_once('./template/sidenav.php');

require_once('./template/tpl-content-wrapper.html');
require_once('./template/topnav.html');

$flag = false;
for($i = 0 ; $i < count($_SESSION['permission']) ; $i++){
    if($_SESSION['permission'][$i] === 'prmA01'){
        $flag = true;
    }
}
if($flag){
    echo "you are free to pass";
}else{
    echo "you may not pass";
    exit();
}
?>

WELCOME TO VENDORS PAGE
<?php
require_once('./template/footer.html');
require_once('./template/tpl-content-close.html');

require_once('./template/tpl-html-foot.php');
?>