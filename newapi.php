<?PHP
include "siteinfo.php";
$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);
$activeall = 1;
$cameraAllowed = "1";
$expirydate = '2019-03-31 00:00:00';

$curr_ip = "103.213.192.118";

// End


if(isset($_GET["action"])){
 $action = $_GET["action"];
  $secureusertoken = $_GET["userToken"];
 }
else if(isset($_POST["action"]))
   {
    $action = $_POST["action"];
    $postdetails = $_POST; 
    $secureusertoken = $postdetails["userToken"];
    
    //print_r($postdetails);die;
   }
else
{
    $postdetails = json_decode(file_get_contents('php://input'), TRUE); 

    $action = $postdetails["action"];
    $secureusertoken = $postdetails["userToken"];
    
    // Get org details
    $selectorg_details = mysqli_query($dbconnection,"select * from users where Org_code='".$postdetails["apptype"]."'");
    if(mysqli_num_rows($selectorg_details)>0)
    {
    $org_details = mysqli_fetch_array($selectorg_details);
    $expirydate  = $org_details["Expire_date"]." 00:00:00";
    $org_status  = $org_details["Org_status"];
    }
    // End
}

if($postdetails)
{
    $apptype = $postdetails["apptype"];
    $checkdate = date("Y-m-d H:i:s");
    $cameracheck = mysqli_query($dbconnection,"select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,a.date,a.end_time,TIMESTAMP(a.date, STR_TO_DATE(a.start_time, '%h:%i %p')) as stimes,TIMESTAMP(a.date, STR_TO_DATE(a.end_time, '%h:%i %p')) as etimes FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id where c.Org_code='".$apptype."' and ('".$checkdate."' BETWEEN TIMESTAMP(a.date, STR_TO_DATE(a.start_time, '%h:%i %p')) and TIMESTAMP(a.date, STR_TO_DATE(a.end_time, '%h:%i %p'))) and b.result_publish='0' group by a.race_distance order by etimes DESC");
    if(mysqli_num_rows($cameracheck)==0)  // If no events available ..camera diabled.
      $cameraAllowed = "0";
}


$headers = apache_request_headers();        
foreach ($headers as $header => $value) {
 if($header=="userToken")
  $secureusertoken = $value;
}


 // Checking code starts


 switch($action){
    case 'pparegister':   // Register and Login service

               $deviceide = $postdetails["deivce_id"];
               $username = $postdetails["username"];
               $apptype = $postdetails["apptype"];
               $password = $postdetails["password"];
               $phone_no = $postdetails["phone_no"];
               $model = $postdetails["model"];
               $version = $postdetails["ver"];
               $code = $postdetails["code"];    
               $timezone = "Asia/Kolkata";
               date_default_timezone_set($timezone);
               $curdate = date("Y-m-d H:i:s");
               $usercount = 0;
               // get org contact number
                    $orgcont_details = mysqli_query($dbconnection,"select * from users where Org_code='".$apptype."'");
                    $orgcontactdet = mysqli_fetch_array($orgcont_details);
                    $phone_num = $orgcontactdet["phone_no"];
                    $usercount = $orgcontactdet["usercount"];
               //
               $checkusercount = mysqli_query($dbconnection,"select * from ppa_register where phone_no!='".$phone_no."' and apptype='".$apptype."'");
              
               if(mysqli_num_rows($checkusercount)<$usercount)
               {

               $selectavailability = mysqli_query($dbconnection,"select * from ppa_register where phone_no='".$phone_no."' and apptype='".$apptype."'");
               if(mysqli_num_rows($selectavailability)==0) {
               $insert_qry = mysqli_query($dbconnection,"insert ppa_register set version='".$version."',code='".$code."',apptype='".$apptype."',username='".$username."',password='".$password."',phone_no='".$phone_no."',expiry_date='".$expirydate."',device_id='".$deviceide."',model='".$model."',cre_date='".$curdate."'");
               $ide = mysqli_insert_id($dbconnection);
               $useride = md5($ide);
               $updatetoken = mysqli_query($dbconnection,"update ppa_register set userToken='".$useride."' where reg_id='".$ide."'");
               $data["status"]=1;  // Updated
               $data["activestatus"]=$activeall;
               $data["accountstatus"]=0;
               $data["userToken"]=$useride;
               $data["userId"]=$ide;
               $data["loftstatus"]=0;
               $data["Orgphone_no"]=$phone_num;
               $data["usertype"]=0;
               $data["origin"]=$_SERVER['REMOTE_ADDR'];
               
               $data["isCameraAllowed"]= $cameraAllowed;
               $data["expirydate"]=$expirydate;
               echo json_encode($data);
               die;
               }
               else
               {
                  $data["status"]=0;
                  $data["msg"] = "Already user registered";
                  echo json_encode($data);
                  die;
                  $timezone = "Asia/Kolkata";
                  date_default_timezone_set($timezone);
                  $curdate = date("Y-m-d H:i:s");

                  $update_qry = mysqli_query($dbconnection,"update ppa_register set version='".$version."',code='".$code."',apptype='".$apptype."',username='".$username."',password='".$password."',phone_no='".$phone_no."',expiry_date='".$expirydate."',device_id='".$deviceide."',model='".$model."',update_date='".$curdate."' where phone_no='".$phone_no."' and apptype='".$apptype."'");
                   
                   // Get user account status
                    $accdetails = mysqli_fetch_array($selectavailability);
                   //
                   // get org contact number
                    $orgcont_details = mysqli_query($dbconnection,"select * from users where Org_code=".$apptype);
                    $orgcontactdet = mysqli_fetch_array($orgcont_details);
                    $phone_num = $orgcontactdet["phone_no"];
                    $ide = $accdetails["reg_id"];
                    $useride = md5($ide); 
                    $updatetoken = mysqli_query($dbconnection,"update ppa_register set userToken='".$useride."' where reg_id='".$ide."'");
                   //
                   $data["status"]=1;
                   $data["activestatus"]=$activeall;
                   $data["accountstatus"]=$accdetails["status"];
                   $data["userToken"]=$useride;
                   $data["userId"]=$ide;
                   $data["Orgphone_no"]=$phone_num;
                   $data["origin"]=$_SERVER['REMOTE_ADDR'];
                   $data["serorigin"]=$_SERVER['SERVER_ADDR'];
                   $data["usertype"]=$accdetails["usertype"];
                   $data["loftstatus"]=$accdetails["loftstatus"];
                   $data["isCameraAllowed"]= $cameraAllowed;
                   $data["expirydate"]=$expirydate;
                   $data["test"]=$upquery;
                   echo json_encode($data);
                   die;
               }
              }
              else
              {
                 $data["status"]=0;
                 $data["msg"] = "Fancier count limit reached. Please contact your Oraganization";
              }
             
    echo json_encode($data);
    break;
    
    case 'getusers':
          $apptype = $_GET["apptype"];
          $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
          $data["url"] = $SITEMAINURL."admin/app/user.php?club_type=".$apptype;
          $data["activestatus"]=$activeall;
          $data["expirydate"]=$expirydate;
          $data["isCameraAllowed"]= $cameraAllowed;
          echo json_encode($data);
          break;

    case 'racelist':
         $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
         $apptype =  $postdetails["apptype"];
         $query = mysqli_query($dbconnection,"select * from ppa_events as a LEFT JOIN users as b ON a.Org_id=b.users_id where b.Org_code='".$apptype."'") ;
         $racecount = mysqli_num_rows($query);
         $i=0;
         while($res = mysqli_fetch_array($query))
         {
           $data["racelist"][$i]["race_ide"]   = $res["Events_id"];
           $data["racelist"][$i]["race_name"]  = $res["Event_name"];
           $data["racelist"][$i]["race_date"]  = $res["Event_date"];
           $data["racelist"][$i]["race_status"]= $res["Event_status"];
           $i++; 
         }
         $data["race_count"]= $racecount;
         echo json_encode($data);
         break;

    case 'basketinfo':
         $authuser = checkauth($dbconnection,$secureusertoken);
         /* if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }*/

         $eventide =  $postdetails["event_id"];
         $apptype =  $postdetails["apptype"];
         $birdtype = mysqli_query($dbconnection,"SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type ,ed_id, race_distance , event_id  FROM `ppa_event_details` INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id where ppa_event_details.event_id='".$eventide . "' group by ppa_event_details.bird_id,ppa_event_details.race_distance");
         $i=0;
         
         $data["event_id"]  =  $postdetails["event_id"];

         while($birdinfo = mysqli_fetch_array($birdtype))
         {
           $data["birdinfo"][$i]["value"]   = $birdinfo["b_id"]."#".$birdinfo["ed_id"];
           $data["birdinfo"][$i]["text"]    = $birdinfo["race_distance"]." Km - ".$birdinfo["brid_type"];
           $i++; 
         }
         
         $birdcolorinfo = mysqli_query($dbconnection,"select * from pigeons_color");
         $i=0;
         while($birdcolinfo = mysqli_fetch_array($birdcolorinfo))
         {
           $data["birdcolor"][$i] = $birdcolinfo["color"];
           $i++; 
         }

         $fancierinfo = mysqli_query($dbconnection,"select * from ppa_register where apptype='".$apptype."'");
         $i=0;
         while($fancierlist = mysqli_fetch_array($fancierinfo))
         {
           $data["fancierinfo"][$i]["useride"] = $fancierlist["reg_id"];
           $data["fancierinfo"][$i]["username"] = $fancierlist["username"];
           $i++; 
         }
         echo json_encode($data);
         break;
    
    case 'viewbasketinfo':
         $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
         $eventide =  $postdetails["event_id"];
         $apptype =  $postdetails["apptype"];
         if(isset($postdetails["fancieride"]))
          $fancier = " and a.fancier_id='".$postdetails["fancieride"]."'";
         else
          $fancier = "";

         $basketquery = mysqli_query($dbconnection,"select a.entry_id,a.fancier_id,b.username,a.ring_no,a.color,a.gender,c.brid_type,f.race_distance from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id = b.reg_id LEFT JOIN ppa_bird_type as c ON c.b_id=a.bird_type LEFT JOIN ppa_event_details as d ON d.ed_id = a.event_id LEFT JOIN ppa_events as e ON d.event_id = a.event_id LEFT JOIN ppa_event_details as f ON f.ed_id=a.event_details_id where a.event_id='".$eventide . "'".$fancier."");
         
         $i=0;
         
         $data["event_id"]  =  $postdetails["event_id"];

         while($basketinfo = mysqli_fetch_array($basketquery))
         {
           $data["basketinfo"][$i]["entry_id"]   = $basketinfo["entry_id"];
           $data["basketinfo"][$i]["fancier_id"]   = $basketinfo["fancier_id"];
           $data["basketinfo"][$i]["username"]   = $basketinfo["username"];
           $data["basketinfo"][$i]["birdcategory"]   = $basketinfo["brid_type"];
           $data["basketinfo"][$i]["raceinfo"]   = $basketinfo["race_distance"]." km";
           $data["basketinfo"][$i]["ringno"]   = $basketinfo["ring_no"];
           $data["basketinfo"][$i]["gender"]   = $basketinfo["gender"];
           $data["basketinfo"][$i]["color"]   = $basketinfo["color"];

           $i++; 
         }
         
         $fancierinfo = mysqli_query($dbconnection,"select * from ppa_register where apptype='".$apptype."'");
         $i=0;
         while($fancierlist = mysqli_fetch_array($fancierinfo))
         {
           $data["fancierinfo"][$i]["useride"] = $fancierlist["reg_id"];
           $data["fancierinfo"][$i]["username"] = $fancierlist["username"];
           $i++; 
         }
         echo json_encode($data);
         break;

    case 'deletebasketinfo':
         $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
         $evententryide =  $postdetails["entry_id"];

         $deletebasketentry = mysqli_query($dbconnection,"delete from ppa_basketing where entry_id='".$evententryide."'");

         $eventide =  $postdetails["event_id"];
         $apptype =  $postdetails["apptype"];
         if(isset($postdetails["fancieride"]))
          $fancier = " and a.fancier_id='".$postdetails["fancieride"]."'";
         else
          $fancier = "";

         $basketquery = mysqli_query($dbconnection,"select a.entry_id,b.username,a.ring_no,a.color,a.gender,c.brid_type,f.race_distance from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id = b.reg_id LEFT JOIN ppa_bird_type as c ON c.b_id=a.bird_type LEFT JOIN ppa_event_details as d ON d.ed_id = a.event_id LEFT JOIN ppa_events as e ON d.event_id = a.event_id LEFT JOIN ppa_event_details as f ON f.ed_id=a.event_details_id where a.event_id='".$eventide . "'".$fancier."");
         
         $i=0;
         
         $data["event_id"]  =  $postdetails["event_id"];

         while($basketinfo = mysqli_fetch_array($basketquery))
         {
           $data["basketinfo"][$i]["entry_id"]   = $basketinfo["entry_id"];
           $data["basketinfo"][$i]["username"]   = $basketinfo["username"];
           $data["basketinfo"][$i]["birdcategory"]   = $basketinfo["brid_type"];
           $data["basketinfo"][$i]["raceinfo"]   = $basketinfo["race_distance"]." km";
           $data["basketinfo"][$i]["ringno"]   = $basketinfo["ring_no"];
           $data["basketinfo"][$i]["gender"]   = $basketinfo["gender"];
           $data["basketinfo"][$i]["color"]   = $basketinfo["color"];

           $i++; 
         }
         
         $fancierinfo = mysqli_query($dbconnection,"select * from ppa_register where apptype='".$apptype."'");
         $i=0;
         while($fancierlist = mysqli_fetch_array($fancierinfo))
         {
           $data["fancierinfo"][$i]["useride"] = $fancierlist["reg_id"];
           $data["fancierinfo"][$i]["username"] = $fancierlist["username"];
           $i++; 
         }

         $data["status"]=1;
         $data["msg"]="Your basket information deleted successfully";  // Updated
         echo json_encode($data);
         break;



    case 'insertbasket':
          $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
          $apptype     = $postdetails["apptype"];
          $birdinfo     = explode("#",$postdetails["birdcategory"]);
          $event_id     = $postdetails["event_id"];
          $eventdetails_id     = $birdinfo[1];
          
          $fancier_id  = $postdetails["fancier_id"];
          if(!isset($postdetails["phone_no"]))
          $phone_no    = 0;
          else
          $phone_no    =  $postdetails["phone_no"];

          if(!isset($postdetails["birdcategoryid"]))
          $birdtype    = 0;
          else
          $birdtype    =  $postdetails["birdcategoryid"];
          
          // if fancier id null means fancier try to insert the user
          if($fancier_id=="") {
          $fancierinfo = mysqli_query($dbconnection,"select * from ppa_register where apptype='".$apptype."' and phone_no='".$phone_no."' limit 0,1");
          $fancierlist = mysqli_fetch_array($fancierinfo);
          $fancier_id  = $fancierlist["reg_id"];
          }
          // end


          $duplicate = "";  
          $count = 0;        
          for ($t=0;$t<count($postdetails["birds"]);$t++) {
          $ringno      = $postdetails["birds"][$t]["ringno"];
          $color       = $postdetails["birds"][$t]["color"];
          $gender      = $postdetails["birds"][$t]["gender"];
          $update_date = date("Y-m-d H:i:s");
          $checkselect = mysqli_query($dbconnection,"select event_id from ppa_basketing where event_id='".$event_id."' and ring_no='".$ringno."'");
            if(mysqli_num_rows($checkselect)==0){
             $insert_qry = mysqli_query($dbconnection,"insert ppa_basketing set event_id='".$event_id."',event_details_id='".$eventdetails_id."',fancier_id='".$fancier_id."',org_code='".$apptype."',ring_no='".$ringno."',bird_type='".$birdtype."',color='".$color."',gender='".$gender."',update_date='".$update_date."',admin_approval='0'");
             $count++;
             }
             else
             {
              $duplicate.= $ringno." , ";
             }
          }

          $data["status"]=1;  // Updated
          if($duplicate=="")
          $data["msg"]="Your information added successfully";  // Updated
          else
          $data["msg"]=$duplicate."  these ring numbers are already added";  // Updated
           
          if($count==0)
          {
            $data["status"]=0;
            $data["msg"]="Your information not added";  // Updated
          }
          echo json_encode($data);
          //print_r($postdetails);
          break;

    case 'getmyBasket':

          $authuser = checkauth($dbconnection,$secureusertoken);
          /*if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }*/

          $apptype      = $postdetails["apptype"];
          $catid     =$postdetails["categoryId"];
          $event_id     = $postdetails["raceId"];
          $event_details_id     = $postdetails["event_details_id"];

          $firstquery = mysqli_query($dbconnection,"SELECT max(date) as maxi,MIN(date) as mini,start_time as start FROM `ppa_event_details` WHERE event_id='".$event_id."'");
          $firstres = mysqli_fetch_array($firstquery);
          $racestartdate = $firstres["mini"];
          $starttime     = $firstres["start"];

          if(!isset($postdetails["phone_no"]))
          $phone_no    = 0;
          else
          $phone_no    =  $postdetails["phone_no"];
          
          // if fancier id null means fancier try to insert the user
          $fancierinfo = mysqli_query($dbconnection,"select * from ppa_register where apptype='".$apptype."' and phone_no='".$phone_no."' limit 0,1");
          $fancierlist = mysqli_fetch_array($fancierinfo);
          $fancier_id  = $fancierlist["reg_id"];
          
          // end
            $temp = array();
            $temp1 = array();
            

          if($event_details_id=='' || $event_details_id==0)
          {
          $query = mysqli_query($dbconnection,"select a.*,b.username as uname,b.latitude as loftlat,b.longitude as loftlong,e.Event_lat as eventlat,e.Event_long as eventlong,c.race_distance,d.brid_type  from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id=b.reg_id LEFT JOIN ppa_event_details as c ON c.ed_id=a.event_details_id LEFT JOIN ppa_bird_type as d ON d.b_id=c.bird_id LEFT JOIN ppa_events as e ON e.Events_id=a.event_id where a.event_id ='".$event_id."' and a.fancier_id ='".$fancier_id."'") ;
          }
          else
          {
          $query = mysqli_query($dbconnection,"select a.*,b.username as uname,b.latitude as loftlat,b.longitude as loftlong,e.Event_lat as eventlat,e.Event_long as eventlong,c.race_distance,d.brid_type  from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id=b.reg_id LEFT JOIN ppa_event_details as c ON c.ed_id=a.event_details_id LEFT JOIN ppa_bird_type as d ON d.b_id=c.bird_id LEFT JOIN ppa_events as e ON e.Events_id=a.event_id where a.event_details_id='".$event_details_id."' and a.event_id ='".$event_id."' and a.fancier_id ='".$fancier_id."'") ;
          }
          $i=0;
          
          if(mysqli_num_rows($query)>0) {
          while($res = mysqli_fetch_array($query))
          {
              if($i==0)
              {
                $temp["status"]  = 1;
                $temp["userid"]  = $res["fancier_id"];
                $temp["username"]    = $res["uname"];
              }

              $updatedphoto = mysqli_query($dbconnection,"select photo_name from ppa_updatephoto where owner_ringno='".$res["ring_no"]."' and event_id ='".$event_id."' and phone_no='".$phone_no."' and club_code='".$apptype."' order by pid DESC limit 0,1");
              
              if(mysqli_num_rows($updatedphoto)>0) 
              {
                $photolists = mysqli_fetch_array($updatedphoto);
                $photo_url  = "https://lespoton.com/portal/uploads/".$photolists["photo_name"];

                // Start calculation
            
                $post_date       = str_replace("'", '',$racestartdate)." ".$starttime;     
                $timeinfo  = explode("_",$photolists["photo_name"]);
                $timestamp = (str_replace(".jpg","",$timeinfo[2])/1000);
                $st_time=strtotime($post_date);
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
                $clickeddate = strtotime($fulldate);
                $starteddate = strtotime(str_replace("'", '',$racestartdate));
                $calculationhour = 0;
                $phour = 0;
                if($clickeddate == $starteddate){
                 $starttime = strtotime($post_date);
                 $clickedtime = strtotime($fulltime);
                 $differenttime = $clickedtime-$starttime;
                 $calculationhour = $differenttime / 60;
                }
                else{   // a.ed_id='".$event_details_id."' AND
                 $calculationhour = 0;
                 $chk_date = mysqli_query($dbconnection,"SELECT * FROM ppa_event_details as a LEFT JOIN ppa_bird_type as b on b.b_id=a.bird_id WHERE a.event_id= '".$event_id."' AND date<='".$fulldate."' AND a.race_distance='".$res["race_distance"]."' AND b.brid_type='".$res["brid_type"]."'");
                 $chk_datedata = mysqli_fetch_array($chk_date);
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
                        $hours = floor($init / 3600);
                        $minutes = floor(($init / 60) % 60);
                        $seconds = $init % 60;
                        $secondstomin = $seconds / 60;
                        $phour =$phour + ($hours * 60) + $minutes+$secondstomin;
                        
                       }else{
                        $phour = $phour + h2m($chk_datedatarow->boarding_time);
                     }
                
                   }
             
                  $calculationhour = $phour;
                }
               
                $flydistance = distance($res["loftlat"],$res["loftlong"],$res["eventlat"],$res["eventlong"],"K");
                if($calculationhour==0)
                  $velocity1 = 0;
                else
                  $velocity1 = ($flydistance*1000)/$calculationhour;
                
                $flydistance = number_format($flydistance,5)." Km";
                $calculationhour    = number_format($calculationhour,2)." Min";
                $velocity1     = number_format($velocity1,7)." Mt/Min";
                // End Calculation  

              }
              else
              {
                $photo_url  = "";
                $flydistance = "";
                $velocity1 = "";
                $calculationhour = "";
              }

              $temp1["ringNo"] = $res["ring_no"];
              $temp1["Color"]  = $res["color"];
              $temp1["gender"] = $res["gender"];
              $temp1["basketStatus"] = $res["admin_approval"];
              $temp1["birdimage"] = $photo_url;
              $temp1["raceDistance"] = $flydistance;
              $temp1["timeTaken"]    = $calculationhour;
              $temp1["velocity"]     = $velocity1;
              $temp1["category"]     = $res["brid_type"];
              //$temp1["raceDistance"] = $res["race_distance"]." Km";
              $temp1["basketId"] = $res["entry_id"];
              //$temp1["loftDistance"] = $res["gender"];
              $temp["birdDetail"][] = $temp1;    
              $i++;
          }
            
            $data= $temp;
          }
          else
          {
            $data["msg"]="No Basketing lists found";
            $data["status"]="0";
          }

          //$data["qry"] = $dis_qry;
          
          echo json_encode($data);
          //print_r($postdetails);
          break;

    case 'categorylist':

          $authuser = checkauth($dbconnection,$secureusertoken);

          /*if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }*/


          error_reporting(-1);
          ini_set('display_errors', 1);
          $apptype =  $postdetails["apptype"];
          $selectdate = date("Y-m-d");

          date_default_timezone_set("Asia/Kolkata");
          $currdate = date('Y-m-d');
          $date = new DateTime($currdate); // For today/now, don't pass an arg.
          $date->modify("-3 day");
          $fromdate = $date->format("Y-m-d");
          $date2 = new DateTime($currdate);
          $date2->modify("+3 day");
          $todate = $date2->format("Y-m-d");
          $photo_created = $postdetails["photo_created"];

          //$query = mysqli_query($dbconnection,"select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,e.bird_name,e.color,e.ring_no,e.gender,e.rubber_inner_no,e.rubber_outer_no FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id INNER JOIN ppa_basketing as e on e.event_details_id=a.ed_id where c.Org_code='".$apptype."' and a.date >='".$fromdate."' and a.date <='".$todate."' and b.result_publish='0' group by a.bird_id order by a.ed_id ASC") ;
           

          $query = mysqli_query($dbconnection,"SELECT a.event_id,b.Event_name FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id = b.Events_id LEFT JOIN users as c on c.users_id = b.Org_id where c.Org_code='".$apptype."' and a.date >= '".$fromdate."' and a.date <= '".$todate."' order by a.event_id DESC limit 0,1") ;

          // select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,e.bird_name,e.color,e.gender,e.rubber_inner_no FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id INNER JOIN ppa_basketing as e on e.event_details_id=a.ed_id where c.Org_code='PPA' and a.date >='2019-10-27' and a.date <='2019-11-13' and b.result_publish='0' group by a.bird_id order by a.ed_id ASC
         
          $i=0;
          $temp = array();
          $temp1 = array();
          if(mysqli_num_rows($query)>0) {
          while($res = mysqli_fetch_array($query))
           {
              $temp["status"] = 1;
              $temp["race"]   = $res["Event_name"];
              $temp["raceId"] = $res["event_id"];
              $query1 = mysqli_query($dbconnection,"SELECT a.*,b.brid_type as birdtype FROM ppa_basketing as a LEFT JOIN ppa_bird_type as b on a.bird_type=b.b_id LEFT JOIN ppa_register as c on c.reg_id=a.fancier_id where a.event_id='".$res["event_id"]."' and a.org_code='".$apptype."' and c.phone_no='".$postdetails["phone_no"]."' and a.admin_approval='1'") ;
              while($res1 = mysqli_fetch_array($query1))
              {
                  $temp1["owner_ringno"]= $res1["ring_no"]."--".$res1["rubber_outer_no"];
                  $temp1["outer_no"]= $res1["rubber_outer_no"];
                  $temp1["fancier_id"]= $res1["fancier_id"];
                  $temp1["event_id"]= $res1["event_id"];
                  $temp1["gender"]= $res1["gender"];
                  $temp1["bird_color"]= $res1["color"];
                  $temp1["categoryname"]= $res1["birdtype"];
                  $temp1["categoryid"]= $res1["bird_type"]."#".$res1["event_details_id"]."#".$res["event_id"]."#".$res1["birdtype"]."#0";
                  $temp["birdsDetail"][] = $temp1;
              }

           }
            $data = $temp;
            $data["msg"]="Category List retrieved";
            if(mysqli_num_rows($query1)==0)
              $data["birdsDetail"] = $temp1;

          }
          else
          {
            $data["status"] = 0;
            $data["msg"]="No Category List retrieved";
            $data["birdsDetail"] = $temp;
          }

          echo json_encode($data);
          break;
    case 'categorylistold':

          $authuser = checkauth($dbconnection,$secureusertoken);

          /*if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }*/


          error_reporting(-1);
          ini_set('display_errors', 1);
          $apptype =  $postdetails["apptype"];
          $selectdate = date("Y-m-d");

          date_default_timezone_set("Asia/Kolkata");
          $currdate = date('Y-m-d');
          $date = new DateTime($currdate); // For today/now, don't pass an arg.
          $date->modify("-3 day");
          $fromdate = $date->format("Y-m-d");
          $date2 = new DateTime($currdate);
          $date2->modify("+3 day");
          $todate = $date2->format("Y-m-d");

          $query = mysqli_query($dbconnection,"select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,e.bird_name,e.color,e.ring_no,e.gender,e.rubber_inner_no,e.rubber_outer_no FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id INNER JOIN ppa_basketing as e on e.event_details_id=a.ed_id where c.Org_code='".$apptype."' and a.date >='".$fromdate."' and a.date <='".$todate."' and b.result_publish='0' group by a.bird_id order by a.ed_id ASC") ;

          // select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,e.bird_name,e.color,e.gender,e.rubber_inner_no FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id INNER JOIN ppa_basketing as e on e.event_details_id=a.ed_id where c.Org_code='PPA' and a.date >='2019-10-27' and a.date <='2019-11-13' and b.result_publish='0' group by a.bird_id order by a.ed_id ASC

          $i=0;
          if(mysqli_num_rows($query)>0) {
          while($res = mysqli_fetch_array($query))
          {
            $data["category"][$i]["name"]  = $res["race_distance"]." Km (".$res["brid_type"].")";
            $data["category"][$i]["value"] = $res["event_id"]."#".$res["ed_id"]."#".$res["bird_id"]."#".$res["brid_type"]."#".$res["race_distance"];
            $data["birdsDetail"][0]["owner_ringno"] = $res["ring_no"];
            $data["birdsDetail"][0]["gender"] = $res["gender"];
            $data["birdsDetail"][0]["bird_color"] = $res["color"];
            $i++;  
          }
            
            $data["msg"]="Category List retrieved";
          }
          else
            $data["msg"]="No categories found";

          echo json_encode($data);
          break;
    case 'updatephoto':
          //die($_SERVER['REMOTE_ADDR']);
          $com_ip = $_SERVER['REMOTE_ADDR'];
          
          /*$authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }*/

       
          $apptype =  $postdetails["apptype"];
          $filename =  $postdetails["filename"];
          $selectedvalue = $postdetails["category"];
          $deviceide = $postdetails["deivce_id"];
          $username = $postdetails["username"];
          $phone_no = $postdetails["phone_no"];
          if(isset($postdetails["loftDistance"]))
          $loftDistance = $postdetails["loftDistance"];
          else
          $loftDistance = 0;
            
          if(!isset($postdetails["auto_detected_tag_no"]))
          $auto_detected_tag_no = $postdetails["auto_detected_tag_no"];
          else
          $auto_detected_tag_no = '';

          if($postdetails["inner_ringno"])
          $inner_ringno = $postdetails["inner_ringno"];
          else
          $inner_ringno = "";
          if($postdetails["outer_ringno"])
          $outer_ringno = $postdetails["outer_ringno"];
          else
          $outer_ringno = "";
          if($postdetails["bird_color"])
          $bird_color = $postdetails["bird_color"];
          else
          $bird_color = "";

          if($postdetails["owner_ringno"])
          {
            $ownerinfodet  = explode("--",$postdetails["owner_ringno"]);
            $owner_ringno = $ownerinfodet[0];
          }
          else
          $owner_ringno = "";

          if($postdetails["gender"])
          $gender = $postdetails["gender"];
          else
          $gender = "";

          $selectedinfo  = explode("#",$selectedvalue);
          $update_date = date("Y-m-d H:i:s");
          // $res1["bird_type"]."#".$res1["event_details_id"]."#".$res["event_id"]."#".$res1["birdtype"]; from categorylist
           
          $racedistinfo   = mysqli_query($dbconnection,"select race_distance from ppa_event_details where ed_id='".$selectedinfo[1]."' limit 0,1");
          $racedistdet    = mysqli_fetch_array($racedistinfo);
          $race_distance  = $racedistdet[0]["race_distance"];

          $loftinfo   = mysqli_query($dbconnection,"select latitude,longitude from ppa_register where apptype='".$apptype."' and phone_no='".$phone_no."' limit 0,1");
          $loftinfodet    = mysqli_fetch_array($loftinfo);
          $loftlatitude   = $loftinfodet["latitude"];
          $loftlongitude  = $loftinfodet["longitude"];

           
          /*if($com_ip==$curr_ip)
           {
           	  //die("select race_distance from ppa_event_details where ed_id='".$selectedinfo[1]."' limit 0,1");
           }*/
         
          $checkphoto_entry   = mysqli_query($dbconnection,"select loftdistance from ppa_updatephoto where photo_name='".$filename."'");
          
          if(mysqli_num_rows($checkphoto_entry)==0 )
          {
            $insert_qry = mysqli_query($dbconnection,"insert ppa_updatephoto set loftdistance='".$loftDistance."',username='".$username."',detected_tag_no='".$auto_detected_tag_no."',phone_no='".$phone_no."',device_ide='".$deviceide."',event_id='".$selectedinfo[2]."',event_details_id='".$selectedinfo[1]."',birdtype='".$selectedinfo[0]."',race_distance='".$race_distance."',photo_name='".$filename."',club_code='".$apptype."',cre_date='".$update_date."',owner_ringno='".$owner_ringno."',gender='".$gender."',color='".$bird_color."'");
          }
          else
          {
            $update_qry = mysqli_query($dbconnection,"update ppa_updatephoto set loftdistance='".$loftDistance."',username='".$username."',detected_tag_no='".$auto_detected_tag_no."',phone_no='".$phone_no."',device_ide='".$deviceide."',event_id='".$selectedinfo[2]."',event_details_id='".$selectedinfo[1]."',birdtype='".$selectedinfo[0]."',race_distance='".$race_distance."',photo_name='".$filename."',club_code='".$apptype."',cre_date='".$update_date."',owner_ringno='".$owner_ringno."',gender='".$gender."',color='".$bird_color."' where photo_name='".$filename."' ");
          }
          


          //$ide = mysql_insert_id();
          $ide=mysqli_insert_id($dbconnection); 
          $latitude = 0;
          $longitude = 0;
          $distance = 0;
          if(isset($postdetails["latitude"]))
            $latitude = $postdetails["latitude"];
          if(isset($postdetails["longitude"]))
            $longitude = $postdetails["longitude"];

          $selectdate = date("Y-m-d"); 
          
          /*$selquery = mysqli_query($dbconnection,"select (6371 * acos( 
                cos( radians(b.Event_lat) ) 
              * cos( radians( ".$latitude." ) ) 
              * cos( radians( ".$longitude." ) - radians(b.Event_long) ) 
              + sin( radians(b.Event_lat) ) 
              * sin( radians( ".$latitude." ) )
                ) ) as distance FROM ppa_events as b where b.Events_id='".$selectedinfo[2]."'") ;*/

          $selquery = mysqli_query($dbconnection,"select * FROM ppa_events as b where b.Events_id='".$selectedinfo[2]."'") ;
          $res      = mysqli_fetch_array($selquery);
          $raceide  = $selectedinfo[2];

          $lat1     = $res["Event_lat"];
          $lon1     = $res["Event_long"];
          //$lat2     = $latitude;
          //$lon2     = $longitude;
          $lat2     = $loftlatitude;
          $lon2     = $loftlongitude;
          //$data["loftlat"] = $loftlatitude;

          $theta    = $lon1 - $lon2;
          $dist     = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist     = acos($dist);
          $dist     = rad2deg($dist);
          $miles    = $dist * 60 * 1.1515;
          
          $distance = $miles * 1.609344;                    
               
          $update_distance = mysqli_query($dbconnection,"update ppa_files set bird_type='".$selectedinfo[0]."',latitude='".$latitude."',longitude='".$longitude."',event_id='".$raceide."',distance='".$distance."',owner_ringno='".$owner_ringno."',bird_gender='".$gender."',bird_color='".$bird_color."' where filename='".$postdetails["filename"]."'");

          if($ide!=0)
          $data["status"] = 1;
          else
          $data["status"] = 0;
          $data["distance"]  = $distance;
          echo json_encode($data);
          break;

    case 'addpiegeon':
         $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
    error_reporting(-1);
    ini_set('display_errors', 1);
          $apptype =  $postdetails["apptype"];
          $bird_type =  $postdetails["bird_type"];
          $ringno = $postdetails["ringno"];
          $color = $postdetails["color"];
          $gender = $postdetails["gender"];
          $phone_no = $postdetails["phone_no"];
          $update_date = date("Y-m-d H:i:s");
          $checkqry = mysqli_query($dbconnection,"select * from pigeons where apptype='".$apptype."' and ringno='".$ringno."' and mobile_no='".$phone_no."'");

          if(mysqli_num_rows($checkqry)==0) 
          {
           $insert_qry = mysqli_query($dbconnection,"insert pigeons set bird_type='".$bird_type."',mobile_no='".$phone_no."',ringno='".$ringno."',color='".$color."',gender='".$gender."',apptype='".$apptype."',cre_date='".$update_date."'");
           $ide = mysqli_insert_id($dbconnection);
           $data["statusmsg"] = "Pigeons added successfully.";
          }
          else
          {
           $ide = 0;
           $data["statusmsg"] = "Ringno : ".$ringno." already available in our system. Contact admin for further";
          }
          
          if($ide!=0)
          $data["status"] = 1;
          else
          $data["status"] = 0;
            
          echo json_encode($data);
          break;

    case 'pigeoninfo':
    
          $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
          $select_color = mysqli_query($dbconnection,"select * from pigeons_color");
          $i=0;
          while($color_res = mysqli_fetch_array($select_color))
          {
            $data["color"][$i]["name"]  = $color_res["color"];
            $data["color"][$i]["ide"]  = $color_res["ide"];
            $i++;  
          }
          $select_birdtypes = mysqli_query($dbconnection,"select * from ppa_bird_type");
          $i=0;
          while($birdtype_res = mysqli_fetch_array($select_birdtypes))
          {
            $data["birdtype"][$i]["name"]  = $birdtype_res["brid_type"];
            $data["birdtype"][$i]["ide"]       = $birdtype_res["b_id"];
            $i++;  
          }
          echo json_encode($data);
          break;

    case 'verifyInnerRing':
    
          $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }

          $fancier_id = $_GET["fancier_id"]; 
          $eventdetails_id = $_GET["eventdetails_id"]; 
          
          $verifyInnerRing = mysqli_query($dbconnection,"select * from ppa_basketing where fancier_id='".$fancier_id."' and event_details_id='".$eventdetails_id."'");

          if(mysqli_num_rows($verifyInnerRing)>0)
          {
            $data["status"]=1;
            $data["msg"]="Valid Ring number";
          }
          else
          {
            $data["status"]=0;
            $data["msg"]="Invalid Ring number";
          }
          echo json_encode($data);
          break;

    case 'getevents':
          $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
          $apptype = $_GET["apptype"];
          $data["url"] = $SITEMAINURL."admin/app/event.php?club_type=".$apptype;
          $data["activestatus"]=$activeall;
          $data["expirydate"]=$expirydate;
          $data["isCameraAllowed"]= $cameraAllowed;
          echo json_encode($data);
          break;

    case 'current_time':
         $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
        date_default_timezone_set("Asia/Kolkata");
        $data["status"]=3;  
        $dd=date("Y-m-d H:i:s");
        $data["timezone"]=strtotime($dd);  
          echo json_encode($data);
          break;
    case 'locationupdate':

        $authuser = checkauth($dbconnection, $secureusertoken);

          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
               date_default_timezone_set("Asia/Kolkata");
               $path = "uploads/"; // Upload directory
               $count = 0;
               $latitude   = $_POST["latitude"];
               $longitude   = $_POST["longitude"];
               $raceide =  $_POST["racename"];
               $liberationtime =  $_POST["liberationtime"];

           if ($_FILES['files']['error'] != 4) 
                   { // No error found! Move uploaded files 
                       $timeval = time();
                       $path_parts = pathinfo($_FILES["files"]["name"]);
                       $extension = $path_parts['extension'];
                       if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$path_parts['basename']))
                            {
                                    
                              $filespath = $path_parts['basename'];
                              $data["status"]=1;
                              $data["activestatus"]=$activeall;
                              $data["expirydate"]= $expirydate;
                              $data["isCameraAllowed"]= $cameraAllowed;
                              $data["message"]="Race location updated successfully";  
                             // $deviceide  = $_POST["deivce_id"];
                                                            //$insert_qry = mysqli_query($dbconnection,"insert ppa_files set event_id='".$raceide."',latitude='".$latitude."',longitude='".$longitude."',club_code='".$apptype."',filename='".$filespath."',mobile='".$phone_no."',username='".$username."',cre_date=now()");
                              $update_eventloation = mysqli_query($dbconnection,"update ppa_events set liberation_url='".$filespath."',liberation_time='".$liberationtime."',Event_lat='".$latitude."',Event_long='".$longitude."' where Events_id='".$raceide."'");
                             // $filename = $path.$filespath;
                             // $imgData = resize_image($filename, 2000,2000,100); // 11327814
                             // imagejpeg($imgData, $filename);
                            }
                            else
                            {
                             // $data["status"]=0;
                             // $data["activestatus"]=$activeall;
                             // $data["expirydate"]=$expirydate;
                              //$data["isCameraAllowed"]= $cameraAllowed;
                              $data["message"]="Problem in updating liberation location";  
                            }
                   }
                   else
                   {
                   // $data["status"]=0;
                   // $data["activestatus"]=$activeall;
                   // $data["expirydate"]=$expirydate;
                   // $data["isCameraAllowed"]= $cameraAllowed;
                    $data["message"]="Problem in updating liberation location";  
                   }

        echo json_encode($data);
        break;
    
    
    case 'fancierdetails':
                    $userToken = $postdetails["userToken"];
                    $authuser = checkauth($dbconnection,$secureusertoken);

          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
                    $selectfanciers = mysqli_query($dbconnection,"select * from ppa_register where userToken='".$userToken."'");
                    $accdetails = mysqli_fetch_array($selectfanciers);
                    //$orgcont_details = mysqli_query($dbconnection,"select * from users where Org_code=".$apptype);
                    //$orgcontactdet = mysqli_fetch_array($orgcont_details);
                    //$phone_num = $orgcontactdet["phone_no"];
                    $ide = $accdetails["reg_id"];
                    $data["status"]=1;
                    $data["userToken"]=$accdetails["userToken"];
                    $data["username"]=$accdetails["username"];
                    $data["phone_no"]=$accdetails["phone_no"];
                    $data["apptype"]=$accdetails["apptype"];
                    $data["accountstatus"]=$accdetails["status"];
                    $data["android_id"]=$accdetails["android_id"]; 
                    $data["userId"]=$ide;
                    $data["Orgphone_no"]=$phone_num;
                    $data["usertype"]=$accdetails["usertype"];
                    $data["loftstatus"]=$accdetails["loftstatus"];
                    $data["profile_url"]=$SITEMAINURL."uploads/".$accdetails["profile_pic"]; 
                echo json_encode($data);
                break;  

    case 'editprofile':
        $authuser = checkauth($dbconnection,$secureusertoken);

          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
               date_default_timezone_set("Asia/Kolkata");
               $path = "uploads/"; // Upload directory
               $count = 0;
               $useride =  $_POST["userToken"];
          
           if ($_FILES['files']['error'] != 4) 
                   { // No error found! Move uploaded files 
                       $timeval = time();
                       $path_parts = pathinfo($_FILES["files"]["name"]);
                       $profilename = "profile_".$useride.".".$path_parts['extension'];
                       $extension = $path_parts['extension'];
                       if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$profilename))
                            {
                                    
                              $data["status"]=1;
                              $data["activestatus"]=$activeall;
                              $data["expirydate"]= $expirydate;
                              $data["isCameraAllowed"]= $cameraAllowed;
                              $data["message"]="Fancier profile updated successfully";  
                              $update_eventloation = mysqli_query($dbconnection,"update ppa_register set profile_pic='".$profilename."' where userToken='".$useride."'");
                              $data["profile_url"]=$SITEMAINURL."uploads/".$profilename; 
                              //$filename = $path.$profilename;
                              //$imgData = resize_image($filename, 2000,2000,100); // 11327814
                              //imagejpeg($imgData, $filename);
                            }
                            else
                            {
                             // $data["status"]=0;
                             // $data["activestatus"]=$activeall;
                             // $data["expirydate"]=$expirydate;
                              //$data["isCameraAllowed"]= $cameraAllowed;
                              $data["message"]="Problem in updating fancier profile";  
                            }
                   }
                   else
                   {
                   // $data["status"]=0;
                   // $data["activestatus"]=$activeall;
                   // $data["expirydate"]=$expirydate;
                   // $data["isCameraAllowed"]= $cameraAllowed;
                    $data["message"]="Problem in updating fancier profile";  
                   }

        echo json_encode($data);
        break;
    case 'racelistinfo':
          $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
          $apptype = $postdetails["apptype"];
          date_default_timezone_set("Asia/Kolkata");
          $currdate = date('Y-m-d');
          $date = new DateTime($currdate); // For today/now, don't pass an arg.
          $date->modify("-3 day");
          $fromdate = $date->format("Y-m-d");
          $date2 = new DateTime($currdate);
          $date2->modify("+3 day");
          $todate = $date2->format("Y-m-d");
          
         // $fromdate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
          //$todate   = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $date) ) ));

          $select_races = mysqli_query($dbconnection,"select a.* from ppa_events as a LEFT JOIN users as b ON b.users_id=a.Org_id where b.Org_code='".$apptype."' and a.Event_date >= '".$fromdate."' and a.Event_date <= '".$todate."' order by a.Event_date DESC ");
          
          $i=0;
          while($race_res = mysqli_fetch_array($select_races))
          {
            $data["race"][$i]["name"]  = $race_res["Event_name"]." ( ".$race_res["Event_name"]." )";
            $data["race"][$i]["ide"]  = $race_res["Events_id"];
            $i++;  
          }
          echo json_encode($data);
          break;


    case 'raceDetails':
          /*$authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }*/
          $apptype = $postdetails["apptype"];
          date_default_timezone_set("Asia/Kolkata");
          $currdate = date('Y-m-d');
          $date = new DateTime($currdate); // For today/now, don't pass an arg.
          $date->modify("-3 day");
          $fromdate = $date->format("Y-m-d");
          $date2 = new DateTime($currdate);
          $date2->modify("+3 day");
          $todate = $date2->format("Y-m-d");
          
         // $fromdate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
          //$todate   = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $date) ) ));

          //$select_races = mysqli_query($dbconnection,"select a.Event_name,a.Events_id from ppa_events as a LEFT JOIN users as b ON b.users_id=a.Org_id where b.Org_code='".$apptype."' and YEARWEEK(a.Event_date) = YEARWEEK(NOW()) group by a.Events_id order by a.Events_id DESC");
          $select_races = mysqli_query($dbconnection,"select a.Event_name,a.Events_id from ppa_events as a LEFT JOIN users as b ON b.users_id=a.Org_id where b.Org_code='".$apptype."' and a.Event_date >= '".$fromdate."' and a.Event_date <= '".$todate."' group by a.Events_id order by a.Events_id DESC");
          $i=0;
          
          if(mysqli_num_rows($select_races)==0)
          {
            $temp = array();
            $data["status"] = 0;
            $data["racelist"] = $temp;
          }
          else
          {
          while($race_res = mysqli_fetch_array($select_races))
          {
            //$data["race"][$i]["name"]  = $race_res["Event_name"]." ( ".$race_res["Event_name"]." )";
            //$data["race"][$i]["ide"]  = $race_res["Events_id"];
           
            $raceide = $race_res["Events_id"];
            //$bird_id = $race_res["bird_id"];
            $temp = array();
            $temp1 = array();
            $temp["racename"]  = $race_res["Event_name"];
            $temp["raceid"]    = $race_res["Events_id"];
            //$data[] = $temp;
            $select_races_details = mysqli_query($dbconnection,"select c.ed_id,c.bird_id,d.brid_type from ppa_event_details as c LEFT JOIN ppa_bird_type as d ON d.b_id=c.bird_id where c.event_id='".$raceide."' group by bird_id ORDER by ed_id ASC");

               while($race_res_det = mysqli_fetch_array($select_races_details))
               {
                   //$temp1["category"] = $race_res_det["brid_type"]."#".$race_res_det["ed_id"];
                   $temp1["category"] = $race_res_det["brid_type"]."#".$race_res_det["ed_id"];
                   $temp1["categoryid"] = $race_res_det["bird_id"];
                   $temp["raceCategegory"][] = $temp1;
               }
              $data["status"] = 1;
              $data["racelist"][] = $temp;
            $i++;  
          }
          }
          echo json_encode($data);
          break;

    case 'syncinfo':
         $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
       error_reporting(-1);
          ini_set('display_errors', 1);
          date_default_timezone_set("Asia/Kolkata");
          $dd=date("Y-m-d H:i:s");
          $given = new DateTime($dd);
          $data["localDate"] = $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e
          $given->setTimezone(new DateTimeZone("UTC"));
          $data["utcDate"] =  $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e 
          $utcgiven = strtotime($data["utcDate"]);
          $istgiven = strtotime($data["localDate"]);
          $data["returnType"] = "json";
          $data["timezone"] = "UTC";
          //$data["daylightSavingTime"] = false;
          $data["url"] = $SITEMAINURL."newapi.php";
          $data["timestamp"] = $utcgiven;
          $data["isttimestamp"] = $istgiven;

          $apptype  =  $postdetails["apptype"];
          if(isset($postdetails["phone"]))
          $phone_no =  $postdetails["phone"];
          else
          $phone_no = 0;
            
          $selectavailability = mysqli_query($dbconnection,"select usertype from ppa_register where phone_no='".$phone_no."' and apptype='".$apptype."'");
          $accdetails = mysqli_fetch_array($selectavailability);
          $data["usertype"]=$accdetails["usertype"];



          echo json_encode($data);
          break;
    case 'loftstatus':
          $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
          $apptype    = $postdetails["apptype"];
          $deviceide  = $postdetails["deivce_id"];
          $phone_no = $postdetails["phone_no"];
          $select_loftstat = mysqli_query($dbconnection,"select * from ppa_register where phone_no='".$phone_no."' and apptype='".$apptype."'");
          if(mysqli_num_rows($select_loftstat)>0) {
            $details = mysqli_fetch_array($select_loftstat);
            $data["loftstatus"]=$details["loftstatus"]; 
          }
          else
           $data["loftstatus"]=0; 

          $data["status"]=1;
          $data["activestatus"]=$activeall;
          $data["expirydate"]=$expirydate;
          $data["isCameraAllowed"]= $cameraAllowed;
          echo json_encode($data);
          break;

    case 'accountstatus':
          $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
          $apptype    = $postdetails["apptype"];
          $deviceide  = $postdetails["deivce_id"];
          $phone_no = $postdetails["phone_no"];
          $select_loftstat = mysqli_query($dbconnection,"select * from ppa_register where phone_no='".$phone_no."' and apptype='".$apptype."'");
          if(mysqli_num_rows($select_loftstat)>0) {
            $details = mysqli_fetch_array($select_loftstat);
            $data["accountstatus"]=$details["status"]; 
          }
          else
           $data["accountstatus"]=0; 

          $data["status"]=1;
          $data["activestatus"]=$activeall;
          $data["expirydate"]=$expirydate;
          $data["isCameraAllowed"]= $cameraAllowed;
          echo json_encode($data);
          break;

    case 'loftdetail':
          $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
          $apptype    = $postdetails["apptype"];
          $deviceide  = $postdetails["deivce_id"];
          $phone_no   = $postdetails["phone_no"];

          $select_loftstat = mysqli_query($dbconnection,"select * from ppa_register where phone_no='".$phone_no."' and apptype='".$apptype."'");

          if(mysqli_num_rows($select_loftstat)>0) {
            $details = mysqli_fetch_array($select_loftstat);

            $data["loftstatus"]=$details["loftstatus"]; 
            $data["loft_image"]=$SITEMAINURL."uploads/".$details["loft_image"]; 
            $data["latitude"]=$details["latitude"]; 
            $data["longitude"]=$details["longitude"]; 
            
          }
          else
          {
           $data["loftstatus"]=0; 
           $data["loft_image"]="";
           $data["latitude"] =""; 
           $data["longitude"]="";
          }

          $data["status"]=1;
          $data["activestatus"]=$activeall;
          $data["expirydate"]=$expirydate;
          $data["isCameraAllowed"]= $cameraAllowed;
          echo json_encode($data);
          break;

    case 'loftupdate':
     $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
     $latitude   = $_POST["latitude"];
     $longitude  = $_POST["longitude"];
     $apptype    = $_POST["apptype"];
     $deviceide  = $_POST["deivce_id"];
     $phone_no   = $_POST["phone_no"];
     //print_r($_FILES);print_r($_POST);die;
               $path = "uploads/"; // Upload directory
               $count = 0;
               $loftprefix = $apptype."_".$phone_no."_".time();
               if ($_FILES['files']['error'] != 4) 
                   { // No error found! Move uploaded files 
                       $timeval = time();
                       $path_parts = pathinfo($_FILES["files"]["name"]);
                       $extension = $path_parts['extension'];
                       
                       $fancierinfo = mysqli_query($dbconnection,"select loft_image from ppa_register where apptype='".$apptype."' and phone_no='".$phone_no."' limit 0,1");
                       $fancierlist = mysqli_fetch_array($fancierinfo);
                       $loft_image  = "uploads/".$fancierlist["loft_image"];
                       
                       if(file_exists($loft_image))
                        @unlink($loft_image);

                       if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$loftprefix.$path_parts['basename']))
                            {
                              $filespath = $loftprefix.$path_parts['basename'];
                              $data["status"]=1;
                              $data["activestatus"]=$activeall;
                              $data["expirydate"]=$expirydate;
                              $update_qry = mysqli_query($dbconnection,"update ppa_register set latitude='".$latitude."',longitude='".$longitude."',loft_image='".$filespath."' where apptype='".$apptype."' and phone_no='".$phone_no."'");
                             // $filename = $path.$filespath;
                             // $imgData = resize_image($filename, 2000,2000,100); // 11327814
                             // imagejpeg($imgData, $filename);
                            }
                            else
                            {
                              $data["status"]=0;
                              $data["activestatus"]=$activeall;
                              $data["expirydate"]=$expirydate;
                              $data["isCameraAllowed"]= $cameraAllowed;
                            }
                   }
                   else
                   {
                    $data["status"]=0;
                    $data["activestatus"]=$activeall;
                    $data["expirydate"]=$expirydate;
                    $data["isCameraAllowed"]= $cameraAllowed;
                   }
        
     
     echo json_encode($data);
    break;

    case 'fileupload':
         $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }
               date_default_timezone_set("Asia/Kolkata");
               $update_date = date("Y-m-d H:i:s");
               $path = "uploads/"; // Upload directory
               $count = 0;
               $phone_no   = $_POST["phone_no"];
               $username   = $_POST["username"];
               $apptype    = $_POST["apptype"];
               $latitude = "";
               $longitude = "";
               
               $currdate = date('Y-m-d');
               $date = new DateTime($currdate); // For today/now, don't pass an arg.
               $date->modify("-3 day");
               $fromdate = $date->format("Y-m-d");
               $date2 = new DateTime($currdate);
               $date2->modify("+3 day");
               $todate = $date2->format("Y-m-d");   

               $raceinfo   = mysqli_query($dbconnection,"SELECT a.event_id,a.bird_id FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id = b.Events_id LEFT JOIN users as c on c.users_id = b.Org_id where c.Org_code='".$apptype."' and a.date >= '".$fromdate."' and a.date <= '".$todate."' order by a.event_id DESC limit 0,1");
               $sel_curr_raceinfo    = mysqli_fetch_array($raceinfo);
               $raceide  = $sel_curr_raceinfo["event_id"];
               $bird_id = $sel_curr_raceinfo["bird_id"];


                    if ($_FILES['files']['error'] != 4) 
                    { // No error found! Move uploaded files 
                       $timeval = time();
                       $path_parts = pathinfo($_FILES["files"]["name"]);
                       $extension = $path_parts['extension'];
                       if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$path_parts['basename']))
                            {
                              
                              // SELECT * FROM ppa_event_details as a LEFT JOIN ppa_events as b ON b.Events_id=a.event_id LEFT JOIN ppa_oraganization as c ON c.Org_id=b.Org_id where c.Org_code='PPA'
                              $filespath = $path_parts['basename'];
                              $data["status"]=1;
                              $data["activestatus"]=$activeall;
                              $data["expirydate"]= $expirydate;
                              $data["isCameraAllowed"]= $cameraAllowed;
                              $latitude   = $_POST["latitude"];
                              $longitude    = $_POST["longitude"];
                              if(isset($_POST["interval"]))
                              {
                                $interval = $_POST["interval"];
                                $dt = new DateTime();
                                $dt->setTimestamp($interval/1000);
                                $timezone = "Asia/Kolkata";
                                $dt->setTimezone(new DateTimeZone($timezone)); 
                                $update_date = $dt->format("Y-m-d H:i:s");

                              }
                              else
                                $interval = "";
                             // $deviceide  = $_POST["deivce_id"];
                              if(isset($_POST["phone_no"]))
                              $phone_no   = $_POST["phone_no"];
                              else
                               $phone_no = '';
                              $insert_qry = mysqli_query($dbconnection,"insert ppa_files set event_id='".$raceide."',bird_type='".$bird_id."',temp_event_id='".$raceide."',latitude='".$latitude."',longitude='".$longitude."',club_code='".$apptype."',filename='".$filespath."',time_interval='".$interval."',mobile='".$phone_no."',username='".$username."',cre_date='".$update_date."'");

                              sendnotification($dbconnection,$apptype,$phone_no,$username);
                            }
                            else
                            {
                              $data["status"]=0;
                              $data["activestatus"]=$activeall;
                              $data["expirydate"]=$expirydate;
                              $data["isCameraAllowed"]= $cameraAllowed;
                            }
                   }
                   else
                   {
                    $data["status"]=0;
                    $data["activestatus"]=$activeall;
                    $data["expirydate"]=$expirydate;
                    $data["isCameraAllowed"]= $cameraAllowed;
                   }
        
     
     echo json_encode($data);
    break;
    case 'ppaexpiry':
     $authuser = checkauth($dbconnection,$secureusertoken);
          if($authuser=="0" || $authuser=="")
          {
            $data["status"]=404;
            $data["msg"]="Authentication failed";
            echo json_encode($data);
            break;
          }

     $apptype = $postdetails["apptype"];
     $code = $postdetails["code"];
     $deviceide = $postdetails["deivce_id"];
     $phone_no   = $postdetails["phone_no"];
     $fcm_id   = $postdetails["fcm_id"];
     $selectuserstatus = mysqli_query($dbconnection,"select * from ppa_register where phone_no='".$phone_no."' and apptype='".$apptype."'");
     // get org contact number
    $orgcont_details = mysqli_query($dbconnection,"select * from users where Org_code='".$apptype."'");
    $orgcontactdet = mysqli_fetch_array($orgcont_details);
    $phone_num = "8015512308";//$orgcontactdet["phone_no"];
    $data["Orgphone_no"]  = $phone_num;
    //
     if(mysqli_num_rows($selectuserstatus)>0) {
      $accdetails = mysqli_fetch_array($selectuserstatus);
      $data["accountstatus"]= $accdetails["status"];
      $data["loftstatus"]= $accdetails["loftstatus"];
      $data["latitude"]= $accdetails["latitude"];
      $data["longitude"]= $accdetails["longitude"];
      $data["reg_id"]= $accdetails["reg_id"];
      $updatefcm_det = mysqli_query($dbconnection,"update ppa_register set android_id='".$fcm_id."' where reg_id='".$accdetails["reg_id"]."'");

      $data["loft_image"]= $SITEMAINURL."uploads/".$accdetails["loft_image"];
     }
     else
     {
      $data["accountstatus"]= 0;
      $data["loftstatus"]= 0;
      $data["latitude"]= "";
      $data["longitude"]= "";
      $data["loft_image"]= "";
     }
     $data["isCameraAllowed"]= $cameraAllowed;

     
     $data["status"]=1;
     $data["activestatus"]=$activeall;
     $data["expirydate"]=$expirydate;
     echo json_encode($data);
    break;
    default:	
		header("HTTP/1.1 200 OK");
		die;	
		break;	
   }


   function resize_image($file, $w, $h, $crop=false) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    
    //Get file extension
    $exploding = explode(".",$file);
    $ext = end($exploding);
    
    switch($ext){
        case "png":
            $src = imagecreatefrompng($file);
        break;
        case "jpeg":
        case "jpg":
            $src = imagecreatefromjpeg($file);
        break;
        case "gif":
            $src = imagecreatefromgif($file);
        break;
        default:
            $src = imagecreatefromjpeg($file);
        break;
    }
    
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}
   
   function checkauth($dbconnection,$token)
   {
      
      $checkuserauth = mysqli_query($dbconnection,"select * from ppa_register where userToken='".$token."'");
      if(mysqli_num_rows($checkuserauth)>0)
       {
        $authusertoken = mysqli_fetch_array($checkuserauth);
        $checkuser = $authusertoken["userToken"];
       }
       else
       $checkuser = 0;
       return $checkuser;
   }
   function sendnotification($dbconnection,$apptype,$phone_no,$username)
   {
       $selectfanciers = mysqli_query($dbconnection,"select * from ppa_register where phone_no!='".$phone_no."' and apptype='".$apptype."'");
       //$selectfanciers = mysqli_query($dbconnection,"select * from ppa_register where apptype='".$apptype."'");
       if(mysqli_num_rows($selectfanciers)>0) {
          
          while($fancierinfo = mysqli_fetch_array($selectfanciers))
           {
              $android_deviceide = $fancierinfo["android_id"];
              $message='{"ResponseCode":"100","UserName":"'.$username.'","phone_no":"'.$phone_no.'","Apptype":"'.$apptype.'","Title":"Photo Taken","Message":"Fancier Mr.'.$username.'. taken the piegion snap :) check out his shots"}';
              $pushparameter="";
              $badge=1;
              sendAnroidPushNotification($dbconnection,$message,$android_deviceide,$pushparameter,$badge,$apptype);
           }

       }
   }

   function sendAnroidPushNotification($dbconnection,$message="",$deviceToken="",$pushparameter="",$badge=1,$apptype)
   {
            if($apptype=="PPA")
              $pushkey = "AIzaSyBd1d-aGtwwbG-QUWd67PIiUZtnI-aKVow";
            else if($apptype=="PRPA")
              $pushkey = "AIzaSyCeWZOqG71bbn8cuhe1Xm_P-Bgxe99slU0";
            else if($apptype=="PHPA")
              $pushkey = "AIzaSyAvOdBc7pEDoeUEV-Hp4InswFz4B-r5Di4";
            else if($apptype=="NRPA")
              $pushkey = "AIzaSyCkjkosA931Qy-2zsXCE4OUhDjZNWCbM0g";
            else if($apptype=="KRPS")
              $pushkey = "AIzaSyBseqyBpWjuODiBrOtptcj-8H31kFME7yg";
            else if($apptype=="GHPA")
              $pushkey = "AIzaSyCcbqJ4TXm13fvM5AT-WO_hwIaEuP75ZDE";
            else if($apptype=="PPAS")
              $pushkey = "AIzaSyCOXLHuzrNg7z2Ct4N7K5Z93jDOUTDu-U8";
            else if($apptype=="AMHC")
              $pushkey = "AIzaSyCuBA2dk4Obop7y3Wbu6w-EJkaR7TWTvwI";

            else if($apptype=="GPRS")
              $pushkey = "AIzaSyBzFtKHwmvQE-6Qbz1vX0Uzyi-Ubmlk2_8";
            else if($apptype=="INDI")
              $pushkey = "AIzaSyCZiIDyB54zSxZmhC-3ncykuYV1S9f1yQo";
            else if($apptype=="MHPC")
              $pushkey = "AIzaSyCCHFeb3S_OA4yBkYnbltJhKDlbbFGNnGM";
            else if($apptype=="THPA")
              $pushkey = "AIzaSyB1wotNytbJ6JQa3eTT5LNlgH6eMJ7n4Y0";
            else if($apptype=="TRPC")
              $pushkey = "AIzaSyBv-r4Sm8K1zomINTiwQvlIoVcjUwj683g";
            else if($apptype=="KRLR")
              $pushkey = "AIzaSyCJTTZDjUUiJeBgh6KTCDR8dpmRHr-ZR4c";
            else if($apptype=="KHPA")
              $pushkey = "AIzaSyCmS5kZqIpQFlbec6A1ADtppZOdKMS4V7M";
            else if($apptype=="RPC")
              $pushkey = "AIzaSyAeW2k1cgM_1a096t28TNW8Ybi7Rf9GV0U";
            else if($apptype=="KRPC")
              $pushkey = "AIzaSyDEu9nqVoWZkbymTrPYKv4pNxubRHs56z0";
            else if($apptype=="MRPA")
              $pushkey = "AIzaSyDZ1mX41QnAbOtY4WZDtdh5AvYDfNZG-Zw";
            else if($apptype=="CRPA")
              $pushkey = "AIzaSyBL4fyz3-w4SvuJzWBUv0p9UwVxcCmyt7E";
            else if($apptype=="PRPS")
              $pushkey = "AIzaSyCMauHRArwt-rr5mYuV7DNx2xw3UToMnMI";
            else if($apptype=="SRPC")
              $pushkey = "AIzaSyAv2yh9vMpmijjPD6AzMinM57fNNJjhbnc";
            else if($apptype=="KRPS2")
              $pushkey = "AIzaSyAbAtI3n_vV8TIZjQhvk5Pn8VlXnwLGZd4";
            else if($apptype=="TRHPA")
              $pushkey = "AIzaSyDZ1mX41QnAbOtY4WZDtdh5AvYDfNZG-Zw";
            else if($apptype=="AMHPC")
              $pushkey = "AIzaSyCBpX_duPPBreOr0QQA0c3h6aN1qSSISNI";
            else if($apptype=="GPRS")
              $pushkey = "AIzaSyBzFtKHwmvQE-6Qbz1vX0Uzyi-Ubmlk2_8";
            else if($apptype=="CRPA")
              $pushkey = "AIzaSyBzFtKHwmvQE-6Qbz1vX0Uzyi-Ubmlk2_8";
            else if($apptype=="KGF")
              $pushkey = "AIzaSyDVJC54wJkEzZ4hu8fhNE1eYF3SUKZwrW4";
            else if($apptype=="HHPA")
              $pushkey = "AIzaSyAeMo0UQU4ivREntYm9J0LAC5w5EkP3Orw";
            else if($apptype=="KRPF")
              $pushkey = "AIzaSyBmSssqFWvvAP8xV5aVby8gkxVYg7KPm6U";
            else if($apptype=="PUPA")
              $pushkey = "AIzaSyCt7QnJic5Kiady8gSHN65OnDhOqT2tWB8";
            else if($apptype=="ELPRS")
              $pushkey = "AIzaSyDSmpxVG8N2lvY7aZaSznIBsD3F9k";
            else if($apptype=="BRPS")
              $pushkey = "AIzaSyCBBw3HtwH57pkGzvSCZRAQrMPXY2RrWiI";
            else if($apptype=="ARPA")
              $pushkey = "AIzaSyCYyg_cpfcibEbMRlHdFR0aE-DpJXlqqyk";
            else if($apptype=="BRPA")
              $pushkey = "AIzaSyC4odxCydTz7vJTPOMPURMeILBALp7W0CQ";
            else if($apptype=="NGTHPA")
              $pushkey = "AIzaSyB9A7hyLbAl1mrtq2JNWDX3vgpTPwmVrAs";
            else if($apptype=="SBS")
              $pushkey = "AIzaSyChbdNbwyUc6q-Nxx4bus5R6nAM3dkvFYQ";
            else if($apptype=="THPS")
              $pushkey = "AIzaSyCOJ11GNwl3XVETlAsRZZtzHJtXOAblgAk";
            else if($apptype=="THRPC")
              $pushkey = "AIzaSyBaMQlYV4Gmh_4oe88A-JUxwEXaL4x2IY0";
            else if($apptype=="DRPS")
              $pushkey = "AIzaSyA2R-bwZQ2_yPz2Ans6GX0rdz6giMW6esI";
            else if($apptype=="KARPS")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="BDS")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="MHPS")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="CRPS")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="AIR")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="PCRPC")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="CHPFA")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="TRRPC")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="CRHPA")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="MRPC")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="NRPC")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else if($apptype=="CERPA")
              $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
            else
              $pushkey = "AIzaSyDUWKKRdi3Bu2o2mKzuog7SR1pHbz7QHQ4";


            
            
            define( 'API_ACCESS_KEY', $pushkey );
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
             $logquery ="insert notificationlog set status ='".$result."',deviceid ='".$deviceToken."',deviceType='Android',message='".addslashes($message)."'";
      mysqli_query($dbconnection,$logquery);
            #Echo Result Of FireBase Server
            return $result;
   }

   function sendandroidnotification($dbconnection,$id,$message)
   {
         
          #API access key from Google API's Console
          define( 'API_ACCESS_KEY', 'YOUR-SERVER-API-ACCESS-KEY-GOES-HERE' );
          $registrationIds = $id;
          #prep the bundle
           $msg = array
                (
          'body'  => 'Body  Of Notification',
          'title' => 'Title Of Notification',
                    'icon'  => 'myicon',/*Default Icon*/
                      'sound' => 'mySound'/*Default sound*/
                );
        $fields = array
            (
              'to'    => $registrationIds,
              'notification'  => $msg
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
      #Echo Result Of FireBase Server
      echo $result;

   }
  

  function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
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

//select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,a.date,a.end_time,TIMESTAMP(a.date, STR_TO_DATE(a.start_time, '%h:%i %p')) as stimes,TIMESTAMP(a.date, STR_TO_DATE(a.end_time, '%h:%i %p')) as etimes FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id where c.Org_code='PPA' and ('2018-09-09 13:00:00' BETWEEN TIMESTAMP(a.date, STR_TO_DATE(a.start_time, '%h:%i %p')) and TIMESTAMP(a.date, STR_TO_DATE(a.end_time, '%h:%i %p'))) and b.result_publish='0' group by a.race_distance order by etimes DESC



?>
