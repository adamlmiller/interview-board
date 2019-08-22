<?php

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/database.php';
include __DIR__ . '/../common/classes.php';

if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['action'] == 'delete') && (isset($_POST['id']))) {
    if ($_POST['id'] == $_SESSION['user']['id']) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">You cannot delete your own user</div>';
    } else {
        $user = new User();

        if ($user->delete($_POST['id'])) {
            $_SESSION['flash'] = '<div class="alert alert-info" role="alert">User deleted successfully</div>';
        } else {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Failed to delete user</div>';
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