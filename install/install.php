<?php include __DIR__ . '/../common/config.php'; ?>
<?php include __DIR__ . '/../common/database.php'; ?>
<?php include __DIR__ . '/header.php'; ?>
<div class="row">
    <div class="col-12">
        <div class="box">
            <p class="box-body">
                <?php if (empty($_GET['step'])) { ?>
                    <h1>Welcome</h1>

                    <hr />

                    <p>Welcome to <strong>Interview Portal</strong> installation process! Just fill in the information below and you will be on your way to creating interviews, managing job postings and candidates and more!</p>

                    <br />

                    <h1>Information Needed</h1>

                    <hr />

                    <form action="install.php?step=2" id="frmSettings" method="post">
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
                        <div class="form-group row">
                            <label for="confirm" class="col-3 col-form-label"><strong>Confirm</strong></label>
                            <div class="col-4">
                                <input name="password" type="password" class="form-control" id="confirm" placeholder="Confirm Password">
                            </div>
                        </div>

                        <br />

                        <button type="submit" class="btn btn-outline-info">Continue with Installation</button>
                    </form>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#phone').mask('(000) 000-0000', {placeholder: "(000) 000-0000"});
                            $("#frmSettings").validate({
                                rules: {
                                    app_name: {
                                        required: true,
                                        normalizer: function(value) {
                                            return $.trim(value);
                                        }
                                    },
                                    first_name: {
                                        required: true,
                                        normalizer: function(value) {
                                            return $.trim(value);
                                        },
                                        minlength: 2,
                                        maxlength: 32
                                    },
                                    last_name: {
                                        required: true,
                                        normalizer: function(value) {
                                            return $.trim(value);
                                        },
                                        minlength: 2,
                                        maxlength: 32
                                    },
                                    phone: {
                                        required: true,
                                        normalizer: function(value) {
                                            return $.trim(value);
                                        }
                                    },
                                    email: {
                                        required: true,
                                        normalizer: function(value) {
                                            return $.trim(value);
                                        },
                                        email: true
                                    },
                                    password: {
                                        required: true,
                                        normalizer: function(value) {
                                            return $.trim(value);
                                        },
                                        minlength: 8
                                    },
                                    confirm: {
                                        equalTo: '#password'
                                    }
                                }
                            });
                        });
                    </script>
                <?php } ?>

                <?php

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_GET['step']) && $_GET['step'] == 2)) {
                    $app_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/';

                    $mysql->query("DROP TABLE IF EXISTS `interviews`;");
                    $mysql->query("CREATE TABLE `interviews` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL DEFAULT '0', `first_name` varchar(32) DEFAULT '', `last_name` varchar(32) DEFAULT '', `email` varchar(96) DEFAULT '', `phone` varchar(14) DEFAULT '(000) 000-0000', `date` date DEFAULT NULL, `method` varchar(64) DEFAULT NULL, `qa` text, `notes` text, `hire` smallint(1) DEFAULT '0', `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
                    $mysql->query("DROP TABLE IF EXISTS `interviews_answers`;");
                    $mysql->query("CREATE TABLE `interviews_answers` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `interview_id` int(11) DEFAULT NULL, `question_id` int(11) DEFAULT NULL, `answer` text, `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
                    $mysql->query("DROP TABLE IF EXISTS `options`;");
                    $mysql->query("CREATE TABLE `options` (`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT, `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '', `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `type` varchar(32) DEFAULT 'system', `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE KEY `name` (`name`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
                    $mysql->query("DROP TABLE IF EXISTS `questions`;");
                    $mysql->query("CREATE TABLE `questions` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `questions_categories_id` int(11) NOT NULL, `name` varchar(128) NOT NULL DEFAULT '', `question` text NOT NULL, `active` tinyint(1) DEFAULT '1', `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;");
                    $mysql->query("DROP TABLE IF EXISTS `questions_categories`;");
                    $mysql->query("CREATE TABLE `questions_categories` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `name` varchar(128) NOT NULL DEFAULT '', `description` text NOT NULL, `active` tinyint(1) DEFAULT '1', `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;");
                    $mysql->query("DROP TABLE IF EXISTS `users`;");
                    $mysql->query("CREATE TABLE `users` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `first_name` varchar(32) DEFAULT NULL, `last_name` varchar(32) DEFAULT NULL, `email` varchar(96) DEFAULT NULL, `password` varchar(128) DEFAULT NULL, `phone` varchar(14) DEFAULT '(000) 000-0000', `active` tinyint(1) DEFAULT '0', `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, `lastlogin` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
                    $mysql->query("DROP TABLE IF EXISTS `regions`;");
                    $mysql->query("CREATE TABLE `regions` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', `region` varchar(32) DEFAULT NULL, `active` tinyint(1) DEFAULT '1', `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
                    $mysql->query("INSERT INTO `regions` (`name`, `region`, `active`) VALUES ('US East (Ohio)','us-east-2',1), ('US East (N. Virginia)','us-east-1',1), ('US West (N. California)','us-west-1',1), ('US West (Oregon)','us-west-2',1), ('Asia Pacific (Hong Kong)','ap-east-1',1), ('Asia Pacific (Mumbai)','ap-south-1',1), ('Asia Pacific (Osaka-Local)','ap-northeast-3',1), ('Asia Pacific (Seoul)','ap-northeast-2',1), ('Asia Pacific (Singapore)','ap-southeast-1',1), ('Asia Pacific (Sydney)','ap-southeast-2',1), ('Asia Pacific (Tokyo)','ap-northeast-1',1), ('Canada (Central)','ca-central-1',1), ('China (Beijing)','cn-north-1',1), ('China (Ningxia)','cn-northwest-1',1), ('EU (Frankfurt)','eu-central-1',1), ('EU (Ireland)','eu-west-1',1), ('EU (London)','eu-west-2',1), ('EU (Paris)','eu-west-3',1), ('EU (Stockholm)','eu-north-1',1), ('Middle East (Bahrain)','me-south-1',1), ('South America (Sao Paulo)','sa-east-1',1), ('AWS GovCloud (US-East)','us-gov-east-1',1), ('AWS GovCloud (US-West)','us-gov-west-1',1);");
                    $mysql->query("INSERT INTO `options` SET `name` = 'allow_signup', `value` = '1', `type` = 'system';");
                    $mysql->query("INSERT INTO `options` SET `name` = 'email_from', `type` = 'system';");
                    $mysql->query("INSERT INTO `options` SET `name` = 'aws_key', `type` = 'system';");
                    $mysql->query("INSERT INTO `options` SET `name` = 'aws_secret', `type` = 'system';");
                    $mysql->query("INSERT INTO `options` SET `name` = 'aws_region', `type` = 'system';");
                    $mysql->query("INSERT INTO `options` SET `name` = 'app_url', `value` = '{$app_url}', `type` = 'system';");
                    $mysql->query("INSERT INTO `options` SET `name` = 'app_url', `value` = '{$_POST['app_name']}', `type` = 'system';");

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
                                    echo '<a class="btn btn-outline-info" href="../index.php">Go to Sign In</a>';
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
                }

                ?>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
