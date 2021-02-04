<?php if(!defined('PREPEND_PATH')) define('PREPEND_PATH', ''); ?>
<div class="page-loader">
    <div class="page-loader__spinner">
        <svg viewBox="25 25 50 50">
            <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
</div>
<style>
    .top-nav>li>a:not(.header__nav__text) {
        padding: .6rem 1rem;
    }
    .top-nav label {
        padding-left: 5px;
        text-transform: uppercase;
    }
</style>

<header class="header">
    <div class="navigation-trigger d-xl-none" data-sa-action="aside-open" data-sa-target=".sidebar">
        <i class="zwicon-hamburger-menu"></i>
    </div>

    <div class="logo d-sm-inline-flex">
        <a href="<?php echo $base_url; ?>" style="font-size: 20px; padding-left: 45px;">Quiz-Juliano</a>
    </div>

    <ul class="top-nav">
        <li class="d-none d-sm-inline-block">
            <a href="<?php echo $base_url; ?>/logout">
                <i class="zwicon-sign-out"></i><label>Logout</label>
            </a>
        </li>
        <div class="clock d-none d-md-inline-block" id="test_down_clock" style="display: none;">
            <div class="time">
                <span class="test__hours">00</span>
                <span class="test__min">00</span>
                <span class="test__sec">00</span>
            </div>
        </div>
    </ul>

</header>

