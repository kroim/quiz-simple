<html>
<?php
if (!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH . "views/partials/head.php");
include(PREPEND_PATH . "views/partials/header.php");
?>
<style>
    #users-table th, #users-table td {
        text-align: center;
        font-size: 14px;
    }
</style>
<body data-sa-theme="10">
<?php include(PREPEND_PATH . "views/partials/sidebar.php"); ?>
<section class="content">
    <header class="content__title">
        <h1>Role management</h1>
    </header>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">User management</h4>
            <div class="table-responsive data-table">
                <table id="users-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 10%">Avatar</th>
                        <th style="width: 20%">Name</th>
                        <th style="width: 35%">Email</th>
                        <th style="width: 10%">Role</th>
                        <th style="width: 20%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < count($users); $i++) { ?>
                        <tr id="user_<?php echo $users[$i]['id']; ?>">
                            <td class="user-number"><?php echo $i + 1 ?></td>
                            <td class="user-name"><img src="<?php echo $base_url . $users[$i]['avatar']; ?>" class="avatar-img"></td>
                            <td class="user-name"><?php echo $users[$i]['name']; ?></td>
                            <td class="user-email"><?php echo $users[$i]['email']; ?></td>
                            <td class="user-role"><?php if ($users[$i]['role'] == 2) echo "Teacher"; else echo "Student"; ?></td>
                            <td class="user-action">
                                <button class="btn btn-warning btn-sm" onclick="editUser(<?php echo $users[$i]['id']; ?>)">Edit</button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- edit role modal -->
<div class="modal fade" id="modal_edit_user" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">Edit user</div>
            <div class="modal-body">
                <input type="hidden" id="modal_edit_user_id">
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" type="text" id="modal_edit_user_name" readonly>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="text" id="modal_edit_user_email" readonly>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control page-select" id="modal_edit_user_role">
                        <option value="Teacher">Teacher</option>
                        <option value="Student">Student</option>
                    </select>
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-link" onclick="editUserBtn()">Save changes</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(PREPEND_PATH . "views/partials/footer.php"); ?>
<?php include(PREPEND_PATH . "views/partials/foot.php"); ?>
<script>
    $(function () {
        $("#users-table").DataTable({
            aaSorting: [],
            autoWidth: !1,
            responsive: !0,
            lengthMenu: [[15, 40, 100, -1], ["15 Rows", "40 Rows", "100 Rows", "Everything"]],
            language: {searchPlaceholder: "Search for records..."},
            sDom: '<"dataTables__top"flB<"dataTables_actions">>rt<"dataTables__bottom"ip><"clear">',
        });
    });
    function editUser(id) {
        $('#modal_edit_user_id').val(id);
        $('#modal_edit_user_name').val($('tr#user_' + id + ' .user-name').text());
        $('#modal_edit_user_email').val($('tr#user_' + id + ' .user-email').text());
        let role = $('tr#user_' + id + ' .user-role').text().replace(/\s/g, '');
        $('#modal_edit_user_role').val(role);
        $('#modal_edit_user').modal('show');
    }
    function editUserBtn() {
        let base_url = $('meta[name="_base_url"]').attr("content");
        let user_id = $('#modal_edit_user_id').val();
        let user_role = $('#modal_edit_user_role').val();
        let url = base_url + '/user-role';
        let data = {
            user_id: user_id,
            user_role: user_role
        };
        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === 'success') {
                    customAlert(res.message, true);
                    $('#modal_edit_user').modal('toggle');
                    setTimeout(function () {
                        location.reload()
                    }, 1500);
                } else customAlert(res.message);
            }
        })
    }
</script>
</body>
</html>
