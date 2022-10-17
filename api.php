<?PHP
error_reporting(0);
ini_set('display_errors', 0);
mysql_connect('104.236.218.51','tripbaydb','Windows123');
//mysql_connect('192.168.0.51','phpserver','SmartWork');
mysql_select_db('spotlight');
 //echo $sql = "select * from bidding as a,hotels as b where a.hotel_id = b.hotel_id and bidding_status='Active' and bidding_end_date >= '".Date("Y-m-d")."' and a. 	bidding_deleted='No' order by bidding_id desc";
 if(isset($_GET["action"]))
 $action = $_GET["action"];
 else if(isset($_POST["action"]))
 {
   $action = $_POST["action"];

 }
 else
 {
 $postdetails = json_decode(file_get_contents('php://input'), TRUE); 
 $action = $postdetails["action"];
 }

 $activeall = 1;
 $expirydate = '2019-03-31 00:00:00';
 switch($action){
    case 'pparegister':
     $deviceide = $postdetails["deivce_id"];
     $username = $postdetails["username"];
     $apptype = $postdetails["apptype"];
     $password = $postdetails["password"];
     $phone_no = $postdetails["phone_no"];
     $model = $postdetails["model"];
     $version = $postdetails["ver"];
     $code = $postdetails["code"];

/*
        if($apptype=="amhc" && $code=='')
        {
          $data["status"]=1;
          $data["activestatus"]=0;
          $data["expirydate"]=$expirydate;
          die;
        }
        */
        if($apptype=="indp" && $version!=11)
        {
          $data["status"]=1;
          $data["activestatus"]=0;
          $data["expirydate"]=$expirydate;
          die;
        }
    
     //if(mysql_num_rows($selectavailability)==0)
     //{
          // check code respective to particular organization
          
          $checkactivecode=mysql_query("select * from ppa_code where Code_status='0' and Code_key='".$code."'");
          
          if(mysql_num_rows($checkactivecode)>0)
          {
            $data["status"]=1;  // Code not belongs to organization
            $data["activestatus"]=0;
            $data["expirydate"]=$expirydate;
            echo json_encode($data);
            die;
          }

          $checkcode=mysql_query("select * from ppa_code where Code_key='".$code."' and Org_code='".$apptype."'");
         //echo "select * from ppa_code where Code_key='".$code."' and Org_code='".$apptype."'";
         //die;

          if(mysql_num_rows($checkcode)==0)
          {
            $data["status"]=2;  // Code not belongs to organization
            $data["activestatus"]=$activeall;
            $data["expirydate"]=$expirydate;
            echo json_encode($data);
            die;
          }
          else
          {
             //$checkcode_exist = mysql_query("select * from ppa_register where code='".$code."'");
             $checkcode_exist = mysql_query("select * from ppa_code where Device_id!='' and Code_key='".$code."'");
             if(mysql_num_rows($checkcode_exist)==0)
             {

               $selectavailability = mysql_query("select * from ppa_register where device_id='".$deviceide."'");
               if(mysql_num_rows($selectavailability)==0) {
               $insert_qry = mysql_query("insert ppa_register set version='".$version."',code='".$code."',apptype='".$apptype."',username='".$username."',password='".$password."',phone_no='".$phone_no."',expiry_date='".$expirydate."',device_id='".$deviceide."',model='".$model."',cre_date=now()");

               $updatecode = mysql_query("update ppa_code set Device_id='".$deviceide."' where Code_key='".$code."'");
               
               $data["status"]=1;  // Updated
               $data["activestatus"]=$activeall;
               $data["expirydate"]=$expirydate;
               echo json_encode($data);
               die;
               }
               else
               {
                  $update_qry = mysql_query("update ppa_register set version='".$version."',code='".$code."',apptype='".$apptype."',username='".$username."',password='".$password."',phone_no='".$phone_no."',expiry_date='".$expirydate."',device_id='".$deviceide."',model='".$model."',update_date=now() where device_id='".$deviceide."'");
                   $updatecode = mysql_query("update ppa_code set Device_id='".$deviceide."' where Code_key='".$code."'");
                   $data["status"]=1;
                   $data["activestatus"]=$activeall;
                   $data["expirydate"]=$expirydate;
                   $data["test"]=$upquery;
                   echo json_encode($data);
                   die;
               }
             }
             else
             {
                
                   $data["status"]=3;  // Code already used with different device id
                   $data["activestatus"]=$activeall;
                   $data["expirydate"]=$expirydate;
                   echo json_encode($data);
                   die;
                

             }
          }
     /*}
     else
     {
      $res = mysql_fetch_array($selectavailability);
      $data["status"]=0;  // Not updated
      $data["activestatus"]=$activeall;
      $data["expirydate"]=$expirydate;
      echo json_encode($data);
      die;
     }*/
    echo json_encode($data);
    break;
    case 'current_time':
        date_default_timezone_set("Asia/Kolkata");
        $data["status"]=3;  
        $dd=date("Y-m-d H:i:s");
        $data["timezone"]=strtotime($dd);  
          echo json_encode($data);
          break;
    case 'fileupload':
     //print_r($_FILES);print_r($_POST);die;
               $path = "uploads/"; // Upload directory
               $count = 0;
               if ($_FILES['files']['error'] != 4) 
                   { // No error found! Move uploaded files 
                       $timeval = time();
                       $path_parts = pathinfo($_FILES["files"]["name"]);
                       $extension = $path_parts['extension'];
                       if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$path_parts['basename']))
                            {
                              $filespath = $path_parts['basename'];
                              $data["status"]=1;
                              $data["activestatus"]=$activeall;
                              $data["expirydate"]='2019-03-31 00:00:00';
                             // $insert_qry = mysql_query("insert ppa_files set filename='".$filespath."',device_id='".$deviceide."',cre_date=now()");
                            }
                            else
                            {
                              $data["status"]=0;
                              $data["activestatus"]=$activeall;
                              $data["expirydate"]=$expirydate;
                            }
                   }
                   else
                   {
                    $data["status"]=0;
                    $data["activestatus"]=$activeall;
                    $data["expirydate"]=$expirydate;
                   }
        
     
     echo json_encode($data);
    break;
    case 'ppaexpiry':

     $apptype = $postdetails["apptype"];
     $code = $postdetails["code"];
     $deviceide = $postdetails["deivce_id"];
     $checkactivecode=mysql_query("select * from ppa_code where Code_status='0' and Code_key='".$code."'");
           if($apptype=="indp" )
        {
          $data["status"]=1;
          $data["activestatus"]=0;
          $data["expirydate"]=$expirydate;
          die;
        }
          if(mysql_num_rows($checkactivecode)>0)
          {
            $data["status"]=1;  // Code not belongs to organization
            $data["activestatus"]=0;
            $data["expirydate"]=$expirydate;
            echo json_encode($data);
            die;
          }
     
     //$update_qry = mysql_query("update ppa_register set status='1',update_date=now() where device_id='".$deviceide."'");
     //$data["status"]=1;
     $data["status"]=1;
     $data["activestatus"]=$activeall;
     $data["expirydate"]=$expirydate;
     echo json_encode($data);
    break;
    default:	
		header("HTTP/1.1 200 OK");
		die;	
		break;	
   }
?>
