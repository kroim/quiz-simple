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
                        <th style="width: 30%">Question</th>
                        <th style="width: 10%">Duration (m)</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < count($new_quizzes); $i++) { ?>
                        <tr id="quiz_<?php echo $new_quizzes[$i]->id; ?>">
                            <td class="quiz-id"><?php echo $i + 1; ?></td>
                            <td class="quiz-code"><?php echo $new_quizzes[$i]->code; ?></td>
                            <td class="quiz-question" data-id=`<?php echo json_encode($new_quizzes[$i]->question_ids); ?>`>
                                <?php for ($j = 0; $j < count($new_quizzes[$i]->questions); $j++) { ?>
                                    <div><?php echo $new_quizzes[$i]->questions[$j]; ?></div>
                                <?php } ?>
                            </td>
                            <td class="quiz-duration"><?php echo $new_quizzes[$i]->total_duration; ?></td>
                            <td class="question-action">
                                <button class="btn btn-warning btn-sm" onclick="editQuiz(<?php echo $new_quizzes[$i]->id; ?>)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="removeQuiz(<?php echo $new_quizzes[$i]->id; ?>)">Remove</button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- add a question modal -->
<div class="modal fade" id="modal_add_quiz" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Create a quiz</h4>
            </div>
            <div class="modal-body">
                <form id="modal-add-quiz-form">
                    <label>Questions</label>
                    <div id="modal_add_questions_div">
                        <div class="form-group question-item">
                            <select class="form-control page-select" required>
                                <?php for ($k = 0; $k < count($questions); $k++) { ?>
                                    <option value="<?php echo $questions[$k]['id'] ?>"><?php echo $questions[$k]['question'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-link" onclick="addQuestionItem()">Add more question</button>
                        <button type="button" class="btn btn-link" onclick="removeQuestionItem()">Remove one</button>
                    </div>
                    <div class="form-group">
                        <label>Duration (m)</label>
                        <input class="form-control" id="modal_add_quiz_duration" type="number" required>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-link">Create a question</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- edit a question modal -->
<div class="modal fade" id="modal_edit_quiz" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit a quiz</h4>
            </div>
            <div class="modal-body">
                <form id="modal-edit-quiz-form">
                    <input type="hidden" id="modal_edit_quiz_id">
                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control" id="modal_edit_quiz_code" readonly>
                    </div>
                    <label>Questions</label>
                    <div id="modal_edit_questions_div">
                        <div class="form-group question-item">
                            <select class="form-control page-select" required>
                                <?php for ($k = 0; $k < count($questions); $k++) { ?>
                                    <option value="<?php echo $questions[$k]['id'] ?>"><?php echo $questions[$k]['question'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-link" onclick="addEditQuestionItem()">Add more question</button>
                        <button type="button" class="btn btn-link" onclick="removeEditQuestionItem()">Remove one</button>
                    </div>
                    <div class="form-group">
                        <label>Duration (m)</label>
                        <input class="form-control" id="modal_edit_quiz_duration" type="number" required>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-link">Save changes</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- remove a quiz modal -->
<div class="modal fade" id="modal_remove_quiz" tabindex="-1">
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
                <input type="hidden" id="modal_remove_quiz_id">
                <button type="button" class="btn btn-link" onclick="removeQuizBtn()">Remove</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div id="questions-select-hidden" style="display: none">
    <div class="form-group question-item">
        <select class="form-control page-select" required>
            <?php for ($k = 0; $k < count($questions); $k++) { ?>
                <option value="<?php echo $questions[$k]['id'] ?>"><?php echo $questions[$k]['question'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<input hidden class="_questions" value='<?= json_encode($questions); ?>'/>
<?php include(PREPEND_PATH . "views/partials/footer.php"); ?>
<?php include(PREPEND_PATH . "views/partials/foot.php"); ?>
<script>
    let base_url = '';
    let _questionArr = [];
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
        _questionArr = JSON.parse($('._questions').val());
    });
    function addQuestionItem() {
        let html = $('#questions-select-hidden').html();
        $('#modal_add_questions_div').append(html);
    }
    function removeQuestionItem() {
        let questions_length = $('#modal_add_questions_div .question-item').length;
        if (questions_length < 2) return;
        $('#modal_add_questions_div .question-item:nth-child(' + questions_length +')').remove()
    }
    function addEditQuestionItem() {
        let html = $('#questions-select-hidden').html();
        $('#modal_edit_questions_div').append(html);
    }
    function removeEditQuestionItem() {
        let questions_length = $('#modal_edit_questions_div .question-item').length;
        if (questions_length < 2) return;
        $('#modal_edit_questions_div .question-item:nth-child(' + questions_length +')').remove()
    }
    $('#modal-add-quiz-form').on('submit', function (e) {
        e.preventDefault();
        let questions = [];
        $('#modal_add_questions_div .question-item').each(function (index, item) {
            let item_id = $(item).find('select').val();
            questions.push(item_id);
        });
        let duration = $('#modal_add_quiz_duration').val();
        let data = {
            action: "add_quiz_own",
            questions: JSON.stringify(questions),
            duration: duration,
        };
        $.ajax({
            url: base_url + "/quizzes-own",
            method: 'post',
            data: data,
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
    });
    function editQuiz(id) {
        $('#modal_edit_quiz_id').val(id);
        let code = $('tr#quiz_' + id + ' .quiz-code').text();
        $('#modal_edit_quiz_code').val(code);
        let duration = $('tr#quiz_' + id + ' .quiz-duration').text();
        $('#modal_edit_quiz_duration').val(duration);
        let question_ids = $('tr#quiz_' + id + ' .quiz-question').attr('data-id').replace(/`/g, '');
        question_ids = JSON.parse(question_ids);
        $('#modal_edit_questions_div .question-item:nth-child(1) select').val(question_ids[0]);
        let questions_length = $('#modal_edit_questions_div .question-item').length;
        if (questions_length > 1) {
            for (let k = 1; k < questions_length; k++) {
                $('#modal_edit_questions_div .question-item:nth-child(2)').remove()
            }
        }
        for (let i = 1; i < question_ids.length; i++) {
            let html = '<div class="form-group question-item"><select class="form-control page-select" required>';
            for (let j = 0; j < _questionArr.length; j++) {
                if (_questionArr[j].id == question_ids[i])
                    html += '<option value="' + _questionArr[j].id +'" selected>' + _questionArr[j].question + '</option>';
                else html += '<option value="' + _questionArr[j].id +'">' + _questionArr[j].question + '</option>';
            }
            html += '</select></div>';
            $('#modal_edit_questions_div').append(html);
        }
        $('#modal_edit_quiz').modal();
    }
    function removeQuiz(id) {
        $('#modal_remove_quiz_id').val(id);
        $('#modal_remove_quiz').modal();
    }
    function removeQuizBtn() {
        let quiz_id = $('#modal_remove_quiz_id').val();
        $.ajax({
            url: base_url + "/quizzes-own",
            method: 'post',
            data: {
                action: "remove_quiz_own",
                quiz_id: quiz_id,
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
