<?php

if (isset($_SESSION['allowed']) && $_SESSION['allowed'] === true) {
    header('location: index.php');
}

$title = 'Register';

include __DIR__ . '/common/header_auth.php';

if ($query = $mysql->query("SELECT * FROM options WHERE type = 'system'")) {
    $settings = [];

    if (count($query->num_rows) >= 1) {
        while ($setting = $query->fetch_assoc()) {
            $settings[$setting['name']] = $setting['value'];
        }
    }

    if ($settings['allow_signup'] == false) {
        header('location: index.php');
    }
}

$flash = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if ($query = $mysql->prepare("INSERT INTO `users` SET `first_name` = ?, `last_name` = ?, `phone` = ?, `email` = ?, `password` = ?, `active` = 1")) {
        if ($query->bind_param("sssss", $_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['email'], $password)) {
            if ($query->execute()) {
                $user_id = $query->insert_id;

                session_start();

                $_SESSION['allowed'] = true;
                $_SESSION['user'] = [
                    'id' => $user_id,
                    'email' => $_POST['email']
                ];

                if (!($query = $mysql->prepare("UPDATE users SET lastlogin = NOW() WHERE id = ?"))) {
                    $flash = '<div class="alert alert-danger" role="alert">Error occurred trying update last login</div>';
                } else {
                    if (!$query->bind_param("i", $user_id)) {
                        $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query</div>';
                    } else {
                        $query->execute();

                        header('location: /index.php');
                        exit();
                    }
                }
            }
        } else {
            $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to create account!</div>';
        }
    } else {
        $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to create account!</div>';
    }
}

?>

<div class="box">
    <div class="box-body">
        <form action="" id="frmSignup" method="post" class="form-auth">
            <?php if (!empty($flash)) { ?><?php echo $flash; ?><?php } ?>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input name="first_name" type="text" id="first_name" class="form-control" placeholder="First Name" autocomplete="false">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input name="last_name" type="text" id="last_name" class="form-control" placeholder="Last Name" autocomplete="false">
            </div>
            <div class="form-group">
                <label for="email">E-Mail Address</label>
                <input name="email" type="text" id="email" class="form-control" placeholder="E-Mail Address" autocomplete="false">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input name="phone" type="text" id="phone" class="form-control" placeholder="(000) 000-0000">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input name="password" type="password" id="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="confirm">Confirm</label>
                <input name="confirm" type="password" id="confirm" class="form-control" placeholder="Confirm Password">
            </div>
            <div class="row">
                <div class="col-6">
                    <button class="btn btn-outline-info btn-block" type="button" onclick="history.back();"><i class="fa fa-arrow-left"></i> Back</button>
                </div>
                <div class="col-6">
                    <button class="btn btn-info btn-block" type="submit">Sign Up <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#phone').mask('(000) 000-0000', {placeholder: "(000) 000-0000"});
        $("#frmSignup").validate({
            rules: {
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

<?php include __DIR__ . '/../common/footer.php'; ?>
