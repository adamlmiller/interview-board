<?php

$title = 'My Account';

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'update') {
    if (!empty($_POST['password'])) {
        $user = new User();
        $user->password($_SESSION['user']['id'], $_POST['password']);
    }

    $user = new User();

    if ($user->update($_SESSION['user']['id'], $_POST)) {
        $_SESSION['flash'] = '<div class="alert alert-info" role="alert">Account updated successfully</div>';
    } else {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to update your account</div>';
    }
}

$user = new User();
$user = $user->read($_SESSION['user']['id']);

?>
<div class="header">
    <div class="row">
        <div class="col-6">
            <h1><i class="fa fa-user"></i> My Profile</h1>
        </div>
        <div class="col-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>
<?php if (!empty($_SESSION['flash'])) echo $_SESSION['flash']; unset($_SESSION['flash']); ?>
<?php if (isset($user)) { ?>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <form action="" id="frmAccount" method="post">
                        <input name="action" value="update" type="hidden">

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input name="first_name" type="text" class="form-control" id="first_name" aria-describedby="firstnameHelp" placeholder="First Name" value="<?php echo $user['first_name']; ?>">
                            <small id="firstnameHelp" class="form-text text-muted">Enter the users first name.</small>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input name="last_name" type="text" class="form-control" id="last_name" aria-describedby="lastnameHelp" placeholder="Last Name" value="<?php echo $user['last_name']; ?>">
                            <small id="lastnameHelp" class="form-text text-muted">Enter the users last name.</small>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input name="phone" type="text" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="(000) 000-0000" value="<?php echo $user['phone']; ?>">
                            <small id="phoneHelp" class="form-text text-muted">Enter the interviewees phone number in the proper format. <span class="text-info text-small">Formatting happens automatically.</span></small>
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail Address</label>
                            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="username@domain.com" value="<?php echo $user['email']; ?>">
                            <small id="emailHelp" class="form-text text-muted">Enter the users e-mail address.</small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Password">
                            <small id="passwordHelp" class="form-text text-muted">Enter a password for the user. <span class="text-danger text-small">Leave blank to not change.</span></small>
                        </div>

                        <button type="submit" class="btn btn-block btn-info"><i class="fas fa-save"></i> Save Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#phone').mask('(000) 000-0000', {placeholder: "(000) 000-0000"});
            $("#frmAccount").validate({
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
                    }
                }
            });
        });
    </script>
<?php } ?>
<?php include __DIR__ . '/../common/footer.php'; ?>
