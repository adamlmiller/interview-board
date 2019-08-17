<?php

$title = 'Settings';

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST AS $key => $value) {
        if ($query = $mysql->prepare("UPDATE `options` SET `value` = ? WHERE `name` = ? AND `type` = 'system'")) {
            if ($query->bind_param("ss", $value, $key)) {
                if ($query->execute()) {
                    $_SESSION['flash'] = '<div class="alert alert-info" role="alert">Settings updated successfully!</div>';
                } else {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save settings!</div>';
                }
            } else {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save settings!</div>';
            }
        } else {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save settings!</div>';
        }
    }
}

if (!($query = $mysql->query("SELECT * FROM options WHERE type = 'system'"))) {
    $_SESSION['flash'] = '';
} else {
    $settings = [];

    if (count($query->num_rows) >= 1) {
        while ($setting = $query->fetch_assoc()) {
            $settings[$setting['name']] = $setting['value'];
        }
    } else {
        $_SESSION['flash'] = '';
    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-12">
            <h1><i class="fa fa-cog"></i> Settings</h1>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['flash'])) echo $_SESSION['flash']; unset($_SESSION['flash']); ?>

<?php if (isset($settings)) { ?>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="app_name">Application Name</label>
                            <input name="app_name" type="text" class="form-control" id="app_name" aria-describedby="appNameHelp" placeholder="Application Name" value="<?php echo $settings['app_name']; ?>">
                            <small id="appNameHelp" class="form-text text-muted">Enter the name of the application.</small>
                        </div>
                        <div class="form-group">
                            <label for="email_from">From E-Mail Address</label>
                            <input name="email_from" type="text" class="form-control" id="email_from" aria-describedby="emailFromHelp" placeholder="E-Mail Address" value="<?php echo $settings['email_from']; ?>">
                            <small id="emailFromHelp" class="form-text text-muted">Enter the e-mail address the e-mail's sent will come from.</small>
                        </div>
                        <div class="form-group">
                            <label for="aws_key">AWS Key</label>
                            <input name="aws_key" type="password" class="form-control" id="aws_key" aria-describedby="awsKeyHelp" placeholder="AWS Key" value="<?php echo $settings['aws_key']; ?>">
                            <small id="awsKeyHelp" class="form-text text-muted">The AWS Key for sending e-mail via SES.</small>
                        </div>
                        <div class="form-group">
                            <label for="aws_secret">AWS Secret</label>
                            <input name="aws_secret" type="password" class="form-control" id="aws_secret" aria-describedby="awsSecretHelp" placeholder="AWS Secret" value="<?php echo $settings['aws_secret']; ?>">
                            <small id="awsSecretHelp" class="form-text text-muted">The AWS Secret for the AWS Key provided.</small>
                        </div>
                        <div class="form-group">
                            <label for="aws_region">AWS Region</label>
                            <select class="form-control selectpicker" name="aws_region">
                                <?php

                                $query = $mysql->query("SELECT `id`,`name`,`region` FROM `regions` WHERE `active` = 1 ORDER BY `name` ASC");

                                while ($region = $query->fetch_assoc()) {
                                    echo '<option value="' . $region['region'] . '"' . ($settings['aws_region'] == $region['region'] ? ' selected' : '') . '>' . $region['name'] . ' (' . $region['region'] . ')</option>';
                                }

                                ?>
                            </select>
                            <small id="awsRegionHelp" class="form-text text-muted">The AWS Region that the Key and Secret belong to.</small>
                        </div>

                        <button type="submit" class="btn btn-block btn-info"><i class="fas fa-save"></i> Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php include __DIR__ . '/../common/footer.php'; ?>
