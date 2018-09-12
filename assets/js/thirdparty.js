$(function () {
    $('.datetimepicker').datetimepicker({
        format: 'MM/DD/YYYY',
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
        var numericReg = /^[0-9\.]+$/;
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
    $.validator.addMethod("notEqual", function (value) {
        return value !== $("#old").val();
    }, "Old password and new password must be different");
    $.validator.addMethod("certificate", function (value, element, param) {
        var c = $(element).parent('div').siblings('div').find('.noneditable');
        var $return = true;
        if (c.val() != "") {
            if (value == "") {
                $return = false;
            }
        }
        return $return;
    }, "Please enter document name");
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

    $.validator.addMethod("valid_certifications", function (value, element) {
        $return = true;
        if ($(element).val()) {
            var ext = $(element).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'doc', 'docx', 'pdf']) == -1) {
                $return = false;
            } else {
                $return = true;
            }
        }
        return $return;
    }, "Accept extension only JPG/PNG/JPEG/DOC/PDF type format");

    $.validator.addClassRules("certificateRequire", {
        certificate: true,
        minlength: 3,
        maxlength: 32
    });
    $.validator.addClassRules("malCertificateRequire", {
        certificate: true,
        minlength: 3,
        maxlength: 32
    });
    //provider update validation
    $("#thirdpartyprofileform").validate({
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
            mobile_no: {
                required: true,
                minlength: 12,
                phonenumber_masking: true
            },
            zipcode: {
                required: true,
                zipcodeUS: true,
                minlength: 5
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
                maxlength: 3000
            },
            profile_image_txt: {
                required: true,
            },
            profile_image: {
                required: {
                    depends: function (element) {
                        if ($('#profile_image_txt').val() <= 0) {
                            return true;
                        }
                        return false;
                    }
                },
                accept: "image/jpg,image/jpeg,image/png,image/gif",
                filesize: 1048576 * 2
            },
            address: {
                required: true
            },
            city: {
                required: true
            },
            'specialities[]': {
                required: true,
                maxspecialities: true,
            },
            'insurance_carriers[]': {
                required: true,
            },
            photo_id_txt: {
                required: true,
            },
            photo_id: {
                required: {
                    depends: function (element) {
                        if ($('#photo_id_txt').val() <= 0) {
                            return true;
                        }
                        return false;
                    }
                },
                accept: "image/jpg,image/jpeg,image/png,image/gif",
                filesize: 1048576 * 2
            },
            'document_name[]': {
                required: {
                    depends: function (element) {
                        if ($('#count_insurance_certificate').val() <= 0) {
                            return true;
                        }
                        return $(element).closest('div.row').find('.certificateRequire').val();
                    }
                },
            },
            "counseling_certifications[]": {
                required: {
                    depends: function (element) {
                        if ($('#count_insurance_certificate').val() <= 0) {
                            return true;
                        }
                        return $(element).closest('div.row').find('.certificateRequire').val();
                    }
                },
//                accept: "jpg|jpeg|pdf|doc|docx|png",
                // accept: "image/jpg,image/jpeg,image/png,pdf,docx,doc",
                valid_certifications: true,
                filesize: 1048576 * 2
            },
            'malpractice_document_name[]': {
                required: {
                    depends: function (element) {
                        if ($('#count_malpractice_certificate').val() <= 0) {
                            return true;
                        }
                        return $(element).closest('div.row').find('.malCertificateRequire').val();
                    }
                },
            },
            "malpractice_certifications[]": {
                required: {
                    depends: function (element) {
                        if ($('#count_malpractice_certificate').val() <= 0) {
                            return true;
                        }
                        return $(element).closest('div.row').find('.malCertificateRequire').val();
                    }
                },
//                accept: "jpg|jpeg|pdf|doc|docx|png",
                //accept: "image/jpg,image/jpeg,image/png,pdf,docx,doc",
                valid_certifications: true,
                filesize: 1048576 * 2
            }
        },
        messages: {
            mobile_phone: {minlength: "Please enter 10 digit mobile number. "},
            profile_image: {
                accept: 'Only image type jpg/png/jpeg/gif is allowed',
                filesize: "Profile image must be less than 2MB"
            },
            photo_id: {
                accept: 'Only image type jpg/png/jpeg/gif is allowed',
                filesize: "photo ID must be less than 2MB"
            },
            "counseling_certifications[]": {
                //accept: 'Accept extension only JPG/PNG/JPEG/DOC/PDF type format',
                filesize: "Profile image must be less than 2MB"
            },
            "malpractice_certifications[]": {
                //accept: 'Accept extension only JPG/PNG/JPEG/DOC/PDF type format',
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
                if (element.attr("name") == "specialities[]") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "insurance_carriers[]") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "profile_image") {
                    $(element).parents('.profileimageDiv').find('.noneditable').addClass('error');
                }
                if (element.attr("name") == "photo_id") {
                    $(element).parents('.profileimageDiv').find('.noneditable').addClass('error');
                }
                if (element.attr("name") == "counseling_certifications[]") {
                    $(element).parents('.counsellingDiv').find('.noneditable').addClass('error');
                }
                if (element.attr("name") == "malpractice_certifications[]") {
                    $(element).parents('.malpracticeDiv').find('.noneditable').addClass('error');
                }
                if (element.attr("name") == "timezone") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "document_name[]") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "malpractice_document_name[]") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "photo_id_txt") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "city") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "address") {
                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
            } else {
                if (element.attr("name") == "malpractice_certifications[]") {
                    $(element).parents('.malpracticeDiv').find('.noneditable').removeClass('error');
                }
                if (element.attr("name") == "counseling_certifications[]") {

                    $(element).parents('.counsellingDiv').find('.noneditable').removeClass('error');
                }
                if (element.attr("name") == "profile_image") {
                    $(element).parents('.profileimageDiv').find('.noneditable').removeClass('error');
                }
                if (element.attr("name") == "photo_id") {
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
    // change password form validation
    $("#user_change_password").validate({
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