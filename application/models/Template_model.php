<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template_model extends CI_Model {

    function __construct() { // Constructor
        $this->load->library('libs3');
        $this->load->helper('download_helper');
        parent::__construct();
    }

    function custom_template_file_upload() {
        ini_set('upload_max_filesize', '512M');
        if (isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"] == UPLOAD_ERR_OK) {
            ############ Edit settings ##############
            $UploadDirectory = FILE_UPLOAD_PATH . 'upload/templates/'; //specify upload directory ends with / (slash)
            ##########################################

            /*
              Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini".
              Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit
              and set them adequately, also check "post_max_size".
             */

            //check if this is an ajax request
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                die();
            }


            //Is file size is less than allowed size.
            if ($_FILES["FileInput"]["size"] > 15728640) {
                die(json_encode(array('status' => 0, 'msg' => 'Please upload file upto 15 MB.'))); //output error
                die("File size is too big!");
            }

            //allowed file type Server side check
            $file_type = strtolower($_FILES['FileInput']['type']);
            switch ($file_type) {
                //allowed file types
                case 'image/png':
                //case 'image/gif':
                case 'image/jpeg':
                case 'image/pjpeg':
                //case 'text/plain':
                //case 'text/html': //html file
                //case 'application/x-zip-compressed':
                case 'application/pdf':
                    //case 'application/msword':
                    //case 'application/vnd.ms-excel':
                    //case 'video/mp4':
                    break;
                default:
                    die(json_encode(array('status' => 0, 'msg' => 'Invalid file format.'))); //output error
            }

            $File_Name = strtolower($_FILES['FileInput']['name']);
            $File_Ext = substr($File_Name, strrpos($File_Name, '.')); //get file extention
            $Random_Number = rand(0, 9999999999); //Random number to be added to name.
            $NewFileName = $Random_Number . $File_Ext; //new file name

            if (move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory . $NewFileName)) {
                $myurl = $UploadDirectory . $NewFileName;
                if ($file_type == 'application/pdf') {
                    try {
//                        $image = new Imagick($myurl);
//                        //$image->setResolution( 300, 300 );
//                        $image->setImageFormat( "png" );
//                        $image->writeImage($UploadDirectory.'png/'.$Random_Number.'.png');

                        $pdftext = file_get_contents($myurl);
                        $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
                        //$num;
                        if ($num == 1) {
                            $image = new Imagick();
                            $image->setResolution(300, 300);
							 $image->readImage($myurl);
                            $image->setImageFormat("png");
                            $image->writeImage($UploadDirectory . 'png/' . $Random_Number . '.png');
                        } else {
                            $target = $UploadDirectory . 'png/' . $Random_Number . '.png';
                            $file_url = 'png/' . $Random_Number . '.png';
                            die(json_encode(array('status' => 2, 'msg' => 'Uploaded PDF file has more than 1 pages, Please select which page you want to load for template?', 'source' => $myurl, 'target' => $target, 'pages' => $num, 'original_name' => $File_Name, 'file_url' => $file_url)));
//                            $image = new Imagick($myurl.'[6]');
//                            $image->setResolution( 300, 300 );
//                            $image->setImageFormat( "png" );
//                            $image->writeImage();
                        }
//                        $im = new Imagick();
//                        $im->pingImage($myurl);
//                        echo $im->getNumberImages();die;
                    } catch (Exception $e) {
                        unlink($UploadDirectory . $NewFileName);
                        die(json_encode(array('status' => 0, 'msg' => 'error converting file to image!')));
                    }
                } else {

                    if ($file_type != 'image/png') {
                        $img_size = getimagesize($UploadDirectory . $NewFileName);
                        if ($img_size[0] <= 3840 && $img_size[1] <= 3840) {
                            imagepng(imagecreatefromstring(file_get_contents($myurl)), $UploadDirectory . "png/$Random_Number.png");
                        } else {
                            unlink($UploadDirectory . $NewFileName);
                            die(json_encode(array('status' => 0, 'msg' => 'Error! Maximum file upload limit is 3840 X 3840 px.'))); //output error
                            die('error uploading File!');
                        }
                    } else {
                        copy($myurl, $UploadDirectory . "png/$Random_Number.png");
                        $fileinput = file_get_contents($UploadDirectory . "png/$Random_Number.png");
                    }
                    unlink($UploadDirectory . $NewFileName);
                }
                die(json_encode(array('status' => 1, 'msg' => 'success', 'file' => "png/$Random_Number.png", 'original_name' => $File_Name)));
            } else {
                die(json_encode(array('status' => 0, 'msg' => 'error uploading File!'))); //output error
                die('error uploading File!');
            }
        } else {
            die(json_encode(array('status' => 0, 'msg' => 'Something wrong with upload! Is "upload_max_filesize" set correctly?'))); //output error
            die('Something wrong with upload. Please try again.');
        }
    }

    function get_template_types($type = false) {
        $query = $this->db->get(TEMPLATE_TYPES);
        $template = array();
        $template[''] = "Select Type";
        if ($query->num_rows() > 0 && $type == true) {
            foreach ($query->result() as $key => $value) {
//                if ($type == 'P' && $value->category == TEMPLATE_TYPE_PRINT_ADS) {
//                    $template[$value->id] = $value->type;
//                } elseif ($type == 'B' && $value->category == TEMPLATE_TYPE_BANNER_ADS) {
//                    $template[$value->id] = $value->type;
//                }
                if($value->category == TEMPLATE_TYPE_PRINT_ADS || $value->category == TEMPLATE_TYPE_BANNER_ADS) {
                        $template[$value->id] = $value->type;
                }
            }
            return $template;
        } else {
            return array();
        }
    }

    function update_custom_template($company_id) {
        $current_user = $this->ion_auth->user()->row();
        $background = $this->input->post('background');
        $section_id = $this->input->post('section_id');
        $template_id = $this->input->post('template_id');
        $template_type = $this->input->post('template_type');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $width = $this->input->post('width');
        $height = $this->input->post('height');
        $notify_check = $this->input->post('notify_check');
        $print_bleed = $this->input->post('print_bleed');

        if (isset($notify_check) && $notify_check == "1") {
            $notify_check = '1';
        } else {
            $notify_check = '0';
        }
        if (isset($print_bleed) && $print_bleed == "1") {
            $print_bleed = '1';
        } else {
            $print_bleed = '0';
        }


        $data = array(
            'size' => '1',
            'type' => $template_type,
            'template_name' => $title,
            'title' => $title,
            'description' => $description,
            'source' => '1',
            'theme_size_id' => '0',
            'company_id' => $company_id,
            'background_image' => $background,
            'height' => $height,
            'width' => $width,
            'is_publish' => 0,
            'print_bleed' => $print_bleed
        );
        $return = array();
        if ($template_id && $template_id != "") {

            $query = $this->db->get_where(TEMPLATES, array('id' => $template_id));
            if ($query->num_rows() > 0) {
                if ($this->db->update(TEMPLATES, $data, array('id' => $template_id))) {
                    $last_id = $template_id;
                    $modify_data = array(
                        'template_id' => $last_id,
                        'user_id' => $current_user->user_id,
                        'modify_date' => date('Y-m-d h:i:s')
                    );
                    $this->db->insert(TEMPLATE_HISTORY, $modify_data);
                    $groups = $this->input->post('groups');
                    if (isset($groups) && !empty($groups) && count($groups) > 0) {
                        $this->db->delete(TEMPLATE_GROUPS, array('template_id' => $last_id));
                        foreach ($groups as $value) {

                            $data1 = array(
                                'group_id' => $value,
                                'template_id' => $last_id,
                                'created_on' => date('Y-m-d h:i:s')
                            );
                            $this->db->insert(TEMPLATE_GROUPS, $data1);
                        }
                    }
                    return $this->get_template_elements($last_id, $return, $template_type, $notify_check);
                } else {
                    return json_encode($return);
                }
            }
        } else {
            $query = $this->db->get_where(TEMPLATES, array('id' => $template_id));
            if ($query->num_rows() == 0) {
                if ($this->db->insert(TEMPLATES, $data)) {
                    $last_id = $this->db->insert_id();
                    $modify_data = array(
                        'template_id' => $last_id,
                        'user_id' => $current_user->user_id,
                        'modify_date' => date('Y-m-d h:i:s')
                    );
                    $this->db->insert(TEMPLATE_HISTORY, $modify_data);
                    $groups = $this->input->post('groups');
                    if (isset($groups) && !empty($groups) && count($groups) > 0) {
                        foreach ($groups as $value) {
                            $this->db->select('*');
                            $this->db->from(TEMPLATE_GROUPS);
                            $this->db->where('group_id', $value);
                            $this->db->where('template_id', $last_id);
                            $query = $this->db->get();

                            if ($query->num_rows() == 0) {
                                $data1 = array(
                                    'group_id' => $value,
                                    'template_id' => $last_id,
                                    'created_on' => date('Y-m-d h:i:s')
                                );
                                $this->db->insert(TEMPLATE_GROUPS, $data1);
                            }
                        }
                    }
                    return $this->get_template_elements($last_id, $return, $template_type, $notify_check);
                } else {
                    return json_encode($return);
                }
            }
        }

//        $sql = "update dim_template_sections set width=$width,height=$height,background_image='$background' where id = $section_id";
//        mysql_query($sql);
    }

    function get_template_elements($last_id, $return = array(), $template_type, $notify_check) {

        $sql = "select * from " . TEMPLATE_DATA_POINTS . " dtdp left join " . DATA_POINTS . " mdp on dtdp.data_point_id=mdp.id where dtdp.template_type_id = $template_type";

        $query = $this->db->query($sql);

        foreach ($query->result_array() as $data) {
            $return[] = $data;
        }
        $template_array = array(
            'id' => $last_id,
            'notify_check' => $notify_check,
            'template_data_points' => $return
        );
        return json_encode($template_array);
    }

    function save_custom_template() {
        $current_user = $this->ion_auth->user()->row();
        $custom_template_id = $this->input->post('custom_template_id');
        $savedraft = $this->input->post('savedraft');
        $notify = $this->input->post('notify');
        if (isset($notify) && $notify == "1") {
            $notify_check = '1';
        } else {
            $notify_check = '0';
        }

        if ($custom_template_id) {
            $query = $this->db->get_where(TEMPLATE_ELEMENTS, array('template_id' => $custom_template_id));
            if ($query->num_rows() > 0) {
                $this->db->delete(TEMPLATE_ELEMENTS, array('template_id' => $custom_template_id));
            }
        }
        $element_name = $this->input->post('element_name');
        $parent_element_name = $this->input->post('parent_element_name');
        $element_type = $this->input->post('element_type');
        $cord_x = $this->input->post('cord_x');
        $cord_y = $this->input->post('cord_y');
        $font_settings = $this->input->post('font_settings');
        $color = $this->input->post('color');
        $settings = $this->input->post('settings');
        $data_point_id = $this->input->post('data_point_id');
        $data_point_category = $this->input->post('data_point_category');
        $is_active = $this->input->post('is_active');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $company_feature = $this->input->post('company_feature');

        foreach ($element_name as $key => $val) {

            $start = 0;
            $stop = 0;
            if (isset($start[$key])) {
                $start = $start[$key];
                $stop = $end[$key];
            }


            // Attempt insert query execution
            $data = array(
                'template_id' => $custom_template_id,
                'element_name' => isset($element_name[$key]) && $element_name[$key] != "" ? $element_name[$key] : '',
                'parent_element_name' => isset($parent_element_name[$key]) ? $parent_element_name[$key] : '',
                'element_type' => isset($element_type[$key]) && $element_type[$key] != "" ? $element_type[$key] : '',
                'color' => isset($color[$key]) && $color[$key] != "" ? $color[$key] : '',
                'settings' => isset($settings[$key]) && $settings[$key] != "" ? $settings[$key] : '',
                'font_settings' => isset($font_settings[$key]) && $font_settings[$key] != "" ? $font_settings[$key] : '',
                'cord_x' => isset($cord_x[$key]) && $cord_x[$key] != "" ? $cord_x[$key] : '',
                'cord_y' => isset($cord_y[$key]) && $cord_y[$key] != "" ? $cord_y[$key] : '',
                'data_point_id' => isset($data_point_id[$key]) && $data_point_id[$key] != "" ? $data_point_id[$key] : '',
                'data_point_category' => isset($data_point_category[$key]) && $data_point_category[$key] != "" ? $data_point_category[$key] : '',
                'is_active' => isset($is_active[$key]) && $is_active[$key] != "" ? $is_active[$key] : '',
                'start' => $start,
                'stop' => $stop
            );

            if ($this->db->insert(TEMPLATE_ELEMENTS, $data)) {
                if ($element_type[$key] != "" && $element_type[$key] == '4') {
                    $data1 = array(
                        'template_id' => $custom_template_id,
                        'element_content' => $company_feature,
                        'element_type' => $element_type[$key]
                    );
                    $this->db->insert(TEMPLATE_COMPANY_ELEMENTS, $data1);
                }
                $flag = true;
            } else {
                $flag = false;
            }
        }
        if ($flag) {
            $data = $this->input->post('dataimgcontent');
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $UploadDirectory = ASSETS_PATH . '/upload/export/';
            $img = $custom_template_id . '.jpeg';
            file_put_contents($UploadDirectory . $img, $data);
            
            $image_path = ASSETS_URL . 'upload/export/'.$img;
            $img_data = getimagesize($image_path);
            $filename = 'upload/export/'.basename($image_path);
            $fileinput = file_get_contents($image_path);
            if ($this->upload_on_s3($fileinput, $img_data['mime'], $filename)) {
                //  unlink($image_path);
            }
            if (isset($savedraft) && $savedraft == '0') {
                $this->db->update(TEMPLATES, array('is_publish' => 0, 'preview_img' => $img), array('id' => $custom_template_id));
            } else {
                $this->db->update(TEMPLATES, array('is_publish' => 1, 'preview_img' => $img), array('id' => $custom_template_id));
                if ($notify_check == '1' || $notify_check == 1) {
                    $template_detail = $this->get_templates(false, $custom_template_id);

                    /*
                     * insert template notification to user
                     */
                    $template_id = $this->encrypt->encode($template_detail[0]->id);
                    $template_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $template_id);
                    $notification_data = array(
                        "notification_msg" => "A new template with name <strong>" . $template_detail[0]->title . "</strong> added in group <strong>" . $template_detail[0]->t_group . "</strong>",
                        "url" => "user_edit_template/" . $template_id,
                        "added" => date("Y-m-d H:i:s")
                    );
                    $this->db->insert(NOTIFICATION, $notification_data);
                    $last_notification_id = $this->db->insert_id();

                    // notify group users by email
                    $sql = "select u.user_id,u.user_email,u.username,GROUP_CONCAT(g.group_name SEPARATOR ', ') as user_grp from " . USER_GROUPS . " ug inner join " . USERS . " u on u.user_id=ug.user_id inner join " . GROUPS . " g on g.group_id=ug.group_id where ug.group_id in (" . $template_detail[0]->t_group_id . ") and u.user_status=1 group by ug.user_id ";

                    $query = $this->db->query($sql);
                    $result = $query->result();
                    foreach ($result as $value) {
                        $message_content = $this->basic_model->get_mail_template('new_template');
                        $data = array(
                            'identity' => $value->username,
                            'groupname' => $value->user_grp,
                            'title' => $template_detail[0]->title,
                        );

                        if (isset($message_content) && !empty($message_content)) {
                            $mail_content = html_entity_decode($message_content->mail_template_content);
                            $message = str_replace("{{identity}}", $data['identity'], $mail_content);
                            $message = str_replace("{{groupname}}", $data['groupname'], $message);
                            $message = str_replace("{{title}}", $data['title'], $message);
                            $message = str_replace("{{siteurl}}", SITE_URL, $message);

                            $message = MAIL_HEADER . $message . MAIL_FOOTER;

                            $this->email->clear();
                            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                            $this->email->to($value->user_email);
                            $this->email->subject($message_content->mail_subject);
                            $this->email->message($message);

                            if ($this->email->send() == TRUE) {
                                
                            }
                        }
                        /*
                         *  Added data notification user
                         */
                        $notification_user_data = array(
                            "notification_id" => $last_notification_id,
                            "user_id" => $value->user_id,
                            "read_status" => '0',
                        );
                        $this->db->insert(NOTIFICATION_USER, $notification_user_data);
                    }
                }
            }

            $image_path = TEMPLATE_PATH . $template_detail[0]->background_image;
            $img_data = getimagesize($image_path);
            $filename = 'upload/templates/png/'.basename($image_path);
            $fileinput = file_get_contents(ASSETS_URL . 'upload/templates/' . $template_detail[0]->background_image);
            if ($this->upload_on_s3($fileinput, $img_data['mime'], $filename)) {
                //  unlink(ASSETS_PATH . 'upload/templates/' . $template_detail[0]->background_image);
            }
        }

        return $flag;
    }

    function get_templates($companyid = false, $template_id = false) {
        $this->db->select('t.*,tt.id as type_id,tt.type,tt.category,GROUP_CONCAT(mg.group_name SEPARATOR ", ") as t_group,GROUP_CONCAT(mg.group_id) as t_group_id');
        $this->db->from(TEMPLATES . ' t');
        $this->db->join(TEMPLATE_TYPES . ' tt', 'tt.id=t.type', 'inner');
        $this->db->join(TEMPLATE_GROUPS . ' tg', 'tg.template_id=t.id', 'inner');
        $this->db->join('brandize_mst_groups mg', 'mg.group_id=tg.group_id', 'inner');
        if ($companyid) {

            $this->db->where('t.company_id', $companyid);
            $this->db->group_by('tg.template_id');
            $this->db->order_by('t.id', 'desc');
        }
        if ($template_id) {
            $this->db->where('t.id', $template_id);
        }
        //  $this->db->where('is_publish', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result();
        } else {
            $return = false;
        }
        return $return;
    }

    function get_custom_template_elements($template_id = false) {
        $this->db->select('*');
        $this->db->from(TEMPLATE_ELEMENTS);
        if ($template_id) {
            $this->db->where('template_id', $template_id);
            $this->db->where('parent_element_name=""');
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_company_features($company_id) {
        $this->db->select('feature_id,feature_title, REPLACE(feature_description, "\r\n", "<br>") as feature_description,feature_icon,feature_company_id,feature_status');
        $query = $this->db->get_where(COMPANY_FEATURES, array('feature_company_id' => $company_id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_company_features1($company_id) {
        $this->db->select('feature_id,feature_title, feature_description,feature_icon,feature_company_id,feature_status');
        $query = $this->db->get_where(COMPANY_FEATURES, array('feature_company_id' => $company_id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    
    function get_company_bullets($company_id) {
        $this->db->select('bullet_detail');
        $query = $this->db->get_where(COMPANY_BULLETS, array('bullet_company_id' => $company_id));
        if ($query->num_rows() > 0) {
            $bullets = array();
            foreach($query->result() as $value){
                $bullets[]=$value->bullet_detail;
            }
            return $bullets;
        } else {
            return array();
        }
    }
    function get_user_templates($user_id) {
        if ($user_id) {
            $sql = "SELECT t.*,(select type from " . TEMPLATE_TYPES . " where id=t.type) as t_type ,(select category from " . TEMPLATE_TYPES . " where id=t.type) as t_category  FROM " . TEMPLATES . " t WHERE is_publish =1 and is_active=1 and id IN (SELECT template_id FROM " . TEMPLATE_GROUPS . " WHERE group_id IN (SELECT group_id FROM `brandize_user_groups` WHERE user_id=$user_id)) order by t.id desc";

            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result();
            }
        }
    }
	function get_user_templates_admin($user_id) {
        if ($user_id) {
            $sql = "SELECT t.*,(select type from " . TEMPLATE_TYPES . " where id=t.type) as t_type ,(select category from " . TEMPLATE_TYPES . " where id=t.type) as t_category  FROM " . TEMPLATES . " t WHERE  is_active=1 and id IN (SELECT template_id FROM " . TEMPLATE_GROUPS . " WHERE group_id IN (SELECT group_id FROM `brandize_user_groups` WHERE user_id=$user_id)) order by t.id desc";

            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result();
            }
        }
    }

    function get_personalize_templates($template_id = false) {
        $sql = 'select * from ' . TEMPLATE_ELEMENTS . ' where is_active=1  and template_id = ' . $template_id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function get_user_template_elements($template_id = false) {
        $sql = 'select * from ' . TEMPLATE_ELEMENTS . ' where is_active=1 and parent_element_name=\'\' and template_id = ' . $template_id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function get_personalise_elements($parent_element, $template_id, $element_type) {

        $sql = 'select * from ' . TEMPLATE_ELEMENTS . ' where is_active=1 and parent_element_name=\'' . $parent_element . '\' and template_id = ' . $template_id;

        $query = $this->db->query($sql);
        $t_array = array();
        if ($query->num_rows() > 0) {
            $sql = 'select * from ' . TEMPLATE_COMPANY_ELEMENTS . ' where  element_type=' . $element_type . ' and template_id = ' . $template_id;
            $query1 = $this->db->query($sql);
            $t_array['t_element'] = $query->result_array();
            $t_array['t_company_elements'] = $query1->result_array();
        }
        return $t_array;
    }

    function get_template_size() {
        $sql = 'select ' . THEME_SIZES . '.*,' . SIZES . '.id size_id,' . SIZES . '.display_size display_size from ' . THEME_SIZES . ' left join ' . SIZES . ' on ' . SIZES . '.id = ' . THEME_SIZES . '.size_id where template_type_id = ' . $_POST['type'] . ' group by ' . SIZES . '.id';
        $query = $this->db->query($sql);
        $template_types = $query->result_array();
        $html = '<option value="">Select Size</option>';
        foreach ($template_types as $template_type) {
            $html .= '<option value="' . $template_type['size_id'] . '">' . $template_type['display_size'] . '</option>';
        }
        return $html;
    }

    function get_themes() {
        $sql = 'select ' . THEME_SIZES . '.*,' . THEMES . '.id theme_id,' . THEMES . '.theme_name theme_name from ' . THEME_SIZES . ' left join ' . THEMES . ' on ' . THEMES . '.id = ' . THEME_SIZES . '.theme_id where template_type_id = ' . $_POST['type'] . ' and size_id = ' . $_POST['size'];
        $query = $this->db->query($sql);
        $template_types = $query->result_array();
        $html = '<option value="">Select Theme</option>';
        foreach ($template_types as $template_type) {
            $html .= '<option value="' . $template_type['id'] . '">' . $template_type['theme_name'] . '</option>';
        }
        return $html;
    }

    function load_default_themes() {
        if (isset($_POST['template_id']) && $_POST['template_id'] != 0) {
            $template_id = $_POST['template_id'];
            $sql = 'select
            ts.bg_x, 
            ts.bg_y, 
            ts.bg_height, 
            ts.bg_width, 
            ts.theme_id, 
            ts.size_id, 
            ts.template_type_id, 
            ts.art_work_url, 
            ts.logo_x, 
            ts.logo_y, 
            ts.logo_height, 
            ts.logo_width, 
            ts.art_work_url, 
            
            tps.bg_img_x bgimg_x, 
            tps.bg_img_y bgimg_y, 
            tps.bg_img_h bgimg_height, 
            tps.bg_img_w bgimg_width,  
            tps.font1,  
            tps.font2,
            
            tps.logo_img_x logoimg_x, 
            tps.logo_img_y logoimg_y, 
            tps.logo_img_h logoimg_height, 
            tps.logo_img_w logoimg_width, 
            tps.background_url default_bg, 
            tps.logo_url default_logo, 
            
                s.height,s.width,s.unit,s.dpi,
                tps.color1,tps.color2,tps.color3,tps.color4
                    from ' . TEMPLATES . ' t
                    left join ' . TEMPLATE_SETTINGS . ' tps on t.id = tps.template_id
                    left join ' . THEME_SIZES . ' ts on t.theme_size_id = ts.id
                    left join ' . SIZES . ' s on s.id = ts.size_id
                    left join ' . THEMES . ' th on th.id = ts.theme_id
                    where 
                    t.id = ' . $_POST['template_id'];

            $query = $this->db->query($sql);
            $template = $query->result_array();
            $template = $template[0];
            $template['art_work_url_content'] = trim($template['art_work_url']) != '' ? file_get_contents(ASSETS_URL . $template['art_work_url']) : '';
            $sql = 'select * from ' . TEMPLATE_ELEMENTS . ' where parent_element_name=\'\' and template_id = ' . $_POST['template_id'];
            $query = $this->db->query($sql);
            $result = $query->result_array();
            $template['template_elements'] = array();
            foreach ($result as $template_elements) {
                $template['template_elements'][] = $template_elements;
            }
            echo json_encode($template);
        } else {
            $sql = 'select  ' . THEME_SIZES . '.*,
                ' . SIZES . '.height,' . SIZES . '.width,' . SIZES . '.unit,' . SIZES . '.dpi,
                ' . THEMES . '.color1,' . THEMES . '.color2,' . THEMES . '.color3,' . THEMES . '.color4
        from ' . THEME_SIZES . '
        left join ' . SIZES . ' on ' . SIZES . '.id = ' . THEME_SIZES . '.size_id
        left join ' . THEMES . ' on ' . THEMES . '.id = ' . THEME_SIZES . '.theme_id
        where
        ' . THEME_SIZES . '.id = ' . $_POST['theme_size_id'];
            $query = $this->db->query($sql);
            $template = $query->result_array();
            $template = $template[0];

            //$template['art_work_url_content'] = trim(ASSETS_URL . $template['art_work_url']) != '' ? file_get_contents($this->get_s3url($template['art_work_url'])) : '';
            $template['art_work_url_content'] = trim($template['art_work_url']) != '' ? file_get_contents(ASSETS_URL . $template['art_work_url']) : '';

            $sql = 'select * from ' . THEME_ELEMENTS . ' where parent_element_name=\'\' and theme_size_id = ' . $_POST['theme_size_id'];
            $result1 = $this->db->query($sql);
            $result = $result1->result_array();
            $template['template_elements'] = array();
            foreach ($result as $template_elements) {
                $template['template_elements'][] = $template_elements;
            }
            return json_encode($template);
        }
    }

    function get_theme_child_elements() {
        $id = $_POST['id'];
        if (isset($_POST['template_id']) && $_POST['template_id'] != 0) {
            $sql = "select * from " . TEMPLATE_ELEMENTS . " a where parent_element_name=(select b.element_name from " . TEMPLATE_ELEMENTS . " b where b.id=$id )and template_id = " . $_POST['template_id'];
        } else {
            $sql = "select a.* from " . THEME_ELEMENTS . "  a where a.parent_element_name=(select b.element_name from " . THEME_ELEMENTS . " b where b.id=$id) and theme_size_id = " . $_POST['theme_size_id'];
        }
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $template['template_elements'] = array();
        foreach ($result as $template_elements) {
            $template['template_elements'][] = $template_elements;
        }
        return json_encode($template);
    }

    function save_design_template($company_id) {
        $current_user = $this->ion_auth->user()->row();
        $template_type = $this->input->post('template_type');
        $template_size = $this->input->post('template_size');
        $theme_size_id = $this->input->post('theme_type');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $bg_height = $this->input->post('bg_height');
        $bg_width = $this->input->post('bg_width');
        $notify_check = $this->input->post('notify_check');
        $template_id_edit = $this->input->post('template_id_edit');
        $savedraft = $this->input->post('savedraft');
        $print_bleed = $this->input->post('print_bleed');

        if (isset($notify_check) && $notify_check == "1") {
            $notify_check = '1';
        } else {
            $notify_check = '0';
        }
        if (isset($print_bleed) && $print_bleed == "1") {
            $print_bleed = '1';
        } else {
            $print_bleed = '0';
        }

        $data = array(
            'source' => 2,
            'size' => $template_size,
            'type' => $template_type,
            'theme_size_id' => $theme_size_id,
            'template_name' => $title,
            'title' => $title,
            'description' => $description,
            'company_id' => $company_id,
            'height' => $bg_height,
            'width' => $bg_width,
            'print_bleed' => $print_bleed
        );

        if ($template_id_edit != "") {
            $this->db->update(TEMPLATES, $data, array('id' => $template_id_edit));
            $modify_data = array(
                'template_id' => $template_id_edit,
                'user_id' => $current_user->user_id,
                'modify_date' => date('Y-m-d h:i:s')
            );
            $this->db->insert(TEMPLATE_HISTORY, $modify_data);
            $groups = $this->input->post('groups');
            if (isset($groups) && !empty($groups) && count($groups) > 0) {
                $this->db->delete(TEMPLATE_GROUPS, array('template_id' => $template_id_edit));
                foreach ($groups as $value) {
                    $data1 = array(
                        'group_id' => $value,
                        'template_id' => $template_id_edit,
                        'created_on' => date('Y-m-d h:i:s')
                    );
                    $this->db->insert(TEMPLATE_GROUPS, $data1);
                }
            }
            $font1 = $this->input->post('font1');
            $font2 = $this->input->post('font2');

            $color1 = $this->input->post('color1');
            $color2 = $this->input->post('color2');
            $color3 = $this->input->post('color3');
            $color4 = $this->input->post('color4');

            $bg_url = $this->input->post('bg_url');
            $bg_width = $this->input->post('bg_width');
            $bg_height = $this->input->post('bg_height');
            $bg_left = $this->input->post('bg_left');
            $bg_top = $this->input->post('bg_top');
            $logo_url = $this->input->post('logo_url');
            $logo_width = $this->input->post('logo_width');
            $logo_height = $this->input->post('logo_height');
            $logo_left = $this->input->post('logo_left');
            $logo_top = $this->input->post('logo_top');
            $pdf = $this->input->post('pdf');
            $jpeg = $this->input->post('jpeg');
            $png = $this->input->post('png');
            $gif = $this->input->post('gif');
            $pdf = $pdf ? 1 : 0;
            $jpeg = $jpeg ? 1 : 0;
            $png = $png ? 1 : 0;
            $gif = $gif ? 1 : 0;

            $data = array(
                'font1' => $font1,
                'font2' => $font2,
                'color1' => $color1,
                'color2' => $color2,
                'color3' => $color3,
                'color4' => $color4,
                'background_url' => $bg_url,
                'bg_img_w' => $bg_width,
                'bg_img_h' => $bg_height,
                'bg_img_x' => $bg_left,
                'bg_img_y' => $bg_top,
                'logo_url' => $logo_url,
                'logo_img_w' => $logo_width,
                'logo_img_h' => $logo_height,
                'logo_img_x' => $logo_left,
                'logo_img_y' => $logo_top,
                'pdf_export' => $pdf,
                'jpeg_export' => $jpeg,
                'png_export' => $png,
                'gif_export' => $gif
            );

            $this->db->update(TEMPLATE_SETTINGS, $data, array('template_id' => $template_id_edit));

            $this->db->delete(TEMPLATE_ELEMENTS, array('template_id' => $template_id_edit));

            $element_name = $this->input->post('element_name');
            $parent_element_name = $this->input->post('parent_element_name');
            $element_type = $this->input->post('element_type');
            $cord_x = $this->input->post('cord_x');
            $cord_y = $this->input->post('cord_y');
            $font_settings = $this->input->post('font_settings');
            $color = $this->input->post('color');
            $settings = $this->input->post('settings');
            $data_point_id = $this->input->post('data_point_id');
            $data_point_category = $this->input->post('data_point_category');
            $is_active = $this->input->post('is_active');
            $start = $this->input->post('start');
            $stop = $this->input->post('end');
            $company_feature = $this->input->post('company_feature');
            $company_heading = $this->input->post('company_heading');
            foreach ($this->input->post('element_name') as $key => $val) {
                $element_name1 = $element_name[$key];
                $parent_element_name1 = $parent_element_name[$key];
                $element_type1 = $element_type[$key];
                $cord_x1 = $cord_x[$key];
                $cord_y1 = $cord_y[$key];
                $font_settings1 = isset($font_settings[$key]) ? $font_settings[$key] : '';
                $color1 = isset($color[$key]) ? $color[$key] : '';
                $settings1 = $settings[$key];
                $data_point_id1 = $data_point_id[$key];
                $data_point_category1 = $data_point_category[$key];
                $is_active1 = $is_active[$key];
                $start1 = 0;
                $stop1 = 0;
                if (isset($start[$key])) {
                    $start1 = $start[$key];
                    $stop1 = $stop[$key];
                }


                // Attempt insert query execution

                $data = array(
                    'template_id' => $template_id_edit,
                    'element_name' => $element_name1,
                    'parent_element_name' => $parent_element_name1,
                    'element_type' => $element_type1,
                    'color' => $color1,
                    'settings' => $settings1,
                    'font_settings' => $font_settings1,
                    'cord_x' => $cord_x1,
                    'cord_y' => $cord_y1,
                    'data_point_id' => $data_point_id1,
                    'data_point_category' => $data_point_category1,
                    'is_active' => $is_active1
                );
                if ($this->db->insert(TEMPLATE_ELEMENTS, $data)) {
                    if ($element_type[$key] != "" && $element_type[$key] == '4') {
                        $data1 = array(
                            'template_id' => $template_id_edit,
                            'element_content' => $company_feature,
                            'element_type' => $element_type[$key]
                        );
                        $this->db->insert(TEMPLATE_COMPANY_ELEMENTS, $data1);
                    }
                    $template_id = $template_id_edit;
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
        } else {
            if ($this->db->insert(TEMPLATES, $data)) {
                $template_id = $this->db->insert_id();
                $modify_data = array(
                    'template_id' => $template_id,
                    'user_id' => $current_user->user_id,
                    'modify_date' => date('Y-m-d h:i:s')
                );
                $this->db->insert(TEMPLATE_HISTORY, $modify_data);
                $groups = $this->input->post('groups');
                if (isset($groups) && !empty($groups) && count($groups) > 0) {
                    foreach ($groups as $value) {
                        $this->db->select('*');
                        $this->db->from(TEMPLATE_GROUPS);
                        $this->db->where('group_id', $value);
                        $this->db->where('template_id', $template_id);
                        $query = $this->db->get();

                        if ($query->num_rows() == 0) {
                            $data1 = array(
                                'group_id' => $value,
                                'template_id' => $template_id,
                                'created_on' => date('Y-m-d h:i:s')
                            );
                            $this->db->insert(TEMPLATE_GROUPS, $data1);
                        }
                    }
                }

                $font1 = $this->input->post('font1');
                $font2 = $this->input->post('font2');

                $color1 = $this->input->post('color1');
                $color2 = $this->input->post('color2');
                $color3 = $this->input->post('color3');
                $color4 = $this->input->post('color4');

                $bg_url = $this->input->post('bg_url');
                $bg_width = $this->input->post('bg_width');
                $bg_height = $this->input->post('bg_height');
                $bg_left = $this->input->post('bg_left');
                $bg_top = $this->input->post('bg_top');
                $logo_url = $this->input->post('logo_url');
                $logo_width = $this->input->post('logo_width');
                $logo_height = $this->input->post('logo_height');
                $logo_left = $this->input->post('logo_left');
                $logo_top = $this->input->post('logo_top');
                $pdf = $this->input->post('pdf');
                $jpeg = $this->input->post('jpeg');
                $png = $this->input->post('png');
                $gif = $this->input->post('gif');
                $pdf = $pdf ? 1 : 0;
                $jpeg = $jpeg ? 1 : 0;
                $png = $png ? 1 : 0;
                $gif = $gif ? 1 : 0;

                $data = array(
                    'font1' => $font1,
                    'font2' => $font2,
                    'color1' => $color1,
                    'color2' => $color2,
                    'color3' => $color3,
                    'color4' => $color4,
                    'background_url' => $bg_url,
                    'bg_img_w' => $bg_width,
                    'bg_img_h' => $bg_height,
                    'bg_img_x' => $bg_left,
                    'bg_img_y' => $bg_top,
                    'logo_url' => $logo_url,
                    'logo_img_w' => $logo_width,
                    'logo_img_h' => $logo_height,
                    'logo_img_x' => $logo_left,
                    'logo_img_y' => $logo_top,
                    'pdf_export' => $pdf,
                    'jpeg_export' => $jpeg,
                    'png_export' => $png,
                    'gif_export' => $gif,
                    'template_id' => $template_id
                );

                $this->db->insert(TEMPLATE_SETTINGS, $data);
//         $sql = "delete from '.TEMPLATE_ELEMENTS.' where template_id = $template_id";
//        mysql_query($sql);
                $element_name = $this->input->post('element_name');
                $parent_element_name = $this->input->post('parent_element_name');
                $element_type = $this->input->post('element_type');
                $cord_x = $this->input->post('cord_x');
                $cord_y = $this->input->post('cord_y');
                $font_settings = $this->input->post('font_settings');
                $color = $this->input->post('color');
                $settings = $this->input->post('settings');
                $data_point_id = $this->input->post('data_point_id');
                $data_point_category = $this->input->post('data_point_category');
                $is_active = $this->input->post('is_active');
                $start = $this->input->post('start');
                $stop = $this->input->post('end');
                $company_feature = $this->input->post('company_feature');
                $company_heading = $this->input->post('company_heading');
                foreach ($this->input->post('element_name') as $key => $val) {
                    $element_name1 = $element_name[$key];
                    $parent_element_name1 = $parent_element_name[$key];
                    $element_type1 = $element_type[$key];
                    $cord_x1 = $cord_x[$key];
                    $cord_y1 = $cord_y[$key];
                    $font_settings1 = isset($font_settings[$key]) ? $font_settings[$key] : '';
                    $color1 = isset($color[$key]) ? $color[$key] : '';
                    $settings1 = $settings[$key];
                    $data_point_id1 = $data_point_id[$key];
                    $data_point_category1 = $data_point_category[$key];
                    $is_active1 = $is_active[$key];
                    $start1 = 0;
                    $stop1 = 0;
                    if (isset($start[$key])) {
                        $start1 = $start[$key];
                        $stop1 = $stop[$key];
                    }


                    // Attempt insert query execution

                    $data = array(
                        'template_id' => $template_id,
                        'element_name' => $element_name1,
                        'parent_element_name' => $parent_element_name1,
                        'element_type' => $element_type1,
                        'color' => $color1,
                        'settings' => $settings1,
                        'font_settings' => $font_settings1,
                        'cord_x' => $cord_x1,
                        'cord_y' => $cord_y1,
                        'data_point_id' => $data_point_id1,
                        'data_point_category' => $data_point_category1,
                        'is_active' => $is_active1
                    );
                    if ($this->db->insert(TEMPLATE_ELEMENTS, $data)) {
                        if ($element_type[$key] != "" && $element_type[$key] == '4') {
                            $data1 = array(
                                'template_id' => $template_id,
                                'element_content' => $company_feature,
                                'element_type' => $element_type[$key]
                            );
                            $this->db->insert(TEMPLATE_COMPANY_ELEMENTS, $data1);
                        }

                        $flag = true;
                    } else {
                        $flag = false;
                    }
                }
            }
        }
        if ($flag) {

            $data = $this->input->post('dataimgcontent');
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $UploadDirectory = ASSETS_PATH . '/upload/export/';
            $img = $template_id . '.jpeg';
            file_put_contents($UploadDirectory . $img, $data);
            //s3 upload
            $image_path = ASSETS_URL . 'upload/export/'.$img;
            $img_data = getimagesize($image_path);
            $filename = 'upload/export/'.basename($image_path);
            $fileinput = file_get_contents($image_path);
            if ($this->upload_on_s3($fileinput, $img_data['mime'], $filename)) {
                //  unlink($image_path);
            }
            
            if (isset($savedraft) && $savedraft == '0') {
                $this->db->update(TEMPLATES, array('is_publish' => 0, 'preview_img' => $img), array('id' => $template_id));
            } else {
                $this->db->update(TEMPLATES, array('is_publish' => 1, 'preview_img' => $img), array('id' => $template_id));
                if ($notify_check == '1' || $notify_check == 1) {
                    $template_detail = $this->get_templates(false, $template_id);
                    /*
                     * insert template notification to user
                     */
                    $template_id = $this->encrypt->encode($template_detail[0]->id);
                    $template_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $template_id);
                    $notification_data = array(
                        "notification_msg" => "A new template with name <strong>" . $template_detail[0]->title . "</strong> added in group <strong>" . $template_detail[0]->t_group . "</strong>",
                        "url" => "user_design_template/" . $template_id,
                        "added" => date("Y-m-d H:i:s")
                    );
                    $this->db->insert(NOTIFICATION, $notification_data);
                    $last_notification_id = $this->db->insert_id();

                    // notify group users by email

                    $sql = "select u.user_id,u.user_email,u.username,GROUP_CONCAT(g.group_name SEPARATOR ', ') as user_grp from " . USER_GROUPS . " ug inner join " . USERS . " u on u.user_id=ug.user_id inner join " . GROUPS . " g on g.group_id=ug.group_id where ug.group_id in (" . $template_detail[0]->t_group_id . ") and u.user_status=1 group by ug.user_id ";

                    $query = $this->db->query($sql);
                    $result = $query->result();

                    foreach ($result as $value) {
                        $message_content = $this->basic_model->get_mail_template('new_template');
                        $data = array(
                            'identity' => $value->username,
                            'groupname' => $value->user_grp,
                            'title' => $template_detail[0]->title,
                        );

                        if (isset($message_content) && !empty($message_content)) {
                            $mail_content = html_entity_decode($message_content->mail_template_content);
                            $message = str_replace("{{identity}}", $data['identity'], $mail_content);
                            $message = str_replace("{{groupname}}", $data['groupname'], $message);
                            $message = str_replace("{{title}}", $data['title'], $message);
                            $message = str_replace("{{siteurl}}", SITE_URL, $message);

                            $message = MAIL_HEADER . $message . MAIL_FOOTER;

                            $this->email->clear();
                            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                            $this->email->to($value->user_email);
                            $this->email->subject($message_content->mail_subject);
                            $this->email->message($message);

                            if ($this->email->send() == TRUE) {
                                
                            }

                            /*
                             *  Added data notification user
                             */
                            $notification_user_data = array(
                                "notification_id" => $last_notification_id,
                                "user_id" => $value->user_id,
                                "read_status" => '0',
                            );
                            $this->db->insert(NOTIFICATION_USER, $notification_user_data);
                        }
                    }
                }
            }
        }

        return true;
    }

    function get_design_template_elements($template_id = false) {
        $sql = 'select ' . TEMPLATE_ELEMENTS . '.*,' . DATA_POINTS . '.input_type from ' . TEMPLATE_ELEMENTS . ' left join ' . DATA_POINTS . ' on ' . DATA_POINTS . '.id=' . TEMPLATE_ELEMENTS . '.data_point_id where is_active=1 and parent_element_name=\'\' and template_id = ' . $template_id;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_design_templates($template_id = false) {
        $sql = 'select mt.*, ms.height,ms.width, ms.unit,ms.dpi, mts.bg_x,mts.bg_y, mts.bg_height, mts.bg_width, mts.art_work_url, mts.logo_x,mts.logo_y, mts.logo_height, mts.logo_width,
    dts.background_url, dts.logo_url, dts.color1, dts.color2, dts.color3, dts.color4, dts.bg_img_x, dts.bg_img_y, dts.bg_img_w, dts.bg_img_h, dts.logo_img_x, dts.logo_img_y, dts.logo_img_w, dts.logo_img_h, dts.font1, dts.font2, dts.pdf_export, dts.png_export, dts.jpeg_export, dts.gif_export
    from ' . TEMPLATES . ' mt
    left join ' . THEME_SIZES . ' mts on mts.id = mt.theme_size_id
    left join ' . SIZES . ' ms on mts.size_id = ms.id    left join ' . TEMPLATE_SETTINGS . ' dts on dts.template_id=mt.id where mt.id = ' . $template_id;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_headlines_drop($company_id) {
        $query = "select * from " . COMPANY_HEADING . " where company_id=" . $company_id;
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {
            $i = 0;
            foreach ($result as $json) {
                $mjson[$i] = $json;
                $i++;
            }
            echo json_encode($mjson);
        } else {
            echo json_encode(array());
        }
    }

    function get_company_headlines_drop($company_id) {
        $query = "select * from " . COMPANY_HEADING . " where company_id=" . $company_id;

        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {
            $i = 0;
            foreach ($result as $json) {
                $mjson[$i] = $json;
                $i++;
            }
            return json_encode($mjson);
        }
    }

    function duplicate_template_data($template_id, $templatename) {
        $redirect = $this->input->post('redirect');
        if (isset($template_id) && $template_id > 0) {
            $check_query = "select * from " . TEMPLATES . " where id <>'" . $template_id . "' and template_name ='" . $templatename . "'";
            $check_sql = $this->db->query($check_query);
            $check_result = $check_sql->result_array();
            if (count($check_result) > 0) {
                $this->session->set_flashdata('error', "Template already exist with same name.");
                if ($redirect == 'dashboard') {
                    redirect(COMPANY_URL . "dashboard");
                } else {
                    redirect(TEMPLATE_URL . "templates");
                }
            }
            $collectdata = $this->db->query("select size,type,template_name,title,description,source,theme_size_id,company_id,background_color,background_image,height,width,video,preview_img,is_publish from " . TEMPLATES . " where id=" . $template_id);
            $result = $collectdata->result_array();
            if (count($result)) {
                $orig_id = $template_id;
                $data = $result[0];
                if ($data['title'] != $templatename) {
                    $source = $result[0]['source'];
                    // Duplicating original id
                    $data['title'] = $templatename;
					$data['is_publish'] = 0;
					
					$dup_template_1 = $this->db->insert(TEMPLATES, $data);
                    $new_id = $this->db->insert_id();
                    // Duplicating original Id Ends

                    $query2 = "select group_id,template_id,created_on from " . TEMPLATE_GROUPS . " where template_id=" . $orig_id;
                    $sql2 = $this->db->query($query2);
                    $result2 = $sql2->result_array();
                    if (count($result2)) {
                        foreach ($result2 as $newresult) {
                            $data = array();
                            $data['group_id'] = $newresult['group_id'];
                            $data['template_id'] = $new_id;
                            $data['created_on'] = date('Y-m-d h:i:s');
                            $this->db->insert(TEMPLATE_GROUPS, $data);
                        }
                    }
                    $query3 = "select section_id,element_name,parent_element_name,element_type,color,settings,font_settings,cord_x,cord_y,data_point_category,data_point_id,is_active,start,stop from " . TEMPLATE_ELEMENTS . " where template_id=" . $orig_id;
                    $sql3 = $this->db->query($query3);
                    $result3 = $sql3->result_array();
                    if (count($result3)) {
                        foreach ($result3 as $newresult1) {
                            $data = array();
                            $data = $newresult1;
                            $data['template_id'] = $new_id;
                            $this->db->insert(TEMPLATE_ELEMENTS, $data);
                        }
                    }

                    $query4 = "select element_content,element_type,company_id from " . TEMPLATE_COMPANY_ELEMENTS . " where template_id=" . $orig_id;
                    $sql4 = $this->db->query($query4);
                    $result4 = $sql4->result_array();
                    if (count($result4)) {
                        foreach ($result4 as $newresult4) {
                            $data = array();
                            $data = $newresult4;
                            $data['template_id'] = $new_id;
                            $this->db->insert(TEMPLATE_COMPANY_ELEMENTS, $data);
                        }
                    }
                    if ($source == "2") {
                        $sql5 = $this->db->query("select background_url,color1,color2,color3,color4,bg_img_x,bg_img_y,bg_img_w,bg_img_h,logo_url,logo_img_x,logo_img_y,logo_img_w,logo_img_h,font1,font2,jpeg_export,png_export,pdf_export,gif_export from " . TEMPLATE_SETTINGS . " where template_id=" . $orig_id);
                        $result5 = $sql5->result_array();
                        if (count($result5)) {
                            foreach ($result5 as $newresult5) {
                                $data = array();
                                $data = $newresult5;
                                $data['template_id'] = $new_id;
                                $this->db->INSERT(TEMPLATE_SETTINGS, $data);
                            }
                        }
                    }
                    $this->session->set_flashdata('message', "Duplicate Template created Successfully.");
                    if ($redirect == 'dashboard') {
                        redirect(COMPANY_URL . "dashboard");
                    } else {
                        redirect(TEMPLATE_URL . "templates");
                    }
                } else {
                    $this->session->set_flashdata('error', "Template already exist with same name.");
                    if ($redirect == 'dashboard') {
                        redirect(COMPANY_URL . "dashboard");
                    } else {
                        redirect(TEMPLATE_URL . "templates");
                    }
                }
            }
        }


        if (isset($template_id) && $template_id > 0) {
            $collectdata = $this->db->query("select size,type,template_name,title,description,source,theme_size_id,company_id,background_color,background_image,height,width,video,is_publish from " . TEMPLATES . " where id=" . $template_id);
            $result = $collectdata->result_array();
            if (count($result)) {
                $orig_id = $template_id;
                $data = $result[0];
                if ($data['title'] != $templatename) {
                    // Duplicating original id
                    $data['title'] = $templatename;
                    $data['is_publish'] = 0;
                    $dup_template_1 = $this->db->insert(TEMPLATES, $data);
                    $new_id = $this->db->insert_id();
                    // Duplicating original Id Ends
                    $query2 = "select group_id,template_id,created_on from " . TEMPLATE_GROUPS . " where template_id=" . $orig_id;
                    $sql2 = $this->db->query($query2);
                    $result2 = $sql2->result_array();
                    if (count($result2)) {
                        foreach ($result2 as $newresult) {
                            $data = array();
                            $data['group_id'] = $newresult['group_id'];
                            $data['template_id'] = $new_id;
                            $data['created_on'] = date('Y-m-d h:i:s');
                            $this->db->insert(TEMPLATE_GROUPS, $data);
                        }
                    }
                    $query3 = "select section_id,element_name,parent_element_name,element_type,color,settings,font_settings,cord_x,cord_y,data_point_category,data_point_id,is_active,start,stop from " . TEMPLATE_ELEMENTS . " where template_id=" . $orig_id;
                    $sql3 = $this->db->query($query3);
                    $result3 = $sql3->result_array();
                    if (count($result3)) {
                        foreach ($result3 as $newresult1) {
                            $data = array();
                            $data = $newresult1;
                            $data['template_id'] = $new_id;
                            $this->db->insert(TEMPLATE_ELEMENTS, $data);
                        }
                    }

                    $query4 = "select element_content,element_type,company_id from " . TEMPLATE_COMPANY_ELEMENTS . " where template_id=" . $orig_id;
                    $sql4 = $this->db->query($query4);
                    $result4 = $sql4->result_array();
                    if (count($result4)) {
                        foreach ($result4 as $newresult4) {
                            $data = array();
                            $data = $newresult4;
                            $data['template_id'] = $new_id;
                            $this->db->insert(TEMPLATE_COMPANY_ELEMENTS, $data);
                        }
                    }
                    $this->session->set_flashdata('message', "Successfully duplicate the template.");
                    if ($redirect == 'dashboard') {
                        redirect(COMPANY_URL . "dashboard");
                    } else {
                        redirect(TEMPLATE_URL . "templates");
                    }
                } else {
                    $this->session->set_flashdata('error', "Template already exist with same name.");
                    if ($redirect == 'dashboard') {
                        redirect(COMPANY_URL . "dashboard");
                    } else {
                        redirect(TEMPLATE_URL . "templates");
                    }
                }
            }
        }
    }

    function delete_template() {
        $template_id = $this->input->post('template_id');
        $query = $this->db->get_where(TEMPLATES, array('id' => $template_id));
        $result = $query->result();
        $result = $result[0];
        if (count($result) > 0) {
            if ($result->source == '1') {
                $this->db->delete(TEMPLATE_GROUPS, array('template_id' => $template_id));
                $this->db->delete(TEMPLATE_ELEMENTS, array('template_id' => $template_id));
                $this->db->delete(TEMPLATE_COMPANY_ELEMENTS, array('template_id' => $template_id));
                $this->db->delete(TEMPLATES, array('id' => $template_id));
                unlink(ASSETS_PATH . 'upload/templates/' . $result->background_image);
                unlink(ASSETS_PATH . 'upload/export/' . $result->preview_img);
            } else {
                $this->db->delete(TEMPLATE_GROUPS, array('template_id' => $template_id));
                $this->db->delete(TEMPLATE_ELEMENTS, array('template_id' => $template_id));
                $this->db->delete(TEMPLATE_COMPANY_ELEMENTS, array('template_id' => $template_id));
                $this->db->delete(TEMPLATE_SETTINGS, array('template_id' => $template_id));
                $this->db->delete(TEMPLATES, array('id' => $template_id));
                unlink(ASSETS_PATH . 'upload/templates/' . $result->background_image);
                unlink(ASSETS_PATH . 'upload/export/' . $result->preview_img);
            }
            return true;
        }
    }

    function update_template_status() {
        $data = array(
            'is_active' => intval($this->input->post('status'))
        );
        if ($this->db->update(TEMPLATES, $data, "id=" . $this->input->post('t_id'))) {
            $this->session->set_flashdata('message', 'Status Updated Successfully.');
            return '1';
        } else {
            return '0';
        }
    }

    function get_mst_themes() {
        $this->db->select('*');
        $this->db->from(THEMES);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function check_title($templateid) {
        $data = array(
            'company_id' => $this->input->post('companyid'),
            'title' => $this->input->post('title'),
            'type' => $this->input->post('template_type'),
            'is_publish' => 1
        );
        if($templateid){
            $data['id']=$templateid;
        }
        $query = $this->db->get_where(TEMPLATES, $data);
        if ($query->num_rows() == 0) {
            return "true";
        } else {
            return "false";
        }
    }

    function upload_on_s3($fileinput, $file_type, $NewFileName) {
        $S3_KEY = AWS_S3_ACCESS_KEY;
        $S3_SECRET = AWS_S3_SECRET_KEY;
        $S3_BUCKET = AWS_S3_BUCKET;
        $EXPIRE_TIME = (60 * 10); // 10 minutes
        $S3_URL = AWS_S3_URL;
        $name = $NewFileName; //$_FILES['FileInput']['name'];
        $objectName = '/temp/' . urlencode($name);
        date_default_timezone_set("UTC");
        $mimeType = $file_type;

        $expires = time() + $EXPIRE_TIME;
        $amzHeaders = "x-amz-acl:private";
        $stringToSign = "PUT\n\n$mimeType\n$expires\n$amzHeaders\n$S3_BUCKET$objectName";
        $sig = urlencode(base64_encode(hash_hmac('sha1', $stringToSign, $S3_SECRET, true)));
        $url = ("$S3_URL$S3_BUCKET$objectName?AWSAccessKeyId=$S3_KEY&Expires=$expires&Signature=$sig");

        $base_path = str_ireplace("\\", "/", FCPATH);

        // $savename = $fileinput['name']; //'files/' . $folder . '/' . $fileid . '/' . $file['version'] . '/' . $data['name'];
        // $target_path = $base_path . "/temp/$target_filename";
        //$file_temp = file_get_contents($fileinput['tmp_name']);
        return $this->libs3->writeFile($name, $mimeType, $fileinput);
    }

    function get_s3url($filename) {
         $EXPIRE_TIME = (60 * 10); // 10 mins
         $expires = time() + $EXPIRE_TIME;
         $fileMeta = $this->libs3->getFileMeta($filename);
         $fileMeta = $fileMeta['mimetype'];
         $base64Image = file_get_contents($this->libs3->getAuthorisedUrl($filename, $expires));
         return  'data:'.$fileMeta.';base64,' . base64_encode($base64Image);
         
    }

    function get_savetemplates($companyid = false, $template_id = false) {
        $this->db->select('t.*,pt.file_path,tt.category,pt.created_on,pt.id');
        $this->db->from(TEMPLATES . ' t');
        $this->db->join(TEMPLATE_TYPES . ' tt', 'tt.id=t.type', 'inner');
        //$this->db->join(TEMPLATE_GROUPS . ' tg', 'tg.template_id=t.id', 'inner');
        $this->db->join(PERSONALIZE_TEMPLATE . ' pt', 'pt.template_id=t.id', 'inner');
        if ($companyid) {

            $this->db->where('t.company_id', $companyid);
            //$this->db->group_by('tg.template_id');
            $this->db->order_by('t.id', 'desc');
        }
        if ($template_id) {
            $this->db->where('t.id', $template_id);
        }
        $this->db->where('is_publish', 1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $return = $query->result();
        } else {
            $return = false;
        }
        return $return;
    }

    function get_design_theme_elements($template_id = false) {
        if ($template_id) {
            $sql = "select " . THEME_SIZES . ".* from " . TEMPLATES . " left join " . THEME_SIZES . " on " . TEMPLATES . ".theme_size_id = " . THEME_SIZES . ".id where " . TEMPLATES . ".id = $template_id";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
    }

    function get_selected_themesize($tt_id) {
        if ($tt_id) {
            $sql = 'select ' . THEME_SIZES . '.*,' . SIZES . '.id size_id,' . SIZES . '.display_size display_size from ' . THEME_SIZES . ' left join ' . SIZES . ' on ' . SIZES . '.id = ' . THEME_SIZES . '.size_id where template_type_id = ' . $tt_id . ' group by ' . SIZES . '.id';
            $query = $this->db->query($sql);
            return $query->result_array();
        }
    }

    function get_custom_feature_elements($template_id = false) {
        $this->db->select('*');
        $this->db->from(TEMPLATE_ELEMENTS);
        if ($template_id) {
            $this->db->where('template_id', $template_id);
            $this->db->where('parent_element_name!=""');
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_history($tempalte_id = false) {
        if ($tempalte_id) {
            $this->db->select('u.account_holder_name,u.username,DATE_FORMAT(th.modify_date,"%m/%d/%Y") as modify_date');
            $this->db->from(TEMPLATE_HISTORY . ' th');
            $this->db->join(USERS . ' u', 'u.user_id=th.user_id');
            $this->db->where('th.template_id', $tempalte_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return json_encode($query->result_array());
            } else {
                return json_encode(array());
            }
        }
    }

    function get_orig_file_name($template_id) {
        $query = "select origname from " . TEMPLATES . " where id=" . $template_id;
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result) > 0) {
            return $result[0]['origname'];
        }
    }

    function get_personalize_template($personalize_id = false) {
        if ($personalize_id) {
            $this->db->select('*');
            $this->db->from(PERSONALIZE_TEMPLATE);
            $this->db->where('id', $personalize_id);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $result = $query->result();
                return $result;
            }
        }
    }
    
    function delete_per_template(){
        $template_id = $this->input->post('template_id');
        $query = $this->db->get_where(PERSONALIZE_TEMPLATE, array('id' => $template_id));
        $result = $query->result();
        $result = $result[0];
        if (count($result) > 0) {
            $this->db->delete(PERSONALIZE_TEMPLATE, array('id' => $template_id));
            unlink(ASSETS_PATH . 'upload/export/' . $result->file_path);
            return true;
        }
        
    }
    

}
