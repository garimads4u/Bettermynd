<?php
//prd($user_detail, 1);
?>

<div id="userDetailModal<?= $result->user_id ?>" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Student Details</h4>
            </div>
            <div class="modal-body">
                <table id="datatable" class="table table-striped table-bordered">
                    <tbody>
                        <?php
                        $gender = array('' => '') + $this->config->item('Gender');
                        $yesno = array('' => '') + $this->config->item('YesNo');
                        ?>
                        <tr><th>Name:</th><td><?= ucwords($result->first_name . ' ' . $result->last_name) ?></td></tr>
                        <tr><th>Email:</th><td><?= $result->user_email ?></td></tr>
                        <tr><th>College Name:</th><td><?= $result->college_name ?></td></tr>
                        <tr><th>Student College ID:</th><td><?= $result->patient_identification_number ?></td></tr>
                        <tr><th>Date Of Birth:</th><td><?= show_date($result->dob) ?></td></tr>
                        <tr><th>Mobile Number:</th><td><?= $result->mobile_no ?></td></tr>
                        <tr><th>Gender:</th><td><?= $gender[$result->gender] ?></td></tr>
                        <tr><th>Ethnicity:</th><td><?= $ethnicity_list[$result->ethnicity] ?></td></tr>
                        <tr><th>TimeZone:</th><td><?= $result->timezone_id ? $timezone_list[$result->timezone_id] : '' ?></td></tr>
                        <tr><th>Campus Address:</th><td><?= $result->address ?></td></tr>
                        <tr><th>State:</th><td><?= $result->state ? $states[$result->state] : '' ?></td></tr>
                        <tr><th>City:</th><td><?= $result->city ?></td></tr>
                        <tr><th>Zipcode:</th><td><?= $result->zipcode ?></td></tr>
                        <tr><th>International Student:</th><td><?= $yesno[$result->is_international] ?></td></tr>
                        <tr><th>Student Athlete:</th><td><?= $yesno[$result->athlete] ?></td></tr>
                        <tr><th>Class Year:</th><td><?= $result->class_year ?></td></tr>
                        <tr><th>Profile Image:</th>
                            <td><?php if (isset($result) && isset($result->profile_image) && strlen($result->profile_image) > 0) {
                            ?>
                                    <img src="<?php echo IMAGE_VIEW_URL; ?>?image=/<?php echo $result->profile_image; ?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(PROFILE_FILE_UPLOAD_PATH); ?>" class="img-responsive  profile_img"/>
                                    <?php
                                } else {
                                    ?>
                                    <img src="<?php echo DEFAULT_PROFILE_PIC; ?>" alt="..." class="img-responsive profile_img">
                                <?php } ?></td>
                        </tr>
                        <tr><th>Last Logged in:</th><td><?= show_dateTime($result->user_last_loggedon) ?></td></tr>
                        <tr><th>Registered On:</th><td><?= show_date($result->user_createdon) ?></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>