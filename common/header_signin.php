<?php

include __DIR__ . '/config.php';
include __DIR__ . '/database.php';

if ($app = $mysql->query("SELECT value FROM options WHERE name = 'app_name'")) {
    $title = $title . ' :: ' . $app->fetch_assoc()['value'];
} else {
    $title = $title . ' :: Interview Portal';
}

?>
<html>
<head>
    <title><?php echo $title; ?></title>
    <link href="/stylesheet/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/stylesheet/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="/stylesheet/fontawesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/stylesheet/signin.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/javascript/jquery.min.js"></script>
    <script type="text/javascript" src="/javascript/jquery.mask.min.js"></script>
    <script type="text/javascript" src="/javascript/popper.min.js"></script>
    <script type="text/javascript" src="/javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="/javascript/bootstrap-select.min.js"></script>
</head>
<body class="text-center">