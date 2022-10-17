<?php
error_reporting(1);
          ini_set('display_errors', 1);

include "siteinfo.php";

$eventide = $_REQUEST["ide"];

$secureusertoken = $_REQUEST["userToken"];
$authuser = checkauthuser($dbconnection,$secureusertoken);

if($authuser=="0" || $authuser=="")
{
  die("<h1>Not Found</h1> <br> The requested URL  was not found on this server.");
}
// die("DSFDsf");

$birdcats = mysqli_query($dbconnection,"select b.brid_type,a.bird_type_id from ppa_report as a LEFT JOIN ppa_bird_type as b ON b.b_id=a.bird_type_id where a.event_id='".$eventide."' group by a.bird_type_id") ;


?>
<!DOCTYPE html>
<html>
<head>
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
</head>
<body>

<div class="container-fluid">
<?php while($birdcatres = mysqli_fetch_array($birdcats))
{  $birdtypename = $birdcatres["brid_type"]; $birdtypeide = $birdcatres["bird_type_id"];?>
<div class="row">
<div class="col-lg-12"> 
   <h1 style="color:#3c8dbc;font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif; text-align:center;"><?php echo $birdtypename?> - Race Results</h1>
    <div class="table-responsive">

          <table id="example" class="table table-striped table-bordered nowrap">  
            <tr> 
              <th>S.no</th> 
              <th>Name</th> 
              <th>Image</th> 
              <th>Mobile no</th> 
              <!--<th>Bird category</th>--> 
              <th>Ring no</th> 
              <th>Gender</th> 
              <th>Color</th> 
              <th>Start Time</th> 
              <th>Board Date</th> 
              <th>Board Time</th> 
              <th>Time Taken ( min )</th> 
              <th>Distance (Km)</th> 
              <th>Velocity (Mt/Min)</th> 


            </tr>
            <?php  

              $query = mysqli_query($dbconnection,"select * from ppa_report as a LEFT JOIN ppa_bird_type as b ON b.b_id=a.bird_type_id where a.event_id='".$eventide."' and  a.bird_type_id='".$birdtypeide."' order by velocity DESC") ;
              $i=1;
              if(mysqli_num_rows($query)>0) {
              while($res = mysqli_fetch_array($query))
              {  ?>
            <tr> 
              <td><?php echo $i;?></td> 
              <td><?php echo $res["name"];?></td> 
              <td style="text-align: center;"><a href="<?php echo $SITEMAINURL;?>uploads/<?php echo $res["img_name"];?>"><img src="<?php echo $SITEMAINURL;?>uploads/<?php echo $res["img_name"];?>" style="height: 80px; width:auto;"></a></td> 
              <td><?php echo $res["mobile_number"];?></td> 
              <!--<td><?php echo $res["brid_type"];?></td> -->
              <td><?php echo $res["ring_no"];?></td>
              <td><?php echo $res["bird_gender"];?></td> 
              <td><?php echo $res["bird_color"];?></td>
              <td><?php echo $res["start_time"];?></td> 
              <td><?php echo date('d-m-Y', ($res["intervel"] / 1000));?></td>
              <td><?php echo date('h:i:s A', ($res["intervel"] / 1000));?></td> 
              <td><?php echo $res["minis"];?></td>
              <td><?php echo $res["distance"];?></td> 
              <td><?php echo $res["velocity"];?></td>
              </tr>  
            <?php $i++; } } else { ?>
            <tr><td colspan="13" align="center"> No results available right now, Please check again later.</td></tr>
            <?php } ?>
          </table>

</div>
</div>
</div>
<?php } ?>


</div>
</body>
</html>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        responsive: true
    } );
 
    new $.fn.dataTable.FixedHeader( table );
} );

  </script>


