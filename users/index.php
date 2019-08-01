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

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1>Users</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <a class="btn btn-dark" href="/users/create.php"><i class="fas fa-plus-square"></i> Create User</a>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['flash'])) echo $_SESSION['flash']; unset($_SESSION['flash']); ?>

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
                            <th scope="col" width="100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                    if ($result = $mysql->query("SELECT * FROM users ORDER BY first_name, last_name ASC")) {
                        if ($result->num_rows >= 1) {
                            while ($user = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '  <td>' . $user['id'] . '</td>';
                                echo '  <td>' . $user['first_name'] . ' ' . $user['last_name'] . '</td>';
                                echo '  <td>' . $user['email'] . '</td>';
                                echo '  <td>' . ($user['active'] ? '<span class="badge badge-pill badge-success">Active</span>':'<span class="badge badge-pill badge-danger">Disabled</span>') . '</td>';
                                echo '  <td>' . date("M jS, Y g:i:sA", strtotime($user['created'])) . '</td>';
                                echo '  <td>' . date("M jS, Y g:i:sA", strtotime($user['modified'])) . '</td>';
                                echo '  <td>' . ($user['lastlogin'] ? date("M jS, Y g:i:sA", strtotime($user['lastlogin'])) : '<span class="badge badge-pill badge-danger">Never</span>') . '</td>';
                                echo '  <td>';
                                echo '    <a class="btn btn-sm btn-outline-dark" href="/users/read.php?id=' . $user['id'] . '"><i class="fas fa-glasses"></i></a>';
                                echo '    <a class="btn btn-sm btn-outline-info" href="/users/update.php?id=' . $user['id'] . '"><i class="fas fa-pencil-alt"></i></a>';
                                echo '    <a class="btn btn-sm btn-outline-danger" href="/users/delete.php?id=' . $user['id'] . '"><i class="fas fa-trash-alt"></i></a>';
                                echo '  </td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><th colspan="8">No users found!</th></tr>';
                        }
                    } else {
                        echo '<tr><th colspan="8">Unknown error occurred!</th></tr>';
                    }

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
include '../common/footer.php';

?>
