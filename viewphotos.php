<?PHP
include "siteinfo.php";

$eventide = $_REQUEST["ide"];
$racename = $_REQUEST["rname"];
$apptype = $_REQUEST["atype"];


if (isset($_GET["uname"])){
  $racename = $_GET["uname"];
}

$secureusertoken = $_REQUEST["userToken"];
$authuser = checkauthuser($dbconnection,$secureusertoken);
if($authuser=="0" || $authuser=="")
{
  die("<h1>Not Found</h1> <br> The requested URL  was not found on this server.");
}


if(isset($_REQUEST["ide"])&& isset($_REQUEST["uname"]))
{
$fancier_name = $_REQUEST["uname"];
//$query = mysqli_query($dbconnection,("SELECT COUNT(*) as cnt,a.username,a.photo_name FROM ppa_updatephoto as a WHERE a.event_id='".$eventide."' GROUP by a.username") ;

$firstquery = mysqli_query($dbconnection,"SELECT max(date) as maxi,MIN(date) as mini,start_time as start FROM `ppa_event_details` WHERE event_id='".$eventide."'");
 $firstres = mysqli_fetch_array($firstquery);
 $maxdate  = $firstres["maxi"]." 23:59:59";
 $mindate  = $firstres["mini"]." 00:00:00";

$racestartdate = $firstres["mini"];
$starttime     = $firstres["start"];

 //$query = mysqli_query($dbconnection,("SELECT COUNT(*) as cnt,a.username,a.photo_name FROM ppa_updatephoto as a WHERE a.event_id='".$eventide."' GROUP by a.username") ;

        /*How many records you want to show in a single page.*/
        $limit = 10;
        /*How may adjacent page links should be shown on each side of the current page link.*/
        $adjacents = 2;
     
        
if($fancier_name=="all")
{
  $sql = mysqli_query($dbconnection,"SELECT a.ide,a.username,a.filename,a.latitude,a.longitude,c.Event_lat,c.Event_long,d.latitude as loftlat,d.longitude as loftlong FROM ppa_files as a LEFT JOIN users as b on a.club_code=b.Org_code LEFT JOIN ppa_events as c on b.users_id=c.Org_id LEFT JOIN ppa_register as d on d.apptype=a.club_code and a.mobile=d.phone_no WHERE a.cre_date>='".$mindate."' and a.cre_date<='".$maxdate."' and club_code='".$apptype."'  and c.Events_id='".$eventide."'") ;

  $total_rows = mysqli_num_rows($sql);
      $total_pages = ceil($total_rows / $limit);
      if(isset($_GET['page']) && $_GET['page'] != "") {
          $page = $_GET['page'];
          $offset = $limit * ($page-1);
        } else {
          $page = 1;
          $offset = 0;
        }


  $query = mysqli_query($dbconnection,"SELECT a.ide,a.username,a.filename,a.latitude,a.longitude,c.Event_lat,c.Event_long,d.latitude as loftlat,d.longitude as loftlong FROM ppa_files as a LEFT JOIN users as b on a.club_code=b.Org_code LEFT JOIN ppa_events as c on b.users_id=c.Org_id LEFT JOIN ppa_register as d on d.apptype=a.club_code and a.mobile=d.phone_no WHERE a.cre_date>='".$mindate."' and a.cre_date<='".$maxdate."' and club_code='".$apptype."'  and c.Events_id='".$eventide."' limit ".$offset.",".$limit) ;
}
else
{
  $sql = mysqli_query($dbconnection,"SELECT a.ide,a.username,a.filename,a.latitude,a.longitude,c.Event_lat,c.Event_long,d.latitude as loftlat,d.longitude as loftlong FROM ppa_files as a LEFT JOIN users as b on a.club_code=b.Org_code LEFT JOIN ppa_events as c on b.users_id=c.Org_id LEFT JOIN ppa_register as d on d.apptype=a.club_code and a.mobile=d.phone_no WHERE a.cre_date>='".$mindate."' and a.cre_date<='".$maxdate."' and club_code='".$apptype."' and a.username='".$fancier_name."' and c.Events_id='".$eventide."'") ;

     

  $total_rows = mysqli_num_rows($sql);
      $total_pages = ceil($total_rows / $limit);
      if(isset($_GET['page']) && $_GET['page'] != "") {
          $page = $_GET['page'];
          $offset = $limit * ($page-1);
        } else {
          $page = 1;
          $offset = 0;
        }
  

  $query = mysqli_query($dbconnection,"SELECT a.ide,a.username,a.filename,a.latitude,a.longitude,c.Event_lat,c.Event_long,d.latitude as loftlat,d.longitude as loftlong FROM ppa_files as a LEFT JOIN users as b on a.club_code=b.Org_code LEFT JOIN ppa_events as c on b.users_id=c.Org_id LEFT JOIN ppa_register as d on d.apptype=a.club_code and a.mobile=d.phone_no WHERE a.cre_date>='".$mindate."' and a.cre_date<='".$maxdate."' and club_code='".$apptype."' and a.username='".$fancier_name."' and c.Events_id='".$eventide."' limit ".$offset.",".$limit) ;
}
   
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





}
else
{
 $firstquery = mysqli_query($dbconnection,"SELECT max(date) as maxi,MIN(date) as mini,start_time as start FROM `ppa_event_details` WHERE event_id='".$eventide."'");
 $firstres = mysqli_fetch_array($firstquery);
 $maxdate  = $firstres["maxi"]." 23:59:59";
 $mindate  = $firstres["mini"]." 00:00:00";

 $racestartdate = $firstres["mini"];
 $starttime     = $firstres["start"];
 //$query = mysqli_query($dbconnection,("SELECT COUNT(*) as cnt,a.username,a.photo_name FROM ppa_updatephoto as a WHERE a.event_id='".$eventide."' GROUP by a.username") ;
 $query = mysqli_query($dbconnection,"SELECT a.ide,COUNT(*) as cnt,a.username,a.filename,d.latitude as loftlat,d.longitude as loftlong FROM ppa_files as a LEFT JOIN ppa_register as d on d.apptype=a.club_code and a.mobile=d.phone_no WHERE a.cre_date>='".$mindate."' and a.cre_date<='".$maxdate."' and club_code='".$apptype."' GROUP by a.username") ;
 //echo "SELECT a.ide,COUNT(*) as cnt,a.username,a.filename FROM ppa_files as a WHERE a.cre_date>='".$mindate."' and a.cre_date<='".$maxdate."' and club_code='".$apptype."' GROUP by a.username";
}

$raceeventide = $eventide;
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
         <tr><td>Choose Photo type : <select onchange="gotopage(this.value)"><option value="">Select Photo type</option><option value="1">All</option><option value="2">By Fancier</option></select></td></tr>
         <tr>
            <td>
          <?php 
           
           if(isset($_GET["all"]))
            $pagingurl = "https://www.lespoton.com/portal/viewphotos.php?uname=all&atype=".$apptype."&rname=".$racename."&ide=".$eventide."&userToken=".$secureusertoken."&all=0";
           else
            $pagingurl = "https://www.lespoton.com/portal/viewphotos.php?uname=".$fancier_name."&atype=".$apptype."&rname=".$racename."&ide=".$eventide."&userToken=".$secureusertoken;

           if($total_pages > 1 && isset($_REQUEST["uname"])) { ?>
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

            <?php  $i=1;
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
                      //$chk_date = mysqli_query($dbconnection,"SELECT * FROM ppa_event_details as a LEFT JOIN ppa_bird_type as b on b.b_id=a.bird_id WHERE a.event_id= '".$raceeventide."' AND a.race_distance='".$evnt_dis."' AND date<='".$fulldate."' AND b.brid_type='".$bird_type."'");
                      
                      // *** Bird type and Race distnace we cant get here thats why velocity is not exact one TODO check with bala

                      $chk_date = mysqli_query($dbconnection,"SELECT * FROM ppa_event_details as a LEFT JOIN ppa_bird_type as b on b.b_id=a.bird_id WHERE a.event_id= '".$raceeventide."' AND date<='".$fulldate."'");

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
                ?>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 title-text" style="margin: auto;text-align: center;">  
                    <?php if(!isset($_GET["uname"])){ ?><h2><?php echo $res["username"];?> ( <?php echo $counts;?> )</h2> <?php } ?>           
                    <div class="photos-height <?php if(isset($_GET['uname'])){ echo "zoom-gallery";}?>">
                     <?php if(isset($_GET["uname"]) || isset($_GET["all"])){ 
                       $timeinfo  = explode("_",$res["filename"]);
                       $timestamp = (str_replace(".jpg","",$timeinfo[2])/1000);
                       
                       $timezone = "Asia/Kolkata";
                       $dt = new DateTime();
                       $dt->setTimestamp($timestamp);
                       $dt->setTimezone(new DateTimeZone($timezone));
                       $datetime = $dt->format('h:i:s A');
                       $fulltime = $dt->format('Y-m-d h:i:s A');
                       //$fulltime = date('Y-m-d H:i:s', $timestamp);
                       
                       //$flydistance = distance($res["latitude"],$res["longitude"],$res["Event_lat"],$res["Event_long"],"K");
                       $flydistance = distance($res["loftlat"],$res["loftlong"],$res["Event_lat"],$res["Event_long"],"K");
                       $velocity1 = ($flydistance*1000)/$calculationhour;
                       ?> 
                     <a href="<?php echo $SITEMAINURL;?>uploads/<?php echo $res["filename"];?>" data-source="">  
                     <img src="<?php echo $SITEMAINURL;?>uploads/<?php echo $res["filename"];?>" class="img-thumbnail full-width-img <?php if(!isset($_GET['uname'])){ echo "center_img";} ?>" alt="race photos"> 
                     </a>    
                     <hr>
                     <?php if(isset($_GET["all"])) { ?>
                     <p><b>Fancier name :</b> <?php echo $res["username"];?> </p>
                     <?php } ?>
                     <p><b>Time:</b> <?php echo $fulltime;?> </p>
                     <p><b>Latitude :</b> <?php echo $res["loftlat"];?></p>
                     <p><b>Longitude :</b> <?php echo $res["loftlong"];?></p>
                     <p><b>Fly Distance :</b> <?php echo $flydistance;?> km</p>
                     <p><b>Velocity :</b> <?php echo number_format($velocity1,7);?></p>
                     <?php } else { ?>
                      <a href="<?php echo $SITEMAINURL;?>viewphotos.php?uname=<?php echo $res["username"];?>&ide=<?php echo $eventide;?>&atype=<?php echo $apptype;?>&userToken=<?php echo $secureusertoken;?>">
                      <img  src="<?php echo $SITEMAINURL;?>uploads/<?php echo $res["filename"];?>" class="img-thumbnail full-width-img <?php if(!isset($_GET['uname'])){ echo "center_img";}?>" alt="race photos"> 
                      </a>
                      <?php } ?>
                    </div>
                  </div>
         
            <?php $i++; } } else { ?>
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
  
  var allpageurl = "https://www.lespoton.com/portal/viewphotos.php?uname=all&atype=<?php echo $apptype;?>&rname=<?php echo $racename;?>&ide=<?php echo $eventide;?>&userToken=<?php echo $secureusertoken;?>&all=0";
  var fancierpageurl = "https://www.lespoton.com/portal/viewphotos.php?atype=<?php echo $apptype;?>&rname=<?php echo $racename;?>&ide=<?php echo $eventide;?>&userToken=<?php echo $secureusertoken;?>";

  
  function gotopage(vals)
  {
    if(vals==1)
      window.location.href = allpageurl;
    else
      window.location.href = fancierpageurl;
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

?>