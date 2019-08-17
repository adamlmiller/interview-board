<?php

$title = 'Read :: Question Category';

include __DIR__ . '/../../common/session.php';
include __DIR__ . '/../../common/header.php';

if (!($query = $mysql->prepare("SELECT * FROM questions_categories WHERE id = ?"))) {
    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
} else {
    if (!$query->bind_param("i", $_GET['id'])) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
    } else {
        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find question category as referenced!</div>';
        } else {
            $category = $result->fetch_assoc();
        }
    }
}

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
    </div>
<?php } ?>

<?php include __DIR__ . '/../../common/footer.php'; ?>
