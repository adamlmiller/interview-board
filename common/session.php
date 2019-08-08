<?php

/*
 * This is going to ensure that we have the database
 * connection established on each page where the
 * header is included. Should you need it on a page
 * where the header is not included, you can
 * reference the database.php file directly
 * from that file.
 */
include __DIR__ . '/config.php';

/*
 * We're going to control the user
 * sessions from here. This will
 * check for a session on each page.
 * If there is no session, the user
 * will be redirected to the sign in
 * page where they can sign in. For
 * any pages that do not require an
 * active session, do not include
 * this file.
 */

if (!isset($_SESSION['allowed']) || $_SESSION['allowed'] !== true) {
    header('location: signin.php');
    exit();
}