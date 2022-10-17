<?php
$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);

class User_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->id) ? $this->session->get_userdata()['user_details'][0]->users_id : '1';
    }

    /**
     * This function is used authenticate user at login
     */
    function auth_user() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $this->db->where("is_deleted='0' AND (name='$email' OR email='$email')");
        $result = $this->db->get('users')->result();

        if (!empty($result)) {
            if (password_verify($password, $result[0]->password)) {
                if ($result[0]->status != 'active') {
                    return 'not_varified';
                }
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * This function is used to delete user
     * @param: $id - id of user table
     */
    function delete($id = '') {
        $this->db->where('users_id', $id);
        $this->db->delete('users');
    }
    function fancierdelete($id = '') {
        $this->db->where('reg_id', $id);
        $this->db->delete('ppa_register');
    }
    function deleteevent($id = '') {
        $this->db->where('Events_id', $id);
        $this->db->delete('ppa_events');

        $this->db->where('event_id', $id);
        $this->db->delete('ppa_event_details');
    }

    function getresults($eventide) {
        $query = $this->db->query("select * from ppa_events as a LEFT JOIN users as b ON a.Org_id=b.users_id where events_id='" . $eventide . "'");
        //echo "select * from ppa_events as a LEFT JOIN users as b ON a.Org_id=b.users_id where events_id='" . $eventide . "'";
        // select * from ppa_events as a LEFT JOIN users as b ON a.Org_id=b.users_id where events_id='1158'
        return $query->result();
    }

    function racestartstatus($eventide) {

        $query = $this->db->query("SELECT max(date) as maxi,MIN(date) as mini,start_time as start FROM `ppa_event_details` WHERE event_id='" . $eventide . "'");
        return $query->result();
    }

    function getcompanylists() {
        $query = $this->db->query("select * from users where user_type!='Admin' and user_type!='admin' order by name ASC");
        // echo "select * from users where user_type!='Admin' and user_type!='admin' order by name ASC";
        return $query->result();
    }

    function getlogtypes() {
        $query = $this->db->query("select action from system_logs group by action");
        return $query->result();
    }

    function currentraces() {
        if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {
            $query = $this->db->query("SELECT * FROM ppa_events as a LEFT JOIN users as b ON a.Org_id = b.users_id where WEEKOFYEAR(a.Event_date)=WEEKOFYEAR(NOW()) limit 0,10");
        } else {
            $orgide = $this->session->userdata('user_details')[0]->users_id;
            $query = $this->db->query("SELECT * FROM ppa_events as a LEFT JOIN users as b ON a.Org_id = b.users_id where WEEKOFYEAR(a.Event_date)=WEEKOFYEAR(NOW()) and a.Org_id='" . $orgide . "' limit 0,10");
        }
        return $query->result();
    }

    function lastresult() {
        if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {
            $get_last_event = $this->db->query("SELECT event_id FROM ppa_report order by report_id DESC limit 0,1");
            $get_id = $get_last_event->row_array(); 
            $ide = $get_id['event_id'];
            $query = $this->db->query("SELECT * FROM ppa_report as a LEFT JOIN ppa_events as b ON a.event_id = b.Events_id where a.event_id = '".$ide."' order by a.velocity DESC limit 0,10");
        } else {
            $orgide = $this->session->userdata('user_details')[0]->Org_code;
            $get_last_event = $this->db->query("SELECT event_id FROM ppa_report where apptype='" . $orgide . "' order by report_id DESC limit 0,1");
            $get_id = $get_last_event->row_array(); 
            $ide = $get_id['event_id'];
            $query = $this->db->query("SELECT * FROM ppa_report as a LEFT JOIN ppa_events as b ON a.event_id = b.Events_id where a.apptype='" . $orgide . "' and a.event_id = '".$ide."' order by a.velocity DESC limit 0,10");
        }
        return $query->result();
    }
    function facnierstat() {
        $query = $this->db->query("SELECT COUNT(*) as cnt,b.name FROM ppa_register as a LEFT JOIN users as b ON a.`apptype`=b.Org_code WHERE 1 group BY a.apptype");
        return $query->result();
    }
    function birddetails($ride) {

        $query = $this->db->query("select a.ringno,e.name as clubname,b.username as fancier,c.brid_type as birdtype,a.gender as gender,d.color as color from pigeons as a LEFT JOIN ppa_register as b ON a.apptype = b.apptype and b.phone_no=a.mobile_no LEFT JOIN ppa_bird_type as c ON c.b_id=a.bird_type LEFT JOIN pigeons_color as d ON d.ide = a.color LEFT JOIN users as e ON a.apptype = e.Org_code where a.bid='" . $ride . "'");
        return $query->result();
    }
    function getbirdtypesbyrace($eventide) {
        $query = $this->db->query("SELECT a.bird_type,b.brid_type FROM ppa_basketing as a LEFT JOIN ppa_bird_type as b on a.bird_type=b.b_id WHERE a.event_id = '" . $eventide . "' group by a.bird_type");
        return $query->result();
    }
    function birdhistory($ringno) {

        $query = $this->db->query("SELECT * FROM ppa_basketing as d LEFT JOIN ppa_report as a ON a.event_details_id=d.event_details_id and a.ring_no=d.ring_no LEFT JOIN ppa_events as b ON b.Events_id=d.event_id LEFT JOIN ppa_event_details as c ON c.ed_id=d.event_details_id WHERE d.ring_no = '" . $ringno . "' group by d.event_id");
        return $query->result();
    }

    function geteventfancierlists($eventide) {
        $query = $this->db->query("select a.* from ppa_register as a LEFT JOIN users as b ON a.apptype=b.Org_code LEFT JOIN ppa_events as c ON c.Org_id=b.users_id where c.Events_id='" . $eventide . "' group by a.reg_id order by a.reg_id ASC");
        // echo "select a.* from ppa_register as a LEFT JOIN users as b ON a.apptype=b.Org_code LEFT JOIN ppa_events as c ON c.Org_id=b.users_id where c.Events_id='" . $eventide . "' group by a.reg_id order by a.reg_id ASC";
        return $query->result();
    }
    function changetatusbyid($id, $status) {
        if ($status == 0) {
            $query = $this->db->query("update ppa_register set usertype='0',status='" . $status . "' where reg_id='" . $id . "'");
        } else {
            $query = $this->db->query("update ppa_register set status='" . $status . "' where reg_id='" . $id . "'");
        }

    }
    function getclubcount() {
        $query = $this->db->query("select users_id from users where user_type!='Admin' and user_type!='admin'");
        return $query->num_rows();
    }
    function getfanciercount() {
        if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {
            $query = $this->db->query("select * from ppa_register");
        } else {
            $apptype = $this->session->userdata('user_details')[0]->Org_code;
            $query = $this->db->query("select * from ppa_register where apptype='" . $apptype . "'");
        }
        return $query->num_rows();
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

    function getracecount() {
        if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {
            $query = $this->db->query("select * from ppa_events");
        } else {
            $org_id = $this->session->userdata('user_details')[0]->users_id;
            $query = $this->db->query("select * from ppa_events where Org_id='" . $org_id . "'");
        }
        return $query->num_rows();
    }

    function getlivecount() {
        if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {
            $query = $this->db->query("SELECT Events_id FROM ppa_events");
            $i = 0;
            foreach ($query->result_array() as $key => $value) {
                $id = $value['Events_id'];
                $get_date_time = $this->db->query("select * from ppa_events as eve LEFT JOIN ppa_event_details as eve_b ON eve.Events_id = eve_b.event_id where eve.Events_id = '" . $id . "'  ORDER BY eve_b.date asc,STR_TO_DATE(eve_b.start_time, '%h:%i %p') asc limit 0,1");
                $get_date_time = $get_date_time->row_array();
                $concate_start_date_time = $get_date_time['Event_date'] . ' ' . $get_date_time['start_time'];
                $concate_start_date_time = strtotime($concate_start_date_time);
                $concate_end_date_time = $get_date_time['Eventend_date'] . ' ' . $get_date_time['end_time'];
                $concate_end_date_time = strtotime($concate_end_date_time);
                $curdate = date("Y-m-d h:i A");
                $curdate = strtotime($curdate);

                if ($concate_start_date_time <= $curdate && $concate_end_date_time >= $curdate) {
                    $i++;
                }
            }
        } else {
            $org_id = $this->session->userdata('user_details')[0]->users_id;
            $query = $this->db->query("SELECT Events_id FROM ppa_events WHERE Org_id='" . $org_id . "'");
            $i = 0;
            foreach ($query->result_array() as $key => $value) {
                $id = $value['Events_id'];
                $get_date_time = $this->db->query("select * from ppa_events as eve LEFT JOIN ppa_event_details as eve_b ON eve.Events_id = eve_b.event_id where eve.Events_id = '" . $id . "'  ORDER BY eve_b.date asc,STR_TO_DATE(eve_b.start_time, '%h:%i %p') asc limit 0,1");
                $get_date_time = $get_date_time->row_array();
                $concate_start_date_time = $get_date_time['Event_date'] . ' ' . $get_date_time['start_time'];
                $concate_start_date_time = strtotime($concate_start_date_time);
                $concate_end_date_time = $get_date_time['Eventend_date'] . ' ' . $get_date_time['end_time'];
                $concate_end_date_time = strtotime($concate_end_date_time);
                $curdate = date("Y-m-d h:i A");
                $curdate = strtotime($curdate);

                if ($concate_start_date_time <= $curdate && $concate_end_date_time >= $curdate) {
                    $i++;
                }
            }
        }
        return $i;
    }

    function getupcomingcount() {
        if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {
            $query = $this->db->query("SELECT Events_id FROM ppa_events");
            $i = 0;
            foreach ($query->result_array() as $key => $value) {
                $id = $value['Events_id'];
                $get_date_time = $this->db->query("select * from ppa_events as eve LEFT JOIN ppa_event_details as eve_b ON eve.Events_id = eve_b.event_id where eve.Events_id = '" . $id . "'  ORDER BY eve_b.date asc,STR_TO_DATE(eve_b.start_time, '%h:%i %p') asc limit 0,1");
                $get_date_time = $get_date_time->row_array();
                $concate_start_date_time = $get_date_time['Event_date'] . ' ' . $get_date_time['start_time'];
                $concate_start_date_time = strtotime($concate_start_date_time);
                $concate_end_date_time = $get_date_time['Eventend_date'] . ' ' . $get_date_time['end_time'];
                $concate_end_date_time = strtotime($concate_end_date_time);
                $curdate = date("Y-m-d h:i A");
                $curdate = strtotime($curdate);

                if ($concate_start_date_time > $curdate && $concate_end_date_time > $curdate) {
                    $i++;
                }
            }
        } else {
            $org_id = $this->session->userdata('user_details')[0]->users_id;
            $query = $this->db->query("SELECT Events_id FROM ppa_events WHERE Org_id='" . $org_id . "'");
            $i = 0;
            foreach ($query->result_array() as $key => $value) {
                $id = $value['Events_id'];
                $get_date_time = $this->db->query("select * from ppa_events as eve LEFT JOIN ppa_event_details as eve_b ON eve.Events_id = eve_b.event_id where eve.Events_id = '" . $id . "'  ORDER BY eve_b.date asc,STR_TO_DATE(eve_b.start_time, '%h:%i %p') asc limit 0,1");
                $get_date_time = $get_date_time->row_array();
                $concate_start_date_time = $get_date_time['Event_date'] . ' ' . $get_date_time['start_time'];
                $concate_start_date_time = strtotime($concate_start_date_time);
                $concate_end_date_time = $get_date_time['Eventend_date'] . ' ' . $get_date_time['end_time'];
                $concate_end_date_time = strtotime($concate_end_date_time);
                $curdate = date("Y-m-d h:i A");
                $curdate = strtotime($curdate);

                if ($concate_start_date_time > $curdate && $concate_end_date_time > $curdate) {
                    $i++;
                }
            }
        }
        return $i;
    }

    function getcompletedcount() {
        if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {
            $query = $this->db->query("SELECT Events_id FROM ppa_events");
            $i = 0;
            foreach ($query->result_array() as $key => $value) {
                $id = $value['Events_id'];
                $get_date_time = $this->db->query("select * from ppa_events as eve LEFT JOIN ppa_event_details as eve_b ON eve.Events_id = eve_b.event_id where eve.Events_id = '" . $id . "'  ORDER BY eve_b.date asc,STR_TO_DATE(eve_b.start_time, '%h:%i %p') asc limit 0,1");
                $get_date_time = $get_date_time->row_array();
                $concate_start_date_time = $get_date_time['Event_date'] . ' ' . $get_date_time['start_time'];
                $concate_start_date_time = strtotime($concate_start_date_time);
                $concate_end_date_time = $get_date_time['Eventend_date'] . ' ' . $get_date_time['end_time'];
                $concate_end_date_time = strtotime($concate_end_date_time);
                $curdate = date("Y-m-d h:i A");
                $curdate = strtotime($curdate);

                if ($concate_start_date_time <$curdate ) {
                    $i++;
                }
            }
        } else {
            $org_id = $this->session->userdata('user_details')[0]->users_id;
            $query = $this->db->query("SELECT Events_id FROM ppa_events WHERE Org_id='" . $org_id . "'");
            $i = 0;
            foreach ($query->result_array() as $key => $value) {
                $id = $value['Events_id'];
                $get_date_time = $this->db->query("select * from ppa_events as eve LEFT JOIN ppa_event_details as eve_b ON eve.Events_id = eve_b.event_id where eve.Events_id = '" . $id . "'  ORDER BY eve_b.date asc,STR_TO_DATE(eve_b.start_time, '%h:%i %p') asc limit 0,1");
                $get_date_time = $get_date_time->row_array();
                $concate_start_date_time = $get_date_time['Event_date'] . ' ' . $get_date_time['start_time'];
                $concate_start_date_time = strtotime($concate_start_date_time);
                $concate_end_date_time = $get_date_time['Eventend_date'] . ' ' . $get_date_time['end_time'];
                $concate_end_date_time = strtotime($concate_end_date_time);
                $curdate = date("Y-m-d h:i A");
                $curdate = strtotime($curdate);

                if ($concate_start_date_time < $curdate && $concate_end_date_time < $curdate) {
                    $i++;
                }
            }
        }
        return $i;
    }

    


    /**
     * This function is used to load view of reset password and varify user too
     */
    function mail_varify() {
        $ucode = $this->input->get('code');
        $this->db->select('email as e_mail');
        $this->db->from('users');
        $this->db->where('var_key', $ucode);
        $query = $this->db->get();
        $result = $query->row();
        if (!empty($result->e_mail)) {
            return $result->e_mail;
        } else {
            return false;
        }
    }

    /**
     * This function is used Reset password
     */
    function ResetPpassword() {
        $email = $this->input->post('email');
        if ($this->input->post('password_confirmation') == $this->input->post('password')) {
            $npass = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $data['password'] = $npass;
            $data['var_key'] = '';
            return $this->db->update('users', $data, "email = '$email'");
        }
    }

    function h2m($hours) {
        $t = EXPLODE(":", $hours);
        $h = $t[0];
        IF (ISSET($t[1])) {
            $m = $t[1];
        } ELSE {
            $m = "00";
        }
        $mm = ($h * 60) + $m;
        RETURN $mm;
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        /* $getdistance = $this->db->query("select (6371 * acos(
        cos( radians(".$lat1.") )
         * cos( radians( ".$lat2." ) )
         * cos( radians( ".$lon2." ) - radians(".$lon1.") )
        + sin( radians(".$lat1.") )
         * sin( radians( ".$lat2." ) )
        ) ) as distance");

        die("select (6371 * acos(
        cos( radians(".$lat1.") )
         * cos( radians( ".$lat2." ) )
         * cos( radians( ".$lon2." ) - radians(".$lon1.") )
        + sin( radians(".$lat1.") )
         * sin( radians( ".$lat2." ) )
        ) ) as distance");
        $dist_res = $getdistance->result();
        return $dist_res[0]->distance;*/

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }

    }

    function distance3434($lat1, $lon1, $lat2, $lon2, $unit) {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = '';
        if ($unit == "K") {
            $kilometers = $miles * 1.609344;

        }
        return $kilometers;
    }

    /**
     * This function is used to select data form table
     */
    function get_data_by($tableName = '', $value = '', $colum = '', $condition = '') {
        if ((!empty($value)) && (!empty($colum))) {
            $this->db->where($colum, $value);
        }
        $this->db->select('*');
        $this->db->from($tableName);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * This function is used to check user is alredy exist or not
     */
    function check_exists($table = '', $colom = '', $colomValue = '') {
        $this->db->where($colom, $colomValue);
        $res = $this->db->get($table)->row();
        if (!empty($res)) {return false;} else {return true;}
    }

    /**
     * This function is used to get users detail
     */
    function get_users($userID = '') {
        $this->db->where('is_deleted', '0');
        if (isset($userID) && $userID != '') {
            $this->db->where('users_id', $userID);
        } else if ($this->session->userdata('user_details')[0]->user_type == 'admin') {
            $this->db->where('user_type', 'admin');
        } else {
            $this->db->where('users.users_id !=', '1');
        }
        $result = $this->db->get('users')->result();
        return $result;
    }

    function getfancierdetails($ide) {

        $fancierquery = $this->db->query("select a.*,b.name from ppa_register as a,users as b where a.apptype=b.Org_code and a.reg_id='" . $ide . "'");
        $result = $fancierquery->result();
        return $result;
    }

    /**
     * This function is used to get email template
     */
    function get_template($code) {
        $this->db->where('code', $code);
        return $this->db->get('templates')->row();
    }

    /**
     * This function is used to Insert record in table
     */
    public function insertRow($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    // public function updateRegisterRow($table, $col, $colVal, $data) {
    //     $this->db->where($col, $colVal);
    //     $this->db->update($table, $data);
    //     return true;
    // }

    /**
     * This function is used to Update record in table
     */
    public function updateRow($table, $col, $colVal, $data) {
        $this->db->where($col, $colVal);
        $this->db->update($table, $data);
        return true;
    }

}