<div id="infoMessage">
    <?php
    if (isset($message) && !empty($message)) {
        echo "<p class='alert alert-success text-left'>" . $message . "</p>";
    }

    if (isset($error) && !empty($error)) {
        echo "<p class='alert alert-danger text-left'>" . $error . "</p>";
    }
    ?>
</div>
<style>
    .doc-serch-grid{
        min-height: 200px;
    }
</style>
<?php
$start_price = '1';
$end_price = '200';
if (isset($post_data['price']) && $post_data['price'] != '') {
    $price_arr = explode('-', str_replace(array('$', '+'), array('', ''), $post_data['price']));
    $start_price = trim(current($price_arr));
    $end_price = trim(end($price_arr));
}
?>
<script>
    $(function() {
    $("#slider-range").slider({
    range: true,
            min: 1,
            max: 200,
            values: [ <?php echo $start_price . ',' . $end_price ?>],
            slide: function(event, ui) {
            if (ui.values[ 1 ] == 200){
            $("#price").val("<?php echo CURRENCY_SYMBOL; ?>" + ui.values[ 0 ] + " - <?php echo CURRENCY_SYMBOL; ?>" + ui.values[ 1 ] + '+');
            } else {
            $("#price").val("<?php echo CURRENCY_SYMBOL; ?>" + ui.values[ 0 ] + " - <?php echo CURRENCY_SYMBOL; ?>" + ui.values[ 1 ]);
            }
            }
    });
            // $("#price").val("<?php echo CURRENCY_SYMBOL; ?>" + $("#slider-range").slider("values", 0) + " - <?php echo CURRENCY_SYMBOL; ?>" + $("#slider-range").slider("values", 1));
            $("#price").val("<?php echo CURRENCY_SYMBOL . $start_price . ' - ' . CURRENCY_SYMBOL . ($end_price == 200 ? $end_price . '+' : $end_price); ?>");
    });</script>
<div class="x_panel">
    <div class="row">
        <div class="col-sm-12">



        </div>
    </div>
    <?php
    if (!isset($provider_data) && empty($provider_data)) {
        // Check / Search for Providers
        ?>
        <h3 class="serch-head">Search for An Appointment</h3>
        <?php ?>
        <form action="<?php echo PATIENT_URL; ?>bookanappointment" method="post" id="search_provider">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Provider Name</label>
                                <?php /* <input type="text" placeholder="Enter Provider Name / Speciality" class="form-control" name="provider_name" id="provider_name"  value="<?php echo isset($post_data) && !empty($post_data) && isset($post_data['provider_name']) ? $post_data['provider_name'] : ''; ?>">
                                  <input type="hidden" name="type" id="type" value="<?php echo isset($post_data) && !empty($post_data) && isset($post_data['type']) ? $post_data['type'] : ''; ?>" />
                                  <input type="hidden" name="id" id="id" value="<?php echo isset($post_data) && !empty($post_data) && isset($post_data['id']) ? $post_data['id'] : ''; ?>" /> */ ?>
                                <select name="provider_name" class="form-control">
                                    <option value="">Select Provider</option>
                                    <?php
                                    if (isset($providerlist) && is_array($providerlist)) {
                                        foreach ($providerlist as $key => $value) {
                                            $selected = (isset($post_data) && !empty($post_data) && isset($post_data['provider_name']) && $post_data['provider_name'] == $key) ? 'selected="selected"' : '';
                                            ?>
                                            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="action" id="action" value="search" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputInsuranceId">Speciality</label>
                                <select name="speciality_id" class="form-control">
                                    <option value="">Select Speciality</option>
                                    <?php
                                    if (isset($specialitylist) && is_array($specialitylist)) {
                                        foreach ($specialitylist as $key => $value) {
                                            $selected = (isset($post_data) && !empty($post_data) && isset($post_data['speciality_id']) && $post_data['speciality_id'] == $key) ? 'selected="selected"' : '';
                                            ?>
                                            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Available From</label>
                                <div class='input-group date datetimepickerRange'  id="appointmentdatefrom" style=" margin-bottom:0">
                                    <input type="text" placeholder="MM/DD/YYYY" class="form-control noneditable" name="start_date" id="start_date"  value="<?php echo isset($post_data) && !empty($post_data) && isset($post_data['start_date']) ? $post_data['start_date'] : ''; ?>" >
                                    <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Available To</label>
                                <div class='input-group date datetimepickerRange'  id="appointmentdateto" style=" margin-bottom:0">
                                    <input type="text" placeholder="MM/DD/YYYY" class="form-control noneditable" name="end_date" id="end_date" value="<?php echo isset($post_data) && !empty($post_data) && isset($post_data['end_date']) ? $post_data['end_date'] : ''; ?>">

                                    <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputInsuranceId">Insurance</label>
                                <select name="insurance_id" class="form-control">
                                    <option value="">Select Insurance</option>
                                    <?php
                                    if (isset($insurencelist) && is_array($insurencelist)) {
                                        foreach ($insurencelist as $key => $value) {
                                            $selected = (isset($post_data) && !empty($post_data) && isset($post_data['insurance_id']) && $post_data['insurance_id'] == $key) ? 'selected="selected"' : '';
                                            ?>
                                            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php /* <div class="col-sm-3">
                          <div class="form-group">
                          <label for="exampleInputPrice">Price Range(<?php echo CURRENCY_SYMBOL; ?>)</label>
                          <select name="price" class="form-control">
                          <option value="">Select Price Range</option>
                          <?php
                          $price_ranges = array('0-50' => '0-50', '50-75' => '50-75', '75-100' => '75-100', '100-125' => '100-125', '125-150' => '125-150', '150-175' => '150-175', '175-200+' => '175-200+');
                          if (isset($price_ranges) && is_array($price_ranges)) {
                          foreach ($price_ranges as $key => $value) {
                          $selected = (isset($post_data) && !empty($post_data) && isset($post_data['price']) && $post_data['price'] == $key) ? 'selected="selected"' : '';
                          ?>
                          <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
                          <?php
                          }
                          }
                          ?>
                          </select>
                          </div>
                          </div> */ ?>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <p>
                                    <label for="price1">Price Range:</label>
                                    <input type="text" id="price" readonly style="border:0; color:#f6931f; font-weight:bold;" name="price">
                                </p>
                                <div id="slider-range"></div>
                            </div>
                        </div>
                        <div class="col-sm-3 pull-right">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="blank">&nbsp;</label>
                                    <br>
                                    <button class="btn btn-primary" data-toggle="tooltip" title="Search"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="blank">&nbsp;</label>

                                    <br> <button class="btn btn-danger" onclick="window.location.href = '<?php echo PATIENT_URL; ?>bookanappointment'" type="button" data-toggle="tooltip" title="Reset Filter"><i class="fa fa-refresh"></i></button>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </form>

        <script type="text/javascript">
                    $(document).ready(function (e) {
            $("#appointmentdatefrom").datetimepicker({format: 'MM/DD/YYYY', minDate: '<?php echo date('m'); ?>/<?php echo date('d'); ?>/<?php echo date('Y'); ?>'});
                        $("#appointmentdateto").datetimepicker({format: 'MM/DD/YYYY', useCurrent: false, minDate: '<?php echo date('m'); ?>/<?php echo date('d'); ?>/<?php echo date('Y'); ?>'});
                                    $("#appointmentdatefrom").on("dp.change", function (e) {
                            $('#appointmentdateto').data("DateTimePicker").minDate(e.date);
                            });
                                    $("#appointmentdateto").on("dp.change", function (e) {
                            $('#appointmentdatefrom').data("DateTimePicker").maxDate(e.date);
                            });
                            });
                                    /*	$("#provider_name").keyup(function(e) {
                                     $this = $(this);

                                     $(this).autocomplete({
                                     source: '<?php echo PATIENT_URL . 'get_providers' ?>',
                                     select: function (event, ui) {

                                     }
                                     });
                                     });*/
                                    /* $(document).on('keydown.autocomplete', '#provider_name', function () {
                                     $this = $(this);
                                     $('#type').val('');
                                     $('#id').val('');
                                     $(this).autocomplete({
                                     source: '<?php echo PATIENT_URL . 'get_providers' ?>',
                                     select: function (event, ui) {
                                     $('#type').val(ui.item.type);
                                     $('#id').val(ui.item.id);
                                     }
                                     });
                                     });   */</script>
        <hr/>
        <div class="clearfix"></div>
        <?php
        if (isset($providers) && !empty($providers)) {
            ?>
            <div class="center">
                <!--<><><><><><><><><><><><><><><><><><><><><><><><><><> DEMO START <><><><><><><><><><><><><><><><><><><><><><><><><><>-->

                <div id="demo" class="jplist" style="">

                    <!-- ios button: show/hide panel -->
                    <div class="jplist-ios-button">
                        <i class="fa fa-sort"></i>
                        jPList Actions
                    </div>

                    <!-- panel -->
                    <div class="jplist-panel panel-top">

                        <!-- items per page dropdown -->
                        <div
                            class="jplist-drop-down"
                            data-control-type="items-per-page-drop-down"
                            data-control-name="paging"
                            data-control-action="paging">

                            <ul>
                                <li><span data-number="3"> 3 per page </span></li>
                                <li><span data-number="5"> 5 per page </span></li>
                                <li><span data-number="10"> 10 per page </span></li>
                                <li><span data-number="15" data-default="true"> 15 per page </span></li>
                                <li><span data-number="all"> View All </span></li>
                            </ul>
                        </div>

                        <div
                            class="jplist-label"
                            data-type="Page {current} of {pages}"
                            data-control-type="pagination-info"
                            data-control-name="paging"
                            data-control-action="paging">
                        </div>

                        <div
                            class="jplist-pagination"
                            data-control-type="pagination"
                            data-control-name="paging"
                            data-control-action="paging">
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <!-- data -->
                    <div class="list  text-shadow">

                        <!-- item 1 -->
                        <?php
                        foreach ($providers as $provider) {
                            ?>

                            <div class="list-item ">
                                <div class="doc-serch-grid">
                                    <div class="row">
                                        <!-- img -->
                                        <div class="col-md-2">
                                            <div class="doc-grid-img">
                                                <?php if (isset($provider['profile_image']) && !empty($provider['profile_image'])) {
                                                    ?>
                                                    <img src="<?php echo SITE_URL; ?>image.php?width=100&height=100&cropratio=1:1&image=/<?php echo $provider['profile_image']; ?>&doc_root=<?php echo urlencode(PROFILE_FILE_UPLOAD_PATH); ?>">
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img src="<?php echo DEFAULT_PROFILE_PIC; ?>" alt="..." >
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="doc-name-head">
                                                <h1><a href="<?php echo SITE_URL; ?>profile/<?php echo $provider['user_id']; ?>"><?php echo $provider['first_name'] . " " . $provider['last_name']; ?></a></h1>
                                                <!--
                                                <span>City :
                                                <?php
                                                /*  if (isset($provider['city']) && !empty($provider['city'])) {
                                                  echo $provider['city'];
                                                  } else {
                                                  echo "N/A";
                                                  }
                                                 */
                                                ?>
                                                </span> -->

                                                <?php if (isset($provider['biography']) && !empty($provider['biography'])) { ?>
                                                    <p class="more1" > <?php
                                                        //echo $this->basic_model->strip_content($provider['biography'], 3000);
                                                        echo substr(trim(strip_tags($provider['biography'])), 0, 160);
                                                        if (strlen(trim(strip_tags($provider['biography']))) > 160) {
                                                            echo ' ....';
                                                            ?>
                                                            <br>
                                                            <a href="<?php echo SITE_URL; ?>profile/<?php echo $provider['user_id']; ?>">Show more</a>
                                                        <?php } ?>
                                                    </p>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <p>
                                                        <?php echo ""; ?>
                                                    </p> <?php
                                                }
                                                ?>

                                                <ul class="user-contact-info ph-sm">
            <!--                                                    <li> <b><i class="color-primary mr-sm fa fa-envelope"></i></b><a href="mailto:<?php echo $provider['user_email']; ?>"><?php echo $provider['user_email']; ?></a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="spec-grid">
                                                <h1>Specialties</h1>
                                                <?php
                                                if (isset($provider['specialities']) && !empty($provider['specialities'])) {
                                                    $specialities = $this->patient_model->get_provider_specialities($provider['specialities']);
                                                    if (isset($specialities) && !empty($specialities)) {
                                                        //$a = implode(', ', $specialities);
                                                        //echo '<p style="font-weight:600;">' . word_limiter($a, 10) . '</p>';
                                                        ?>
                                                        <ul>
                                                            <?php foreach ($specialities as $speciality) {
                                                                ?>
                                                                <li><a><?php echo character_limiter($speciality, 15); ?></a></li>
                                                                <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                        <?php
                                                    } else {
                                                        echo "None";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="btn-doc-serch text-center">


                                                <p class="text-center"><a  class="btn btn-primary" href="<?php echo PATIENT_URL; ?>bookanappointment/<?php echo $provider['user_id']; ?>">Book Appointment</a></p>
                                                <p class="text-center"><span class="txt-green">
                                                        <?php
                                                        if (isset($provider['session_cost']) && !empty($provider['session_cost'])) {
                                                            echo "$" . number_format($provider['session_cost'], 2);
                                                        }
                                                        ?>
                                                    </span><span class="txt-green1"> per session</span></p>
                                                <p class="text-center">
                                                    <!--<h1>Insurance Accepted</h1>-->
                                                    <span class="txt-green">
                                                        <span style="font-weight:600; font-size:14px;">Insurance Accepted</span>
                                                        <?php
                                                        if (isset($provider['insurance_carriers']) && !empty($provider['insurance_carriers'])) {
                                                            $insurance_carriers = $this->patient_model->get_insurence($provider['insurance_carriers']);
                                                            if (isset($insurance_carriers) && !empty($insurance_carriers)) {
                                                                $a = implode(', ', $insurance_carriers);
                                                                echo '<p style="font-weight:600;">' . word_limiter($a, 7) . '</p>';
                                                                ?>
                                                                <?php
                                                            } else {
                                                                echo '<p style="font-weight:600;">None</p>';
                                                            }
                                                        } else {
                                                            echo '<p style="font-weight:600;">None</p>';
                                                        }
                                                        ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <!-- data -->

                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <!-- item 2 -->


                    </div>
                    <!-- panel -->
                    <div class="jplist-panel panel-top">

                        <!-- items per page dropdown -->
                        <div
                            class="jplist-drop-down"
                            data-control-type="items-per-page-drop-down"
                            data-control-name="paging"
                            data-control-action="paging">

                            <ul>
                                <li><span data-number="3"> 3 per page </span></li>
                                <li><span data-number="5"> 5 per page </span></li>
                                <li><span data-number="10"> 10 per page </span></li>
                                <li><span data-number="15" data-default="true"> 15 per page </span></li>
                                <li><span data-number="all"> View All </span></li>
                            </ul>
                        </div>

                        <div
                            class="jplist-label"
                            data-type="Page {current} of {pages}"
                            data-control-type="pagination-info"
                            data-control-name="paging"
                            data-control-action="paging">
                        </div>

                        <div
                            class="jplist-pagination"
                            data-control-type="pagination"
                            data-control-name="paging"
                            data-control-action="paging">
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <!-- no results -->
                    <div class="jplist-no-results text-shadow align-center">
                        <p>No results found</p>
                    </div>
                </div>

            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger static_alrt_sh">No counselors are available within the parameters you have selected. Please modify your criteria to find available counselors.</div>
            <?php
        }
    } else if ($form = 0) {
        // Book An Appointment

        if (isset($provider_availabality) && !empty($provider_availabality)) {
            $schedules = $provider_availabality['schedule'];
            $timings = $provider_availabality['timings'];
            $final_array = array();
            $d = 0;
            if (isset($schedules) && !empty($schedules)) {
                foreach ($schedules as $schedule) {

                    $final_array[$d] = 'new Date(' . date('Y', strtotime($schedule['start_date'])) . ', ' . date('m', strtotime($schedule['start_date'])) . ', ' . (date('d', strtotime($schedule['start_date'])) - 1) . '),"' . date('m/d/Y', strtotime($schedule['start_date'])) . '"';
                    $d++;
                }
            }
        }
        ?>
        <div class="col-sm-6 col-xs-6 col-sm-offset-3">
            <div class="x_panel">
                <div class="x_content">
                    <form action="<?php echo PATIENT_URL; ?>payment" method="post">
                        <div class="form-group">
                            <label class="control-label">Counselor : </label>
                            <label class="control-label"><strong><?php echo ucwords($provider_data['first_name'] . " " . $provider_data['last_name']); ?></strong></label>
                            <a href="<?php echo PATIENT_URL; ?>bookanappointment">Change</a> </div>
                        <div class="form-group">
                            <label class="control-label">Appointment Date : </label>
                            <input type="hidden" name="provider_id" id="provider_id" value="<?php echo $provider_data['user_id']; ?>" />
                            <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $patient_data->user_id; ?>" />
                            <?php if (isset($provider_data['session_cost']) && !empty($provider_data['session_cost'])) {
                                ?>
                                <input type="hidden" name="session_cost" class="form-control" id="session_cost" value="<?php echo number_format($provider_data['session_cost'], 2); ?>" />
                                <?php
                            }
                            ?>
                            <div class='input-group date'  id="appointmentdate" style=" margin-bottom:0">
                                <input type="text" name="appointmentdate" id="appointmentdate_1" class="form-control noneditable" required />
                                <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Time Slots</label>
                            <select class="form-control" name="timeslot" id="timeslot">
                                <?php
                                if (isset($timings) && !empty($timings)) {
                                    foreach ($timings as $timing) {
                                        ?>
                                        <option value="<?php echo $timing['start_time']; ?>"><?php echo $timing['start_time']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <div class="clearfix"><br/><br/></div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Proceed >></button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript">
                    $(document).ready(function (e) {
            $('#appointmentdate').datetimepicker({
            format: 'MM/DD/YYYY',
                    defaultDate: "<?php echo date('M/d/Y'); ?>",
                    enabledDates: [
    <?php echo implode(",", $final_array); ?>
                    ]

            });
            });
                    $("#timeslot").focus(function (e) {

            var date_val = $("#appointmentdate_1").val();
                    date_val = date_val.replace(/\//g, "-", date_val);
                    date_val = escape(date_val);
                    $.get("<?php echo PATIENT_URL; ?>get_time_slots/<?php echo $provider_data['user_id']; ?>/" + date_val, function (data, status) {

                    $("#timeslot").html(data);
                    });
            });</script>
        <?php
    } else {
        ?>
        <div class="x_content">
            <?php if (isset($error) && !empty($error)) {
                ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php
            }
            ?>
            <?php if (isset($message) && !empty($message)) {
                ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
                <?php
            }
            ?>
            <div class="form-group">
                <label class="control-label">Counselor : </label>
                <label class="control-label"><strong><?php echo ucwords($provider_data['first_name'] . " " . $provider_data['last_name']); ?></strong></label>
                <a href="<?php echo PATIENT_URL; ?>bookanappointment">Change</a> </div>
            <div class="card-box">
                <div id="calendars"></div>
            </div>
            <form id="appform" action="<?php echo PATIENT_URL; ?>payment" method="post">

                <input type="hidden" name="provider_id" id="provider_id" value="<?php echo $provider_data['user_id']; ?>" />
                <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $patient_data->user_id; ?>" />
                <?php if (isset($provider_data['session_cost']) && !empty($provider_data['session_cost'])) {
                    ?>
                    <input type="hidden" name="session_cost" class="form-control" id="session_cost" value="<?php echo number_format($provider_data['session_cost'], 2); ?>" />
                    <?php
                }
                ?>
                <input type="hidden" name="appointmentdate" id="appointmentdate_1" class="form-control noneditable" required />
                <input type="hidden" name="timeslot" id="timeslot" class="form-control noneditable" required />
                <input type="hidden" name="end_dateslot" id="end_dateslot" class="form-control noneditable" required />
                <input type="hidden" name="end_timeslot" id="end_timeslot" class="form-control noneditable" required />
            </form>
        </div>
        <style>
            .fc-event{
                cursor: pointer;
            }
        </style>
        <script>
                    function show_modal(start_date, start_time, end_time, end_date){
                    $('#appointmentdate_1').val(start_date);
                            $('#timeslot').val(start_time);
                            $('#end_timeslot').val(end_time);
                            $('#end_dateslot').val(end_date);
                            $('#appform').submit();
                    }
            $(document).ready(function() {
            //		$(".groups_dropdown").chosen({});

            $('#calendars').fullCalendar({
            header: {
            left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
            },
                    defaultDate:'<?php echo date('Y-m-d'); ?>',
                    //			defaultDate: '2016-12-12',
                    navLinks: true, // can click day/week names to navigate views
                    selectable: false,
                    selectHelper: true,
                    editable: false,
                    eventLimit: true, // allow "more" link when too many events
                    timeFormat: 'h(:mm) a',
                    eventClick: function (calEvent, jsEvent, view) {
                    show_modal(calEvent.start_date, calEvent.start_time, calEvent.end_time, calEvent.end_date);
                    },
                    events: [
    <?php
    if (isset($schedules) && !empty($schedules)) {
        foreach ($schedules as $schedule) {

            $avail_check = $this->provider_model->get_slot_booking($schedule->provider_id, $schedule->avail_id);
            if ($avail_check) {
                continue;
            }
            ?>
                            {
                            title: '<?php
            if ($avail_check) {
                echo "Booked";
            } else {
                echo "Available";
            }
            ?>',
                                    start: '<?php echo $schedule->start_date . " " . $schedule->start_time; ?>',
                                    start_date: '<?php echo date('m/d/Y', strtotime($schedule->start_date)); ?>',
                                    end_date: '<?php echo date('m/d/Y', strtotime($schedule->end_date)); ?>',
                                    start_time: '<?php echo $schedule->start_time; ?>',
                                    end_time: '<?php echo $schedule->end_time; ?>',
                                    end: '<?php echo $schedule->end_date . " " . $schedule->end_time; ?>',
                                    avail_id:'<?php echo $schedule->avail_id; ?>',
                                    provider_id:'<?php echo $schedule->provider_id; ?>',
            <?php
            if ($avail_check) {
                echo "className: 'bg-purple',slot_id: '" . $avail_check[0]['app_id'] . "',patient_id: '" . $avail_check[0]['patient_id'] . "'";
            }
            ?>
                            },
            <?php
        }
    }
    ?>
                    ]
            });
            });
                    $(document).ready(function(e) {
            $(".datetimepicker").datetimepicker({
            minDate:new Date(<?php echo date('Y'); ?>, <?php echo date('m') - 1; ?>, <?php echo date('d'); ?>),
                    format: 'MM/DD/YYYY'

            });
            });
                    $("#avail_form").validate({
            rules: {
            identity: {
            required: true
            },
                    password: {
                    required: true
                    }
            },
                    errorPlacement: function (error, element) {
                    var my = "";
                            var at = "";
                            if ($(window).width() < 800) {
                    my = 'bottom right';
                            at = 'top right';
                    } else {
                    my = 'bottom right';
                            at = 'top right';
                    }
                    if (!error.is(':empty')) {
                    $(element).not('.valid').qtip({
                    overwrite: false,
                            content: error,
                            show: 'focus',
                            hide: 'blur',
                            position: {
                            my: my,
                                    at: at,
                                    viewport: $(window),
                                    adjust: {
                                    x: 0,
                                            y: 0
                                    }
                            },
                            style: {
                            classes: 'qtip-custom qtip-shadow',
                                    tip: {
                                    height: 6,
                                            width: 11
                                    }
                            }
                    }).qtip('option', 'content.text', error);
                    } else {
                    element.qtip('destroy');
                    }
                    },
                    success: "valid"
            });</script>
        <?php
    }
    ?>

</div>
<div class="clearfix"></div>

<style>
    .morecontent span {
        display: none;
    }
    .morelink {
        display: block;
    }
    .doc-name-head span {
        font-size: 14px;
    }
</style>
<script type="text/javascript">
            $(document).ready(function() {
    var showChar = 80;
            var ellipsestext = "...";
            var moretext = "Show more >";
            var lesstext = "Show less";
            $('.more').each(function() {
    var content = $(this).html();
            if (content.length > showChar) {

    var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
            $(this).html(html);
    }

    });
            $(".morelink").click(function(){
    if ($(this).hasClass("less")) {
    $(this).removeClass("less");
            $(this).html(moretext);
    } else {
    $(this).addClass("less");
            $(this).html(lesstext);
    }
    $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
    });
    });
</script>
