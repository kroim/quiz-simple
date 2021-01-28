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
        <h1>Teachers management</h1>
    </header>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Teachers management</h4>
            <div class="table-responsive data-table">
                <table id="users-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10%">NO</th>
                        <th style="width: 20%">Name</th>
                        <th style="width: 40%">Email</th>
                        <th style="width: 20%">Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < count($users); $i++) { ?>
                        <tr id="user_{{ $user->id }}">
                            <td class="user-number"><?php echo $users[$i]['id']; ?></td>
                            <td class="user-name"><?php echo $users[$i]['name']; ?></td>
                            <td class="user-email"><?php echo $users[$i]['email']; ?></td>
                            <td class="user-description"><?php echo $users[$i]['description']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

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
</script>
</body>
</html>
