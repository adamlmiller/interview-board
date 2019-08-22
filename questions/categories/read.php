<?php

$title = 'Read :: Question Category';

include __DIR__ . '/../../common/session.php';
include __DIR__ . '/../../common/header.php';

$category = new QuestionCategory();
$category = $category->read($_GET['id']);

?>
<div class="header">
    <div class="row">
        <div class="col-6">
            <h1><i class="far fa-question-circle"></i> Question Category :: Read</h1>
        </div>
        <div class="col-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>
<?php if (!empty($category)) { ?>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <strong><?php echo $category['name']; ?></strong>
                    <br />
                    <p><?php echo $category['description']; ?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php include __DIR__ . '/../../common/footer.php'; ?>
