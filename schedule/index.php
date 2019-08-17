<?php

$title = 'Schedule';

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/header.php';

?>

<div class="header">
    <div class="row">
        <div class="col-12">
            <h1><i class="fa fa-calendar-alt"></i> Schedule</h1>
        </div>
    </div>
</div>

<div class="box">
    <div class="box-body">
        <div class="calendar" id="calendar"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var calement = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calement, {
            plugins: ['bootstrap', 'dayGrid', 'interaction', 'moment', 'momentTimezone'],
            themeSystem: 'bootstrap',
            height: $(window).height() - 140
        });

        calendar.render();
    });
</script>

<?php include __DIR__ . '/../common/footer.php'; ?>
