<?php

if (!isset($_SESSION['allowed']) || $_SESSION['allowed'] !== true) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

include __DIR__ . '/../common/config.php';
include __DIR__ . '/../common/database.php';

if ($query = $mysql->prepare("SELECT id,name FROM questions_categories WHERE active = 1 ORDER BY name ASC")) {
    if ($query->execute()) {
        if ($result = $query->get_result()) {
            $categories = [];

            while ($category = $result->fetch_assoc()) {
                $categories[] = $category;
            }

            header("HTTP/1.1 200 OK");

            echo json_encode($categories);
        } else {
            header("HTTP/1.1 204 No Content");
            exit;
        }
    } else {
        header("HTTP/1.1 204 No Content");
        exit;
    }
}