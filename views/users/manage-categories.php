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
                        <button class="btn btn-success btn-sm" onclick="addMainCategoy()" style="display: inline-block; float: right">Add</button>
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
                        <button class="btn btn-success btn-sm" onclick="addSubCategoy()" style="display: inline-block; float: right">Add</button>
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
                                    <td class="user-name"><?php echo $sub_categories[$j]['category_id']; ?></td>
                                    <td class="user-action">
                                        <button class="btn btn-warning btn-sm" onclick="editSubCategoy(<?php echo $sub_categories[$j]['id']; ?>)">Edit</button>
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
</script>
</body>
</html>
