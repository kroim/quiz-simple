$('#register_account').on('submit', function (e) {
    e.preventDefault();
    let base_url = $('meta[name="_base_url"]').attr('content');
    let url = base_url + '/register';
    let register_name = $('#register_name').val();
    if (register_name === '') {
        customAlert(auth_messages[0]);
        return;
    }
    let register_email = $('#register_email').val();
    if (register_email === '') {
        customAlert(auth_messages[2]);
        return;
    }
    if (register_email.indexOf('@') < 0) {
        customAlert(auth_messages[3]);
        return;
    }
    let register_password = $('#register_password').val();
    if (register_password === '') {
        customAlert(auth_messages[5]);
        return;
    }
    if (register_password.length < 6) {
        customAlert(auth_messages[7]);
        return;
    }
    let register_confirm_password = $('#register_confirm_password').val();
    if (register_confirm_password === '') {
        customAlert(auth_messages[8]);
        return;
    }
    if (register_password !== register_confirm_password) {
        customAlert(auth_messages[9]);
        return;
    }
    let register_role = $('#register_role').val();
    let data = {
        name: register_name,
        email: register_email,
        password: register_password,
        role: register_role
    };
    $.ajax({
        url: url,
        method: 'post',
        data: data,
        success: function (res) {
            res = JSON.parse(res);
            if (res.status === 'success') {
                customAlert(res.message, true);
                setTimeout(function () {
                    location.href = base_url + "/login";
                }, 2500)
            } else customAlert(res.message);
        }
    })
});
$('#login_account').on('submit', function (e) {
    e.preventDefault();
    let base_url = $('meta[name="_base_url"]').attr('content');
    let url = base_url + '/login';
    let login_email = $('#login_email').val();
    if (login_email === '') {
        customAlert(auth_messages[2]);
        return;
    }
    if (login_email.indexOf('@') < 0) {
        customAlert(auth_messages[3]);
        return;
    }
    let login_password = $('#login_password').val();
    if (login_password === '') {
        customAlert(auth_messages[5]);
        return;
    }
    let data = {
        email: login_email,
        password: login_password
    };
    $.ajax({
        url: url,
        method: 'post',
        data: data,
        success: function (res) {
            res = JSON.parse(res);
            if (res.status === 'success') {
                customAlert(res.message, true);
                setTimeout(function () {
                    location.href = base_url;
                }, 2000);
            } else customAlert(res.message);
        }
    })
});
$('#forgot_password_account').on('submit', function (e) {
    e.preventDefault();
    let forgot_email = $('#forgot_password_account input[type="email"]').val();
    if (!validateEmail(forgot_email)) {
        customAlert(auth_messages[3]);
        return;
    }
    let _token = $('#forgot_password_account input[name="_token"]').val();
    console.log(forgot_email, _token);
});
