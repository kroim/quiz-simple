<?php
if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH."views/partials/head.php");
?>

<body data-sa-theme="10">
<div class="login">
    <!-- Forgot Password -->
    <div class="login__block active" id="l-forget-password">
        <div class="login__block__header">
            <i class="zwicon-user-circle"></i>
            Reset Your Password
            <div class="actions actions--inverse login__block__actions">
                <div class="dropdown">
                    <i data-toggle="dropdown" class="zwicon-more-h actions__item"></i>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?php echo $base_url ?>/login">Remember password?</a>
                        <a class="dropdown-item" href="<?php echo $base_url ?>/register">Create an account</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="login__block__body">
            <div class="form-group">
                <input type="password" class="form-control text-center" placeholder="New Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control text-center" placeholder="Confirm Password">
            </div>
            <button type="button" onclick="alert('Coming soon ...')" class="btn btn-theme btn--icon"><i class="zwicon-checkmark"></i></button>
        </div>
    </div>
</div>
<?php include(PREPEND_PATH."views/partials/footer.php"); ?>
<?php include(PREPEND_PATH."views/partials/foot.php"); ?>
<script>
    let auth_messages = [
        "Name is required.",  // 0
        "Name is already exist.",  // 1
        "Email is required.",  // 2
        "Email is not valid.",  // 3
        "Email is already exist.",  // 4
        "Password is required.",  // 5
        "Password is wrong.",  // 6
        "Password should be more than 6 characters.",  // 7
        "Confirm password is required.",  // 8
        "Confirm password is not matched."  // 9
    ]
</script>
<script src="<?php echo PREPEND_PATH; ?>public/common/js/auth.js"></script>