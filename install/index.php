<?php include 'header.php'; ?>
<div class="text-center"><img src="/image/interview-color.png" /></a></div>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="box">
            <div class="box-body">
                <?php if (empty($_GET['step'])) { ?>
                    <p>Welcome to <strong>Interview Portal</strong>. Before getting started, we need some information on the database. You will need to know the following items before proceeding.</p>

                    <ol>
                        <li>Database name</li>
                        <li>Database username</li>
                        <li>Database password</li>
                        <li>Database hostname</li>
                        <li>Database port</li>
                    </ol>

                    <p>We are going to use this information to create a <strong>config.php</strong> file. If for any reason this automatic file creation does not work, do not worry. All this does is fill in the database information to a configuration file. You may also mv <strong>common/config.php.example</strong> to <strong>common/config.php</strong> then open it in a text editor, fill in your information, and save it.</p>

                    <p>These settings were supplied to you by your hosting provider. If you do not have this information, then you will need to contact them before you can continue. If you are ready...</p>

                    <br />

                    <a class="btn btn-outline-primary" href="index.php?step=2">Let's do it!</a>
                <?php } ?>

                <?php if ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['step']) && $_GET['step'] == 2)) { ?>
                    <p>Please enter your database connection details below. If you are not sure about these, contact your hosting provider.</p>

                    <form method="post" action="index.php?step=3">
                        <div class="form-group row">
                            <label for="database" class="col-3 col-form-label"><strong>Database Name</strong></label>
                            <div class="col-4">
                                <input name="database" type="text" class="form-control" id="database" value="interview">
                            </div>
                            <div class="col-5 col-form-label">The name of the database.</div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-3 col-form-label"><strong>Database Username</strong></label>
                            <div class="col-4">
                                <input name="username" type="text" class="form-control" id="username" value="username">
                            </div>
                            <div class="col-5 col-form-label">Your database username.</div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-3 col-form-label"><strong>Database Password</strong></label>
                            <div class="col-4">
                                <input name="password" type="password" class="form-control" id="password" value="password">
                            </div>
                            <div class="col-5 col-form-label">Your database password.</div>
                        </div>
                        <div class="form-group row">
                            <label for="hostname" class="col-3 col-form-label"><strong>Database Hostname</strong></label>
                            <div class="col-4">
                                <input name="hostname" type="text" class="form-control" id="hostname" value="localhost">
                            </div>
                            <div class="col-5">You should be able to get this from your hosting provider if <strong>localhost</strong> does not work.</div>
                        </div>

                        <br />

                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </form>
                <?php } ?>

                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_GET['step']) && $_GET['step'] == 3)) { ?>
                    <?php $mysql = mysqli_connect($_POST['hostname'], $_POST['username'], $_POST['password'], $_POST['database']); ?>

                    <?php if (!$mysql) { ?>
                        <h3>Error establishing a database connection</h3>

                        <p>This either means that the username and password your provided are incorrect, that the information in your <strong>config.php</strong> file is incorrect or that we were unable to contact the database server at <strong>localhost</strong>. This could mean your host’s database server is down.</p>

                        <ul>
                            <li>Are you sure you have the correct username and password?</li>
                            <li>Are you sure that you have provided he correct hostname?</li>
                            <li>Are you sure that the database server is running?</li>
                        </ul>

                        <p>If you are unsure what these terms mean you should probably contact your hosting provider.</p>

                        <br />

                        <a href="index.php?step=1" onclick="javascript:history.go(-1);return false;" class="btn btn-outline-primary">Try again</a>
                    <?php } else { ?>
                        <?php

                        $docroot = realpath(__DIR__ . '/..');
                        $source = $docroot . '/common/config.php.example';
                        $destination = $docroot . '/common/config.php';

                        if (file_exists($source)) {
                            if (rename($source, $destination)) {
                                $config = file_get_contents($destination);
                                $config = str_replace("{database}", $_POST['database'], $config);
                                $config = str_replace("{username}", $_POST['username'], $config);
                                $config = str_replace("{password}", $_POST['password'], $config);
                                $config = str_replace("{hostname}", $_POST['hostname'], $config);

                                if (file_put_contents($destination, $config)) {
                                    echo '<p><strong>Congratulations!</strong> You have made it through this part of the installation. We can now communicate with your database. If you are ready...</p><br />';
                                    echo '<a class="btn btn-outline-primary" href="install.php">Run the installation</a>';
                                }
                            } else {
                                echo '<div class="alert alert-danger">Unable to rename <strong>config.php.example</strong> to <strong>config.php</strong>!</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger">Cannot find <strong>config.php.example</strong>!</div>';
                        }

                        ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
