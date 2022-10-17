<?php   
error_reporting(0);
ini_set('display_errors', 0);
mysql_connect('104.236.218.51','tripbaydb','Windows123');
//mysql_connect('192.168.0.51','phpserver','SmartWork');
mysql_select_db('spotlight');

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


$select_photos = mysql_query("select * from ppa_files");
while($photos_result = mysql_fetch_array($select_photos))
{
  $filenames[] = $photos_result["filename"];
}

$select_lats = mysql_query("select * from ppa_register");
while($lat_result = mysql_fetch_array($select_lats))
{
  $latlonginfo[$lat_result["phone_no"]][0] = $lat_result["latitude"];
  $latlonginfo[$lat_result["phone_no"]][1] = $lat_result["longitude"];
}
//print_r($latlonginfo);
if(isset($_POST["calc"]))
{
   //   print_r($_POST);

     function distancecalc($lat1, $lon1, $lat2, $lon2, $unit) {

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
   $caldistance = distancecalc($_POST["lat1"],$_POST["lon1"],$_POST["lat2"],$_POST["lon2"],"K");
     echo " Distance : ".number_format($caldistance,2)." Km";
}
else if(isset($_POST["save"]))
{
   $update = mysql_query("update ppa_register set latitude='".$_POST["lat"]."',longitude='".$_POST["long"]."' where phone_no='".$_POST["phone_no"]."'");
   echo "updated";
}
else
{
//print_r($_POST);
//amc, mhc,indp,ppa
    $clubtype = 'PPA';

    if($_POST["clubtype"]==1)
      $clubtype = 'PPA';
    else if($_POST["clubtype"]==2)
      $clubtype = 'amhc';
    else if($_POST["clubtype"]==3)
      $clubtype = 'mhpc';
    else if($_POST["clubtype"]==4)
      $clubtype = 'indp';
    else if($_POST["clubtype"]==5)
      $clubtype = 'gprs';
    else if($_POST["clubtype"]==6)
      $clubtype = 'trpc';
    else if($_POST["clubtype"]==7)
      $clubtype = 'thpa';
    else 
      $clubtype = 'PPA';



        $ch = curl_init();
        //$selecteddate = '2017-12-28';
        $selecteddate = $_POST["values"];

        $headers = array("Authorization: Basic " . base64_encode('69c7a42185701fb8077d724bb85c909b'));
		
		curl_setopt($ch, CURLOPT_URL, 'https://data.mixpanel.com/api/2.0/export/?from_date='.$selecteddate.'&to_date='.$selecteddate.'&event=%5B%22new_photo%22%5D');

		//curl_setopt($ch, CURLOPT_URL, 'https://mixpanel.com/api/2.0/engage/?api_key=d96f76e71346c0edb0a1b094aa57ba0d&expire=1514419200');

		//curl_setopt($ch, CURLOPT_URL, 'https://mixpanel.com/api/2.0/segmentation/?event=new_photo&from_date=2017-12-25&to_date=2017-12-27&api_key=d96f76e71346c0edb0a1b094aa57ba0d&api_secret=69c7a42185701fb8077d724bb85c909b&expire=1514419200&addiction_unit=hour');

		//curl_setopt($ch, CURLOPT_URL, 'https://mixpanel.com/api/2.0/events?event=new_photo&from_date=2012-12-25&to_date=2012-12-25&type=unique&unit=day&interval=20&limit=20');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


		$result = curl_exec($ch);
		if(curl_error($ch))
		{
			//echo 'error:' . curl_error($ch);
			//die('-1');
			//return -1;
		}

		curl_close($ch);
		//$result = json_decode($result);
		//print_r($result);
		//echo $result[0];
		
		//$myArray = json_decode($myArray, true);
		//echo "<pre>";
		//print_r($result);
	
	    $result = str_replace("}}","}},", $result);
	    $result = "[".substr($result,0,strlen($result)-1)."]";
	   // print_r($result);
		
		$myArray = json_decode($result, true);
		$brand = '$brand';
		$city = '$city';
		$model = '$model';
        $data['city'] = array();
		//print_r($myArray[0]);
    $post_date = $_POST["values"]." ".trim($_POST["times"]);
    $filterstart = strtotime($_POST["values"]." ".trim($_POST["timestart"]));
    $filterend   = strtotime($_POST["values"]." ".trim($_POST["timeend"]));

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
  
       $timestamp = ($myArray[$i]["properties"]["interval"]/1000);
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
 
         if($latlonginfo[$myArray[$i]["properties"]["phone_no"]][0])
               $latitudeinfo = $latlonginfo[$myArray[$i]["properties"]["phone_no"]][0];
         else
               $latitudeinfo = $myArray[$i]["properties"]["longitude"];

         if($latlonginfo[$myArray[$i]["properties"]["phone_no"]][1])
               $longitudeinfo = $latlonginfo[$myArray[$i]["properties"]["phone_no"]][1];
         else
               $longitudeinfo = $myArray[$i]["properties"]["latitude"];


         $distance = distance($_POST["lat"],$_POST["lon"],$latitudeinfo,$longitudeinfo,"K");
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
      $data["velocity1"][] = $velocity1;
    }

    // sorting end

  //die;  
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
 
      // new fields to add

        if(isset($myArray[$i]["properties"]["velocity"]))
        $data["velocity"][] = $myArray[$i]["properties"]["velocity"];
        else
          $data["velocity"][] = '';

        if(isset($myArray[$i]["properties"]["distance"]))
        $data["distance"][] = $myArray[$i]["properties"]["distance"];
        else
        $data["distance"][] = '';

      // new fields to add

		    if(isset($myArray[$i]["properties"][$brand]))
		    $data["brand"][] = 	$myArray[$i]["properties"][$brand];
		    else
            $data["brand"][] = 	'';

            if(isset($myArray[$i]["properties"][$model]))
		    $data["model"][] = 	$myArray[$i]["properties"][$model];
		    else
           $data["model"][] = 	'';
            
            if(isset($myArray[$i]["properties"][$city]))
		    $data["city"][] = 	$myArray[$i]["properties"][$city];
		    else
            $data["city"][] = 	'';


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
		    $data["os"][] = 	$myArray[$i]["properties"]["mp_lib"];
		    else
            $data["os"][] = 	'';
          $currentcount++;
        }

		     // $data["model"][] = 	$myArray[$i]["properties"][$model];
		   // $data["os"][] = 	$myArray[$i]["properties"]["mp_lib"];
		 }
   //  echo "<pre>";
		// print_r($data["velocity"]);
//echo "</pre>";
	    
//die;  
$totalrecords = $currentcount;    
?>
<style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    
}
.disp
{
 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
 color:#50AEAF; 
 font-size:16px; 
 font-weight: bold;
}
.pageno
{
 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
 color:#FFFFFF;
 background-color:#50AEAF;
 padding:2px;
 font-size:13px; 
 width:20px;
 height:20px;
 text-align:center;
 font-weight: bold;
}
.curpageno
{
 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
 color:#50AEAF;
 border:1px solid #50AEAF;
 background-color:#ffffff;
 padding:2px;
 font-size:13px; 
 width:20px;
 height:20px;
 text-align:center;
 font-weight: bold;
}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #50AEAF;
    color: white;
}
</style>
<table border="0" cellspacing="0" cellspacing="0" width="100%">
   <tr>
      <td align="center">
          <table border="0" cellspacing="4" cellspacing="4" width="90%">
            <tr>
              <td align="left" colspan="8" class="disp">
               Total Entry : <?php echo $totalrecords;?>
             </td>
             <td align="right" colspan="8" class="disp">
               <input type="button" value="Export" id="exportreport">
             </td>
            </tr>
          </table>
      </td>
   </tr>
   <tr>
      <td align="center">
         <table id="customers" border="0" cellspacing="0" cellspacing="0" width="90%">
  <tr>
    <th>S.No</th><th>Name</th><th>Phone Number</th><th>Time</th><th>Distance (km)</th><th>Velocity<br>meter per minute</th><th>Latitude</th><th>Longitude</th><th></th><!--<th>Brand</th><th>City</th><th>Interval</th>--><th>isValid</th><th>File</th><th>File Name</th><th>Device ID</th>
  </tr>
  <?php 

     


     if($totalrecords>0) {  
    // $_POST["page"] = 0;
     //$limit = 10;
      $limit = $totalrecords;
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
     $numpages = $totalrecords/$limit;
     $quo      = $totalrecords%$limit;
     if($quo>0)
      $numpages++;

     }
    //echo $start.$end;
    // for ($t=$start;$t<$end;$t++) {
     for ($t=0;$t<count($data["name"]);$t++) {

     $timestamp = ($data["interval"][$t]/1000);
     $timezone = "Asia/Kolkata";
     $dt = new DateTime();
     $dt->setTimestamp($timestamp);
     $dt->setTimezone(new DateTimeZone($timezone));
     //$datetime = $dt->format('Y-m-d h:i:s A (l)');
     $datetime = $dt->format('h:i:s A');
     $fulltime = $dt->format('Y-m-d h:i:s A');
     //$_POST["times"] = str_replace('AM','',$_POST["times"]);
     //$_POST["times"] = str_replace('PM','',$_POST["times"]);

        //$starttime = strtotime($_POST["values"]." ".trim($_POST["times"]));
        //echo $starttime;
        $post_date = $_POST["values"]." ".trim($_POST["times"]);
        //echo date("Y-m-d H:i:s", strtotime(stripslashes($fulltime)))." - ".date("Y-m-d H:i:s", strtotime(stripslashes($post_date)))." - ".$_POST["values"]." ".trim($_POST["times"])."<br>";
     // Velocity calculation
   
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



         $distance = distance($_POST["lat"],$_POST["lon"],$latitudeinfo,$longitudeinfo,"K");
         $velocity = ($distance*1000)/$calculationhour;
       }
       if(trim($_POST["times"])== '' || trim($_POST["lat"])=='' || trim($_POST["lon"])=='')
       {
         $velocity = 0;
       }

     //
     if (in_array($data["name"][$t], $filenames))
       $bgcolor = 'style="color:green;font-weight:bold;"';
     else
       $bgcolor = '';
     ?>
   <tr <?php echo $bgcolor;?>>
      <td><?php echo $t+1;?></td>
      <td><?php echo $data["username"][$t]?></td>
      <td><?php echo $data["phone_no"][$t]?></td>    
      <td><?php echo $datetime;?></td>
      <!-- Field to add -->
      <td><?php echo number_format($data["distance"][$t],2)."";?></td>
      <td><?php echo number_format($data["velocity"][$t],2)."";?></td>
      <!-- Field to add -->
      <td>
       <?php if($latlonginfo[$data["phone_no"][$t]][0])
               $latitudeinfo = $latlonginfo[$data["phone_no"][$t]][0];
             else
               $latitudeinfo = $data["latitude"][$t];

             if($latlonginfo[$data["phone_no"][$t]][1])
               $longitudeinfo = $latlonginfo[$data["phone_no"][$t]][1];
             else
               $longitudeinfo = $data["longitude"][$t];
       ?>
       <input type="text" style="width:150px;" name="lati<?php echo $t+1;?>" id="lati<?php echo $t+1;?>" value="<?php echo $latitudeinfo?>"></td>
      <td><input type="text" style="width:150px;" name="longi<?php echo $t+1;?>" id="longi<?php echo $t+1;?>" value="<?php echo $longitudeinfo?>"></td>
      <td><input type="button" value="update" onclick="savelatlong('<?php echo $data["phone_no"][$t]?>','<?php echo $t+1;?>');"></td>
      <!--<td><?php echo $data["brand"][$t]." - ".$data["model"][$t]?></td>
      <td><?php echo $data["city"][$t]?></td>
      <td><?php echo $data["interval"][$t]?></td>-->
      <td><?php if($data["isValid"][$t]==1) echo "True"; else echo "False";?></td>
      <?php
       $filename = "http://104.236.218.51/ppa/uploads/".$data["name"][$t];
       if (@getimagesize($filename)) { ?>  
      <td><img height="80" width="60" src="uploads/<?php echo $data["name"][$t]?>"></td>
      <?php } else {  ?>
      <td>No image</td>
      <?php } ?>
      <td><?php echo $data["name"][$t]?></td>
      <td><?php echo $data["deivce_id"][$t]?></td>
      
   </tr>
  <?php } } else { ?>
   <tr>
      <td colspan="13" align="center" style="color:red;">No Records Available for the selected date.. choose  other date.</td>
   </tr>
  <?php } ?>
</table>
      </td>
   </tr>
   <tr>
     <td align="center" colspan="13">
         <table border="0" cellspacing="4" cellspacing="4">
          <tr>
            <?php for($t=1;$t<=$numpages;$t++) { ?>
              <td onclick="paging(<?php echo $t-1;?>)">
                 <div <?php if($page==$t) echo 'class="curpageno"'; else echo 'class="pageno"';?> id="pagenum" onclick="paging(<?php echo $t-1;?>);" style="cursor:pointer;"><?php echo $t;?></div>
                </td>
            <?php } ?>
          </tr>
         </table>
     </td>
   </tr>
</table>
<script>
$(function() {
        $("#exportreport").click(function(){
       $("#customers").table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "<?php echo $clubtype."_report_".$selecteddate?>",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        }); 
         });
      });
</script>
<?php } 


unset($myArray);
unset($data["interval"]);
unset($data["date"]);
unset($data["properties"]);
unset($data["date"]);
unset($data["brand"]);
unset($data["model"]);
unset($data["city"]);
unset($data["isValid"]);
unset($data["deivce_id"]);
unset($data["phone_no"]);
unset($data["longitude"]);
unset($data["latitude"]);
unset($data["username"]);
unset($data["name"]);
unset($data["isValid"]);

?>