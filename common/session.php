<?php

include __DIR__ . '/config.php';

if (!isset($_SESSION['allowed']) || $_SESSION['allowed'] !== true) {
    header('location: signin.php');
    exit();
}