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
                $query = $mysql->prepare("DELETE FROM `interviews_answers` WHERE `question_id` = ?");
                $query->bind_param("i", $_GET['id']);
                $query->execute();

                $query = $mysql->prepare("DELETE FROM `questions` WHERE `id` = ?");
                $query->bind_param("i", $_GET['id']);
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
} else {
    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">No reference provided!</div>';

    header('location: /questions/index.php');
    exit();
}

?>