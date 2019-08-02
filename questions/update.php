<?php

/*
 * We're going to include our session
 * controller to check for an active
 * session.
 */
include '../common/session.php';

/*
 * We're going to include our header which
 * is going to be common throughout our
 * entire application.
 */
include '../common/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'update') {
    if ($query = $mysql->prepare("UPDATE `questions` SET `name` = ?, `question` = ?, `active` = 1 WHERE `id` = ?")) {
        if ($query->bind_param("ssi", $_POST['name'], $_POST['question'], $_POST['id'])) {
            if ($query->execute()) {
                if ($query->affected_rows === -1) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question!</div>';
                } elseif ($query->affected_rows === 0) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Failed to update question! Were any changes made?</div>';
                } else {
                    $_SESSION['flash'] = '<div class="alert alert-success" role="alert">Question updated successfully!</div>';
                }
            } else {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question!</div>';
            }
        } else {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question!</div>';
        }
    } else {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question!</div>';
    }
}

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
        <div class="col-md-6">
            <h1><i class="fas fa-question"></i> Questions :: Update</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['flash'])) echo $_SESSION['flash']; unset($_SESSION['flash']); ?>

<?php if (isset($question)) { ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="box">
                <div class="box-body">
                    <form action="" method="post">
                        <input name="action" value="update" type="hidden">
                        <input name="id" value="<?php echo $question['id']; ?>" type="hidden">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Name" value="<?php echo $question['name']; ?>">
                            <small id="nameHelp" class="form-text text-muted">Enter a short identifier for this question.</small>
                        </div>
                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea name="question" rows="10" class="form-control" id="question" aria-describedby="questionHelp" placeholder="Enter the question here..."><?php echo $question['question']; ?></textarea>
                            <small id="questionHelp" class="form-text text-muted">Please provide your question above. Be as specific as possible and remember to check or grammar and spelling.</small>
                        </div>

                        <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-save"></i> Save Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php

/*
 * Here, we're including our footer which
 * is going to be common throughout our
 * entire application just like the header.
 */
include '../common/footer.php';

?>
