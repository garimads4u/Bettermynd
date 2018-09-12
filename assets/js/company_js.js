function isUrlValid(url) {
    return /^(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}
// JavaScript Document
function view_invoice(transaction_id) {
    if (window.XMLHttpRequest) {

        // code for IE7+, Firefox, Chrome, Opera, Safari

        xmlhttp = new XMLHttpRequest();

    } else {

        // code for IE6, IE5

        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    }

    xmlhttp.onreadystatechange = function () {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            document.getElementById("invoice_body").innerHTML = xmlhttp.responseText;

        }

    };

    var invoice_url = SITE_URL_ROOT + "company/get_invoice/" + transaction_id;
    xmlhttp.open("GET", invoice_url, true);

    xmlhttp.send();



}

$(document).ready(function () {

    // start Additional method

    $.validator.addMethod("password_validation", function (value, element) {



        var numericReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,15}$/;

        return numericReg.test(value);

    }, "Password contains 8-15 characters at least 1 Uppercase, 1 Lowercase, 1 Digit and 1 Special Character");



    $.validator.addMethod("username_validation", function (value, element) {

        // var numericReg = /^[A-Za-z0-9|\.\_\-]{4,15}$/;

        //  var numericReg = /^[A-Za-z0-9|\.\_\-]{4,15}$/;

//        var numericReg = /^([a-zA-Z])[a-zA-z0-9\._-]{3,15}[A-Za-z0-9]$/;

        var numericReg = /^([a-zA-Z])[a-zA-z0-9\._-]{2,14}[A-Za-z0-9]$/;

        // var numericReg = /^[A-Za-z]+$/;

        //    var numericReg = /^[a-zA-Z'.,-]{0,150}$/;

        return numericReg.test(value);



    }, "Username should be between 4 to 15  alphanumeric characters.");



    $.validator.addMethod("email_valid", function (value, element) {

        if (value != "") {

//            var numericReg = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var numericReg = /^([A-Za-z]{1})([A-Za-z0-9-_.]{2,28})([A-Za-z0-9])+\@([a-zA-Z0-9]+\.)+(([a-zA-Z]{2,4}))\w?$/;

            return numericReg.test(value);

        }

        else {

            return true;

        }

    }, "Please Enter valid email address");



    $.validator.addMethod("text_validation", function (value, element) {

        //   var numericReg = /^[A-Za-z|\'|\s]+$/;

        if (value != "") {
            value = value.replace(/\s+/g, '');
            var numericReg = /^[A-Za-z ]+$/;

            //    var numericReg = /^[a-zA-Z'.,-]{0,150}$/;

            return numericReg.test(value);

        }

        else {

            return true;

        }



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

            //    var numericReg = /^[a-zA-Z'.,-]{0,150}$/;

            return numericReg.test(value);

        }

        else {

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

        }

        else {

            return true;

        }



    }, "Please enter valid website address.");
	

    $.validator.addMethod("address_field_validation", function (value, element) {

        //   var numericReg = /^[A-Za-z|\'|\s]+$/;

        if (value != "") {

            var numericReg = /^[a-zA-Z0-9\.\,\_\-\/\(\)\'\s]+$/;

            //    var numericReg = /^[a-zA-Z'.,-]{0,150}$/;

            return numericReg.test(value);

        }

        else {

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
        }
        else {
            return true;
        }

    }, "Please enter alphanumeric value.");



    $.validator.addMethod("postcode", function (value, element) {
        if (value != "") {
            var numericReg = /^(?=.*\d)[a-zA-Z\d #,-]+$/;

            return numericReg.test(value);
        }
        else {
            return true;
        }

    }, "Zipcode contains 5-8 alpha numneric or digit only");



    $.validator.addMethod("notEqual", function (value) {

        return value !== $("#old").val();

    }, "Old password and new password must be different");



//    $.validator.addMethod("heading_title", function(value, element) {

//        console.log();

//	 if($(element).parent().next('div').find('.sub').val()!="")

//             return false;

//         else

//             return true;

//	}, "Please select both the item and its amount.");



//        $.validator.addMethod("heading_title1", function(value, element) {

//        console.log($(element).data('subhead'));

//        var el = $(element).data('subhead');

//        if($('#'+el).val().length > 0) {

//            return false;

//        }

//        else {

//            return true;

//        }

//	 if($(element).parent().next('div').find('.sub').val()!="")

//             return false;

//         else

//             return true;

//	}, "Please select both the item and its amount.");



    $("#profile_frm").validate({
        rules: {
            user_email: {
                required: true,
                email_valid: true

            },
            office_phone: {
                minlength: 10,
                maxlength: 16,
                digits: true



            },
            account_holder_name: {
                required: true,
                minlength: 5,
                text_validation: true

            },
            mobile_phone: {
                minlength: 16

            },
            zipcode: {
                postcode: true,
                rangelength: [5, 8]

            },
            website: {
                url: true

            },
            fax_number: {
                minlength: 10,
                maxlength: 16,
                digits: true

            },
            fb_url: {
                url: true,
                fburl: true

            },
            twitter_url: {
                url: true,
                twitterurl: true

            },
            linkedin_url: {
                url: true

            },
            youtube_url: {
                url: true

            },
            address: {
                minlength: 6,
                address_field_validation: true

            }

        },
        messages: {
            website: {url: "Please enter Website in correct format(using http://, https://) "},
            fb_url: {url: "Please enter Website in correct format(using http://, https://) "},
            twitter_url: {url: "Please enter Website in correct format(using http://, https://) "},
            linkedin_url: {url: "Please enter Website in correct format(using http://, https://) "},
            youtube_url: {url: "Please enter Website in correct format(using http://, https://) "},
            mobile_phone: {minlength: "Please enter 10 digit mobile number. "},
            zipcode: {rangelength: "Zipcode contains 5-8 alpha numneric or digit only."},
            office_phone: {minlength: "Please enter 10 digit mobile number."},
            fax_number: {minlength: "Please enter 10 digit mobile number."}

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



    $('#biography').on('keyup', function () {

        var char = $(this).val();

        if (char.length >= 0) {

            var c = 500 - char.length;

            $('#charCount').text(c);



        }

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



    $("#company_profile").validate({
        rules: {
            company_name: {
                minlength: 5,
                text_validation_company_name: true

            },
            company_general_email: {
                email_valid: true

            },
            company_support_email: {
                email_valid: true

            },
            office_phone: {
                minlength: 10,
                maxlength: 16,
                special_validation:true

            },
            office_phone2: {
                minlength: 10,
                maxlength: 16,
                special_validation:true				
                

            },
            primary_account_holder: {
                minlength: 5,
                text_validation: true

            },
            company_address: {
                minlength: 6,
                address_field_validation: true

            },
            company_zipcode: {
                postcode: true,
                rangelength: [5, 8]

            },
            company_website: {
                is_valid_url: true

            },
            company_fax_number: {
                minlength: 10,
                maxlength: 16,
                digits: true

            },
            company_fb_url: {
                url: true,
                fburl: true

            },
            company_twitter_url: {
                url: true,
                twitterurl: true

            },
            company_linkedin_url: {
                url: true

            },
            company_youtube_url: {
                url: true

            },
            "heading_title[]": {
                //text_validation_aplhanumeric: true

            },
            "heading_subtitle[]": {
                //text_validation_aplhanumeric: true

            },
            "bullet_detail[]": {
                //text_validation_aplhanumeric: true

            },
            "feature_title[]": {
                //text_validation_aplhanumeric: true

            }



        },
        messages: {
            company_website: {url: "Please enter Website in correct format(using http://, https://) "},
            company_fb_url: {url: "Please enter Website in correct format(using http://, https://) "},
            company_twitter_url: {url: "Please enter Website in correct format(using http://, https://) "},
            company_linkedin_url: {url: "Please enter Website in correct format(using http://, https://) "},
            company_youtube_url: {url: "Please enter Website in correct format(using http://, https://) "},
            mobile_phone: {minlength: "Please enter 10 digit mobile number. "},
            zipcode: {rangelength: "Zipcode contains 5-8 alpha numneric or digit only."}



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

    $('#biography').on('keypress', function () {

        var char = $(this).val();

        if (char.length >= 0) {

            var c = 500 - char.length;

            $('#charCount').text(c);



        }

    });

    $(".delete_heading").click(function (event) {

        event.preventDefault();

        var heading_id = $(this).data('id');

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
                rangelength: [3, 32],
                text_validation1: true

            },
            last_name: {
                required: {
                    depends: function () {

                        if ($('input[value="company"]:checked').val() == 'company')
                            return true;

                    }

                },
                rangelength: [3, 32],
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



});



$(document).on("click", ".group_status", function (e) {

    e.preventDefault();

    id = $(this).attr('id');

    var status = $(this).data('status');

    status = status != '' && status == '1' ? 'activate' : 'deactivate';

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
        message: 'Do you really want to ' + status + ' this group?',
        callback: function (result) {

            if (result == true) {

                if (document.getElementById(id).checked) {

                    status = '0';

                }

                else {

                    status = '1';

                }



                $.ajax({
                    url: SITE_URL_ROOT + "company/update_group/" + u_id + "/" + status,
                    data: 'group_id=' + u_id + '&status=' + status,
                    type: "POST",
                    success: function (data) {



                        window.location.href = SITE_URL_ROOT + "company/groups";

                    },
                    error: function () {

                    }

                });

                //$('.switchery').trigger('click');



            }

        },
        title: 'Manage Group Status'

    });

});