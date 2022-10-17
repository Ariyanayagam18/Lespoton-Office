<?PHP
include "siteinfo.php";

$eventide = $_REQUEST["ide"];
$racename = $_REQUEST["rname"];
$apptype = $_REQUEST["atype"];
$secureusertoken = $_REQUEST["userToken"];
$authuser = checkauthuser($dbconnection,$secureusertoken);
if($authuser=="0" || $authuser=="")
{
  die("<h1>Not Found</h1> <br> The requested URL  was not found on this server.");
}

$fancier_name = "";
if(isset($_GET["btype"]) && $_GET["btype"]!='')
$firstquery = mysqli_query($dbconnection,"SELECT max(date) as maxi,MIN(date) as mini,start_time as start FROM `ppa_event_details` WHERE event_id='".$eventide."' and bird_id='".$_GET["btype"]."'");
else
$firstquery = mysqli_query($dbconnection,"SELECT max(date) as maxi,MIN(date) as mini,start_time as start FROM `ppa_event_details` WHERE event_id='".$eventide."'");
 $firstres = mysqli_fetch_array($firstquery);
 $maxdate  = $firstres["maxi"]." 23:59:59";
 $mindate  = $firstres["mini"]." 00:00:00";

$racestartdate = $firstres["mini"];
$starttime     = $firstres["start"];
$limit = 50;
$adjacents = 2;


$sql = mysqli_query($dbconnection,"SELECT a.ide,a.username,a.filename,a.latitude,a.longitude,c.Event_lat,c.Event_long,d.latitude as loftlat,d.longitude as loftlong FROM ppa_files as a LEFT JOIN users as b on a.club_code=b.Org_code LEFT JOIN ppa_events as c on b.users_id=c.Org_id LEFT JOIN ppa_register as d on d.apptype=a.club_code and a.mobile=d.phone_no WHERE a.cre_date>='".$mindate."' and a.cre_date<='".$maxdate."' and club_code='".$apptype."'  and c.Events_id='".$eventide."' and a.filename not like '%liberation%'") ;

$total_rows = mysqli_num_rows($sql);
      $total_pages = ceil($total_rows / $limit);
      if(isset($_GET['page']) && $_GET['page'] != "") {
          $page = $_GET['page'];
          $offset = $limit * ($page-1);
        } else {
          $page = 1;
          $offset = 0;
        }

$query = mysqli_query($dbconnection,"SELECT a.ide,a.velocity,ADDTIME(FROM_UNIXTIME(a.time_interval/1000,'%Y-%m-%d %H:%i:%s'), '11:30') as istpick,FROM_UNIXTIME(a.time_interval/1000,'%Y-%m-%d %H:%i:%s') as pick,TIMESTAMPDIFF(MINUTE,TIMESTAMP(event_det.date,event_det.end_time),ADDTIME(FROM_UNIXTIME(a.time_interval/1000,'%Y-%m-%d %H:%i:%s'), '11:30')) as df,(1000*1.609344 * 60 * 1.1515 * degrees(acos(sin(radians(c.Event_lat)) * sin(radians(d.latitude)) + cos(radians(c.Event_lat)) * cos(radians(d.latitude)) * cos(radians(c.Event_long-d.longitude)))))/(TIMESTAMPDIFF(MINUTE,TIMESTAMP(event_det.date,event_det.end_time),ADDTIME(FROM_UNIXTIME(a.time_interval/1000,'%Y-%m-%d %H:%i:%s'), '11:30'))) as velo,1.609344 * 60 * 1.1515 * degrees(acos(sin(radians(c.Event_lat)) * sin(radians(d.latitude)) +  cos(radians(c.Event_lat)) * cos(radians(d.latitude)) * cos(radians(c.Event_long-d.longitude)))) as dist,a.time_interval,a.owner_ringno,a.mobile,a.ide,a.username,a.filename,a.latitude,a.longitude,c.Event_lat,c.Event_long,d.latitude as loftlat,d.longitude as loftlong FROM ppa_files as a LEFT JOIN users as b on a.club_code=b.Org_code LEFT JOIN ppa_events as c on b.users_id=c.Org_id LEFT JOIN ppa_register as d on d.apptype=a.club_code and a.mobile=d.phone_no LEFT JOIN (
              SELECT  event_id, max(date) as date,start_time as end_time 
              FROM  ppa_event_details
              where event_id = '".$eventide."'
          ) event_det ON (c.Events_id = event_det.event_id)
WHERE a.cre_date>='".$mindate."' and a.cre_date<='".$maxdate."' and club_code='".$apptype."'  and c.Events_id='".$eventide."' and a.filename not like '%liberation%' order by velocity*1 DESC limit ".$offset.",".$limit) ;






if($total_pages <= (1+($adjacents * 2))) {
          $start = 1;
          $end   = $total_pages;
        } else {
          if(($page - $adjacents) > 1) {           //Checking if the current page minus adjacent is greateer than one.
            if(($page + $adjacents) < $total_pages) {  //Checking if current page plus adjacents is less than total pages.
              $start = ($page - $adjacents);         //If true, then we will substract and add adjacent from and to the current page number  
              $end   = ($page + $adjacents);         //to get the range of the page numbers which will be display in the pagination.
            } else {                   //If current page plus adjacents is greater than total pages.
              $start = ($total_pages - (1+($adjacents*2)));  //then the page range will start from total pages minus 1+($adjacents*2)
              $end   = $total_pages;               //and the end will be the last page number that is total pages number.
            }
          } else {                     //If the current page minus adjacent is less than one.
            $start = 1;                                //then start will be start from page number 1
            $end   = (1+($adjacents * 2));             //and end will be the (1+($adjacents * 2)).
          }
}
$raceeventide = $eventide;

$racebirdquery = mysqli_query($dbconnection,"SELECT DISTINCT ppa_bird_type.b_id as birdtype,ppa_bird_type.brid_type,ppa_event_details.race_distance FROM ppa_event_details INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id WHERE ppa_event_details.event_id ='".$raceeventide."'");

?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-control" content="no-cache">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
 <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">

<!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Magnific Popup core JS file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
</head>
<body>

<div class="container-fluid">
<div class="row">
<div class="col-lg-12 title-content"> 
   <div class="row">
     <table border="0" cellpadding="0" cellspacing="0" align="center">
         <tr>
            <td><h1><?php echo $racename;?> Race Photos </h1></td>
         </tr>
         <?php $optionhtml = ''; while ($birdres = mysqli_fetch_array($racebirdquery)) { 

//$getraceinfo = mysqli_query($dbconnection,"SELECT max(date) as maxi,MIN(date) as mini,start_time as start,ed_id FROM `ppa_event_details` WHERE event_id='".$raceeventide."' and bird_id = '".$birdres["b_id"]."' and race_distance='".$birdres["race_distance"]."'");
             // $racedetails = mysqli_fetch_array($getraceinfo);

                               // $autoresults[] = "'".$racedetails[0]["ed_id"]."','".$birdres["race_distance"]."-".$birdres["brid_type"]."','".$racedetails[0]["maxi"]."','".$racedetails[0]["mini"]."','".$racedetails[0]["start"]."','".$birdres["brid_type"]."','".$apptype."','".$fancier_name."'";
               //$optionhtml .= "<option value=\"".$racedetails[0]["ed_id"].",".$birdres["race_distance"]."-".$birdres["brid_type"].",".$racedetails[0]["maxi"].",".$racedetails[0]["mini"].",".$racedetails[0]["start"].",".$birdres["brid_type"].",".$apptype.",".$fancier_name."\">".$birdres["race_distance"]."-".$birdres["brid_type"]."</option>";
               $bird_ide[] = $birdres["birdtype"];
               $selected = "";
               if($birdres["birdtype"]==$_GET["btype"])
               	$selected = "selected";

               $optionhtml .= "<option value=\"".$birdres["birdtype"]."\" ".$selected.">".$birdres["race_distance"]."-".$birdres["brid_type"]."</option>";
         
          } ?>
         <tr><td>Choose Bird type : <select onchange="gotopage(this.value)"><option value="">Select bird type</option><?php echo $optionhtml;?></select></td></tr>
         <tr>
            <td>
          <?php  
           if(isset($_GET["btype"]))
            $pagingurl = "https://www.lespoton.com/portal/liveresult.php?atype=".$apptype."&rname=".$racename."&ide=".$eventide."&userToken=".$secureusertoken."&btype=".$_REQUEST["btype"];
           else
            $pagingurl = "https://www.lespoton.com/portal/liveresult.php?atype=".$apptype."&rname=".$racename."&ide=".$eventide."&userToken=".$secureusertoken;

           if($total_pages > 1) { ?>
          <ul class="pagination pagination-sm justify-content-center">
            <!-- Link of the first page -->
            <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
              <a class='page-link' href='<?php echo $pagingurl;?>&page=1'>&lt;&lt;</a>
            </li>
            <!-- Link of the previous page -->
            <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
              <a class='page-link' href='<?php echo $pagingurl;?>&page=<?php ($page>1 ? print($page-1) : print 1)?>'>&lt;</a>
            </li>
            <!-- Links of the pages with page number -->
            <?php for($i=$start; $i<=$end; $i++) { ?>
            <li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
              <a class='page-link' href='<?php echo $pagingurl;?>&page=<?php echo $i;?>'><?php echo $i;?></a>
            </li>
            <?php } ?>
            <!-- Link of the next page -->
            <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
              <a class='page-link' href='<?php echo $pagingurl;?>&page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'>&gt;</a>
            </li>
            <!-- Link of the last page -->
            <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
              <a class='page-link' href='<?php echo $pagingurl;?>&page=<?php echo $total_pages;?>'>&gt;&gt;</a>
            </li>
          </ul>
        <?php } ?>
            </td>
         </tr>
     </table>
   </div>
    <div class="row">
            <table id="example" class="table table-striped table-bordered nowrap" style="width:90%">  
            <tr> 
              <th>S.no</th> 
              <th>Name</th> 
              <th>Image</th> 
              <th>Mobile no</th> 
              <!--<th>Bird category</th>--> 
              <th>Ring no</th> 
              <th>Date</th> 
              <th>Time</th> 
              <th>Time Taken ( min )</th> 
              <th>Distance (Km)</th> 
              <th>Velocity (Mt/Min)</th> 
              <th>Latitude</th> 
              <th>Longitude</th> 
            </tr>
            <?php  $i=0; $velocityupdate = 0;
              if(mysqli_num_rows($query)>0) {
              while($res = mysqli_fetch_array($query))
              {  
                 if($res["cnt"])
                  $counts = $res["cnt"];
                 else
                  $counts = mysqli_num_rows($query);

                // Start calculation
            $racestartdate = $firstres["mini"];
            $starttime     = $firstres["start"];

            $post_date       = str_replace("'", '',$racestartdate)." ".$starttime;     
            $timeinfo  = explode("_",$res["filename"]);
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
              //die($clickeddate." - ".$starteddate);
              if($clickeddate == $starteddate){
                  $starttime = strtotime($post_date);
                  $clickedtime = strtotime($fulltime);
                  $differenttime = $clickedtime-$starttime;
                  $calculationhour = $differenttime / 60;
              }
              else{   // a.ed_id='".$event_details_id."' AND
                      $calculationhour = 0;
                      if(isset($_REQUEST["btype"]) && $_REQUEST["btype"]!='')
                      $current_bird_id = $_REQUEST["btype"];
                      else
                      $current_bird_id = $bird_ide[0];

                      $chk_date = mysqli_query($dbconnection,"SELECT * FROM ppa_event_details as a LEFT JOIN ppa_bird_type as b on b.b_id=a.bird_id WHERE a.event_id= '".$raceeventide."' AND date<='".$fulldate."' and a.bird_id='".$current_bird_id."' ORDER by a.date ASC");
                     
                      $phour = 0;
                      while($chk_datedatarow = mysqli_fetch_array($chk_date))
                      {
                      $racestartdate = strtotime($chk_datedatarow["date"]);
                      $racestarttime = strtotime($chk_datedatarow["start_time"]);
                      $extimedata = date('h:i:s A', $racestarttime);
                      if($clickeddate == $racestartdate){
                        $full_start_date = $chk_datedatarow["date"].' '.$extimedata;
                        $extime =  strtotime($exfulltime) - strtotime($full_start_date);
                        $init = $extime;
                        //$balancemin = date('i', $extime);
                        $hours = floor($init / 3600);
                        $minutes = floor(($init / 60) % 60);
                        $seconds = $init % 60;
                        $secondstomin = $seconds / 60;
                        $phour =$phour + ($hours * 60) + $minutes+$secondstomin;
                        //echo "IN ".$phour;
                        
                       }else{
                        //echo h2m("1:45");
                        $phour = $phour + h2m($chk_datedatarow->boarding_time);
                     }
                
                   }
             
                  $calculationhour = $phour;
               }
               


                // End Calculation
               $flydistance = distance($res["loftlat"],$res["loftlong"],$res["Event_lat"],$res["Event_long"],"K");
               $velocity1 = ($flydistance*1000)/$calculationhour;
               if($res["velocity"]=="")
               {
                  $firstquery = mysqli_query($dbconnection,"update ppa_files set velocity='".$velocity1."' WHERE ide='".$res["ide"]."'");
                  $velocityupdate++;
               }
                ?>
                    
         
            <?php $i++; ?>
            <tr> 
              <td><?php echo $i;?></td> 
              <td><?php echo $res["username"];?></td> 
              <td style="text-align: center;"><a href="<?php echo $SITEMAINURL;?>uploads/<?php echo $res["filename"];?>"><img src="<?php echo $SITEMAINURL;?>uploads/<?php echo $res["filename"];?>" style="height: 80px; width:auto;"></a></td> 
              <td><?php echo $res["mobile"];?></td> 
              <!--<td><?php echo $res["brid_type"];?></td> -->
              <td><?php echo $res["owner_ringno"];?></td>
              <td><?php echo date('d-m-Y', ($res["time_interval"] / 1000));?></td>
              <td><?php echo date('h:i:s A', ($res["time_interval"] / 1000));?></td> 
              <td><?php echo number_format($calculationhour,7);?></td>
              <td><?php echo number_format($flydistance,7);?></td> 
              <td><?php echo number_format($velocity1,7);?></td>
              <td><?php echo $res["Event_lat"];?></td>
              <td><?php echo $res["Event_long"];?></td>
            </tr>  

                 
            <?php } 

            } else { ?>
            <div class="col-sm-12 col-xs-12" style="margin: auto;text-align: center;">  
                    <h2 style="color: #fff;border-top-color: #00c0ef!important;border: 3px solid transparent;background: #1d5f85;font-weight: 500;margin-bottom: 20px;"> No photos available right now, Please check again later.</div>
            <?php } ?>
         </div>

</div>
</div>
</div>

<!-- <script type="text/javascript">
  $(document).ready(function() {
  $('.zoom-gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    closeOnContentClick: false,
    closeBtnInside: false,
    mainClass: 'mfp-with-zoom mfp-img-mobile',
    image: {
      verticalFit: true,
    },
    gallery: {
      enabled: true
    },
    zoom: {
      enabled: true,
      duration: 300, 
      opener: function(element) {
        return element.find('img');
      }
    }
    
  });
});

</script> -->



</body>
<script>
  
  var allpageurl = "https://www.lespoton.com/portal/liveresult.php?atype=<?php echo $apptype;?>&rname=<?php echo $racename;?>&ide=<?php echo $eventide;?>&userToken=<?php echo $secureusertoken;?>";
  
  function gotopage(vals)
  {
      window.location.href = allpageurl+"&btype="+vals;
  }

</script>
<style>

.image-source-link {
  color: #98C3D1;
}

.mfp-with-zoom .mfp-container,
.mfp-with-zoom.mfp-bg {
  opacity: 0;
  -webkit-backface-visibility: hidden;
  /* ideally, transition speed should match zoom duration */
  -webkit-transition: all 0.3s ease-out; 
  -moz-transition: all 0.3s ease-out; 
  -o-transition: all 0.3s ease-out; 
  transition: all 0.3s ease-out;
}

.mfp-with-zoom.mfp-ready .mfp-container {
    opacity: 1;
}
.mfp-with-zoom.mfp-ready.mfp-bg {
    opacity: 0.8;
}

.mfp-with-zoom.mfp-removing .mfp-container, 
.mfp-with-zoom.mfp-removing.mfp-bg {
  opacity: 0;
}

   .center_img{
     position: absolute;
    top: 50%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%)
   }

  .full-width-img {height: 200px;
         /*border: 3px solid #00c0ef;*/
  
  }
  .title-content h1 {    
    color: #3fcafd;
    font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
    text-align: center;
    text-transform: uppercase;
    font-size: 3rem;
  }
  .title-text h2{
    color: #fff;
   
    border: 2px solid #fff;
    background: #3fcafd;
    font-weight: 500;
    margin-bottom: 20px;
    font-size: 2rem;
  }
  .photos-height {
    /*height: 150px;*/
    width: 100%;
    border: 3px solid #3fcafd;
   margin-top: 10px;
   padding-top: 30px;
    padding-bottom: 20px;
    text-align: center;
   
    background: #fff;
    margin-top: 30px;
    margin-bottom: 10px;
    border-radius: 4px;
    padding-right: 10px;
    padding-left: 10px;
    min-height: 360px;
    position: relative;
}
  .photos-height p { 
  text-align: left;
  padding-left: 5px;
  }
 hr {
    border: 0;
    border-top: 3px solid #3fcafd;
  
}
.photos-height p b{ 
 color:#3fcafd;
}
body {
 background-color: #f9f9f9 !important;
}

@media only screen and (max-width: 767px) {

  .photos-height {
      width: 80%;
      margin:auto;
      margin-top: 10px;
  }
 .full-width-img {
    height: 230px;
}
 .photos-height p b {display: block;} 
/* .mfp-img {
    max-height: 400px !important;
 }*/
}
</style>
</html>

<?php

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
 if($velocityupdate>0)
 {?>
    <script>window.location.reload();</script>
 <?php } ?>