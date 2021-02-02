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
            <?php if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 2) { ?>
                <li class="navigation__sub <?php if ($sidebar->menu == "questions") echo 'navigation__sub--active'; ?>">
                    <a href="javascript:"><i class="zwicon-info-circle"></i> Questions <i class="zwicon-arrow-down"></i></a>
                    <ul>
                        <li class="<?php if ($sidebar->sub_menu == "questions-all") echo 'navigation__active'; ?>">
                            <a href="<?php echo $base_url; ?>/questions-all"> All questions</a>
                        </li>
                        <li class="<?php if ($sidebar->sub_menu == "questions-own") echo 'navigation__active'; ?>">
                            <a href="<?php echo $base_url; ?>/questions-own"> My questions</a>
                        </li>
                    </ul>
                </li>
                <li class="navigation__sub <?php if ($sidebar->menu == "quizzes") echo 'navigation__sub--active'; ?>">
                    <a href="javascript:"><i class="zwicon-ab-testing"></i> Quizzes <i class="zwicon-arrow-down"></i></a>
                    <ul>
                        <?php if ($_SESSION['user_role'] == 1) { ?>
                            <li class="<?php if ($sidebar->sub_menu == "quizzes-all") echo 'navigation__active'; ?>">
                                <a href="<?php echo $base_url; ?>/quizzes-all"> All quizzes</a>
                            </li>
                        <?php } ?>
                        <li class="<?php if ($sidebar->sub_menu == "quizzes-own") echo 'navigation__active'; ?>">
                            <a href="<?php echo $base_url; ?>/quizzes-own"> My quizzes</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($_SESSION['user_role'] == 3) { ?>
                <li class="<?php if ($sidebar->menu == "tests") echo 'navigation__active'; ?>">
                    <a href="<?php echo $base_url; ?>/tests"><i class="zwicon-edit-pencil"></i> Tests</a>
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
