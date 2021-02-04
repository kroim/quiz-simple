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
        <h1>Test</h1>
    </header>
    <h5 class="card-subtitle text-center" style="font-size: 18px; font-weight: bold; font-style: oblique; color: orangered;">Do not close this browser, do not refresh after you started.</h5>
    <div class="card">
        <div class="card-body">
            <?php if ($quiz->status != 1) { ?>
                <h3 class="text-center">Unable to apply this quiz!</h3>
            <?php } else { ?>
                <h4 class="card-title">Problems</h4>
                <div class="actions">
                    <button class="btn btn-success">Submit Result</button>
                </div>
                <input hidden id="test-quiz-id" value="<?= $quiz->id ?>">
                <input hidden id="test-quiz-code" value="<?= $quiz->code ?>">
                <div class="tab-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php for ($i = 0; $i < count($quiz->question_ids); $i++) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($i == 0) echo 'active'; ?>" data-toggle="tab" href="#problem_<?= $quiz->question_ids[$i] ?>" role="tab">
                                    <span class="page-link text-center"><?= $i + 1; ?></span></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <?php for ($j = 0; $j < count($quiz->question_ids); $j++) { ?>
                            <div class="tab-pane fade <?php if ($j == 0) echo 'active show'; ?>" id="problem_<?= $quiz->question_ids[$j] ?>" role="tabpanel">
                                <h5><?= $quiz->questions[$j] ?></h5>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>
<?php include(PREPEND_PATH . "views/partials/footer.php"); ?>
<?php include(PREPEND_PATH . "views/partials/foot.php"); ?>
<script>
    let base_url = $('meta[name="_base_url"]').attr('content');
</script>
</body>
</html>
