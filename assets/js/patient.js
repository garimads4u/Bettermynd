$(function () {
    $('.datetimepicker').datetimepicker({
        format: 'MM/DD/YYYY',
        maxDate: 'now',
        minDate: '1900-01-01'

    });
    $(".mobilemark").inputmask("999-999-9999", {"placeholder": "___-___-____"});
});
$(document).ready(function () {
    $.validator.setDefaults({ignore: ":hidden:not(.chosen-select)"});
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
        var numericReg = /^([A-Za-z]{1})([A-Za-z0-9-_.]{2,100})([A-Za-z0-9])+\@([a-zA-Z0-9]+\.)+(([a-zA-Z]{2,4}))\w?$/;
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
    $.validator.addMethod("text_numeric_validation", function (value, element) {
        var numericReg = /^[A-Za-z0-9_-]+$/;
        return numericReg.test(value);
    }, "Please enter Characters , numeric and special character (-,_)allowed.");
    $.validator.addMethod("phonenumber_masking", function (value, element) {
        var numericReg = /^[0-9][0-9][0-9]-[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]$/;
        return numericReg.test(value);
    }, "Please enter valid mobile number");
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, "Large file uploaded.");
    //provider update validation
    $("#updatePatientProfile").validate({
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
                required: true,
            },
            patient_identification_number: {
                required: true,
                text_numeric_validation: true
            },
            dob: {
                required: true
            },
            address: {
                required: true
            },
            city: {
                required: true
            },
            state: {
                required: true
            },
            timezone: {
                required: true
            },
            gender: {
                required: true
            },
            zipcode: {
                required: true,
                minlength: 5,
                zipcodeUS: true
            },
            ethnicity: {
                required: true,
            },
            mobile_no: {
                required: true,
                minlength: 12,
                phonenumber_masking: true
            },
            profile_image: {
                required: false,
                accept: "image/jpg,image/jpeg,image/png,image/gif",
                filesize: 1048576 * 2

            },
            is_international: {
                required: true
            },
            athlete: {
                required: true
            },
            class_year: {
                required: true
            }
        },
        messages: {
            mobile_phone: {
                minlength: "Please enter 10 digit mobile number. ",
            },
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
                if (element.attr("name") == "timezone") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "state") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
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
    $("#paymentform").validate({
        rules: {
            card_number: {
                required: true,
                creditcard: true,
                minlength: 13,
                maxlength: 25
            },
            expiration_date: {
                required: true,
                minlength: 9
            },
            cvv_code: {
                required: true
            },
            address: {
                required: true
            },
            zip_code: {
                required: true,
                rangelength: [5, 8],
                postcode: true
            }
        },
        messages: {
            expiration_date: {
                minlength: "Expiration date must be in MM/YYYY format."
            },
            zip_code: {
                rangelength: "Zipcode contains 5-8 alpha numneric or digit only."
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
        submitHandler: function (form) {
            $("#signup_btn").attr("disabled", true);
            $('#loading_image').removeClass('hide').addClass('show');
            exp = $('#expiration_date').val();
            exp = exp.split('/');
            Stripe.card.createToken({
                number: $('#card_number').val(),
                cvc: $('#cvv_code').val(),
                exp_month: $.trim(exp[0]),
                exp_year: $.trim(exp[1]),
                name: $('#first_name').val() + ' ' + $('#last_name').val(),
                address_line1: $('#address').val(),
                address_city: 'test',
                address_zip: $('#zip_code').val(),
                // address_state: $('.state').val(),
                // address_country: $('.country').val()
            }, stripeResponseHandler);
            return false;
        },
        success: "valid"
    });
});