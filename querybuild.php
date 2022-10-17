<?PHP
include "siteinfo.php";
$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);

$selectorg_details = mysqli_query($dbconnection,"select * from system_logs where entry_date >= 2021-02-14 and description like '%Response Data Event Id : 326%' ORDER BY `ide` DESC");

while($res = mysqli_fetch_array($selectorg_details))
         {
           $user_id   = $res["user_id"];
           $desc = $res["description"];
           $descinfo = explode(":", $desc);
           $raceidinfo = explode(" ", $descinfo[1]);
           $event_id = trim($raceidinfo[1]);
           $bird_type_info = explode(" ", $descinfo[2]);
           $bird_type = trim($bird_type_info[1]);
           $file_info = explode(" ", $descinfo[10]);
           $file_name = trim($file_info[0]);
           $fileexpolde = explode(" ",$descinfo[4]);
           $filename = trim($fileexpolde[0]);
           $timeInterval = explode("_",$filename);
           $getTimeInterval = explode(".", $timeInterval[2]);
           
           $event_details = mysqli_query($dbconnection,"SELECT *  FROM ppa_event_details WHERE event_id = '".$event_id."' AND bird_id = '".$bird_type."' ORDER BY ed_id DESC");
           $event_details_res  = mysqli_fetch_array($event_details);
           $event_temp_id  = $event_details_res["ed_id"];
           
           $secondsinfo = explode(" ", $descinfo[7]);
           $trap_time  = trim($descinfo[5].":".$descinfo[6].":".$secondsinfo[0]);
           
           $interval_info = explode(".", $file_name);
           $interval = explode("_", $interval_info[0]);
           $timeinterval = trim($interval[2]);

           $distanceinfo = explode(" ", $descinfo[11]);
           $distance = trim($distanceinfo[0]);
           $velocityinfo = explode(" ", $descinfo[12]);
           $velocity = trim($velocityinfo[0]);
           //echo "<pre>";
           //print_r($distance." - ".$velocity);
           $user_details = mysqli_query($dbconnection,"select * from ppa_register where reg_id='".$user_id."'");
           $user_details_res  = mysqli_fetch_array($user_details);

          

           $apptype  = $user_details_res["apptype"];
           $latitude  = $user_details_res["latitude"];
           $longitude  = $user_details_res["longitude"];
           $phone_no  = $user_details_res["phone_no"];
           $username  = $user_details_res["username"];
           
           
           $query = "INSERT INTO `ppa_files` (`ide`, `device_id`, `club_code`, `event_id`, `temp_event_id`, `bird_type`, `username`, `mobile`, `filename`, `time_interval`, `latitude`, `longitude`, `distance`, `velocity`, `inner_ring_no`, `outer_ring_no`, `bird_color`, `bird_gender`, `owner_ringno`, `timetaken`, `cre_date`, `deleted`, `image_status`, `tag_device_id`) VALUES (NULL, '123', '".$apptype."', '".$event_id."', '".$event_temp_id."', '".$bird_type."', '".$username."', '".$phone_no."', '".$filename."', '".$getTimeInterval[0]."', '".$latitude."', '".$longitude."', '".$distance."', '".$velocity."', NULL, NULL, NULL, NULL, NULL, NULL, '".$trap_time."', '0', '0', NULL);";

           echo  $query."<br><br>";
         }
/*
Response Data Event ID : 332  Bird Id : 128  Current Date :2021-02-14 filename : Traptime :2021-02-14 05:41:35 PM Phone Number :9003224598  Apptype :CHPFA  Chiptimestamp :fname_LespotOn871_1613304695000.chip  Total Distance :95.96105474585 Km  velocity:189.4279745  categoryName:Open  categoryId:128  Gender:Male  ring_no:CHPFA4601  Color:Blue  Race Name:Training Toss Naidupeta

 $event_details = mysqli_query($dbconnection,"SELECT *  FROM ppa_event_details WHERE event_id = '".$event_id."' AND bird_id = '".$bird_type."' ORDER BY ed_id DESC");
           $event_details_res  = mysqli_fetch_array($event_details);

INSERT INTO `ppa_files` (`ide`, `device_id`, `club_code`, `event_id`, `temp_event_id`, `bird_type`, `username`, `mobile`, `filename`, `time_interval`, `latitude`, `longitude`, `distance`, `velocity`, `inner_ring_no`, `outer_ring_no`, `bird_color`, `bird_gender`, `owner_ringno`, `timetaken`, `cre_date`, `deleted`, `image_status`, `tag_device_id`) VALUES (NULL, '123', 'KRPC', '306', '506', '69', 'Suresh', '8660328514', 'fname_LespotOn696_1613287319000.jpg', '1613287319000', '13.0212907', '77.6444345', '306.65064807463', '1107.1086638', NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-14 12:51:59', '0', '0', NULL);*/

