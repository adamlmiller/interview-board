<?php

/*
 * Page Title
 */
$title = 'Schedule';

/*
 * We're going to include our session
 * controller to check for an active
 * session.
 */
include __DIR__ . '/../common/session.php';

/*
 * We're going to include our header which
 * is going to be common throughout our
 * entire application.
 */
include __DIR__ . '/../common/header.php';

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1><i class="fa fa-calendar-alt"></i> Schedule</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <!--<a class="btn btn-dark" href="/schedule/create.php"><i class="fas fa-plus-square"></i> Schedule Interview</a>-->
            </div>
        </div>
    </div>
</div>

<p>Nothing here yet but this will be used to schedule an interview. Thinking about making it so that it can send an e-mail with a calendar invite and maybe even an SMS. Thinking about how this will be done, I think using full calendar (<a href="https://fullcalendar.io/" target="_blank">https://fullcalendar.io/</a>) will be a good start. From there, we can add a button to create a new schedule, possibly even when a user clicks on a day box. When a user clicks on an existing schedule, it will popup the update modal and then we will need to give a way to delete them as well. There's a pretty decent video here <a href="https://www.youtube.com/watch?v=OePNkDd3Yb8" target="_blank">https://www.youtube.com/watch?v=OePNkDd3Yb8</a> explaining the basic steps of using a Bootstrap modal to add an event.</p>

<?php

/*
 * Here, we're including our footer which
 * is going to be common throughout our
 * entire application just like the header.
 */
include __DIR__ . '/../common/footer.php';

?>
