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
            <li>
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
            </li>

        </ul>

    </div>
</nav>