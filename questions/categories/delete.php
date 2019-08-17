<?php

include __DIR__ . '/../../common/session.php';
include __DIR__ . '/../../common/database.php';

if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['action'] == 'delete') && (isset($_POST['id']))) {
    if (!($query = $mysql->prepare("SELECT * FROM questions_cateogories WHERE id = ?"))) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
    } else {
        if (!$query->bind_param("i", $_POST['id'])) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
        } else {
            $query->execute();

            $result = $query->get_result();

            if ($result->num_rows === 0) {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find question category as referenced!</div>';
            } else {
                $query = $mysql->prepare("DELETE FROM `questions_categories` WHERE `id` = ?");
                $query->bind_param("i", $_POST['id']);
                $query->execute();

                if ($query->affected_rows === -1) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to delete question category!</div>';
                } elseif ($query->affected_rows === 0) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Failed to delete question category!</div>';
                } else {
                    $_SESSION['flash'] = '<div class="alert alert-info" role="alert">Question Category deleted successfully!</div>';
                }
            }
        }
    }

    header('location: /questions/categories/index.php');
    exit();
}

?>

<form action="/questions/categories/delete.php" method="post">
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />

    <div class="modal-header modal-header-danger">
        <h5 class="modal-title" id="modalDeleteLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
        Are you sure you want to delete this question category? This <strong>cannot</strong> be undone!
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i> DELETE</button>
    </div>
</form>
