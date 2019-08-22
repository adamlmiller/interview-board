<?php

$title = 'Create :: Users';

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'create') {
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $user = new User();

    if ($user->create($_POST)) {
        $_SESSION['flash'] = '<div class="alert alert-info" role="alert">User created successfully</div>';
    } else {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Failed to create user</div>';
    }

    header('location: /users/index.php');

    exit();
}

?>
<div class="header">
    <div class="row">
        <div class="col-6">
            <h1><i class="fa fa-users"></i> Users :: Create</h1>
        </div>
        <div class="col-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-body">
                <form action="" id="frmCreate" method="post">
                    <input name="action" value="create" type="hidden">

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input name="first_name" type="text" class="form-control" id="first_name" aria-describedby="firstnameHelp" placeholder="First Name">
                        <small id="firstnameHelp" class="form-text text-muted">Enter the users first name.</small>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input name="last_name" type="text" class="form-control" id="last_name" aria-describedby="lastnameHelp" placeholder="Last Name">
                        <small id="lastnameHelp" class="form-text text-muted">Enter the users last name.</small>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input name="phone" type="text" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="(000) 000-0000">
                        <small id="phoneHelp" class="form-text text-muted">Enter the interviewees phone number in the proper format. <span class="text-info text-small">Formatting happens automatically.</span></small>
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail Address</label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="username@domain.com">
                        <small id="emailHelp" class="form-text text-muted">Enter the users e-mail address.</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Password">
                        <small id="passwordHelp" class="form-text text-muted">Enter a password for the user.</small>
                    </div>
                    <div class="form-group">
                        <label for="confirm">Confirm</label>
                        <input name="confirm" type="password" class="form-control" id="confirm" aria-describedby="confirmHelp" placeholder="Confirm Password">
                        <small id="confirmHelp" class="form-text text-muted">Confirm the password previously entered.</small>
                    </div>
                    <div class="form-group">
                        <label for="active">Active</label>
                        <select class="form-control selectpicker" name="active">
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6"><a class="btn btn-block btn-outline-dark" href="/users/"><i class="fas fa-ban"></i> Cancel</a></div>
                        <div class="col-6"><button type="submit" class="btn btn-block btn-info"><i class="fas fa-save"></i> Save User</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#phone').mask('(000) 000-0000', {placeholder: "(000) 000-0000"});
        $("#frmCreate").validate({
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
