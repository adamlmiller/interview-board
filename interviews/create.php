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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'create') {
    if ($query = $mysql->prepare("INSERT INTO `interviews` SET `user_id` = ?, `first_name` = ?, `last_name` = ?, `email` = ?, `phone` = ?, `date` = ?, `method` = ?, `qa` = ?, `notes` = ?, `hire` = ?")) {
        if ($query->bind_param("isssssssss", $_SESSION['user']['id'], $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['date'], $_POST['method'], $_POST['qa'], $_POST['notes'], $_POST['hire'])) {
            if ($query->execute()) {
                if ($query->affected_rows === -1) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save interview!</div>';
                } elseif ($query->affected_rows === 0) {
                    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Failed to save interview!</div>';
                } else {
                    $interview_id = $query->insert_id;

                    foreach ($_POST['answer'] AS $key => $value) {
                        $answer = $mysql->prepare("INSERT INTO `interviews_answers` SET `interview_id` = ?, `question_id` = ?, `answer` = ?");
                        $answer->bind_param("iis", $interview_id, $key, $value);
                        $answer->execute();
                    }

                    $_SESSION['flash'] = '<div class="alert alert-success" role="alert">Interview created successfully!</div>';

                    header('location: /interviews/index.php');
                    exit();
                }
            } else {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save interview!</div>';
            }
        } else {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save interview!</div>';
        }
    } else {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save interview!</div>';
    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1>Interviews :: Create</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['flash'])) echo $_SESSION['flash']; unset($_SESSION['flash']); ?>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="box">
            <div class="box-body">
                <form action="" method="post">
                    <input name="action" value="create" type="hidden">

                    <h5>General Information</h5>

                    <hr />

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input name="first_name" type="text" class="form-control" id="first_name" aria-describedby="firstnameHelp" placeholder="First Name">
                                <small id="firstnameHelp" class="form-text text-muted">Enter the interviewees first name.</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input name="last_name" type="text" class="form-control" id="last_name" aria-describedby="lastnameHelp" placeholder="Last Name">
                                <small id="lastnameHelp" class="form-text text-muted">Enter the interviewees last name.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">E-Mail Address</label>
                                <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="username@domain.com">
                                <small id="emailHelp" class="form-text text-muted">Enter the interviewees e-mail address.</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input name="phone" type="text" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="(000) 000-0000">
                                <small id="phoneHelp" class="form-text text-muted">Enter the interviewees phone number in the proper format. <span class="text-info">Formatting happens automatically!</span></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="date">Interview Date</label>
                                <input name="date" type="text" class="form-control" id="date" aria-describedby="dateHelp" placeholder="yyyy-mm-dd">
                                <small id="dateHelp" class="form-text text-muted">Enter the interview date in the proper format. <span class="text-info">Formatting happens automatically!</span></small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="method">Interview Method</label>
                                <input name="method" type="text" class="form-control" id="method" aria-describedby="methodHelp" placeholder="Phone, In Person, E-Mail, etc.">
                                <small id="methodHelp" class="form-text text-muted">Enter the method user to perform the interview.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="qa">Questions asked by the Interviewee</label>
                                <textarea rows="5" name="qa" type="text" class="form-control" id="qa" aria-describedby="qaHelp" placeholder="Enter questions and answers that the interviewee asked..."></textarea>
                                <small id="qaHelp" class="form-text text-muted">Enter any questions that the interviewee asked and the responses given.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="notes">Additional Notes</label>
                                <textarea rows="5" name="notes" type="text" class="form-control" id="notes" aria-describedby="notesHelp" placeholder="Enter any additional notes about the interviewee or the interview in general."></textarea>
                                <small id="notesHelp" class="form-text text-muted">Enter any additional notes about the interviewee or the interview in general.</small>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <h5>Question and Answer</h5>

                    <hr />

                    <?php

                    if ($query = $mysql->query("SELECT * FROM questions WHERE active = 1 ORDER BY id ASC")) {
                        if ($query->num_rows >= 1) {
                            $i = 1;

                            while ($question = $query->fetch_assoc()) {
                                echo '<div class="form-group"><label for="question' . $question['id'] . '">' . $i . ') ' . $question['question'] . '</label><textarea rows="5" name="answer[' . $question['id'] . ']" class="form-control" id="question' . $question['id'] . '"></textarea></div>';

                                $i++;
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">No questions found!</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Unknown error occurred retrieving questions from database!</div>';
                    }

                    ?>

                    <div class="form-group">
                        <label for="hire">Should we hire this person?</label>
                        <select class="selectpicker" name="hire">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                            <option value="2">Unsure</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-save"></i> Save Interview</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#date').mask('0000-00-00', {placeholder: "yyyy-mm-dd"});
        $('#phone').mask('(000) 000-0000', {placeholder: "(000) 000-0000"});
    });
</script>

<?php

/*
 * Here, we're including our footer which
 * is going to be common throughout our
 * entire application just like the header.
 */
include '../common/footer.php';

?>
