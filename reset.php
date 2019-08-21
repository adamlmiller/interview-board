<?php

if (isset($_SESSION['allowed']) && $_SESSION['allowed'] === true) {
    header('location: /index.php');
}

$title = 'Reset Password';

include __DIR__ . '/common/header_auth.php';

if (empty($_GET['code'])) {
    header('location: /signin.php');
    exit;
} else {
    if ($query = $mysql->prepare("SELECT id FROM `users` WHERE `code` = ?")) {
        if ($query->bind_param("s", $_GET['code'])) {
            if ($query->execute()) {
                if ($results = $query->get_result()) {
                    if ($results->num_rows != 1) {
                        header('location: /signin.php');
                        exit;
                    }
                }
            }
        }
    }
}

$flash = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['code'])) {
        if ($query = $mysql->prepare("SELECT id, email, lastlogin FROM `users` WHERE `code` = ?")) {
            if ($query->bind_param("s", $_POST['code'])) {
                if ($query->execute()) {
                    if ($result = $query->get_result()) {
                        if ($result->num_rows == 1) {
                            $user = $result->fetch_assoc();

                            if ($query = $mysql->prepare("UPDATE `users` SET `password` = ? WHERE `id` = ?")) {
                                if ($query->bind_param("si", password_hash($_POST['password']), $user['id'])) {
                                    if ($query->execute()) {
                                        if ($query->affected_rows === 1) {
                                            session_start();

                                            $_SESSION['allowed'] = true;
                                            $_SESSION['user'] = [
                                                'id' => $user['id'],
                                                'email' => $user['email'],
                                                'lastlogin' => $user['lastlogin']
                                            ];

                                            header('location: /index.php');
                                            exit();
                                        } else {
                                            $flash = '<div class="alert alert-danger" role="alert">Error occurred</div>';
                                        }
                                    } else {
                                        $flash = '<div class="alert alert-danger" role="alert">Error occurred</div>';
                                    }
                                } else {
                                    $flash = '<div class="alert alert-danger" role="alert">Error occurred</div>';
                                }
                            } else {
                                $flash = '<div class="alert alert-danger" role="alert">Error occurred</div>';
                            }
                        } else {
                            $flash = '<div class="alert alert-danger" role="alert">Error occurred</div>';
                        }
                    } else {
                        $flash = '<div class="alert alert-danger" role="alert">Error occurred</div>';
                    }
                } else {
                    $flash = '<div class="alert alert-danger" role="alert">Error occurred</div>';
                }
            } else {
                $flash = '<div class="alert alert-danger" role="alert">Error occurred</div>';
            }
        } else {
            $flash = '<div class="alert alert-danger" role="alert">Error occurred</div>';
        }
    } else {
        $flash = '<div class="alert alert-danger" role="alert">Error occurred</div>';
    }
}

?>

<div class="box">
    <div class="box-body">
        <form action="" id="frmReset" method="post" class="form-auth">
            <input name="code" type="hidden" value="<?php echo $_GET['code']; ?>" />

            <?php if (!empty($flash)) { ?><?php echo $flash; ?><?php } ?>
            <div class="form-group">
                <label for="password">New Password</label>
                <input name="password" type="password" id="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="confirm">Confirm</label>
                <input name="confirm" type="password" id="confirm" class="form-control" placeholder="Confirm Password">
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-info btn-block" type="submit">Change Password <i class="fa fa-sign-in-alt"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#frmReset").validate({
            rules: {
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

<?php include __DIR__ . '/common/footer.php'; ?>
