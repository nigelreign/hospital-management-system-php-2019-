<div id="kt_header" class="header header-fixed">
    <div class="container-fluid">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div class="header-logo mr-10 d-none d-lg-flex">
                <a href="./">
                    <img alt="Logo"
                         src="../../assets/images/patient.png"
                         class="h-40px"/>
                </a>
            </div>
            <div id="kt_header_menu"
                 class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
                <ul class="menu-nav">
                    <li class="menu-item menu-item-active" aria-haspopup="true">
                        <a href="./" class="menu-link">
                            <span class="menu-text"><? echo strtoupper($_SESSION['role']) ?> DASHBOARD</span>
                        </a>
                    </li>
                    <? if ($_SESSION['role'] == 'admin') { ?>
                        <li class="menu-item menu-item-active" aria-haspopup="true">
                            <a href="manage-users" class="menu-link">
                                <span class="menu-text">Manage Users</span>
                            </a>
                        </li>
                        <? } if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'nurse'){ ?>
                            <li class="menu-item menu-item-active" aria-haspopup="true">
                                <a href="manage-wards" class="menu-link">
                                    <span class="menu-text">Manage Wards</span>
                                </a>
                            </li>
                        <? } ?>
                        <li class="menu-item menu-item-active" aria-haspopup="true">
                            <a href="manage-patients" class="menu-link">
                                <span class="menu-text">Manage Patients</span>
                            </a>
                        </li>
                    <li class="menu-item" aria-haspopup="true">
                        <a href="../../signout" class="btn btn-danger">
                            <span class="menu-text">Logout</span>
                            <span class="menu-desc"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>