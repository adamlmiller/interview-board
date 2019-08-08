<?php

/*
 * We're going to include our session
 * controller to check for an active
 * session.
 */
include __DIR__ . '/../common/session.php';

/*
 * We're going to include our database
 * directly because we do not need the
 * header here.
 */
include __DIR__ . '/../common/database.php';

if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['action'] == 'delete') && (isset($_POST['id']))) {
    if ($_POST['id'] == $_SESSION['user']['id']) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">You cannot delete your own user!</div>';

        header('location: /users/index.php');
        exit();
    } else {
        if (!($query = $mysql->prepare("SELECT * FROM users WHERE id = ?"))) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
        } else {
            if (!$query->bind_param("i", $_POST['id'])) {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
            } else {
                $query->execute();

                $result = $query->get_result();

                if ($result->num_rows === 0) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find user as referenced!</div>';
                } else {
                    $query = $mysql->prepare("DELETE FROM `users` WHERE `id` = ?");
                    $query->bind_param("i", $_POST['id']);
                    $query->execute();

                    if ($query->affected_rows === -1) {
                        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to delete user!</div>';
                    } elseif ($query->affected_rows === 0) {
                        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Failed to delete user!</div>';
                    } else {
                        $_SESSION['flash'] = '<div class="alert alert-success" role="alert">User deleted successfully!</div>';
                    }
                }
            }
        }
    }

    header('location: /users/index.php');
    exit();
}

?>

<form action="/users/delete.php" method="post">
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />

    <div class="modal-header modal-header-danger">
        <h5 class="modal-title" id="modalDeleteLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
        Are you sure you want to delete this user? This <strong>cannot</strong> be undone!
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i> DELETE</button>
    </div>
</form>