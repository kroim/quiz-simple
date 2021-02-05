<html>
<?php
if (!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH . "views/partials/head.php");
include(PREPEND_PATH . "views/partials/header.php");
?>
<style>
    #test-table th, #test-table td {
        text-align: center;
        font-size: 14px;
    }
</style>
<body data-sa-theme="10">
<?php include(PREPEND_PATH . "views/partials/sidebar.php"); ?>
<section class="content">

    <header class="content__title">
        <h1>Dashboard</h1>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive data-table">
                <?php if ($_SESSION['user_role'] == 1) { ?>
                    <table id="test-table" class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th style="width: 10%">Name</th>
                            <th style="width: 10%">Email</th>
                            <th style="width: 50%">Question</th>
                            <th style="width: 40%">Answer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ($i = 0; $i < count($tests); $i++) {
                            $item_questions = $tests[$i]->questions;
                            $item_answers = $tests[$i]->answers;
                            for ($j = 0; $j < count($item_questions); $j++) { ?>
                                <tr>
                                <td class="test-id" data-id="<?= $tests[$i]->id ?>"><?= $i + 1 ?></td>
                                <td class="test-user-name"><?= $tests[$i]->name ?></td>
                                <td class="test-user-email"><?= $tests[$i]->email ?></td>
                                <td class="question-name"><?php echo $item_questions[$j]; ?></td>
                                <td class="question-answers">
                                <?php $answers = json_decode($item_answers[$j]);
                                for ($k = 0; $k < count($answers); $k++) { ?>
                                    <div><?php echo $answers[$k]->name ?> (<?php if ($answers[$k]->flag == 1) echo "checked"; else echo "un-checked"; ?>)</div>
                                <?php } ?>
                            <?php } ?>
                            </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } else if ($_SESSION['user_role'] == 2) { ?>
                    <table id="test-table" class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th style="width: 10%">Name</th>
                            <th style="width: 10%">Email</th>
                            <th style="width: 50%">Question</th>
                            <th style="width: 40%">Answer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ($i = 0; $i < count($tests); $i++) {
                            $item_questions = $tests[$i]->questions;
                            $item_answers = $tests[$i]->answers;
                            for ($j = 0; $j < count($item_questions); $j++) { ?>
                                <tr>
                                <td class="test-id" data-id="<?= $tests[$i]->id ?>"><?= $i + 1 ?></td>
                                <td class="test-user-name"><?= $tests[$i]->name ?></td>
                                <td class="test-user-email"><?= $tests[$i]->email ?></td>
                                <td class="question-name"><?php echo $item_questions[$j]; ?></td>
                                <td class="question-answers">
                                <?php $answers = json_decode($item_answers[$j]);
                                for ($k = 0; $k < count($answers); $k++) { ?>
                                    <div><?php echo $answers[$k]->name ?> (<?php if ($answers[$k]->flag == 1) echo "checked"; else echo "un-checked"; ?>)</div>
                                <?php } ?>
                            <?php } ?>
                            </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <table id="test-table" class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th style="width: 50%">Question</th>
                            <th style="width: 40%">Answer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ($i = 0; $i < count($tests); $i++) {
                            $item_questions = $tests[$i]->questions;
                            $item_answers = $tests[$i]->answers;
                            for ($j = 0; $j < count($item_questions); $j++) { ?>
                                <tr>
                                <td class="test-id" data-id="<?= $tests[$i]->id ?>"><?= $i + 1 ?></td>
                                <td class="question-name"><?php echo $item_questions[$j]; ?></td>
                                <td class="question-answers">
                                <?php $answers = json_decode($item_answers[$j]);
                                for ($k = 0; $k < count($answers); $k++) { ?>
                                    <div><?php echo $answers[$k]->name ?> (<?php if ($answers[$k]->flag == 1) echo "checked"; else echo "un-checked"; ?>)</div>
                                <?php } ?>
                            <?php } ?>
                            </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php include(PREPEND_PATH . "views/partials/footer.php"); ?>
<?php include(PREPEND_PATH . "views/partials/foot.php"); ?>
<script>
    $(function () {
        $("#test-table").DataTable({
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
