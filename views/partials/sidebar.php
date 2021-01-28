<?php ?>
<aside class="sidebar ">
    <div class="scrollbar">
        <div class="user">
            <div class="user__info">
                <img class="user__img" src="<?php echo $base_url . $_SESSION['user_avatar'] ?>" alt="avatar">
                <div style="word-break: break-all">
                    <div class="user__name"><?php echo $_SESSION['user_name'] ?></div>
                    <div class="user__email"><?php echo $_SESSION['user_email'] ?></div>
                </div>
            </div>
        </div>
        <ul class="navigation">

            <li class="<?php if ($sidebar->menu == "dashboard") echo 'navigation__active'; ?>">
                <a href="<?php echo $base_url; ?>"><i class="zwicon-home"></i> Dashboard</a>
            </li>
            <?php if ($_SESSION['user_role'] == 1) { ?>
                <li class="navigation__sub <?php if ($sidebar->menu == "user_management") echo 'navigation__sub--active'; ?>">
                    <a href="javascript:"><i class="zwicon-users"></i> Management <i class="zwicon-arrow-down"></i></a>
                    <ul>
                        <li class="<?php if ($sidebar->sub_menu == "user-role") echo 'navigation__active'; ?>">
                            <a href="<?php echo $base_url; ?>/user-role"> Users</a>
                        </li>
                        <li class="<?php if ($sidebar->sub_menu == "user-categories") echo 'navigation__active'; ?>">
                            <a href="<?php echo $base_url; ?>/user-categories"> Categories</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <li class="<?php if ($sidebar->menu == "account") echo 'navigation__active'; ?>">
                <a href="<?php echo $base_url; ?>/account"><i class="zwicon-user-circle"></i> Account</a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/logout"><i class="zwicon-arrow-circle-right"></i> Logout</a>
            </li>
        </ul>
    </div>
</aside>
