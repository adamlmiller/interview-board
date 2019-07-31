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
        $insert = $mysql->prepare("INSERT INTO `interviews` SET `first_name` = ?, `last_name` = ?, `email` = ?, `phone` = ?, `date` = ?, `method` = ?, `qa` = ?, `notes` = ?, `hire` = ?");
        $insert->bind_param("sssssssss", $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['date'], $_POST['method'], $_POST['qa'], $_POST['notes'], $_POST['hire']);
        $insert->execute();

        if ($insert->affected_rows === -1) {
            $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to save new interview! <strong>Error: </strong> ' . $insert->error . '</div>';
        } elseif ($insert->affected_rows === 0) {
            $flash = '<div class="alert alert-danger" role="alert">Failed to save new interview!</div>';
        } else {
            $interview_id = $insert->insert_id;

            foreach ($_POST['answer'] AS $key => $value) {
                $answer = $mysql->prepare("INSERT INTO `interviews_answers` SET `interview_id` = ?, `question_id` = ?, `answer` = ?");
                $answer->bind_param("iis", $interview_id, $key, $value);
                $answer->execute();
            }

            $flash = '<div class="alert alert-success" role="alert">Interview created successfully!</div>';
        }

        $insert->close();
    }

//    if ($_POST['action'] == 'update') {
//        if (!empty($_POST['password'])) {
//            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
//
//            $update = $mysql->prepare("UPDATE `users` SET `first_name` = ?, `last_name` = ?, `email` = ?, `password` = ?, `active` = 1 WHERE `id` = ?");
//            $update->bind_param("ssssi", $_POST['first_name'], $_POST['last_name'], $_POST['email'], $password, $_POST['id']);
//            $update->execute();
//        } else {
//            $update = $mysql->prepare("UPDATE `users` SET `first_name` = ?, `last_name` = ?, `email` = ?, `active` = 1 WHERE `id` = ?");
//            $update->bind_param("sssi", $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['id']);
//            $update->execute();
//        }
//
//        if ($update->affected_rows === -1) {
//            $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to update user! <strong>Error: </strong> ' . $update->error . '</div>';
//        } elseif ($update->affected_rows === 0) {
//            $flash = '<div class="alert alert-danger" role="alert">Failed to update user! Were any changes made?</div>';
//        } else {
//            $flash = '<div class="alert alert-success" role="alert">User updated successfully!</div>';
//        }
//
//        $update->close();
//    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1>Interviews</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <button class="btn btn-dark" onclick="window.location.href = 'interviews_create.php';"><i class="fas fa-plus-square"></i> Create Interview</button>
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
                            <th scope="col" width="100px">Phone</th>
                            <th scope="col" width="100px">Date</th>
                            <th scope="col" width="175px">Created</th>
                            <th scope="col" width="175px">Modified</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                        if ($result = $mysql->query("SELECT * FROM interviews ORDER BY first_name, last_name ASC")) {
                            if ($result->num_rows >= 1) {
                                while ($interview = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '  <td>' . $interview['id'] . '</td>';
                                    echo '  <td><a href="interviews_read.php?id=' . $interview['id'] . '">' . $interview['first_name'] . ' ' . $interview['last_name'] . '</a></td>';
                                    echo '  <td>' . $interview['email'] . '</td>';
                                    echo '  <td>' . $interview['phone'] . '</td>';
                                    echo '  <td>' . date("M jS, Y", strtotime($interview['date'])) . '</td>';
                                    echo '  <td>' . date("M jS, Y g:i:sA", strtotime($interview['created'])) . '</td>';
                                    echo '  <td>' . date("M jS, Y g:i:sA", strtotime($interview['modified'])) . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><th colspan="7">No interviews found!</th></tr>';
                            }
                        } else {
                            echo '<tr><th colspan="7">Unknown error occurred!</th></tr>';
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
