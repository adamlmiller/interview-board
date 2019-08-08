<?php

if (!isset($_SESSION['allowed']) || $_SESSION['allowed'] !== true) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

include __DIR__ . '/../common/config.php';
include __DIR__ . '/../common/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['questions_categories_id'])) {
    if ($query = $mysql->prepare("SELECT id,name FROM questions WHERE questions_categories_id = ? AND active = 1 ORDER BY name ASC")) {
        if ($query->bind_param("i", $_GET['questions_categories_id'])) {
            if ($query->execute()) {
                if ($result = $query->get_result()) {
                    $questions = [];

                    while ($question = $result->fetch_assoc()) {
                        $questions[] = $question;
                    }

                    header("HTTP/1.1 200 OK");

                    echo json_encode($questions);
                }
            } else {
                header("HTTP/1.1 204 No Content");
                exit;
            }
        } else {
            header("HTTP/1.1 204 No Content");
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    if ($query = $mysql->prepare("SELECT id,name,question FROM questions WHERE id = ?")) {
        if ($query->bind_param("i", $_GET['id'])) {
            if ($query->execute()) {
                if ($result = $query->get_result()) {
                    header("HTTP/1.1 200 OK");

                    echo json_encode($result->fetch_assoc());
                }
            } else {
                header("HTTP/1.1 204 No Content");
                exit;
            }
        } else {
            header("HTTP/1.1 204 No Content");
            exit;
        }
    }
}