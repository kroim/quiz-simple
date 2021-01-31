<html>
<?php
if (!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH . "views/partials/head.php");
include(PREPEND_PATH . "views/partials/header.php");
?>
<style>
    #quiz-table th, #quiz-table td {
        text-align: center;
        font-size: 14px;
    }

    #modal_remove_quiz .modal-body {
        text-align: center;
    }
</style>
<body data-sa-theme="10">
<?php include(PREPEND_PATH . "views/partials/sidebar.php"); ?>
<section class="content">

    <header class="content__title">
        <h1>Quizzes</h1>
        <div class="actions">
            <button class="btn btn-success" onclick="$('#modal_add_quiz').modal()">Create a quiz</button>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive data-table">
                <table id="quiz-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10%">No</th>
                        <th style="width: 10%">Code</th>
                        <th style="width: 10%">Question</th>
                        <th style="width: 30%">Answer</th>
                        <th style="width: 20%">Duration</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < count($quizzes); $i++) { ?>
                        <tr id="quiz_<?php echo $quizzes[$i]['id']; ?>">
                            <td class="quiz-id"><?php echo $quizzes[$i]['id']; ?></td>
                            <td class="quiz-code"><?php echo $quizzes[$i]['code']; ?></td>
                            <td class="quiz-question"><?php echo $quizzes[$i]['question']; ?></td>
                            <td class="quiz-answer" data-content=`<?php echo $quizzes[$i]['answers']; ?>`>
                                <?php
                                $answers = json_decode($quizzes[$i]['answers']);
                                for ($j = 0; $j < count($answers); $j++) { ?>
                                    <div><?php echo $answers[$j]->name ?> (<?php if ($answers[$j]->flag == 1) echo "correct"; else echo "wrong"; ?>)</div>
                                <?php }
                                ?>
                            </td>
                            <td class="question-action">
                                <button class="btn btn-warning btn-sm" onclick="editQuiz(<?php echo $quizzes[$i]['id']; ?>)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="removeQuiz(<?php echo $quizzes[$i]['id']; ?>)">Remove</button>
                            </td>
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
    let base_url = '';
    $(function () {
        $("#quiz-table").DataTable({
            aaSorting: [],
            autoWidth: !1,
            responsive: !0,
            lengthMenu: [[15, 40, 100, -1], ["15 Rows", "40 Rows", "100 Rows", "Everything"]],
            language: {searchPlaceholder: "Search for records..."},
            sDom: '<"dataTables__top"flB<"dataTables_actions">>rt<"dataTables__bottom"ip><"clear">',
        });
        base_url = $('meta[name="_base_url"]').attr('content');
    });
</script>
</body>
</html>
