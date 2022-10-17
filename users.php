<?PHP
include "siteinfo.php";

$secureusertoken = $_REQUEST["userToken"];
$authuser = checkauthuser($dbconnection,$secureusertoken);
if($authuser=="0" || $authuser=="")
{
  die("<h1>Not Found</h1> <br> The requested URL  was not found on this server.");
}

$clubcode = $_REQUEST["code"];

$query = mysqli_query($dbconnection,"select * from ppa_register where apptype='".$clubcode."'") ;
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
    <td align="center"><h1 style="color:#3c8dbc;font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;">Fanciers</h1></td>
  </tr>
  <tr>
      <td align="center" width="80%">
          <table id="example" class="table table-striped table-bordered nowrap" style="width:90%">  
            <tr> 
              <th>S.no</th> 
              <th>Name</th> 
              <th>Phone number</th> 
              <th>Loft Location</th> 
            </tr>
            <?php  $i=1;
             if(mysqli_num_rows($query)>0) {
              while($res = mysqli_fetch_array($query))
              {  ?>
            <tr> 
              <td><?php echo $i;?></td> 
              <td><?php echo $res["username"];?></td> 
              <td><?php echo $res["phone_no"];?></td> 
              <td><?php if($res["latitude"]!='') { ?><a href="http://maps.google.com/?q=<?php echo $res["latitude"].",".$res["longitude"];?>" target="_blank">Map View</a>
              <?php } else { ?>
                Location not updated
              <?php } ?>
              </td>
            </tr>  
            <?php $i++; } } else { ?>
             <tr><td colspan="4" align="center"> No fanciers available right now , Please check again later.</td></tr>
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


