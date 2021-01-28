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
                                <th style="width: 10%">NO</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for ($i = 0; $i < count($categories); $i++) { ?>
                                <tr id="user_{{ $user->id }}">
                                    <td class="user-number"><?php echo $categories[$i]['id']; ?></td>
                                    <td class="user-name"><?php echo $categories[$i]['name']; ?></td>
                                    <td class="user-action">
                                        <button class="btn btn-warning btn-sm" onclick="editMainCategoy(<?php echo $categories[$i]['id']; ?>)">Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="removeMainCategoy(<?php echo $categories[$i]['id']; ?>)">Remove</button>
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
                                <tr id="user_{{ $user->id }}">
                                    <td class="user-number"><?php echo $sub_categories[$j]['id']; ?></td>
                                    <td class="user-name"><?php echo $sub_categories[$j]['name']; ?></td>
                                    <td class="user-name"><?php echo $sub_categories[$j]['category_name']; ?></td>
                                    <td class="user-action">
                                        <button class="btn btn-warning btn-sm"
                                                onclick="editSubCategoy(<?php echo $sub_categories[$j]['id']; ?>, <?php echo $sub_categories[$j]['category_id']; ?>)">Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="removeSubCategoy(<?php echo $sub_categories[$j]['id']; ?>)">Remove</button>
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
                    <button type="button" class="btn btn-link" onclick="editSubCategoryBtn()">Add a sub category</button>
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
                    <button type="button" class="btn btn-link" onclick="editSubCategoryBtn()">Add a sub category</button>
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
        $("#main-table, #sub-table").DataTable({
            aaSorting: [],
            autoWidth: !1,
            responsive: !0,
            lengthMenu: [[15, 40, 100, -1], ["15 Rows", "40 Rows", "100 Rows", "Everything"]],
            language: {searchPlaceholder: "Search for records..."},
            sDom: '<"dataTables__top"flB<"dataTables_actions">>rt<"dataTables__bottom"ip><"clear">',
        });
    });
    function addMainCategory() {
        let base_url = $('meta[name="_base_url"]').attr('content');
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
        let base_url = $('meta[name="_base_url"]').attr('content');
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
</script>
</body>
</html>
