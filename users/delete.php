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

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    if ($_GET['id'] == $_SESSION['user']['id']) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">You cannot delete your own user!</div>';

        header('location: /users/index.php');
        exit();
    } else {
        if (!($query = $mysql->prepare("SELECT * FROM users WHERE id = ?"))) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
        } else {
            if (!$query->bind_param("i", $_GET['id'])) {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
            } else {
                $query->execute();

                $result = $query->get_result();

                if ($result->num_rows === 0) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find user as referenced!</div>';
                } else {
                    $query = $mysql->prepare("DELETE FROM `users` WHERE `id` = ?");
                    $query->bind_param("i", $_GET['id']);
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

        header('location: /users/index.php');
        exit();
    }
} else {
    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">No reference provided!</div>';

    header('location: /users/index.php');
    exit();
}

?>