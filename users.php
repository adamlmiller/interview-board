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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'create') {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $insert = $mysql->prepare("INSERT INTO `users` SET `first_name` = ?, `last_name` = ?, `email` = ?, `password` = ?, `active` = 1");
        $insert->bind_param("ssss", $_POST['first_name'], $_POST['last_name'], $_POST['email'], $password);
        $insert->execute();

        if ($insert->affected_rows === -1) {
            $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to save new user! <strong>Error: </strong> ' . $insert->error . '</div>';
        } elseif ($insert->affected_rows === 0) {
            $flash = '<div class="alert alert-danger" role="alert">Failed to save new user!</div>';
        } else {
            $flash = '<div class="alert alert-success" role="alert">User created successfully!</div>';
        }

        $insert->close();
    }

    if ($_POST['action'] == 'update') {
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $update = $mysql->prepare("UPDATE `users` SET `first_name` = ?, `last_name` = ?, `email` = ?, `password` = ?, `active` = 1 WHERE `id` = ?");
            $update->bind_param("ssssi", $_POST['first_name'], $_POST['last_name'], $_POST['email'], $password, $_POST['id']);
            $update->execute();
        } else {
            $update = $mysql->prepare("UPDATE `users` SET `first_name` = ?, `last_name` = ?, `email` = ?, `active` = 1 WHERE `id` = ?");
            $update->bind_param("sssi", $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['id']);
            $update->execute();
        }

        if ($update->affected_rows === -1) {
            $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to update user! <strong>Error: </strong> ' . $update->error . '</div>';
        } elseif ($update->affected_rows === 0) {
            $flash = '<div class="alert alert-danger" role="alert">Failed to update user! Were any changes made?</div>';
        } else {
            $flash = '<div class="alert alert-success" role="alert">User updated successfully!</div>';
        }

        $update->close();
    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1>Users</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <button class="btn btn-dark" onclick="window.location.href = 'users_create.php';"><i class="fas fa-plus-square"></i> Create User</button>
            </div>
        </div>
    </div>
</div>

<?php if (isset($flash)) echo $flash; ?>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" width="25px">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">E-Mail</th>
                            <th scope="col" width="75px">Active</th>
                            <th scope="col" width="175px">Created</th>
                            <th scope="col" width="175px">Modified</th>
                            <th scope="col" width="175px">Last Login</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                        if ($result = $mysql->query("SELECT * FROM users ORDER BY first_name, last_name ASC")) {
                            if ($result->num_rows >= 1) {
                                while ($user = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '  <td>' . $user['id'] . '</td>';
                                    echo '  <td><a href="users_update.php?id=' . $user['id'] . '">' . $user['first_name'] . ' ' . $user['last_name'] . '</a></td>';
                                    echo '  <td>' . $user['email'] . '</td>';
                                    echo '  <td>' . ($user['active'] ? '<span class="badge badge-pill badge-success">Active</span>':'<span class="badge badge-pill badge-danger">Disabled</span>') . '</td>';
                                    echo '  <td>' . date("M jS, Y g:i:sA", strtotime($user['created'])) . '</td>';
                                    echo '  <td>' . date("M jS, Y g:i:sA", strtotime($user['modified'])) . '</td>';
                                    echo '  <td>' . ($user['lastlogin'] ? date("M jS, Y g:i:sA", strtotime($user['lastlogin'])) : '<span class="badge badge-pill badge-danger">Never</span>') . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><th colspan="6">No users found!</th></tr>';
                            }
                        } else {
                            echo '<tr><th colspan="6">Unknown error occurred!</th></tr>';
                        }

                        $result->free();

                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php

/*
 * Here, we're including our footer which
 * is going to be common throughout our
 * entire application just like the header.
 */
include 'common/footer.php';

?>
