<?php

function finddistance($lat1, $lon1, $lat2, $lon2, $unit) {
        
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


?>
<style>
.box-body {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 2px;
    border-bottom-left-radius: 2px;
    padding: 20px;
}
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 4px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 5px;
  padding-bottom: 5px;
  text-align: left;
  background-color: #00c0ef;
  color: white;
}
</style>   
<?php
?>     
<div class="box-body box-profile">
  <table border="0" cellspacing="0" cellpadding="0" id="customers">
     <tr>
        <th>#</th>
        <th>Fancier name</th>
        <th>Bird Type & Count</th>
        <th>Race Distance</th>
     </tr>
     <?php $i = 0;

       foreach ($fancierdata as $value) {  $i++;
        
        $fanquery = "SELECT count(a.birdtype) as cnt ,a.birdtype,b.brid_type FROM `ppa_updatephoto` as a LEFT JOIN ppa_bird_type as b ON a.birdtype=b.b_id where a.event_id=".$eventdata[0]->event_id." and a.username='".$value->username."' group by a.birdtype";
        $select_fancierwise =$this->db->query($fanquery);
        $select_fancier_det = $select_fancierwise->result();
        ?>
               <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $value->username;?></td>
                  <?php if(count($select_fancier_det)>0) { ?><td><?php foreach ($select_fancier_det as $info) {?>
                         <table border="0" style="border: none;">
                            <tr><td style="border: none;"><?php echo $info->brid_type;?> : <?php echo $info->cnt;?></td></tr>
                         </table>
                  <?php } ?></td><?php } else { ?>
                  <td>N/A</td>
                  <?php } ?>
                  <td id="container">

                     <?php 
                         if($value->latitude=='')
                          echo "<span style='color:red'>"."Loft not updated"."<span>";
                         else if($racedata[0]->Event_lat=='')
                          echo "<span style='color:red'>"."Race not started"."<span>";
                         else
                         echo $distance = finddistance($racedata[0]->Event_lat,$racedata[0]->Event_long,$value->latitude,$value->longitude,"K")." Km"; 
                     ?>
                  </td>
               </tr>
       <?php }

     ?>
  </table>         
</div>
<?php
?>
