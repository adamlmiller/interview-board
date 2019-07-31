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
        $insert = $mysql->prepare("INSERT INTO `questions` SET `name` = ?, `question` = ?, `active` = 1");
        $insert->bind_param("ss", $_POST['name'], $_POST['question']);
        $insert->execute();

        if ($insert->affected_rows === -1) {
            $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to save new question! <strong>Error: </strong> ' . $insert->error . '</div>';
        } elseif ($insert->affected_rows === 0) {
            $flash = '<div class="alert alert-danger" role="alert">Failed to save new question!</div>';
        } else {
            $flash = '<div class="alert alert-success" role="alert">Question created successfully!</div>';
        }

        $insert->close();
    }

    if ($_POST['action'] == 'update') {
        $update = $mysql->prepare("UPDATE `questions` SET `name` = ?, `question` = ?, `active` = 1 WHERE `id` = ?");
        $update->bind_param("ssi", $_POST['name'], $_POST['question'], $_POST['id']);
        $update->execute();

        if ($update->affected_rows === -1) {
            $flash = '<div class="alert alert-danger" role="alert">Error occurred when trying to update question! <strong>Error: </strong> ' . $update->error . '</div>';
        } elseif ($update->affected_rows === 0) {
            $flash = '<div class="alert alert-danger" role="alert">Failed to update question! Were any changes made?</div>';
        } else {
            $flash = '<div class="alert alert-success" role="alert">Question updated successfully!</div>';
        }

        $update->close();
    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1>Questions</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <button class="btn btn-dark" onclick="window.location.href = 'questions_create.php';"><i class="fas fa-plus-square"></i> Create Question</button>
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
                            <th scope="col" width="75px">Active</th>
                            <th scope="col" width="175px">Created</th>
                            <th scope="col" width="175px">Modified</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            if ($result = $mysql->query("SELECT id,name,active,created,modified FROM questions ORDER BY id ASC")) {
                                if ($result->num_rows >= 1) {
                                    while ($question = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '  <td>' . $question['id'] . '</td>';
                                        echo '  <td><a href="questions_update.php?id=' . $question['id'] . '">' . $question['name'] . '</a></td>';
                                        echo '  <td>' . ($question['active'] ? '<span class="badge badge-pill badge-success">Active</span>':'<span class="badge badge-pill badge-danger">Disabled</span>') . '</td>';
                                        echo '  <td>' . date("M jS, Y g:i:sA", strtotime($question['created'])) . '</td>';
                                        echo '  <td>' . date("M jS, Y g:i:sA", strtotime($question['modified'])) . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><th colspan="6">No questions found!</th></tr>';
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
