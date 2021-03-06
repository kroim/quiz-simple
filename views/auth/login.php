<?php
if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH."views/partials/head.php");
?>

<body data-sa-theme="10">
<div class="login">

    <!-- Login -->
    <div class="login__block active" id="l-login">
        <div class="login__block__header">
            <i class="zwicon-user-circle"></i>
            Login

            <div class="actions actions--inverse login__block__actions">
                <div class="text-right">
                    <a href="<?php echo $base_url ?>/register">
                        <i class="zwicon-plus"></i> Register
                    </a>
                </div>
            </div>
        </div>

        <form class="login__block__body" id="login_account">
            <div class="form-group">
                <input type="text" class="form-control" id="login_email" placeholder="Email Address" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="login_password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-success">Login</button>
        </form>
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
<script src="<?php echo $base_url; ?>/public/common/js/auth.js"></script>