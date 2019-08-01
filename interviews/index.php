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
            <h1>Interviews</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <a class="btn btn-dark" href="/interviews/create.php"><i class="fas fa-plus-square"></i> Create Interview</a>
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
                            <th scope="col" width="100px">Hire?</th>
                            <th scope="col" width="100px">Phone</th>
                            <th scope="col" width="100px">Date</th>
                            <th scope="col" width="175px">Created</th>
                            <th scope="col" width="175px">Modified</th>
                            <th scope="col" width="100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                    if ($query = $mysql->query("SELECT * FROM interviews ORDER BY created DESC")) {
                        if ($query->num_rows >= 1) {
                            while ($interview = $query->fetch_assoc()) {
                                echo '<tr>';
                                echo '  <td>' . $interview['id'] . '</td>';
                                echo '  <td>' . $interview['first_name'] . ' ' . $interview['last_name'] . '</td>';
                                echo '  <td>' . $interview['email'] . '</td>';
                                echo '  <td>';

                                if ($interview['hire'] == 0) echo '<span class="badge badge-pill badge-danger">No</span>';
                                if ($interview['hire'] == 1) echo '<span class="badge badge-pill badge-success">Yes</span>';
                                if ($interview['hire'] == 2) echo '<span class="badge badge-pill badge-info">Unsure</span>';

                                echo '  <td>' . $interview['phone'] . '</td>';
                                echo '  <td>' . date("M jS, Y", strtotime($interview['date'])) . '</td>';
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
                            echo '<tr><th colspan="9">No interviews found!</th></tr>';
                        }
                    } else {
                        echo '<tr><th colspan="9">Unknown error occurred!</th></tr>';
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
