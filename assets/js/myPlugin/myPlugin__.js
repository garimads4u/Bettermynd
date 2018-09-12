(function ( $ ) {
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
    $.fn.dssettings = function( options ) {
        //default options.
        var settings = $.extend({
            dsmaxwidth : 400,
            dsmaxheight : 30,
            dsmaxchars : 100,
            dsdefaultcontent : '',
            dsusereditable : false,
            dsscalefont : false,
        }, options );
        var dsmaxwidth = settings.dsmaxwidth;
        var dsmaxheight = settings.dsmaxheight;
        var dsmaxchars = settings.dsmaxchars;
        var dsdefaultcontent = settings.dsdefaultcontent;
        var dsusereditable = settings.dsusereditable;
        var dsscalefont = settings.dsscalefont;
        if(this.val()!=''){
            var json_vals = this.val();
            var vals = JSON.parse(json_vals);
            //console.log(vals);
            dsmaxwidth = vals.dsmaxwidth;
            dsmaxheight = vals.dsmaxheight;
            dsmaxchars = vals.dsmaxchars;
            dsdefaultcontent = vals.dsdefaultcontent;
            if(typeof vals.dsusereditable != 'undefined'){
                dsusereditable = true;
            }else{
                dsusereditable = false;
            }
            if(typeof vals.dsscalefont != 'undefined'){
                dsscalefont = true;
            }else{
                dsscalefont = false;
            }
        }
        var check_dsusereditable = '';
        if(dsusereditable){
            check_dsusereditable = 'checked="checked"';
        }
        var check_dsscalefont = '';
        if(dsscalefont){
            check_dsscalefont = 'checked="checked"';
        }
        var that = this;
        this.hide();
        var button = $('<button type="button"><i class="fa fa-cogs"></i></button>');
        var window_dom =    '<div class="dssettings-panel panel_settings">'+
                            '<h6>Settings</h6>'+
                            '<span class="pull-left">Max Width <input type="text" name="dsmaxwidth" class="ds-max-width" maxlength="4" value="'+dsmaxwidth+'">'+
                            '</span><span class="pull-right">Max Height <input type="text" name="dsmaxheight" class="ds-max-height" maxlength="4" value="'+dsmaxheight+'">'+
                            '</span><div class="clearfix"></div>Max Characters <input type="text" name="dsmaxchars" class="ds-max-chars" maxlength="4" value="'+dsmaxchars+'"><br>'+
                            'Readonly? <input type="checkbox" name="dsusereditable" class="ds-user-editable flat" value="1" '+check_dsusereditable+'> &nbsp; '+
                            ' Scale Font Width <input type="checkbox" name="dsscalefont" class="ds-scale-font flat" value="1" '+check_dsscalefont+'><br>'+
                            'Default Content <input type="text" name="dsdefaultcontent" class="ds-default-content" value="'+dsdefaultcontent+'">'+
                            '</div>';
        var settings_window = $(window_dom);
        this.after(button);
        button.after(settings_window);
        //only numbers in numeric fields
         $(".ds-max-width,.ds-max-height, .ds-max-chars").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
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
        var getData = function(){

                var o = {};
                var a = settings_window.find('input').serializeArray();
                $.each(a, function() {
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
        if(this.val()=='')getData();
        settings_window.find('input').change(getData);
        settings_window.find('input').keyup(getData);
        $(document).mousedown(function (e) {
            if (!settings_window.is(e.target) // if the target of the click isn't the container...
                && settings_window.has(e.target).length === 0) // ... nor a descendant of the container
            {
                settings_window.hide();
            }
        });
        button.click(function(){
            settings_window.show();
        });
    };
    $('.ds-settings').each(function(){
        $(this).dssettings({
        });
    });
    //-------------------------------------------------------------------------------------------
    //settings plugin
    $.fn.dsfontpick = function( options ) {
        //default options.
        var settings = $.extend({
            defaultAlign: 'left',
            bold: false,
            italic: false,
            underline: false,
            stikethrough: false,
            font: '',
            dsfontsize: '14', //px
            textwidth: '25',
            textheight: '10',
            lineheight: '10',
            charspacing: '30'
        }, options );
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
        var dslineheight = settings.lineheight;
        var dscharspacing = settings.charspacing;
        
        if(this.val()!=''){
            var json_vals = this.val();
            var vals = JSON.parse(json_vals);
           // console.log(vals);
            
            dsfont = vals.dsfont;
            dsfontsize = vals.dsfontsize;
            dstextwidth = vals.dstextwidth;
            dstextheight = vals.dstextheight;
            dslineheight = vals.dslineheight;
            dscharspacing = vals.dscharspacing;
            
            if(typeof vals.dsbold != 'undefined'){
                dsbold = true;
            }else{
                dsbold = false;
            }
            if(typeof vals.dsitalic != 'undefined'){
                dsitalic = true;
            }else{
                dsitalic = false;
            }
            if(typeof vals.dsunderline != 'undefined'){
                dsunderline = true;
            }else{
                dsunderline = false;
            }
            if(typeof vals.dsstikethrough != 'undefined'){
                dsstikethrough = true;
            }else{
                dsstikethrough = false;
            }
            if(typeof vals.dsalign != 'undefined'){
                dsalign = vals.dsalign;
            }
        }
        
        var alignleft = '';
        var aligncenter = '';
        var alignright = '';
        var bold =dsbold?CHECKED:'';
        var italic =dsitalic?CHECKED:'';
        var underline =dsunderline?CHECKED:'';
        var stikethrough =dsstikethrough?CHECKED:'';
        if(dsalign=='left')alignleft = CHECKED;
        if(dsalign=='center')aligncenter = CHECKED;
        if(dsalign=='right')alignright = CHECKED;
        var that = this;
        this.hide();
        var button = $('<button type="button"><i class="fa fa-paragraph"></i></button>');
        var window_dom =    '<div class="dssettings-panel" >'+
                            '<h6>Characters</h6>'+
                            '<input type="text" name="dsfont" class="ds-font" value="'+dsfont+'">'+
                            '<span class="font_size"><img src="images/tt_size.jpg"> <select name="dsfontsize">';
                           for(i=1;i<=72;i++) {
                               if(dsfontsize==i){
                                   window_dom +=  '<option value='+i+' selected="selected">'+i+' px</option>';
                               }else{
                                   window_dom +=  '<option value='+i+'>'+i+' px</option>';
                               }
                               
                           }
            window_dom +=  '</select></span><hr class="clear">'+
							'<div class="clearfix"><span class="pull-left">'+
                            '<form onsubmit="return false;"><label><input type="radio" name="dsalign" value="left" '+alignleft+' class="paragraph_check"><i class="fa fa-align-left"></i></label>'+
                            '<label><input type="radio" name="dsalign" value="center" '+aligncenter+' class="paragraph_check"><i class="fa fa-align-center"></i></label>'+
                            '<label><input type="radio" name="dsalign" value="right" '+alignright+' class="paragraph_check"><i class="fa fa-align-right"></i></label></form>'+
                            '<label><input type="checkbox" value="1" name="dsbold" class="paragraph_check" '+bold+'><i class="fa fa-bold"></i></label>'+
                            '<label><input type="checkbox" value="1" name="dsitalic" class="paragraph_check" '+italic+'><i class="fa fa-italic"></i></label>'+
                            '<label><input type="checkbox" value="1" name="dsunderline" class="paragraph_check" '+underline+'><i class="fa fa-underline"></i></label>'+
                            '<label><input type="checkbox" value="1" name="dsstrikethrough" class="paragraph_check" '+stikethrough+'><i class="fa fa-strikethrough"></i></label>'+
                            '</span><span class="pull-right"> <span><img src="images/aa.jpg"></span> <input type="text" name="dstextheight" class="ds-text-height" maxlength="3" value="'+dstextheight+'"><br>'+
                            ' <span><img src="images/av.jpg"></span><input type="text" name="dstextwidth" class="ds-text-width" maxlength="3" value="'+dstextwidth+'">'+
                             '</span></div><hr>'+
                            '<i class="fa fa-text-height"></i></i> <input type="text" name="dslineheight" class="ds-arrow-v" maxlength="3" value="'+dslineheight+'">&nbsp;&nbsp;'+
                            '<i class="fa fa-text-width"></i> <input type="text" name="dscharspacing" class="ds-arrow-h" maxlength="3" value="'+dscharspacing+'"><br>'+
                            '</div>';
                            
        var settings_window = $(window_dom);
        this.after(button);
        button.after(settings_window);

        //only numbers in numeric fields
        settings_window.children('.ds-font').fontselect();
        //only numbers in numeric fields
         $(".ds-text-height, .ds-text-width, ds-arrow-h, ds-arrow-v").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
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
        var getData = function(){

                var o = {};
                var a = settings_window.find('input, select').serializeArray();
                $.each(a, function() {
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
        if(this.val()=='')getData();
        settings_window.find('input, select').change(getData);
        $(document).mousedown(function (e) {
            if (!settings_window.is(e.target) // if the target of the click isn't the container...
                && settings_window.has(e.target).length === 0) // ... nor a descendant of the container
            {
                settings_window.hide();
            }
        });
        button.click(function(){
            settings_window.show();
        });
    };
    $.loadScript('js/myPlugin/jquery.fontselect.js', function(){
        //Stuff to do after someScript has loaded
        $('.ds-fontpick').each(function(){
            $(this).dsfontpick({
            });
        });
    });
    var cssId = 'myFontCss';  // you could encode the css path itself to generate id..
    if (!document.getElementById(cssId))
    {
        var head  = document.getElementsByTagName('head')[0];
        var link  = document.createElement('link');
        link.id   = cssId;
        link.rel  = 'stylesheet';
        link.type = 'text/css';
        link.href = 'js/myPlugin/fontselect.css';
        link.media = 'all';
        head.appendChild(link);
    }
    //---------------------------------------------------------------------
    //color picker plugin
    $.fn.dscolorpick = function( options ) {
        //default options.
        var settings = $.extend({
            color: '#000000'
        }, options );
        
        var that = this;
        this.hide();
        if(this.val()!=''){
            var clr = $(that).val();
        }else{
            var clr = settings.color;
        }
        var button = $('<button type="button"><i class="fa fa-th"></i></button>');
        button.css('color',clr);
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
    $.loadScript('js/myPlugin/colorpicker.js', function(){
        //Stuff to do after someScript has loaded
        $('.ds-colorpick').each(function(){
            $(this).dscolorpick({
            });
        });
    });
    var cssId = 'myCss';  // you could encode the css path itself to generate id..
    if (!document.getElementById(cssId))
    {
        var head  = document.getElementsByTagName('head')[0];
        var link  = document.createElement('link');
        link.id   = cssId;
        link.rel  = 'stylesheet';
        link.type = 'text/css';
        link.href = 'js/myPlugin/colorpicker.css';
        link.media = 'all';
        head.appendChild(link);
    }
    //-----------------------------------------------------------------------------------
}( jQuery ));

