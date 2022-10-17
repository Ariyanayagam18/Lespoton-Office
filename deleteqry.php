<?php
error_reporting(1);
          ini_set('display_errors', 1);
          global $dbconnection;
$dbconnection = mysqli_connect('localhost','karlakat_spot','Windows123',"karlakat_spotlight");
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);

//$SITEMAINURL = "http://104.236.218.51/spotlightdemo/";
$SITEMAINURL = "https://www.lespoton.com/portal/";
 
 //SELECT * FROM `ppa_files` where cre_date > (NOW() - INTERVAL 1 MONTH) 

 $ppafiles = mysqli_query($dbconnection,"SELECT ide,filename,cre_date,MONTH(cre_date) FROM `ppa_files` where filename NOT IN (SELECT ppa_updatephoto.photo_name FROM ppa_updatephoto) and filename NOT IN (SELECT ppa_report.img_name FROM ppa_report) and filename NOT IN (SELECT ppa_register.loft_image FROM ppa_register) and MONTH(cre_date)=12 and YEAR(cre_date)!=2020");

 //$deletefiles = mysqli_query($dbconnection,"SELECT * FROM `ppa_files` as a where a.cre_date > (NOW() - INTERVAL 1 MONTH) and a.deleted!=2 and a.deleted!=1");

//$ppafiles = mysqli_query($dbconnection,"SELECT ide,filename,cre_date,MONTH(cre_date) FROM `ppa_files` where filename='fname_358057081579961_1576222454537.jpg'");

// change the deleted column status in to 2 for important files


 /*while($res = mysqli_fetch_array($ppafiles))
  {
  	//$filename = "uploads/".$res["img_name"];
    $filename = "uploads/".$res["filename"];
    $ide  = $res["ide"];
    $cre_date  = $res["cre_date"];
    if(file_exists($filename))
    {
     $yesarray[] = $filename;
    }
    else
    {
     echo "NO - ".$ide."  - ".$cre_date." - ".$filename."<br>";	
     $noarray[] = $filename;
    }
   /* if($orifilename==$filename)
    {
      $reportarray[] = $orifilename;

      //mysqli_query($dbconnection,"update ppa_files set deleted = 2 where ide=".$ide);
    }*/

 // }

?>
   <table border="1" cellspacing="3" cellpadding="3" width="60%">
<?php
  $i=0;
  while($res = mysqli_fetch_array($ppafiles))
  {
    $filename = "uploads/".$res["filename"];
    $ide  = $res["ide"];
    $cre_date  = $res["cre_date"];
    $status    = "NO";
    if(file_exists($filename))
    {
     $status    = "YES";$i++;
    // if($i==1)
     //{
         //$image = file_get_contents('http://www.lespoton.com/portal/'.$filename);
         //$outimage = file_put_contents('/opt/lampp/htdocs/AO/'.$filename, $image);
         //$fullPath = 'http://www.lespoton.com/portal/'.$filename;
         // echo '<iframe name="frame"'.$i.' id="frame"'.$i.' src="downloadss.php?path='.$fullPath.'"></iframe>';
        // header("Content-Type: application/force-download"); 
        // header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" ); 
         
         //$remoteURL = 'https://www.example.com/files/project.zip';

// Force download



       
     //}
    // $ppafiles = mysqli_query($dbconnection,"update ppa_files set image_status='1' where filename='".$res["filename"]."'");
     echo "<tr><td>".$ide."</td><td>".$filename."</td><td>".$status."</td></tr>";
   }
    //echo "<tr><td>".$ide."</td><td>".$filename."</td><td>".$status."</td><td><img src='".$filename."' width=100 height=100></td>></tr>";
  }
  
?>
   </table>
<?php
   echo "<br>TOT : ".$i;



   //if($i==1) {
   //  $image = file_get_contents('http://www.lespoton.com/portal/'.$filename);
   //  $outimage = file_put_contents('/home/twilightuser/Downloads/Tams/'.$res["filename"], $image);
   //  }
// End

/*
while($res = mysqli_fetch_array($deletefiles))
  {
     $filename = "uploads/".$res["filename"];
      $ide  = $res["ide"];
     if (!unlink($filename))
     {
       
       echo ("<br> $ide Error deleting $filename");
       if(!file_exists($filename))
        mysqli_query($dbconnection,"update ppa_files set deleted = 1 where ide=".$ide);
     }
     else
     {
       echo ("<br> $ide Deleted $filename");
       mysqli_query($dbconnection,"update ppa_files set deleted = 1 where ide=".$ide);
     }
  }

*/


  //echo count($yesarray)." - ".count($noarray)." - ".count($reportarray);
?>