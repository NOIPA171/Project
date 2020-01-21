<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                <img 
                    <?php
                        $sql = "SELECT `vImg` FROM `vendors` WHERE `vId` = {$arrGetInfo['vId']}";
                        $img = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
                        if(count($img)>0 && $img['vImg'] !== null){
                            echo 'alt="image" class="rounded-circle navIcon" src="';
                            echo "./images/".$img['vImg'];
                            // echo '"/>';
                            echo '"';
                        }
                    ?>
                    />
                    <a href="./admin.php">
                        <span class="block m-t-xs font-bold"><?php echo $arrGetInfo['vaFName'].' '.$arrGetInfo['vaLName'] ?></span>
                        <span class="text-muted text-xs block">
                            <?php 
                            if($arrGetInfo['vaRoleId']==1){
                                echo "Owner";
                            }else if($arrGetInfo['vaRoleId']==2){
                                echo "Manager";
                            }else{
                                echo "Staff";
                            }
                            ?> 
                        </span>
                    </a>
                </div>
                <div class="logo-element">
                    <img alt="image" class="navIcon navIcon-s" src="
                    <?php
                        $sql = "SELECT `vImg` FROM `vendors` WHERE `vId` = {$arrGetInfo['vId']}";
                        $img = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
                        if(count($img)>0){
                            echo "./images/".$img['vImg'];
                        }
                    ?>
                    "/>
                </div>
            </li>
            <!-- --------menu starts here-------- -->
            <?php

                function buildMenu($arrGetInfo){
                    //取得menu資訊
                    $url = "./template/sidemenu.json";
                    $data = file_get_contents($url);
                    $dataObj = json_decode($data);
                    $menuArr = json_decode(json_encode($dataObj), True);
                    
                    //目前頁面的名稱
                    $currentLink = str_replace("/Project/vendors", ".", $_SERVER['SCRIPT_NAME']);

                    for($i = 0 ; $i < count($menuArr); $i++){
                        //若有子選單，定義 $submenu
                        if(isset($menuArr[$i]['submenu'])){
                            $submenu = $menuArr[$i]['submenu'];
                        }
                        
                        echo "<li";
                        //若目前頁面為該li的連結，或者子選單的連結，則加上active
                        if($menuArr[$i]['link'] === $currentLink){
                            echo " class='active'";
                        }else if(isset($submenu)){
                            $flag = false;
                            for($j = 0 ; $j < count($submenu) ; $j++){
                                if(in_array($currentLink, $submenu[$j])){
                                    $flag = true;
                                }
                            }
                            if($flag){
                                echo " class='active'";
                            }
                        }
                        echo ">";
                        echo "<a";
                        //若有權限，則加上href
                        if(in_array($menuArr[$i]['permission'], $arrGetInfo['permissions']) || $menuArr[$i]['permission'] === "all"){
                            echo " href='".$menuArr[$i]['link']."'";
                        }else if(isset($submenu) && in_array($menuArr[$i]['permission'], $arrGetInfo['permissions'])){
                            echo " href='#'";
                        }
                        // else{
                        //     echo " style='pointer-events:none;'";
                        // }
                        echo ">";
                        echo "<i class='fa ".$menuArr[$i]['icon']."'></i>";
                        echo "<span class='nav-label'>";
                        echo $menuArr[$i]['name'];
                        echo "</span>";
                        //若有子選單，則加上箭頭
                        if(isset($submenu)){
                            echo "<span class='fa arrow'></span>";
                        }
                        echo "</a>";
                        //加入子選單
                        if(isset($submenu)){
                            echo "<ul class='nav nav-second-level'>";
                            for($j = 0 ; $j < count($submenu) ; $j++){
                                echo "<li";
                                //若目前頁面為該li的連結，加上active
                                if($submenu[$j]['link'] === $currentLink){
                                    echo " class='active'";
                                }
                                echo ">";
                                echo "<a";
                                if(in_array($submenu[$j]['permission'], $arrGetInfo['permissions']) || $submenu[$j]['permission'] === "all"){
                                    echo " href='".$submenu[$j]['link']."'";
                                }
                                // else{
                                //     echo " style='pointer-events:none;'";
                                // }
                                echo ">";
                                echo "<i class='fa ".$submenu[$j]['icon']."'></i>";
                                echo "<span class='nav-label'>";
                                echo $submenu[$j]['name'];
                                echo "</span>";
                                echo "</a>";
                                echo "</li>";
                            }
                            echo "</ul>";
                            echo "</li>";
                        }
                    }
                }
                buildMenu($arrGetInfo);
            ?>
        </ul>

    </div>
</nav>