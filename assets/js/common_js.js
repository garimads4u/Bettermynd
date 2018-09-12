$(function () {
    $(".mobilemark").inputmask("999-999-9999", {"placeholder": "___-___-____"});

});
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
$(document).ready(function () {
    $.validator.addMethod("zipcodeUS", function (value, element) {
        return this.optional(element) || /^\d{5}(?:-\d{4})?$/.test(value)
    }, "Pease enter 5 or 9 digit zip code. Eg. 12345-1234 or 12345");
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, "Large file uploaded.");
    $.validator.addMethod("password_validation", function (value, element) {
        var numericReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,15}$/;
        return numericReg.test(value);
    }, "Password contains 8-15 characters at least 1 Uppercase, 1 Lowercase, 1 Digit and 1 Special Character");
    $.validator.addMethod("username_validation", function (value, element) {
        var numericReg = /^([a-zA-Z])[a-zA-z0-9\._-]{2,14}[A-Za-z0-9]$/;
        return numericReg.test(value);
    }, "Username should be between 4 to 15  alphanumeric characters.");
    $.validator.addMethod("email_valid", function (value, element) {
        var numericReg = /^([A-Za-z]{1})([A-Za-z0-9-_.]{1,100})([A-Za-z0-9])+\@([a-zA-Z0-9]+\.)+(([a-zA-Z]{2,4}))\w?$/;
        return numericReg.test(value);
    }, "Please Enter valid email address");
    $.validator.addMethod("text_validation", function (value, element) {
        var numericReg = /^[A-Za-z]+$/;
        return numericReg.test(value);
    }, "Please enter Characters only.");
    $.validator.addMethod("postcode", function (value, element) {
        var numericReg = /^(?=.*\d)[a-zA-Z\d #,-]+$/;
        return numericReg.test(value);
    }, "Postcode contains 6-8 alpha numneric or digit only");

    $.validator.addMethod("numeric_validation", function (value, element) {
        var numericReg = /^[0-9]+$/;
        return numericReg.test(value);
    }, "Please enter numbers only.");

    $.validator.addMethod("phonenumber_masking", function (value, element) {
        var numericReg = /^[0-9][0-9][0-9]-[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]$/;
        return numericReg.test(value);
    }, "Please enter valid mobile number");


    $.validator.addMethod("notFutureDate", function (value, element) {
        var idate = value;
        dateReg = /(0[1-9]|1[012])[\/](0[1-9]|[12][0-9]|3[01])[\/]19[0-9][0-9]|20[0-9][0-9]/;
        if (dateReg.test(idate)) {
            if (isFutureDate(idate)) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }, function (params, element) {
        return 'Entered date is future date';
    });

    $.validator.addClassRules("maskFutureDate", {
        notFutureDate: true
    });





    $("#loginform").validate({
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
    });

    $("#signupform").validate({
        rules: {
            email: {
                required: true,
                email_valid: true
            },
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
//            patient_id: {
//                required: true
//            },
            dob: {
                required: true
            },
//            mobile_no: {
//                required: true,
//                minlength: 12,
//                phonenumber_masking: true
//            },
            terms_checked: {
                required: true,
                min: 1
            },
        },
        messages: {
            email: {
                remote: "{0} is already in use."
            },
            terms_checked: "Please accept terms and conditions ",
            //mobile_phone: {minlength: "Please enter 10 digit mobile number. "},
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
        /*submitHandler: function (form) {
            form.submit();
        },*/
        success: "valid"
    });


    $('.btn-apply').on('click', function () {
        $(this).fadeOut(function () {
            $('.apply').fadeIn();
        });
    });

    $("#forgotform").validate({
        rules: {
            identity: {
                required: true,
                email: true
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
    });

    $("#reset_form").validate({
        rules: {
            new : {
                required: true,
                password_validation: true
            },
            new_confirm: {
                required: true,
                equalTo: "#new",
                password_validation: true
            }
        },
        messages: {
            new_confirm: {
                equalTo: "New Password and Confirm New Password should be same.",
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
    });

    $('#signup_btn').prop('disabled', false);

    //provider signup validation
    $("#providersignupform").validate({
        rules: {
            user_email: {
                required: true,
                email_valid: true,
            },
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
            terms_checked: {
                required: true,
                min: 1
            },
            profile_image_txt: {
                required: true
            },
            profile_image: {
                required: false,
                accept: "image/jpg,image/jpeg,image/png,image/gif",
                filesize: 1048576 * 2
            }
//            terms_checked: {
//                required: function(elem){
//                    return $("input.terms_checked:checked").length > 0;
//                }
//            }

        },
        messages: {
            user_email: {
                remote: "{0} is already in use."
            },
            terms_checked: "Please accept terms and conditions ",
            /* password_confirm: {
             equalTo: "Password and Confirm Password doesn't match."
             },*/
            mobile_phone: {minlength: "Please enter 10 digit mobile number. "},
            profile_image: {
                accept: 'Only image type jpg/png/jpeg/gif is allowed',
                filesize: "Profile image must be less than 2MB"
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
        /*submitHandler: function (form) {

            form.submit();
        },*/
        success: "valid"
    });


    //third party signup form validation
    $("#thirtpartysignupform").validate({
        rules: {
            /* password: {
             required: true,
             password_validation: true
             },
             password_confirm: {
             required: true,
             equalTo: "#password"
             }, */
            user_email: {
                required: true,
                email_valid: true,
            },
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
            city: {
                required: true,
                // rangelength: [2, 25],
            },
            state: {
                required: true
            },
            zipcode: {
                required: true,
                zipcodeUS: true,
                minlength: 5
            },
            address: {
                required: true,
                rangelength: [5, 150],
            },
            mobile_no: {
                required: true,
                minlength: 12,
                phonenumber_masking: true
            },
            terms_checked: {
                required: true,
                min: 1
            },
            profile_image_txt: {
                required: true
            },
            profile_image: {
                required: false,
                accept: "image/jpg,image/jpeg,image/png,image/gif",
                filesize: 1048576 * 2
            }
//            terms_checked: {
//                required: function(elem){
//                    return $("input.terms_checked:checked").length > 0;
//                }
//            }

        },
        messages: {
            user_email: {
                remote: "{0} is already in use."
            },
            terms_checked: "Please accept terms and conditions ",
            /* password_confirm: {
             equalTo: "Password and Confirm Password doesn't match."
             },*/
            mobile_phone: {minlength: "Please enter 10 digit mobile number. "},
            profile_image: {
                accept: 'Only image type jpg/png/jpeg/gif is allowed',
                filesize: "Profile image must be less than 2MB"
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
        /*submitHandler: function (form) {

            form.submit();
        },*/
        success: "valid"
    });


    $("#collegesignupform").validate({
        rules: {
            user_email: {
                required: true,
                email_valid: true,
            },
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
                rangelength: [5, 150]
            },
            college_state: {
                required: true,
            },
            college_city: {
                required: true,
                minlength: 3
            },
            college_office_no: {
                required: true,
                phonenumber_masking: true
            },
            college_zipcode: {
                required: true,
                zipcodeUS: true,
                minlength: 5
            },
            terms_checked: {
                required: true
            },
        },
        messages: {
            terms_checked: "Please accept terms and conditions ",
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
                })
                        .qtip('option', 'content.text', error);
            }
            else {
                element.qtip('destroy');
            }
        },
        success: "valid"
    });



});