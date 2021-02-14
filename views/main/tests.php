<html>
<?php
if (!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
include(PREPEND_PATH . "views/partials/head.php");
include(PREPEND_PATH . "views/partials/header.php");
?>
<link rel="stylesheet" href="<?= $base_url; ?>/public/common/css/tests.css">
<body data-sa-theme="10">
<?php include(PREPEND_PATH . "views/partials/sidebar.php"); ?>
<section class="content">

    <header class="content__title">
        <h1>Tests</h1>
    </header>

    <div class="card">
        <div class="card-body">
            <form id="quiz-code-form">
                <h4 style="flex: 1">Enter Your Quiz Code</h4>
                <input type="text" class="form-control" style="flex: 2" required>
                <button class="btn btn-theme" style="flex: 1">Get Quiz</button>
            </form>
        </div>
    </div>
</section>
<!-- confirm test modal -->
<div class="modal fade" id="modal_confirm_quiz" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body">
                <div class="form-group">
                    <i class="zwicon-info-circle" style="font-size: 7rem"></i>
                </div>
                <div class="form-group">
                    <h3>You can't stop testing after you start a test, Do not refresh and do not close browser.</h3>
                </div>
                <div class="form-group">
                    <h5 class="text-center">There are <span id="problem_counts"></span> problems</h5>
                </div>
                <input type="hidden" id="modal_confirm_quiz_code">
            </div>
        </div>
    </div>
</div>
<?php include(PREPEND_PATH . "views/partials/footer.php"); ?>
<?php include(PREPEND_PATH . "views/partials/foot.php"); ?>
<script>
    let base_url = $('meta[name="_base_url"]').attr('content');
    $('#quiz-code-form').on('submit', function (e) {
        e.preventDefault();
        let code = $(this).find('input').val();
        $.ajax({
            url: base_url + "/tests",
            method: 'post',
            data: {
                action: "get_quiz",
                code: code,
            },
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === "success") {
                    $('#modal_confirm_quiz_code').val(code);
                    $('#problem_counts').text(res.count);
                    $('#modal_confirm_quiz').modal();
                    setTimeout(function () {
                        startTest()
                    }, 5000);
                } else customAlert(res.message);
            }
        })
    });
    function startTest() {
        location.href = base_url + "/test-quiz?code=" + $('#modal_confirm_quiz_code').val();
    }
</script>
</body>
</html>
