<?php

include __DIR__ . '/config.php';
include __DIR__ . '/database.php';
include __DIR__ . '/system.php';
include __DIR__ . '/../includes/class.utility.php';
include __DIR__ . '/../includes/class.paginator.php';
include __DIR__ . '/../includes/class.email.php';

if ($app = $mysql->query("SELECT value FROM options WHERE name = 'app_name'")) {
    $title = $title . ' :: ' . $app->fetch_assoc()['value'];
} else {
    $title = $title . ' :: Interview Portal';
}

$path = explode('/', $_SERVER['REQUEST_URI'])[1];

if (!empty(explode('/', $_SERVER['REQUEST_URI'])[2]) && (explode('/', $_SERVER['REQUEST_URI'])[2] != basename($_SERVER['PHP_SELF']))) $path = explode('/', $_SERVER['REQUEST_URI'])[2];

?>
<html>
<head>
    <title><?php echo $title; ?></title>
    <link href="/stylesheet/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/stylesheet/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="/stylesheet/fontawesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
    <link href="/stylesheet/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/javascript/jquery.min.js"></script>
    <script type="text/javascript" src="/javascript/jquery.mask.min.js"></script>
    <script type="text/javascript" src="/javascript/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/javascript/fullcalendar.min.js"></script>
    <script type="text/javascript" src="/javascript/popper.min.js"></script>
    <script type="text/javascript" src="/javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="/javascript/bootstrap-select.min.js"></script>
</head>
<body>

<div class="top">
    <div class="navbar-header"></div>
    <ul class="nav float-right">
        <li><a href="/users/account.php"><i class="fa fa-user"></i> My Account</a></li>
    </ul>
</div>
<div class="sidebar">
    <div class="sidebar-top">
        <a class="brand" href="/"><img src="/image/interview.png" /></a>
    </div>
    <div class="sidebar-middle">
        <ul>
            <li><a<?php echo ($path == '' ? ' class="active"':''); ?> href="/"><i class="fas fa-home"></i></a></li>
            <li><a<?php echo ($path == 'interviews' ? ' class="active"':''); ?> href="/interviews/"><i class="fas fa-address-book"></i></a></li>
            <li><a<?php echo ($path == 'schedule' ? ' class="active"':''); ?> href="/schedule/"><i class="far fa-calendar-alt"></i></a></li>
            <li><a<?php echo ($path == 'questions' ? ' class="active"':''); ?> href="/questions/"><i class="fas fa-question"></i></a></li>
            <li><a<?php echo ($path == 'categories' ? ' class="active"':''); ?> href="/questions/categories/"><i class="far fa-question-circle"></i></a></li>
            <li><a<?php echo ($path == 'users' ? ' class="active"':''); ?> href="/users/"><i class="fa fa-users"></i></a></li>
        </ul>
    </div>
    <div class="sidebar-bottom">
        <ul>
            <li><a<?php echo ($path == 'settings' ? ' class="active"':''); ?> href="/settings/"><i class="fa fa-cog"></i></a></li>
            <li><a href="/signout.php"><i class="fa fa-sign-out-alt"></i></a></li>
        </ul>
    </div>
</div>
<div class="main">