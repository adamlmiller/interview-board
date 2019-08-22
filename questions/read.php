<?php

$title = 'Read :: Questions';

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/header.php';

$question = new Question();
$question = $question->read($_GET['id']);

?>
<div class="header">
    <div class="row">
        <div class="col-6">
            <h1><i class="fas fa-question"></i> Questions :: Read</h1>
        </div>
        <div class="col-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>
<?php if (!empty($question)) { ?>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <strong><?php echo $question['name']; ?></strong>
                    <br />
                    <p><?php echo $question['question']; ?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php include __DIR__ . '/../common/footer.php'; ?>
