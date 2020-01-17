<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="img/profile_small.jpg"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"><?php echo $_SESSION['userName']; ?></span>
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
                <a data-nav-link="prmA01" href="./vendors.php"><i class="fa fa-pie-chart"></i> <span class="nav-label">廠商</span></a>
            </li>
            <li>
                <a data-nav-link="prmA02" href="./charts.php"><i class="fa fa-flask"></i> <span class="nav-label">報表</span></a>
            </li>
            <li>
                <a data-nav-link="prmA03" href="./users.php"><i class="fa fa-flask"></i> <span class="nav-label">會員</span></a>
            </li>
            <li>
                <a data-nav-link="prmA04" href="./comments.php"><i class="fa fa-flask"></i> <span class="nav-label">評論</span></a>
            </li>
            <li>
                <a data-nav-link="prmA00" href="./platform.php"><i class="fa fa-flask"></i> <span class="nav-label">平台</span></a>
            </li>

        </ul>

    </div>
</nav>