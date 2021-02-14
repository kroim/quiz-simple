<html>
<?php
if (!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH . "views/partials/head.php");
include(PREPEND_PATH . "views/partials/header.php");
?>
<style>
    #question-table th, #question-table td {
        text-align: center;
        font-size: 14px;
    }

    #modal_remove_question .modal-body {
        text-align: center;
    }

    .answer-item label {
        margin-bottom: 0;
    }

    .answer-item {
        display: flex;
    }

    .answer-item input[type="radio"] {
        margin-top: .25rem;
    }
</style>
<body data-sa-theme="10">
<?php include(PREPEND_PATH . "views/partials/sidebar.php"); ?>
<section class="content">

    <header class="content__title">
        <h1>Questions</h1>
        <div class="actions">
            <button class="btn btn-success" onclick="$('#modal_add_question').modal()">Create a question</button>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive data-table">
                <table id="question-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 10%">Category</th>
                        <th style="width: 10%">Sub-Category</th>
                        <th style="width: 25%">Problem</th>
                        <th style="width: 35%">Answers</th>
                        <th style="width: 15%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < count($questions); $i++) { ?>
                        <tr id="question_<?php echo $questions[$i]['id']; ?>">
                            <td class="question-id"><?php echo $questions[$i]['id']; ?></td>
                            <td class="question-category" data-id="<?php echo $questions[$i]['category_id']; ?>"><?php echo $questions[$i]['category_name']; ?></td>
                            <td class="question-sub-category" data-id="<?php echo $questions[$i]['sub_id']; ?>"><?php echo $questions[$i]['sub_name']; ?></td>
                            <td class="question-name"><?php echo $questions[$i]['question']; ?></td>
                            <td class="question-answers" data-content=`<?php echo $questions[$i]['answers']; ?>`>
                                <?php
                                $answers = json_decode($questions[$i]['answers']);
                                for ($j = 0; $j < count($answers); $j++) { ?>
                                    <div><?php echo $answers[$j]->name ?> (<?php if ($answers[$j]->flag == 1) echo "correct"; else echo "wrong"; ?>)</div>
                                <?php }
                                ?>
                            </td>
                            <td class="question-action">
                                <button class="btn btn-warning btn-sm" onclick="editQuestion(<?php echo $questions[$i]['id']; ?>)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="removeQuestion(<?php echo $questions[$i]['id']; ?>)">Remove</button>
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
<div class="modal fade" id="modal_add_question" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Create a question</h4>
            </div>
            <div class="modal-body">
                <form id="modal-add-question-form">
                    <div class="form-group">
                        <label>Main Category</label>
                        <select class="form-control page-select" id="modal_add_question_category" required>
                            <?php for ($k = 0; $k < count($categories); $k++) { ?>
                                <option value="<?php echo $categories[$k]['id'] ?>"><?php echo $categories[$k]['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sub Category</label>
                        <select class="form-control page-select" id="modal_add_question_sub_category" required>
                            <?php for ($k = 0; $k < count($sub_categories); $k++) { ?>
                                <option value="<?php echo $sub_categories[$k]['id'] ?>"><?php echo $sub_categories[$k]['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Question</label>
                        <input class="form-control" type="text" id="modal_add_question_name" required>
                    </div>
                    <label>Answers (blue: correct answer, red: wrong answer)</label>
                    <div id="modal_add_answers_div">
                        <div class="form-group answer-item">
                            <input class="form-control modal_add_question_name" type="text" required>
                            <label class="btn bg-red"><input type="radio" name="answer_item_0" checked></label>
                            <label class="btn bg-blue"><input type="radio" name="answer_item_0"></label>
                        </div>
                        <div class="form-group answer-item">
                            <input class="form-control modal_add_question_name" type="text" required>
                            <label class="btn bg-red"><input type="radio" name="answer_item_1" autocomplete="off" checked></label>
                            <label class="btn bg-blue"><input type="radio" name="answer_item_1" autocomplete="off"></label>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-link" onclick="addAnswerItem()">Add more answer</button>
                        <button type="button" class="btn btn-link" onclick="removeAnswerItem()">Remove one</button>
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
<div class="modal fade" id="modal_edit_question" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit a question</h4>
            </div>
            <div class="modal-body">
                <form id="modal-edit-question-form">
                    <input type="hidden" id="modal_edit_question_id">
                    <div class="form-group">
                        <label>Main Category</label>
                        <select class="form-control page-select" id="modal_edit_question_category" required>
                            <?php for ($k = 0; $k < count($categories); $k++) { ?>
                                <option value="<?php echo $categories[$k]['id'] ?>"><?php echo $categories[$k]['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sub Category</label>
                        <select class="form-control page-select" id="modal_edit_question_sub_category" required>
                            <?php for ($k = 0; $k < count($sub_categories); $k++) { ?>
                                <option value="<?php echo $sub_categories[$k]['id'] ?>"><?php echo $sub_categories[$k]['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Question</label>
                        <input class="form-control" type="text" id="modal_edit_question_name" required>
                    </div>
                    <label>Answers (red: wrong answer, blue: correct answer)</label>
                    <div id="modal_edit_answers_div">
                        <div class="form-group answer-item">
                            <input class="form-control modal_edit_question_name" type="text" required>
                            <label class="btn bg-red"><input type="radio" name="answer_item_0" checked></label>
                            <label class="btn bg-blue"><input type="radio" name="answer_item_0"></label>
                        </div>
                        <div class="form-group answer-item">
                            <input class="form-control modal_edit_question_name" type="text" required>
                            <label class="btn bg-red"><input type="radio" name="answer_item_1" autocomplete="off" checked></label>
                            <label class="btn bg-blue"><input type="radio" name="answer_item_1" autocomplete="off"></label>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-link" onclick="addEditAnswerItem()">Add more answer</button>
                        <button type="button" class="btn btn-link" onclick="removeEditAnswerItem()">Remove one</button>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-link">Edit a question</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- remove a question modal -->
<div class="modal fade" id="modal_remove_question" tabindex="-1">
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
                <input type="hidden" id="modal_remove_question_id">
                <button type="button" class="btn btn-link" onclick="removeQuestionBtn()">Remove</button>
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
        $("#question-table").DataTable({
            aaSorting: [],
            autoWidth: !1,
            responsive: !0,
            lengthMenu: [[15, 40, 100, -1], ["15 Rows", "40 Rows", "100 Rows", "Everything"]],
            language: {searchPlaceholder: "Search for records..."},
            sDom: '<"dataTables__top"flB<"dataTables_actions">>rt<"dataTables__bottom"ip><"clear">',
        });
        base_url = $('meta[name="_base_url"]').attr('content');
    });

    function addAnswerItem() {
        let answer_length = $('.answer-item').length;
        let item_id = 'answer_item_' + answer_length;
        let html = '<div class="form-group answer-item">' +
            '<input class="form-control modal_add_question_name" type="text" required>' +
            '<label class="btn bg-red"><input type="radio" name="' + item_id + '" autocomplete="off" checked></label>' +
            '<label class="btn bg-blue"><input type="radio" name="' + item_id + '" autocomplete="off"></label>' +
            '</div>';
        $('#modal_add_answers_div').append(html);
    }
    function addEditAnswerItem() {
        let answer_length = $('.answer-item').length;
        let item_id = 'answer_item_' + answer_length;
        let html = '<div class="form-group answer-item">' +
            '<input class="form-control modal_edit_question_name" type="text" required>' +
            '<label class="btn bg-red"><input type="radio" name="' + item_id + '" autocomplete="off" checked></label>' +
            '<label class="btn bg-blue"><input type="radio" name="' + item_id + '" autocomplete="off"></label>' +
            '</div>';
        $('#modal_edit_answers_div').append(html);
    }
    function removeAnswerItem() {
        let answer_length = $('#modal_add_answers_div .answer-item').length;
        if (answer_length < 3) return;
        $('#modal_add_answers_div .answer-item:nth-child(' + answer_length +')').remove()
    }
    function removeEditAnswerItem() {
        let answer_length = $('#modal_edit_answers_div .answer-item').length;
        if (answer_length < 3) return;
        $('#modal_edit_answers_div .answer-item:nth-child(' + answer_length +')').remove()
    }
    $('#modal-add-question-form').on('submit', function (e) {
        e.preventDefault();
        let category = $('#modal_add_question_category').val();
        let sub_category = $('#modal_add_question_sub_category').val();
        let question = $('#modal_add_question_name').val();
        let answers = [];
        $('#modal_add_answers_div .answer-item').each(function (index, item) {
            let name = $(item).find('.modal_add_question_name').val();
            let item_flag = 0;
            $(item).find('input[type="radio"]').each(function (index1, item1) {
                if (index1 === 1 && $(item1).prop('checked')) item_flag = 1
            });
            answers.push({name: name, flag: item_flag});
        });
        $.ajax({
            url: base_url + '/questions-own',
            method: 'post',
            data: {
                action: "add_question_own",
                category: category,
                sub_category: sub_category,
                question: question,
                answers: JSON.stringify(answers),
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
    });
    function editQuestion(id) {
        let category = $('tr#question_' + id + ' .question-category').attr('data-id');
        let sub_category = $('tr#question_' + id + ' .question-sub-category').attr('data-id');
        let name = $('tr#question_' + id + ' .question-name').text();
        let answers_content = $('tr#question_' + id + ' .question-answers').attr('data-content').replace(/`/g, "");
        let answers = JSON.parse(answers_content);
        $('#modal_edit_question_id').val(id);
        $('#modal_edit_question_category').val(category);
        $('#modal_edit_question_sub_category').val(sub_category);
        $('#modal_edit_question_name').val(name);
        $('#modal_edit_answers_div .answer-item:nth-child(1) .modal_edit_question_name').val(answers[0].name);
        if (answers[0].flag == 1) $('#modal_edit_answers_div .answer-item:nth-child(1) .bg-blue input').prop('checked', true);
        else $('#modal_edit_answers_div .answer-item:nth-child(1) .bg-red input').prop('checked', true);
        $('#modal_edit_answers_div .answer-item:nth-child(2) .modal_edit_question_name').val(answers[1].name);
        if (answers[1].flag == 1) $('#modal_edit_answers_div .answer-item:nth-child(2) .bg-blue input').prop('checked', true);
        else $('#modal_edit_answers_div .answer-item:nth-child(2) .bg-red input').prop('checked', true);
        if (answers.length > 2) {
            for (let k = 2; k < answers.length; k++) {
                $('#modal_edit_answers_div .answer-item:nth-child(3)').remove();
            }
            let html ='';
            for (let i = 2; i < answers.length; i++) {
                html += '<div class="form-group answer-item">' +
                    '<input class="form-control modal_edit_question_name" type="text" value="' + answers[i].name + '" required>';
                if (answers[i].flag == 1) {
                    html += '<label class="btn bg-red"><input type="radio" name="' + i + '" autocomplete="off"></label>' +
                        '<label class="btn bg-blue"><input type="radio" name="' + i + '" autocomplete="off" checked></label>';
                } else {
                    html += '<label class="btn bg-red"><input type="radio" name="' + i + '" autocomplete="off" checked></label>' +
                        '<label class="btn bg-blue"><input type="radio" name="' + i + '" autocomplete="off"></label>';
                }
                html += '</div>';
            }
            $('#modal_edit_answers_div').append(html);
        }
        $('#modal_edit_question').modal();
    }
    $('#modal-edit-question-form').on('submit', function (e) {
        e.preventDefault();
        let question_id = $('#modal_edit_question_id').val();
        let category = $('#modal_edit_question_category').val();
        let sub_category = $('#modal_edit_question_sub_category').val();
        let question = $('#modal_edit_question_name').val();
        let answers = [];
        $('#modal_edit_answers_div .answer-item').each(function (index, item) {
            let name = $(item).find('.modal_edit_question_name').val();
            let item_flag = 0;
            $(item).find('input[type="radio"]').each(function (index1, item1) {
                if (index1 === 1 && $(item1).prop('checked')) item_flag = 1
            });
            answers.push({name: name, flag: item_flag});
        });
        let data = {
            action: "edit_question_own",
            question_id: question_id,
            category: category,
            sub_category: sub_category,
            question: question,
            answers: JSON.stringify(answers),
        };
        $.ajax({
            url: base_url + '/questions-own',
            method: 'post',
            data: data,
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === 'success') {
                    customAlert(res.message, true);
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else customAlert(res.message);
            }
        })
    });
    function removeQuestion(id) {
        $('#modal_remove_question_id').val(id);
        $('#modal_remove_question').modal();
    }
    function removeQuestionBtn() {
        let question_id = $('#modal_remove_question_id').val();
        $.ajax({
            url: base_url + '/questions-own',
            method: 'post',
            data: {
                action: "remove_question_own",
                question_id: question_id,
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
