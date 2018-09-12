var jqXHR = null;
function sendFileToServer(formData, status)
{

    canvas.hide();
    $('.loading-img').show();
    $('#slider').hide();
    var uploadURL = SITE_URL + "template/custom_template_file_upload"; //Upload URL
    var extraData = {}; //Extra Data.
    if (jqXHR != null) {
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
                    // status.setProgress(percent);
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
//        console.log(data);
//            status.setProgress(100);
//
//            $("#status1").append("File upload Done<br>");
            //  $('.loading-img').hide();
            data = JSON.parse(data);
            if (data.status == 1) {

                url = SITE_URL + 'assets/upload/templates/' + data.file;
                $('#files').val('');
                $("<img/>", {
                    load: function () {
                        $('#background').val(data.file);
                        canvas.css('width', (this.width) + 'px');
                        canvas.css('height', (this.height) + 'px');
                        canvas.css('background-image', 'url(' + url + ')');
                        canvas.css('background-size', (this.width) + 'px ' + (this.height) + 'px');//background-size: 80px 60px;
                        bleed.css('width', (this.width - (bleedsize * 2)) + 'px');
                        bleed.css('height', (this.height - (bleedsize * 2)) + 'px');
                        bleed.css('margin-left', bleedsize + 'px');
                        bleed.css('margin-top', bleedsize + 'px');
                        $('#width').val(this.width);
                        $('#height').val(this.height);
                        $('#width').removeClass('error');
                        $('#height').removeClass('error');
                        $('#width').attr("readonly", false);
                        $('#height').attr("readonly", false);
                        $('#width').prop('disabled', true);
                        $('#height').prop('disabled', true);

                        canvas.show();
                        $('#slider').show();
                        $('.loading-img').hide();
                        $('.loading-img').css('display', 'none');
                    },
                    src: url
                });
                $("#errormsg").css('display', 'none');
                $("#errormsg").removeClass("show");
                $("#errormsg").addClass("hide");

            } else if (data.status == 2) {

                $('#message_page').html(data.msg);
                $('#select_page').html('');
                for (i = 1; i <= data.pages; i++) {
                    $('#select_page').append('<option value="' + i + '">' + i + '</option>');
                }
                $('#apply_image_changes').unbind('click').bind('click', function () {
                    $('#apply_image_changes').unbind('click');
                    data.selected_page = $('#select_page').val();
                    $.post(SITE_URL + "template/pdf_to_png", data, function (newdata) {
                        newdata = JSON.parse(newdata);
                        if (newdata.status == 1) {
                            //url = 'uploads/'+newdata.file;
                            url = SITE_URL + 'assets/upload/templates/' + newdata.file;
                            $('#files').val('');
                            $("<img/>", {
                                load: function () {
                                    $('#background').val(newdata.file);
                                    canvas.css('width', (this.width) + 'px');
                                    canvas.css('height', (this.height) + 'px');
                                    canvas.css('background-image', 'url(' + url + ')');
                                    canvas.css('background-size', (this.width) + 'px ' + (this.height) + 'px');//background-size: 80px 60px;
                                    $('#width').val(this.width);
                                    $('#height').val(this.height);
                                    canvas.show();
                                    $('#slider').show();
                                    $('#page_modal').modal('hide');
                                    $('.loading-img').hide();
                                    $('.loading-img').css('display', 'none');
                                },
                                src: url
                            });
                            $("#errormsg").css('display', 'none');
                            $("#errormsg").removeClass("show");
                            $("#errormsg").addClass("hide");
                        } else {
                            $("#errormsg").text(newdata.msg);

                            $("#errormsg").removeClass("hide");
                            window.scroll(0, 0);
                            if ($("#errormsg").hasClass("hide")) {

                            }
                            else {

                            }
                        }
                    });
                });
                $('#page_modal').modal('show');
            }
            else {

                $('#width').removeClass('error');
                $('#height').removeClass('error');
                $('#width').attr("readonly", true);
                $('#height').attr("readonly", true);
                $('#width').prop('disabled', false);
                $('#height').prop('disabled', false);
                $('#width').val("");
                $('#height').val("");
                $("#errormsg").text(data.msg);
                $("#errormsg").removeClass("hide");
                $("#errormsg").addClass("show");

                $('.loading-img').hide();
                $('.loading-img').css('display', 'none');
                window.scroll(0, 0);
                if ($("#errormsg").hasClass("hide")) {

                }
                else {

                }
            }
        }
    });

    //  status.setAbort(jqXHR);
}

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
        $("#errormsg").text('Upload single file only.');
        $("#errormsg").removeClass("hide");
        return false;
    }
    for (var i = 0; i < files.length; i++)
    {
        var fd = new FormData();
        fd.append('FileInput', files[i]);

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
        // fileupload
        var file_size = this.files[0].size;
        var file_type = this.files[0].type;
			
			$("#errormsg").addClass("hide");
			$("#errormsg").removeClass("show");
        
		if (file_type != "image/jpeg" && file_type != "image/png" && file_type != "image/pjpeg" && file_type != "application/pdf")
        {

            $("#infoMessage").html('<p class="alert alert-danger err1">Invalid file format.</p>');
            $(".err1").fadeTo(2000, 500).slideUp(800, function () {
                $(".err1").alert('close');
                //$("#targetsource").attr("src", "");
                // document.getElementById("targetsource").removeAttribute("src");
            });
            this.value = null;
        }
        else if (file_size > 15728640) {
            $("#infoMessage").html('<p class="alert alert-danger err1">Please upload file upto 15 MB.</p>');
            $(".err1").fadeTo(2000, 500).slideUp(800, function () {
                $(".err1").alert('close');
                //  $("#targetsource").attr("src", "");

            });
            this.value = null;
        }
        else {
            //file upload
            var fd = new FormData($('#fileupload')[0]);
            sendFileToServer(fd);
            this.value = null;
        }

//        var fd = new FormData($('#fileupload')[0]);
//        sendFileToServer(fd);
//        this.value = null;
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