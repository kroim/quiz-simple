<html>
<?php
if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH."views/partials/head.php");
include(PREPEND_PATH."views/partials/header.php");
?>

<body data-sa-theme="10">
<?php include(PREPEND_PATH."views/partials/sidebar.php"); ?>
<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>My Account</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card profile">
                            <div class="profile__img">
                                <img src="{{ url(Auth::user()->avatar) }}" alt="Profile Avatar" id="profile_avatar">
                                <a href="javascript:" class="zwicon-camera profile__img__edit" onclick="$('#crop-image-modal').modal()"></a>
                            </div>

                            <div class="profile__info">
                                <ul class="icon-list">
                                    <li><i class="zwicon-user-circle"></i> {{ Auth::user()->name }}</li>
                                    <li><i class="zwicon-mail"></i> {{ Auth::user()->email }}</li>
                                    <li><i class="zwicon-password"></i> {{ (Auth::user()->role == 1)?'Administrator':((Auth::user()->role == 2)?'Teacher':'Student') }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" id="profile_name" class="form-control" value="{{ Auth::user()->name }}">
                                </div>
                                <div class="form-group">
                                    <label>Useremail</label>
                                    <input type="text" id="profile_email" class="form-control" value="{{ Auth::user()->email }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('global.common.description') }}</label>
                                    <textarea class="form-control" id="profile_description" rows="4">{{ Auth::user()->description }}</textarea>
                                </div>

                                <div class="form-group" style="text-align: center">
                                    <button class="btn btn-outline-warning" onclick="changeProfile()">{{ __('global.common.change').' '.__('global.common.profile') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('global.common.current').' '.__('global.common.password') }}*</label>
                                    <input type="password" id="profile_old_password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('global.common.new').' '.__('global.common.password') }}*</label>
                                    <input type="password" class="form-control" id="profile_new_password">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('global.common.confirm_password') }}*</label>
                                    <input type="password" class="form-control" id="profile_confirm_password">
                                </div>
                                <div class="form-group" style="text-align: center">
                                    <button class="btn btn-outline-danger" onclick="changePassword()">{{ __('global.common.change').' '.__('global.common.password') }}</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<?php include(PREPEND_PATH."views/partials/footer.php"); ?>
<?php include(PREPEND_PATH."views/partials/foot.php"); ?>
</body>
</html>
