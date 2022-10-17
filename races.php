<?PHP
include "siteinfo.php";
$clubcode = $_REQUEST["code"];

$query = mysqli_query($dbconnection,"select * from ppa_events as a LEFT JOIN users as b ON a.Org_id=b.users_id where b.Org_code='".$clubcode."' order by a.Event_date DESC") ;

$secureusertoken = $_REQUEST["userToken"];
$authuser = checkauthuser($dbconnection,$secureusertoken);
if($authuser=="0" || $authuser=="")
{
  die("<h1>Not Found</h1> <br> The requested URL  was not found on this server.");
}
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
<table border="0" cellspacing="0" cellspacing="0" width="100%">
  <tr>
    <td align="center"><h1 style="color:#3c8dbc;font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;">Races</h1></td>
  </tr>
  <tr>
      <td align="center" width="80%">
          <table id="example" class="table table-striped table-bordered nowrap" style="width:90%">  
            <tr> 
              <th>S.no</th> 
              <th>Race Name</th> 
              <th>Date</th> 
              <th>Photos</th> 
              <th>Live Results</th> 
              <th>Verified Results</th> 
            </tr>
            <?php  $i=1;
             if(mysqli_num_rows($query)>0) {
              while($res = mysqli_fetch_array($query))
              {  ?>
            <tr> 
              <td><?php echo $i;?></td> 
              <td><?php echo $res["Event_name"];?></td> 
              <td><?php echo $res["Event_date"];?></td> 
              <td> <a href='<?php echo $SITEMAINURL;?>viewphotos.php?atype=<?php echo $clubcode?>&rname=<?php echo $res["Event_name"];?>&ide=<?php echo $res["Events_id"];?>&userToken=<?php echo $secureusertoken;?>'>View Photos</a></td>
              <td> <a href='<?php echo $SITEMAINURL;?>liveresult.php?atype=<?php echo $clubcode?>&rname=<?php echo $res["Event_name"];?>&ide=<?php echo $res["Events_id"];?>&userToken=<?php echo $secureusertoken;?>'>Live Result</a></td> 
              <?php if($res["result_publish"]=='1') { ?>
              <td> <a href='<?php echo $SITEMAINURL;?>raceresults.php?ide=<?php echo $res["Events_id"];?>&userToken=<?php echo $secureusertoken;?>'>View Result</a></td> 
              <?php } else { ?>
               <td style="color:red;">Not published</td> 
              <?php } ?>
            </tr>  
            <?php $i++; } } else { ?>
             <tr><td colspan="4" align="center"> No races available right now , Please check again later.</td></tr>
            <?php } ?>
          </table>
      </td>
   </tr>
</table>



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


