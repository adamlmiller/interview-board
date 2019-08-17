<?php

$title = 'Read :: Questions';

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/header.php';

if (!($query = $mysql->prepare("SELECT * FROM questions WHERE id = ?"))) {
    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
} else {
    if (!$query->bind_param("i", $_GET['id'])) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
    } else {
        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find question as referenced!</div>';
        } else {
            $question = $result->fetch_assoc();
        }
    }
}

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
