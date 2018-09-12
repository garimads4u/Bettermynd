<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="row">
        <?php 
        if(isset($get_support_videos) && !empty($get_support_videos)){
            foreach($get_support_videos as $video){ 
                //$url = @explode('?v=',$video->url);
                $url = $video->url;
                $pattern = '%^# Match any youtube URL
            (?:https?://)?  # Optional scheme. Either http or https
            (?:www\.)?      # Optional www subdomain
            (?:             # Group host alternatives
              youtu\.be/    # Either youtu.be,
            | youtube\.com  # or youtube.com
              (?:           # Group path alternatives
                /embed/     # Either /embed/
              | /v/         # or /v/
              | .*v=        # or /watch\?v=
              )             # End path alternatives.
            )               # End host alternatives.
            ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
            ($|&).*         # if additional parameters are also in query string after video id.
            $%x'        ;
        $result = preg_match($pattern, $url, $matches);
?>
         <div class="col-sm-4">
            <div class="video_overbx">
                <div class="video_img">
                    <a href="javascript:void(0);" class="videoplay"  data-url="<?php echo (isset($matches[1]) ? $matches[1] : ''); ?>"><img src="<?php echo IMAGES_URL; ?>video_pic.png" alt=""></a>
                </div>
                <div class="video_title"><?php echo $video->title; ?></div>
            </div>
        </div>
        
        <?php 
            }
        }        
        ?>
       </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('.videoplay').on('click',function(event){
        var url = $(this).data('url');
        var full_url = "https://www.youtube.com/embed/"+url+"?enablejsapi=1&playerapiid=ytplayer&autoplay=0&amp;rel=0&amp;controls=1&amp;showinfo=1&amp;";
        $("#ytplayer").attr("src", full_url);
        console.log(full_url);
        $("#myvideomodal").modal('show');
    });
    

});

function clear_element(){
    document.getElementById("ytplayer").src="";
    player.pauseVideo();
}
</script>


 <div class="modal fade" id="myvideomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body" id="m_modal_body">
          <iframe width="100%" id="ytplayer" src=""  height="315" id="homeframe" src="" frameborder="0" allowfullscreen>
          </iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default"  data-dismiss="modal"  onclick="clear_element()">Close</button>
        </div>
      </div>
    </div>
  </div>
