<?php

if (isset($_SESSION['allowed']) && $_SESSION['allowed'] === true) {
    header('location: index.php');
}

$title = 'Forgot Password';

include __DIR__ . '/common/header_auth.php';

$flash = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($query = $mysql->prepare("SELECT `id` FROM `users` WHERE `email` = ?")) {
        if ($query->bind_param('s', $_POST['email'])) {
            if ($query->execute()) {
                $result = $query->get_result();

                if ($result->num_rows === 0) {
                    $flash = '<div class="alert alert-danger" role="alert">No account found</div>';
                } else {
                    $user = $result->fetch_assoc();

                    $utility = new Utility();
                    $code = $utility->generateString();

                    if ($query = $mysql->prepare("UPDATE `users` SET `code` = ? WHERE `id` = ?")) {
                        if ($query->bind_param('si', $code, $user['id'])) {
                            if ($query->execute()) {
                                $url = $system['app_url'] . 'reset.php?code=' . $code;

                                /**
                                 * NEED TO SEND RESET E-MAIL
                                 */

                                $flash = '<div class="alert alert-info" role="alert">Reset e-mail sent</div>';
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
        <form action="" id="frmForgot" method="post" class="form-auth">
            <?php if (!empty($flash)) { ?><?php echo $flash; ?><?php } ?>
            <div class="form-group">
                <label for="email">E-Mail Address</label>
                <input name="email" type="email" id="email" class="form-control" placeholder="E-Mail Address" autofocus autocomplete="false">
            </div>
            <div class="row">
                <div class="col-6">
                    <button class="btn btn-outline-info btn-block" type="button" onclick="history.back();"><i class="fa fa-arrow-left"></i> Back</button>
                </div>
                <div class="col-6">
                    <button class="btn btn-info btn-block" type="submit">Reset <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <span class="text-muted text-small">Don't have an account?</span> <a href="/signup.php">Create one</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#frmForgot").validate({
            rules: {
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

<?php include __DIR__ . '/common/footer.php'; ?>
