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
    <title>Sign In || Interviews</title>
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