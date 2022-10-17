<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);

class User extends CI_Controller {

    function __construct() {
        parent::__construct(); 
		$this->load->model('User_model');
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
            redirect( base_url().'user/dashboard', 'refresh');
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

    public function dashboard(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $this->load->view('include/header');
            $data['fanciercount'] = $this->User_model->getfanciercount();
            $data['clubcount'] = $this->User_model->getclubcount();
            $data['racecount'] = $this->User_model->getracecount();
            $data['currentraces'] = $this->User_model->currentraces();
            $data['lastresult'] = $this->User_model->lastresult();

            $this->load->view('dashboard',$data);                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function raceinfo(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $eventid = $this->uri->segment(3);
            $data['result_data'] = $this->User_model->getresults($eventid);
            $query = $this->db->query("SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type,ppa_event_details.race_distance FROM ppa_event_details INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id WHERE ppa_event_details.event_id ='".$eventid."'");
            $data['racetypes'] = $query->result();
            $this->load->view('include/header');
            $this->load->view('raceinfo',$data);                
            $this->load->view('include/footer');                
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function verifyresult(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $eventid = $this->uri->segment(3);
            $data['result_data'] = $this->User_model->getresults($eventid);
            $data['geteventfancierlists'] = $this->User_model->geteventfancierlists($eventid);
            $query = $this->db->query("SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type,ppa_event_details.race_distance FROM ppa_event_details INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id WHERE ppa_event_details.event_id ='".$eventid."'");
            $data['racetypes'] = $query->result();
            $this->load->view('include/header');
            $this->load->view('verifyresult',$data);                
            $this->load->view('include/footer');                
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }
    
    public function removeresultentry()
    {
      $events = $this->db->query("Delete from ppa_report where img_name ='".$_REQUEST["img"]."'");
      echo "1";
    }
    public function addresultentry()
    {
      //print_r($_REQUEST);
      
      $events = $this->db->query("SELECT Event_date from ppa_events where Events_id ='".$_REQUEST["eventide"]."'");
      $eventres = $events->result();

      $clubinfo = $this->db->query("SELECT users_id from users where Org_code ='".$_REQUEST["ctype"]."'");
      $clubres = $clubinfo->result();
      
      $birdinfo = $this->db->query("SELECT b_id from ppa_bird_type where brid_type ='".$_REQUEST["birdtype"]."'");
      $birdres = $birdinfo->result();

      $raceinfo = explode("-",$_REQUEST["eventdist"]);
      $eventdetails = $this->db->query("SELECT ed_id,start_time from ppa_event_details where event_id ='".$_REQUEST["eventide"]."' and race_distance ='".$raceinfo[0]."' order by ed_id ASC limit 0,1");
      $eventdetailsres = $eventdetails->result();
      date_default_timezone_set('Asia/Kolkata');
      $nice_date = date('d/m/Y', strtotime( $eventres[0]->Event_date ));

      
      $insertarray["clubtype"] =  $clubres[0]->users_id;
      $insertarray["bird_type_id"] =  $birdres[0]->b_id;
      $insertarray["event_sche_date"] =  $eventres[0]->Event_date;
      $insertarray["event_details_id"] =  $eventdetailsres[0]->ed_id;
      $insertarray["start_date"] =  $nice_date;
      $insertarray["latitude"] =  $_REQUEST["lat"];
      $insertarray["longtitude"] =  $_REQUEST["lang"];
      $insertarray["name"] =  $_REQUEST["uname"];
      $insertarray["apptype"] =  $_REQUEST["ctype"];
      $insertarray["device_id"] =  $_REQUEST["deviceid"];
      $insertarray["event_id"] =  $_REQUEST["eventide"];
      $insertarray["img_name"] =  $_REQUEST["image"];
      $insertarray["distance"] =  $_REQUEST["distance"];
      $insertarray["intervel"] =  $_REQUEST["interval"];
      $insertarray["mobile_number"] =  $_REQUEST["phno"];
      $insertarray["velocity"] =  $_REQUEST["velocity"];
      $insertarray["minis"] =  $_REQUEST["chour"];
      $insertarray["start_time"] =  $eventdetailsres[0]->start_time;
      
      //print_r($insertarray);
      $this->db->set('created_date', 'NOW()', FALSE);
      $this->db->insert('ppa_report ', $insertarray);
      echo $this->db->insert_id();
    }
        
    public function raceresult()
    {
       // print_r($_REQUEST);
        $event_id = '';
        $event_details_id = '';
        $events_sche_date = '';
        $bird_type = '';
        if(isset($_POST['event_id'])){ $event_id = $_POST['event_id']; } else { $event_id = ''; }
        if(isset($_POST['event_details_id'])){ $event_details_id = $_POST['event_details_id'];} else { $event_details_id = '';}
        if(isset($_POST['events_sche_date'])){ $events_sche_date = $_POST['events_sche_date'];} else { $events_sche_date = '';}
        if(isset($_POST['bird_type'])){ $bird_type = $_POST['bird_type'];} else { $bird_type = '';}

        $select_lats = $this->db->query("select * from ppa_register");
        $latresultdata = $select_lats->result();
        foreach ($latresultdata as $row)
        {
            $latlonginfo[$row->phone_no][0] = $row->latitude;
            $latlonginfo[$row->phone_no][1] = $row->longitude;  
        }
        
        $ch = curl_init();
        //$selecteddate = '2017-12-28';
        date_default_timezone_set ( 'Asia/Kolkata' );
        $current_date = date ( 'Y-m-d' );
        $date = strtotime($_POST["values1"]);
        $evnt_dis = $_POST["evnt_distance"];
        $clubtype = $_POST["org_code"];
        $dateconvert = date("Y-m-d", $date);
        
        $selecteddate = $_POST["values"];
        $selecteddate2 = '';
        if($current_date < $dateconvert){
              $selecteddate2 = $current_date;
        }
        else{
              $selecteddate2 = $_POST["values1"];
        }

        $nice_date = date('d/m/Y', strtotime( $selecteddate ));
        $post_date = $_POST["values"]." ".trim($_POST["times"]);
   
        $verified = $this->db->query("SELECT intervel FROM ppa_report WHERE start_date='".$nice_date."' AND apptype='".$clubtype."'");
        $verifieddata = $verified->result();
        $intervel = array ();
        foreach ($verifieddata as $verifyrow)
        {
            $intervel[] = $verifyrow->intervel;    
        }
    
        $headers = array("Authorization: Basic " . base64_encode('69c7a42185701fb8077d724bb85c909b'));
        curl_setopt($ch, CURLOPT_URL, 'https://data.mixpanel.com/api/2.0/export/?from_date='.$selecteddate.'&to_date='.$selecteddate2.'&event=%5B%22new_photo%22%5D');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
    
        if(curl_error($ch))
        {
          $errror = 1;
        }

        curl_close($ch);
        $result = str_replace("}}","}},", $result);
        $result = "[".substr($result,0,strlen($result)-1)."]";      
        $myArray = json_decode($result, true);
        $brand = '$brand';
        $city = '$city';
        $model = '$model';
        $data['city'] = array();
        
        // User approved images list
        $choosen_Date = date('Y-m-d', strtotime( $selecteddate ))." 00:00:00";
        $verified_photo = $this->db->query("SELECT photo_name FROM ppa_updatephoto WHERE cre_date >='".$choosen_Date."' AND club_code='".$clubtype."'");
        $verified_photores = $verified_photo->result();
        foreach ($verified_photores as $verified_photorow)
        {
          $approved_photos[] = $verified_photorow->photo_name;
        }
        
        // End user approved images list

        // Sorting start
        for($i=0;$i<count($myArray);$i++)
        {
          $timestamp = ($myArray[$i]["properties"]["interval"]/1000);
          $timezone = "Asia/Kolkata";
          $dt = new DateTime();
          $dt->setTimestamp($timestamp);
          $dt->setTimezone(new DateTimeZone($timezone));
          //$datetime = $dt->format('Y-m-d h:i:s A (l)');
          if($clubtype=='indp')
            $railtime = $dt->format('H');
          else
            $railtime = 0;
        
          // calculate velocity
          $st_time=strtotime($post_date);
          $timestamp = ($myArray[$i]["properties"]["interval"]/1000);
          $timezone = "Asia/Kolkata";
          $dt = new DateTime();
          $dt->setTimestamp($timestamp);
          $dt->setTimezone(new DateTimeZone($timezone)); 
          $datetime = $dt->format('h:i:s A');
          $fulltime = $dt->format('Y-m-d h:i:s A');
          $exfulltime = $dt->format('Y-m-d h:i:s A');
          $fulldate = $dt->format('Y-m-d ');
          $fullextime = $dt->format('h:i:s');       
          $endtime_ram = $dt->format('h:i');
                 
          if(isset($_POST["times"]) && isset($_POST["lat"]) && isset($_POST["lon"]))
          {
              $clickeddate = strtotime($fulldate);
              $startdate = strtotime($selecteddate);
              $calculationhour = 0;
              $phour = 0;
              if($clickeddate == $startdate){
                  $starttime = strtotime($post_date);
                  $clickedtime = strtotime($fulltime);
                  $differenttime = $clickedtime-$starttime;
                  $calculationhour = $differenttime / 60;
              }
              else{
                      $calculationhour = 0;
                      $chk_date = $this->db->query("SELECT * FROM ppa_event_details as a LEFT JOIN ppa_bird_type as b on b.b_id=a.bird_id WHERE a.event_id= '".$event_id."' AND a.race_distance='".$evnt_dis."' AND b.brid_type='".$bird_type."'");
                      $chk_datedata = $chk_date->result();
                      $chk_date = mysqli_query($link->con,"SELECT * FROM ppa_event_details as a LEFT JOIN ppa_bird_type as b on b.b_id=a.bird_id WHERE a.event_id= '".$event_id."' AND a.race_distance='".$evnt_dis."' AND b.brid_type='".$bird_type."'");
              
                      $phour = 0;
                      foreach ($chk_datedata as $chk_datedatarow)
                      {
                      $racestartdate = strtotime($chk_datedatarow->date);
                      $racestarttime = strtotime($chk_datedatarow->start_time);
                      $extimedata = date('h:i:s A', $racestarttime);
                    
                      if($clickeddate == $racestartdate){
                        $full_start_date = $chk_datedatarow->date.' '.$extimedata;
                        $extime =  strtotime($exfulltime) - strtotime($full_start_date);
                        $init = $extime;
                        //$balancemin = date('i', $extime);
                        $hours = floor($init / 3600);
                        $minutes = floor(($init / 60) % 60);
                        $seconds = $init % 60;
                        $phour =$phour + ($hours * 60) + $minutes;
                        //echo "IN ".$phour;
                        
                       }else{
                        //echo h2m("1:45");
                        $phour = $phour + $this->User_model->h2m($chk_datedatarow->boarding_time);
                     }
                
                   }
             
                  $calculationhour = $phour;
               }
            
            if($latlonginfo[$myArray[$i]["properties"]["phone_no"]][0])
                $latitudeinfo = $latlonginfo[$myArray[$i]["properties"]["phone_no"]][0];
            else
                $latitudeinfo = $myArray[$i]["properties"]["longitude"];
            
            if($latlonginfo[$myArray[$i]["properties"]["phone_no"]][1])
                $longitudeinfo = $latlonginfo[$myArray[$i]["properties"]["phone_no"]][1];
            else
                $longitudeinfo = $myArray[$i]["properties"]["latitude"];
            
            
            $distance = $this->User_model->distance($_POST["lat"],$_POST["lon"],$latitudeinfo,$longitudeinfo,"K");
            $velocity1 = ($distance*1000)/$calculationhour;
        }
        
        if(trim($_POST["times"])== '' || trim($_POST["lat"])=='' || trim($_POST["lon"])=='')
        {
            $velocity1 = 0;
            $distance  = 0;
        }
        if($latitudeinfo==0 || $longitudeinfo==0 || $latitudeinfo=='0' || $longitudeinfo=='0' || $latitudeinfo=='' || $longitudeinfo=='')
        {
            $velocity1 = 0;
            $distance = 0;
        }
        
        // echo $myArray[$i]["properties"]["interval"]." - ".$latitudeinfo." - ".$longitudeinfo." - ".$velocity1." - <br>";
        $myArray[$i]["properties"]["velocity"]= $velocity1;
        $myArray[$i]["properties"]["distance"]= $distance;
         $myArray[$i]["properties"]["chour"]= $calculationhour;
        
        $data["velocity1"][] = $velocity1;
        }
    
        // sorting end
        if(count($myArray)>0)
        array_multisort($data["velocity1"], SORT_DESC,SORT_NUMERIC, $myArray);
        $currentcount=0;

        for($i=0;$i<count($myArray);$i++)
         {
               if($myArray[$i]["properties"]["apptype"]==$clubtype)  // For PPA club
               {
                  if(isset($myArray[$i]["properties"]["date"]))
                    $data["date"][] = $myArray[$i]["properties"]["date"];
                  else
                    $data["date"][] = '';
    
                  if(isset($myArray[$i]["properties"]["velocity"]))
                    $data["velocity"][] = $myArray[$i]["properties"]["velocity"];
                  else
                    $data["velocity"][] = '';
    
                  if(isset($myArray[$i]["properties"]["chour"]))
                    $data["chour"][] = $myArray[$i]["properties"]["chour"];
                  else
                    $data["chour"][] = '';
    
                  if(isset($myArray[$i]["properties"]["distance"]))
                    $data["distance"][] = $myArray[$i]["properties"]["distance"];
                  else
                    $data["distance"][] = '';
    
           
                  if(isset($myArray[$i]["properties"][$brand]))
                    $data["brand"][] =  $myArray[$i]["properties"][$brand];
                  else
                    $data["brand"][] =  '';

                  if(isset($myArray[$i]["properties"][$model]))
                    $data["model"][] =  $myArray[$i]["properties"][$model];
                  else
                    $data["model"][] =   '';
            
                  if(isset($myArray[$i]["properties"][$city]))
                    $data["city"][] =   $myArray[$i]["properties"][$city];
                  else
                    $data["city"][] =   '';


                  if(isset($myArray[$i]["properties"]["interval"]))
                    $data["interval"][] = $myArray[$i]["properties"]["interval"];
                  else
                    $data["interval"][] = '';

                  if(isset($myArray[$i]["properties"]["isValid"]))
                    $data["isValid"][] = $myArray[$i]["properties"]["isValid"];
                  else
                    $data["isValid"][] = '';

                  if(isset($myArray[$i]["properties"]["deivce_id"]))
                    $data["deivce_id"][] = $myArray[$i]["properties"]["deivce_id"];
                  else
                    $data["deivce_id"][] = '';

                  if(isset($myArray[$i]["properties"]["name"]))
                    $data["name"][] = $myArray[$i]["properties"]["name"];
                  else
                    $data["name"][] = '';

                  if(isset($myArray[$i]["properties"]["username"]))
                    $data["username"][] = $myArray[$i]["properties"]["username"];
                  else
                    $data["username"][] = '';

                  if(isset($myArray[$i]["properties"]["phone_no"]))
                    $data["phone_no"][] = $myArray[$i]["properties"]["phone_no"];
                  else
                    $data["phone_no"][] = '';

                  if(isset($myArray[$i]["properties"]["longitude"]))
                    $data["latitude"][] = $myArray[$i]["properties"]["longitude"];      // lat&long changed in app
                  else
                    $data["latitude"][] = '';

                  if(isset($myArray[$i]["properties"]["latitude"]))
                    $data["longitude"][] = $myArray[$i]["properties"]["latitude"];
                  else
                    $data["longitude"][] = '';

                  if(isset($myArray[$i]["properties"]["mp_lib"]))
                    $data["os"][] =     $myArray[$i]["properties"]["mp_lib"];
                  else
                    $data["os"][] =     '';
                    $currentcount++;
                }
         }

         $totalrecords = $currentcount;?>
         <table border="0" cellspacing="0" width="100%">
         <tr>
           <td align="center" style="padding: 5px;">
             <table border="0" cellspacing="4" width="100%">
               <tr>
                <td align="left" class="disp" style="width: 50%;">
                <!--<input type="button" class="butt-active1" value="Export" id="exportreport" style="margin-bottom: 7px;width: 114px;">
                <br>-->
                 Total Entry : <?php echo $totalrecords;?>   
                </td>
              </tr>
            </table>
         </td>
     </tr>
   <tr>
      <td align="center">
         <table id="customers" border="0" cellspacing="0" width="99%">
      <tr>
      <th align="center">S.No</th>
      <th align="center">Name</th>
      <th align="center">Phone Number</th>    
      <th align="center">Image</th>
      <th align="center">Date</th>
      <th align="center">Time</th>
      <th align="center">Time Taken (Min)</th>
      <th align="center">Distance (Mt)</th>
      <th align="center">Velocity (Mt/Min)</th>
      <th align="center">Latitude</th>
      <th align="center">Longitude</th>
      <th></th>
  </tr>
    <?php 
       if($totalrecords>0) {  
        /* $limit = $totalrecords;
         $page  = $_POST["page"]+1;
         $start = ($page*$limit)-$limit;
         $end = $page*$limit;
         if($end>$totalrecords)
         $end = $totalrecords;
         if($totalrecords<$limit){
          $numpages = 1;
         }
         else
         {
           $numpages  = $totalrecords/$limit;
           $quo       = $totalrecords%$limit;
           if($quo>0)
            $numpages++;
         }
         $filterlist = array();
         $innerarray = array();


         /*for ($t=0;$t<count($data["name"]);$t++) 
         {
             $ss = $data["interval"][$t] / 1000;  $dt->setTimestamp($ss); $dt->format('Y-m-d');
             $timestamp = ($data["interval"][$t]/1000);
             $timezone = "Asia/Kolkata";
             $dt = new DateTime();
             $dt->setTimestamp($timestamp);
             $dt->setTimezone(new DateTimeZone($timezone));
             $datetime = $dt->format('h:i:s A');
             $fulltime = $dt->format('Y-m-d h:i:s A');
             if($latlonginfo[$data["phone_no"][$t]][0])
                $latitudeinfo = $latlonginfo[$data["phone_no"][$t]][0];
             else
               $latitudeinfo = $data["latitude"][$t];

            if($latlonginfo[$data["phone_no"][$t]][1])
              $longitudeinfo = $latlonginfo[$data["phone_no"][$t]][1];
            else
              $longitudeinfo = $data["longitude"][$t];

             $innerarray[$data["phone_no"][$t]]["username"][]   =   $data["username"][$t];
             $innerarray[$data["phone_no"][$t]]["phone_no"][]   =   $data["phone_no"][$t];
             $innerarray[$data["phone_no"][$t]]["name"][]       =   $data["name"][$t];
             $innerarray[$data["phone_no"][$t]]["date"][]       =   $dt->format('Y-m-d');
             $innerarray[$data["phone_no"][$t]]["datetime"][]   =   $datetime;
             $innerarray[$data["phone_no"][$t]]["hour"][]       =   number_format($data["chour"][$t],2);
             $innerarray[$data["phone_no"][$t]]["distance"][]   =   number_format($data["distance"][$t],3);
             $innerarray[$data["phone_no"][$t]]["velocity"][]   =   number_format($data["velocity"][$t],7);
             $innerarray[$data["phone_no"][$t]]["latitude"][]   =    $latitudeinfo;
             $innerarray[$data["phone_no"][$t]]["longitude"][]  =   $longitudeinfo;
         }*/


         for ($t=0;$t<count($data["name"]);$t++) 
         {
           //if(in_array ($data["phone_no"][$t],$filterlist))
           // continue;
           $filterlist[] = $data["phone_no"][$t];
           $timestamp = ($data["interval"][$t]/1000);
           $timezone = "Asia/Kolkata";
           $dt = new DateTime();
           $dt->setTimestamp($timestamp);
           $dt->setTimezone(new DateTimeZone($timezone));
           $datetime = $dt->format('h:i:s A');
           $fulltime = $dt->format('Y-m-d h:i:s A');
           if(isset($_POST["times"]) && isset($_POST["lat"]) && isset($_POST["lon"]))
           {
              $starttime = strtotime($post_date);
              $clickedtime = strtotime($fulltime);
              $differenttime = $clickedtime-$starttime;
              $calculationhour = $differenttime / 60;
              
              if($latlonginfo[$data["phone_no"][$t]][0])
               $latitudeinfo = $latlonginfo[$data["phone_no"][$t]][0];
              else
               $latitudeinfo = $data["latitude"][$t];

              if($latlonginfo[$data["phone_no"][$t]][1])
               $longitudeinfo = $latlonginfo[$data["phone_no"][$t]][1];
              else
               $longitudeinfo = $data["longitude"][$t];

              $distance = $this->User_model->distance($_POST["lat"],$_POST["lon"],$latitudeinfo,$longitudeinfo,"K");
              $velocity = ($distance*1000)/$calculationhour;
           }
       
           if(trim($_POST["times"])== '' || trim($_POST["lat"])=='' || trim($_POST["lon"])=='')
           {
              $velocity = 0;
           }
           if(in_array ($data["interval"][$t],$intervel))
           {
                  $bgcolor = 'style="background-color:#87CEFF;"';
                  $disable = 'style="width: 50px; height: 50px; cursor: not-allowed;"';
                  $model = '';
           }
           else
           {
                $bgcolor = '';
                $disable = 'style="width: 50px; height: 50px; cursor: pointer;"';
                $model = 'myModal';
           }
           
           $approved_html = "";
           if (in_array($data["name"][$t], $approved_photos))
           {
             $approved_html = '<i style="font-size:25px;" title="Fancier approved photo" class="fa fa-check" aria-hidden="true"></i>';
           }
           else
           {
             $approved_html = '';
           }

           ?>
           <tr <?php echo $bgcolor;?> id="rowide<?php echo $t;?>">
               <td><?php echo $t+1;?><?php echo "&nbsp;&nbsp;".$approved_html;?></td>
               <td align="center"><?php echo $data["username"][$t]?></td>
               <td align="center"><?php echo $data["phone_no"][$t]?></td>
           <?php
           $filepath = base_url();
           //$filepath = "http://104.236.218.51/spotlight/";
           $filename = $filepath."uploads/".$data["name"][$t];
           $uname =stripslashes(trim($data["username"][$t])) ;


               if (@getimagesize($filename)) { ?>
               <td align="center">
                 <img id="imageide<?php echo $t; ?>" src="<?php echo $filepath;?>uploads/<?php echo $data["name"][$t]?>" data-toggle="modal" data-target="#myModal<?php echo $t; ?>" <?php echo $disable;?> >
                 <div id="<?php echo $model; ?><?php echo $t; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog" style="width:700px;">
                          <div class="modal-content" style="width:700px;">

                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                             </div>
                                <div class="modal-body image_resizing" style="text-align: center;">
                                          <img class="zoom-class" src="<?php echo $filepath;?>uploads/<?php echo $data["name"][$t]?>" data-zoom-image="<?php echo $filepath;?>uploads/<?php echo $data["name"][$t]?>" class="img-responsive">
                                          </div>           
                                      
                             <div class="modal-footer">
                                  <div style="width:100%;text-align: center;"><b>Bird Type : <?php echo $bird_type;?></b></div>
                                  <div style="width:100%;text-align: center;"><button type="button" id="verify_data" class="btn btn-primary" onclick="verify_report('<?php echo $clubtype;?>','<?php echo $uname;?>','<?php echo $data["phone_no"][$t];?>','<?php echo $data["name"][$t];?>','<?php echo number_format($data["chour"][$t],2); ?>','<?php echo $data["deivce_id"][$t]; ?>','<?php echo $data["interval"][$t]; ?>','<?php echo number_format($data["velocity"][$t],7);?>','<?php echo number_format($data["distance"][$t],3);?>','<?php echo $latitudeinfo;?>','<?php echo $longitudeinfo;?>','<?php echo $t;?>','<?php echo $event_id;?>','<?php echo $evnt_dis;?>','<?php echo $bird_type;?>')">Verify</button></div> 
                                   <?php
                                   /*if($bird_type == ''){
                                        $bird_query  = $this->db->query("SELECT * FROM ppa_bird_type");
                                        $bird_result = $bird_query->result();
                                        ?>
                                       <p class="font-italic pull-left">Bird Types</p>
                                       <hr>
                                      <?php
                                            foreach ($bird_result as $key=>$birdlist ) {
                                            //while($rowl1 = mysqli_fetch_array ($live2)) {
                                                 if($birdlist->brid_type != "") {
                                                    ?>
                                                     <div class="form-check pull-left">
                                                        <label>
                                                            <input type="radio" name="radio_btn" value="<?php echo $birdlist->b_id;?>"> <span class="label-text"><?php echo $birdlist->brid_type;?></span>
                                                        </label>
                                                    </div>
                                                    <?php
                                                 }
                                            }
                                    }
                                    else*/
                                    //{ ?>
                                        
                                   <?php
                                    //}

                                    
                                   ?>
                                   <div id="statusdiv<?php echo $t; ?>" style="color: green;    padding: 10px;"></div>
                                 
                              </div>
                          </div>
                        </div>
                  </div>
                </td>
                <?php } else {  ?>
                <td align="center"><img width="60" height="60" src="http://www.brady.eu/Images/BradyGlobal/no-preview-thumb.gif"></td>
                <?php } ?>
                <td align="center"><?php $ss = $data["interval"][$t] / 1000;  $dt->setTimestamp($ss); echo $dt->format('Y-m-d');?></td>
                <td align="center"><?php echo $datetime;?></td>
                <td align="center"><?php echo number_format($data["chour"][$t],2)."";?></td>
                <td align="center"><?php echo number_format($data["distance"][$t],3)."";?></td>
                <td align="center"><?php echo number_format($data["velocity"][$t],7)."";?></td>
                <td align="center">
                   <?php if($latlonginfo[$data["phone_no"][$t]][0])
                             $latitudeinfo = $latlonginfo[$data["phone_no"][$t]][0];
                         else
                             $latitudeinfo = $data["latitude"][$t];

                         if($latlonginfo[$data["phone_no"][$t]][1])
                            $longitudeinfo = $latlonginfo[$data["phone_no"][$t]][1];
                         else
                            $longitudeinfo = $data["longitude"][$t];
                    ?>
                    <p><?php echo $latitudeinfo;?></p>
                 </td>
                 <td><p><?php echo $longitudeinfo;?></p></td>
                 <td><br><br><a href="http://maps.google.com/?q=<?php echo $latitudeinfo?>,<?php echo $longitudeinfo?>" target="_blank">Map View</a></td>
          </tr>
          <?php } } else { ?>
          <tr>
           <td colspan="14" align="center" style="color:red;">No Records Available for the selected date.. choose  other date.</td>
          </tr>
          <?php } ?>
         </table>
         </td>
      </tr>
   </table>
<?php
}


    public function verifyphotos()
    {
       // print_r($_REQUEST);
        $event_id = '';
        $event_details_id = '';
        $events_sche_date = '';
        $bird_type = '';
        if(isset($_POST['event_id'])){ $event_id = $_POST['event_id']; } else { $event_id = ''; }
        if(isset($_POST['event_details_id'])){ $event_details_id = $_POST['event_details_id'];} else { $event_details_id = '';}
        if(isset($_POST['events_sche_date'])){ $events_sche_date = $_POST['events_sche_date'];} else { $events_sche_date = '';}
        if(isset($_POST['bird_type'])){ $bird_type = $_POST['bird_type'];} else { $bird_type = '';}

        $select_lats = $this->db->query("select * from ppa_register");
        $latresultdata = $select_lats->result();
        foreach ($latresultdata as $row)
        {
            $latlonginfo[$row->phone_no][0] = $row->latitude;
            $latlonginfo[$row->phone_no][1] = $row->longitude;  
        }
        
        $ch = curl_init();
        //$selecteddate = '2017-12-28';
        date_default_timezone_set ( 'Asia/Kolkata' );
        $current_date = date ( 'Y-m-d' );
        $date = strtotime($_POST["values1"]);
        $evnt_dis = $_POST["evnt_distance"];
        $clubtype = $_POST["org_code"];
        $dateconvert = date("Y-m-d", $date);
        
        $selecteddate = $_POST["values"];
        $selecteddate2 = '';
        if($current_date < $dateconvert){
              $selecteddate2 = $current_date;
        }
        else{
              $selecteddate2 = $_POST["values1"];
        }

        $nice_date = date('d/m/Y', strtotime( $selecteddate ));
        $post_date = $_POST["values"]." ".trim($_POST["times"]);
   
        $verified = $this->db->query("SELECT intervel FROM ppa_report WHERE start_date='".$nice_date."' AND apptype='".$clubtype."'");
        $verifieddata = $verified->result();
        $intervel = array ();
        foreach ($verifieddata as $verifyrow)
        {
            $intervel[] = $verifyrow->intervel;    
        }
    
        $headers = array("Authorization: Basic " . base64_encode('69c7a42185701fb8077d724bb85c909b'));
        curl_setopt($ch, CURLOPT_URL, 'https://data.mixpanel.com/api/2.0/export/?from_date='.$selecteddate.'&to_date='.$selecteddate2.'&event=%5B%22new_photo%22%5D');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
    
        if(curl_error($ch))
        {
          $errror = 1;
        }

        curl_close($ch);
        $result = str_replace("}}","}},", $result);
        $result = "[".substr($result,0,strlen($result)-1)."]";      
        $myArray = json_decode($result, true);
        $brand = '$brand';
        $city = '$city';
        $model = '$model';
        $data['city'] = array();
        
        // User approved images list
        $choosen_Date = date('Y-m-d', strtotime( $selecteddate ))." 00:00:00";
        $verified_photo = $this->db->query("SELECT photo_name FROM ppa_updatephoto WHERE cre_date >='".$choosen_Date."' AND club_code='".$clubtype."'");
        $verified_photores = $verified_photo->result();
        foreach ($verified_photores as $verified_photorow)
        {
          $approved_photos[] = $verified_photorow->photo_name;
        }
        
        // End user approved images list

        // Sorting start
        for($i=0;$i<count($myArray);$i++)
        {
          $timestamp = ($myArray[$i]["properties"]["interval"]/1000);
          $timezone = "Asia/Kolkata";
          $dt = new DateTime();
          $dt->setTimestamp($timestamp);
          $dt->setTimezone(new DateTimeZone($timezone));
          //$datetime = $dt->format('Y-m-d h:i:s A (l)');
          if($clubtype=='indp')
            $railtime = $dt->format('H');
          else
            $railtime = 0;
        
          // calculate velocity
          $st_time=strtotime($post_date);
          $timestamp = ($myArray[$i]["properties"]["interval"]/1000);
          $timezone = "Asia/Kolkata";
          $dt = new DateTime();
          $dt->setTimestamp($timestamp);
          $dt->setTimezone(new DateTimeZone($timezone)); 
          $datetime = $dt->format('h:i:s A');
          $fulltime = $dt->format('Y-m-d h:i:s A');
          $exfulltime = $dt->format('Y-m-d h:i:s A');
          $fulldate = $dt->format('Y-m-d ');
          $fullextime = $dt->format('h:i:s');       
          $endtime_ram = $dt->format('h:i');
                 
          if(isset($_POST["times"]) && isset($_POST["lat"]) && isset($_POST["lon"]))
          {
              $clickeddate = strtotime($fulldate);
              $startdate = strtotime($selecteddate);
              $calculationhour = 0;
              $phour = 0;
              if($clickeddate == $startdate){
                  $starttime = strtotime($post_date);
                  $clickedtime = strtotime($fulltime);
                  $differenttime = $clickedtime-$starttime;
                  $calculationhour = $differenttime / 60;
              }
              else{
                      $calculationhour = 0;
                      $chk_date = $this->db->query("SELECT * FROM ppa_event_details as a LEFT JOIN ppa_bird_type as b on b.b_id=a.bird_id WHERE a.event_id= '".$event_id."' AND a.race_distance='".$evnt_dis."' AND b.brid_type='".$bird_type."'");
                      $chk_datedata = $chk_date->result();
                      $chk_date = mysqli_query($link->con,"SELECT * FROM ppa_event_details as a LEFT JOIN ppa_bird_type as b on b.b_id=a.bird_id WHERE a.event_id= '".$event_id."' AND a.race_distance='".$evnt_dis."' AND b.brid_type='".$bird_type."'");
              
                      $phour = 0;
                      foreach ($chk_datedata as $chk_datedatarow)
                      {
                      $racestartdate = strtotime($chk_datedatarow->date);
                      $racestarttime = strtotime($chk_datedatarow->start_time);
                      $extimedata = date('h:i:s A', $racestarttime);
                    
                      if($clickeddate == $racestartdate){
                        $full_start_date = $chk_datedatarow->date.' '.$extimedata;
                        $extime =  strtotime($exfulltime) - strtotime($full_start_date);
                        $init = $extime;
                        //$balancemin = date('i', $extime);
                        $hours = floor($init / 3600);
                        $minutes = floor(($init / 60) % 60);
                        $seconds = $init % 60;
                        $phour =$phour + ($hours * 60) + $minutes;
                        //echo "IN ".$phour;
                        
                       }else{
                        //echo h2m("1:45");
                        $phour = $phour + $this->User_model->h2m($chk_datedatarow->boarding_time);
                     }
                
                   }
             
                  $calculationhour = $phour;
               }
            
            if($latlonginfo[$myArray[$i]["properties"]["phone_no"]][0])
                $latitudeinfo = $latlonginfo[$myArray[$i]["properties"]["phone_no"]][0];
            else
                $latitudeinfo = $myArray[$i]["properties"]["longitude"];
            
            if($latlonginfo[$myArray[$i]["properties"]["phone_no"]][1])
                $longitudeinfo = $latlonginfo[$myArray[$i]["properties"]["phone_no"]][1];
            else
                $longitudeinfo = $myArray[$i]["properties"]["latitude"];
            
            
            $distance = $this->User_model->distance($_POST["lat"],$_POST["lon"],$latitudeinfo,$longitudeinfo,"K");
            $velocity1 = ($distance*1000)/$calculationhour;
        }
        
        if(trim($_POST["times"])== '' || trim($_POST["lat"])=='' || trim($_POST["lon"])=='')
        {
            $velocity1 = 0;
            $distance  = 0;
        }
        if($latitudeinfo==0 || $longitudeinfo==0 || $latitudeinfo=='0' || $longitudeinfo=='0' || $latitudeinfo=='' || $longitudeinfo=='')
        {
            $velocity1 = 0;
            $distance = 0;
        }
        
        // echo $myArray[$i]["properties"]["interval"]." - ".$latitudeinfo." - ".$longitudeinfo." - ".$velocity1." - <br>";
        $myArray[$i]["properties"]["velocity"]= $velocity1;
        $myArray[$i]["properties"]["distance"]= $distance;
         $myArray[$i]["properties"]["chour"]= $calculationhour;
        
        $data["velocity1"][] = $velocity1;
        }
    
        // sorting end
        if(count($myArray)>0)
        array_multisort($data["velocity1"], SORT_DESC,SORT_NUMERIC, $myArray);
        $currentcount=0;

        for($i=0;$i<count($myArray);$i++)
         {
               if($myArray[$i]["properties"]["apptype"]==$clubtype)  // For PPA club
               {
                  if(isset($myArray[$i]["properties"]["date"]))
                    $data["date"][] = $myArray[$i]["properties"]["date"];
                  else
                    $data["date"][] = '';
    
                  if(isset($myArray[$i]["properties"]["velocity"]))
                    $data["velocity"][] = $myArray[$i]["properties"]["velocity"];
                  else
                    $data["velocity"][] = '';
    
                  if(isset($myArray[$i]["properties"]["chour"]))
                    $data["chour"][] = $myArray[$i]["properties"]["chour"];
                  else
                    $data["chour"][] = '';
    
                  if(isset($myArray[$i]["properties"]["distance"]))
                    $data["distance"][] = $myArray[$i]["properties"]["distance"];
                  else
                    $data["distance"][] = '';
    
           
                  if(isset($myArray[$i]["properties"][$brand]))
                    $data["brand"][] =  $myArray[$i]["properties"][$brand];
                  else
                    $data["brand"][] =  '';

                  if(isset($myArray[$i]["properties"][$model]))
                    $data["model"][] =  $myArray[$i]["properties"][$model];
                  else
                    $data["model"][] =   '';
            
                  if(isset($myArray[$i]["properties"][$city]))
                    $data["city"][] =   $myArray[$i]["properties"][$city];
                  else
                    $data["city"][] =   '';


                  if(isset($myArray[$i]["properties"]["interval"]))
                    $data["interval"][] = $myArray[$i]["properties"]["interval"];
                  else
                    $data["interval"][] = '';

                  if(isset($myArray[$i]["properties"]["isValid"]))
                    $data["isValid"][] = $myArray[$i]["properties"]["isValid"];
                  else
                    $data["isValid"][] = '';

                  if(isset($myArray[$i]["properties"]["deivce_id"]))
                    $data["deivce_id"][] = $myArray[$i]["properties"]["deivce_id"];
                  else
                    $data["deivce_id"][] = '';

                  if(isset($myArray[$i]["properties"]["name"]))
                    $data["name"][] = $myArray[$i]["properties"]["name"];
                  else
                    $data["name"][] = '';

                  if(isset($myArray[$i]["properties"]["username"]))
                    $data["username"][] = $myArray[$i]["properties"]["username"];
                  else
                    $data["username"][] = '';

                  if(isset($myArray[$i]["properties"]["phone_no"]))
                    $data["phone_no"][] = $myArray[$i]["properties"]["phone_no"];
                  else
                    $data["phone_no"][] = '';

                  if(isset($myArray[$i]["properties"]["longitude"]))
                    $data["latitude"][] = $myArray[$i]["properties"]["longitude"];      // lat&long changed in app
                  else
                    $data["latitude"][] = '';

                  if(isset($myArray[$i]["properties"]["latitude"]))
                    $data["longitude"][] = $myArray[$i]["properties"]["latitude"];
                  else
                    $data["longitude"][] = '';

                  if(isset($myArray[$i]["properties"]["mp_lib"]))
                    $data["os"][] =     $myArray[$i]["properties"]["mp_lib"];
                  else
                    $data["os"][] =     '';
                    $currentcount++;
                }
         }

         $totalrecords = $currentcount;?>
          <?php $counts = 0;
       //if($totalrecords>0) {  
        
         for ($t=0;$t<count($data["name"]);$t++) 
         {
           if($data["phone_no"][$t]!=$_POST["phoneno"])
            continue;
           $counts++;
           $filterlist[] = $data["phone_no"][$t];
           $timestamp = ($data["interval"][$t]/1000);
           $timezone = "Asia/Kolkata";
           $dt = new DateTime();
           $dt->setTimestamp($timestamp);
           $dt->setTimezone(new DateTimeZone($timezone));
           $datetime = $dt->format('h:i:s A');
           $fulltime = $dt->format('Y-m-d h:i:s A');
           if(isset($_POST["times"]) && isset($_POST["lat"]) && isset($_POST["lon"]))
           {
              $starttime = strtotime($post_date);
              $clickedtime = strtotime($fulltime);
              $differenttime = $clickedtime-$starttime;
              $calculationhour = $differenttime / 60;
              
              if($latlonginfo[$data["phone_no"][$t]][0])
               $latitudeinfo = $latlonginfo[$data["phone_no"][$t]][0];
              else
               $latitudeinfo = $data["latitude"][$t];

              if($latlonginfo[$data["phone_no"][$t]][1])
               $longitudeinfo = $latlonginfo[$data["phone_no"][$t]][1];
              else
               $longitudeinfo = $data["longitude"][$t];

              $distance = $this->User_model->distance($_POST["lat"],$_POST["lon"],$latitudeinfo,$longitudeinfo,"K");
              $velocity = ($distance*1000)/$calculationhour;
           }
       
           if(trim($_POST["times"])== '' || trim($_POST["lat"])=='' || trim($_POST["lon"])=='')
           {
              $velocity = 0;
           }
           if(in_array ($data["interval"][$t],$intervel))
           {
                  $bgcolor = 'style="background-color:#87CEFF;"';
                  $disable = 'style="width: 50px; height: 50px; cursor: not-allowed;"';
                  $model = '';
           }
           else
           {
                $bgcolor = '';
                $disable = 'style="width: 50px; height: 50px; cursor: pointer;"';
                $model = 'myModal';
           }
           
           $approved_html = "";
           if (in_array($data["name"][$t], $approved_photos))
           {
             $approved_html = '<i style="font-size:25px;" title="Fancier approved photo" class="fa fa-check" aria-hidden="true"></i>';
           }
           else
           {
             $approved_html = '';
           }

           ?>
           
             <!--  <td><?php echo $t+1;?><?php echo "&nbsp;&nbsp;".$approved_html;?></td>
               <td align="center"><?php echo $data["username"][$t]?></td>
               <td align="center"><?php echo $data["phone_no"][$t]?></td>-->
           <?php
           $filepath = base_url();
           //$filepath = "http://104.236.218.51/spotlight/";
           $filename = $filepath."uploads/".$data["name"][$t];
           $uname =stripslashes(trim($data["username"][$t])) ;


               if (@getimagesize($filename)) { ?>
                
               <div class="gallery">
                 <div class="img-magnifier-container">
                 <img width="250" height="300" id="imageide<?php echo $t; ?>" src="<?php echo $filepath;?>uploads/<?php echo $data["name"][$t]?>" ></div>
                 <div id="<?php echo $model; ?><?php echo $t; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog" style="width:700px;">
                          <div class="modal-content" style="width:700px;">

                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                             </div>
                                <div class="modal-body image_resizing" style="text-align: center;">
                                          <img class="zoom-class" src="<?php echo $filepath;?>uploads/<?php echo $data["name"][$t]?>" data-zoom-image="<?php echo $filepath;?>uploads/<?php echo $data["name"][$t]?>" class="img-responsive">
                                          </div>           
                                      
                             <div class="modal-footer">
                                  <div style="width:100%;text-align: center;"><b>Bird Type : <?php echo $bird_type;?></b></div>
                                  <div style="width:100%;text-align: center;"><button type="button" id="verify_data" class="btn btn-primary" onclick="verify_report('<?php echo $clubtype;?>','<?php echo $uname;?>','<?php echo $data["phone_no"][$t];?>','<?php echo $data["name"][$t];?>','<?php echo number_format($data["chour"][$t],2); ?>','<?php echo $data["deivce_id"][$t]; ?>','<?php echo $data["interval"][$t]; ?>','<?php echo number_format($data["velocity"][$t],7);?>','<?php echo number_format($data["distance"][$t],3);?>','<?php echo $latitudeinfo;?>','<?php echo $longitudeinfo;?>','<?php echo $t;?>','<?php echo $event_id;?>','<?php echo $evnt_dis;?>','<?php echo $bird_type;?>')">Verify</button></div> 
                                   <?php
                                   /*if($bird_type == ''){
                                        $bird_query  = $this->db->query("SELECT * FROM ppa_bird_type");
                                        $bird_result = $bird_query->result();
                                        ?>
                                       <p class="font-italic pull-left">Bird Types</p>
                                       <hr>
                                      <?php
                                            foreach ($bird_result as $key=>$birdlist ) {
                                            //while($rowl1 = mysqli_fetch_array ($live2)) {
                                                 if($birdlist->brid_type != "") {
                                                    ?>
                                                     <div class="form-check pull-left">
                                                        <label>
                                                            <input type="radio" name="radio_btn" value="<?php echo $birdlist->b_id;?>"> <span class="label-text"><?php echo $birdlist->brid_type;?></span>
                                                        </label>
                                                    </div>
                                                    <?php
                                                 }
                                            }
                                    }
                                    else*/
                                    //{ ?>
                                        
                                   <?php
                                    //}

                                    
                                   ?>
                                   <div id="statusdiv<?php echo $t; ?>" style="color: green;    padding: 10px;"></div>
                                 
                              </div>
                          </div>
                        </div>
                  </div>
                  <div class="desc" >Time Taken (Min) : <?php echo number_format($data["chour"][$t],2)."";?> <br>Distance (Mt) : <?php echo number_format($data["distance"][$t],3)."";?> <br> Velocity (Mt/Min) : <?php echo number_format($data["velocity"][$t],7)."";?>
                  <?php if(!in_array ($data["interval"][$t],$intervel)) { ?><br><div style="height:50px;text-align: center;vertical-align: middle;padding-top: 15px;" id="buttonarea<?php echo $t;?>"><a style="cursor: pointer;" onclick="verify_report('<?php echo $clubtype;?>','<?php echo $uname;?>','<?php echo $data["phone_no"][$t];?>','<?php echo $data["name"][$t];?>','<?php echo number_format($data["chour"][$t],2); ?>','<?php echo $data["deivce_id"][$t]; ?>','<?php echo $data["interval"][$t]; ?>','<?php echo number_format($data["velocity"][$t],7);?>','<?php echo number_format($data["distance"][$t],3);?>','<?php echo $latitudeinfo;?>','<?php echo $longitudeinfo;?>','<?php echo $t;?>','<?php echo $event_id;?>','<?php echo $evnt_dis;?>','<?php echo $bird_type;?>')"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal">Approve</button></a></div>
                  	<?php } else {?>
                  	<br>
                  	<div style="height:50px;text-align: center;vertical-align: middle;padding-top: 15px;" id="buttonarea<?php echo $t;?>"><a style="cursor: pointer;" onclick="remove_report('<?php echo $clubtype;?>','<?php echo $uname;?>','<?php echo $data["phone_no"][$t];?>','<?php echo $data["name"][$t];?>','<?php echo number_format($data["chour"][$t],2); ?>','<?php echo $data["deivce_id"][$t]; ?>','<?php echo $data["interval"][$t]; ?>','<?php echo number_format($data["velocity"][$t],7);?>','<?php echo number_format($data["distance"][$t],3);?>','<?php echo $latitudeinfo;?>','<?php echo $longitudeinfo;?>','<?php echo $t;?>','<?php echo $event_id;?>','<?php echo $evnt_dis;?>','<?php echo $bird_type;?>')"><button type="button" class="btn-sm  btn " style="background-color:red;border-color:red;color:white;" data-toggle="modal">Decline</button></a></div>
                  	<?php } ?>
                  </div>
                  </div>
                <?php } else {  ?>
                <div align="center"><img width="60" height="60" src="http://www.brady.eu/Images/BradyGlobal/no-preview-thumb.gif"></div>
                <?php } ?>
                <!--<td align="center"><?php $ss = $data["interval"][$t] / 1000;  $dt->setTimestamp($ss); echo $dt->format('Y-m-d');?></td>
                <td align="center"><?php echo $datetime;?></td>
                <td align="center"><?php echo number_format($data["chour"][$t],2)."";?></td>
                <td align="center"><?php echo number_format($data["distance"][$t],3)."";?></td>
                <td align="center"><?php echo number_format($data["velocity"][$t],7)."";?></td>
                <td align="center">-->
                   <?php if($latlonginfo[$data["phone_no"][$t]][0])
                             $latitudeinfo = $latlonginfo[$data["phone_no"][$t]][0];
                         else
                             $latitudeinfo = $data["latitude"][$t];

                         if($latlonginfo[$data["phone_no"][$t]][1])
                            $longitudeinfo = $latlonginfo[$data["phone_no"][$t]][1];
                         else
                            $longitudeinfo = $data["longitude"][$t];
                    ?>
                 <!--</td>
                 <td><p><?php echo $longitudeinfo;?></p></td>
                 <td><br><br><a href="http://maps.google.com/?q=<?php echo $latitudeinfo?>,<?php echo $longitudeinfo?>" target="_blank">Map View</a></td>-->
         
          <?php  } ?>
            
            <?php if($counts==0 || $totalrecords==0) { ?>
              <div>
               <td colspan="14" align="center" style="color:red;">No Records Available for the selected fancier.. choose  other one.</td>
              </div>
            <?php } ?>
<?php
}
    public function fancier(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $this->load->view('include/header');
            $data['getcompanylists'] = $this->User_model->getcompanylists();
            $this->load->view('fancier_table',$data);                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function basketing(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $this->load->view('include/header');
            $eventide = $this->uri->segment(3);
            $data['result_data'] = $this->User_model->getresults($eventide);
            $data['getcompanylists'] = $this->User_model->getcompanylists();
            $data['geteventfancierlists'] = $this->User_model->geteventfancierlists($eventide);
            $this->load->view('basketing_table',$data);                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function viewbasketing(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $this->load->view('include/header');
            $eventide = $this->uri->segment(3);
            $data['result_data'] = $this->User_model->getresults($eventide);
            $data['getcompanylists'] = $this->User_model->getcompanylists();
            $data['geteventfancierlists'] = $this->User_model->geteventfancierlists($eventide);
            $this->load->view('view_basketentry',$data);                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function addrace(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $this->load->view('include/header');
            $this->load->view('add_race');                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }
 
    public function raceresults(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $resultid = $this->uri->segment(3);
            $data['result_data'] = $this->User_model->getresults($resultid);
            $this->load->view('include/header',$data);
            $this->load->view('results',$data);                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }


    public function editrace(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $this->load->view('include/header');
            $this->load->view('edit_race');                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function races(){
        is_login();
        if(CheckPermission("users", "own_read")){
            $this->load->view('include/header');
            $data['getcompanylists'] = $this->User_model->getcompanylists();
            $this->load->view('race_table',$data);                
            $this->load->view('include/footer');            
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function changeaccountstatus()
    {
        $status = $_POST["status"];
        $ide = $_POST["ide"];
        $query = $this->db->query("update ppa_register set status='".$status."' where reg_id='".$ide."'");
       // echo "update ppa_register set status='".$status."' where reg_id='".$ide."'";
        echo "0";

    }
  
   public function changeloftstatus()
    {
        $status = $_POST["status"];
        $ide = $_POST["ide"];
        $query = $this->db->query("update ppa_register set loftstatus='".$status."' where reg_id='".$ide."'");
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
        {
         $html = "Unpublished <a style='cursor:pointer;' onclick=changeresultstatus(".$ide.",'1')>Make Publish</a>";  
        }
        else
        {

         $html = "Published <a style='cursor:pointer;' onclick=changeresultstatus(".$ide.",'0')>Make Unpublish</a>";  
         $this->sendnotification($ide);

        }
        echo $html;

    }

    
   public function sendnotification($ide)
   {
       $selectfanciers = $this->db->query("SELECT * FROM `ppa_register` as a LEFT JOIN users as b ON a.`apptype` = b.Org_code LEFT JOIN ppa_events as c ON c.Org_id= b.users_id WHERE c.Events_id='".$ide."'");
       $selectuserlist = $selectfanciers->result();
       foreach ($selectuserlist as $key=>$user ) { 
              $android_deviceide = $user->android_id;
              $username = $user->username;
              $apptype  = $user->apptype;
              $racename = $user->Event_name;
              $message='{"ResponseCode":"100","UserName":"'.$username.'","Apptype":"'.$apptype.'","Title":"Photo Taken","Message":"Hello Mr.'.$username.', '.$racename.'race result released please check out :)"}';
              $pushparameter="";
              $badge=1;
              $android_deviceide = "daFawQQJQLw:APA91bE1ljTEf1u89M8ffpO7yiPClnhPRVXFTOpZrH2w5Su-CtnacQhef4_Bb93pioE3fwD4RXmVaBciBodf5FbeJ6cPo2sk2PK7WxlP2uPnawquD80EEcfEq4ZLPEbxs5aY39bYYkLs";
              //$android_deviceide = "ddadr9rxPww:APA91bGJEhtubzZk4nUHFjRxar4RKP1NjQ3OjJwNMs4AI_F6E7PVGQXLswvtYd61JS5B8ZqkABc_Kf9tpA1TLNIfF_YYbox0I7n1ynp5gnWuA72GLb4ROiUKbYLMoqObIHFXJ3PH0Tac";

              $this->sendAnroidPushNotification($message,$android_deviceide,$pushparameter,$badge);
       }
   }

   public function sendAnroidPushNotification($message="",$deviceToken="",$pushparameter="",$badge=1)
   {
            define( 'API_ACCESS_KEY', 'AIzaSyBd1d-aGtwwbG-QUWd67PIiUZtnI-aKVow' );
            $registrationIds = $deviceToken;    
           #prep the bundle

            $fields = array(
                'to' => $deviceToken,
                'data' => array('to' => $deviceToken, 'message' => $message)
            );
  
            $headers = array
            (
             'Authorization: key=' . API_ACCESS_KEY,
             'Content-Type: application/json'
            );
            #Send Reponse To FireBase Server  
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
            $logquery =$this->db->query("insert notificationlog set status ='".$result."',deviceid ='".$deviceToken."',deviceType='Android',message='".addslashes($message)."'");
            #Echo Result Of FireBase Server
            return $result;
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
    public function updateentryresult()
    {
      // print_r($_REQUEST);
      // die;
       $entryid = $_POST["entryid"];
       $ringno = $_POST["ringno"];
       for ($ide=0;$ide<count($entryid);$ide++)
       {
          $data["ring_no"]   = $ringno[$ide];     
          $birdtype          = explode("#",$_POST["birdtypes"][$ide]);
          $data["bird_type"] = $birdtype[0];
          $data["event_id"]  = $birdtype[1];
          $entryide          = $entryid[$ide];

          $timezone = "Asia/Kolkata";
          date_default_timezone_set($timezone);
          $curdate = date("Y-m-d H:i:s");
          
          $data["color"] = $_POST["birdcolor"][$ide];
          $data["gender"] = $_POST["gender"][$ide];
          $data["update_date"] = $curdate;
          $data["rubber_outer_no"] = $_POST["rubber_outer_no"][$ide];
          $data["rubber_inner_no"] = $_POST["rubber_inner_no"][$ide];
          $data["sticker_outer_no"] = $_POST["sticker_outer_no"][$ide];
          $data["sticker_inner_no"] = $_POST["sticker_inner_no"][$ide];
         // print_r($data);
         // $query = $this->db->query("select * from ppa_basketing where event_id='".$birdtype[1]."' and fancier_id='".$fancieride."' and ring_no='".$ringno[$ide]."'");
         // $checkcount = $query->num_rows();
         // if($checkcount==0)
          $this->User_model->updateRow('ppa_basketing','entry_id',$entryide, $data);
         //else
         // $ringnumbers.= $ringno[$ide].",";

       }
    }
    public function updatebasket()
    {
       
       $eventide   = $_POST["eventide"];
       $fancieride = $_POST["fancieride"];
       $birdtype   = explode("#",$_POST["birdtypes"]); // Birdtype and event details id coming jointly in this variable.

       $query = $this->db->query("select b.Org_code from users as b LEFT JOIN ppa_events as c ON c.Org_id=b.users_id where c.Events_id='".$eventide."'");
       $orgdetails = $query->result();
       $org_code   = $orgdetails[0]->Org_code;
       
       $ringno = $_POST["ringno"];
       $ringnumbers = '';
       for ($ide=0;$ide<count($ringno);$ide++)
       {
          $data["ring_no"] = $ringno[$ide];
          $data["event_id"] = $birdtype[1];
          $data["fancier_id"] = $fancieride;
          $data["org_code"] = $org_code;
          $data["bird_type"] = $birdtype[0];
          $timezone = "Asia/Kolkata";
          date_default_timezone_set($timezone);
          $curdate = date("Y-m-d H:i:s");
          
          $data["color"] = $_POST["colortypes"][$ide];
          $data["gender"] = $_POST["gender"][$ide];
          $data["update_date"] = $curdate;
          $data["rubber_outer_no"] = $_POST["rubber_outer_no"][$ide];
          $data["rubber_inner_no"] = $_POST["rubber_inner_no"][$ide];
          $data["sticker_outer_no"] = $_POST["sticker_outer_no"][$ide];
          $data["sticker_inner_no"] = $_POST["sticker_inner_no"][$ide];
         // print_r($data);
          $query = $this->db->query("select * from ppa_basketing where event_id='".$birdtype[1]."' and fancier_id='".$fancieride."' and ring_no='".$ringno[$ide]."'");
          $checkcount = $query->num_rows();
          if($checkcount==0)
          $this->User_model->insertRow('ppa_basketing',$data);
          else
          $ringnumbers.= $ringno[$ide].",";

       }
       if(trim($ringnumbers)!='')
       $this->session->set_flashdata('messagePr', 'Basket info added successfully & following ring numbers duplicated ( '.$ringnumbers.' ) ');
       else
       $this->session->set_flashdata('messagePr', 'Basket info added successfully');
       redirect( base_url().'user/basketing/'.$eventide, 'refresh');
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

        if($this->session->userdata('user_details')[0]->user_type !='Admin')
        $where = "apptype = '".$clubtype."' and apptype != ''";
        else
        {
         if(isset($_GET["companytype"]) && $_GET["companytype"]!='')
         $where = array("apptype = '".$_GET["companytype"]."'");
         else 
         $where = "";

        }
//echo "SS ".$where; die;
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

            if(trim($output_arr['data'][$key][5])=='1')
           {
            if(trim($output_arr['data'][$key][6])=='0')
                $output_arr['data'][$key][6] = '<span style="color:red;">Inactive</span> <br> <a style="cursor:pointer;" onclick="changeloftstatus('.$id.',1);">Make Active</a>';
            else
                $output_arr['data'][$key][6] = '<span style="color:green;">Active</span> <br> <a style="cursor:pointer;"  onclick="changeloftstatus('.$id.',0);">Make Inactive</a>';
            }
            else
             $output_arr['data'][$key][6] = "Not Applicable";

            if(trim($output_arr['data'][$key][5])=='0')
                $output_arr['data'][$key][5] = '<span style="color:red;">Inactive</span> <br> <a style="cursor:pointer;" onclick="changestatus('.$id.',1);">Make Active</a>';
            else
                $output_arr['data'][$key][5] = '<span style="color:green;">Active</span> <br> <a style="cursor:pointer;"  onclick="changestatus('.$id.',0);">Make Inactive</a>';

           

            //$output_arr['data'][$key][0] = "<input type='checkbox' value='".$id."' name='selData'>";
            $output_arr['data'][$key][1] = '<input type="checkbox" name="selData" value="'.$id.'">';
            $output_arr['data'][$key][0] = $rows;$rows++;

        }
        echo json_encode($output_arr);
    }

    
    public function basketingTable (){
        is_login();
        $raceeventide = $_GET["event"];
        $table = 'ppa_basketing';
        $primaryKey = 'entry_id';
        
        $birdtype = $this->db->query("SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type ,ed_id, race_distance , event_id  FROM `ppa_event_details` INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id where ppa_event_details.event_id='".$raceeventide . "'");
        $birdinfo = $birdtype->result();
        foreach ($birdinfo as $key=>$dis ) { 
          if($dis->b_id."#".$dis->ed_id!='')
           {
             $racecat[] = $dis->b_id."#".$dis->ed_id."$".$dis->race_distance." - ".$dis->brid_type;
           }
        }

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
           array( 'db' => 'a.entry_id', 'dt' => 0 ,'field' => 'entry_id'),
           array( 'db' => 'b.username', 'dt' => 1 ,'field' => 'username'),
                    array( 'db' => 'c.brid_type', 'dt' => 2,'field' => 'brid_type'),
                    array( 'db' => 'd.race_distance', 'dt' => 3 ,'field' => 'race_distance'),
                    array( 'db' => 'a.ring_no', 'dt' => 4,'field' => 'ring_no'),
                    array( 'db' => 'a.gender', 'dt' => 5,'field' => 'gender'),
                    array( 'db' => 'a.color', 'dt' => 6,'field' => 'color'),
                    array( 'db' => 'a.rubber_outer_no', 'dt' => 7,'field' => 'rubber_outer_no'),
                    array( 'db' => 'a.rubber_inner_no', 'dt' => 8,'field' => 'rubber_inner_no'),
                    array( 'db' => 'a.sticker_outer_no', 'dt' => 9,'field' => 'sticker_outer_no'),
                    array( 'db' => 'a.sticker_inner_no', 'dt' => 10,'field' => 'sticker_inner_no')
                   
            );
        //array( 'db' => 'a.entry_id', 'dt' => 11 ,'field' => 'entry_id')
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        
        $clubtype = $this->session->userdata ('user_details')[0]->Org_code;
        $Join_condition=' from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id = b.reg_id LEFT JOIN ppa_bird_type as c ON c.b_id=a.bird_type LEFT JOIN ppa_event_details as d ON d.ed_id = a.event_id LEFT JOIN ppa_events as e ON d.event_id = e.Events_id';
       // if(trim($clubtype)!='' && $this->session->userdata('user_details')[0]->user_type !='Admin')
        if(isset($_GET["fanciertype"]) && $_GET["fanciertype"]!='')
        $where = "e.Events_id=".$raceeventide." and a.fancier_id=".$_GET["fanciertype"];
        else
        $where = "e.Events_id=".$raceeventide; 
        $groupby = "";
        //$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$Join_condition, $where);
         $output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $Join_condition, $where,$groupby);
        $rows =$_REQUEST["start"]+1;
        $racecatdropdown = '';
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
            $report = $output_arr['data'][$key][4];
            
            

            $output_arr['data'][$key][4] = "<input  class='form-control' style=width:120px; type='textbox' name='ringno[]' value='".$output_arr['data'][$key][4]."'>";
            $output_arr['data'][$key][7] = "<input class='form-control' style=width:120px; type='textbox' name='rubber_outer_no[]' value='".$output_arr['data'][$key][7]."'>";
            $output_arr['data'][$key][8] = "<input class='form-control' style=width:120px; type='textbox' name='rubber_inner_no[]' value='".$output_arr['data'][$key][8]."'>";
            $output_arr['data'][$key][9] = "<input class='form-control' style=width:120px; type='textbox' name='sticker_outer_no[]' value='".$output_arr['data'][$key][9]."'>";
            $output_arr['data'][$key][10] = "<input class='form-control' style=width:120px; type='textbox' name='sticker_inner_no[]' value='".$output_arr['data'][$key][10]."'>";
                    

            $birdcolordropdown = "<select name=birdcolor[] class=form-control input-sm>";
            $colorhightlight = '';
            for($t=0;$t<count($birdcolor);$t++)
            {
              if($output_arr['data'][$key][6]==$birdcolor[$t])
                $colorhightlight = "selected";
              else
                $colorhightlight = "";
              $birdcolordropdown.= "<option ".$colorhightlight." value='".$birdcolor[$t]."'>".$birdcolor[$t]."</option>";
            }
            $birdcolordropdown.= "</select>";

            $genderdropdown = "<select name=gender[] class=form-control input-sm>";
            $genderhightlight = '';
            for($t=0;$t<count($genderarray);$t++)
            {
              if($output_arr['data'][$key][5]==trim($genderarray[$t]))
                $genderhightlight = "selected";
              else
                $genderhightlight = "";
              $genderdropdown.= "<option ".$genderhightlight." value='".$genderarray[$t]."'>".$genderarray[$t]."</option>";
            }
            $genderdropdown.= "</select>";
           
            $output_arr['data'][$key][5] = $genderdropdown;
            $output_arr['data'][$key][6] = $birdcolordropdown;

            $racecatdropdown = "<select name=birdtypes[] class=form-control input-sm>";
            $racehightlight = "";
            for($t=0;$t<count($racecat);$t++) { 
              $values = explode("$",$racecat[$t]);
              $distvalues = explode("-",$values[1]);
              if($output_arr['data'][$key][3]==trim($distvalues[0]))
                $racehightlight = "selected";
              else
                $racehightlight = "";

              $racecatdropdown.="<option ".$racehightlight." value='".$values[0]."'>".$values[1]."</option>";
            } 
            $racecatdropdown.= "</select>";
            $output_arr['data'][$key][3] = $racecatdropdown;
            //$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '<a id="btnEditRow" class="modalButtonUser mClass"  href="'.base_url().'races/editrace/'.$id.'"  type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a><a data-toggle="modal" class="mClass" onclick="seteventId('.$id.', \'user\')"   data-src="'.$id.'" data-target="#cnfrm_delete" title="Delete race"><i class="fa fa-trash" data-id=""></i></a>';

            $output_arr['data'][$key][0] = "<input type='hidden' name='entryid[]' value='".$output_arr['data'][$key][0]."'>".$rows;$rows++;
           

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

                    //array( 'db' => 'c.start_date', 'dt' => 8,'field' => 'start_date'),
                    array( 'db' => 'c.start_time', 'dt' => 8,'field' => 'start_time'),
                    array( 'db' => 'c.intervel', 'dt' => 9,'field' => 'intervel'),
                    array( 'db' => 'c.intervel', 'dt' => 10,'field' => 'intervel'),
                    array( 'db' => 'c.minis', 'dt' => 11,'field' => 'minis'),
                    array( 'db' => 'c.distance', 'dt' => 12,'field' => 'distance'),
                    array( 'db' => 'c.velocity', 'dt' => 13,'field' => 'velocity'),
                    //array( 'db' => 'c.latitude', 'dt' => 15,'field' => 'latitude'),
                    //array( 'db' => 'c.longtitude', 'dt' => 16,'field' => 'longtitude')
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

             $output_arr['data'][$key][9] = date('d-m-Y', ($output_arr['data'][$key][9] / 1000));
             $output_arr['data'][$key][10] = date('h:i:s A', ($output_arr['data'][$key][10] / 1000));

            if($editmode==1) {
            $output_arr['data'][$key][5] = "<input class='form-control' style=width:120px; type='textbox' name='ringno[]' value='".$output_arr['data'][$key][5]."'>";
            $birdcolordropdown = "<select name=birdcolor[] class=form-control input-sm>";
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

            $genderdropdown = "<select name=gender[] class=form-control input-sm>";
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
            //$output_arr['data'][$key][15] = number_format($output_arr['data'][$key][15],6);
            //$output_arr['data'][$key][16] = number_format($output_arr['data'][$key][16],6);
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
                    array( 'db' => 'CONCAT(c.Event_lat," - ",c.Event_long)', 'dt' => 4 ,'field' => 'CONCAT(c.Event_lat," - ",c.Event_long)'),
                    array( 'db' => 'c.Event_date', 'dt' => 5 ,'field' => 'Event_long'),
                    array( 'db' => 'e.event_id', 'dt' => 6,'field' => 'event_id'),
                    array( 'db' => 'e.event_id', 'dt' => 7,'field' => 'event_id'),
                    array( 'db' => 'e.event_id', 'dt' => 8,'field' => 'event_id'),
                    array( 'db' => 'c.Events_id', 'dt' => 9,'field' => 'Events_id')
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        
        $clubtype = $this->session->userdata ('user_details')[0]->Org_code;
        $clubide = $this->session->userdata ('user_details')[0]->users_id;
        
        $Join_condition=' from ppa_events as c LEFT JOIN users as d ON d.users_id = c.Org_id LEFT JOIN ppa_report as e ON e.event_id=c.Events_id';
        if($this->session->userdata('user_details')[0]->user_type !='Admin')
        $where = "c.Org_id = '".$clubide."'";
        else
        {
         if(isset($_GET["companytype"]) && $_GET["companytype"]!='')
         $where = "d.users_id = '".$_GET["companytype"]."'";
         else 
         $where = "";
        }
        $groupby = "c.Events_id";
        //$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$Join_condition, $where);
         $output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $Join_condition, $where,$groupby);
        $rows =$_REQUEST["start"]+1;
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
            $report = $output_arr['data'][$key][6];
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
           
           
            $timezone = "Asia/Kolkata";
            date_default_timezone_set($timezone);
            $curdate = date("Y-m-d");

           

           if(trim($output_arr['data'][$key][6])!='' && $output_arr['data'][$key][6] > 0) // Race completed wont delete and edit
           {
              $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= 'No Action';
              if(trim($output_arr['data'][$key][5])>$curdate)
              {
                $output_arr['data'][$key][6] = "<span style=color:orange;font-weight:bold;>Upcoming</span>";
                $output_arr['data'][$key][7] = "<span style=color:red;font-weight:bold;>Not Available</span>";
                $output_arr['data'][$key][8] = "<span style=color:red;font-weight:bold;>Not Available</span>";
              }
              else if(trim($output_arr['data'][$key][5])==$curdate)
              {
                $output_arr['data'][$key][6] = "<span style=color:green;font-weight:bold;>LIVE</span>";
                $output_arr['data'][$key][7] = '<span style=color:green;font-weight:bold;><a href="'.base_url().'user/raceinfo/'.$id.'">Live Results</a></span>';
                $output_arr['data'][$key][8] = '<span style=color:green;font-weight:bold;><a href="'.base_url().'user/verifyresult/'.$id.'">Verify Results</a></span>';
              }
              else
              {
                $output_arr['data'][$key][6] = "<span style=color:blue;font-weight:bold;>Completed</span><br><a href='".base_url().'user/raceresults/'.$id."'>View Results</a>";
                $output_arr['data'][$key][7] = '<span style=color:green;font-weight:bold;><a href="'.base_url().'user/raceinfo/'.$id.'">Live Results</a></span>';
                $output_arr['data'][$key][8] = '<span style=color:green;font-weight:bold;><a href="'.base_url().'user/verifyresult/'.$id.'">Verify Results</a></span>';
              }
           }
           else
           {
               $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="'.base_url().'races/editrace/'.$id.'"  type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a><a data-toggle="modal" class="mClass" onclick="seteventId('.$id.', \'user\')"   data-src="'.$id.'" data-target="#cnfrm_delete" title="Delete race"><i class="fa fa-trash" data-id=""></i></a>';

               if(trim($output_arr['data'][$key][5])>$curdate)
               {
                 $output_arr['data'][$key][6] = "<span style=color:orange;font-weight:bold;>Upcoming</span>";
                 $output_arr['data'][$key][7] = "<span style=color:red;font-weight:bold;>Not Available</span>";
                 $output_arr['data'][$key][8] = "<span style=color:red;font-weight:bold;>Not Available</span>";
               }
               else if(trim($output_arr['data'][$key][5])==$curdate)
               {
                 $output_arr['data'][$key][6] = "<span style=color:green;font-weight:bold;>LIVE</span>";
                 $output_arr['data'][$key][7] = '<span style=color:green;font-weight:bold;><a href="'.base_url().'user/raceinfo/'.$id.'">Live Results</a></span>';
                 $output_arr['data'][$key][8] = '<span style=color:green;font-weight:bold;><a href="'.base_url().'user/verifyresult/'.$id.'">Verify Results</a></span>';
               }
               else
               {
                 $output_arr['data'][$key][6] = "<span style=color:blue;font-weight:bold;>Completed</span>";
                 $output_arr['data'][$key][7] = '<span style=color:green;font-weight:bold;><a href="'.base_url().'user/raceinfo/'.$id.'">Live Results</a></span>';
                 $output_arr['data'][$key][8] = '<span style=color:green;font-weight:bold;><a href="'.base_url().'user/verifyresult/'.$id.'">Verify Results</a></span>';
               }
           }
            

            
           $output_arr['data'][$key][5] = "<a href='".base_url().'user/basketing/'.$id."'><i class='glyphicon glyphicon-plus' aria-hidden='true'></i>&nbsp;Add Entry</a><br><a href='".base_url().'user/viewbasketing/'.$id."'><i class='fa fa-hand-o-right' aria-hidden='true'></i>&nbsp;View Entry</a>";
            

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

    public function appraces(){
            $this->load->view('include/header');
            $this->load->view('apprace_table',$data);                
            $this->load->view('include/footer');            
        
    }

    public function appracesTable(){
        $table = 'ppa_events';
        $primaryKey = 'Events_id';
        

        $columns = array(
           array( 'db' => 'c.Events_id', 'dt' => 0 ,'field' => 'Events_id'),array( 'db' => 'c.Event_name', 'dt' => 1 ,'field' => 'Event_name'),
                    array( 'db' => 'c.Event_date', 'dt' => 2 ,'field' => 'Event_date'),
                    array( 'db' => 'c.result_publish', 'dt' => 3 ,'field' => 'result_publish'),
                    array( 'db' => 'c.result_publish', 'dt' => 4,'field' => 'result_publish')
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        
        $clubtype = 'PPA';
        
        $Join_condition=' from ppa_events as c LEFT JOIN users as d ON d.users_id = c.Org_id';
        $where = "";
        
        $groupby = "c.Events_id";
        //$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$Join_condition, $where);
         $output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $Join_condition, $where,$groupby);
        $rows =$_REQUEST["start"]+1;
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
            
            $timezone = "Asia/Kolkata";
            date_default_timezone_set($timezone);
            $curdate = date("Y-m-d");
            
            if($output_arr['data'][$key][3]=='1')
             $output_arr['data'][$key][4] = "<a href='".base_url().'user/appraceresults/'.$id."'>View Results</a>";
            else
             $output_arr['data'][$key][4] = ""; 

            
            if($output_arr['data'][$key][3]=='1')
             $output_arr['data'][$key][3] = "<span style='color:green;'>Published</span>";
            else
             $output_arr['data'][$key][3] = "<span style='color:red;'>Not Published</span>";

            
            
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
        //$data = $this->input->post();
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
           // $data = $this->input->post();
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
            $data['Expire_date'] = $this->input->post('expiryclubdate');
            $data['address'] = $this->input->post('address');
            $this->User_model->updateRow('users', 'users_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            //echo $this->db->last_query();
            //print_r($data);die;

            $this->db->where("users_id='$id'");
            $result = $this->db->get('users')->result();
            if($this->session->userdata ('user_details')[0]->user_type!='Admin')
            $this->session->set_userdata('user_details',$result);
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