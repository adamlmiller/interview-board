<?php

if (isset($_SESSION['allowed']) && $_SESSION['allowed'] === true) {
    header('location: index.php');
}

$title = 'Sign In';

include __DIR__ . '/common/header_signin.php';

$flash = null;
$emptyEmail = false;
$emptyPassword = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty(trim($_POST['email'])))
        $emptyEmail = true;

    if (empty(trim($_POST['password'])))
        $emptyPassword = true;

    if ($emptyEmail || $emptyPassword)
        $flash = 'Please check all required fields!';

    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
        if (!($query = $mysql->prepare("SELECT id, email, password, lastlogin FROM users WHERE email = ?"))) {
            $flash = 'Error occurred when trying to prepare query!';
        } else {
            if (!$query->bind_param("s", $_POST['email'])) {
                $flash = 'Error occurred trying to find account!';
            } else {
                $query->execute();

                $result = $query->get_result();

                if ($result->num_rows === 0) {
                    $flash = 'No account for supplied e-mail address!';
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
                            $flash = 'Error occurred trying update last login!';
                        } else {
                            if (!$query->bind_param("i", $user['id'])) {
                                $flash = 'Error occurred when trying to bind parameters to query!';
                            } else {
                                $query->execute();

                                header('location: index.php');
                                exit();
                            }
                        }
                    } else {
                        $flash = 'Incorrect password!';
                    }
                }
            }
        }
    }
}

?>

<form action="signin.php" method="post" class="form-signin">
    <div class="text-center"><img src="/image/interview-color.png" /></div>

    <br />

    <?php if (!empty($flash)) { ?><div class="alert alert-danger" role="alert"><?php echo $flash; ?></div><?php } ?>
    <div class="form-group">
        <label for="email">E-Mail Address</label>
        <input name="email" type="email" id="email" class="form-control <?php echo ($emptyEmail === true ? 'form-error' : ''); ?>" placeholder="E-Mail Address" autofocus autocomplete="false">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input name="password" type="password" id="password" class="form-control <?php echo ($emptyPassword === true ? 'form-error' : ''); ?>" placeholder="Password">
    </div>
    <button class="btn btn-info btn-block" type="submit">Sign In</button>
</form>

<?php include __DIR__ . '/common/footer.php'; ?>
