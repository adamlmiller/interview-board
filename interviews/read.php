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

if (!($query = $mysql->prepare("SELECT * FROM interviews WHERE id = ?"))) {
    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
} else {
    if (!$query->bind_param("i", $_GET['id'])) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
    } else {
        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find interview as referenced!</div>';
        } else {
            $interview = $result->fetch_assoc();
        }
    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1>Interviews :: Read :: <?php echo $interview['first_name'] . ' ' . $interview['last_name']; ?></h1>
        </div>
        <div class="col-md-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>

<?php if (!empty($interview)) { ?>
<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="box">
            <div class="box-body">
                <h5>General Information</h5>

                <hr />

                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td><strong>First Name</strong></td>
                            <td><?php echo $interview['first_name']; ?></td>
                            <td><strong>Last Name</strong></td>
                            <td><?php echo $interview['last_name']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>E-Mail Address</strong></td>
                            <td><?php echo $interview['email']; ?></td>
                            <td><strong>Phone Number</strong></td>
                            <td><?php echo $interview['phone']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Interview Date</strong></td>
                            <td><?php echo $interview['date']; ?></td>
                            <td><strong>Interview Method</strong></td>
                            <td><?php echo $interview['method']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Interview Created</strong></td>
                            <td><?php echo date("M jS, Y g:i:sA", strtotime($interview['created'])); ?></td>
                            <td><strong>Interview Modified</strong></td>
                            <td><?php echo date("M jS, Y g:i:sA", strtotime($interview['modified'])); ?></td>
                        </tr>
                        <tr><td colspan="4"><strong>Questions asked by the Interviewee</strong></td></tr>
                        <tr><td colspan="4"><?php echo $interview['qa']; ?></td></tr>
                        <tr><td colspan="4"><strong>Additional Notes</strong></td></tr>
                        <tr><td colspan="4"><?php echo $interview['notes']; ?></td></tr>
                    </tbody>
                </table>

                <hr />

                <h5>Question and Answer</h5>

                <hr />

                <?php

                if (!($query = $mysql->prepare("SELECT * FROM interviews_answers ia, questions q WHERE q.id = ia.question_id AND interview_id = ?"))) {
                    echo '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
                } else {
                    if (!$query->bind_param("i", $_GET['id'])) {
                        echo '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query! <strong>Error: </strong> ' . $query->error . '</div>';
                    } else {
                        $query->execute();

                        $result = $query->get_result();

                        if ($result->num_rows === 0) {
                            echo '<div class="alert alert-danger" role="alert">Unable to find interview as referenced!</div>';
                        } else {
                            while ($answer = $result->fetch_assoc()) {
                                echo '<div class="card">';
                                echo '  <div class="card-header"><strong>' . $answer['question'] . '</strong></div>';
                                echo '  <div class="card-body">' . $answer['answer'] . '</div>';
                                echo '</div>';
                                echo '<br />';
                            }
                        }
                    }
                }

                ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php

/*
 * Here, we're including our footer which
 * is going to be common throughout our
 * entire application just like the header.
 */
include '../common/footer.php';

?>
