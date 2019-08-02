<?php

/*
 * This is going to ensure that we have the database
 * connection established on each page where the
 * header is included. Should you need it on a page
 * where the header is not included, you can
 * reference the database.php file directly
 * from that file.
 */
include 'config.php';
include 'database.php';

?>
<html>
<head>
    <title>Interviews</title>
    <link href="/stylesheet/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/stylesheet/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="/stylesheet/fontawesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/javascript/jquery.min.js"></script>
    <script type="text/javascript" src="/javascript/jquery.mask.min.js"></script>
    <script type="text/javascript" src="/javascript/popper.min.js"></script>
    <script type="text/javascript" src="/javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="/javascript/bootstrap-select.min.js"></script>
</head>
<body>

<div class="top">
    <div class="navbar-header"></div>
    <ul class="nav float-right">
        <li><a href="/users/profile.php"><i class="fa fa-fw fa-user"></i> My Account</a></li>
    </ul>
</div>
<div class="sidebar">
    <div class="sidebar-top">
        <a class="brand" href="/"><img src="/image/interview.png" /></a>
    </div>
    <div class="sidebar-middle">
        <ul>
            <li><a href="/"><i class="fas fa-home"></i></a></li>
            <li><a href="/interviews/"><i class="fas fa-address-book"></i></a></li>
            <li><a href="/questions/"><i class="fas fa-question"></i></a></li>
            <li><a href="/users/"><i class="fa fa-users"></i></a></li>
        </ul>
    </div>
    <div class="sidebar-bottom">
        <ul>
            <li><a href="/signout.php"><i class="fa fa-sign-out-alt"></i></a></li>
        </ul>
    </div>
</div>
<div class="main">