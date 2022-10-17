<?php
//ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed ');
class Races extends CI_Controller {

    function __construct() {
        parent::__construct(); 
		$this->load->model('Race_model');
		$this->user_id = isset($this->session->get_userdata()['user_details'][0]->id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
    }

    /**
      * This function is redirect to users profile page
      * @return Void
      */
    public function index() {
    	if(is_login()){
    		redirect( base_url().'user/profile', 'refresh');
    	} 
    }

    /**
      * This function is used to load login view page
      * @return Void
      */
    public function login(){
    	if(isset($_SESSION['user_details'])){
    		redirect( base_url().'user/profile', 'refresh');
    	}   
    	$this->load->view('include/script');
        $this->load->view('login'); 
    }

    /**
      * This function is used to logout user
      * @return Void
      */
    public function logout(){
        is_login();
        $this->session->unset_userdata('user_details');               
        redirect( base_url().'user/login', 'refresh');
    }

    /**
     * This function is used to registr user
     * @return Void
     */
    public function registration(){
    	if(isset($_SESSION['user_details'])){
    		redirect( base_url().'user/profile', 'refresh');
    	}
        //Check if admin allow to registration for user
		if(setting_all('register_allowed')==1){
			if($this->input->post()) {
				$this->add_edit();
				$this->session->set_flashdata('messagePr', 'Successfully Registered..');
			} else {
				$this->load->view('include/script');
				$this->load->view('register');
			}
		}
		else {
			$this->session->set_flashdata('messagePr', 'Registration Not allowed..');
			redirect( base_url().'user/login', 'refresh');
		}
    }
    
    /**
     * This function is used for user authentication ( Working in login process )
     * @return Void
     */
	public function auth_user($page =''){ 
		$return = $this->User_model->auth_user();
		if(empty($return)) { 
            $this->session->set_flashdata('messagePr', 'Invalid details');	
            redirect( base_url().'user/login', 'refresh');  
        } else { 
            
			if($return == 'not_varified') {
				$this->session->set_flashdata('messagePr', 'This accout is not varified. Please contact to your admin..');
                redirect( base_url().'user/login', 'refresh');
			} else {

				$this->session->set_userdata('user_details',$return);
			}
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    /**
     * This function is used send mail in forget password
     * @return Void
     */
    public function forgetpassword(){
        $page['title'] = 'Forgot Password';
        if($this->input->post()){
            $setting = settings();
            $res = $this->User_model->get_data_by('users', $this->input->post('email'), 'email',1);
            if(isset($res[0]->users_id) && $res[0]->users_id != '') { 
                $var_key = $this->getVarificationCode(); 
                $this->User_model->updateRow('users', 'users_id', $res[0]->users_id, array('var_key' => $var_key));
                $sub = "Reset password";
                $email = $this->input->post('email');      
                $data = array(
                    'user_name' => $res[0]->name,
                    'action_url' =>base_url(),
                    'sender_name' => $setting['company_name'],
                    'website_name' => $setting['website'],
                    'varification_link' => base_url().'user/mail_varify?code='.$var_key,
                    'url_link' => base_url().'user/mail_varify?code='.$var_key,
                    );
                $body = $this->User_model->get_template('forgot_password');
                $body = $body->html;
                foreach ($data as $key => $value) {
                    $body = str_replace('{var_'.$key.'}', $value, $body);
                }
                if($setting['mail_setting'] == 'php_mailer') {
                    $this->load->library("send_mail");         
                    $emm = $this->send_mail->email($sub, $body, $email, $setting);
                } else {
                    // content-type is required when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: '.$setting['EMAIL'] . "\r\n";
                    $emm = mail($email,$sub,$body,$headers);
                }
                if($emm) {
                    $this->session->set_flashdata('messagePr', 'To reset your password, link has been sent to your email');
                    redirect( base_url().'user/login','refresh');
                }
            } else {    
                $this->session->set_flashdata('forgotpassword', 'This account does not exist');//die;
                redirect( base_url()."user/forgetpassword");
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
    public function mail_varify(){
      	$return = $this->User_model->mail_varify();         
      	$this->load->view('include/script');
      	if($return){          
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
    public function reset_password(){
        $return = $this->User_model->ResetPpassword();
        if($return){
        	$this->session->set_flashdata('messagePr', 'Password Changed Successfully..');
            redirect( base_url().'user/login', 'refresh');
        } else {
        	$this->session->set_flashdata('messagePr', 'Unable to update password');
            redirect( base_url().'user/login', 'refresh');
        }
    }

    /**
     * This function is generate hash code for random string
     * @return string
     */
    public function getVarificationCode(){        
        $pw = $this->randomString();   
        return $varificat_key = password_hash($pw, PASSWORD_DEFAULT); 
    }

    

    /**
     * This function is used for show users list
     * @return Void
     */
    public function userTable(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $this->load->view('include/header');
            $this->load->view('user_table');                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function fancier(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $this->load->view('include/header');
            $this->load->view('fancier_table');                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function addrace(){
        is_login();
        if(CheckPermission("users", "own_read")){
        	    if(!isset($id) || $id == '') {
		            $id = $this->session->userdata ('user_details')[0]->users_id;
		        }
        	$table = 'ppa_bird_type';
        	$data['bird_list'] = $this->Race_model->get_data_by($table);
        	if($id == 1){
        		$table_name = 'users';
        		$where = "1";
        		$data['org_list'] = $this->Race_model->get_validate($table_name, $where);
            }else{
	        	$table_name = 'users';
        		$where = array('users_id' => $id);
        		$data['org_list'] = $this->Race_model->get_validate($table_name, $where);
            }
            $this->load->view('include/header');
            $this->load->view('add_race', $data);                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }
 	public function add_event()
 	{
 		//$b_dis = $_REQUEST["bird_distance"];
		date_default_timezone_set ( 'Asia/Kolkata' );
		$current_date = date ( 'Y-m-d H:i:s' );
 		$eventdate = date('Y-m-d', strtotime( $_POST["event_sch_date"] ));
 		
		$b_type = array();
		$bird_dis = array();
		$bird_type = array();
		$start_date = array();
		$start_time = array();
		$end_time = array();
		$bording_time = array();
		for($i=0; $i<count ($_POST["bird_distance"]); $i++){
			$birdvalue = $_POST["bird_distance"][$i];
			$b_type[] = $_POST["select_bird_type"][$i];
			$start = ($i+1)*10;
			$end = ($start+10)-1;
				for($j=$start; $j<=$end; $j++){
					if(isset($_POST["start_date".$j])){
					$sdate = $_POST["start_date".$j][0];
					$bird_dis['bird_distance'][] = $_POST["bird_distance"][$i];
					$bird_type['select_bird_type'][] = $_POST["select_bird_type"][$i];
					$start_date['race_date'][] = date('Y-m-d', strtotime( $sdate));
					$start_time['start_time'][] = $_POST["start_time".$j][0];
					$end_time['end_time'][] = $_POST["end_time".$j][0];
					$bording_time['time_distance'][] = $_POST["time_distance".$j][0];
				}
			}

		}
		

		$table_name = 'ppa_events';
		$where = array('Org_id' => $_POST["org_name"],'Event_date' => $eventdate,'Event_name' => $_POST["event_name"]);
		$chkevent = $this->Race_model->event_validate($table_name, $where);
		if($chkevent == 1){
			$data['Org_id'] = $_POST["org_name"];
			$data['Event_name'] = $_POST["event_name"];
			$data['Event_lat'] = $_POST["event_latitude"];
			$data['Event_long'] = $_POST["event_longitude"];
			$data['Event_date'] = $eventdate;
			$data['Created_date'] = $current_date;
			$event_id = $this->Race_model->insertRow($table_name, $data);
			if($event_id != ""){
				$res = "";
				$info['event_id'] = $event_id;
				$info['created'] = $current_date;
				
				$detail_table = 'ppa_event_details';
				for($j=0; $j<count ($bird_dis['bird_distance']); $j++){
					$info['bird_id'] = $bird_type['select_bird_type'][$j];
					$info['race_distance'] = $bird_dis['bird_distance'][$j];
					$info['date'] = $start_date['race_date'][$j];
					$info['start_time'] = $start_time['start_time'][$j];
					$info['end_time'] = $end_time['end_time'][$j];
					$info['boarding_time'] = $bording_time['time_distance'][$j];
					$event_details_id = $this->Race_model->insertRow($detail_table, $info);
					if($event_details_id != ""){
						$res = 1;	
					}
					else{
						$res = 0;
					}
					
				}
				echo $res;
			}
			
		}
 		exit();
 		# code...
 	}
    public function raceresults(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $resultid = $this->uri->segment(3);
            $data['result_data'] = $this->User_model->getresults($resultid);
            $this->load->view('include/header');
            $this->load->view('results',$data);                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function update_category()
    {
        # code...
        $eventID = $_POST['event_id'];
        $event_table = 'ppa_events';
        $event_table_col = 'Events_id';
        $data['Event_date'] = date('Y-m-d', strtotime($_POST['view_date'])); 
        $data['Event_name'] = $_POST['view_name']; 
        $data['Event_lat'] = $_POST['view_latitude']; 
        $data['Event_long'] = $_POST['view_longitude']; 
        $res = $this->Race_model->updateRow($event_table, $event_table_col, $eventID, $data);
        if($res != ""){
            $this->Race_model->DeleteEvents($eventID);
            $rs = '';
            for ($i=0; $i < count($_POST['race_distance']); $i++) { 
                    # code...
                    $info['event_id'] = $eventID;    
                    $info['race_distance'] = $_POST['race_distance'][$i];
                    $info['bird_id'] = $_POST['Bird_Type'][$i];
                    $info['date'] = date('Y-m-d', strtotime($_POST['Bird_Date'][$i]));
                    $info['start_time'] = $_POST['Bird_start_time'][$i];
                    $info['end_time'] = $_POST['Bird_end_time'][$i];
                    $info['boarding_time'] = $_POST['boarding_time_distance'][$i];
                    $event_details_table = 'ppa_event_details';
                    $re = $this->Race_model->insertRow($event_details_table, $info);
                    if($re != ""){
                        $rs = 1;
                    }else{
                        $rs = 0;
                    }
                }    
            echo $rs;
        }
        
        die();
    }

    public function editrace(){
        is_login();
        if(CheckPermission("users", "own_read")){
        	$eventid = $this->uri->segment(3);
        	$event_table = 'ppa_events'; 
        	$eve_col='Events_id';
        	$data['event_list'] = $this->Race_model->get_data_by($event_table, $eventid, $eve_col);
        	$org_id = $data['event_list'][0]->Org_id;
        	$org_table = 'users';
        	$org_col = 'users_id';
        	$data['org_list'] = $this->Race_model->get_data_by($org_table, $org_id, $org_col);
        	$bird_table = 'ppa_bird_type';
        	$data['bird_type'] = $this->Race_model->get_data_by($bird_table);
        	$event_detail_table = 'ppa_event_details';
        	$event_det_col = 'event_id';
        	$data['event_details'] = $this->Race_model->get_data_by($event_detail_table, $eventid, $event_det_col);


            $this->load->view('include/header');
            $this->load->view('edit_race', $data);                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function races_list(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $this->load->view('include/header');
            $this->load->view('race_table');                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }
    public function event_deleted()
    {
    	# code...
    	$event_id = $_POST['ids'];
    	$ras = $this->Race_model->delete_event_details($event_id);
    	$res = '';
    	if($ras == ''){
    		$res  = 1;	
    	}
    	echo $res;
    	exit();
    }
    public function update_main_event()
    {
      	# code...
    	date_default_timezone_set ( 'Asia/Kolkata' );
		$current_date = date ( 'Y-m-d H:i:s' );
 		$eventdate = date('Y-m-d', strtotime( $_POST["event_sche_date"] ));
 		$data['Event_name'] = $_POST["event_name"];
		$data['Event_lat'] = $_POST["event_lat"];
		$data['Event_long'] = $_POST["event_long"];
		$data['Event_date'] = $eventdate;
		$data['Updated_date'] = $current_date;
		$table  = 'ppa_events';
		$col = 'Events_id';
		echo $update_event = $this->Race_model->updateRow($table, $col, $_POST["event_id"], $data);
		exit();
    }
    public function update_event_details()
    {
  //   	echo "<pre>";
		// print_r($_POST);
		//  echo "</pre>";
		// die();
    	# code...
    	date_default_timezone_set ( 'Asia/Kolkata' );
		$current_date = date ( 'Y-m-d H:i:s' );
 		$racedate = date('Y-m-d', strtotime( $_POST["bird_date"] ));
    	$event_id = $_POST["event_id"];
		$event_details_id = $_POST["event_details_id"];
		$data['bird_id'] = $_POST["bird_type"];
		$data['date'] = $racedate;
		$data['start_time'] = $_POST["bird_start_time"];
		$data['end_time'] = $_POST["bird_end_time"];
		$data['boarding_time'] = $_POST["boarding_time"];
		$data['Updated_date'] = $current_date;

		$table  = 'ppa_event_details';
		$col = 'ed_id';
		echo $update_event = $this->Race_model->updateRow($table, $col, $event_details_id, $data);
	    exit();
	}
	public function add_anoter_event()
	{
		date_default_timezone_set ( 'Asia/Kolkata' );
		$current_date = date ( 'Y-m-d H:i:s' );

		$evet_id = $_POST["event_id"];
		$b_dis = $_POST["bird_distance"];
		$b_type = $_POST["select_bird_type"];
		$dates = $_REQUEST["start_date10"];
		$start_date = array();
		$start_time = array();
		$end_time = array();
		$bording_time = array();
 		
		for($i=10; $i<20; $i++) {
			if(isset($_POST["start_date".$i])){
				$sdate = $_POST["start_date".$i][0];
				$start_date['start_date'][] = date('Y-m-d', strtotime( $sdate));
				$start_time['start_time'][] = $_POST["start_time".$i][0];
				$end_time['end_time'][] = $_POST["end_time".$i][0];
				$bording_time['time_distance'][] = $_POST["time_distance".$i][0];
				
			}
		}

			$info['event_id'] = $evet_id;
			$info['bird_id'] = $b_type[0];
			$info['race_distance'] = $b_dis[0];
			$detail_table = 'ppa_event_details';
			$res = '';
		for($j=0; $j<count ($start_date['start_date']); $j++){
			$info['date'] = $start_date['start_date'][$j];
			$info['start_time'] = $start_time['start_time'][$j];
			$info['end_time'] = $end_time['end_time'][$j];
			$info['boarding_time'] = $bording_time['time_distance'][$j];
			$info['created'] = $current_date;
			$event_details_id = $this->Race_model->insertRow($detail_table, $info);
			if($event_details_id != ""){
				$res = 1;	
			}
			else{
				$res = 0;
			}
		}
		echo $res;
 		exit();
	}
    public function changeaccountstatus()
    {
        $status = $_POST["status"];
        $ide = $_POST["ide"];
        $query = $this->db->query("update ppa_register set status='".$status."' where reg_id='".$ide."'");
       // echo "update ppa_register set status='".$status."' where reg_id='".$ide."'";
        echo "0";

    }
    public function changeresultstatus()
    {
        $status = $_POST["status"];
        $ide = $_POST["ide"];
        $query = $this->db->query("update ppa_events set result_publish='".$status."' where Events_id='".$ide."'");
       // echo "update ppa_register set status='".$status."' where reg_id='".$ide."'";
        if($status=="0")
         $html = "Unpublished <a style='cursor:pointer;' onclick=changeresultstatus(".$ide.",'1')>Make Publish</a>";  
        else
         $html = "Published <a style='cursor:pointer;' onclick=changeresultstatus(".$ide.",'0')>Make Unpublish</a>";  
        echo $html;

    }

    public function changeclubstatus()
    {
        $status = $_POST["status"];
        $ide = $_POST["ide"];
        $query = $this->db->query("update users set Org_status='".$status."' where users_id='".$ide."'");
       // echo "update ppa_register set status='".$status."' where reg_id='".$ide."'";
        echo "0";
       
    }
    public function clearresult($id)
    {
        $query = $this->db->query("delete from ppa_report  where event_id='".$id."'");
        $this->session->set_flashdata('messagePr', 'Results cleared successfully');
        redirect( base_url().'user/raceresults/'.$id, 'refresh');
    }


    public function updateresult()
    {
       $eventdetailide = $_POST["eventdetailid"];
       $eventide = $_POST["eventide"];
       $gender = $_POST["gender"];
       $birdcolor = $_POST["birdcolor"];
       $ringno = $_POST["ringno"];
       for ($ide=0;$ide<count($ringno);$ide++)
       {
          $updateringno      = $ringno[$ide];
          $updatebirdcolor   = $birdcolor[$ide];
          $updatebirdgender  = $gender[$ide];
          $reportide = $eventdetailide[$ide];
          $query = $this->db->query("update ppa_report set ring_no='".$updateringno."',bird_gender='".$updatebirdgender."',bird_color='".$updatebirdcolor."' where report_id='".$reportide."'");
       }
      // $this->session->set_flashdata('messagePr', 'Results data updated successfully');
      // redirect( base_url().'user/raceresults/'.$eventide, 'refresh');*/

    }

    public function updatelatlong()
    {
        $lat = $_POST["lat"];
        $long = $_POST["long"];
        $ide = $_POST["fancier_id"];
        $query = $this->db->query("update ppa_register set latitude='".$lat."',longitude='".$long."' where reg_id='".$ide."'");
        $this->session->set_flashdata('messagePr', 'Latitude and longitude details updated Successfully' );
                redirect( base_url().'user/fancier', 'refresh');
    }

    /**
     * This function is used to create datatable in users list page
     * @return Void
     */
    public function dataTable (){
        is_login();
	    $table = 'users';
    	$primaryKey = 'users_id';
    	$columns = array(
           array( 'db' => 'users_id', 'dt' => 0 ),
					array( 'db' => 'name', 'dt' => 1 ),
					array( 'db' => 'email', 'dt' => 2 ),
                    array( 'db' => 'phone_no', 'dt' => 3 ),
                    array( 'db' => 'address', 'dt' => 4 ),
                    array( 'db' => 'Expire_date', 'dt' => 5 ),
                    array( 'db' => 'Org_status', 'dt' => 6 ),
					array( 'db' => 'users_id', 'dt' => 7 )
		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);
		$where = array("user_type != 'admin'");
		$output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where);
		$rows =$_REQUEST["start"]+1;
        foreach ($output_arr['data'] as $key => $value) {
			$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
			if(CheckPermission($table, "all_update")){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a><a id="btnViewRow" class="modalClubview mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View Details"><i class="fa fa-eye" data-id=""></i></a>';
			}else if(CheckPermission($table, "own_update") && (CheckPermission($table, "all_update")!=true)){
				$user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a><a id="btnViewRow" class="modalClubview mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View Details"><i class="fa fa-eye" data-id=""></i></a>';
				}
			}
			
            if(trim($output_arr['data'][$key][6])=='0')
                $output_arr['data'][$key][6] = '<span style="color:red;">Inactive</span> <br> <a style="cursor:pointer;" onclick="changeclubstatus('.$id.',1);">Make Active</a>';
            else
                $output_arr['data'][$key][6] = '<span style="color:green;">Active</span> <br> <a style="cursor:pointer;"  onclick="changeclubstatus('.$id.',0);">Make Inactive</a>';


			/*if(CheckPermission($table, "all_delete")){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
			else if(CheckPermission($table, "own_delete") && (CheckPermission($table, "all_delete")!=true)){
				$user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
				}
			}*/

            $output_arr['data'][$key][0] = $rows;$rows++;;
		}
		echo json_encode($output_arr);
    }


    public function fancierTable (){
        is_login();
        $table = 'ppa_register';
        $primaryKey = 'reg_id';
        $columns = array(
           array( 'db' => 'reg_id', 'dt' => 0 ),
           array( 'db' => 'reg_id', 'dt' => 1 ),
           array( 'db' => 'username', 'dt' => 2 ),
                    array( 'db' => 'phone_no', 'dt' => 3 ),
                    array( 'db' => 'address', 'dt' => 4 ),
                    array( 'db' => 'status', 'dt' => 5 ),
                    array( 'db' => 'loftstatus', 'dt' => 6 ),
                    array( 'db' => 'reg_id', 'dt' => 7 )
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        
        $clubtype = $this->session->userdata ('user_details')[0]->Org_code;

        if(trim($clubtype)!='' && $this->session->userdata('user_details')[0]->user_type !='Admin')
        $where = array("apptype = '".$clubtype."'");
        else
        $where = "";

        $output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where);
        $rows =$_REQUEST["start"]+1;
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
            
           $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="btnfancierview mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View Details"><i class="fa fa-eye" data-id=""></i></a>';
          
            
           /* if(CheckPermission($table, "all_delete")){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
            else if(CheckPermission($table, "own_delete") && (CheckPermission($table, "all_delete")!=true)){
                $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
                if($user_id==$this->user_id){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
                }
            }*/

            if(trim($output_arr['data'][$key][4])=='0')
                $output_arr['data'][$key][4] = '<span style="color:red;">Inactive</span> <br> <a style="cursor:pointer;" onclick="changestatus('.$id.',1);">Make Active</a>';
            else
                $output_arr['data'][$key][4] = '<span style="color:green;">Active</span> <br> <a style="cursor:pointer;"  onclick="changestatus('.$id.',0);">Make Inactive</a>';

            if(trim($output_arr['data'][$key][5])=='0')
                $output_arr['data'][$key][5] = '<span style="color:red;">Inactive</span> <br> <a style="cursor:pointer;" onclick="changeloftstatus('.$id.',1);">Make Active</a>';
            else
                $output_arr['data'][$key][5] = '<span style="color:green;">Active</span> <br> <a style="cursor:pointer;"  onclick="changeloftstatus('.$id.',0);">Make Inactive</a>';

            //$output_arr['data'][$key][0] = "<input type='checkbox' value='".$id."' name='selData'>";
            $output_arr['data'][$key][1] = '<input type="checkbox" name="selData" value="'.$id.'">';
            $output_arr['data'][$key][0] = $rows;$rows++;

        }
        echo json_encode($output_arr);
    }

    public function resultsTable (){
        is_login();
        $raceeventide = $_GET["event"];
        $table = 'ppa_report';
        $primaryKey = 'report_id';
        if(isset($_GET["editmode"]) && $_GET["editmode"]!=0)
        $editmode = 1;
        else
        $editmode = 0; 
        if(isset($_GET["birdtype"]) && $_GET["birdtype"]!='')
        $birdtype = $_GET["birdtype"];
        else
        $birdtype = '';  

        //
			$birdcolor[]="Dark Chequer";
			$birdcolor[]="Dark Chequer Pied";
			$birdcolor[]="Dark Chequer WF";
			$birdcolor[]="Light Chequer";
			$birdcolor[]="Light Chequer Pied";
			$birdcolor[]="Light Chequer WF";
			$birdcolor[]="Red Chequer";
			$birdcolor[]="Red Chequer Pied";
			$birdcolor[]="Red Chequer WF";
			$birdcolor[]="Blue";
			$birdcolor[]="Blue Pied";
			$birdcolor[]="Blue WF";
			$birdcolor[]="Mealey";
			$birdcolor[]="Mealey Pied";
			$birdcolor[]="Mealey WF";
			$birdcolor[]="Jack";
			$birdcolor[]="Jack Pied";
			$birdcolor[]="Jack WF";
			$birdcolor[]="Grizzle";
			$birdcolor[]="Soomun";
			$genderarray[] = "Male";                                        
			$genderarray[] = "Female";                                        
        //
        $columns = array(
           array( 'db' => 'c.report_id', 'dt' => 0 ,'field' => 'report_id'),
           array( 'db' => 'c.name', 'dt' => 1 ,'field' => 'name'),
                    array( 'db' => 'c.mobile_number', 'dt' => 2 ,'field' => 'mobile_number'),
                    array( 'db' => 'd.name as clubname', 'dt' => 3 ,'field' => 'clubname'),
                    array( 'db' => 'e.brid_type', 'dt' => 4,'field' => 'brid_type'),
                    array( 'db' => 'c.ring_no', 'dt' => 5,'field' => 'ring_no'),
                    array( 'db' => 'c.bird_gender', 'dt' => 6,'field' => 'bird_gender'),
                    array( 'db' => 'c.bird_color', 'dt' => 7,'field' => 'bird_color'),

                    array( 'db' => 'c.start_date', 'dt' => 8,'field' => 'start_date'),
                    array( 'db' => 'c.start_time', 'dt' => 9,'field' => 'start_time'),
                    array( 'db' => 'c.intervel', 'dt' => 10,'field' => 'intervel'),
                    array( 'db' => 'c.intervel', 'dt' => 11,'field' => 'intervel'),
                    array( 'db' => 'c.minis', 'dt' => 12,'field' => 'minis'),
                    array( 'db' => 'c.distance', 'dt' => 13,'field' => 'distance'),
                    array( 'db' => 'c.velocity', 'dt' => 14,'field' => 'velocity'),
                    array( 'db' => 'c.latitude', 'dt' => 15,'field' => 'latitude'),
                    array( 'db' => 'c.longtitude', 'dt' => 16,'field' => 'longtitude')
        );

       //array( 'db' => 'CONCAT("Name : ",c.name,"<br> Mobile : ",c.mobile_number,"<br> Club : ",d.name)', 'dt' => 1 ,'field' => 'CONCAT("Name : ",c.name,"<br> Mobile : ",c.mobile_number,"<br> Club : ",d.name)'),
             //       array( 'db' => 'c.mobile_number', 'dt' => 2 ,'field' => 'mobile_number'),

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        
        $clubtype = $this->session->userdata ('user_details')[0]->Org_code;
        $Join_condition=' from ppa_report as c LEFT JOIN users as d ON d.users_id = c.clubtype LEFT JOIN ppa_bird_type as e ON e.b_id=c.bird_type_id';
       // if(trim($clubtype)!='' && $this->session->userdata('user_details')[0]->user_type !='Admin')
        if($birdtype!='') 
           $where = "c.event_id = '".$raceeventide."' and c.bird_type_id = '".$birdtype."'";
        else 
           $where = "c.event_id = '".$raceeventide."'";
       // else
       // $where = "";
        $groupby = "c.report_id";
        //$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$Join_condition, $where);
         $output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $Join_condition, $where,$groupby);
        $rows =$_REQUEST["start"]+1;
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
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
              $output_arr['data'][$key][4] = "<span style=color:blue;font-weight:bold;>Completed</span>";*/

             $output_arr['data'][$key][10] = date('d-m-Y', ($output_arr['data'][$key][10] / 1000));
             $output_arr['data'][$key][11] = date('h:i:s A', ($output_arr['data'][$key][11] / 1000));

            if($editmode==1) {
            $output_arr['data'][$key][5] = "<input class='form-group' type='textbox' name='ringno[]' value='".$output_arr['data'][$key][5]."'>";
            $birdcolordropdown = "<select name=birdcolor[]>";
            $colorhightlight = '';
            for($t=0;$t<count($birdcolor);$t++)
            {
              if($output_arr['data'][$key][7]==$birdcolor[$t])
                $colorhightlight = "selected";
              else
                $colorhightlight = "";
              $birdcolordropdown.= "<option ".$colorhightlight." value='".$birdcolor[$t]."'>".$birdcolor[$t]."</option>";
            }
            $birdcolordropdown.= "<select>";

            $genderdropdown = "<select name=gender[]>";
            $genderhightlight = '';
            for($t=0;$t<count($genderarray);$t++)
            {
              if($output_arr['data'][$key][6]==$genderarray[$t])
                $genderhightlight = "selected";
              else
                $genderhightlight = "";
              $genderdropdown.= "<option ".$genderhightlight." value='".$genderarray[$t]."'>".$genderarray[$t]."</option>";
            }
            $genderdropdown.= "<select>";

           // $genderdropdown = "<select><option value='Male'>Male</option><option value='Female'>Female</option></select>";
            
            $output_arr['data'][$key][6] = $genderdropdown;
            $output_arr['data'][$key][7] = $birdcolordropdown;
            }

            $output_arr['data'][$key][0] = "<input type='hidden' name='eventdetailid[]' value='".$output_arr['data'][$key][0]."'>".$rows;$rows++;

        }
        echo json_encode($output_arr);
    }

    public function racesTable(){
        is_login();
        $table = 'ppa_events';
        $primaryKey = 'Events_id';
        

        $columns = array(
           array( 'db' => 'c.Events_id', 'dt' => 0 ,'field' => 'Events_id'),array( 'db' => 'c.Event_name', 'dt' => 1 ,'field' => 'Event_name'),
                    array( 'db' => 'd.name', 'dt' => 2 ,'field' => 'name'),
                    array( 'db' => 'c.Event_date', 'dt' => 3 ,'field' => 'Event_date'),
                    array( 'db' => 'e.event_id', 'dt' => 4,'field' => 'event_id'),
                    array( 'db' => 'c.Events_id', 'dt' => 5,'field' => 'Events_id')
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        
        $clubtype = $this->session->userdata ('user_details')[0]->Org_code;
        $Join_condition=' from ppa_events as c LEFT JOIN users as d ON d.users_id = c.Org_id LEFT JOIN ppa_report as e ON e.event_id=c.Events_id';
        if(trim($clubtype)!='' && $this->session->userdata('user_details')[0]->user_type !='Admin')
        $where = array("d.Org_code = '".$clubtype."'");
        else
        $where = "";
        $groupby = "c.Events_id";
        //$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$Join_condition, $where);
         $output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $Join_condition, $where,$groupby);
        $rows =$_REQUEST["start"]+1;
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
            $report = $output_arr['data'][$key][4];
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
           
           
            $timezone = "Asia/Kolkata";
            date_default_timezone_set($timezone);
            $curdate = date("Y-m-d");


           if(trim($output_arr['data'][$key][4])!='' && $output_arr['data'][$key][4] > 0) // Race completed wont delete and edit
           {
              $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="btnfancierview mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View race Details"><i class="fa fa-eye" data-id=""></i></a>';
              if(trim($output_arr['data'][$key][3])>$curdate)
              $output_arr['data'][$key][4] = "<span style=color:orange;font-weight:bold;>Upcoming</span>";
              else if(trim($output_arr['data'][$key][3])==$curdate)
              $output_arr['data'][$key][4] = "<span style=color:green;font-weight:bold;>LIVE</span>";
              else
              $output_arr['data'][$key][4] = "<span style=color:blue;font-weight:bold;>Completed</span><br><a href='".base_url().'user/raceresults/'.$id."'>View Results</a>";
           }
           else
           {
               $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="'.base_url().'races/editrace/'.$id.'"  type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a><a id="btnEditRow" class="btnfancierview mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View race Details"><i class="fa fa-eye" data-id=""></i></a><a data-toggle="modal" class="mClass" onclick="seteventId('.$id.', \'user\')"   data-src="'.$id.'" data-target="#cnfrm_delete" title="Delete race"><i class="fa fa-trash" data-id=""></i></a>';

               if(trim($output_arr['data'][$key][3])>$curdate)
                 $output_arr['data'][$key][4] = "<span style=color:orange;font-weight:bold;>Upcoming</span>";
               else if(trim($output_arr['data'][$key][3])==$curdate)
                 $output_arr['data'][$key][4] = "<span style=color:green;font-weight:bold;>LIVE</span>";
               else
                 $output_arr['data'][$key][4] = "<span style=color:blue;font-weight:bold;>Completed</span>";
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
                $output_arr['data'][$key][5] = '<span style="color:green;">Active</span> <br> <a style="cursor:pointer;"  onclick="changeloftstatus('.$id.',0);">Make Inactive</a>';*/

            //$output_arr['data'][$key][0] = "<input type='checkbox' value='".$id."' name='selData'>";
            $output_arr['data'][$key][0] = $rows;$rows++;

        }
        echo json_encode($output_arr);
    }

    

    /**
     * This function is Showing users profile
     * @return Void
     */
    public function profile($id='') {   
        is_login();
        if(!isset($id) || $id == '') {
            $id = $this->session->userdata ('user_details')[0]->users_id;
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
        if($this->input->post('id')){
            $data['userData'] = getDataByid('users',$this->input->post('id'),'users_id'); 
            echo $this->load->view('add_user', $data, true);
        } else {
            echo $this->load->view('add_user', '', true);
        }
        exit;
    }

    public function get_clubview() {
        is_login();
        if($this->input->post('id')){
            $data['clubData'] = getDataByid('users',$this->input->post('id'),'users_id'); 
            echo $this->load->view('clubview', $data, true);
        } else {
            echo $this->load->view('clubview', '', true);
        }
        exit;
    }

    public function get_fancierview() {
        is_login();
        if($this->input->post('id')){
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
        foreach($_FILES as $name => $fileInfo)
        {
            $filename=$_FILES[$name]['name'];
            $tmpname=$_FILES[$name]['tmp_name'];
            $exp=explode('.', $filename);
            $ext=end($exp);
            $newname=  $exp[0].'_'.time().".".$ext; 
            $config['upload_path'] = 'assets/images/';
            $config['upload_url'] =  base_url().'assets/images/';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000'; 
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname,"assets/images/".$newname);
            return $newname;
        }
    }
  
    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add_edit($id='') {   
        $data = $this->input->post();
        $profile_pic = 'user.png';
        if($this->input->post('users_id')) {
            $id = $this->input->post('users_id');
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'userTable';
            }
        } else {
            $redirect = 'login';
        }
        if($this->input->post('fileOld')) {  
            $newname = $this->input->post('fileOld');
            $profile_pic =$newname;
        } else {
            $data[$name]='';
            $profile_pic ='user.png';
        }
        foreach($_FILES as $name => $fileInfo)
        { 
             if(!empty($_FILES[$name]['name'])){
                $newname=$this->upload(); 
                $data[$name]=$newname;
                $profile_pic =$newname;
             } else {  
                if($this->input->post('fileOld')) {  
                    $newname = $this->input->post('fileOld');
                    $data[$name]=$newname;
                    $profile_pic =$newname;
                } else {
                    $data[$name]='';
                    $profile_pic ='user.png';
                } 
            } 
        }
        if($id != '') {
            $data = $this->input->post();
            if($this->input->post('status') != '') {
                $data['status'] = $this->input->post('status');
            }
            if($this->input->post('users_id') == 1) { 
            $data['user_type'] = 'admin';
            }
            if($this->input->post('password') != '') {
                if($this->input->post('currentpassword') != '') {
                    $old_row = getDataByid('users', $this->input->post('users_id'), 'users_id');
                    if(password_verify($this->input->post('currentpassword'), $old_row->password)){
                        if($this->input->post('password') == $this->input->post('confirmPassword')){
                            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                            $data['password']= $password;     
                        } else {
                            $this->session->set_flashdata('messagePr', 'Password and confirm password should be same...');
                            redirect( base_url().'user/'.$redirect, 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('messagePr', 'Enter Valid Current Password...');
                        redirect( base_url().'user/'.$redirect, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('messagePr', 'Current password is required');
                    redirect( base_url().'user/'.$redirect, 'refresh');
                }
            }
            $id = $this->input->post('users_id');
            unset($data['fileOld']);
            unset($data['currentpassword']);
            unset($data['confirmPassword']);
            unset($data['users_id']);
            unset($data['user_type']);
            if(isset($data['edit'])){
                unset($data['edit']);
            }
            if($data['password'] == ''){
                unset($data['password']);
            }
            $data['profile_pic'] = $profile_pic;
            $data['phone_no'] = $this->input->post('phone_no');
            $data['address'] = $this->input->post('address');
            $this->User_model->updateRow('users', 'users_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'user/'.$redirect, 'refresh');
        } else { 
            if($this->input->post('user_type') != 'admin') {
                $data = $this->input->post();
                $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                $checkValue = $this->User_model->check_exists('users','email',$this->input->post('email'));
                if($checkValue==false)  {  
                    $this->session->set_flashdata('messagePr', 'This Email Already Registered with us..');
                    redirect( base_url().'user/userTable', 'refresh');
                }
                $checkValue1 = $this->User_model->check_exists('users','name',$this->input->post('name'));
                if($checkValue1==false) {  
                    $this->session->set_flashdata('messagePr', 'Username Already Registered with us..');
                    redirect( base_url().'user/userTable', 'refresh');
                }
                $data['status'] = 'active';
                if(setting_all('admin_approval') == 1) {
                    $data['status'] = 'deleted';
                }
                
                if($this->input->post('status') != '') {
                    $data['status'] = $this->input->post('status');
                }
                //$data['token'] = $this->generate_token();
                $data['user_id'] = $this->user_id;
                $data['password'] = $password;
                $data['profile_pic'] = $profile_pic;
                $data['is_deleted'] = 0;
                if(isset($data['password_confirmation'])){
                    unset($data['password_confirmation']);    
                }
                if(isset($data['call_from'])){
                    unset($data['call_from']);    
                }
                unset($data['submit']);
                $this->User_model->insertRow('users', $data);
                redirect( base_url().'user/'.$redirect, 'refresh');
            } else {
                $this->session->set_flashdata('messagePr', 'You Don\'t have this autherity ' );
                redirect( base_url().'user/registration', 'refresh');
            }
        }
    
    }


    /**
     * This function is used to delete users
     * @return Void
     */
    public function delete($id){
        is_login(); 
        $ids = explode('-', $id);
        foreach ($ids as $id) {
            $this->User_model->delete($id); 
        }
       redirect(base_url().'user/userTable', 'refresh');
    }

    public function raceeventdelete($id){
        is_login(); 
        $ids = explode('-', $id);
        foreach ($ids as $id) {
            $this->User_model->deleteevent($id); 
        }
       $this->session->set_flashdata('messagePr', 'Race event deleted successfully' );
       redirect(base_url().'user/races', 'refresh');
    }

    
    public function changestatusall($id){
        is_login(); 
        $data = explode('_', $id);
        $ids = explode('-', $data[1]);
        foreach ($ids as $id) {
            $this->User_model->changetatusbyid($id,$data[0]); 
        }
       $this->session->set_flashdata('messagePr', 'Fancier status changed successfully' );
       redirect(base_url().'user/fancier', 'refresh');
    }

    /**
     * This function is used to send invitation mail to users for registration
     * @return Void
     */
    public function InvitePeople() {
        is_login();
    	if($this->input->post('emails')){
            $setting = settings();
			$var_key = $this->randomString();
    		$emailArray = explode(',', $this->input->post('emails'));
    		$emailArray = array_map('trim', $emailArray);
    		$body = $this->User_model->get_template('invitation');
            $result['existCount'] = 0;
            $result['seccessCount'] = 0;
            $result['invalidEmailCount'] = 0;
            $result['noTemplate'] = 0;
    		if(isset($body->html) && $body->html != '') {
                $body = $body->html;
	    		foreach ($emailArray as $mailKey => $mailValue) {
	    			if(filter_var($mailValue, FILTER_VALIDATE_EMAIL)) {
	    				$res = $this->User_model->get_data_by('users', $mailValue, 'email');
	    				if(is_array($res) && empty($res)) {
			    			$link = (string) '<a href="'.base_url().'user/registration?invited='.$var_key.'">Click here</a>';
			    			$data = array('var_user_email' => $mailValue, 'var_inviation_link' => $link);
    				        foreach ($data as $key => $value) {
    				          $body = str_replace('{'.$key.'}', $value, $body);
    				        }
                            if($setting['mail_setting'] == 'php_mailer') {
                                $this->load->library("send_mail");
    			    			$emm = $this->send_mail->email('Invitation for registration', $body, $mailValue, $setting);
                            } else {
                                // content-type is required when sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $headers .= 'From: '.$setting['EMAIL'] . "\r\n";
                                $emm = mail($mailValue,'Invitation for registration',$body,$headers);
                            }
			    			if($emm) {
			    				$darr = array('email' => $mailValue, 'var_key' => $var_key);
			    				$this->User_model->insertRow('users', $darr);
			    				$result['seccessCount'] += 1;;
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
    	if($this->input->post('code') && $this->input->post('code') != '') {
    		$res = $this->User_model->get_data_by('users', $this->input->post('code'), 'var_key');
    		$result = array();
    		if(is_array($res) && !empty($res)) {
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
    public function register_invited($id){
        $data = $this->input->post();
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data['password'] = $password;
        $data['var_key'] = NULL;
        $data['is_deleted'] = 0;
        $data['status'] = 'active';
        $data['user_id'] = 1;
        if(isset($data['password_confirmation'])) {
            unset($data['password_confirmation']);
        }
        if(isset($data['call_from'])) {
            unset($data['call_from']);
        }
        if(isset($data['submit'])) {
            unset($data['submit']);
        }
        $this->User_model->updateRow('users', 'users_id', $id, $data);
        $this->session->set_flashdata('messagePr', 'Successfully Registered..');
        redirect( base_url().'user/login', 'refresh');
    }

    /**
     * This function is used to check email is alredy exist or not
     * @return TRUE/FALSE
     */
    public function checEmailExist() {
      	$result = 1;
      	$res = $this->User_model->get_data_by('users', $this->input->post('email'), 'email');
      	if(!empty($res)){
      		if($res[0]->users_id != $this->input->post('uId')){
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
    public function generate_token(){
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = $alpha . $alpha_upper . $numeric ;            
        $token = '';  
        $up_lp_char = $alpha . $alpha_upper .$special;
        $chars = str_shuffle($chars);
        $token = substr($chars, 10,10).strtotime("now").substr($up_lp_char, 8,8) ;
        return $token;
    }

    /**
     * This function is used to Generate a random string
     * @return String
     */
    public function randomString(){
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = $alpha . $alpha_upper . $numeric;            
        $pw = '';    
        $chars = str_shuffle($chars);
        $pw = substr($chars, 8,8);
        return $pw;
    }


}