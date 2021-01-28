<html>
<?php
if (!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH . "views/partials/head.php");
include(PREPEND_PATH . "views/partials/header.php");
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>/public/common/croppie/croppie.css" type="text/css">
<body data-sa-theme="10">
<?php include(PREPEND_PATH . "views/partials/sidebar.php"); ?>
<section class="content">
    <header class="content__title">
        <h1>My Account</h1>
    </header>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card profile">
                        <div class="profile__img">
                            <img src="<?php echo $base_url . $_SESSION['user_avatar'] ?>" alt="Profile Avatar" id="profile_avatar">
                            <a href="javascript:" class="zwicon-camera profile__img__edit" onclick="$('#crop-image-modal').modal()"></a>
                        </div>

                        <div class="profile__info">
                            <ul class="icon-list">
                                <li><i class="zwicon-user-circle"></i> <?php echo $_SESSION['user_name'] ?></li>
                                <li><i class="zwicon-mail"></i> <?php echo $_SESSION['user_email'] ?></li>
                                <li>
                                    <i class="zwicon-password"></i>
                                    <?php if ($_SESSION['user_role'] == 1) echo "Administrator";
                                    elseif ($_SESSION['user_role'] == 2) echo "Teacher";
                                    else echo "Student"; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" id="profile_name" class="form-control" value="<?php echo $_SESSION['user_name'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Useremail</label>
                                <input type="text" id="profile_email" class="form-control" value="<?php echo $_SESSION['user_email'] ?>">
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" id="profile_description" rows="4"><?php echo $_SESSION['user_description'] ?></textarea>
                            </div>

                            <div class="form-group" style="text-align: center">
                                <button class="btn btn-outline-warning" onclick="changeProfile()">Change Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Current Password*</label>
                                <input type="password" id="profile_old_password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>New Password*</label>
                                <input type="password" class="form-control" id="profile_new_password">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password*</label>
                                <input type="password" class="form-control" id="profile_confirm_password">
                            </div>
                            <div class="form-group" style="text-align: center">
                                <button class="btn btn-outline-danger" onclick="changePassword()">Change Password</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>
<!-- Crop Image Modal -->
<div id="crop-image-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 style="text-align: center">Profile Photo</h3>
                <div class="form-group">
                    <div id="upload-origin" style="width:100%;"></div>
                </div>
                <input type="file" id="upload-crop" style="display:none;" accept="image/*"/>
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-primary form-control" onclick="$('#upload-crop').click();">Select</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary form-control" data-dismiss="modal" onclick="uploadCropImg()">Crop</button>
                    </div>
                </div>
            </div><!-- end modal-bpdy -->
        </div><!-- end modal-content -->
    </div><!-- end modal-dialog -->
</div>
<?php include(PREPEND_PATH . "views/partials/footer.php"); ?>
<?php include(PREPEND_PATH . "views/partials/foot.php"); ?>
<script type="text/javascript" src="<?php echo $base_url; ?>/public/common/croppie/croppie.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>/public/common/croppie/upload_img.js"></script>
<script>
    function changeProfile() {
        let profile_avatar = $('#profile_avatar').attr('src');
        let profile_name = $('#profile_name').val();
        if (profile_name === "") {
            customAlert("Username is required");
            return;
        }
        let profile_email = $('#profile_email').val();
        if (profile_email === "") {
            customAlert("Useremail is required");
            return;
        }
        let profile_description = $('#profile_description').val();

        let url = '<?php echo $base_url; ?>/account';
        let data = {
            action: "change_profile",
            avatar: profile_avatar,
            name: profile_name,
            email: profile_email,
            description: profile_description,
        };
        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === 'success') {
                    customAlert(res.message, true);
                }
                else customAlert(res.message);
            }
        })
    }
    function changePassword() {
        let current_password = $('#profile_old_password').val();
        let new_password = $('#profile_new_password').val();
        if (current_password === '' || new_password === '') {
            customAlert("Current password is required");
            return;
        }
        if (new_password.length < 6) {
            customAlert("Password should be at least 6 characters");
            return;
        }
        let confirm_password = $('#profile_confirm_password').val();
        if (new_password !== confirm_password) {
            customAlert("Confirm password is not matched");
            return;
        }
        let url = '<?php echo $base_url; ?>/account';
        let data = {
            action: 'change_password',
            current_password: current_password,
            new_password: new_password
        };
        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === 'success') customAlert(res.message, true);
                else customAlert(res.message);
            }
        })
    }
</script>
</body>
</html>
