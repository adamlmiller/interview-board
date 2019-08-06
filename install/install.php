<?php include '../common/config.php'; ?>
<?php include '../common/database.php'; ?>
<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="box">
            <p class="box-body">

                <?php if (empty($_GET['step'])) { ?>
                    <h1>Welcome</h1>

                    <hr />

                    <p>Welcome to <strong>Interview Portal</strong> installation process! Just fill in the information below and you will be on your way to creating interviews, managing job postings and candidates and more!</p>

                    <br />

                    <h1>Information Needed</h1>

                    <hr />

                    <form method="post" action="install.php?step=2">
                        <div class="form-group row">
                            <label for="app_name" class="col-3 col-form-label"><strong>Application Name</strong></label>
                            <div class="col-4">
                                <input name="app_name" type="text" class="form-control" id="app_name" value="Interview Portal" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="first_name" class="col-3 col-form-label"><strong>First Name</strong></label>
                            <div class="col-4">
                                <input name="first_name" type="text" class="form-control" id="first_name" placeholder="First Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-3 col-form-label"><strong>Last Name</strong></label>
                            <div class="col-4">
                                <input name="last_name" type="text" class="form-control" id="last_name" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-3 col-form-label"><strong>Phone Number</strong></label>
                            <div class="col-4">
                                <input name="phone" type="text" class="form-control" id="phone" placeholder="(000) 000-0000">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-3 col-form-label"><strong>E-Mail Address</strong></label>
                            <div class="col-4">
                                <input name="email" type="email" class="form-control" id="email" placeholder="username@domain.com">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-3 col-form-label"><strong>Password</strong></label>
                            <div class="col-4">
                                <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                            </div>
                        </div>

                        <br />

                        <button type="submit" class="btn btn-outline-primary">Continue with Installation</button>
                    </form>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#phone').mask('(000) 000-0000', {placeholder: "(000) 000-0000"});
                        });
                    </script>
                <?php } ?>

                <?php

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_GET['step']) && $_GET['step'] == 2)) {
                    $mysql->query("DROP TABLE IF EXISTS `interviews`");
                    $mysql->query("CREATE TABLE `interviews` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL DEFAULT '0', `first_name` varchar(32) DEFAULT '', `last_name` varchar(32) DEFAULT '', `email` varchar(96) DEFAULT '', `phone` varchar(14) DEFAULT '(000) 000-0000', `date` date DEFAULT NULL, `method` varchar(64) DEFAULT NULL, `qa` text, `notes` text, `hire` smallint(1) DEFAULT '0', `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
                    $mysql->query("DROP TABLE IF EXISTS `interviews_answers`");
                    $mysql->query("CREATE TABLE `interviews_answers` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `interview_id` int(11) DEFAULT NULL, `question_id` int(11) DEFAULT NULL, `answer` text, `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
                    $mysql->query("DROP TABLE IF EXISTS `options`");
                    $mysql->query("CREATE TABLE `options` (`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT, `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '', `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE KEY `name` (`name`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                    $mysql->query("DROP TABLE IF EXISTS `questions`");
                    $mysql->query("CREATE TABLE `questions` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `name` varchar(128) NOT NULL DEFAULT '', `question` text NOT NULL, `active` tinyint(1) DEFAULT '1', `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
                    $mysql->query("DROP TABLE IF EXISTS `users`");
                    $mysql->query("CREATE TABLE `users` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `first_name` varchar(32) DEFAULT NULL, `last_name` varchar(32) DEFAULT NULL, `email` varchar(96) DEFAULT NULL, `password` varchar(128) DEFAULT NULL, `phone` varchar(14) DEFAULT '(000) 000-0000', `active` tinyint(1) DEFAULT '0', `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, `lastlogin` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");

                    if ($query = $mysql->prepare("INSERT INTO `options` SET name = 'app_name', value = ?")) {
                        if ($query->bind_param('s', $_POST['app_name'])) {
                            if ($query->execute()) {
                                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                                if ($query = $mysql->prepare("INSERT INTO `users` SET `first_name` = ?, `last_name` = ?, `phone` = ?, `email` = ?, `password` = ?, `active` = 1")) {
                                    if ($query->bind_param("sssss", $_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['email'], $password)) {
                                        if ($query->execute()) {
                                            if ($query->affected_rows === -1) {
                                                echo '<div class="alert alert-danger" role="alert">Error occurred when trying to save user!';
                                            } elseif ($query->affected_rows === 0) {
                                                echo '<div class="alert alert-danger" role="alert">Failed to save user!</div>';
                                            } else {
                                                echo '<h1>Success!</h1>';
                                                echo '<hr />';
                                                echo '<p>Your <strong>Interview Portal</strong> has been installed successfully! Thank you, and enjoy!</p>';
                                                echo '<br />';
                                                echo '<a class="btn btn-outline-primary" href="../index.php">Go to Sign In</a>';
                                            }
                                        } else {
                                            echo '<div class="alert alert-danger" role="alert">Error occurred when trying to save user!</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Error occurred when trying to save user!</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Error occurred when trying to save user!</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Error occurred when trying to save application name!</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Error occurred when trying to save application name!</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error occurred when trying to save application name!</div>';
                    }
                }

                ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
