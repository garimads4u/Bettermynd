$(document).ready(function () {


    $.validator.setDefaults({ignore: ":hidden:not(.chosen-select)"});

    $("#step-1").validate({
        rules: {
            template_type: {
                required: true,
//				number:true
            },
            "groups[]": {
                required: true,
            },
            title: {
                required: {
                    depends: function () {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                minlength: 4,
                maxlength: 50,
                remote: {
                    url: SITE_URL + "template/check_template_title/" + ($("input[name='template_id']").val() != "" ? $("input[name='template_id']").val() : '0'),
                    type: "POST",
                    data:
                            {
                                companyid: function ()
                                {
                                    return $('#step-1 :input[name="c_compnay_id"]').val();
                                },
                                template_type: function ()
                                {
                                    return $('#step-1 #templatetype').val();
                                }
                            }
                }
            }

        },
        messages: {
            "groups[]": {required: "Please select a group to continue."},
            title: {required: "Please enter template title to continue.",
                maxlength: "Please enter 50 character only.",
                remote: "Template with this name is already exist."
            },
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
                if (element.attr("name") == "groups[]") {

                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "template_type") {

                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
            }
            else {

                element.qtip('destroy');
            }

        },
        submitHandler: function (form) {

            $('div').removeClass('qtip-custom qtip-shadow');
            $("#signup_btn").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.

        },
        success: "valid"
    });

    $("#save_theme_frm").validate({
        rules: {
            template_type: {
                required: true
//                number:true
            },
            title: {
                required: {
                    depends: function () {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                minlength: 4,
                maxlength: 50,
                remote: {
                    url: SITE_URL + "template/check_template_title/" + ($("input[name='template_id_edit']").val() != "" ? $("input[name='template_id_edit']").val() : '0'),
                    type: "POST",
                    data:
                            {
                                companyid: function ()
                                {
                                    return $('input[name="c_compnay_id"]').val();
                                },
                                template_type: function ()
                                {
                                    return $('#template_type').val();
                                }
                            }
                }
            },
            "groups[]": {
                required: true
            },
            template_size: {
                required: true

            },
            theme_type: {
                required: true

            }

        },
        messages: {
            "groups[]": {required: "Please select a group to continue."},
            title: {required: "Please enter template title to continue.",
                maxlength: "Please enter 50 character only.",
                remote: "Template with this name is already exist."}
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
                if (element.attr("name") == "groups[]") {

                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "template_type") {

                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "template_size") {

                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
                if (element.attr("name") == "theme_type") {

                    $(element).next('div').addClass('qtip-custom qtip-shadow');
                }
            }
            else {

                element.qtip('destroy');
            }
        },
        submitHandler: function (form) {
//            $("#signup_btn").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        },
        success: "valid"
    });
    $('.chosen-select').change(function () {
        if ($(this).val() != "") {
            $(this).next('div').removeClass('qtip-custom qtip-shadow');
        }
        else {
            $(this).next('div').addClass('qtip-custom qtip-shadow');
        }
    });
    $('.groups_dropdown').change(function () {

        if ($(this).val() != "") {
            $(this).next('div').removeClass('qtip-custom qtip-shadow');
        }
        else {
            $(this).next('div').addClass('qtip-custom qtip-shadow');
        }
    });
});
