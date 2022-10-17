<?PHP
include "siteinfo.php";



         $query = mysqli_query($dbconnection,"SELECT filename , cre_date FROM `ppa_files` WHERE club_code = 'PPA' order by cre_date ASC") ;
         $racecount = mysqli_num_rows($query);
         $i=0;?>
         <table border="0" cellpadding="0" cellspacing="0" width="50%">
         <?php
 
         while($res = mysqli_fetch_array($query))
         {
            $filename = "uploads/".$res['filename'];
            if(file_exists($filename))
             {
             echo "<tr><td>".$res['filename']."</td><td>".$res['cre_date']."</td><td>".$stat."</td></tr>";$i++;
              //@unlink($filename);
             }

         }   echo $i;?>
         </table>



