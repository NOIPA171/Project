<?php

if(!in_array($pagePrm, $arrGetInfo['permissions'])){
    if($pagePrm !== 'all'){
        echo "您沒有權限瀏覽此頁面";
        exit();
    }
}