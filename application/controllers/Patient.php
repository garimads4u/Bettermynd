<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language', 'email'));
        set_smtp_config();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $uri_segment = $this->uri->segment(2, 0);
        $this->load->model('college_model');
        $this->load->model('patient_model');
        $this->load->model('basic_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_type = $current_user->user_type;
            if ($user_type != 4) {
                if ($user_type == 2) {
                    redirect(COLLEGE_URL . "dashboard");
                } else if ($user_type == 3) {
                    redirect(PROVIDER_URL . "dashboard");
                } else if ($user_type == 1) {
                    redirect(SADMIN_URL . "dashboard");
                } else {
                    redirect(THIRD_PARTY_URL . "dashboard");
                }
            }
        }
        $this->basic_model->set_current_timezone();
    }

    function index() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            redirect(PATIENT_URL . "dashboard");
        }
    }

    function dashboard() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);

            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PATIENT_URL . "manage_profile");
            }

            $this->data = array();
            $campus_details = $this->basic_model->get_college_name($current_user->college_id);
            $this->data['campus_details'] = $campus_details;
            $this->load->model('sadmin_model');
            $limit = 10;
            $cond = array('college_id' => $current_user->college_id, 'type != ' => 0);
            $welcome = $this->sadmin_model->getwelcomeData($cond);

            $this->data['welcome_data'] = $welcome;
            $cond = array('type' => '0');
            $this->data['bettermynd_note_data'] = $this->sadmin_model->getwelcomeData($cond);

            $this->data['welcome_note'] = (isset($welcome->notes_detail) && !empty($welcome->notes_detail) ? $welcome->notes_detail : '');
            if ($welcome && isset($welcome->notes_id)) {
                $this->data['welcome_note_image'] = $this->sadmin_model->getwelcome_imageData(array('welcome_notes_id' => $welcome->notes_id));
            }

            $this->data['total_transaction_amount'] = $this->patient_model->get_total_transaction($current_user->user_id);
            $this->data['total_appointment'] = $this->patient_model->get_total_appointment($current_user->user_id);
            $this->data['own_provider'] = $this->patient_model->get_provider($current_user->user_id);
            $this->data['upcoming_appointment'] = $this->patient_model->get_upcoming_appointment($current_user->user_id, $limit);
            $this->load->model('message_model', 'message');
            $this->data['flashmessages'] = $this->message->get_flashmessages($current_user->college_id);
            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->headerdata['page_title'] = "Dashboard";
            $this->sidebardata['is_active'] = 'dashboard';
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            $this->elements['middle'] = 'patient/dashboard';
            $this->elements_data['middle'] = $this->data;

            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PATIENT_URL . "manage_profile");
                exit;
            }

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $appointments = $this->patient_model->get_patient_appointments($current_user->user_id);
            if (isset($appointments) && !empty($appointments)) {
                $this->data['appointments'] = $appointments;
            }


            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            //$this->elements['middle'] = 'patient/myappointments';
            $this->elements_data['middle'] = $this->data;

            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function upcoming_appoinment() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);

            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PATIENT_URL . "manage_profile");
            }

            $this->data = array();
            $this->load->model('sadmin_model');
            $this->data['upcoming_appointment'] = $this->patient_model->get_upcoming_appointment($current_user->user_id);
            $this->load->model('message_model', 'message');
            $this->data['flashmessages'] = $this->message->get_flashmessages($current_user->college_id);
            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->headerdata['page_title'] = "Upcoming Appoinments";
            $this->sidebardata['is_active'] = 'dashboard';
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('upcoming_appoinment', 'Upcoming Appoinments'));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            $this->elements['middle'] = 'patient/dashboard';
            $this->elements_data['middle'] = $this->data;

            $current_user = $this->ion_auth->user()->row();

            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            $this->elements['middle'] = 'patient/upcoming_appoinment';
            $this->elements_data['middle'] = $this->data;

            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function checkout() {
        $this->load->model('patient_model', 'pm');
        $this->load->library('zoomapi');
        $json = array();
        try {
            require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php'); //or you
            Stripe::setApiKey(STRIPE_SK); //Replace with your Secret Key
            $patient_id = $this->input->post('patient_id');
            $provider_id = $this->input->post('provider_id');
            $slot_id = $this->input->post('slot_id');
            $patient_data = $this->basic_model->get_user_data($patient_id);
            $provider_data = $this->patient_model->get_provider_data($provider_id);
            $provider_data = $provider_data[0];
            $provider_data['zoom_user_id'] = '';
            if (empty($provider_data['zoom_user_id'])) {
                $id = $provider_data['user_id'];
                $data1 = array(
                    'email' => $provider_data['user_email'],
                    'first_name' => $provider_data['first_name'],
                    'last_name' => $provider_data['last_name']
                );
                $response_json = $this->zoomapi->custCreateAUser($data1);
                $response = json_decode($response_json);
                if (isset($response->id)) {
                    $zoom = array(
                        'zoom_user_id' => $response->id,
                        'zoom_response' => $response_json
                    );
                    $this->basic_model->set_userzoominfo($id, $zoom);
                    $provider_data['zoom_user_id'] = $zoom['zoom_user_id'];
                }
            }
            $appointment_id = $this->patient_model->book_an_appointment($patient_id, $provider_id, $slot_id);

            $appointment_data = $this->patient_model->get_patient_appointments_data($patient_id, $appointment_id);

            //create appointment on zoom
            $given = new DateTime($appointment_data['start_date'] . ' ' . $appointment_data['start_time']);
            $given->format("Y-m-d H:i:s") . "\n"; // 2014-12-12 14:18:00 Asia/Bangkok
            $given->setTimezone(new DateTimeZone("UTC"));
            $start_time = $given->format("Y-m-d\TG:i:s\Z") . "\n"; // 2014-12-12 07:18:00 UTC

            $data1 = array(
                'host_id' => $provider_data['zoom_user_id'], //'91zIyX-DSj-wr9dwQndaRQ',//Cannot be updated after creation.
                'topic' => 'BetterMynd - Appointment #' . $appointment_id,
                'type' => 2, //Meeting type: 1 means instant meeting (Only used for host to start it as soon as created). 2 means normal scheduled meeting. 3 means a recurring meeting.
                'duration' => defined(MEETING_DURATION) ? MEETING_DURATION : 45,
                'start_time' => $start_time, //Should be UTC time, such as 2012-11-25T12:00:00Z
                'option_enforce_login' => false,
                'option_jbh' => true
            );
            $response = $this->zoomapi->createAMeeting($data1);
            $response = json_decode($response);
            if ((!isset($response->uuid)) || isset($response->error)) {
                $json['error'] = "We apologize, but we were unable to process your payment. Please try again or send a message to us at students@bettermynd.com.";
            } else {

                $appointment_zoom_data = array(
                    'appointment_id' => $appointment_id,
                    'req_host_id' => $provider_data['zoom_user_id'], //Cannot be updated after creation.
                    'req_topic' => 'BetterMynd - Appointment #' . $appointment_id,
                    'req_type' => 2, //Meeting type: 1 means instant meeting (Only used for host to start it as soon as created). 2 means normal scheduled meeting. 3 means a recurring meeting.
                    'req_start_time' => $start_time, //Should be UTC time, such as 2012-11-25T12:00:00Z
                    'res_uuid' => $response->uuid,
                    'res_id' => $response->id,
                    'res_start_url' => $response->start_url,
                    'res_join_url' => $response->join_url,
                    'res_duration' => $response->duration,
                    'res_timezone' => $response->timezone,
                    'res_password' => $response->password,
                    'res_h323_password' => $response->h323_password,
                    'complete_response' => json_encode($response),
                    'created_on' => $this->basic_model->set_utc_datetime(date('Y-m-d H:i:s'))
                );
                $this->pm->save_zoom_info($appointment_zoom_data);

                $data = array(
                    'patient_id' => $patient_id,
                    'provider_id' => $provider_id,
                    'appointment_id' => $appointment_id,
                    'coupon_id' => $this->input->post('coupon_id'),
                );

                $description = $this->input->post('description');
                if ($this->input->post('coupon_id')) {
                    $description = $description . " (used coupon - " . $this->input->post('coupon_id') . ")";
                }
                $paid_amt = $this->input->post('remain_session_cost');

                if ($paid_amt > 0) {
                    $charge = Stripe_Charge::create(array(
                                //"amount" => $this->input->post('amount') * 100,
                                "amount" => $paid_amt * 100,
                                "currency" => "usd",
                                // "card" => $this->input->post('stripeToken'),
                                "source" => $this->input->post('stripeToken'),
                                "description" => $description,
                                "metadata" => $data,
                    ));
                } else {
                    $data = new stdClass();
                    $data->patient_id = $patient_id;
                    $data->provider_id = $provider_id;
                    $data->appointment_id = $appointment_id;
                    $data->coupon_id = $this->input->post('coupon_id');
                    $charge = new stdClass();
                    $charge->paid = 1;
                    $charge->amount = $paid_amt * 100;
                    $charge->currency = "usd";
                    $charge->metadata = $data;
                    $charge->balance_transaction = 'tn_' . $appointment_id . time();
                    $charge->id = 'ch_' . $appointment_id . time();
                    $charge->object = 'charge';
                    $charge->description = $description;
                }

                if ($charge->paid == 1) {

                    $this->pm->appointment_transaction(serialize($charge));
                    $update_status_appointment = $this->patient_model->update_appointment($appointment_id);

                    if ($update_status_appointment) {
                        $message_content = $this->basic_model->get_mail_template('appointment_booked_provider');
                        $mail_content = html_entity_decode($message_content->mail_template_content);

                        $message = str_replace("{{identity}}", $provider_data['first_name'] . " " . $provider_data['last_name'], $mail_content);
                        //$message = str_replace(" {{patient_name}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $message);
                        $message = str_replace("{{patient_name}}", $patient_data['first_name'] . " " . $patient_data['last_name'] . '(<b>' . $patient_data['collegename'] . '</b>)', $message);
                        $message = str_replace("{{siteurl}}", SITE_URL . 'login', $message);
                        $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $provider_data['timezone_code']), $message);
                        $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $provider_data['timezone_code']), $message);
                        $message = str_replace("{{payment_info}}", CURRENCY_SYMBOL . $provider_data['session_cost'], $message);
                        $message = MAIL_HEADER . $message . MAIL_FOOTER;

                        $this->email->clear();
                        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                        $this->email->to($provider_data['user_email']);
                        $this->email->subject($message_content->mail_subject);
                        $this->email->message($message);
                        $this->email->send();

                        //                    if (isset($message_content) && !empty($message_content)) {
                        //                        if ($this->email->send() == TRUE) {
                        //                            $this->email->send();
                        //                            $this->session->set_flashdata('success', "Your appointment booked successfully.");
                        //                            $json['success'] = "Your payment has been completed";
                        //                        } else {
                        //                            $json['success'] = "Your payment has been completed, Email not sent";
                        //                        }
                        //                    } else {
                        //                        $json['success'] = "Your payment has been completed, Email not sent";
                        //                    }

                        $message_content = $this->basic_model->get_mail_template('appointment_booked_patient');
                        $mail_content = html_entity_decode($message_content->mail_template_content);
                        //$message = str_replace("{{identity}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $mail_content);
                        $message = str_replace("{{identity}}", $patient_data['first_name'] . " " . $patient_data['last_name'] . '(<b>' . $patient_data['collegename'] . '</b>)', $mail_content);
                        $message = str_replace("{{provider_name}}", $provider_data['first_name'] . " " . $provider_data['last_name'], $message);
                        $message = str_replace("{{siteurl}}", SITE_URL . 'login', $message);
                        $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time']), $message);
                        $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time']), $message);
                        $message = str_replace("{{payment_info}}", CURRENCY_SYMBOL . $paid_amt, $message);
                        $message = MAIL_HEADER . $message . MAIL_FOOTER;

                        $this->email->clear();
                        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                        $this->email->to($patient_data['user_email']);
                        $this->email->subject($message_content->mail_subject);
                        $this->email->message($message);
                        $this->email->send();
                        $this->session->set_flashdata('message', "Your appointment has been booked. You will receive an email confirmation shortly with your appointment details.");
                        $json['success'] = "Your payment has been completed";
                    }
                } else {
                    $json['error'] = "Your payment has not been completed, Please try again later";
                }
            }
        } catch (Stripe_CardError $e) {
            $json['error'] = $e->getMessage();
        } catch (Stripe_InvalidRequestError $e) {
            $json['error'] = $e->getMessage();
        } catch (Stripe_AuthenticationError $e) {
            $json['error'] = $e->getMessage();
        } catch (Stripe_Error $e) {
            $json['error'] = $e->getMessage();
        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }

        $json = json_encode($json);
        echo $json;
    }

    public function bookanappointment() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PATIENT_URL . "manage_profile");
                exit;
            }

            $this->data['insurencelist'] = $this->basic_model->get_insurencelist();
            $this->data['specialitylist'] = $this->basic_model->get_specialitylist();
            $this->data['providerlist'] = $this->basic_model->get_providers($current_user->college_id);

            $provider_id = $this->uri->segment(3, 0);
            $this->data['providers'] = array();
            if (isset($provider_id) && !empty($provider_id)) {
                $this->load->model('provider_model');
                $schedule = $this->provider_model->getValidProviderShcedule($provider_id);
                if (isset($schedule) && !empty($schedule)) {
                    $this->data['schedules'] = $schedule;
                }

                $provider_data = $this->patient_model->get_provider_data($provider_id);
                if (isset($provider_data) && !empty($provider_data)) {
                    $this->data['provider_data'] = $provider_data[0];
                    $this->data['patient_data'] = $current_user;
                    $provider_availabality = $this->patient_model->get_provider_availabality($provider_id);

                    if (isset($provider_availabality) && !empty($provider_availabality)) {
                        if (isset($provider_availabality['timings']) && !empty($provider_availabality['timings'])) {
//prd($provider_availabality,1);
                            $this->data['provider_availabality'] = $provider_availabality;
                        } else {
                            $this->session->set_flashdata('error', "We're sorry, but this provider does not currently have any sessions available. Please search for another provider or email us at students@bettermynd.com and we will work with the provider to find you an open session time for you.");
                            redirect(PATIENT_URL . 'bookanappointment');
                        }
                    } else {
                        $this->session->set_flashdata('error', "We're sorry, but this provider does not currently have any sessions available. Please search for another provider or email us at students@bettermynd.com and we will work with the provider to find you an open session time for you.");
                        redirect(PATIENT_URL . 'bookanappointment');
                    }
                }
            } else {
                $searchterm = $this->input->post('provider_name');
                if (!$searchterm) {
                    $searchterm = $this->input->post('start_date');
                }
                if (!$searchterm) {
                    $searchterm = $this->input->post('end_date');
                }
                if (!$searchterm) {
                    $searchterm = $this->input->post('insurance_id');
                }
                if (!$searchterm) {
                    $searchterm = $this->input->post('price');
                }
                if (!$searchterm) {
                    $searchterm = $this->input->post('speciality_id');
                }

                if (isset($searchterm) && !empty($searchterm)) {
                    $providers = $this->patient_model->get_search_providers($current_user->user_id);
                    $this->data['post_data'] = $_POST;
                } else {
                    $providers = $this->patient_model->get_user_providers($current_user->user_id);
                }
                if (isset($providers) && !empty($providers)) {
                    $this->data['providers'] = $providers;
                }
            }

            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('bookanappointment', 'Book An Appointment'));
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->headerdata['page_title'] = "Book An Appointment";
            $this->sidebardata['is_active'] = 'bookanappointment';
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            $this->elements['middle'] = 'patient/bookanappointment';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function verifyUser() {
        $provider_name = $_POST['provider_name'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        if ($provider_name == '' && $start_date = 11) {

            $status = array("STATUS" => "true");
        }
        echo json_encode($status);
    }

    public function showavailabality() {
        $provider_id = $this->input->post('provider');
        if (isset($provider_id) && !empty($provider_id)) {
            redirect('patient/bookanappointment/' . $provider_id);
        }
    }

    public function payment() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PATIENT_URL . "manage_profile");
                exit;
            }
            $this->data = array();


            // Patient_id
            $patient_id = $this->input->post('patient_id');

            if ($patient_id == '') {
                redirect(PATIENT_URL . "bookanappointment");
                exit;
            }

            if (isset($patient_id) && !empty($patient_id)) {
                $this->data['patient_id'] = array(
                    'name' => 'patient_id',
                    'id' => 'patient_id',
                    'type' => 'hidden',
                    'maxlength' => '32',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "patient_id Name",
                    'value' => $patient_id
                );
            }

            // Patient_id
            $provider_id = $this->input->post('provider_id');
            if (isset($provider_id) && !empty($provider_id)) {
                $this->data['provider_id'] = array(
                    'name' => 'provider_id',
                    'id' => 'provider_id',
                    'type' => 'hidden',
                    'maxlength' => '32',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "provider_id",
                    'value' => $provider_id
                );
                $provider_data = $this->patient_model->get_provider_data($provider_id);

                if (isset($provider_data) && !empty($provider_data)) {
                    $this->data['provider_info'] = $provider_data[0];
                }
            }
            //prd($this->input->post(), 1);
            //Time Slots
            $appointmentdate = $this->input->post('appointmentdate');
            $end_dateslot = $this->input->post('end_dateslot');
            $end_timeslot = $this->input->post('end_timeslot');
            $session_cost = $this->input->post('session_cost');
            $timeslot = $this->input->post('timeslot');

            $utc_start_datetime = $this->basic_model->set_utc_datetime($appointmentdate . ' ' . $timeslot);
            $utc_end_datetime = $this->basic_model->set_utc_datetime($appointmentdate . ' ' . $timeslot);

            if (isset($appointmentdate) && !empty($appointmentdate) && isset($timeslot) && !empty($timeslot)) {
                $slot_id = $this->patient_model->get_time_slot($provider_id, $utc_start_datetime, $utc_start_datetime);

                $this->data['slot_id'] = array(
                    'name' => 'slot_id',
                    'id' => 'slot_id',
                    'type' => 'hidden',
                    'maxlength' => '32',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "provider_id",
                    'value' => $slot_id
                );
                $this->data['appointment_date_time'] = array(
                    'name' => 'appointment_date_time',
                    'id' => 'appointment_date_time',
                    'type' => 'hidden',
                    'value' => $appointmentdate . " " . $timeslot
                );
                $this->data['appointment_on'] = $appointmentdate . " " . $timeslot;
                $this->data['end_timeslot'] = $end_timeslot;
                $this->data['session_cost'] = $session_cost;
            }


//            $this->data['patient_id'] = $current_user->user_id;

            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "First Name",
                'autocomplete' => "off",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['first_name']) ? $postdata['first_name'] : ''
            );
            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Last Name",
                'autocomplete' => "off",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['last_name']) ? $postdata['last_name'] : ''
            );
            $this->data['card_number'] = array(
                'name' => 'card_number',
                'id' => 'card_number',
                'type' => 'text',
                "class" => "form-control  col-md-7 col-xs-12 credit_card_number nonpaste",
                'autocomplete' => "off",
                'placeholder' => "Credit Card Number"
            );
            $this->data['expiration_date'] = array(
                'name' => 'expiration_date',
                'id' => 'expiration_date',
                'type' => 'text',
                "class" => "form-control  col-md-7 col-xs-12 credit_card_expiry nonpaste",
                'autocomplete' => "MM / YYYY",
                'placeholder' => "MM / YYYY",
            );
            $this->data['cvv_code'] = array(
                'name' => 'cvv_code',
                'id' => 'cvv_code',
                'type' => 'password',
                "class" => "form-control  col-md-7 col-xs-12 credit_card_cvc nonpaste",
                'autocomplete' => "CVV",
                'placeholder' => "CVV"
            );
            $this->data['address'] = array(
                'name' => 'address',
                'id' => 'address',
                'type' => 'text',
                "class" => "form-control  col-md-7 col-xs-12",
                'autocomplete' => "off",
                'placeholder' => "Address",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['address']) ? $postdata['address'] : ''
            );
            $this->data['zip_code'] = array(
                'name' => 'zip_code',
                'id' => 'zip_code',
                'type' => 'text',
                'maxlength' => '8',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Zip Code",
                'autocomplete' => "off",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['zip_code']) ? $postdata['zip_code'] : ''
            );
            $this->data['coupon_code'] = array(
                'name' => 'coupon_code',
                'id' => 'coupon_code',
                'type' => 'text',
                "class" => "form-control",
                'placeholder' => "Coupon Code",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['coupon_code']) ? $postdata['coupon_code'] : ''
            );


            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "Payment";
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('payment', 'Payment'));
            $this->sidebardata['is_active'] = 'payment';
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            $this->elements['middle'] = 'patient/payment';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function transaction() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PATIENT_URL . "manage_profile");
                exit;
            }
            $this->data = array();

            $this->data['transaction'] = $this->patient_model->get_appointment_transaction($current_user->user_id);
            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->headerdata['page_title'] = "Past Appointments";
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('transaction', 'Past Appointments'));
            $this->sidebardata['is_active'] = 'transaction';
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            $this->elements['middle'] = 'patient/transaction';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function manage_profile() {
        $current_user = $this->ion_auth->user()->row();

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->data = array();
            $this->headerdata = array();
            $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';
            if (!isset($postdata) && empty($postdata)) {
                
            }

            $this->data['title'] = "Manage Student";

            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => $current_user->user_id,
                'type' => 'hidden'
            );

            $this->data['user_type'] = array(
                'name' => 'user_type',
                'id' => 'user_type',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => '4',
                'type' => 'hidden'
            );

            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                "class" => "form-control",
                'type' => 'text',
                'readonly' => "readonly",
                'maxlength' => '100',
                'placeholder' => "e.g. you@widgetcorp.com",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['email']) ? $postdata['email'] : $current_user->user_email
            );

            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "First Name",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['first_name']) ? $postdata['first_name'] : $current_user->first_name
            );
            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Last Name",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['last_name']) ? $postdata['last_name'] : $current_user->last_name
            );
            $this->data['patient_identification_number'] = array(
                'name' => 'patient_identification_number',
                'id' => 'patient_identification_number',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Student ID Number",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['patient_identification_number']) ? $postdata['patient_identification_number'] : $current_user->patient_identification_number
            );
            $dob_date = "";
            if (isset($current_user->dob) && !empty($current_user->dob)) {
                $dob_date = $this->basic_model->convertDatePatient($current_user->dob);
                if (isset($dob_date) && !empty($dob_date)) {
                    $postdata = "";
                }
            }

            $this->data['dob'] = array(
                'name' => 'dob',
                'id' => 'dob',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12 noneditable ",
                'placeholder' => "Date Of Birth",
                'value' => $dob_date
            );

            $this->data['mobile_no'] = array(
                'name' => 'mobile_no',
                'id' => 'mobile_no',
                'type' => 'text',
                'maxlength' => '15',
                "class" => "form-control  col-md-7 col-xs-12 mobilemark",
                'placeholder' => "___-___-____",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['mobile_no']) ? $postdata['mobile_no'] : $current_user->mobile_no
            );

            $this->data['address'] = array(
                'name' => 'address',
                'id' => 'address',
                'type' => 'text',
                'maxlength' => '200',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Enter Campus Address",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['address']) ? $postdata['address'] : $current_user->address
            );
            $this->data['city'] = array(
                'name' => 'city',
                'id' => 'city',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Enter City",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['city']) ? $postdata['city'] : $current_user->city
            );

            $this->data['zipcode'] = array(
                'name' => 'zipcode',
                'id' => 'zipcode',
                'type' => 'text',
                'maxlength' => '10',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Enter Zipcode",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['zipcode']) ? $postdata['zipcode'] : $current_user->zipcode
            );

            $states = $this->basic_model->get_state_list();

            $this->data['states'] = $states;

            if (isset($current_user->state) && !empty($current_user->state)) {
                $state_select = $current_user->state;
            } else {
                $state_select = '';
            }
            $this->data['state_selected'] = $state_select;
            $this->data['is_international_selected'] = isset($postdata) && !empty($postdata) && isset($postdata['is_international']) ? $postdata['is_international'] : $current_user->is_international;
            $this->data['athlete_selected'] = isset($postdata) && !empty($postdata) && isset($postdata['athlete']) ? $postdata['athlete'] : $current_user->athlete;
            $this->data['class_year_selected'] = isset($postdata) && !empty($postdata) && isset($postdata['class_year']) ? $postdata['class_year'] : $current_user->class_year;

            $this->data['college'] = array('' => 'Select College') + $this->college_model->getCollege();
            $this->data['college_selected'] = (isset($current_user->college_id) && !empty($current_user->college_id)) ? $current_user->college_id : '';

            $this->data['timezone_list'] = array('' => 'Select Time Zone') + $this->basic_model->get_timezonelist();
            //prd($this->data['timezone_list'], 1);
            if (isset($current_user->timezone_id) && !empty($current_user->timezone_id)) {
                $timezone_list_selected = $current_user->timezone_id;
            } else {
                $timezone_list_selected = DEFAULT_TIMEZONE;
            }
            $this->data['timezone_list_selected'] = $timezone_list_selected;
            $this->data['profile_image'] = $current_user->profile_image;

            $this->data['ethnicity_list'] = array('' => 'Select Ethnicity') + $this->basic_model->get_ethnicitylist();
            if (isset($current_user->ethnicity) && !empty($current_user->ethnicity)) {
                $ethnicity_list_selected = $current_user->ethnicity;
            } else {
                $ethnicity_list_selected = '';
            }
            $this->data['ethnicity_list_selected'] = $ethnicity_list_selected;

            if (isset($current_user->gender) && !empty($current_user->gender)) {
                $gender_selected = $current_user->gender;
            } else {
                $gender_selected = 1;
            }
            $this->data['gender_selected'] = $gender_selected;
            unset($_SESSION['postdata']);
            $this->sidebardata = array();
            $this->sidebardata['is_active'] = 'manage_profile';
            $this->data['is_profile_completeness'] = $current_user->is_profile_completeness;
            $this->data['is_disabled'] = $current_user->is_disabled;
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->headerdata['page_title'] = "Manage Profile";
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('manage_profile', 'Manage Profile'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            $this->elements['middle'] = 'patient/patient_manage_profile';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function manage_patient_profile() {
        // Configuration options
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;



        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('patient_identification_number', $this->lang->line('create_user_validation_patient_id_label'), 'required');
        $this->form_validation->set_rules('dob', $this->lang->line('create_user_validation_dob_label'), 'required');
        $this->form_validation->set_rules('mobile_no', $this->lang->line('create_user_validation_mobile_no_label'), 'required');

        if ($this->form_validation->run() == true) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->load->model("basic_model");

            $additional_data = array();

            $post_arr = $this->input->post();
            $post_arr = $this->basic_model->stripTagsPostArray($post_arr);
            if ($this->patient_model->update_patient($post_arr)) {
                $this->session->set_flashdata('message', $this->lang->line('profile_update_patient'));
                redirect(PATIENT_URL . "manage_profile");
            } else {
                $_SESSION['postdata'] = $_POST;
                $this->session->set_flashdata('error', "Profile Image must be of JPG/PNG/JPEG/GIF image type.");
                redirect(PATIENT_URL . "manage_profile");
            }
        } else {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(PATIENT_URL . "manage_profile");
        }
    }

    public function changepassword() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PATIENT_URL . "manage_profile");
                exit;
            }
            $this->data = array();

            $this->sidebardata = array();

            $this->data['script_to_include'] = "sadmin_js.js";
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata['is_active'] = 'changepassword';
            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Old Password'
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'New Password'
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Confirm New Password'
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $current_user->id,
            );
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $this->headerdata['page_title'] = "Change Password";
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('changepassword', 'Change Password'));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            $this->elements['middle'] = 'patient/change_password';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function change_password() {

        $current_user = $this->ion_auth->user()->row();
        $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
        if (isset($user_complete_status) && $user_complete_status != 1) {
            redirect(PATIENT_URL . "manage_profile");
            exit;
        }

        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');
        if ($this->form_validation->run() == true) {
            $identity = $this->session->userdata('identity');
            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
            $identity_u = $this->config->item('identity', 'ion_auth');
            if ($change) {
                $userinfo = $this->basic_model->get_userinfo($this->input->post('user_id'));
                $data = array(
                    'identity' => $userinfo->{$identity_u}
                );
                $this->load->model('basic_model');
                $message_content = $this->basic_model->get_mail_template('change_password');
                if (isset($message_content) && !empty($message_content)) {
                    $mail_content = html_entity_decode($message_content->mail_template_content);
                    $message = str_replace("{{identity}}", $data['identity'], $mail_content);
                    $message = MAIL_HEADER . $message . MAIL_FOOTER;
                    $this->email->clear();
                    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                    $this->email->to($userinfo->user_email);
                    $this->email->subject($message_content->mail_subject);
                    $this->email->message($message);
                    if ($this->email->send() == TRUE) {
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(PATIENT_URL . "changepassword", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(PATIENT_URL . "changepassword", 'refresh');
                    }
                } else {

                    $this->session->set_flashdata('message', $this->ion_auth->messages());

                    redirect(PATIENT_URL . "changepassword", 'refresh');
                }
            } else {

                $this->session->set_flashdata('error', $this->ion_auth->errors());

                redirect(PATIENT_URL . "changepassword", 'refresh');
            }
        } else {

            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(PATIENT_URL . "changepassword");
        }
    }

    public function myappointments() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PATIENT_URL . "manage_profile");
                exit;
            }
            $this->data = array();
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $appointments = $this->patient_model->get_patient_appointments($current_user->user_id);
            if (isset($appointments) && !empty($appointments)) {
                $this->data['appointments'] = $appointments;
            }
            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "My Appointments";
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('transaction', 'My Appointments'));
            $this->sidebardata['is_active'] = 'myappointments';
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            $this->elements['middle'] = 'patient/myappointments';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function view_profile() {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $this->data = array();
            $this->headerdata = array();

            $this->data['title'] = "Manage Student";

            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            $this->data['profile_data'] = $current_user;
            if (!empty($current_user->dob)) {
                $dob = $this->basic_model->convertDate($current_user->dob);
            } else {
                $dob = $current_user->dob;
            }
            if (isset($current_user->dob) && !empty($current_user->dob)) {
                $dob = $this->basic_model->convertDatePatient($current_user->dob);
            }

            $this->data['dob'] = $dob;
            if (isset($current_user->timezone_id) && !empty($current_user->timezone_id)) {
                $timezone = $this->basic_model->getTimeZoneName($current_user->timezone_id);
            } else {
                $timezone = "N/A";
            }
            $this->data['timezone'] = $timezone;

            $this->data['profile_image'] = $current_user->profile_image;

            if (isset($current_user->college_id) && !empty($current_user->college_id)) {
                $college_name = $this->basic_model->getCollegeName($current_user->college_id);
            } else {
                $college_name = "N/A";
            }
            $this->data['college_name'] = $college_name;


            if (isset($current_user->ethnicity) && !empty($current_user->ethnicity)) {
                $ethnicity_name = $this->basic_model->getEthnicityName($current_user->ethnicity);
            } else {
                $ethnicity_name = "N/A";
            }
            $this->data['ethnicity_name'] = $ethnicity_name;


            $this->data['profile_image'] = $current_user->profile_image;


            $this->sidebardata = array();
            $this->sidebardata['is_active'] = 'manage_profile';

            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "View Profile";
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('view_profile', 'My Profile'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            $this->elements['middle'] = 'patient/view_profile';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function get_providers() {
        $search = $this->input->get('term');
        if (isset($search) && !empty($search)) {
//					 $searchquery="select * from bm_users where user_type='3' and ((first_name like '%".$search."%') or (last_name like '%".$search."%')) and college_id='".$this->ion_auth->user()->row()->college_id."'";
            $searchquery = "(SELECT
                                                        concat(first_name, ' ',last_name) as value,
                                                        user_id as id,
                                                        'provider' as type
                                                       FROM bm_users
                                                       WHERE
                                                       (
                                                            MATCH(first_name, last_name) AGAINST ('" . $search . "') or
                                                            soundex(first_name)=soundex('" . $search . "')  or
                                                            soundex(last_name)=soundex('" . $search . "') or
                                                                 first_name like '%$search%' or
                                                                 last_name like '%$search%'
                                                        ) and
                                                        ((user_type='3' and college_id='" . $this->ion_auth->user()->row()->college_id . "') or (user_type='5'))
                                                            )
                                                            union
                                                            (
                                                            select
                                                            speciality_title as value,
                                                            speciality_id as id,
                                                            'speciality' as type
                                                            from bm_speciality
                                                            WHERE
                                                                (
                                                                     MATCH(speciality_title) AGAINST ('" . $search . "') or
                                                                     soundex(speciality_title)=soundex('" . $search . "') or
                                                                         speciality_title like '%$search%'
                                                                 )
                                                            )
                                                 ";
            $searchsql = $this->db->query($searchquery);
            if ($searchsql->num_rows()) {
                $searchrow = $searchsql->result_array();
                echo json_encode($searchrow);
            } else {
                
            }
        }
    }

    function get_time_slots() {

        $provider_id = $this->uri->segment(3, 0);
        $date = $this->uri->segment(4, 0);
        $date = str_replace(" ", "", urldecode($date));
        $date = str_replace("-", "/", urldecode($date));


        if (isset($provider_id) && !empty($provider_id) && isset($date) && !empty($date)) {
            $date = date('Y-m-d', strtotime($date));
            $query1 = "select distinct(start_time) from bm_provider_availablity where provider_id=$provider_id and start_date='" . $date . "' and avail_id not in (select slot_id from bm_appointments where provider_id='" . $provider_id . "')";
            $sql1 = $this->db->query($query1);
            if ($sql1->num_rows()) {
                $result1 = $sql1->result_array();
                if (count($result1)) {
                    foreach ($result1 as $result) {
                        echo "<option value='" . $result['start_time'] . "'>" . $result['start_time'] . "</option>";
                    }
                }
            }
        }
    }

    public function update_schedule() {

        $avail_id = $this->input->post('avail_id');
        $provider_id = $this->input->post('provider_id');
        $slot_id = $this->input->post('slot_id');
        $patient_id = $this->input->post('patient_id');
        $app_status = $this->input->post('app_status');
        $app_id = $this->input->post('app_id');
        $this->data = array();
        if (isset($app_status) && !empty($app_status)) {
            $this->data['app_status'] = $app_status;
        }
        if (isset($app_id) && !empty($app_id)) {
            $this->data['app_id'] = $app_id;
        }
        if (isset($avail_id) && !empty($avail_id)) {
            $this->data['avail_id'] = $avail_id;
        }
        if (isset($provider_id) && !empty($provider_id)) {
            $this->data['provider_id'] = $provider_id;
        }
        if (isset($slot_id) && !empty($slot_id)) {
            $this->data['slot_id'] = $slot_id;
        }
        if (isset($patient_id) && !empty($patient_id)) {
            $this->data['patient_id'] = $patient_id;
        }
        $this->load->model('provider_model');
        $avail_info = $this->provider_model->get_avail_info($avail_id);
        if (isset($avail_info) && !empty($avail_info)) {
            $this->data['avail_info'] = $avail_info[0];
        }
        $this->data['avail_times'] = $this->basic_model->get_times(date('H:i', strtotime($avail_info[0]->start_time)));
        $this->load->model('basic_model');
        $provider_info = $this->provider_model->get_user_info($provider_id);

        if (isset($provider_info) && !empty($provider_info)) {
            $this->data['provider_info'] = $provider_info[0];
        }
        $this->load->view('patient/update_schedule', $this->data);
    }

    public function updateavailabality() {
        $this->load->model('provider_model');
        $ttype = $this->input->post('ttype');
        $provider_id = $this->input->post('provider_id');
        $patient_id = $this->input->post('patient_id');
        $avail_id = $this->input->post('avail_id');
        $before_24_hours = $this->input->post('refund_time_limit');
        try {
            if (isset($ttype) && !empty($ttype)) {
                if ($ttype == "appointment" && isset($patient_id) && !empty($patient_id)) {

                    $update = $this->provider_model->update_appointment($avail_id, $provider_id, $patient_id);

                    if ($update) {
                        $patient_data = $this->basic_model->get_user_data($patient_id);
                        $this->load->model('patient_model');
                        $provider_data = $this->patient_model->get_provider_data($provider_id);
                        $provider_data = $provider_data[0];
                        $appointment_data = $this->provider_model->get_avail_info($avail_id);
                        $appointment_data = (array) $appointment_data[0];
                        $app_id = $this->input->post('app_id');

                        $transaction = $this->provider_model->get_appointment_transaction($app_id);
                        $chk_refund_amt = $this->basic_model->chk_applied_coupon(serialize($transaction));
                        $metadata = array(
                            'patient_id' => $patient_id,
                            'provider_id' => $provider_id,
                            'appointment_id' => $app_id,
                            'amount_to_bm' => $transaction['amount_to_bm'],
                            'amount_to_provider' => $transaction['amount_to_provider'],
                        );

                        if ($before_24_hours >= strtotime(date('Y-m-d H:i:s'))) {
                            if (isset($transaction['charge_id']) && !empty($transaction['charge_id']) && $chk_refund_amt > 0) {
                                require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php'); //or you
                                Stripe::setApiKey(STRIPE_SK); //Replace with your Secret Key

                                $k = new Stripe_Charge($transaction['charge_id'], STRIPE_SK);
                                $refund = $k->refund(array(
                                    //"charge" => $transaction['charge_id'],
                                    "metadata" => $metadata,
                                    "reason" => 'requested_by_customer',
                                ));

                                $refund = $refund->__toArray(true);
                            } else {
                                $refund = array();
                                $refund['metadata'] = $metadata;
                                $refund['reason'] = 'requested_by_customer';
                                $refund['refunded'] = 1;
                            }

                            $this->provider_model->appointment_refund(serialize($refund), serialize($transaction));

                            $message_content = $this->basic_model->get_mail_template('appointment_canceled_patitent_before24');
                            $mail_content = html_entity_decode($message_content->mail_template_content);
                            $message = str_replace("{{identity}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $mail_content);
                            $message = str_replace("{{siteurl}}", SITE_URL, $message);
                            $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time']), $message);
                            $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time']), $message);
                            $message = MAIL_HEADER . $message . MAIL_FOOTER;

                            $this->email->clear();
                            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                            $this->email->to($patient_data['user_email']);
                            $this->email->subject($message_content->mail_subject);
                            $this->email->message($message);
                            $this->email->send();
                        } else {
                            $message_content = $this->basic_model->get_mail_template('appointment_canceled_patitent_within24');
                            $mail_content = html_entity_decode($message_content->mail_template_content);
                            $message = str_replace("{{identity}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $mail_content);
                            $message = str_replace("{{siteurl}}", SITE_URL, $message);
                            $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time']), $message);
                            $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time']), $message);
                            $message = MAIL_HEADER . $message . MAIL_FOOTER;

                            $this->email->clear();
                            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                            $this->email->to($patient_data['user_email']);
                            $this->email->subject($message_content->mail_subject);
                            $this->email->message($message);
                            $this->email->send();
                        }

                        //send mail to admin
                        $admin = $this->basic_model->getAdminDetails();
                        $message_content = $this->basic_model->get_mail_template('appointment_canceled_send_to_admin');
                        $mail_content = html_entity_decode($message_content->mail_template_content);
                        $message = str_replace("{{identity}}", ucfirst($admin['first_name'] . " " . $admin['last_name']), $mail_content);
                        $message = str_replace("{{cancelled_by}}", ucfirst($patient_data['first_name'] . " " . $patient_data['last_name']), $message);
                        $message = str_replace("{{patient_name}}", ucfirst($patient_data['first_name'] . " " . $patient_data['last_name']), $message);
                        $message = str_replace("{{patient_email}}", $patient_data['user_email'], $message);
                        $message = str_replace("{{counselor_name}}", ucfirst($provider_data['first_name'] . " " . $provider_data['last_name']), $message);
                        $message = str_replace("{{counselor_email}}", $provider_data['user_email'], $message);
                        $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $admin['timezone_code']), $message);
                        $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $admin['timezone_code']), $message);
                        $message = MAIL_HEADER . $message . MAIL_FOOTER;

                        $this->email->clear();
                        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                        $this->email->to($admin['user_email']);
                        $this->email->subject($message_content->mail_subject);
                        $this->email->message($message);
                        $this->email->send();

                        $message_content = $this->basic_model->get_mail_template('appointment_canceled_provider');
                        $mail_content = html_entity_decode($message_content->mail_template_content);
                        $message = str_replace("{{identity}}", $provider_data['first_name'] . " " . $provider_data['last_name'], $mail_content);
                        $message = str_replace("{{patient_name}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $message);
                        $message = str_replace("{{siteurl}}", SITE_URL, $message);
                        $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $provider_data['timezone_code']), $message);
                        $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $provider_data['timezone_code']), $message);
                        $message = str_replace("{{payment_info}}", CURRENCY_SYMBOL . $provider_data['session_cost'], $message);
                        $message = MAIL_HEADER . $message . MAIL_FOOTER;

                        $this->email->clear();
                        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                        $this->email->to($provider_data['user_email']);
                        $this->email->subject($message_content->mail_subject);
                        $this->email->message($message);
                        $this->email->send();

                        $this->session->set_flashdata('message', "Appointment Cancelled Successfully.");
                        redirect(PATIENT_URL . 'dashboard');
                    }
                } else {
                    $update = $this->provider_model->update_schedule($avail_id);
                    if ($update) {
                        $this->session->set_flashdata('message', "Schedule Cancelled Successfully.");
                        redirect(PATIENT_URL . 'dashboard');
                    }
                }
            } else {
                redirect(PATIENT_URL . 'dashboard');
            }
        } catch (Stripe_CardError $e) {
            $json['error'] = $e->getMessage();
        } catch (Stripe_InvalidRequestError $e) {
            $json['error'] = $e->getMessage();
        } catch (Stripe_AuthenticationError $e) {
            $json['error'] = $e->getMessage();
        } catch (Stripe_Error $e) {
            $json['error'] = $e->getMessage();
        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }
        $this->session->set_flashdata('error', $json['error']);
        redirect(PATIENT_URL . 'dashboard');
    }

    public function joinappointment($app_id) {
        $app_id = base64_decode($app_id);
        //shell_exec('usr/local/bin/php -'.base_url('cron/endmeeting/'.$app_id));
        redirect(getjoinurl($app_id));
    }

    function redirecttoadmin() {
        if (isset($_SESSION['from_admin']) && $_SESSION['from_admin'] == "1") {
            $_SESSION['from_admin'] = '';
            unset($_SESSION['from_admin']);
        } else {
            redirect(SADMIN_URL . "college");
        }
        $user_data = $this->basic_model->get_super_data();

        if (isset($user_data) && !empty($user_data)) {
            // Switchin Session Data
            $session_data = array(
                'identity' => $user_data['user_email'],
                'username' => $user_data['user_email'],
                'email' => $user_data['user_email'],
                'user_id' => $user_data['user_id'], //everyone likes to overwrite id so we'll use user_id
                'old_last_login' => $user_data['last_login'],
            );
            $this->session->set_userdata($session_data);
            //$this->session->set_userdata("total_logins", $this->basic_model->get_login_stat($user_data['user_id']));
            redirect(SADMIN_URL);
            //
        }
    }

    function validate_coupon() {
        $status = 'error';
        $message = 'This coupon is not valid.';
        require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php'); //or you
        Stripe::setApiKey(STRIPE_SK); //Replace with your Secret Key
        try {
            $coupon_id = trim($_POST['coupon_id']);
            $session_cost = trim($_POST['session_cost']);
            require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php'); //or you
            Stripe::setApiKey(STRIPE_SK); //Replace with your Secret Key
            $coupon = Stripe_Coupon::retrieve($coupon_id);
        } catch (Stripe_CardError $e) {
            //$json['error'] = $e->getMessage();
            $json['error'] = 'Invalid Promo Code.';
        } catch (Stripe_InvalidRequestError $e) {
            //$json['error'] = $e->getMessage();
            $json['error'] = 'Invalid Promo Code.';
        } catch (Stripe_AuthenticationError $e) {
            //$json['error'] = $e->getMessage();
            $json['error'] = 'Invalid Promo Code.';
        } catch (Stripe_Error $e) {
            //$json['error'] = $e->getMessage();
            $json['error'] = 'Invalid Promo Code.';
        } catch (Exception $e) {
            //$json['error'] = $e->getMessage();
            $json['error'] = 'Invalid Promo Code.';
        }

        if (isset($coupon) && $coupon) {
            if ($coupon->valid) {
                $coupon_id = isset($coupon->id) ? $coupon->id : '';
                $coupon_object = isset($coupon->object) ? $coupon->object : '';
                $coupon_amount_off = isset($coupon->amount_off) ? $coupon->amount_off : '';
                $coupon_percent_off = isset($coupon->percent_off) ? $coupon->percent_off : '';
                $coupon_duration = isset($coupon->duration) ? $coupon->duration : '';
                $coupon_duration_in_months = isset($coupon->duration_in_months) ? $coupon->duration_in_months : '';
                $coupon_max_redemptions = isset($coupon->max_redemptions) ? $coupon->max_redemptions : '';
                $expire_on = isset($coupon->redeem_by) ? $coupon->redeem_by : '';

                if ($coupon_amount_off) { //P=> percent A=>amount
                    $coupon_amount_off = $coupon_amount_off / 100;
                    $coupon_coupon_type = 'A';
                    $discount_amt = number_format($coupon_amount_off, 2);
                } else {
                    $coupon_coupon_type = 'P';
                    $discount_amt = number_format((($session_cost * $coupon_percent_off) / 100), 2);
                }
                $remain_session_cost = number_format(($session_cost - $discount_amt), 2);

                if ($discount_amt <= 0) {
                    $discount_amt = number_format(0, 2);
                }

                $current_user = $this->ion_auth->user()->row();
                $chk_coupon_reusable = $this->basic_model->is_reusable_coupon($coupon_duration, $coupon_id, $current_user->user_id);
                if ($chk_coupon_reusable == 'YES') {
                    $response = array(
                        'coupon_id' => $coupon_id,
                        'coupon_object' => $coupon_object,
                        'coupon_coupon_type' => $coupon_coupon_type,
                        'coupon_amount_off' => $coupon_amount_off,
                        'coupon_percent_off' => $coupon_percent_off,
                        'discount_amt' => $discount_amt,
                        'remain_session_cost' => $remain_session_cost,
                        'coupon_duration' => $coupon_duration,
                        'coupon_duration_in_months' => $coupon_duration_in_months,
                        'coupon_max_redemptions' => $coupon_max_redemptions,
                        'expire_on' => $expire_on,
                    );

                    $status = 'success';
                    $message = $response;
                } else {
                    $message = 'This coupon is already used.';
                }
            } else {
                if ($coupon->redeem_by < time()) {
                    $message = 'This coupon is expired.';
                }
            }
        } else {
            $message = $json['error'];
        }
        echo json_encode(array('status' => $status, 'message' => $message));
        exit;
    }

}
