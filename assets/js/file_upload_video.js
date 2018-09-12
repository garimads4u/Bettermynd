var jqXHR = null;
function sendFileToServer(formData, status)
{
    document.getElementById("play_video").pause();
    document.getElementById("play_video").style.display = "none";
    document.getElementById("new_controls").style.display = "none";
    $('.loading-img').show();
    var uploadURL = SITE_URL + "template/ajax_php_file_video"; //Upload URL
    var extraData = {}; //Extra Data.
    if (jqXHR != null && jqXHR.readyState == 4) {
        return false;
    }
    jqXHR = $.ajax({
        xhr: function (data) {
            var xhrobj = $.ajaxSettings.xhr();
            if (xhrobj.upload) {
                xhrobj.upload.addEventListener('progress', function (event) {
                    var percent = 0;
                    var position = event.loaded || event.position;
                    var total = event.total;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);
                    }
                    //Set progress
                    //status.setProgress(percent);
                }, false);
            }
            return xhrobj;
        },
        url: uploadURL,
        type: "POST",
        contentType: false,
        processData: false,
        cache: false,
        data: formData,
        success: function (data) {
            jqXHR = null;
            $('.loading-img').hide();
            document.getElementById("play_video").style.display = "block";
            document.getElementById("new_controls").style.display = "block";
            data = JSON.parse(data);
            if (data.status) {
                url = data.file;
                $('#background').val(url);
                $('#files').val('');
                $('#video_container').show();
                $('source').attr('src', url);
                $('video').load();
                $('#duration').val(data.duration);
                $('.end_time').text(secondsToHms($('#duration').val()));
                $('#width').val(data.width);
                $("#width").addClass("graycolor");
                $('#height').val(data.height);
                $('#origname').val(data.origname);
                set_dimensions();
                $(window).on('resize', function () {
                    set_dimensions()
                });
                $('#menu_toggle').on('click', function () {
                    set_dimensions()
                });
                $('#slider').show();
                $('.control').fadeIn(500);
                canvas.show();
            } else {

                $("#infoMessage").html("<p class='alert alert-danger text-left'>" + data.msg + "</p>");
                $("#infoMessage").removeClass("hide");
                $('.loading-img').hide();
                $('.loading-img').css('display', 'none');
                window.scroll(0, 0);
                $(".alert-danger").fadeTo(2000, 500).slideUp(800, function () {
                    $(".alert-danger").alert('close');
                });
                if ($("#errormsg").hasClass("hide")) {

                }
                else {

                }
            }
        }
    });

    //status.setAbort(jqXHR);
}
function set_dimensions() {
    width = $('video').width();
    height = $('video').height();
    data_width = $('#width').val();
    data_height = $('#height').val();
    width_per = (width / data_width) * 100;
    height_per = (height / data_height) * 100;
    canvas.css('width', data_width + 'px');
    canvas.css('height', data_height + 'px');
    zoom = width_per;
    //canvas.css('zoom', width_per+'%' );
    canvas.css('transform-origin', 'top left');
    canvas.css('transform', ' scale(' + width_per / 100 + ')');
}
$(window).on('resize', function () {
    set_dimensions()
});
$('#menu_toggle').on('click', function () {
    set_dimensions()
});
var rowCount = 0;
function createStatusbar(obj)
{
    rowCount++;
    var row = "odd";
    if (rowCount % 2 == 0)
        row = "even";
    this.statusbar = $("<div class='statusbar " + row + "'></div>");
    this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
    this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
    this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
    this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
    //obj.after(this.statusbar);

    this.setFileNameSize = function (name, size)
    {
        var sizeStr = "";
        var sizeKB = size / 1024;
        if (parseInt(sizeKB) > 1024)
        {
            var sizeMB = sizeKB / 1024;
            sizeStr = sizeMB.toFixed(2) + " MB";
        }
        else
        {
            sizeStr = sizeKB.toFixed(2) + " KB";
        }

        this.filename.html(name);
        this.size.html(sizeStr);
    }
    this.setProgress = function (progress)
    {
        var progressBarWidth = progress * this.progressBar.width() / 100;
        this.progressBar.find('div').animate({width: progressBarWidth}, 10).html(progress + "% ");
        if (parseInt(progress) >= 100)
        {
            this.abort.hide();
        }
    }
    this.setAbort = function (jqxhr)
    {
        var sb = this.statusbar;
        this.abort.click(function ()
        {
            jqxhr.abort();
            sb.hide();
        });
    }
}
function handleFileUpload(files, obj)
{

    if (files.length > 1) {
        $("#infoMessage").html('<p class="alert alert-danger">Please upload a single file only.</p>');
        $(".alert-danger").fadeTo(2000, 500).slideUp(800, function () {
            $(".alert-danger").alert('close');
            $("#targetsource").attr("src", "");
        });
        return;
    }
    for (var i = 0; i < files.length; i++)
    {
        var fd = new FormData();
        fd.append('FileInput', files[i]);
        if (files[i].type.length <= 0) {
            $("#infoMessage").html('<p class="alert alert-danger">Folder upload not allowed.</p>');
            $(".alert-danger").fadeTo(2000, 500).slideUp(800, function () {
                $(".alert-danger").alert('close');
                $("#targetsource").attr("src", "");
            });
            return;
        }
        var status = new createStatusbar(obj); //Using this we can set progress.
        status.setFileNameSize(files[i].name, files[i].size);
        sendFileToServer(fd, status);

    }
}
$(document).ready(function ()
{
    var obj = $("#dragandrophandler");
    obj.on('dragenter', function (e)
    {

        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', '5px solid #0B85A1');
    });
    obj.on('dragover', function (e)
    {
        e.stopPropagation();
        e.preventDefault();
    });
    obj.on('drop', function (e)
    {
        $(this).css('border', '5px dashed rgba(0, 0, 0, 0.2)');
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        //We need to send dropped files to Server
        handleFileUpload(files, obj);
    });
    $('#files').on('change', function (e)
    {

        var file_size = this.files[0].size;
        var file_type = this.files[0].type;

        if (file_size > 52428800) {
            $("#infoMessage").html('<p class="alert alert-danger">Please upload video file upto 50 MB.</p>');
            $(".alert-danger").fadeTo(2000, 500).slideUp(800, function () {
                $(".alert-danger").alert('close');
                $("#targetsource").attr("src", "");

            });
        }
        else if (file_type != "video/mp4" && file_type != "video/mpg" && file_type != "video/mpeg" && file_type != "video/avi" && file_type != "video/mov" && file_type != "video/quicktime" && file_type != "video/x-ms-wmv" && file_type != "video/3gpp" && file_type != "video/3gp")
        {

            $("#infoMessage").html('<p class="alert alert-danger">Invalid file format.</p>');
            $(".alert-danger").fadeTo(2000, 500).slideUp(800, function () {
                $(".alert-danger").alert('close');
                $("#targetsource").attr("src", "");
                document.getElementById("targetsource").removeAttribute("src");
            });
            this.value = null;
        }
        else {
            // fileupload
            var fd = new FormData($('#fileupload')[0]);
            $("#targetsource").attr("src", "");
            document.getElementById("targetsource").removeAttribute("src");
            sendFileToServer(fd);
            this.value = null;
        }
    });
    $(document).on('dragenter', function (e)
    {
        e.stopPropagation();
        e.preventDefault();
    });
    $(document).on('dragover', function (e)
    {
        e.stopPropagation();
        e.preventDefault();
        obj.css('border', '5px dashed #0B85A1');
    });
    $(document).on('drop', function (e)
    {
        e.stopPropagation();
        e.preventDefault();
    });

});