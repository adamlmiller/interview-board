<?php

/*
 * We're going to include our session
 * controller to check for an active
 * session.
 */
include '../common/session.php';

/*
 * We're going to include our database
 * directly because we do not need the
 * header here.
 */
include '../common/database.php';

if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['action'] == 'delete') && (isset($_POST['id']))) {
    if (!($query = $mysql->prepare("SELECT * FROM questions WHERE id = ?"))) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
    } else {
        if (!$query->bind_param("i", $_POST['id'])) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
        } else {
            $query->execute();

            $result = $query->get_result();

            if ($result->num_rows === 0) {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find question as referenced!</div>';
            } else {
                $query = $mysql->prepare("DELETE FROM `interviews_answers` WHERE `question_id` = ?");
                $query->bind_param("i", $_POST['id']);
                $query->execute();

                $query = $mysql->prepare("DELETE FROM `questions` WHERE `id` = ?");
                $query->bind_param("i", $_POST['id']);
                $query->execute();

                if ($query->affected_rows === -1) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to delete question!</div>';
                } elseif ($query->affected_rows === 0) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Failed to delete question!</div>';
                } else {
                    $_SESSION['flash'] = '<div class="alert alert-success" role="alert">Question deleted successfully!</div>';
                }
            }
        }
    }

    header('location: /questions/index.php');
    exit();
}

?>

<form action="/questions/delete.php" method="post">
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />

    <div class="modal-header modal-header-danger">
        <h5 class="modal-title" id="modalDeleteLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
        Are you sure you want to delete this question? This <strong>cannot</strong> be undone! <strong>It will be removed from all interviews including the interviewees answer!</strong>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i> DELETE</button>
    </div>
</form>
