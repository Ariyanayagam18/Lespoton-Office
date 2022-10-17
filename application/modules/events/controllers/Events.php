<?php
//ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed ');
$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);
session_start();
class Events extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Event_model');
        // $this->load->model('User_model');
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->id) ? $this->session->get_userdata()['user_details'][0]->users_id : '1';
    }

    /**
     * This function is redirect to users profile page
     * @return Void
     */
    public function index() {
        if (is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    /**
     * This function is used to load login view page
     * @return Void
     */
    public function login() {
        if (isset($_SESSION['user_details'])) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
        $this->load->view('include/script');
        $this->load->view('login');
    }

    /**
     * This function is used to logout user
     * @return Void
     */
    public function logout() {
        is_login();
        $this->session->unset_userdata('user_details');
        redirect(base_url() . 'user/login', 'refresh');
    }

    /**
     * This function is used to registr user
     * @return Void
     */
    public function registration() {
        if (isset($_SESSION['user_details'])) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
        //Check if admin allow to registration for user
        if (setting_all('register_allowed') == 1) {
            if ($this->input->post()) {
                $this->add_edit();
                $this->session->set_flashdata('messagePr', 'Successfully Registered..');
            } else {
                $this->load->view('include/script');
                $this->load->view('register');
            }
        } else {
            $this->session->set_flashdata('messagePr', 'Registration Not allowed..');
            redirect(base_url() . 'user/login', 'refresh');
        }
    }

    /**
     * This function is used for user authentication ( Working in login process )
     * @return Void
     */
    public function auth_user($page = '') {
        $return = $this->User_model->auth_user();
        if (empty($return)) {
            $this->session->set_flashdata('messagePr', 'Invalid details');
            redirect(base_url() . 'user/login', 'refresh');
        } else {

            if ($return == 'not_varified') {
                $this->session->set_flashdata('messagePr', 'This accout is not varified. Please contact to your admin..');
                redirect(base_url() . 'user/login', 'refresh');
            } else {

                $this->session->set_userdata('user_details', $return);
            }
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    /**
     * This function is used send mail in forget password
     * @return Void
     */
    public function forgetpassword() {
        $page['title'] = 'Forgot Password';
        if ($this->input->post()) {
            $setting = settings();
            $res = $this->User_model->get_data_by('users', $this->input->post('email'), 'email', 1);
            if (isset($res[0]->users_id) && $res[0]->users_id != '') {
                $var_key = $this->getVarificationCode();
                $this->User_model->updateRow('users', 'users_id', $res[0]->users_id, array('var_key' => $var_key));
                $sub = "Reset password";
                $email = $this->input->post('email');
                $data = array(
                    'user_name' => $res[0]->name,
                    'action_url' => base_url(),
                    'sender_name' => $setting['company_name'],
                    'website_name' => $setting['website'],
                    'varification_link' => base_url() . 'user/mail_varify?code=' . $var_key,
                    'url_link' => base_url() . 'user/mail_varify?code=' . $var_key,
                );
                $body = $this->User_model->get_template('forgot_password');
                $body = $body->html;
                foreach ($data as $key => $value) {
                    $body = str_replace('{var_' . $key . '}', $value, $body);
                }
                if ($setting['mail_setting'] == 'php_mailer') {
                    $this->load->library("send_mail");
                    $emm = $this->send_mail->email($sub, $body, $email, $setting);
                } else {
                    // content-type is required when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: ' . $setting['EMAIL'] . "\r\n";
                    $emm = mail($email, $sub, $body, $headers);
                }
                if ($emm) {
                    $this->session->set_flashdata('messagePr', 'To reset your password, link has been sent to your email');
                    redirect(base_url() . 'user/login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('forgotpassword', 'This account does not exist'); //die;
                redirect(base_url() . "user/forgetpassword");
            }
        } else {
            $this->load->view('include/script');
            $this->load->view('forget_password');
        }
    }

    /**
     * This function is used to load view of reset password and varify user too
     * @return : void
     */
    public function mail_varify() {
        $return = $this->User_model->mail_varify();
        $this->load->view('include/script');
        if ($return) {
            $data['email'] = $return;
            $this->load->view('set_password', $data);
        } else {
            $data['email'] = 'allredyUsed';
            $this->load->view('set_password', $data);
        }
    }

    /**
     * This function is used to reset password in forget password process
     * @return : void
     */
    public function reset_password() {
        $return = $this->User_model->ResetPpassword();
        if ($return) {
            $this->session->set_flashdata('messagePr', 'Password Changed Successfully..');
            redirect(base_url() . 'user/login', 'refresh');
        } else {
            $this->session->set_flashdata('messagePr', 'Unable to update password');
            redirect(base_url() . 'user/login', 'refresh');
        }
    }

    /**
     * This function is generate hash code for random string
     * @return string
     */
    public function getVarificationCode() {
        $pw = $this->randomString();
        return $varificat_key = password_hash($pw, PASSWORD_DEFAULT);
    }

    /**
     * This function is used for show users list
     * @return Void
     */
    public function userTable() {
        is_login();
        if (CheckPermission("users", "own_read")) {
            $this->load->view('include/header');
            $this->load->view('user_table');
            $this->load->view('include/footer');
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    public function fancier() {
        is_login();
        if (CheckPermission("users", "own_read")) {
            $this->load->view('include/header');
            $this->load->view('fancier_table');
            $this->load->view('include/footer');
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    public function addrace() {
        is_login();
        if (CheckPermission("users", "own_read")) {
            if (!isset($id) || $id == '') {
                $id = $this->session->userdata('user_details')[0]->users_id;
            }
            $table = 'ppa_bird_type';
            $data['bird_list'] = $this->Event_model->get_data_by($table);
            //$data['bird_list'] = $this->Event_model->get_club_data_($table);
            //echo "IDE ".$id;
            if ($id == 1) {
                $query = $this->db->query("select * from users where user_type!='Admin' order by name asc");
                $data['org_list'] = $query->result();
            } else {
                $table_name = 'users';
                $where = array('users_id' => $id);
                $data['org_list'] = $this->Event_model->get_validate($table_name, $where);
            }
            $this->load->view('include/header');
            $this->load->view('add_race', $data);
            $this->load->view('include/footer');
            //$this->session->set_flashdata('messagePr', 'Bird added Successfully');
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    function entrylog($action = "", $desc = "") {
        if (isset($this->session->userdata('user_details')[0]->users_id)) {
            $useride = $this->session->userdata('user_details')[0]->users_id;
        } else {
            $useride = 0;
        }

        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $insertarray["ip"] = $ipaddress;
        $insertarray["action"] = $action;
        $insertarray["description"] = $desc;
        $insertarray["user_id"] = $useride;
        $insertarray["entry_date"] = date("Y-m-d H:i:s");
        $this->db->insert('system_logs ', $insertarray);
    }

    public function add_event() {
        // echo "<pre>";
        // print_r($_POST);die;
        //$b_dis = $_REQUEST["bird_distance"];
        //echo "<pre>"; print_r($_POST); die;
        date_default_timezone_set('Asia/Kolkata');
        $current_date = date('Y-m-d H:i:s');
        $eventdate = date('Y-m-d H:i:s', strtotime($_POST["event_sch_date"]));
        $eventenddate = date('Y-m-d H:i:s', strtotime($_POST["event_end_date"]));

        $b_type = array();
        $bird_dis = array();
        $bird_type = array();
        $start_date = array();
        $End_date = array();
        $start_time = array();
        $end_time = array();
        $bording_time = array();
        for ($i = 0; $i < count($_POST["bird_distance"]); $i++) {
            $birdvalue = $_POST["bird_distance"][$i];
            $b_type[] = $_POST["select_bird_type"][$i];
            $start = ($i + 1) * 10;
            $end = ($start + 10) - 1;
            for ($j = $start; $j <= $end; $j++) {
                if (isset($_POST["start_date" . $j])) {
                    $sdate = $_POST["start_date" . $j][0];
                    $edate = $_POST["End_date" . $j][0];
                    $bird_dis['bird_distance'][] = $_POST["bird_distance"][$i];
                    $bird_type['select_bird_type'][] = $_POST["select_bird_type"][$i];
                    $bird_tag_color['select_bird_tag_color'][] = $_POST["select_bird_tag_color"][$i];
                    $start_date['race_date'][] = date('Y-m-d', strtotime($sdate));
                    $End_date['raceend_date'][] = date('Y-m-d', strtotime($sdate));
                    $start_time['start_time'][] = $_POST["start_time" . $j][0];
                    $end_time['end_time'][] = $_POST["end_time" . $j][0];
                    $bording_time['time_distance'][] = $_POST["time_distance" . $j][0];
                }
            }

        }

        $table_name = 'ppa_events';
        $where = array('Org_id' => $_POST["org_name"], 'Event_date' => $eventdate, 'Eventend_date' => $eventenddate, 'Event_name' => $_POST["event_name"]);
        $chkevent = $this->Event_model->event_validate($table_name, $where);
        if ($chkevent == 1) {
            $data['Org_id'] = $_POST["org_name"];
            $data['Event_name'] = $_POST["event_name"];
            $data['Event_lat'] = $_POST["event_latitude"];
            $data['Event_long'] = $_POST["event_longitude"];
            $data['Event_date'] = $eventdate;
            $data['Eventend_date'] = $eventenddate;
            $data['Created_date'] = $current_date;
            $event_id = $this->Event_model->insertRow($table_name, $data);

            $action = "Create new race";
            $desc = $this->session->userdata('user_details')[0]->name . " created the new race. Race name : " . $_POST["event_name"] . " & the race scheduled by " . $data['Event_date'] . " Race id : " . $event_id;
            $this->entrylog($action, $desc);

            if ($event_id != "") {
                $res = "";
                $info['event_id'] = $event_id;
                $info['created'] = $current_date;

                $detail_table = 'ppa_event_details';
                for ($j = 0; $j < count($bird_dis['bird_distance']); $j++) {
                    $info['bird_id'] = $bird_type['select_bird_type'][$j];
                    $info['race_distance'] = $bird_dis['bird_distance'][$j];
                    $info['date'] = $start_date['race_date'][$j];
                    $info['End_date'] = $End_date['raceend_date'][$j];
                    $info['start_time'] = $start_time['start_time'][$j];
                    $info['end_time'] = $end_time['end_time'][$j];
                    $info['boarding_time'] = $bording_time['time_distance'][$j];
                    $info['bird_tag_color'] = $bird_tag_color["select_bird_tag_color"][$j];
                    $info["created"] = date("Y-m-d H:i:s");
                    $event_details_id = $this->Event_model->insertRow($detail_table, $info);
                    if ($event_details_id != "") {
                        $res = 1;
                    } else {
                        $res = 0;
                    }

                }
                echo $res;
            }

        }
        exit();
        # code...
    }
    public function raceresults() {
        is_login();
        if (CheckPermission("users", "own_read")) {
            $resultid = $this->uri->segment(3);
            $data['result_data'] = $this->User_model->getresults($resultid);
            $this->load->view('include/header');
            $this->load->view('results', $data);
            $this->load->view('include/footer');
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    function sendAnroidPushNotification($title = "", $body = "", $message = "", $android_deviceide = "", $pushparameter = "", $badge = 1, $notify_key, $userreg_id = "", $apptype = "", $phone_no = "", $action = "") {
        #API access key from Google API's Console
        define('API_ACCESS_KEY', 'AAAAIIj1UWU:APA91bH47-0G7dEM90XnfldDAIOkQQ8b1gJmCd2XuqHtmuTD8a1JwoahrLiu753PKyAjjzG-xd4U9benlvUks0Ckij6kN5lZOWqGOyHIXEoAY9-LhCDqn2swIbcfjm1UkZyW1YVxMb03');

        $registrationIds = $android_deviceide;
        $msg = array
            (
            'title' => $title,
            'body' => $body,
            // "category" => $action,
            // "user_id" => $user_id,
            // "auction_id" => $auction_id,
            // "bird_id" => $bird_id,
            'icon' => 'myicon', /*Default Icon*/
            'badge' => $badge,
            'sound' => 'mySound', /*Default sound*/
        );

        $fields = array
            (
            'to' => $registrationIds,
            'notification' => $msg,
        );

        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        $date = date("Y-m-d H:i:s A");
        $logquery = $this->db->query("insert notificationlog set status ='" . $result . "',deviceid ='" . $android_deviceide . "',userid ='" . $userreg_id . "',deviceType='Android',message='" . $msg['body'] . "',action='".$action."',apptype='".$apptype."',phone_no='".$phone_no."',updatedTime='".$date."'");

        // echo "<pre>";
        // print_r($result);
        return $result;
    }


    function sendIosPushNotification($title = "", $body = "", $message = "", $GetMyDeviceId = "", $pushparameter = "", $badge = 1, $notify_key, $userreg_id = "", $apptype = "", $phone_no, $action = "") {
        try
        {

            $passphrase = '123';
            $pemfilepath = 'var/www/html/pigeonsportsclock.com/pigeon/lespotPushP12.pem';
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', $pemfilepath);
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
            $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
            if (!$fp) {
                exit;
            }
            $body['aps'] = array(
                'alert' => array(
                    'title' => $title,
                    'body' => $body,
                ),
                'badge' => (int) $badge,
                //'message' => $pushparameter,
                'sound' => '1,624',
            );
            $payload = json_encode($body);

            $msg = chr(0) . pack('n', 32) . pack('H*', $GetMyDeviceId) . pack('n', strlen($payload)) . $payload;

            $result = fwrite($fp, $msg, strlen($msg));
            // print_r($msg);

            fclose($fp);
            //return 1;
            $date = date("Y-m-d H:i:s A");
            $logquery = $this->db->query("insert notificationlog set status ='" . $result . "',deviceid ='" . $GetMyDeviceId . "',userid ='" . $userreg_id . "',deviceType='Ios',message='" . addslashes($message) . "',action='".$action."',apptype='".$apptype."',phone_no='".$phone_no."',updatedTime='".$date."'");
            return $result;

        } catch (Exception $e) {
            print_r($e);
        }

    }

    public function update_category() {
        # code...
        // echo "<pre>";
        // print_r($_POST);die;
        $eventID = $_POST['event_id'];
        $event_table = 'ppa_events';
        $event_table_col = 'Events_id';
        $data['Event_date'] = date('Y-m-d', strtotime($_POST['view_date']));
        $data['Eventend_date'] = date('Y-m-d', strtotime($_POST['view_end_race_date']));
        $data['Event_name'] = $_POST['view_name'];
        $data['Event_lat'] = $_POST['view_latitude'];
        $data['Event_long'] = $_POST['view_longitude'];

        $action = "Edit the race";
        $desc = $this->session->userdata('user_details')[0]->name . " updated the race. Race name : " . $_POST["view_name"] . " & the race scheduled by " . $data['Event_date'] . " Race id : " . $_POST["event_id"];
        $this->entrylog($action, $desc);

        // desc:Twilight Admin updated the race. Race name : test_race_5000 & the race scheduled by 2020-10-20 Race id : 975

        $res = $this->Event_model->updateRow($event_table, $event_table_col, $eventID, $data);
        if ($res != "") {
            //$this->Event_model->DeleteEvents($eventID);
            $rs = '';
            for ($i = 0; $i < count($_POST['race_distance']); $i++) {
                # code...

                if (isset($_POST['event_det_id'][$i]) && $_POST['event_det_id'][$i] != '') {
                    $event_tab_val = $_POST['event_det_id'][$i];
                    $event_tab_col = 'ed_id';
                    $info['event_id'] = $eventID;
                    $info['race_distance'] = $_POST['race_distance'][$i];
                    $info['bird_id'] = $_POST['Bird_Type'][$i];
                    $info['bird_tag_color'] = $_POST['BirdTag_color'][$i];
                    $info['date'] = date('Y-m-d', strtotime($_POST['Bird_Date'][$i]));
                    $info['End_date'] = date('Y-m-d', strtotime($_POST['Bird_Date'][$i]));
                    $info['start_time'] = $_POST['Bird_start_time'][$i];
                    $info['end_time'] = $_POST['Bird_end_time'][$i];
                    $info['boarding_time'] = $_POST['boarding_time_distance'][$i];
                    $info["Updated_date"] = date("Y-m-d H:i:s");
                    $event_details_table = 'ppa_event_details';
                    //$re = $this->Event_model->insertRow($event_details_table, $info);
                    $re = $this->Event_model->updateRow($event_details_table, $event_tab_col, $event_tab_val, $info);
                    if ($re != "") {
                        $rs = 1;
                    } else {
                        $rs = 0;
                    }

                } else {
                    $info['event_id'] = $eventID;
                    $info['race_distance'] = $_POST['race_distance'][$i];
                    $info['bird_id'] = $_POST['Bird_Type'][$i];
                    $info['bird_tag_color'] = $_POST['BirdTag_color'][$i];
                    $info['date'] = date('Y-m-d', strtotime($_POST['Bird_Date'][$i]));
                    $info['End_date'] = date('Y-m-d', strtotime($_POST['Bird_Date'][$i]));
                    $info['start_time'] = $_POST['Bird_start_time'][$i];
                    $info['end_time'] = $_POST['Bird_end_time'][$i];
                    $info['boarding_time'] = $_POST['boarding_time_distance'][$i];
                    $info["created"] = date("Y-m-d H:i:s");
                    $event_details_table = 'ppa_event_details';
                    $re = $this->Event_model->insertRow($event_details_table, $info);
                    if ($re != "") {
                        $rs = 1;
                    } else {
                        $rs = 0;
                    }

                }

            }

            // $query = $this->db->query("select ppa_register.reg_id,ppa_register.phone_no,ppa_register.apptype,ppa_register.username,ppa_register.android_id,Event_name from ppa_events inner join users on users.users_id=ppa_events.Org_id inner join ppa_register on ppa_register.apptype=users.Org_code where ppa_events.Events_id='" . $eventID . "'");

            // select ppa_register.reg_id,ppa_register.phone_no,ppa_register.apptype,ppa_register.username,ppa_register.android_id,Event_name from ppa_events inner join users on users.users_id=ppa_events.Org_id inner join ppa_register on ppa_register.apptype=users.Org_code where ppa_events.Events_id='1025'

            $query = $this->db->query("SELECT * FROM ppa_register AS A
            INNER JOIN
            ppa_basketing AS B ON
            A.reg_id = B.fancier_id
            LEFT JOIN
            ppa_events AS C ON
            B.event_id = C.Events_id
            where C.Events_id='" . $eventID . "'");

            $event_de = $query->result();
            foreach ($event_de as $key => $value) {
                # code...
                $android_deviceide = $value->android_id;
                $apptype = $value->apptype;
                $phone_no = $value->phone_no;
                $username = $value->username;
                $event_name = $value->Event_name;
                $userreg_id = $value->reg_id;

                $title = "Race timings updated";
                $message = "Dear " . $username . " " . "Event name:" . $event_name . " race timings has been updated. Please check out!..";
                $body = "Dear " . $username . " " . "Event name:" . $event_name . " race timings has been updated. Please check out!..";
                $pushparameter = "";
                $badge = 1;
                $pushparameter = '{"ResponseCode":"200","badge":"1"}';
                $action = "Race updated";

                if (strlen($android_deviceide) == 64) 
                {
                    $pushparameter = "";
                    $badge = 1;
                    $notify_key = 1;
                    $this->sendIosPushNotification($title, $body, $message, $android_deviceide, $pushparameter, $badge, $notify_key, $userreg_id, $apptype, $phone_no, $action);
                } 
                else 
                {
                    $pushparameter = "";
                    $badge = 1;
                    $this->sendAnroidPushNotification($title, $body, $message, $android_deviceide, $pushparameter, $badge, $notify_key, $userreg_id, $apptype, $phone_no, $action);
                }

            }

            echo $rs;
        }

    }
    // public function sendnotification($apptype,$phone_no,$username){

    // }

    public function editrace() {
        is_login();
        if (CheckPermission("users", "own_read")) {
            $eventid = $this->uri->segment(3);
            $eventid = base64_decode(urldecode($eventid));
            $event_table = 'ppa_events';
            $eve_col = 'Events_id';
            $data['event_list'] = $this->Event_model->get_data_by($event_table, $eventid, $eve_col);
            $org_id = $data['event_list'][0]->Org_id;
            $org_table = 'users';
            $org_col = 'users_id';
            $data['org_list'] = $this->Event_model->get_data_by($org_table, $org_id, $org_col);
            $bird_table = 'ppa_bird_type';
            $bird_column = 'user_id';
            $bird_sticker_table = 'pigeon_sticker_colors';
            $data['bird_type'] = $this->Event_model->get_data_by($bird_table, $org_id, $bird_column);
            $data['bird_sticker_color'] = $this->Event_model->get_data_by($bird_sticker_table, $org_id, $bird_column);
            // $user_id = $this->session->userdata("user_details")[0]->users_id;
            // $apptype = $this->session->userdata("user_details")[0]->Org_code;
            // $bird_type = $this->db->query("select bird_type from ppa_bird_type where user_id='".$user_id."' and apptype='".$apptype."'");
            // $get_bird_color = $bird_type->row_array();
            // $data['bird_type'] = $get_bird_color;
            $event_detail_table = 'ppa_event_details';
            $event_det_col = 'event_id';
            $data['event_details'] = $this->Event_model->get_data_by($event_detail_table, $eventid, $event_det_col);

            $this->load->view('include/header');
            $this->load->view('edit_race', $data);
            $this->load->view('include/footer');
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    public function races_list() {
        is_login();
        if (CheckPermission("users", "own_read")) {
            $this->load->view('include/header');
            $this->load->view('race_table');
            $this->load->view('include/footer');
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }
    public function event_deleted() {
        # code...
        $event_id = $_POST['ids'];
        $get_event_name = $this->db->query("select * from ppa_event_details where ed_id = '".$event_id."'");
        $event_name = $get_event_name->row_array();
        $bird_id = $event_name['bird_id'];
        $action = "Race event category removed";
        $desc = $this->session->userdata('user_details')[0]->name . " removed the list of events category (". $bird_id ." ". $event_id . ")";
        $this->User_model->entrylog($action, $desc);

        $ras = $this->Event_model->delete_event_details($event_id);
        $res = '';
        if ($ras == '') {
            $res = 1;
        }
        echo $res;
        exit();
    }
    public function update_main_event() {
        # code...
        date_default_timezone_set('Asia/Kolkata');
        $current_date = date('Y-m-d H:i:s');
        $eventdate = date('Y-m-d', strtotime($_POST["event_sche_date"]));
        $data['Event_name'] = $_POST["event_name"];
        $data['Event_lat'] = $_POST["event_lat"];
        $data['Event_long'] = $_POST["event_long"];
        $data['Event_date'] = $eventdate;
        $data['Updated_date'] = $current_date;
        $table = 'ppa_events';
        $col = 'Events_id';

        $action = "Edit the race";
        $desc = $this->session->userdata('user_details')[0]->name . " updated the race. Race name : " . $_POST["event_name"] . " & the race scheduled by " . $data['Event_date'] . " Race id : " . $_POST["event_id"];
        $this->entrylog($action, $desc);

        echo $update_event = $this->Event_model->updateRow($table, $col, $_POST["event_id"], $data);
        exit();
    }
    public function update_event_details() {
        //       echo "<pre>";
        // print_r($_POST);
        //  echo "</pre>";
        // die();
        # code...
        date_default_timezone_set('Asia/Kolkata');
        $current_date = date('Y-m-d H:i:s');
        $racedate = date('Y-m-d', strtotime($_POST["bird_date"]));
        $event_id = $_POST["event_id"];
        $event_details_id = $_POST["event_details_id"];
        $data['bird_id'] = $_POST["bird_type"];
        $data['date'] = $racedate;
        $data['start_time'] = $_POST["bird_start_time"];
        $data['end_time'] = $_POST["bird_end_time"];
        $data['boarding_time'] = $_POST["boarding_time"];
        $data['Updated_date'] = $current_date;

        $table = 'ppa_event_details';
        $col = 'ed_id';
        echo $update_event = $this->Event_model->updateRow($table, $col, $event_details_id, $data);
        exit();
    }
    public function add_anoter_event() {
        date_default_timezone_set('Asia/Kolkata');
        $current_date = date('Y-m-d H:i:s');

        $evet_id = $_POST["event_id"];
        $b_dis = $_POST["bird_distance"];
        $b_type = $_POST["select_bird_type"];
        $b_tag_color = $_POST["select_bird_tag_color"];
        $dates = $_REQUEST["start_date10"];
        $start_date = array();
        $start_time = array();
        $end_time = array();
        $bording_time = array();

        for ($i = 10; $i < 20; $i++) {
            if (isset($_POST["start_date" . $i])) {
                $sdate = $_POST["start_date" . $i][0];
                $start_date['start_date'][] = date('Y-m-d', strtotime($sdate));
                $start_time['start_time'][] = $_POST["start_time" . $i][0];
                $end_time['end_time'][] = $_POST["end_time" . $i][0];
                $bording_time['time_distance'][] = $_POST["time_distance" . $i][0];

            }
        }

        $info['event_id'] = $evet_id;
        $info['bird_id'] = $b_type[0];
        $info['bird_tag_color'] = $b_tag_color[0];
        $info['race_distance'] = $b_dis[0];
        $detail_table = 'ppa_event_details';
        $res = '';
        for ($j = 0; $j < count($start_date['start_date']); $j++) {
            $info['date'] = $start_date['start_date'][$j];
            $info['start_time'] = $start_time['start_time'][$j];
            $info['end_time'] = $end_time['end_time'][$j];
            $info['boarding_time'] = $bording_time['time_distance'][$j];
            $info['created'] = $current_date;
            $event_details_id = $this->Event_model->insertRow($detail_table, $info);
            if ($event_details_id != "") {
                $res = 1;
            } else {
                $res = 0;
            }
        }
        echo $res;
        exit();
    }
    public function changeaccountstatus() {
        $status = $_POST["status"];
        $ide = $_POST["ide"];
        $query = $this->db->query("update ppa_register set status='" . $status . "' where reg_id='" . $ide . "'");
        // echo "update ppa_register set status='".$status."' where reg_id='".$ide."'";
        echo "0";

    }
    public function changeresultstatus() {
        $status = $_POST["status"];
        $ide = $_POST["ide"];
        $query = $this->db->query("update ppa_events set result_publish='" . $status . "' where Events_id='" . $ide . "'");
        // echo "update ppa_register set status='".$status."' where reg_id='".$ide."'";
        if ($status == "0") {
            $html = "Unpublished <a style='cursor:pointer;' onclick=changeresultstatus(" . $ide . ",'1')>Make Publish</a>";
        } else {
            $html = "Published <a style='cursor:pointer;' onclick=changeresultstatus(" . $ide . ",'0')>Make Unpublish</a>";
        }

        echo $html;

    }

    public function changeclubstatus() {
        $status = $_POST["status"];
        $ide = $_POST["ide"];
        $query = $this->db->query("update users set Org_status='" . $status . "' where users_id='" . $ide . "'");
        // echo "update ppa_register set status='".$status."' where reg_id='".$ide."'";
        echo "0";

    }
    public function clearresult($id) {
        $query = $this->db->query("delete from ppa_report  where event_id='" . $id . "'");
        $this->session->set_flashdata('messagePr', 'Results cleared successfully');
        redirect(base_url() . 'user/raceresults/' . $id, 'refresh');
    }

    public function updateresult() {
        $eventdetailide = $_POST["eventdetailid"];
        $eventide = $_POST["eventide"];
        $gender = $_POST["gender"];
        $birdcolor = $_POST["birdcolor"];
        $ringno = $_POST["ringno"];
        for ($ide = 0; $ide < count($ringno); $ide++) {
            $updateringno = $ringno[$ide];
            $updatebirdcolor = $birdcolor[$ide];
            $updatebirdgender = $gender[$ide];
            $reportide = $eventdetailide[$ide];
            $query = $this->db->query("update ppa_report set ring_no='" . $updateringno . "',bird_gender='" . $updatebirdgender . "',bird_color='" . $updatebirdcolor . "' where report_id='" . $reportide . "'");
        }
        // $this->session->set_flashdata('messagePr', 'Results data updated successfully');
        // redirect( base_url().'user/raceresults/'.$eventide, 'refresh');*/

    }

    public function updatelatlong() {
        $lat = $_POST["lat"];
        $long = $_POST["long"];
        $ide = $_POST["fancier_id"];
        $query = $this->db->query("update ppa_register set latitude='" . $lat . "',longitude='" . $long . "' where reg_id='" . $ide . "'");
        $this->session->set_flashdata('messagePr', 'Latitude and longitude details updated Successfully');
        redirect(base_url() . 'user/fancier', 'refresh');
    }

    /**
     * This function is used to create datatable in users list page
     * @return Void
     */
    public function dataTable() {
        is_login();
        $table = 'users';
        $primaryKey = 'users_id';
        $columns = array(
            array('db' => 'users_id', 'dt' => 0),
            array('db' => 'name', 'dt' => 1),
            array('db' => 'email', 'dt' => 2),
            array('db' => 'phone_no', 'dt' => 3),
            array('db' => 'address', 'dt' => 4),
            array('db' => 'Expire_date', 'dt' => 5),
            array('db' => 'Org_status', 'dt' => 6),
            array('db' => 'users_id', 'dt' => 7),
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname,
        );
        $where = array("user_type != 'admin'");
        $output_arr = SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where);
        $rows = $_REQUEST["start"] + 1;
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key]) - 1];
            $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] = '';
            if (CheckPermission($table, "all_update")) {
                $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="Edit"><i class="fa fa-pencil" data-id=""></i></a><a id="btnViewRow" class="modalClubview mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="View Details"><i class="fa fa-eye" data-id=""></i></a>';
            } else if (CheckPermission($table, "own_update") && (CheckPermission($table, "all_update") != true)) {
                $user_id = getRowByTableColomId($table, $id, 'users_id', 'user_id');
                if ($user_id == $this->user_id) {
                    $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="Edit"><i class="fa fa-pencil" data-id=""></i></a><a id="btnViewRow" class="modalClubview mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="View Details"><i class="fa fa-eye" data-id=""></i></a>';
                }
            }

            if (trim($output_arr['data'][$key][6]) == '0') {
                $output_arr['data'][$key][6] = '<span style="color:red;">Inactive</span> <br> <a style="cursor:pointer;" onclick="changeclubstatus(' . $id . ',1);">Make Active</a>';
            } else {
                $output_arr['data'][$key][6] = '<span style="color:green;">Active</span> <br> <a style="cursor:pointer;"  onclick="changeclubstatus(' . $id . ',0);">Make Inactive</a>';
            }

            /*if(CheckPermission($table, "all_delete")){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
            else if(CheckPermission($table, "own_delete") && (CheckPermission($table, "all_delete")!=true)){
            $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
            if($user_id==$this->user_id){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
            }
             */

            $output_arr['data'][$key][0] = $rows;
            $rows++;
        }
        echo json_encode($output_arr);
    }

    public function fancierTable() {
        is_login();
        $table = 'ppa_register';
        $primaryKey = 'reg_id';
        $columns = array(
            array('db' => 'reg_id', 'dt' => 0),
            array('db' => 'reg_id', 'dt' => 1),
            array('db' => 'username', 'dt' => 2),
            array('db' => 'phone_no', 'dt' => 3),
            array('db' => 'address', 'dt' => 4),
            array('db' => 'status', 'dt' => 5),
            array('db' => 'loftstatus', 'dt' => 6),
            array('db' => 'reg_id', 'dt' => 7),
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname,
        );

        $clubtype = $this->session->userdata('user_details')[0]->Org_code;

        if (trim($clubtype) != '' && $this->session->userdata('user_details')[0]->user_type != 'Admin') {
            $where = array("apptype = '" . $clubtype . "'");
        } else {
            $where = "";
        }

        $output_arr = SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where);
        $rows = $_REQUEST["start"] + 1;
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key]) - 1];
            $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] = '';

            $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a id="btnEditRow" class="btnfancierview mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="View Details"><i class="fa fa-eye" data-id=""></i></a>';

            /* if(CheckPermission($table, "all_delete")){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
            else if(CheckPermission($table, "own_delete") && (CheckPermission($table, "all_delete")!=true)){
            $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
            if($user_id==$this->user_id){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
            }
             */

            if (trim($output_arr['data'][$key][4]) == '0') {
                $output_arr['data'][$key][4] = '<span style="color:red;">Inactive</span> <br> <a style="cursor:pointer;" onclick="changestatus(' . $id . ',1);">Make Active</a>';
            } else {
                $output_arr['data'][$key][4] = '<span style="color:green;">Active</span> <br> <a style="cursor:pointer;"  onclick="changestatus(' . $id . ',0);">Make Inactive</a>';
            }

            if (trim($output_arr['data'][$key][5]) == '0') {
                $output_arr['data'][$key][5] = '<span style="color:red;">Inactive</span> <br> <a style="cursor:pointer;" onclick="changeloftstatus(' . $id . ',1);">Make Active</a>';
            } else {
                $output_arr['data'][$key][5] = '<span style="color:green;">Active</span> <br> <a style="cursor:pointer;"  onclick="changeloftstatus(' . $id . ',0);">Make Inactive</a>';
            }

            //$output_arr['data'][$key][0] = "<input type='checkbox' value='".$id."' name='selData'>";
            $output_arr['data'][$key][1] = '<input type="checkbox" name="selData" value="' . $id . '">';
            $output_arr['data'][$key][0] = $rows;
            $rows++;

        }
        echo json_encode($output_arr);
    }

    public function resultsTable() {
        is_login();
        $raceeventide = $_GET["event"];
        $table = 'ppa_report';
        $primaryKey = 'report_id';
        if (isset($_GET["editmode"]) && $_GET["editmode"] != 0) {
            $editmode = 1;
        } else {
            $editmode = 0;
        }

        if (isset($_GET["birdtype"]) && $_GET["birdtype"] != '') {
            $birdtype = $_GET["birdtype"];
        } else {
            $birdtype = '';
        }

        //
        $birdcolor[] = "Dark Chequer";
        $birdcolor[] = "Dark Chequer Pied";
        $birdcolor[] = "Dark Chequer WF";
        $birdcolor[] = "Light Chequer";
        $birdcolor[] = "Light Chequer Pied";
        $birdcolor[] = "Light Chequer WF";
        $birdcolor[] = "Red Chequer";
        $birdcolor[] = "Red Chequer Pied";
        $birdcolor[] = "Red Chequer WF";
        $birdcolor[] = "Blue";
        $birdcolor[] = "Blue Pied";
        $birdcolor[] = "Blue WF";
        $birdcolor[] = "Mealey";
        $birdcolor[] = "Mealey Pied";
        $birdcolor[] = "Mealey WF";
        $birdcolor[] = "Jack";
        $birdcolor[] = "Jack Pied";
        $birdcolor[] = "Jack WF";
        $birdcolor[] = "Grizzle";
        $birdcolor[] = "Soomun";
        $genderarray[] = "Male";
        $genderarray[] = "Female";
        //
        $columns = array(
            array('db' => 'c.report_id', 'dt' => 0, 'field' => 'report_id'),
            array('db' => 'c.name', 'dt' => 1, 'field' => 'name'),
            array('db' => 'c.mobile_number', 'dt' => 2, 'field' => 'mobile_number'),
            array('db' => 'd.name as clubname', 'dt' => 3, 'field' => 'clubname'),
            array('db' => 'e.brid_type', 'dt' => 4, 'field' => 'brid_type'),
            array('db' => 'c.ring_no', 'dt' => 5, 'field' => 'ring_no'),
            array('db' => 'c.bird_gender', 'dt' => 6, 'field' => 'bird_gender'),
            array('db' => 'c.bird_color', 'dt' => 7, 'field' => 'bird_color'),

            array('db' => 'c.start_date', 'dt' => 8, 'field' => 'start_date'),
            array('db' => 'c.start_time', 'dt' => 9, 'field' => 'start_time'),
            array('db' => 'c.intervel', 'dt' => 10, 'field' => 'intervel'),
            array('db' => 'c.intervel', 'dt' => 11, 'field' => 'intervel'),
            array('db' => 'c.minis', 'dt' => 12, 'field' => 'minis'),
            array('db' => 'c.distance', 'dt' => 13, 'field' => 'distance'),
            array('db' => 'c.velocity', 'dt' => 14, 'field' => 'velocity'),
            array('db' => 'c.latitude', 'dt' => 15, 'field' => 'latitude'),
            array('db' => 'c.longtitude', 'dt' => 16, 'field' => 'longtitude'),
        );

        //array( 'db' => 'CONCAT("Name : ",c.name,"<br> Mobile : ",c.mobile_number,"<br> Club : ",d.name)', 'dt' => 1 ,'field' => 'CONCAT("Name : ",c.name,"<br> Mobile : ",c.mobile_number,"<br> Club : ",d.name)'),
        //       array( 'db' => 'c.mobile_number', 'dt' => 2 ,'field' => 'mobile_number'),

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname,
        );

        $clubtype = $this->session->userdata('user_details')[0]->Org_code;
        $Join_condition = ' from ppa_report as c LEFT JOIN users as d ON d.users_id = c.clubtype LEFT JOIN ppa_bird_type as e ON e.b_id=c.bird_type_id';
        // if(trim($clubtype)!='' && $this->session->userdata('user_details')[0]->user_type !='Admin')
        if ($birdtype != '') {
            $where = "c.event_id = '" . $raceeventide . "' and c.bird_type_id = '" . $birdtype . "'";
        } else {
            $where = "c.event_id = '" . $raceeventide . "'";
        }

        // else
        // $where = "";
        $groupby = "c.report_id";
        //$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$Join_condition, $where);
        $output_arr = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $Join_condition, $where, $groupby);
        $rows = $_REQUEST["start"] + 1;
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key]) - 1];
            $report = $output_arr['data'][$key][4];
            //$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';

            /*
            if(trim($output_arr['data'][$key][4])!='' && $output_arr['data'][$key][4] > 0) // Race completed wont delete and edit
            {
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="btnfancierview mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View race Details"><i class="fa fa-eye" data-id=""></i></a>';
            }
            else
            {
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="'.base_url().'user/editrace/'.$id.'"  type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a><a id="btnEditRow" class="btnfancierview mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View race Details"><i class="fa fa-eye" data-id=""></i></a><a data-toggle="modal" class="mClass" onclick="seteventId('.$id.', \'user\')"   data-src="'.$id.'" data-target="#cnfrm_delete" title="Delete race"><i class="fa fa-trash" data-id=""></i></a>';
            }
            $timezone = "Asia/Kolkata";
            date_default_timezone_set($timezone);
            $curdate = date("Y-m-d");

            if(trim($output_arr['data'][$key][3])>$curdate)
            $output_arr['data'][$key][4] = "<span style=color:orange;font-weight:bold;>Upcoming</span>";
            else if(trim($output_arr['data'][$key][3])==$curdate)
            $output_arr['data'][$key][4] = "<span style=color:green;font-weight:bold;>LIVE</span>";
            else
             */

            $output_arr['data'][$key][10] = date('d-m-Y', ($output_arr['data'][$key][10] / 1000));
            $output_arr['data'][$key][11] = date('h:i:s A', ($output_arr['data'][$key][11] / 1000));

            if ($editmode == 1) {
                $output_arr['data'][$key][5] = "<input class='form-group' type='textbox' name='ringno[]' value='" . $output_arr['data'][$key][5] . "'>";
                $birdcolordropdown = "<select name=birdcolor[]>";
                $colorhightlight = '';
                for ($t = 0; $t < count($birdcolor); $t++) {
                    if ($output_arr['data'][$key][7] == $birdcolor[$t]) {
                        $colorhightlight = "selected";
                    } else {
                        $colorhightlight = "";
                    }

                    $birdcolordropdown .= "<option " . $colorhightlight . " value='" . $birdcolor[$t] . "'>" . $birdcolor[$t] . "</option>";
                }
                $birdcolordropdown .= "<select>";

                $genderdropdown = "<select name=gender[]>";
                $genderhightlight = '';
                for ($t = 0; $t < count($genderarray); $t++) {
                    if ($output_arr['data'][$key][6] == $genderarray[$t]) {
                        $genderhightlight = "selected";
                    } else {
                        $genderhightlight = "";
                    }

                    $genderdropdown .= "<option " . $genderhightlight . " value='" . $genderarray[$t] . "'>" . $genderarray[$t] . "</option>";
                }
                $genderdropdown .= "<select>";

                // $genderdropdown = "<select><option value='Male'>Male</option><option value='Female'>Female</option></select>";

                $output_arr['data'][$key][6] = $genderdropdown;
                $output_arr['data'][$key][7] = $birdcolordropdown;
            }

            $output_arr['data'][$key][0] = "<input type='hidden' name='eventdetailid[]' value='" . $output_arr['data'][$key][0] . "'>" . $rows;
            $rows++;

        }
        echo json_encode($output_arr);
    }

    public function racesTable() {
        is_login();
        $table = 'ppa_events';
        $primaryKey = 'Events_id';

        $columns = array(
            array('db' => 'c.Events_id', 'dt' => 0, 'field' => 'Events_id'), array('db' => 'c.Event_name', 'dt' => 1, 'field' => 'Event_name'),
            array('db' => 'd.name', 'dt' => 2, 'field' => 'name'),
            array('db' => 'c.Event_date', 'dt' => 3, 'field' => 'Event_date'),
            array('db' => 'e.event_id', 'dt' => 4, 'field' => 'event_id'),
            array('db' => 'c.Events_id', 'dt' => 5, 'field' => 'Events_id'),
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname,
        );

        $clubtype = $this->session->userdata('user_details')[0]->Org_code;
        $Join_condition = ' from ppa_events as c LEFT JOIN users as d ON d.users_id = c.Org_id LEFT JOIN ppa_report as e ON e.event_id=c.Events_id';
        if (trim($clubtype) != '' && $this->session->userdata('user_details')[0]->user_type != 'Admin') {
            $where = array("d.Org_code = '" . $clubtype . "'");
        } else {
            $where = "";
        }

        $groupby = "c.Events_id";
        //$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$Join_condition, $where);
        $output_arr = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $Join_condition, $where, $groupby);
        $rows = $_REQUEST["start"] + 1;
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key]) - 1];
            $report = $output_arr['data'][$key][4];
            $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] = '';

            $timezone = "Asia/Kolkata";
            date_default_timezone_set($timezone);
            $curdate = date("Y-m-d");

            if (trim($output_arr['data'][$key][4]) != '' && $output_arr['data'][$key][4] > 0) // Race completed wont delete and edit
            {
                $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a id="btnEditRow" class="btnfancierview mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="View race Details"><i class="fa fa-eye" data-id=""></i></a>';
                if (trim($output_arr['data'][$key][3]) > $curdate) {
                    $output_arr['data'][$key][4] = "<span style=color:orange;font-weight:bold;>Upcoming</span>";
                } else if (trim($output_arr['data'][$key][3]) == $curdate) {
                    $output_arr['data'][$key][4] = "<span style=color:green;font-weight:bold;>LIVE</span>";
                } else {
                    $output_arr['data'][$key][4] = "<span style=color:blue;font-weight:bold;>Completed</span><br><a href='" . base_url() . 'user/raceresults/' . $id . "'>View Results</a>";
                }

            } else {
                $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="' . base_url() . 'races/editrace/' . $id . '"  type="button" data-src="' . $id . '" title="Edit"><i class="fa fa-pencil" data-id=""></i></a><a id="btnEditRow" class="btnfancierview mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="View race Details"><i class="fa fa-eye" data-id=""></i></a><a data-toggle="modal" class="mClass" onclick="seteventId(' . $id . ', \'user\')"   data-src="' . $id . '" data-target="#cnfrm_delete" title="Delete race"><i class="fa fa-trash" data-id=""></i></a>';

                if (trim($output_arr['data'][$key][3]) > $curdate) {
                    $output_arr['data'][$key][4] = "<span style=color:orange;font-weight:bold;>Upcoming</span>";
                } else if (trim($output_arr['data'][$key][3]) == $curdate) {
                    $output_arr['data'][$key][4] = "<span style=color:green;font-weight:bold;>LIVE</span>";
                } else {
                    $output_arr['data'][$key][4] = "<span style=color:blue;font-weight:bold;>Completed</span>";
                }

            }

            /* if(CheckPermission($table, "all_delete")){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
            else if(CheckPermission($table, "own_delete") && (CheckPermission($table, "all_delete")!=true)){
            $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
            if($user_id==$this->user_id){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
            }
            }

            if(trim($output_arr['data'][$key][4])=='0')
            $output_arr['data'][$key][4] = '<span style="color:red;">Inactive</span> <br> <a style="cursor:pointer;" onclick="changestatus('.$id.',1);">Make Active</a>';
            else
            $output_arr['data'][$key][4] = '<span style="color:green;">Active</span> <br> <a style="cursor:pointer;"  onclick="changestatus('.$id.',0);">Make Inactive</a>';

            if(trim($output_arr['data'][$key][5])=='0')
            $output_arr['data'][$key][5] = '<span style="color:red;">Inactive</span> <br> <a style="cursor:pointer;" onclick="changeloftstatus('.$id.',1);">Make Active</a>';
            else
             */

            //$output_arr['data'][$key][0] = "<input type='checkbox' value='".$id."' name='selData'>";
            $output_arr['data'][$key][0] = $rows;
            $rows++;

        }
        echo json_encode($output_arr);
    }

    /**
     * This function is Showing users profile
     * @return Void
     */
    public function profile($id = '') {
        is_login();
        if (!isset($id) || $id == '') {
            $id = $this->session->userdata('user_details')[0]->users_id;
        }
        $data['user_data'] = $this->User_model->get_users($id);
        $this->load->view('include/header');
        $this->load->view('profile', $data);
        $this->load->view('include/footer');
    }

    /**
     * This function is used to show popup of user to add and update
     * @return Void
     */
    public function get_modal() {
        is_login();
        if ($this->input->post('id')) {
            $data['userData'] = getDataByid('users', $this->input->post('id'), 'users_id');
            echo $this->load->view('add_user', $data, true);
        } else {
            echo $this->load->view('add_user', '', true);
        }
        exit;
    }

    public function get_clubview() {
        is_login();
        if ($this->input->post('id')) {
            $data['clubData'] = getDataByid('users', $this->input->post('id'), 'users_id');
            echo $this->load->view('clubview', $data, true);
        } else {
            echo $this->load->view('clubview', '', true);
        }
        exit;
    }

    public function get_fancierview() {
        is_login();
        if ($this->input->post('id')) {
            $data['fancierData'] = $this->User_model->getfancierdetails($this->input->post('id'));
            echo $this->load->view('fancierview', $data, true);
        } else {
            echo $this->load->view('fancierview', '', true);
        }
        exit;
    }

    /**
     * This function is used to upload file
     * @return Void
     */
    function upload() {
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'assets/images/';
            $config['upload_url'] = base_url() . 'assets/images/';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "assets/images/" . $newname);
            return $newname;
        }
    }

    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add_edit($id = '') {
        $data = $this->input->post();
        $profile_pic = 'user.png';
        if ($this->input->post('users_id')) {
            $id = $this->input->post('users_id');
        }
        if (isset($this->session->userdata('user_details')[0]->users_id)) {
            if ($this->input->post('users_id') == $this->session->userdata('user_details')[0]->users_id) {
                $redirect = 'profile';
            } else {
                $redirect = 'userTable';
            }
        } else {
            $redirect = 'login';
        }
        if ($this->input->post('fileOld')) {
            $newname = $this->input->post('fileOld');
            $profile_pic = $newname;
        } else {
            $data[$name] = '';
            $profile_pic = 'user.png';
        }
        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $data[$name] = $newname;
                $profile_pic = $newname;
            } else {
                if ($this->input->post('fileOld')) {
                    $newname = $this->input->post('fileOld');
                    $data[$name] = $newname;
                    $profile_pic = $newname;
                } else {
                    $data[$name] = '';
                    $profile_pic = 'user.png';
                }
            }
        }
        if ($id != '') {
            $data = $this->input->post();
            if ($this->input->post('status') != '') {
                $data['status'] = $this->input->post('status');
            }
            if ($this->input->post('users_id') == 1) {
                $data['user_type'] = 'admin';
            }
            if ($this->input->post('password') != '') {
                if ($this->input->post('currentpassword') != '') {
                    $old_row = getDataByid('users', $this->input->post('users_id'), 'users_id');
                    if (password_verify($this->input->post('currentpassword'), $old_row->password)) {
                        if ($this->input->post('password') == $this->input->post('confirmPassword')) {
                            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                            $data['password'] = $password;
                        } else {
                            $this->session->set_flashdata('messagePr', 'Password and confirm password should be same...');
                            redirect(base_url() . 'user/' . $redirect, 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('messagePr', 'Enter Valid Current Password...');
                        redirect(base_url() . 'user/' . $redirect, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('messagePr', 'Current password is required');
                    redirect(base_url() . 'user/' . $redirect, 'refresh');
                }
            }
            $id = $this->input->post('users_id');
            unset($data['fileOld']);
            unset($data['currentpassword']);
            unset($data['confirmPassword']);
            unset($data['users_id']);
            unset($data['user_type']);
            if (isset($data['edit'])) {
                unset($data['edit']);
            }
            if ($data['password'] == '') {
                unset($data['password']);
            }
            $data['profile_pic'] = $profile_pic;
            $data['phone_no'] = $this->input->post('phone_no');
            $data['address'] = $this->input->post('address');
            $this->User_model->updateRow('users', 'users_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect(base_url() . 'user/' . $redirect, 'refresh');
        } else {
            if ($this->input->post('user_type') != 'admin') {
                $data = $this->input->post();
                $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                $checkValue = $this->User_model->check_exists('users', 'email', $this->input->post('email'));
                if ($checkValue == false) {
                    $this->session->set_flashdata('messagePr', 'This Email Already Registered with us..');
                    redirect(base_url() . 'user/userTable', 'refresh');
                }
                $checkValue1 = $this->User_model->check_exists('users', 'name', $this->input->post('name'));
                if ($checkValue1 == false) {
                    $this->session->set_flashdata('messagePr', 'Username Already Registered with us..');
                    redirect(base_url() . 'user/userTable', 'refresh');
                }
                $data['status'] = 'active';
                if (setting_all('admin_approval') == 1) {
                    $data['status'] = 'deleted';
                }

                if ($this->input->post('status') != '') {
                    $data['status'] = $this->input->post('status');
                }
                //$data['token'] = $this->generate_token();
                $data['user_id'] = $this->user_id;
                $data['password'] = $password;
                $data['profile_pic'] = $profile_pic;
                $data['is_deleted'] = 0;
                if (isset($data['password_confirmation'])) {
                    unset($data['password_confirmation']);
                }
                if (isset($data['call_from'])) {
                    unset($data['call_from']);
                }
                unset($data['submit']);
                $this->User_model->insertRow('users', $data);
                redirect(base_url() . 'user/' . $redirect, 'refresh');
            } else {
                $this->session->set_flashdata('messagePr', 'You Don\'t have this autherity ');
                redirect(base_url() . 'user/registration', 'refresh');
            }
        }

    }

    /**
     * This function is used to delete users
     * @return Void
     */
    public function delete($id) {
        is_login();
        $ids = explode('-', $id);
        foreach ($ids as $id) {
            $this->User_model->delete($id);
        }
        redirect(base_url() . 'user/userTable', 'refresh');
    }

    public function raceeventdelete($id) {
        is_login();
        $ids = explode('-', $id);
        foreach ($ids as $id) {
            $this->Event_model->deleteevent($id);
        }
        $this->session->set_flashdata('messagePr', 'Race event deleted successfully');
        redirect(base_url() . 'events/races', 'refresh');
    }

    public function changestatusall($id) {
        is_login();
        $data = explode('_', $id);
        $ids = explode('-', $data[1]);
        foreach ($ids as $id) {
            $this->User_model->changetatusbyid($id, $data[0]);
        }
        $this->session->set_flashdata('messagePr', 'Fancier status changed successfully');
        redirect(base_url() . 'user/fancier', 'refresh');
    }

    /**
     * This function is used to send invitation mail to users for registration
     * @return Void
     */
    public function InvitePeople() {
        is_login();
        if ($this->input->post('emails')) {
            $setting = settings();
            $var_key = $this->randomString();
            $emailArray = explode(',', $this->input->post('emails'));
            $emailArray = array_map('trim', $emailArray);
            $body = $this->User_model->get_template('invitation');
            $result['existCount'] = 0;
            $result['seccessCount'] = 0;
            $result['invalidEmailCount'] = 0;
            $result['noTemplate'] = 0;
            if (isset($body->html) && $body->html != '') {
                $body = $body->html;
                foreach ($emailArray as $mailKey => $mailValue) {
                    if (filter_var($mailValue, FILTER_VALIDATE_EMAIL)) {
                        $res = $this->User_model->get_data_by('users', $mailValue, 'email');
                        if (is_array($res) && empty($res)) {
                            $link = (string) '<a href="' . base_url() . 'user/registration?invited=' . $var_key . '">Click here</a>';
                            $data = array('var_user_email' => $mailValue, 'var_inviation_link' => $link);
                            foreach ($data as $key => $value) {
                                $body = str_replace('{' . $key . '}', $value, $body);
                            }
                            if ($setting['mail_setting'] == 'php_mailer') {
                                $this->load->library("send_mail");
                                $emm = $this->send_mail->email('Invitation for registration', $body, $mailValue, $setting);
                            } else {
                                // content-type is required when sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $headers .= 'From: ' . $setting['EMAIL'] . "\r\n";
                                $emm = mail($mailValue, 'Invitation for registration', $body, $headers);
                            }
                            if ($emm) {
                                $darr = array('email' => $mailValue, 'var_key' => $var_key);
                                $this->User_model->insertRow('users', $darr);
                                $result['seccessCount'] += 1;
                            }
                        } else {
                            $result['existCount'] += 1;
                        }
                    } else {
                        $result['invalidEmailCount'] += 1;
                    }
                }
            } else {
                $result['noTemplate'] = 'No Email Template Availabale.';
            }
        }
        echo json_encode($result);
        exit;
    }

    /**
     * This function is used to Check invitation code for user registration
     * @return TRUE/FALSE
     */
    public function chekInvitation() {
        if ($this->input->post('code') && $this->input->post('code') != '') {
            $res = $this->User_model->get_data_by('users', $this->input->post('code'), 'var_key');
            $result = array();
            if (is_array($res) && !empty($res)) {
                $result['email'] = $res[0]->email;
                $result['users_id'] = $res[0]->users_id;
                $result['result'] = 'success';
            } else {
                $this->session->set_flashdata('messagePr', 'This code is not valid..');
                $result['result'] = 'error';
            }
        }
        echo json_encode($result);
        exit;
    }

    /**
     * This function is used to registr invited user
     * @return Void
     */
    public function register_invited($id) {
        $data = $this->input->post();
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data['password'] = $password;
        $data['var_key'] = NULL;
        $data['is_deleted'] = 0;
        $data['status'] = 'active';
        $data['user_id'] = 1;
        if (isset($data['password_confirmation'])) {
            unset($data['password_confirmation']);
        }
        if (isset($data['call_from'])) {
            unset($data['call_from']);
        }
        if (isset($data['submit'])) {
            unset($data['submit']);
        }
        $this->User_model->updateRow('users', 'users_id', $id, $data);
        $this->session->set_flashdata('messagePr', 'Successfully Registered..');
        redirect(base_url() . 'user/login', 'refresh');
    }

    /**
     * This function is used to check email is alredy exist or not
     * @return TRUE/FALSE
     */
    public function checEmailExist() {
        $result = 1;
        $res = $this->User_model->get_data_by('users', $this->input->post('email'), 'email');
        if (!empty($res)) {
            if ($res[0]->users_id != $this->input->post('uId')) {
                $result = 0;
            }
        }
        echo $result;
        exit;
    }

    /**
     * This function is used to Generate a token for varification
     * @return String
     */
    public function generate_token() {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = $alpha . $alpha_upper . $numeric;
        $token = '';
        $up_lp_char = $alpha . $alpha_upper . $special;
        $chars = str_shuffle($chars);
        $token = substr($chars, 10, 10) . strtotime("now") . substr($up_lp_char, 8, 8);
        return $token;
    }

    /**
     * This function is used to Generate a random string
     * @return String
     */
    public function randomString() {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = $alpha . $alpha_upper . $numeric;
        $pw = '';
        $chars = str_shuffle($chars);
        $pw = substr($chars, 8, 8);
        return $pw;
    }

    public function checkFancierType() 
    {
        $getFancierId = $_POST['fancierid'];
        $event_id = $_POST['eventide'];
        $getFancierDetials = $this->db->query("select read_type from ppa_register where reg_id ='" . $getFancierId . "'");
        $FancierDetials = $getFancierDetials->row_array();
        $getbasketing = $this->db->query("select scanReader,rubber_outer_no from ppa_basketing where fancier_id ='" . $getFancierId . "' and event_id ='".$event_id."'");
        $getbasketing = $getbasketing->row_array();
        $merge_array = array();
        $merge_array["read_type"] = $FancierDetials['read_type'];
        $merge_array["scanReader"] = $getbasketing["scanReader"];
        $merge_array["rubber_outer_no"] = $getbasketing["rubber_outer_no"];

        //echo "<pre>"; print_r($merge_array["read_type"]); die;
        echo json_encode($merge_array);
    }

    public function get_bird_value(){
        $postData = $this->input->post();
        if($postData != "")
        {
            $apptype = $postData["org_name"];
            $get_app_type = $this->db->query("select Org_code,users_id from users where users_id = '".$apptype."'");
            $getAppType = $get_app_type->row_array();
            if(!empty($getAppType))
            {
                $user_id = $getAppType['users_id'];
                $appType = $getAppType['Org_code'];

                $get_color = $this->db->query("select sticker_color,ide from pigeon_sticker_colors where apptype = '".$appType."' and user_id='".$user_id."' and status = '1'");
                $get_bird_color = $get_color->result_array();

                $get_category = $this->db->query("select brid_type,b_id from ppa_bird_type where apptype = '".$appType."' and user_id='".$user_id."' and bird_status = '1'");
                $get_bird_category = $get_category->result_array();

                $get_all_details = array_merge($get_bird_color,$get_bird_category);

                $getAllDetails = array();
                foreach ($get_all_details as $key => $value) {
                    $getAllDetails[$key]['ide'] = $value["ide"];
                    $getAllDetails[$key]['sticker_color'] = $value["sticker_color"];
                    $getAllDetails[$key]['b_id'] = $value["b_id"];
                    $getAllDetails[$key]['brid_type'] = $value["brid_type"];
                }
                //echo "<pre>"; print_r($getAllDetails); die;
                echo json_encode($getAllDetails);
            }
        }
    }

}