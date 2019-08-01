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
    if (!($query = $mysql->prepare("SELECT * FROM interviews WHERE id = ?"))) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
    } else {
        if (!$query->bind_param("i", $_GET['id'])) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
        } else {
            $query->execute();

            $result = $query->get_result();

            if ($result->num_rows === 0) {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find interview as referenced!</div>';
            } else {
                $query = $mysql->prepare("DELETE FROM `interviews` WHERE `id` = ?");
                $query->bind_param("i", $_GET['id']);
                $query->execute();

                $query = $mysql->prepare("DELETE FROM `interviews_answers` WHERE `interview_id` = ?");
                $query->bind_param("i", $_GET['id']);
                $query->execute();

                if ($query->affected_rows === -1) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to delete interview!</div>';
                } elseif ($query->affected_rows === 0) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Failed to delete interview!</div>';
                } else {
                    $_SESSION['flash'] = '<div class="alert alert-success" role="alert">Interview deleted successfully!</div>';
                }
            }
        }
    }
} else {
    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">No reference provided!</div>';

    header('location: /interviews/index.php');
    exit();
}

?>