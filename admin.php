<?php
    require_once('./check/checkPSession.php');
    require_once('./template/tpl-html-head.php');

    require_once('./template/sidenav.php');

    require_once('./template/tpl-content-wrapper.html');
    require_once('./template/topnav.html');

    echo "hello ".$_SESSION['userName'];
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    require_once('./template/footer.html');
    require_once('./template/tpl-content-close.html');



    require_once('./template/tpl-html-foot.php');