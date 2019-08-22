<?php

$title = 'Read :: Users';

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/header.php';

$user = new User();
$user = $user->read($_GET['id']);

?>
<div class="header">
    <div class="row">
        <div class="col-6">
            <h1><i class="fa fa-users"></i> Users :: Read :: <?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h1>
        </div>
        <div class="col-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>
<?php if (!empty($user)) { ?>
    <div class="row">
        <div class="col-12">
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
<?php include __DIR__ . '/../common/footer.php'; ?>
