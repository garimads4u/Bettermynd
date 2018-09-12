<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BetterMynd | <?php
            if (isset($header_data) && isset($header_data['page_title'])) {
                echo $header_data['page_title'];
            }
            ?></title>

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo IMAGES_URL; ?>favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo IMAGES_URL; ?>favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo IMAGES_URL; ?>favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo IMAGES_URL; ?>favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo IMAGES_URL; ?>favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#000000">
        <meta name="msapplication-TileImage" content="<?php echo IMAGES_URL; ?>favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">


        <!-- Bootstrap core CSS -->
        <script type="text/javascript" src="<?php echo JS_URL . "moment.js"; ?>"></script>
        <script src="<?php echo JS_URL . "jquery.min.js"; ?>"></script>

        <script src="<?php echo JS_URL . "bootstrap.min.js"; ?>"></script>
        <script type="text/javascript" src="<?php echo JS_URL . "bootstrap-datetimepicker.js"; ?>"></script>
        <link href="<?php echo CSS_URL . "bootstrap.min.css"; ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo CSS_URL . "bootstrap-datetimepicker.min.css"; ?>" />
        <link href="<?php echo CSS_URL . "brandize-custom.css"; ?>" rel="stylesheet">

        <link href="<?php echo FONTS_URL . "css/font-awesome.min.css"; ?>" rel="stylesheet">
        <link href="<?php echo CSS_URL . "animate.min.css"; ?>" rel="stylesheet">
        <!-- Custom styling plus plugins -->
        <link href="<?php echo CSS_URL . "custom.css"; ?>" rel="stylesheet">
        <link href="<?php echo CSS_URL . "icheck/flat/blue.css"; ?>" rel="stylesheet">
        <link href="<?php echo JS_URL . "datatables/css/new_datatable.css"; ?>" rel="stylesheet" type="text/css" />

        <!-- Choosen select -->
        <link rel="stylesheet" href="<?php echo CSS_URL . "select/prism.css"; ?>">
        <link rel="stylesheet" href="<?php echo CSS_URL . "select/chosen.css"; ?>">

        <!-- Multi select -->
        <script src="<?php echo JS_URL; ?>jquery-ui.js"></script>


        <!-- switchery -->
        <link rel="stylesheet" href="<?php echo CSS_URL . "switchery/bootstrap-switch.css"; ?>" />
        <link rel="stylesheet" href="<?php echo CSS_URL . "switchery/switchery.min.css"; ?>" />


        <link href="<?php echo CSS_URL; ?>jquery.qtip.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo JS_URL; ?>myPlugin/myPlugin.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>jquery-ui.css">
        <!--calendar css-->
        <link href="<?php echo JS_URL . "fullcalendar/dist/fullcalendar.css"; ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>file_upload.css">
        <!--[if lt IE 9]>
                <script src="<?php echo JS_URL; ?>ie8-responsive-file-warning.js"></script>
                <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                <![endif]-->
        <script>
            var SITE_URL = "<?php echo SITE_URL; ?>";
            var SITE_URL_ROOT = "<?php echo SITE_URL; ?>";
        </script>

        <script type="text/javascript" src="<?php echo JS_URL; ?>jquery.form.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>imgareaselect-animated.css" />
        <script type="text/javascript" src="<?php echo JS_URL; ?>jquery.imgareaselect.js"></script>

        <?php if (isset($company_details) && !empty($company_details) && strlen($company_details['company_logo1_color1']) > 0) {
            ?>
            <style type="text/css">
                .btn-primary{
                    background-color:<?php echo $company_details['company_logo1_color1']; ?> !important;
                    border-color:<?php echo $company_details['company_logo1_color1']; ?> !important;

                }
                .label-primary{
                    background-color:<?php echo $company_details['company_logo1_color1']; ?> !important;
                    border-color:<?php echo $company_details['company_logo1_color1']; ?> !important;

                }
                #slider .ui-widget-header {
                    background-color:<?php echo $company_details['company_logo1_color1']; ?> !important;
                }

                .icheckbox_flat-blue.checked {background-color:<?php echo $company_details['company_logo1_color1']; ?> !important;}
                .iradio_flat-blue.checked{background-color:<?php echo $company_details['company_logo1_color1']; ?> !important;}
                .paginate_button.active a{
                    background-color:<?php echo $company_details['company_logo1_color1']; ?> !important;
                    border-color:<?php echo $company_details['company_logo1_color1']; ?> !important;
                }
                .progress-bar{
                    background-color:<?php echo $company_details['company_logo1_color1']; ?> !important;
                }
                .design_steps{
                    color:<?php echo $company_details['company_logo1_color1']; ?> !important;
                }
                #theme_type_chosen:hover,#theme_type_chosen:selected{
                    background-color:<?php echo $company_details['company_logo1_color1']; ?> !important;
                }
                .template_preview{
                    border-top:2px solid <?php echo $company_details['company_logo1_color1']; ?> !important;
                }
                .menu_section h3::after{
                    border-bottom:1px solid <?php echo $company_details['company_logo1_color1']; ?> !important;
                }
                .mnotification{
                    background-color:<?php echo $company_details['company_logo1_color1']; ?> !important;
                    border:solid 1px <?php echo $company_details['company_logo1_color1']; ?> !important;
                }
            </style>
            <?php
        } else {
            ?>
            <style type="text/css">
                .icheckbox_flat-blue.checked {background-color:#55acee !important;}
                .iradio_flat-blue.checked{background-color:#55acee !important;}
            </style>
            <?php
        }
        $add_script = 1;
        if ($this->ion_auth->logged_in() && $this->ion_auth->user()->row()->user_type == 1) {
            $add_script = 0;
        }

        if ($add_script == 1) {
            ?>

            <script type="text/javascript">
            window.heap = window.heap || [], heap.load = function (e, t) {
                window.heap.appid = e, window.heap.config = t = t || {};
                var r = t.forceSSL || "https:" === document.location.protocol, a = document.createElement("script");
                a.type = "text/javascript", a.async = !0, a.src = (r ? "https:" : "http:") + "//cdn.heapanalytics.com/js/heap-" + e + ".js";
                var n = document.getElementsByTagName("script")[0];
                n.parentNode.insertBefore(a, n);
                for (var o = function (e) {
                    return function () {
                        heap.push([e].concat(Array.prototype.slice.call(arguments, 0)))
                    }
                }, p = ["addEventProperties", "addUserProperties", "clearEventProperties", "identify", "removeEventProperty", "setEventProperties", "track", "unsetEventProperty"], c = 0; c < p.length; c++)
                    heap[p[c]] = o(p[c])
            };
            heap.load("2197708629");
            </script>
        <?php } ?>
    </head>

    <body class="nav-md">

        <noscript>
        <meta http-equiv="refresh" content="0.0;url=<?php echo base_url('index/nojs'); ?>">

        <style>.body { display:none; }</style>
        </noscript>
        <div class="container body">
            <div class="main_container">
                <?php echo isset($content_for_layout_sidebar) ? $content_for_layout_sidebar : ''; ?>

                <!-- top navigation -->
                <?php echo isset($content_for_layout_header) ? $content_for_layout_header : ''; ?>

                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="row">

                        <?= isset($content_for_layout_middle) ? $content_for_layout_middle : ''; ?>

                    </div>

                </div>
                <!-- /page content -->

            </div>
        </div>
        <div id="custom_notifications" class="custom-notifications dsp_none">
            <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
            </ul>
            <div class="clearfix"></div>
            <div id="notif-group" class="tabbed_notifications"></div>
        </div>


        <script type="text/javascript" src="<?php echo JS_URL . "jquery.validate.js"; ?>"></script>
        <script type="text/javascript" src="<?php echo JS_URL . "additional-methods.js"; ?>"></script>
        <script type="text/javascript" src="<?php echo JS_URL; ?>nicescroll/jquery.nicescroll.min.js"></script>
        <script src="<?php echo JS_URL; ?>qtip/jquery.qtip.min.js" type="text/javascript"></script>
        <script src="<?php echo JS_URL . "jquery.formance.min.js"; ?>"></script>
        <script src="<?php echo JS_URL . "awesome_form.js"; ?>"></script>
<!--        <script src="<?php echo JS_URL; ?>sortable.js"></script>
        <script src="<?php echo JS_URL; ?>sortable-app.js"></script>-->
        <script src="<?php echo JS_URL; ?>pace/pace.min.js"></script>


        <script src="<?php echo JS_URL . "bootbox.min.js"; ?>"></script>
        <!-- bootstrap progress js -->
        <script src="<?php echo JS_URL . "progressbar/bootstrap-progressbar.min.js"; ?>"></script>
        <!-- icheck -->
        <script src="<?php echo JS_URL . "icheck/icheck.min.js"; ?>"></script>
        <!-- switchery -->
        <script src="<?php echo JS_URL . "switchery/switchery.min.js"; ?>"></script>
        <script src="<?php echo JS_URL . "custom.js"; ?>"></script>

        <!-- Datatables-->
        <script src="<?php echo JS_URL . "datatables/new_datatables.js"; ?>"></script>
        <script src="<?php echo JS_URL . "datatables/dataTables.bootstrap.js"; ?>"></script>

        <!-- pace -->
        <script src="<?php echo JS_URL . "moris/raphael-min.js"; ?>"></script>
        <script src="<?php echo JS_URL . "moris/morris.min.js"; ?>"></script>

        <link rel="stylesheet" href="<?php echo CSS_URL . "select/bootstrap-multiselect.css"; ?>">
        <script src = "<?php echo JS_URL . "select/bootstrap-multiselect.js"; ?>"></script>

        <script type="text/javascript">
            $(document).ready(function (e) {
                $('.groups_dropdown').multiselect({nonSelectedText: 'Select A Group', numberDisplayed: 1});
            });



        </script>



        <script type="text/javascript">

            $(document).ready(function () {
                $('input.phone_number').formance('format_phone_number');
            });

            $(document).ready(function () {
                $('#datatable_no_search').dataTable({
                    "ordering": true,
                    "searching": false,
                    aaSorting: [],
                    "oLanguage": {
                        "sEmptyTable": "No record found."
                    }
                });
                $('#datatable, #datatable1').dataTable({
                    "ordering": true,
                    aaSorting: [],
                    "oLanguage": {
                        "sEmptyTable": "No record found."
                    }
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
                $('#datatable_notification').dataTable({
                    "ordering": false,
                    "searching": false,
                    "lengthChange": false,
                    "pageLength": 2,
                    scrollY: 180,
                    "scrollX": false,
                    "oLanguage": {
                        "sEmptyTable": "No record found."
                    }
                });
                var table = $('#datatable-fixed-header').DataTable({
                    fixedHeader: true
                });

            });

            $(document).on("click", ".logout", function (e) {

                bootbox.confirm({
                    buttons: {
                        confirm: {
                            label: '<?php echo $this->lang->line('logout_confirm_button_confirm_label'); ?>'
                                    //className: 'confirm-button-class'
                        },
                        cancel: {
                            label: '<?php echo $this->lang->line('logout_confirm_button_cancel_label'); ?>'
                                    //className: 'cancel-button-class'
                        }
                    },
                    message: '<?php echo $this->lang->line('logout_confirm_message_label'); ?>',
                    callback: function (result) {
                        if (result == true) {
                            window.location = "<?php echo SITE_URL; ?>checkout";
                        }
                    },
                    title: '<?php echo $this->lang->line('logout_confirm_title_label'); ?>'
                });
            });

        </script>
        <?php if (isset($script_to_include) && strlen($script_to_include) > 0) {
            ?>
            <script src="<?php echo JS_URL . $script_to_include; ?>"></script>
            <?php
        }
        ?>
        <script>
            $(document).on('change', '.btn-file :file', function () {

                var input = $(this),
                        numFiles = input.get(0).files ? input.get(0).files.length : 1,
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            $(document).ready(function () {

                $('.btn-file :file').on('fileselect', function (event, numFiles, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                            log = numFiles > 1 ? numFiles + ' files selected' : label;

                    if (input.length) {
                        input.val(log);
                    } else {
                        if (log)
                            alert(log);
                    }

                });
            });
        </script>
        <!-- /footer content -->


        <!-- / Choosen Select  -->
        <script src="<?php echo JS_URL . "select/chosen.jquery.min.js"; ?>" type="text/javascript"></script>
        <script src="<?php echo JS_URL . "select/chosen.ajaxaddition.jquery.js"; ?>" type="text/javascript"></script>
        <script src="<?php echo JS_URL . "select/prism.js"; ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo JS_URL . "jquery.inputmask.bundle.js"; ?>"></script>
        <script src="<?php echo JS_URL . "basic.js"; ?>" type="text/javascript" charset="utf-8"></script>

        <!-----        !--->
        <link href="<?php echo ASSETS_URL; ?>dist/css/jplist.demo-pages.min.css" rel="stylesheet" type="text/css" />
        <!-- jPList core js and css  -->
        <link href="<?php echo ASSETS_URL; ?>dist/css/jplist.core.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo ASSETS_URL; ?>dist/js/jplist.core.min.js"></script>

        <!-- jplist pagination bundle -->
        <script src="<?php echo ASSETS_URL; ?>dist/js/jplist.pagination-bundle.min.js"></script>
        <link href="<?php echo ASSETS_URL; ?>dist/css/jplist.pagination-bundle.min.css" rel="stylesheet" type="text/css" />
        <!-----        !--->
        <script>
            $('document').ready(function () {

                $('#demo').jplist({
                    itemsBox: '.list'
                    , itemPath: '.list-item'
                    , panelPath: '.jplist-panel'
                    , deepLinking: true
                });
            });
        </script>

        <script type="text/javascript">
            var config = {
                '.chosen-select': {},
                '.chosen-select-mail': {width: "95%"},
                '.chosen-select-deselect': {allow_single_deselect: true},
                '.chosen-select-no-single': {disable_search_threshold: 10},
                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                '.chosen-select-width': {width: "95%"},
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

//            $(".alert-success").fadeTo(2000, 500).slideUp(800, function () {
//                $(".alert-success").alert('close');
//            });
            // $(".alert-danger").fadeTo(2000, 500).slideUp(800, function(){
            // $(".alert-danger").alert('close');
// });


        </script>

        <script type="text/javascript">
            jQuery.validator.addMethod("cke_required", function (value, element) {
                var idname = $(element).attr('id');
                var editor = CKEDITOR.instances[idname];
                $(element).val(editor.getData());
                return $(element).val().length > 0;
            }, "Message field can\'t be empty!");


            (function ($) {
                $.fn.checkFileType = function (options) {
                    var defaults = {
                        allowedExtensions: [],
                        success: function () {
                        },
                        error: function () {
                        }
                    };
                    options = $.extend(defaults, options);

                    return this.each(function (i) {

                        $(this).on('change', function () {
                            var value = $(this).val(),
                                    file = value.toLowerCase(),
                                    extension = file.substring(file.lastIndexOf('.') + 1);
                            if ($.inArray(extension, options.disallowedExtensions) == -1) {
                                if (this.files[i].size / 1024 / 1024 > 20) {
                                    options.error('Please upload file upto 20 MB.');
                                } else {
                                    options.success('Succefully uploaded file.');
                                }
                            } else {
                                options.error('Wrong file format Please select another file.');
                                $(this).focus();
                            }
                        });

                    });
                };

            })(jQuery);


            jQuery.validator.addMethod("file_check", function (value, element) {
                var options = {
                    disallowedExtensions: ["exe", "msi"]
                };
                var file = value.toLowerCase();
                var extension = file.substring(file.lastIndexOf('.') + 1);
                return ($.inArray(extension, options.disallowedExtensions) == -1);
            }, "Wrong file format Please select another file.");


            $.validator.addMethod('filesize', function (value, element, param) {
                return this.optional(element) || (((element.files[0].size / 1024) / 1024) <= param)
            }, 'File size must be less than {0}MB');


            $('.chosen-select').change(function () {
                if ($(this).val() != "") {
                    $(this).next('div').removeClass('qtip-custom qtip-shadow');
                }
                else {
                    $(this).next('div').addClass('qtip-custom qtip-shadow');
                }
            });
        </script>

        <!-- Jquery-Ui -->
        <!-- BEGIN full calendar -->
        <script src="<?php echo JS_URL . "fullcalendar/dist/fullcalendar.min.js"; ?>"></script>
        <script src="<?php echo JS_URL . "fullcalendar/dist/jquery.fullcalendar.js"; ?>"></script>
        <!-- /idle logout alert -->
        <script src="<?php echo JS_URL . 'idle/jquery.idletimer.js'; ?>" type="text/javascript"></script>
        <script src="<?php echo JS_URL . 'idle/jquery.idletimeout.js'; ?>" type="text/javascript"></script>

        <script type="text/javascript">
            //setup the dialog

            jQuery(document).ready(function () {
                $(".allow_decimal").on("input", function (evt) {
                    var self = $(this);
                    self.val(self.val().replace(/(\.\d\d)\d+|([\d.]*)[^\d.]/, '$1$2'));
                    if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
                    {
                        evt.preventDefault();
                    }
                });
                $(".decimalNumber").on("change", function (evt) {
                    var value = $(this).val();
                    if (value != "") {
                        $(this).val(parseFloat(value).toFixed(2));
                    }
                });
                //setting maxlength of 500
                $(document).ready(function () {
                    $('.carousel').carousel({
                        pause: true,
                        interval: false
                    });
                });

                //cache a reference to the countdown element so we don't have to query the DOM for it on each ping.
                var $countdown = $("#dialog-countdown");
                //start the idle timer plugin
                $.idleTimeout('#time_out', 'div.modal-dialog .modal-footer #working', {
                    idleAfter: 900, //  Seconds
                    pollingInterval: 700, // Seconds (conter)
                    keepAliveURL: '<?php echo SITE_URL; ?>email/autologin',
                    serverResponseEquals: 'OK',
                    titleMessage: 'You will be logged out in <strong>%s</strong> seconds.',
                    onTimeout: function () {
                        window.location = "<?php echo SITE_URL; ?>checkout";
                    },
                    onIdle: function () {
                        $('#time_out').modal('show');
                    },
                    onCountdown: function (counter) {
                        $countdown.html(counter); // update the counter
                    }
                });

                $(document).on('click', '#logout', function () {
                    $.idleTimeout.options.onTimeout.call(this);
                });


            });
        </script>

        <script type="text/javascript">
            $(document).ready(function (e) {
                $(".noneditable").keydown(function (e) {
                    if ((e.key).toLowerCase() == 'tab')
                        return true;
                    return false;
                });
                $(".noneditable").mousedown(function (e) {
                    return false;
                });
                $("input[type='text']").change(function (e) {
                    var val = $(this).val();
                    $(this).val($.trim(val));
                });
            });
        </script>

        <div class="modal fade" id="time_out"  data-keyboard="false" data-backdrop="static"  role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true"  >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <i class="fa fa-warning pull-left view_warning"  style="color:#ff0000 !important;"></i>
                        <h2 class="view_warning-head">Your session is about to expire!</h2>
                        <h5>
                            <div id="dialog-countdown"></div>
                        </h5>
                        <h5> Do you want to stay signed in?  </h5>
                    </div>
                    <div class="modal-footer">
                        <button  class="btn btn-primary" data-dismiss="modal"  id="working" type="button">Yes, keep me signed in</button>
                        <button class="btn btn-default" id="logout" type="button">No, Sign me out</button>
                    </div>
                </div>
            </div>
        </div>


    </body>
</html>