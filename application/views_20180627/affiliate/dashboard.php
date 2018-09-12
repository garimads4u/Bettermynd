<div class="col-md-8 col-sm-8">
    <div class="x_panel">
        <div class="x_content">
            <h4>Earn Recurring Referral Commissions</h4>
            <br />
            <p>
                <strong>Recommend Brandize to Your Clients or Agents and Earn 10% Commission for as Long as they Remain a Member</strong>
                <br /><br/>

                For Example if you refer a company with 100 user signup: (100*$149)10% = $1,490 would be your commission, and it
                would continue each year for those users which renew membership. Commissions are paid via PayPal at the time member's
                initial and renewal payments are processed
            </p>
            <a href="<?php echo AFFILIATE_URL . 'profile'; ?>" class="btn btn-default">Edit Affiliate Profile</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_content">
            <h4 class="capsON">Affiliate Sales</h4>
            <p>
                Below is your Affiliate sales history.
                <br /><br />
            </p>
            <div class="row">
                <div class="col-sm-5 text-left">
                    <strong>
                        Total Active Member Referrals: <span class="headingBlue"><?php echo $count_active_member; ?></span><br />
                        Total Link Clicks : <span class="headingBlue"><?php echo $total_click; ?></span>
                    </strong>
                </div>
                <div class="col-sm-7 text-right">
                    <strong>
                        Current Commission: <span class="headingBlue"><?php echo CURRENCY_SYMBOL.' '. $current_commission;?></span>   |   Due: <span class="headingBlue"><?php echo $lastdate;?></span><br />
                        Last Commission : <span class="headingBlue"><?php echo CURRENCY_SYMBOL.' '. $last_commission;?></span>   |  Date: <span class="headingBlue"><?php echo $previousdate;?></span>
                    </strong>
                </div>
            </div>
            <div id="morris-chart" style="width:100%;">
            </div>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_content">
            <h4 class="capsON">Sales by User</h4>
            <div class="">
                <table class="table table-striped table-bordered" id="dtsalesbyuser">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Company Url</th>
                            <th>Date Joined</th>
                            <th>Renewal Date</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                    if (isset($all_ref) && count($all_ref) > 0 && !empty($all_ref)) {
                        foreach ($all_ref as $value) {
                            echo "<tr>"
                            . "<td>" . $value->username . "</td>"
                            . "<td>" . $value->company_url . "</td>"
                            . "<td>" . date(DATE_FORMAT, ($value->user_createdon)) . "</td>"
                            . "<td>" . date(DATE_FORMAT, (strtotime($value->subscription_end_date))) . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                       
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="col-md-4 col-sm-4">
    <div class="x_panel template_preview">
        <div class="x_content">
            <h3 class="capsON headingBlue">Get Started</h3>
            <h4 class="capsON">Share your Referral Link</h4>
            <br />
            <div class="row bgGreen">
                <div class="col-xs-12">Your Referral Link</div>
                <div class="col-xs-8"><input type="text" class="form-control" value="<?php echo $referrer_link; ?>" id='r_link'/></div>
                <div class="col-xs-2"><a class="btn btn-default clipbrd" data-clipboard-action="copy" data-clipboard-target="#r_link" id="copybtn" data-toggle="tooltip" title="Copy to clipboard">Copy</a></div>
                
            </div>
            <br />
            <h4 class="capsON">Download Affiliate Materials</h4>
            <br />
            <div class="row bgGreen">
                <div class="col-sm-6 text-center">
                    <a href="#">
                        <img src="<?php echo IMAGES_URL; ?>banners.png" alt="" />
                        Banners
                    </a>
                </div>
                <div class="col-sm-6 text-center ">
                    <a href="#">
                        <img src="<?php echo IMAGES_URL; ?>email_script.png" alt="" />
                        E-Mail Scripts
                    </a>
                </div>
            </div>

            <br />

            <h4 class="capsON">Marketing & Sales tips</h4>
            <div class="row bgGreen">
                <ul>
                    <li><a href="#">Article Title 1</a></li>
                    <li><a href="#">Article Title 2</a></li>
                    <li><a href="#">Article Title 3</a></li>
                    <li><a href="#">Article Title 4</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo JS_URL; ?>clipboard.min.js"></script>
<script type="text/javascript">
   
    $(document).ready(function () {
        $('#dtsalesbyuser').dataTable({
            "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
             "ordering": false,
            "bFilter": false,
            "bInfo":false,
            "bLengthChange": false,
           "pagingType" :"simple_numbers"
        });
        $('#datatable-keytable').DataTable({
            keys: true
        });
        $('#datatable-responsive').DataTable();
        $('#datatable-scroller').DataTable({
            ajax: "js/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({
            fixedHeader: true
        });
        
        var data = <?php echo $affiliate_sale;?>,
                config = {
                    data: data,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Total Users'],
                    fillOpacity: 0.6,
                    hideHover: 'auto',
                    behaveLikeLine: true,
                    onlyIntegers: true,
                    resize: true,
                    pointFillColors: ['#ffffff'],
                    pointStrokeColors: ['#55acee'],
                    lineColors: ['#55acee'],
                    yLabelFormat: function(y){return y != Math.round(y)?'':y;},
                                xLabelFormat: function (x) {
                     var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
                    var month = IndexToMonth[ x.getMonth() ];
                    var year = x.getFullYear();
                    return  month;
                },
                dateFormat: function (x) {
                    var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
                    var month = IndexToMonth[ new Date(x).getMonth() ];
                    var year = new Date(x).getFullYear();
                    return month;
                },
                  
                };
        config.element = 'morris-chart';
        Morris.Line(config);
    });
    var clipboard = new Clipboard('.clipbrd');
    
    //clipboard.on('success', function(e) {
        $('#copybtn').on({
        "click": function() {
         $(this).tooltip({ items: "#copybtn", content: "Copied"});
          $(this).tooltip("open");
         },
         "mouseout": function() {    
//             $(this).tooltip("disable");   
            $(this).attr('title','');
        }
});

    //e.clearSelection();
   // });

    clipboard.on('error', function(e) {
     
    });
     
    
   
</script>

