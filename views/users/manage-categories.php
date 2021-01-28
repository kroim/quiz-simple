<html>
<?php
if (!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH . "views/partials/head.php");
include(PREPEND_PATH . "views/partials/header.php");
?>
<style>
    #main-table th, #main-table td, #sub-table th, #sub-table td {
        text-align: center;
        font-size: 14px;
    }
    #modal_remove_main_category .modal-body, #modal_remove_sub_category .modal-body {
        text-align: center;
    }
</style>
<body data-sa-theme="10">
<?php include(PREPEND_PATH . "views/partials/sidebar.php"); ?>
<section class="content">

    <header class="content__title">
        <h1>Categories management</h1>
    </header>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div style="display: inline-block; width: 100%;">
                        <h4 class="card-title" style="display: inline-block">Main categories</h4>
                        <button class="btn btn-success btn-sm" onclick="$('#modal_add_main_category').modal()" style="display: inline-block; float: right">Add</button>
                    </div>
                    <div class="table-responsive data-table">
                        <table id="main-table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10%">ID</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for ($i = 0; $i < count($categories); $i++) { ?>
                                <tr id="main_<?php echo $categories[$i]['id']; ?>">
                                    <td class="main-id"><?php echo $categories[$i]['id']; ?></td>
                                    <td class="main-name"><?php echo $categories[$i]['name']; ?></td>
                                    <td class="main-action">
                                        <button class="btn btn-warning btn-sm" onclick="editMainCategory(<?php echo $categories[$i]['id']; ?>)">Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="removeMainCategory(<?php echo $categories[$i]['id']; ?>)">Remove</button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div style="display: inline-block; width: 100%;">
                        <h4 class="card-title" style="display: inline-block">Sub categories</h4>
                        <button class="btn btn-success btn-sm" onclick="$('#modal_add_sub_category').modal()" style="display: inline-block; float: right">Add</button>
                    </div>
                    <div class="table-responsive data-table">
                        <table id="sub-table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10%">NO</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 20%">Main Category</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for ($j = 0; $j < count($sub_categories); $j++) { ?>
                                <tr id="sub_<?php echo $sub_categories[$j]['id'] ?>">
                                    <td class="sub-id"><?php echo $sub_categories[$j]['id']; ?></td>
                                    <td class="sub-name"><?php echo $sub_categories[$j]['name']; ?></td>
                                    <td class="sub-parent"><?php echo $sub_categories[$j]['category_name']; ?></td>
                                    <td class="sub-action">
                                        <button class="btn btn-warning btn-sm"
                                                onclick="editSubCategory(<?php echo $sub_categories[$j]['id']; ?>, <?php echo $sub_categories[$j]['category_id']; ?>)">Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="removeSubCategory(<?php echo $sub_categories[$j]['id']; ?>)">Remove</button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- add a main category modal -->
<div class="modal fade" id="modal_add_main_category" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add a main category</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Category Name</label>
                    <input class="form-control" type="text" id="modal_main_category_name">
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-link" onclick="addMainCategory()">Add a category</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add a sub category modal -->
<div class="modal fade" id="modal_add_sub_category" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add a sub category</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Category Name</label>
                    <input class="form-control" type="text" id="modal_sub_category_name">
                </div>
                <div class="form-group">
                    <label>Main Category</label>
                    <select class="form-control page-select" id="modal_add_sub_category_parent">
                        <?php for ($k = 0; $k < count($categories); $k++) { ?>
                            <option value="<?php echo $categories[$k]['id'] ?>"><?php echo $categories[$k]['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-link" onclick="addSubCategory()">Add a sub category</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- edit a main category modal -->
<div class="modal fade" id="modal_edit_main_category" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit a main category</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal_edit_main_category_id">
                <div class="form-group">
                    <label>Category Name</label>
                    <input class="form-control" type="text" id="modal_edit_main_category_name">
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-link" onclick="editMainCategoryBtn()">Edit a main category</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- edit a sub category modal -->
<div class="modal fade" id="modal_edit_sub_category" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit a sub category</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal_edit_sub_category_id">
                <div class="form-group">
                    <label>Category Name</label>
                    <input class="form-control" type="text" id="modal_edit_sub_category_name">
                </div>
                <div class="form-group">
                    <label>Main Category</label>
                    <select class="form-control page-select" id="modal_edit_sub_category_parent">
                        <?php for ($k = 0; $k < count($categories); $k++) { ?>
                            <option value="<?php echo $categories[$k]['id'] ?>"><?php echo $categories[$k]['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-link" onclick="editSubCategoryBtn()">Edit a sub category</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- remove a main category modal -->
<div class="modal fade" id="modal_remove_main_category" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body">
                <div class="form-group">
                    <i class="zwicon-info-circle" style="font-size: 7rem"></i>
                </div>
                <div class="form-group">
                    <h3>Are you sure to remove?</h3>
                </div>
                <input type="hidden" id="modal_remove_main_category_id">
                <button type="button" class="btn btn-link" onclick="removeMainCategoryBtn()">Remove</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- remove a sub category modal -->
<div class="modal fade" id="modal_remove_sub_category" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body">
                <div class="form-group">
                    <i class="zwicon-info-circle" style="font-size: 7rem"></i>
                </div>
                <div class="form-group">
                    <h3>Are you sure to remove?</h3>
                </div>
                <input type="hidden" id="modal_remove_sub_category_id">
                <button type="button" class="btn btn-link" onclick="removeSubCategoryBtn()">Remove</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php include(PREPEND_PATH . "views/partials/footer.php"); ?>
<?php include(PREPEND_PATH . "views/partials/foot.php"); ?>
<script>
    let base_url = '';
    $(function () {
        $("#main-table, #sub-table").DataTable({
            aaSorting: [],
            autoWidth: !1,
            responsive: !0,
            lengthMenu: [[15, 40, 100, -1], ["15 Rows", "40 Rows", "100 Rows", "Everything"]],
            language: {searchPlaceholder: "Search for records..."},
            sDom: '<"dataTables__top"flB<"dataTables_actions">>rt<"dataTables__bottom"ip><"clear">',
        });
        base_url = $('meta[name="_base_url"]').attr('content');
    });
    function addMainCategory() {
        let url = base_url + "/user-categories";
        let name = $('#modal_main_category_name').val();
        $.ajax({
            url: url,
            method: 'post',
            data: {
                action: "add_main_category",
                name: name
            },
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === "success") {
                    customAlert(res.message, true);
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else customAlert(res.message);
            }
        })
    }
    function addSubCategory() {
        let url = base_url + "/user-categories";
        let name = $('#modal_sub_category_name').val();
        let category = $('#modal_add_sub_category_parent').val();
        $.ajax({
            url: url,
            method: 'post',
            data: {
                action: "add_sub_category",
                name: name,
                category: category,
            },
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === "success") {
                    customAlert(res.message, true);
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else customAlert(res.message);
            }
        })
    }
    function editMainCategory(id) {
        $('#modal_edit_main_category_id').val(id);
        let name = $('tr#main_' + id + ' .main-name').text();
        $('#modal_edit_main_category_name').val(name);
        $('#modal_edit_main_category').modal();
    }
    function editMainCategoryBtn() {
        let category_id = $('#modal_edit_main_category_id').val();
        let category_name = $('#modal_edit_main_category_name').val();
        $.ajax({
            url: base_url + "/user-categories",
            method: 'post',
            data: {
                action: "edit_main_category",
                id: category_id,
                name: category_name,
            },
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === "success") {
                    customAlert(res.message, true);
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else customAlert(res.message);
            }
        })
    }
    function removeMainCategory(id) {
        $('#modal_remove_main_category_id').val(id);
        $('#modal_remove_main_category').modal();
    }
    function removeMainCategoryBtn() {
        let category_id = $('#modal_remove_main_category_id').val();
        $.ajax({
            url: base_url + "/user-categories",
            method: 'post',
            data: {
                action: "remove_main_category",
                id: category_id,
            },
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === "success") {
                    customAlert(res.message, true);
                    setTimeout(function () {
                        location.reload()
                    }, 2000);
                } else customAlert(res.message);
            }
        })
    }
    function editSubCategory(id, category_id) {
        $('#modal_edit_sub_category_id').val(id);
        let name = $('tr#sub_' + id + ' .sub-name').text();
        $('#modal_edit_sub_category_name').val(name);
        $('#modal_edit_sub_category_parent').val(category_id);
        $('#modal_edit_sub_category').modal();
    }
    function editSubCategoryBtn() {
        let sub_id = $('#modal_edit_sub_category_id').val();
        let sub_name = $('#modal_edit_sub_category_name').val();
        let sub_parent = $('#modal_edit_sub_category_parent').val();
        $.ajax({
            url: base_url + "/user-categories",
            method: 'post',
            data: {
                action: "edit_sub_category",
                id: sub_id,
                name: sub_name,
                parent: sub_parent,
            },
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === "success") {
                    customAlert(res.message, true);
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else customAlert(res.message);
            }
        })
    }
    function removeSubCategory(id) {
        $('#modal_remove_sub_category_id').val(id);
        $('#modal_remove_sub_category').modal();
    }
    function removeSubCategoryBtn() {
        let sub_id = $('#modal_remove_sub_category_id').val();
        $.ajax({
            url: base_url + "/user-categories",
            method: 'post',
            data: {
                action: "remove_sub_category",
                id: sub_id,
            },
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === "success") {
                    customAlert(res.message, true);
                    setTimeout(function () {
                        location.reload()
                    }, 2000);
                } else customAlert(res.message);
            }
        })
    }
</script>
</body>
</html>
