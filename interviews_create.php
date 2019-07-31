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
    <div class="row">
        <div class="col-md-6">
            <h1>Interviews :: Create</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="box">
            <div class="box-body">
                <form action="interviews.php" method="post">
                    <input name="action" value="create" type="hidden">

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input name="first_name" type="text" class="form-control" id="first_name" aria-describedby="firstnameHelp" placeholder="First Name">
                                        <small id="firstnameHelp" class="form-text text-muted">Enter the interviewees first name.</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input name="last_name" type="text" class="form-control" id="last_name" aria-describedby="lastnameHelp" placeholder="Last Name">
                                        <small id="lastnameHelp" class="form-text text-muted">Enter the interviewees last name.</small>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="email">E-Mail Address</label>
                                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="username@domain.com">
                                        <small id="emailHelp" class="form-text text-muted">Enter the interviewees e-mail address.</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input name="phone" type="text" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="(000) 000-0000">
                                        <small id="phoneHelp" class="form-text text-muted">Enter the interviewees phone number in the proper format. <span class="text-info">Formatting happens automatically!</span></small>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="date">Interview Date</label>
                                        <input name="date" type="text" class="form-control" id="date" aria-describedby="dateHelp" placeholder="yyyy-mm-dd">
                                        <small id="dateHelp" class="form-text text-muted">Enter the interview date in the proper format. <span class="text-info">Formatting happens automatically!</span></small>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="method">Interview Method</label>
                                        <input name="method" type="text" class="form-control" id="method" aria-describedby="methodHelp" placeholder="Phone, In Person, E-Mail, etc.">
                                        <small id="methodHelp" class="form-text text-muted">Enter the method user to perform the interview.</small>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="form-group">
                        <label for="qa">Questions asked by the Interviewee</label>
                        <textarea rows="5" name="qa" type="text" class="form-control" id="qa" aria-describedby="qaHelp" placeholder="Enter questions and answers that the interviewee asked..."></textarea>
                        <small id="qaHelp" class="form-text text-muted">Enter any questions that the interviewee asked and the responses given.</small>
                    </div>
                    <div class="form-group">
                        <label for="notes">Additional Notes</label>
                        <textarea rows="5" name="notes" type="text" class="form-control" id="notes" aria-describedby="notesHelp" placeholder="Enter any additional notes about the interviewee or the interview in general."></textarea>
                        <small id="notesHelp" class="form-text text-muted">Enter any additional notes about the interviewee or the interview in general.</small>
                    </div>

                    <h3>Question and Answer</h3>

                    <?php

                        if ($result = $mysql->query("SELECT * FROM questions WHERE active = 1 ORDER BY id ASC")) {
                            if ($result->num_rows >= 1) {
                                $i = 1;

                                while ($question = $result->fetch_assoc()) {
                                    echo '<div class="form-group"><label for="question' . $question['id'] . '">' . $i . ') ' . $question['question'] . '</label><textarea rows="5" name="answer[' . $question['id'] . ']" class="form-control" id="question' . $question['id'] . '"></textarea></div>';

                                    $i++;
                                }
                            } else {
                                echo 'No questions found!';
                            }
                        } else {
                            echo 'Unknown error occurred retrieving questions from database!';
                        }

                        $result->free();

                    ?>

                    <div class="form-group">
                        <label for="hire">Should we hire this person?</label>
                        <select class="selectpicker" name="hire">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                            <option value="2">Unsure</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Interview</button>
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
include 'common/footer.php';

?>
