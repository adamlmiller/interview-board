<?php

/*
 * We're going to include our session
 * controller to check for an active
 * session.
 */
include 'common/session.php';

/*
 * We're going to include our header which
 * is going to be common throughout our
 * entire application.
 */
include 'common/header.php';

if (!($query = $mysql->prepare("SELECT * FROM users WHERE id = ?"))) {
    $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query! <strong>Error: </strong> ' . $query->error . '</div>';
} else {
    if (!$query->bind_param("i", $_GET['id'])) {
        $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query! <strong>Error: </strong> ' . $query->error . '</div>';
    } else {
        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows === 0) {
            $flash = '<div class="alert alert-danger" role="alert">Unable to find user as referenced!</div>';
        } else {
            $user = $result->fetch_assoc();
        }
    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1>Users :: Update</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>

<?php if (isset($flash)) echo $flash; ?>
<?php if (isset($user)) { ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="box">
                <div class="box-body">
                    <form action="users.php" method="post">
                        <input name="action" value="update" type="hidden">
                        <input name="id" value="<?php echo $user['id']; ?>" type="hidden">

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
                            <label for="email">E-Mail Address</label>
                            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="username@domain.com" value="<?php echo $user['email']; ?>">
                            <small id="emailHelp" class="form-text text-muted">Enter the users e-mail address.</small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Password">
                            <small id="passwordHelp" class="form-text text-muted">Enter a password for the user. <strong>LEAVE BLANK TO NOT CHANGE!</strong></small>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php

/*
 * Here, we're including our footer which
 * is going to be common throughout our
 * entire application just like the header.
 */
include 'common/footer.php';

?>
