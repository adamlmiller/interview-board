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

?>

<div class="header">
    <h1>Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="box">
            <div class="box-header"><h6>Most Recent Interviews (5)</h6></div>
            <div class="box-body">
                <table class="table table-borderless table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">E-Mail</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Created</th>
                            <th scope="col">Modified</th>
                            <th scope="col" width="100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if ($query = $mysql->query("SELECT * FROM interviews ORDER BY created DESC LIMIT 5")) {
                            if ($query->num_rows >= 1) {
                                while ($interview = $query->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '  <td>' . $interview['id'] . '</td>';
                                    echo '  <td><a href="interviews/read.php?id=' . $interview['id'] . '">' . $interview['first_name'] . ' ' . $interview['last_name'] . '</a></td>';
                                    echo '  <td>' . $interview['email'] . '</td>';
                                    echo '  <td>' . $interview['phone'] . '</td>';
                                    echo '  <td>' . date("M jS, Y g:i:sA", strtotime($interview['created'])) . '</td>';
                                    echo '  <td>' . date("M jS, Y g:i:sA", strtotime($interview['modified'])) . '</td>';
                                    echo '  <td>';
                                    echo '    <a class="btn btn-sm btn-outline-dark" href="/interviews/read.php?id=' . $interview['id'] . '"><i class="fas fa-glasses"></i></a>';
                                    echo '    <a class="btn btn-sm btn-outline-info" href="/interviews/update.php?id=' . $interview['id'] . '"><i class="fas fa-pencil-alt"></i></a>';
                                    echo '    <a class="btn btn-sm btn-outline-danger" href="/interviews/delete.php?id=' . $interview['id'] . '"><i class="fas fa-trash-alt"></i></a>';
                                    echo '  </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><th colspan="7">No interviews found!</th></tr>';
                            }
                        } else {
                            echo '<tr><th colspan="7">Database query failed!</th></tr>';
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
include 'common/footer.php';

?>
