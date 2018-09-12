<div class="x_panel">

    <div class="x_content">
        <?php if (isset($error) && !empty($error)) {
            ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <div class="clearfix"></div>
            <?php
        }
        if (isset($message) && !empty($message)) {
            ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
            <div class="clearfix"></div>
            <?php
        }
        ?>
        <div class="card-box">
            <div id="calendars"></div>
        </div>

    </div>
</div>


<script>

    $(document).ready(function () {

        $('#calendars').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '<?php echo date('Y-m-d'); ?>',
//			defaultDate: '2016-12-12',
            navLinks: true, // can click day/week names to navigate views
            selectable: false,
            selectHelper: true,
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            timeFormat: 'h(:mm) a',
            events: [
<?php
if (isset($appointments) && !empty($appointments)) {
    foreach ($appointments as $schedule) {
        ?>
                        {
                            title: 'Available',
                            start: '<?php echo date('Y-m-d H:i:s', strtotime($schedule['start_date'] . " " . $schedule['start_time'])); ?>',
                            end: '<?php echo date('Y-m-d H:i:s', strtotime($schedule['end_date'] . " " . $schedule['end_time'])); ?>',
                        },
        <?php
    }
}
?>
            ]
        });

    });

</script>