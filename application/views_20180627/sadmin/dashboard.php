
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink hover-expand-effect">
            <div class="icon1">
                <i class="fa fa-building-o" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">Total Colleges</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_colleges; ?>" data-speed="15" data-fresh-interval="20"><?php echo $total_colleges; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon1">
                <i class="fa fa-user-md" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">Total Providers</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_providers; ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total_providers; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon1">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">Total Students</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_patients; ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total_patients; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon1">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">NEW APPOINTMENTS</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_appointments; ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total_appointments; ?></div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix" style="display:none;">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Notifications
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="row clearfix">
                            <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                                <form id="send_flashmessage_form" action="<?php echo base_url('sadmin/dashboard'); ?>" method="post">
                                    <div class="form-group">
                                        <label for="collegelist">Select Colleges</label><span class="mandatory">*</span>
                                        <?php
                                        $options = $college;
                                        $selected = '';
                                        $attr = 'class="form-control chosen-select" multiple="multiple"';
                                        echo form_dropdown('college_id[]', $options, $selected, $attr);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea class="form-control" id="message" name="flashmessage" placeholder="Message" maxlength="500"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary pull-right" name="send_flashmessage" value="Send">Send</button>
                                </form>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">

                                <table id="datatable_notification" class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>Colleges</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (isset($flashmessages) && !empty($flashmessages) && count($flashmessages) > 0) {
                                            foreach ($flashmessages as $value) {
                                                echo "<tr>"
                                                . "<td>" . ucfirst($value->colleges) . "</td>"
                                                . "<td>" . ucfirst($value->message) . "</td>"
                                                . "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='2' align='center'>No Record Found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- message to do list -->
    <div class="col-md-6 col-sm-6 col-xs-12 recentactivity latestmsg">
        <div class="x_panel">
            <div class="x_title">
                <h2>LAST TRANSACTIONS</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                 <!--<th>#</th>-->
                                <th>PROVIDER</th>
                                <th>STUDENT</th>
                                <th>AMOUNT</th>
                                <th>TRANSACTION ID</th>
                                <th>FROM</th>
                                <th>TO</th>
<!--                            <th>Status</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($last_transactions) && !empty($last_transactions) && count($last_transactions) > 0) {
                                foreach ($last_transactions as $value) {
                                    echo "<tr>"
                                    //. "<td>" . $i . "</td>"
                                    . "<td>" . ucfirst($value->provider_name) . "</td>"
                                    . "<td>" . ucfirst($value->patient_name) . "</td>"
                                    . "<td>" . ($value->amount ? CURRENCY_SYMBOL . $value->amount : '') . "</td>"
                                    . "<td>" . $value->transaction_no . "</td>"
                                    . "<td>" . show_dateTime($value->start_date . ' ' . $value->start_time) . "</td>"
                                    . "<td>" . show_dateTime($value->end_date . ' ' . $value->end_time) . "</td>"
//                              . "<td><a class='btn btn-primary btn-xs' href='#'><i class='fa fa-folder'></i>  </a><a class='btn btn-danger btn-xs' href='#'><i class='fa fa-trash-o'></i>  </a></td>"
                                    . "</tr>";
                                    $i++;
                                }
                            } else {
                                echo "<tr><td colspan='7' align='center'>No Record Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End to do list -->

    <!-- start of appointment widget -->
    <div class="col-md-6 col-sm-6 col-xs-12 recentactivity latestmsg">
        <div class="x_panel">
            <div class="x_title">
                <h2>UPCOMING APPOINTMENTS</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <!--<th>#</th>-->
                                <th>PROVIDER</th>
                                <th>STUDENT</th>
                                <th>FROM</th>
                                <th>TO</th>
<!--                            <th>Status</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($upcoming_appointment) && !empty($upcoming_appointment) && count($upcoming_appointment) > 0) {
                                foreach ($upcoming_appointment as $value) {
                                    echo "<tr>"
                                    //. "<td>" . $i . "</td>"
                                    . "<td>" . ucfirst($value->provider_name) . "</td>"
                                    . "<td>" . ucfirst($value->patient_name) . "</td>"
                                    . "<td>" . show_dateTime($value->start_date . ' ' . $value->start_time) . "</td>"
                                    . "<td>" . show_dateTime($value->end_date . ' ' . $value->end_time) . "</td>"
//                              . "<td><a class='btn btn-primary btn-xs' href='#'><i class='fa fa-folder'></i>  </a><a class='btn btn-danger btn-xs' href='#'><i class='fa fa-trash-o'></i>  </a></td>"
                                    . "</tr>";

                                    $i++;
                                }
                            } else {
                                echo "<tr><td colspan='5' align='center'>No Record Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <a href="<?php echo SADMIN_URL; ?>upcoming_appoinment" class="btn btn-primary">More</a>
                </div>

            </div>
        </div>
    </div>
    <!-- end of weather widget -->
</div>
<!--
<div class="x_panel">
    <div class="x_content">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div>
                    <div class="profile-photo">
                        <img alt="Jane Doe" src="<?php echo ASSETS_URL; ?>images/user-avatar.jpg">
                    </div>
                    <div class="user-header-info">
                        <h2 class="user-name">Jane Doe</h2>
                        <h5 class="user-position">UI Designer</h5>
                        <div class="user-social-media">
                            <div class="text-lg"><a href="#" class="fa fa-twitter-square"></a> <a href="#" class="fa fa-facebook-square"></a> <a href="#" class="fa fa-linkedin-square"></a> <a href="#" class="fa fa-google-plus-square"></a></div>
                        </div>
                        <div class="clear"></div>
                        <div><a class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#myModal">Edit </a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="user-inf">
                    <div class="">

                        <ul class="user-contact-info ph-sm">
                            <li><b><i class="color-primary mr-sm fa fa-envelope"></i></b> jane-doe@email.com</li>
                            <li><b><i class="color-primary mr-sm fa fa-phone"></i></b> (023) 234 2344</li>
                            <li><b><i class="color-primary mr-sm fa fa-globe"></i></b> Helsinki, Finland</li>

                        </ul>
                    </div>
                </div></div>
            <div class="col-md-6 col-lg-4">
                <div class="b-primary bt-sm ">
                    <div class="user-job">
                        <div class="widget-list list-sm list-left-element ">
                            <ul>
                                <li>
                                    <a href="#">
                                        <div class="left-element"><i class="fa fa-check color-success"></i></div>
                                        <div class="text">
                                            <span class="title">95 Jobs</span>
                                            <span class="subtitle">Completed</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="left-element"><i class="fa fa-clock-o color-warning"></i></div>
                                        <div class="text">
                                            <span class="title">3 Proyects</span>
                                            <span class="subtitle">working on</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="left-element"><i class="fa fa-envelope color-primary"></i></div>
                                        <div class="text">
                                            <span class="title">Leave a Menssage</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="black-bdr"><div class="clear"></div>
        <h2 class="profile-head">Practice Related Information</h2>
        <div class="clear"></div>


        <div class="profile-view-state">


            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Education</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Awards</a></li>
                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Hospitals</a></li>
                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Practice</a></li>
                <li role="presentation"><a href="#specialty" aria-controls="specialty" role="tab" data-toggle="tab">Specialty</a></li>
            </ul>


            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                                <tr>
                                    <th>Qualification</th>
                                    <th>University</th>
                                    <th>Passing Year</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>MBBS</td>
                                    <td>dreamsoft University</td>
                                    <td>2009</td>

                                    <td>

                                        <a class="btn btn-info btn-xs" href="#"><i class="fa fa-pencil"></i>  </a>
                                        <a class="btn btn-danger btn-xs" href="#"><i class="fa fa-trash-o"></i>  </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>MBBS</td>
                                    <td>dreamsoft University</td>
                                    <td>2009</td>

                                    <td>

                                        <a class="btn btn-info btn-xs" href="#"><i class="fa fa-pencil"></i>  </a>
                                        <a class="btn btn-danger btn-xs" href="#"><i class="fa fa-trash-o"></i>  </a>
                                    </td>
                                </tr>




                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="profile">...</div>
                <div role="tabpanel" class="tab-pane" id="messages">...</div>
                <div role="tabpanel" class="tab-pane" id="settings">...</div>
                <div role="tabpanel" class="tab-pane" id="specialty">...</div>
            </div>

        </div>
    </div>

</div>
-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">First Name</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Last Name</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date of Birth</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Gender</label>
                                <select class="form-control">
                                    <option>Male</option>
                                    <option>Female</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Contact Number</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Contact Number">
                            </div>
                        </div><div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Address">
                            </div>
                        </div><div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">City</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="City">
                            </div>
                        </div><div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">State</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="State">
                            </div>
                        </div><div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Zip</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Zip">
                            </div>
                        </div><div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Experience</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Experience">
                            </div>
                        </div><div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Profile Image</label>
                                <div class="col-md-12 text-center">
                                    <div class="Img text-center">
                                        <div class="profilePic"><img id="img_prev" width="100" alt="" src="<?php echo ASSETS_URL; ?>images/user-avatar.jpg" class="img-thumbnail img-circle"></div>
                                    </div>
                                    <br>
                                </div>
                                <br class="clear">  <p class="text-center">
                                    <a class="btn btn-info " href="#"><i class="fa fa-pencil"></i>  Edit Image</a>
                                    <a class="btn btn-danger " href="#"><i class="fa fa-trash-o"></i>  Delete Image</a>
                                </p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- end of weather widget -->
</div>