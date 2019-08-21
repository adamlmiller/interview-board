<?php

$title = 'Home';

include __DIR__ . '/common/session.php';
include __DIR__ . '/common/header.php';

$interviews = $mysql->query("SELECT COUNT(*) AS total FROM interviews");
$questions = $mysql->query("SELECT COUNT(*) AS total FROM questions");
$users = $mysql->query("SELECT COUNT(*) AS total FROM users");

?>

<div class="header">
    <h1><i class="fas fa-home"></i> Dashboard</h1>
</div>

<div class="row">
    <div class="col-4">
        <div class="tile">
            <div class="tile-heading">Interviews</div>
            <div class="tile-body"><i class="fas fa-address-book"></i><h2 class="float-right"><?php echo $interviews->fetch_assoc()['total']; ?></h2></div>
            <div class="tile-footer"><a href="/interviews/">Go to Interviews <i class="fa fa-angle-right"></i></a></div>
        </div>
    </div>
    <div class="col-4">
        <div class="tile">
            <div class="tile-heading">Questions</div>
            <div class="tile-body"><i class="fas fa-question"></i><h2 class="float-right"><?php echo $questions->fetch_assoc()['total']; ?></h2></div>
            <div class="tile-footer"><a href="/questions/">Go to Questions <i class="fa fa-angle-right"></i></a></div>
        </div>
    </div>
    <div class="col-4">
        <div class="tile">
            <div class="tile-heading">Users</div>
            <div class="tile-body"><i class="fa fa-users"></i><h2 class="float-right"><?php echo $users->fetch_assoc()['total']; ?></h2></div>
            <div class="tile-footer"><a href="/users/">Go to Users <i class="fa fa-angle-right"></i></a></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
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
                                    echo '  <td>' . $interview['first_name'] . ' ' . $interview['last_name'] . '</td>';
                                    echo '  <td>' . $interview['email'] . '</td>';
                                    echo '  <td>' . $interview['phone'] . '</td>';
                                    echo '  <td>' . date("M jS, Y g:i:sA", strtotime($interview['created'])) . '</td>';
                                    echo '  <td>' . date("M jS, Y g:i:sA", strtotime($interview['modified'])) . '</td>';
                                    echo '  <td class="text-right">';
                                    echo '    <a class="btn btn-sm btn-outline-dark" href="/interviews/read.php?id=' . $interview['id'] . '"><i class="fas fa-glasses"></i></a>';
                                    echo '    <a class="btn btn-sm btn-outline-info" href="/interviews/update.php?id=' . $interview['id'] . '"><i class="fas fa-pencil-alt"></i></a>';
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

<?php include __DIR__ . '/common/footer.php'; ?>
