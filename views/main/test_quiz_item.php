<html>
<?php
if (!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH . "views/partials/head.php");
include(PREPEND_PATH . "views/partials/header.php");
?>
<link rel="stylesheet" href="<?= $base_url; ?>/public/common/css/test-item.css">
<body data-sa-theme="10">
<?php include(PREPEND_PATH . "views/partials/sidebar.php"); ?>
<section class="content">

    <header class="content__title">
        <h1>Test</h1>
    </header>
    <h5 class="card-subtitle text-center" style="font-size: 18px; font-weight: bold; font-style: oblique; color: orangered;">Do not close this browser, Do not refresh this page</h5>
    <div class="card">
        <div class="card-body">
            <?php if ($quiz->status != 1) { ?>
                <h3 class="text-center">Unable to apply this quiz!</h3>
            <?php } else { ?>
                <h4 class="card-title">Problems</h4>
                <input hidden id="test-quiz-id" value="<?= $quiz->id ?>">
                <input hidden id="test-quiz-code" value="<?= $quiz->code ?>">
                <div class="tab-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php for ($i = 0; $i < count($quiz->question_ids); $i++) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($i == 0) echo 'active'; else echo 'disabled';?>" data-toggle="tab" href="#problem_<?= $quiz->question_ids[$i] ?>" role="tab">
                                    <span class="page-link text-center"><?= $i + 1; ?></span></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <?php for ($j = 0; $j < count($quiz->question_ids); $j++) { ?>
                            <div class="tab-pane fade <?php if ($j == 0) echo 'active show'; ?>" id="problem_<?= $quiz->question_ids[$j] ?>" role="tabpanel">
                                <div class="form-group">
                                    <h5><?= $quiz->questions[$j] ?></h5>
                                </div>
                                <?php $answers = json_decode($quiz->answers[$j]); ?>
                                <?php for ($k = 0; $k < count($answers); $k++) { ?>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mb-2" data-id="answer-item">
                                            <input type="checkbox" data-id="answer-flag" class="custom-control-input" id="answer_<?= $j ?>_<?= $k ?>">
                                            <label class="custom-control-label" data-id="answer-name" for="answer_<?= $j ?>_<?= $k ?>"><?= $answers[$k]->name ?></label>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($j < count($quiz->question_ids) - 1) { ?>
                                    <div class="text-right">
                                        <button class="btn btn-warning" onclick="gotoNext()">Next Problem</button>
                                    </div>
                                <?php } else { ?>
                                    <div class="text-right">
                                        <button class="btn btn-success" onclick="$('#modal_confirm_submit').modal()">Submit Test</button>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>
<!-- confirm test submit modal -->
<div class="modal fade" id="modal_confirm_submit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body">
                <div class="form-group">
                    <i class="zwicon-info-circle" style="font-size: 7rem"></i>
                </div>
                <div class="form-group">
                    <h3>Are you sure to submit your test result?</h3>
                </div>
                <input type="hidden" id="modal_confirm_quiz_code">
                <button type="button" class="btn btn-link" onclick="submitTest()">Submit Test</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- close test modal -->
<div class="modal fade" id="modal_close_test" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body">
                <div class="form-group">
                    <i class="zwicon-clock" style="font-size: 7rem; color: orangered;"></i>
                </div>
                <div class="form-group">
                    <h3>Time is up !</h3>
                </div>
                <input type="hidden" id="modal_confirm_question">
                <button type="button" class="btn btn-link" data-dismiss="modal" onclick="gotoNext()">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include(PREPEND_PATH . "views/partials/footer.php"); ?>
<?php include(PREPEND_PATH . "views/partials/foot.php"); ?>
<script>
    let base_url = $('meta[name="_base_url"]').attr('content');
    let durations = JSON.parse('<?= json_encode($quiz->durations) ?>');
    function clock_func(targetTime) {
        let currentTime = new Date().getTime();
        let distance = targetTime - currentTime;
        let hours = Math.floor(distance / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);
        if (hours < 10) hours = "0" + hours;
        if (minutes < 10) minutes = "0" + minutes;
        if (seconds < 10) seconds = "0" + seconds;
        if (distance < 1) {
            return false;
        } else {
            $('.test__hours').text(hours);
            $('.test__min').text(minutes);
            $('.test__sec').text(seconds);
            $('#test_down_clock').css('display', 'block');
            return true;
        }
    }
    let current_time = new Date();
    let duration_item_splits = durations[0].split(":");
    let target_time = new Date(current_time.setHours(new Date(current_time).getHours() + parseInt(duration_item_splits[0])));
    target_time = new Date(target_time.setMinutes(target_time.getMinutes() + parseInt(duration_item_splits[1])));
    target_time = new Date(target_time.setSeconds(target_time.getSeconds() + parseInt(duration_item_splits[2])));
    let targetTime = new Date(target_time).getTime() + 2000;
    let clock = setInterval(function () {
        if (!clock_func(targetTime)) {
            clearInterval(clock);
            $('#modal_confirm_question').val('1');
            $('#modal_close_test').modal();
        }
    }, 500);
    function gotoNext() {
        let active_index = 0;
        $('.nav-link').each(function (index, nav) {
            let nav_class = $(nav).attr('class');
            if (nav_class.indexOf('active') > -1) active_index = index;
        });
        submitTest(active_index);
        if (active_index < durations.length - 1) {
            let next_child = active_index + 1;
            $($('.nav-link')[active_index]).removeClass('active').addClass('disabled');
            $($('.tab-pane')[active_index]).removeClass('active').removeClass('show');
            $($('.nav-link')[next_child]).removeClass('disabled').addClass('active');
            $($('.tab-pane')[next_child]).addClass('active').addClass('show');
            clearInterval(clock);
            current_time = new Date();
            duration_item_splits = durations[next_child].split(":");
            target_time = new Date(current_time.setHours(new Date(current_time).getHours() + parseInt(duration_item_splits[0])));
            target_time = new Date(target_time.setMinutes(target_time.getMinutes() + parseInt(duration_item_splits[1])));
            target_time = new Date(target_time.setSeconds(target_time.getSeconds() + parseInt(duration_item_splits[2])));
            targetTime = new Date(target_time).getTime() + 2000;
            clock = setInterval(function () {
                if (!clock_func(targetTime)) {
                    clearInterval(clock);
                    $('#modal_confirm_question').val('1');
                    $('#modal_close_test').modal();
                }
            }, 500);
        } else {
            location.href = base_url;
        }
    }
    function submitTest(active_index) {
        if (active_index === undefined) active_index = durations.length - 1;
        let item_flag = 0;
        if (active_index === durations.length - 1) item_flag = 1;
        let tab = $('.tab-pane')[active_index];
        let quiz_id = $('#test-quiz-id').val();
        let question_id = $(tab).attr('id').replace('problem_', '');
        let answer_item = [];
        $(tab).find('div[data-id="answer-item"]').each(function (index, item) {
            let name = $(item).find('label[data-id="answer-name"]').text();
            let flag = $(item).find('input[data-id="answer-flag"]').prop('checked')?1:0;
            answer_item.push({name: name, flag: flag});
        });
        let data = {
            action: "submit_test_item",
            item_flag: item_flag,
            quiz_id: quiz_id,
            question_id: question_id,
            answer: JSON.stringify(answer_item),
        };
        $.ajax({
            url: base_url + "/tests",
            method: 'post',
            data: data,
            success: function (res) {
                res = JSON.parse(res);
                if (active_index === durations.length - 1) location.href = base_url;
            }
        })
    }
</script>
</body>
</html>
