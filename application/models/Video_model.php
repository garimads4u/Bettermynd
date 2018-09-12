<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Video_model extends CI_Model {

    function __construct() { // Constructor
        parent::__construct();
    }

    function get_template_data($company_id) {

        $return = array();
        $sql = $this->db->query("select * from " . TEMPLATE_SECTIONS . " where id =4");
        $result = $sql->result_array();
        if (count($result)) {
            $return['data1'] = $result[0];
        }

        $sql1 = $this->db->query('select * from ' . ELEMENT_TYPES);
        $result1 = $sql1->result_array();
        if (count($result1)) {
            $return['element_types'] = $result1[0];
        }

        $sql2 = $this->db->query('select * from ' . TEMPLATE_TYPES . " where category='3'");
        $result2 = $sql2->result_array();

        if (count($result2)) {
            $return['template_types'] = $result2;
        }

        $sql4 = $this->db->query('select * from ' . TEMPLATE_ELEMENTS . ' where section_id=4');
        $result4 = $sql4->result_array();
        if (count($result4) > 0) {

            $return['result4'] = $result4[0];
        }
        $sql5 = $this->db->query("select * from " . GROUPS . " where group_created_company_id=" . $company_id . " order by group_name");
        $result5 = $sql5->result_array();
        if (count($result5)) {
            $return['groups'] = $result5;
        }
        $return['dpi'] = 72;
        $return['canvaswidth'] = 3.5; //inch
        $return['canvasheight'] = 2; //inch
        $return['canvaswidth_px'] = $result[0]['width'] . 'px'; //inch
        $return['canvasheight_px'] = $result[0]['height'] . 'px'; //inch
        return $return;
    }

    function get_video_size($videofile) {
        $ffmpeg_path = '/usr/local/bin/ffmpeg';
        $duration = array();
        $bitrate = '';
        $video_bitrate = '';
        $vwidth = 320;
        $vheight = 240;
        $owidth = '';
        $oheight = '';
        $sfrequency = '';
        $audio_bitrate = '';

        $ffmpeg_output = array();
        $ffmpeg_cmd = $ffmpeg_path . " -i '" . $videofile . '\' 2>&1 | cat | egrep -e \'(Duration|Stream)\'';
        @exec($ffmpeg_cmd, $ffmpeg_output);

        //print_r($ffmpeg_output);
        // if file not found just return null
        if (sizeof($ffmpeg_output) == '')
            return null;

        foreach ($ffmpeg_output as $line) {
            $ma = array();
            // get duration and video bitrate
            if (strpos($line, 'Duration:') !== false) {
                preg_match('/(?<hours>\d+):(?<minutes>\d+):(?<seconds>\d+)\.(?<fractions>\d+)/', $line, $ma);
                $duration = array(
                    'raw' => $ma['hours'] . ':' . $ma['minutes'] . ':' . $ma['seconds'] . '.' . $ma['fractions'],
                    'hours' => intval($ma['hours']),
                    'minutes' => intval($ma['minutes']),
                    'seconds' => intval($ma['seconds']),
                    'fractions' => intval($ma['fractions']),
                    'rawSeconds' => intval($ma['hours']) * 60 * 60 +
                    intval($ma['minutes']) * 60 + intval($ma['seconds']) +
                    (intval($ma['fractions']) != 0 ? 1 : '')
                );

                preg_match('/bitrate:\s(?<bitrate>\d+)\skb\/s/', $line, $ma);
                $bitrate = $ma['bitrate'];
            }

            // get video size
            if (strpos($line, 'Video:') !== false) {
//												preg_match('/\s(?<width>\d+)[x](?<height>\d+)\s\[/', $line, $ma);
                preg_match('/\s(?<width>\d+)[x](?<height>\d+)[,\s]/', $line, $ma);
                $owidth = $ma['width'];
                $oheight = $ma['height'];
                $vwidth = $owidth;
                $vheight = $oheight;
            }

            // get audio quality
            if (strpos($line, 'Audio:') !== false) {
                preg_match('/,\s(?<sfrequency>\d+)\sHz,/', $line, $ma);
                $sfrequency = $ma['sfrequency'];

                preg_match('/,\s(?<bitrate>\d+)\skb\/s/', $line, $ma);
                $audio_bitrate = $ma['bitrate'];
            }
        }

        return array(
            'width' => $vwidth,
            'height' => $vheight,
            'srcWidth' => $owidth,
            'srcHeight' => $oheight,
            'duration' => $duration,
            'bitrate' => $bitrate,
            'audioBitrate' => $audio_bitrate,
            'audioSampleFrequency' => $sfrequency
        );
    }

    function save_video_template($elements) {

        $section_id = 4;
        $template_id = $_POST['template_id'];
        $deleteQuery = $this->db->query("delete from " . TEMPLATE_ELEMENTS . " where template_id=" . $template_id);
        $commands = array();
        if (isset($elements) && !empty($elements)) {
            foreach ($_POST['element_name'] as $key => $val) {

                $element_name = $_POST['element_name'][$key];
                $element_type = $_POST['element_type'][$key];
                $cord_x = $_POST['cord_x'][$key];
                $cord_y = $_POST['cord_y'][$key];
                $font_settings = $_POST['font_settings'][$key];
                $color = $_POST['color'][$key];
                $settings = addslashes($_POST['settings'][$key]);
                $data_point_id = $_POST['data_point_id'][$key];
                $data_point_category = $_POST['data_point_category'][$key];
                $is_active = $_POST['is_active'][$key];
                $start = 0;
                $stop = 0;
                if (isset($_POST['start'][$key])) {
                    $start = $_POST['start'][$key];
                    $stop = $_POST['end'][$key];
                }
                $sql = $this->db->query("INSERT INTO " . TEMPLATE_ELEMENTS . " (section_id,template_id,element_name,  element_type, color, settings, font_settings, cord_x, cord_y, data_point_id, data_point_category,is_active,start,stop) VALUES ($section_id,$template_id,'$element_name', '$element_type','$color','$settings','$font_settings',$cord_x,$cord_y, $data_point_id, $data_point_category,$is_active,$start,$stop)");


                $x = $_POST['cord_x'][$key];
                $y = $_POST['cord_y'][$key];
                if (isset($_POST['start'][$key])) {
                    $start = $_POST['start'][$key];
                    $stop = $_POST['end'][$key];
                }
                $color = trim($_POST['color'][$key]) != '' ? $_POST['color'][$key] : '#9fa3ab';
                $fonts = json_decode($_POST['font_settings'][$key]);
                $fontsize = $fonts->dsfontsize;
                //“/usr/share/fonts/brandize_fonts/
                $font = $fonts->dsfont != '' ? '/usr/share/fonts/brandize_fonts/' . $fonts->dsfont : '/usr/share/fonts/brandize_fonts/OpenSans-ExtraBold';
                // $font = 0?'/usr/share/fonts/brandize_fonts/'.$fonts->dsfont:'/usr/share/fonts/ttf/OpenSans-ExtraBold';
                if ($_POST['is_active'][$key] == "1") {
                    $commands[] = "drawtext=\"fontfile='$font.ttf': \ text='$val': fontcolor=$color: fontsize=$fontsize: box=0: boxcolor=black@0.5: \ boxborderw=5: x=$x: y=$y:enable='between(t,$start,$stop)'\"";
                }
            }
            $video_file_query = "select * from " . TEMPLATES . " where id='" . $template_id . "'";
            $video_file_sql = $this->db->query($video_file_query);
            $video_file_result = $video_file_sql->result_array();
            if (isset($video_file_result) && !empty($video_file_result)) {
                $path_copy = VIDEO_UPLOAD_PATH . $video_file_result[0]['video'];
                $newfile = time() . '_preview.mp4';
                $path_paste = VIDEO_UPLOAD_PATH . 'final/' . $newfile;
            }


            $test = "/usr/local/bin/ffmpeg -i '$path_copy' -vf " . implode(',', $commands) . " -codec:a copy '$path_paste'";

            $ex = system($test, $return);
            if ($return) {
                $this->session->set_flashdata('error', 'There is some error in generating preview of your video.Please try again later.');
                $this->db->query("delete from " . TEMPLATES . " where id=" . $template_id);
                return "0";
            } else {
                $file_url = $path_paste;
                $file_url_arr = explode("/", $file_url);
                $file_url = $file_url_arr[sizeof($file_url_arr) - 1];
                $update_query = "update " . TEMPLATES . " set preview_img='$file_url' where id=" . $template_id;
                $update_sql = $this->db->query($update_query);
            }
            if ($file_url) {
                return "1";
            }
        }
    }

    function get_user_template_default_data($template_id) {


        $return = array();
        $sql = $this->db->query("select * from " . TEMPLATES . " where id =" . $template_id);
        $result = $sql->result_array();
        if (count($result)) {
            $return['data1'] = $result[0];
        }

        $sql1 = $this->db->query('select * from ' . ELEMENT_TYPES);
        $result1 = $sql1->result_array();
        if (count($result1)) {
            $return['element_types'] = $result1[0];
        }



        $sql4 = $this->db->query('select * from ' . TEMPLATE_ELEMENTS . ' where template_id=' . $template_id . ' and is_active=1');
        $result4 = $sql4->result_array();
        if (count($result4) > 0) {

            $return['result4'] = $result4;
        }
        $sql5 = $this->db->query("select * from " . GROUPS . " order by group_name");
        $result5 = $sql5->result_array();
        if (count($result5)) {
            $return['groups'] = $result5;
        }
        $return['dpi'] = 72;
        $return['canvaswidth'] = $return['data1']['width'] / $return['dpi']; //inch
        $return['canvasheight'] = $return['data1']['height'] / $return['dpi'];
        ; //inch
        $return['canvaswidth_px'] = $return['data1']['width'] . 'px'; //inch
        $return['canvasheight_px'] = $return['data1']['height'] . 'px'; //inch
        return $return;
    }

}
