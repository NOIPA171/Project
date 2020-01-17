<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="img/profile_small.jpg"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"><?php echo $arrGetInfo['aFName'].' '.$arrGetInfo['aLName'] ?></span>
                        <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                        <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                        <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
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
                    $currentLink = str_replace("/Project/platform", ".", $_SERVER['SCRIPT_NAME']);

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
                        }else if(isset($submenu)){
                            echo " href='#'";
                        }
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
                            echo "<ul class='nav nav-second-level";
                            //好像會自動處理這段
                            // $flag = false;
                            // for($j = 0 ; $j < count($submenu) ; $j++){
                            //     if($submenu[$j]['link'] === $currentLink || in_array($currentLink, $submenu[$j])){
                            //         $flag = true;
                            //     }
                            // }
                            // if($flag){
                            //     echo " collapse in' aria-expaned='true";
                            // }
                            echo "'>";
                            for($j = 0 ; $j < count($submenu) ; $j++){
                                echo "<li";
                                //若目前頁面為該li的連結，加上active
                                if($submenu[$j]['link'] === $currentLink){
                                    echo " class='active'";
                                }
                                echo ">";
                                echo "<a";
                                if(in_array($submenu[$j]['permission'], $arrGetInfo['permissions'])){
                                    echo " href='".$submenu[$j]['link']."'";
                                }else if($submenu[$j]['permission'] === "all"){
                                    echo " href='#'";
                                }
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