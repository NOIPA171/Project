<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="img/profile_small.jpg"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"><?php echo $_SESSION['userName'] ?></span>
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
            // echo "<pre>";
            // print_r($arrGetInfo);
            // echo "</pre>";
                function buildMenu($arrGetInfo){
                    $url = "./template/sidemenu.json";
                    $data = file_get_contents($url);
                    $dataObj = json_decode($data);
                    $menuArr = json_decode(json_encode($dataObj), True);

                    // echo "<pre>";
                    // print_r($menuArr);
                    // print_r($menuArr[5]['submenu'][0]);                    
                    // echo "</pre>";

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
                            for($j = 0 ; $j < count($submenu) ; $j++){
                                if(in_array($currentLink, $submenu[$j])){
                                    echo " class='active'";
                                }
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
                        // if(isset($submenu)){
                        //     $flag = false;
                        //     for($j = 0 ; $j < count($submenu) ; $j++){
                        //         if($submenu[$j]['link'] === $currentLink || in_array($currentLink, $submenu[$j])){
                        //             $flag = true;
                        //         }
                        //     }
                        //     if($flag){
                        //         echo " aria-expanded='true'";
                        //     }
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
                            echo "<ul class='nav nav-second-level";
                            $flag = false;
                            for($j = 0 ; $j < count($submenu) ; $j++){
                                if($submenu[$j]['link'] === $currentLink || in_array($currentLink, $submenu[$j])){
                                    $flag = true;
                                }
                            }
                            if($flag){
                                echo " collapse in' aria-expaned='true'";
                            }
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
            <!-- <li>
                <a href="./admin.php"><i class="fa fa-diamond"></i> <span class="nav-label">首頁</span></a>
            </li>
            <li>
                <a data-nav-link="prmV01" href="./products.php"><i class="fa fa-pie-chart"></i> <span class="nav-label">產品</span></a>
            </li>
            <li>
                <a data-nav-link="prmV02" href="./charts.php"><i class="fa fa-flask"></i> <span class="nav-label">報表</span></a>
            </li>
            <li>
                <a data-nav-link="prmV03" href="./marketing.php"><i class="fa fa-flask"></i> <span class="nav-label">行銷</span></a>
            </li>
            <li>
                <a data-nav-link="prmV04" href="./orders.php"><i class="fa fa-flask"></i> <span class="nav-label">訂單</span></a>
            </li>
            <li>
                <a data-nav-link="prmV00" href="#">
                    <i class="fa fa-flask"></i> 
                    <span class="nav-label">工作人員</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                        <li><a href="./staff.php">工作人員一覽</a></li>
                        <li><a href="./staff_add.php">新增</a></li>
                    </ul>
            </li> -->

        </ul>

    </div>
</nav>