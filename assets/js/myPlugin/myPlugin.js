(function ($) {
    jQuery.loadScript = function (url, callback) {
        jQuery.ajax({
            url: url,
            dataType: 'script',
            success: callback,
            async: true
        });
    }
    //-------------------------------------------------------------------------------------------
    //settings plugin
    function change_value(value) {
        document.getElementById("ds_defaultcontent").value = value;
        $("#ds_defaultcontent").change().keyup();
    }
    $.fn.dssettings = function (options) {
        //default options.

        var settings = $.extend({
            dsmaxwidth: 200,
            dsmaxheight: 30,
            dsmaxchars: 100,
            dsdefaultcontent: '',
            element_type: this.data('element_type'),
            dsusereditable: false,
            dsscalefont: false,
            dsorder: 3,
            dsbullettype: '1'
        }, options);
//        console.log(settings);
        var dsmaxwidth = settings.dsmaxwidth;
        var dsmaxheight = settings.dsmaxheight;
        var dsmaxchars = settings.dsmaxchars;
        var dsdefaultcontent = settings.dsdefaultcontent;
        var dsusereditable = settings.dsusereditable;
        var dsscalefont = settings.dsscalefont;
        var element_type = settings.element_type;
        var dsorder = settings.dsorder;
        var dsbullettype = settings.dsbullettype;
        var makereadonly = false;
        if (this.data('makereadonly') == 'true' || this.data('makereadonly') == true) {
            makereadonly = true;
        }
        if (this.val() != '') {
            var json_vals = this.val();
            var vals = JSON.parse(json_vals);
            //console.log(vals);
            dsmaxwidth = vals.dsmaxwidth;
            dsmaxheight = vals.dsmaxheight;
            dsmaxchars = vals.dsmaxchars;
            dsdefaultcontent = vals.dsdefaultcontent;
            if (typeof vals.dsusereditable != 'undefined') {
                dsusereditable = true;
            } else {
                dsusereditable = false;
            }
            if (typeof vals.dsscalefont != 'undefined') {
                dsscalefont = true;
            } else {
                dsscalefont = false;
            }
            if (typeof vals.dsbullettype != 'undefined') {
                dsbullettype = vals.dsbullettype;
            }
        }
        var bullet_1 = '';
        var bullet_A = '';
        var bullet_a = '';
        var bullet_i = '';
        var bullet_I = '';
        var bullet_disc = '';
        var bullet_circle = '';
        var bullet_square = '';
        var CHECKED = 'checked="checked"';
        if (dsbullettype == '1')
            bullet_1 = CHECKED;
        if (dsbullettype == 'A')
            bullet_A = CHECKED;
        if (dsbullettype == 'a')
            bullet_a = CHECKED;
        if (dsbullettype == 'i')
            bullet_i = CHECKED;
        if (dsbullettype == 'I')
            bullet_I = CHECKED;
        if (dsbullettype == 'disc')
            bullet_disc = CHECKED;
        if (dsbullettype == 'circle')
            bullet_circle = CHECKED;
        if (dsbullettype == 'square')
            bullet_square = CHECKED;
        var check_dsusereditable = '';
        if (dsusereditable) {
            check_dsusereditable = 'checked="checked"';
        }
        var check_dsscalefont = '';
        if (dsscalefont) {
            check_dsscalefont = 'checked="checked"';
        }
        if (makereadonly) {
            check_dsusereditable = 'checked="checked"';
        }
        var that = this;
        this.hide();
        var button = $('<button type="button" title="General Settings"><i class="fa fa-cogs"></i></button>');
        var window_dom = '<div data-settingsource="' + that.parents('[data-source]').data('source') + '" class="dssettings-panel panel_settings">' +
                '<h6>Settings</h6>' +
                '<span class="pull-left">Max Width <input type="text" name="dsmaxwidth" class="ds-max-width" maxlength="4" value="' + dsmaxwidth + '">' +
                '</span><span class="pull-right">Max Height <input type="text" name="dsmaxheight" class="ds-max-height" maxlength="4" value="' + dsmaxheight + '"></span><div class="clearfix"></div><input type="hidden" name="dselement_type" maxlength="4" value="' + element_type + '">';
        if (element_type == 2 || element_type == '2') {
            window_dom += 'Max Characters <input type="text" name="dsmaxchars" class="ds-max-chars" maxlength="4" value="' + dsmaxchars + '"><br>';
        }
        if (element_type == 3 || element_type == '3') {
            // window_dom += 'Order <input type="text" name="dsorder" class="dsorder" maxlength="4" value="'+dsorder+'"><br>';
            window_dom += '<form onsubmit="return false;" class="bullet_types">';
            window_dom += '<label><input type="radio" name="dsbullettype" value="1" ' + bullet_1 + ' class="paragraph_check"><i class="bull">1</i></label>';

            window_dom += '<label><input type="radio" name="dsbullettype" value="disc" ' + bullet_disc + ' class="paragraph_check"><i class="bull">&bull;</i></label>';
            window_dom += '<label><input type="radio" name="dsbullettype" value="circle" ' + bullet_circle + ' class="paragraph_check"><i class="bull">&#9900;</i></label>';
            window_dom += '<label><input type="radio" name="dsbullettype" value="square" ' + bullet_square + ' class="paragraph_check"><i class="bull">&#9755;</i></label>';
            window_dom += '</form>';
        }
        window_dom += 'Readonly? <input type="checkbox" name="dsusereditable" class="ds-user-editable " value="1" ' + check_dsusereditable + ' ';
        if (makereadonly) {
            window_dom += ' onclick="return false;" onkeydown="return false;" ';
        }
        window_dom += ' > &nbsp; ' +
                ' Scale Font Width <input type="checkbox" name="dsscalefont" class="ds-scale-font " value="1" ' + check_dsscalefont + '><br>';

        if (element_type != 4 && this.parents('tr').find('input[name="parent_element_name[]"]').val() == '') {
            if (element_type == 3 || element_type == '3') {
                if (typeof company_bullets != 'undefined' && company_bullets != '') {
                    var regex = /<br\s*[\/]?>/gi;
                    window_dom += 'Default Content <textarea name="dsdefaultcontent" class="ds-default-content">' + company_bullets.replace(regex, "\n") + '</textarea>';
                }
                else {
                    window_dom += 'Default Content <textarea name="dsdefaultcontent" class="ds-default-content">' + dsdefaultcontent + '</textarea>';
                }
            }
            else if (element_type == 5 || element_type == '5') {

                var d_1 = "";
                var marray = new Array();

                jQuery.ajax({
                    url: SITE_URL + "template/get_headlines_drop",
                    data: '',
                    type: "POST",
                    async: false,
                    datatype: 'json',
                    success: function (data) {
                        var returnjson = JSON.parse(data);


                        var h = "";
                        d_1 += "Default Content <select name='' id='element_type' onchange='javascript:change_hidden_value(this);'>";
                        var cd = 0;

                        $.each(returnjson, function (i, v) {
                            console.log('v', v);
                            if (cd == 0 || !cd) {
                                marray[0] = v.heading_title;
                                Ist_subheadline = v.heading_subtitle;

                            }
                            h += '<option value="' + v.heading_title + '" data-subheadline="' + v.heading_subtitle + '" >' + v.heading_title + '</option>';
                            cd++;
                        });
                        d_1 += h + "</select>";


                    }
                });
                if (Ist_subheadline != '') {
                    window_dom += d_1;
                    window_dom += '<input type="hidden" name="dsdefaultcontent" id="ds_defaultcontent" class="ds-default-content" value="' + marray[0] + '" >';
                }
                else {
                    window_dom += 'Default Content <input type="text" name="dsdefaultcontent" class="ds-default-content" value="' + dsdefaultcontent + '">';
                }
            }
            else if (element_type == 6 || element_type == "6") {
                if (Ist_subheadline != '') {
                    window_dom += 'Default Content <input value="' + Ist_subheadline + '" readonly="readonly" type="text" name="dsdefaultcontent" id="subheadlinetcontent" class="ds-default-content" >';
                }
                else {
                    window_dom += 'Default Content <input type="text" name="dsdefaultcontent" class="ds-default-content" value="' + dsdefaultcontent + '">';
                }
            }
            else {
                window_dom += 'Default Content <input type="text" name="dsdefaultcontent" class="ds-default-content" value="' + dsdefaultcontent + '">';
            }
        }
        window_dom += '</div>';

        var settings_window = $(window_dom);
        this.after(button);
        $('body').append(settings_window);
        //button.after(settings_window);
        //only numbers in numeric fields

        $(".ds-max-width,.ds-max-height, .ds-max-chars").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
        var getData = function () {

            var o = {};
            var a = settings_window.find('input, textarea').serializeArray();
            $.each(a, function () {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            var data = JSON.stringify(o);

            $(that).val(data).change().blur();
        };
        if (this.val() == '')
            getData();
        settings_window.find('input, textarea').change(getData);
        settings_window.find('input, textarea').keyup(getData);
        $(document).mousedown(function (e) {
            if (!settings_window.is(e.target) // if the target of the click isn't the container...
                    && settings_window.has(e.target).length === 0) // ... nor a descendant of the container
            {

                settings_window.hide();
                // $('[data-step="' + current_step + '"]').find('.my_table').addClass('table-responsive');
            }
        });
        button.click(function () {
            //  $('[data-step="' + current_step + '"]').find('.my_table').removeClass('table-responsive');
            settings_window.show();
            settings_window.css('left', button.offset().left - 275 + 'px');
            settings_window.css('top', button.offset().top + 30 + 'px');
        });
    };

    //-------------------------------------------------------------------------------------------
    //settings plugin
    $.fn.dsfontpick = function (options) {
        //default options.
        var settings = $.extend({
            defaultAlign: 'left',
            bold: false,
            italic: false,
            underline: false,
            stikethrough: false,
            font: '',
            dsfontsize: '18', //px
            textwidth: '0',
            textheight: '25',
            textvstrech: '1',
            texthstrech: '1'
        }, options);
        var CHECKED = 'checked="checked"';

        var dsbold = settings.bold;
        var dsitalic = settings.italic;
        var dsunderline = settings.underline;
        var dsstikethrough = settings.stikethrough;
        var dsalign = settings.defaultAlign;

        var dsfont = settings.font;
        var dsfontsize = settings.dsfontsize;
        var dstextwidth = settings.textwidth;
        var dstextheight = settings.textheight;
        var dstextvstrech = settings.textvstrech;
        var dstexthstrech = settings.texthstrech;

        if (this.val() != '') {
            var json_vals = this.val();
            var vals = JSON.parse(json_vals);


            dsfont = vals.dsfont != "" ? vals.dsfont : "Open+Sans";

            dsfontsize = vals.dsfontsize;
            dstextwidth = vals.dstextwidth;
            dstextheight = vals.dstextheight;
            dstextvstrech = vals.dstextvstrech;
            dstexthstrech = vals.dstexthstrech;

            if (typeof vals.dsbold != 'undefined') {
                dsbold = true;
            } else {
                dsbold = false;
            }
            if (typeof vals.dsitalic != 'undefined') {
                dsitalic = true;
            } else {
                dsitalic = false;
            }
            if (typeof vals.dsunderline != 'undefined') {
                dsunderline = true;
            } else {
                dsunderline = false;
            }
            if (typeof vals.dsstikethrough != 'undefined') {
                dsstikethrough = true;
            } else {
                dsstikethrough = false;
            }
            if (typeof vals.dsalign != 'undefined') {
                dsalign = vals.dsalign;
            }
        }


        var bold = dsbold ? CHECKED : '';
        var italic = dsitalic ? CHECKED : '';
        var underline = dsunderline ? CHECKED : '';
        var stikethrough = dsstikethrough ? CHECKED : '';
        var alignleft = '';
        var aligncenter = '';
        var alignright = '';
        if (dsalign == 'left')
            alignleft = CHECKED;
        if (dsalign == 'center')
            aligncenter = CHECKED;
        if (dsalign == 'right')
            alignright = CHECKED;
        var that = this;
        this.hide();
        var button = $('<button type="button" title="Font Setting"><i class="fa fa-paragraph"></i></button>');
        var window_dom = '<div class="dssettings-panel" >' +
                '<h6>Characters</h6>' +
                '<input type="text" name="dsfont" class="ds-font" value="' + dsfont + '">' +
                '<span class="font_size"><img src="' + SITE_URL + 'assets/images/tt_size.jpg"> <select name="dsfontsize">';
        for (i = 1; i <= 72; i++) {
            if (dsfontsize == i) {
                window_dom += '<option value=' + i + ' selected="selected">' + i + ' px</option>';
            } else {
                window_dom += '<option value=' + i + '>' + i + ' px</option>';
            }

        }
        window_dom += '</select></span><hr class="clear">' +
                '<div class="clearfix"><span class="pull-left">' +
                '<form onsubmit="return false;"><label><input type="radio" name="dsalign" value="left" ' + alignleft + ' class="paragraph_check"><i class="fa fa-align-left"></i></label>' +
                '<label><input type="radio" name="dsalign" value="center" ' + aligncenter + ' class="paragraph_check"><i class="fa fa-align-center"></i></label>' +
                '<label><input type="radio" name="dsalign" value="right" ' + alignright + ' class="paragraph_check"><i class="fa fa-align-right"></i></label></form>' +
                '<label><input type="checkbox" value="1" name="dsbold" class="paragraph_check" ' + bold + '><i class="fa fa-bold"></i></label>' +
                '<label><input type="checkbox" value="1" name="dsitalic" class="paragraph_check" ' + italic + '><i class="fa fa-italic"></i></label>' +
                '<label><input type="checkbox" value="1" name="dsunderline" class="paragraph_check" ' + underline + '><i class="fa fa-underline"></i></label>' +
                '<label><input type="checkbox" value="1" name="dsstrikethrough" class="paragraph_check" ' + stikethrough + '><i class="fa fa-strikethrough"></i></label>' +
                '</span><span class="pull-right"> <span><img src="' + SITE_URL + 'assets/images/aa.jpg"></span> <input type="number" name="dstextheight" class="ds-text-height" maxlength="3" value="' + dstextheight + '"><br>' +
                ' <span><img src="' + SITE_URL + 'assets/images/av.jpg"></span><input type="number" name="dstextwidth" class="ds-text-width" maxlength="3" value="' + dstextwidth + '">' +
                '</span></div><hr>' +
                '<i class="fa fa-text-height"></i></i> <input type="number" name="dstextvstrech" class="ds-arrow-v" maxlength="3" value="' + dstextvstrech + '">&nbsp;&nbsp;' +
                '<i class="fa fa-text-width"></i> <input type="number" name="dstexthstrech" class="ds-arrow-h" maxlength="3" value="' + dstexthstrech + '"><br>' +
                '</div>';

        var settings_window = $(window_dom);
        if (this.prop('readonly')) {
            button.prop('disabled', true);
            button.css('color', '#c7c7c7');
        }
        this.after(button);
        $('body').append(settings_window);
        //button.after(settings_window);

        //only numbers in numeric fields
        settings_window.children('.ds-font').fontselect();
        //only numbers in numeric fields
        $(".ds-text-height, .ds-text-width, ds-arrow-h, ds-arrow-v").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
        var getData = function () {

            var o = {};
            var a = settings_window.find('input, select').serializeArray();
            $.each(a, function () {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            var data = JSON.stringify(o);

            $(that).val(data).change().blur();
        };
        if (this.val() == '')
            getData();
        settings_window.find('input, select').change(getData);
        settings_window.find('input, select').keyup(getData);
        $(document).mousedown(function (e) {
            if (!settings_window.is(e.target) // if the target of the click isn't the container...
                    && settings_window.has(e.target).length === 0) // ... nor a descendant of the container
            {
                settings_window.hide();
                // $('[data-step="' + current_step + '"]').find('.my_table').addClass('table-responsive');
            }
        });
        button.click(function () {
            // $('[data-step="' + current_step + '"]').find('.my_table').removeClass('table-responsive');
            settings_window.show();
            settings_window.css('left', button.offset().left - 225 + 'px');
            settings_window.css('top', button.offset().top + 30 + 'px');
        });
    };
    $.loadScript(SITE_URL + 'assets/js/myPlugin/jquery.fontselect.js', function () {
        //Stuff to do after someScript has loaded

        $('.ds-fontpick').each(function () {
            $(this).dsfontpick({
            });
        });
        $('.ds-settings').each(function () {
            $(this).dssettings({
            });
        });
    });
    var cssId = 'myFontCss';  // you could encode the css path itself to generate id..
    if (!document.getElementById(cssId))
    {
        var head = document.getElementsByTagName('head')[0];
        var link = document.createElement('link');
        link.id = cssId;
        link.rel = 'stylesheet';
        link.type = 'text/css';
        link.href = SITE_URL + 'assets/js/myPlugin/fontselect.css';
        link.media = 'all';
        head.appendChild(link);
    }
    //---------------------------------------------------------------------
    //color picker plugin
    $.fn.dscolorpick = function (options) {
        //default options.
        var settings = $.extend({
            color: '#000000'
        }, options);

        var that = this;
        this.hide();
        if (this.val() != '') {
            var clr = $(that).val();
        } else {
            var clr = settings.color;
        }
        var button = $('<button type="button" title="Color Setting"><i class="fa fa-th"></i></button>');
        button.css('color', clr);
        if (this.prop('readonly')) {
            button.prop('disabled', true);
            button.css('color', '#c7c7c7');
        }
        this.after(button);

        button.ColorPicker({
            color: clr,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                button.css('color', '#' + hex);
                that.val('#' + hex).change().blur();
            }
        });
    };
    $.loadScript(SITE_URL + 'assets/js/myPlugin/colorpicker.js', function () {
        //Stuff to do after someScript has loaded
        $('.ds-colorpick').each(function () {
            $(this).dscolorpick({
            });
        });
    });
    var cssId = 'myCss';  // you could encode the css path itself to generate id..
    if (!document.getElementById(cssId))
    {
        var head = document.getElementsByTagName('head')[0];
        var link = document.createElement('link');
        link.id = cssId;
        link.rel = 'stylesheet';
        link.type = 'text/css';
        link.href = SITE_URL + 'assets/js/myPlugin/colorpicker.css';
        link.media = 'all';
        head.appendChild(link);
    }
//-----------------------------------------------------------------------------------
}(jQuery));