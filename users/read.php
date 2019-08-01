<?php

/*
 * We're going to include our session
 * controller to check for an active
 * session.
 */
include '../common/session.php';

/*
 * We're going to include our header which
 * is going to be common throughout our
 * entire application.
 */
include '../common/header.php';

if (!($query = $mysql->prepare("SELECT * FROM users WHERE id = ?"))) {
    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
} else {
    if (!$query->bind_param("i", $_GET['id'])) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
    } else {
        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find user as referenced!</div>';
        } else {
            $user = $result->fetch_assoc();
        }
    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1>Users :: Read :: <?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h1>
        </div>
        <div class="col-md-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>

<?php if (!empty($user)) { ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><strong>First Name</strong></td>
                                <td><?php echo $user['first_name']; ?></td>
                                <td><strong>Last Name</strong></td>
                                <td><?php echo $user['last_name']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>E-Mail Address</strong></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><strong>Phone Number</strong></td>
                                <td><?php echo $user['phone']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Created</strong></td>
                                <td><?php echo date("M jS, Y g:i:sA", strtotime($user['created'])); ?></td>
                                <td><strong>Modified</strong></td>
                                <td><?php echo date("M jS, Y g:i:sA", strtotime($user['modified'])); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Last Login</strong></td>
                                <td><?php echo date("M jS, Y g:i:sA", strtotime($user['lastlogin'])); ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
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
include '../common/footer.php';

?>
