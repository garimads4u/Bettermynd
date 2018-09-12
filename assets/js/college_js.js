$(document).on("click", ".provider_status", function (e) {
    var that = $(this);
    e.preventDefault();
    id = $(this).attr('id');
    var status = $(this).data('status');
    status = status != '' && status == '1' ? 'deactivate' : 'activate';
    u_id = $(this).val();
    bootbox.confirm({
        buttons: {
            confirm: {
                label: 'Yes, please'
                        //className: 'confirm-button-class'
            },
            cancel: {
                label: 'No, thanks'
                        //className: 'cancel-button-class'
            }
        },
        message: 'Do you really want to ' + status + ' provider profile?',
        callback: function (result) {
            if (result == true) {
                if (document.getElementById(id).checked) {
                    status = '0';
                }
                else {
                    status = '1';
                }
                $.ajax({
                    url: SITE_URL + "college/provider_update_status",
                    data: 'user_id=' + u_id + '&status=' + status,
                    type: "POST",
                    success: function (data) {
                        $('#infoMessage').html('<p class="alert alert-success text-left">Status Updated Successfully.<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
//                        $(".alert-success").fadeTo(2000, 500).slideUp(800, function () {
//                            $(".alert-success").alert('close');
//                        });
                        that.prop('checked', parseInt(status));
                        that.data('status', status);
                    },
                    error: function () {
                    }
                });
                //$('.switchery').trigger('click');

            }
        },
        title: 'Manage Provider Account Status'
    });
});
$(document).ready(function () {
// start Additional method
    $.validator.addMethod("zipcodeUS", function (value, element) {
        return this.optional(element) || /^\d{5}(?:-\d{4})?$/.test(value)
    }, "Pease enter 5 or 9 digit zip code. Eg. 12345-1234 or 12345");
    $.validator.addMethod("password_validation", function (value, element) {
        var numericReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,15}$/;
        return numericReg.test(value);
    }, "Password contains 8-15 characters at least 1 Uppercase, 1 Lowercase, 1 Digit and 1 Special Character");
    $.validator.addMethod("username_validation", function (value, element) {
        var numericReg = /^([a-zA-Z])[a-zA-z0-9\._-]{2,14}[A-Za-z0-9]$/;
        return numericReg.test(value);
    }, "Username should be between 4 to 15  alphanumeric characters.");
    $.validator.addMethod("email_valid", function (value, element) {
        if (value != "") {
            var numericReg = /^([A-Za-z]{1})([A-Za-z0-9-_.]{2,28})([A-Za-z0-9])+\@([a-zA-Z0-9]+\.)+(([a-zA-Z]{2,4}))\w?$/;
            return numericReg.test(value);
        } else {
            return true;
        }
    }, "Please Enter valid email address");
    $.validator.addMethod("text_validation", function (value, element) {
        // var numericReg = /^[A-Za-z|\'|\s]+$/;
        var numericReg = /^[A-Za-z]+$/;
        //    var numericReg = /^[a-zA-Z'.,-]{0,150}$/;
        return numericReg.test(value);
    }, "Please enter Characters only.");
    $.validator.addMethod("notNumber", function (value, element, param) {
        var reg = /^[0-9]*$/;
        if (reg.test(value)) {
            return false;
        } else {
            return true;
        }

    }, "Please enter alphanumeric characters. Only numbers are not allowed.");
    $.validator.addMethod("text_validation1", function (value, element) {
        //   var numericReg = /^[A-Za-z|\'|\s]+$/;
        if (value != "") {
            var numericReg = /^[A-Za-z]+$/;
            //    var numericReg = /^[a-zA-Z'.,-]{0,150}$/;
            return numericReg.test(value);
        }
        else {
            return true;
        }
    }, "Please enter Characters only.");
    $.validator.addMethod("text_validation_aplhanumeric", function (value, element) {
        //   var numericReg = /^[A-Za-z|\'|\s]+$/;
        if (value != "") {
            var numericReg = /^[a-zA-Z0-9\-\,\.\s]+$/;
            return numericReg.test(value);
        } else {
            return true;
        }
    }, "Please enter alphanumeric value.");
    $.validator.addMethod("special_validation", function (value, element) {
        //   var numericReg = /^[A-Za-z|\'|\s]+$/;
        if (value != "") {
            var numericReg = /^[0-9a-zA-Z\-\s]+$/;
            //    var numericReg = /^[a-zA-Z'.,-]{0,150}$/;
            return numericReg.test(value);
        }
        else {
            return true;
        }

    }, "Please enter proper phone number.");
    $.validator.addMethod("is_valid_url", function (value, element) {
        //   var numericReg = /^[A-Za-z|\'|\s]+$/;
        if (value != "") {
            return isUrlValid(value);
        } else {
            return true;
        }
    }, "Please enter valid website address.");
    $.validator.addMethod("address_field_validation", function (value, element) {
        //   var numericReg = /^[A-Za-z|\'|\s]+$/;
        if (value != "") {
            var numericReg = /^[a-zA-Z0-9\.\,\_\-\/\(\)\'\s]+$/;
            //    var numericReg = /^[a-zA-Z'.,-]{0,150}$/;
            return numericReg.test(value);
        } else {
            return true;
        }
    }, "Special characters not allowed.");
    $.validator.addMethod("text_validation_company_name", function (value, element) {
        //   var numericReg = /^[A-Za-z|\'|\s]+$/;
        if (value != "") {
            value = value.replace(/\s+/g, '');
            var numericReg = /^[a-zA-Z0-9\-\.\s]+$/;
            //    var numericReg = /^[a-zA-Z'.,-]{0,150}$/;
            return numericReg.test(value);
        } else {
            return true;
        }
    }, "Please enter alphanumeric value.");
    $.validator.addMethod("postcode", function (value, element) {
        if (value != "") {
            var numericReg = /^(?=.*\d)[a-zA-Z\d #,-]+$/;
            return numericReg.test(value);
        } else {
            return true;
        }
    }, "Zipcode contains 5-8 alpha numneric or digit only");
    $.validator.addMethod("notEqual", function (value) {
        return value !== $("#old").val();
    }, "Old password and new password must be different");
    $.validator.addMethod("numeric_validation", function (value, element) {
        var numericReg = /^[0-9\d.]+$/;
        return numericReg.test(value);
    }, "Please enter numbers only.");
    $.validator.addMethod("session_cost_validation", function (value, element) {
        value = parseFloat(value);
        if (value < 0 && value > 10000) {
            return false;
        } else {
            return true;
        }
    }, "Session Cost is invalid.");
    $.validator.addMethod("phonenumber_masking", function (value, element) {
        var numericReg = /^[0-9][0-9][0-9]-[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]$/;
        return numericReg.test(value);
    }, "Please enter valid mobile number");
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, "Large file uploaded.");
    $.validator.addMethod("maxspecialities", function (value, element) {
        $return = value.length > 5 ? false : true;
        if (!$return) {
            my = 'bottom right';
            at = 'top right';
            $(element).next('div').qtip({
                content: {
                    text: 'Specialities can not have more than 5 values.'
                },
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
            });
        } else {
            $(element).next('div').qtip('destroy');
        }
        return $return;
    }, "Specialities can not have more than 5 values.");


    $("#providerprofile_edit").validate({
        ignore: [],
        rules: {
            first_name: {
                required: true,
                rangelength: [1, 32],
                text_validation: true,
            },
            last_name: {
                required: true,
                rangelength: [1, 32],
                text_validation: true,
            },
            college_id: {
                required: true
            },
            mobile_no: {
                required: true,
                minlength: 12,
                phonenumber_masking: true
            },
            'specialities[]': {
                required: true,
                maxspecialities: true,
            },
            session_cost: {
                required: true,
                minlength: 1,
                maxlength: 7,
                min: 1,
                numeric_validation: true,
                session_cost_validation: true,
                number: true
            },
            biography: {
                required: true,
                minlength: 10,
                maxlength: 500
            },
            profile_image: {
                required: false,
                accept: "image/jpg,image/jpeg,image/png,image/gif",
                filesize: 1048576

            }
        },
        messages: {
            mobile_phone: {minlength: "Please enter 10 digit mobile number. "},
            profile_image: {
                accept: 'Only image type jpg/png/jpeg/gif is allowed',
                filesize: "Profile image must be less than 1MB"
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

                if (element.attr("name") == "specialities[]") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "profile_image") {
                    $(element).parents('.profileimageDiv').find('.noneditable').addClass('error');
                }
            } else {
                if (element.attr("name") == "profile_image") {
                    $(element).parents('.profileimageDiv').find('.noneditable').removeClass('error');
                }
                element.qtip('destroy');
            }
        },
        submitHandler: function (form) {

            form.submit();
        },
        success: "valid"
    });



    $("#change_password").validate({
        rules: {
            old: {
                required: true
            },
            new : {
                required: true,
                notEqual: true,
                password_validation: true,
            },
            new_confirm: {
                required: true,
                equalTo: "#new"
            }
        },
        messages: {
            new_confirm: {equalTo: "Password and Confirm Password doesn't match."}
        },
        errorPlacement: function (error, element) {
            var my = "";
            var at = "";
            if ($(window).width() < 800)
            {
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
                        adjust: {x: 0, y: 0}

                    },
                    style: {
                        classes: 'qtip-custom qtip-shadow',
                        tip: {
                            height: 6,
                            width: 11

                        }
                    }
                })
                qtip('option', 'content.text', error);
            }
            else {
                element.qtip('destroy');
            }
        },
        success: "valid"

    });
    $(".delete_heading").click(function (event) {

        event.preventDefault();
        var heading_id = $(this).data('id');
        bootbox.confirm({
            buttons: {
                confirm: {
                    label: 'Yes, please'
                },
                cancel: {
                    label: 'No, thanks'
                }
            },
            message: 'Do you really want to delete heading.',
            callback: function (result) {

                if (result == true) {

                    $.ajax({
                        url: SITE_URL_ROOT + "company/delete_company_heading",
                        data: 'heading_id=' + heading_id,
                        type: "POST",
                        success: function (data) {
                            window.location.href = '';
                        },
                        error: function () {
                        }
                    });
                }
            },
            title: 'Delete Company Heading'

        });
    });
    $(".delete_bullets").click(function (event) {

        event.preventDefault();
        var company_bullet_id = $(this).data('id');
        bootbox.confirm({
            buttons: {
                confirm: {
                    label: 'Yes, please'

                            //className: 'confirm-button-class'

                },
                cancel: {
                    label: 'No, thanks'

                            //className: 'cancel-button-class'

                }

            },
            message: 'Do you really want to delete bullet.',
            callback: function (result) {

                if (result == true) {

                    $.ajax({
                        url: SITE_URL_ROOT + "company/delete_company_bullet",
                        data: 'company_bullet_id=' + company_bullet_id,
                        type: "POST",
                        success: function (data) {

                            window.location.href = '';
                        },
                        error: function () {

                        }

                    });
                }

            },
            title: 'Delete Company Bullet'

        });
    });
    $(".delete_features").click(function (event) {

        event.preventDefault();
        var feature_id = $(this).data('id');
        bootbox.confirm({
            buttons: {
                confirm: {
                    label: 'Yes, please'

                            //className: 'confirm-button-class'

                },
                cancel: {
                    label: 'No, thanks'

                            //className: 'cancel-button-class'

                }

            },
            message: 'Do you really want to delete feature information.',
            callback: function (result) {

                if (result == true) {

                    $.ajax({
                        url: SITE_URL_ROOT + "company/delete_company_feature",
                        data: 'feature_id=' + feature_id,
                        type: "POST",
                        success: function (data) {

                            window.location.href = '';
                        },
                        error: function () {

                        }

                    });
                }

            },
            title: 'Delete Company Features Information'

        });
    });
    $(".changepassword").click(function (event) {

        var uid = $(this).data('id');
        var user_email = $(this).data('email');
        bootbox.confirm({
            buttons: {
                confirm: {
                    label: 'Yes, please'

                            //className: 'confirm-button-class'

                },
                cancel: {
                    label: 'No, thanks'

                            //className: 'cancel-button-class'

                }

            },
            message: 'Do you want to send change password request on <a href="javascript:void(0)">' + user_email + '</a>',
            callback: function (result) {

                if (result == true) {

                    $.ajax({
                        url: SITE_URL_ROOT + "sadmin/change_password_request",
                        data: 'user_id=' + uid,
                        type: "POST",
                        success: function (data) {
                            if (data == '1') {
                                $('#infoMessage').html('');
                                $('#infoMessage').html('<p class="alert alert-danger text-left">Email id not found in our database! Try again later.</p>');
                            } else if (data == '2') {
                                $('#infoMessage').html('');
                                $('#infoMessage').html('<p class="alert alert-success text-left">We have sent an email to registered e-mail address of company regarding instructions for changing password.</p>');
                            } else {
                                $('#infoMessage').html('');
                                $('#infoMessage').html('<p class="alert alert-danger text-left">Error! Try again later.</p>');
                            }

                        },
                        error: function () {

                        }

                    });
                }
            },
            title: 'Password Change Request'
        });
    });
    var u_id = '';
    var id = '';
    $(document).on("click", ".user_status", function (e) {

        e.preventDefault();
        id = $(this).attr('id');
        var pass = $(this).data("password");
        if (pass == "no") {
            bootbox.alert({
                message: "User still not logged in yet",
                callback: function () { /* your callback code */
                },
                title: 'Manage Company Account Status'
            });
            return;
        }
        var status = $(this).data('status');
        status = status != '' && status == '1' ? 'deactivate' : 'activate';
        u_id = $(this).val();
        bootbox.confirm({
            buttons: {
                confirm: {
                    label: 'Yes, please'

                            //className: 'confirm-button-class'

                },
                cancel: {
                    label: 'No, thanks'

                            //className: 'cancel-button-class'

                }

            },
            message: 'Do you really want to ' + status + ' user profile?',
            callback: function (result) {

                if (result == true) {

                    if (document.getElementById(id).checked) {

                        status = '0';
                    }

                    else {

                        status = '1';
                    }

                    $.ajax({
                        url: SITE_URL_ROOT + "company/update_status",
                        data: 'user_id=' + u_id + '&status=' + status,
                        type: "POST",
                        success: function (data) {



                            window.location.href = "";
                        },
                        error: function () {

                        }

                    });
                    //$('.switchery').trigger('click');



                }

            },
            title: 'Manage Company Account Status'

        });
    });
    $("#add_user").validate({
        ignore: [],
        rules: {
            username: {
                required: true,
                username_validation: true,
                notNumber: true,
                minlength: 3,
                maxlength: 15,
                remote: {
                    url: SITE_URL_ROOT + "username_availablity",
                    type: "POST",
                    data:
                            {
                                username: function ()

                                {

                                    return $('#add_user :input[name="username"]').val();
                                }

                            }

                }



            },
            first_name: {
                required: {
                    depends: function () {

                        if ($('input[value="company"]:checked').val() == 'company')
                            return true;
                    }

                },
                rangelength: [1, 32],
                text_validation1: true

            },
            last_name: {
                required: {
                    depends: function () {

                        if ($('input[value="company"]:checked').val() == 'company')
                            return true;
                    }

                },
                rangelength: [1, 32],
                text_validation1: true

            },
            user_email: {
                required: true,
                email_valid: true

            },
            account_holder_name: {
                required: true,
                minlength: 5,
                text_validation: true

            },
            card_number: {
                required: {
                    depends: function () {

                        if ($('input[value="company"]:checked').val() == 'company')
                            return true;
                    }

                },
                creditcard: true,
                minlength: 13,
                maxlength: 25

            },
            expiration_date: {
                required: {
                    depends: function () {

                        if ($('input[value="company"]:checked').val() == 'company')
                            return true;
                    }

                },
                minlength: 9

            },
            cvv_code: {
                required: {
                    depends: function () {

                        if ($('input[value="company"]:checked').val() == 'company')
                            return true;
                    }

                }



            },
            address: {
                required: {
                    depends: function () {

                        if ($('input[value="company"]:checked').val() == 'company')
                            return true;
                    }

                }

            },
            zip_code: {
                required: {
                    depends: function () {

                        if ($('input[value="company"]:checked').val() == 'company')
                            return true;
                    }

                }



            },
            level: {
                required: true

            }



        },
        messages: {
            username: {remote: "{0} is already in use."},
            expiration_date: {minlength: "Expiration date must be in MM/YYYY format."},
            zip_code: {rangelength: "Zipcode contains 5-8 alpha numneric or digit only."}

        },
//        errorPlacement: function (label, element) {

//            if (element.attr("name") == "terms_checked") {

//                $('<span class="error"></span>').insertAfter('.terms').append(label)

//            } else {

//                $('<span class="arrow"></span>').insertBefore(element);

//                $('<span class="error"></span>').insertAfter(element).append(label)

//            }

//

//        },

        errorPlacement: function (error, element) {



            var my = "";
            var at = "";
            if (element.attr("name") == "level") {

                $(element).next('div').addClass('qtip-custom qtip-shadow');
            }



            if ($(window).width() < 800)

            {

                my = 'bottom right';
                at = 'top right';
            }

            else

            {

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
                        adjust: {x: 0, y: 0}

                    },
                    style: {
                        classes: 'qtip-custom qtip-shadow',
                        tip: {
                            height: 6,
                            width: 11

                        }

                    }

                })

                        .qtip('option', 'content.text', error);
            }

            else {

                element.qtip('destroy');
            }



        },
        submitHandler: function (form) {
            $('.chosen-container').removeClass('qtip-custom');
            $("#signup_btn").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.

        },
        success: "valid"

    });
    $("#group_form").validate({
        rules: {
            groupname: {
                required: true,
                minlength: 3,
                maxlength: 80

            },
        },
        messages: {
            groupname: {required: "Group name must be entered."},
        },
        success: "valid"

    });
    $("#collegeupdateform").validate({
        rules: {
            first_name: {
                required: true,
                rangelength: [1, 32],
                text_validation: true,
            },
            last_name: {
                required: true,
                rangelength: [1, 32],
                text_validation: true,
            },
            college_name: {
                required: true,
                minlength: 3
            },
            college_address: {
                required: true,
                address_field_validation: true,
                minlength: 2
            },
            college_state: {
                required: true,
            },
            college_city: {
                required: true,
                //minlength: 3
            },
            college_office_no: {
                required: true,
            },
            college_zipcode: {
                required: true,
                zipcodeUS: true,
                minlength: 5
            },
            profile_image: {
                required: false,
                accept: "image/jpg,image/jpeg,image/png,image/gif",
                filesize: 1048576 * 2

            },
            timezone: {
                required: true,
            },
        },
        messages: {
            profile_image: {
                accept: 'Only image type jpg/png/jpeg/gif is allowed',
                filesize: "Profile image must be less than 2MB"
            }
        },
        errorPlacement: function (error, element) {
            var my = "";
            var at = "";
            if ($(window).width() < 800)
            {
                my = 'bottom right';
                at = 'top right';
            }
            else
            {
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
                        adjust: {x: 0, y: 0}
                    },
                    style: {
                        classes: 'qtip-custom qtip-shadow',
                        tip: {
                            height: 6,
                            width: 11
                        }
                    }
                }).qtip('option', 'content.text', error);
                if (element.attr("name") == "profile_image") {
                    $(element).parents('.profileimageDiv').find('.noneditable').addClass('error');
                }
            }
            else {
                if (element.attr("name") == "profile_image") {
                    $(element).parents('.profileimageDiv').find('.noneditable').removeClass('error');
                }
                element.qtip('destroy');
            }
        },
        success: "valid"
    });
});


