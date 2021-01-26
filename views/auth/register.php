<?php
if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH."views/partials/head.php");
?>

<body data-sa-theme="10">
<div class="login">
    <!-- Register -->
    <div class="login__block active" id="l-register">
        <div class="login__block__header">
            <i class="zwicon-user-circle"></i>
            Create an account

            <div class="actions actions--inverse login__block__actions">
                <div class="dropdown">
                    <i data-toggle="dropdown" class="zwicon-more-h actions__item"></i>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?php echo $base_url ?>/login">Already have an account?</a>
                        <a class="dropdown-item" href="<?php echo $base_url ?>/forgot-password">Forgot password?</a>
                    </div>
                </div>
            </div>
        </div>

        <form class="login__block__body" id="register_account">
            <div class="form-group">
                <input type="text" class="form-control" id="register_name" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="register_email" placeholder="Email Address">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="register_password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="register_confirm_password" placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <select class="form-control page-select" id="register_role">
                    <option value="Teacher">Teacher</option>
                    <option value="Student">Student</option>
                </select>
            </div>

            <button type="submit" class="btn btn-theme btn--icon"><i class="zwicon-checkmark"></i></button>
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