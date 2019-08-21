<?php

if (isset($_SESSION['allowed']) && $_SESSION['allowed'] === true) {
    header('location: index.php');
}

$title = 'Sign In';

include __DIR__ . '/common/header_auth.php';

$flash = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
        if (!($query = $mysql->prepare("SELECT id, email, password, lastlogin FROM users WHERE email = ?"))) {
            $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query</div>';
        } else {
            if (!$query->bind_param("s", $_POST['email'])) {
                $flash = '<div class="alert alert-danger" role="alert">Error occurred trying to find account</div>';
            } else {
                $query->execute();

                $result = $query->get_result();

                if ($result->num_rows === 0) {
                    $flash = '<div class="alert alert-danger" role="alert">No account for supplied e-mail address</div>';
                } else {
                    $user = $result->fetch_assoc();

                    if (password_verify(trim($_POST['password']), $user['password'])) {
                        session_start();

                        $_SESSION['allowed'] = true;
                        $_SESSION['user'] = [
                            'id' => $user['id'],
                            'email' => $user['email'],
                            'lastlogin' => $user['lastlogin']
                        ];

                        if (!($query = $mysql->prepare("UPDATE users SET lastlogin = NOW() WHERE id = ?"))) {
                            $flash = '<div class="alert alert-danger" role="alert">Error occurred trying update last login</div>';
                        } else {
                            if (!$query->bind_param("i", $user['id'])) {
                                $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query</div>';
                            } else {
                                $query->execute();

                                header('location: index.php');
                                exit();
                            }
                        }
                    } else {
                        $flash = '<div class="alert alert-danger" role="alert">Incorrect password</div>';
                    }
                }
            }
        }
    }
}

if ($query = $mysql->query("SELECT * FROM options WHERE type = 'system'")) {
    $settings = [];

    if (count($query->num_rows) >= 1) {
        while ($setting = $query->fetch_assoc()) {
            $settings[$setting['name']] = $setting['value'];
        }
    }
}

?>

<div class="box">
    <div class="box-body">
        <form action="" id="frmSignin" method="post" class="form-auth">
            <?php if (!empty($flash)) { ?><?php echo $flash; ?><?php } ?>
            <div class="form-group">
                <label for="email">E-Mail Address</label>
                <input name="email" type="email" id="email" class="form-control" placeholder="E-Mail Address" autofocus autocomplete="false">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input name="password" type="password" id="password" class="form-control" placeholder="Password">
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-info btn-block" type="submit">Sign In <i class="fa fa-sign-in-alt"></i></button>
                </div>
            </div>

            <br />

            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <a href="/forgot.php"><i class="fa fa-lock"></i> Forgot Password</a>
                    </div>
                </div>
            </div>

            <?php if ($settings['allow_signup']) { ?>
                <hr />

                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <span class="text-muted text-small">Don't have an account?</span> <a href="/signup.php">Create one</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#frmSignin").validate({
            rules: {
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
                }
            }
        });
    });
</script>

<?php include __DIR__ . '/common/footer.php'; ?>
