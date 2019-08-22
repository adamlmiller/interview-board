<?php

$title = 'Read :: Interviews';

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/header.php';

$interview = new Interview();
$interview = $interview->read($_GET['id']);

?>
<div class="header">
    <div class="row">
        <div class="col-6">
            <h1><i class="fas fa-address-book"></i> Interviews :: Read :: <?php echo $interview['first_name'] . ' ' . $interview['last_name']; ?></h1>
        </div>
        <div class="col-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>
<?php if (!empty($interview)) { ?>
<div class="row">
    <div class="col-12">
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
                            <td><?php echo date($system['date_format_short'], strtotime($interview['date'])); ?></td>
                            <td><strong>Interview Method</strong></td>
                            <td><?php echo $interview['method']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Interview Created</strong></td>
                            <td><?php echo date($system['date_format_long'], strtotime($interview['created'])); ?></td>
                            <td><strong>Interview Modified</strong></td>
                            <td><?php echo date($system['date_format_long'], strtotime($interview['modified'])); ?></td>
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

                $answers = new InterviewAnswer();
                $answers = $answers->get($interview['id']);

                if (count($answers) >= 1) {
                    foreach ($answers AS $answer) {
                        echo '<div class="card">';
                        echo '  <div class="card-header"><strong>' . $answer['question'] . '</strong></div>';
                        echo '  <div class="card-body">' . $answer['answer'] . '</div>';
                        echo '</div>';
                        echo '<br />';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">No interview questions</div>';
                }

                ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php include __DIR__ . '/../common/footer.php'; ?>
