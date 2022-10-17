<?PHP
include "siteinfo.php";
$timezone = "Asia/Kolkata";
include "Mail/phpmailer/class.phpmailer.php";
//require('/portal/Mail/phpmailer/class.phpmailer.php');

date_default_timezone_set($timezone);
$activeall = 1;
$cameraAllowed = "1";
$expirydate = '2019-03-31 00:00:00';
$curr_ip = "103.213.192.118";
// End
if (isset($_GET["action"])) {
    $action = $_GET["action"];
    $secureusertoken = $_GET["Authorization"];
} else if (isset($_POST["action"])) {
    $action = $_POST["action"];
    $postdetails = $_POST;
    $secureusertoken = $postdetails["Authorization"];
    //print_r($postdetails);die;
} else {
    $postdetails = json_decode(file_get_contents('php://input'), TRUE);
    $action = $postdetails["action"];
    $secureusertoken = $postdetails["Authorization"];
    // Get org details
    $selectorg_details = mysqli_query($dbconnection, "select * from users where Org_code='" . $postdetails["apptype"] . "'");
    if (mysqli_num_rows($selectorg_details) > 0) {
        $org_details = mysqli_fetch_array($selectorg_details);
        $expirydate = $org_details["Expire_date"] . " 00:00:00";
        $org_status = $org_details["Org_status"];
    }
    // End
}

if ($postdetails) {
    $apptype = $postdetails["apptype"];
    $checkdate = date("Y-m-d H:i:s");
    $cameracheck = mysqli_query($dbconnection, "select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,a.date,a.end_time,TIMESTAMP(a.date, STR_TO_DATE(a.start_time, '%h:%i %p')) as stimes,TIMESTAMP(a.date, STR_TO_DATE(a.end_time, '%h:%i %p')) as etimes FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id where c.Org_code='" . $apptype . "' and ('" . $checkdate . "' BETWEEN TIMESTAMP(a.date, STR_TO_DATE(a.start_time, '%h:%i %p')) and TIMESTAMP(a.date, STR_TO_DATE(a.end_time, '%h:%i %p'))) and b.result_publish='0' group by a.race_distance order by etimes DESC");
    if (mysqli_num_rows($cameracheck) == 0) // If no events available ..camera diabled.
    {
        $cameraAllowed = "0";
    }

}

$headers = apache_request_headers();
foreach ($headers as $header => $value) {
    if ($header == "Authorization") {
        $secureusertoken = $value;
    }

}
// Checking code starts
switch ($action) {

case 'forgotpassword':
    $email_id = $postdetails["email"];
    $str = rand();
    $check_email = mysqli_query($dbconnection, "select * from ppa_register where email_id='" . $email_id . "'");
    if (mysqli_num_rows($check_email) > 0) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Username = "manibalan@twilightsoftwares.com";
        $mail->Password = "Mani@12345";
        $mail->Host = "smtp.gmail.com";
        $mail->Mailer = "smtp";
        $mail->AddAddress($email_id);
        $mail->Subject = 'Forgot Passowrd';
        $mail->WordWrap = 80;
        $mail->MsgHTML("https://www.lespoton.com/portal/forgotpassword.php?verify_id=" . $str . "");
        $mail->IsHTML(true);

        if (!$mail->Send()) {
            $data["status"] = 404;
            $data["message"] = "Mail Not Send";
            echo json_encode($data);
            break;
        } else {
            $updatetoken = mysqli_query($dbconnection, "update ppa_register set verify_id='" . $str . "' where email_id='" . $email_id . "'");
            $data["status"] = 200;
            $data["message"] = "Mail Send successfully";
            echo json_encode($data);
            break;
        }

    } else {
        $data["status"] = 404;
        $data["message"] = "User Not Found";
        echo json_encode($data);
        break;
    }

case 'pparegister': // Register and Login service
    $deviceide = $postdetails["deivce_id"];
    $username = $postdetails["username"];
    $apptype = $postdetails["apptype"]; //Post App Type
    $password = $postdetails["password"];
    $phone_no = $postdetails["phone_no"]; //Post phone number
    $model = $postdetails["model"];
    $version = $postdetails["ver"];
    $code = $postdetails["code"];
    $language = $postdetails["language"];
    $country = $postdetails["country"];
    $email_id = $postdetails["email_id"];
    //$notify_status = $postdetails["notify_status"];
    $timezone = "Asia/Kolkata";
    date_default_timezone_set($timezone);
    $curdate = date("Y-m-d H:i:s");
    $usercount = 0;
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($postdetails["notify_status"] != "") {
        $notify_status = $postdetails["notify_status"];
    } else {
        $notify_status = 0;
    }

    $notify_status = 1;

    $orgcont_details = mysqli_query($dbconnection, "select * from users where Org_code='" . $apptype . "'");
    $orgcontactdet = mysqli_fetch_array($orgcont_details);

    if ($orgcontactdet["phone_no"] != "") {
        $phone_num = $orgcontactdet["phone_no"];
    } else {
        $phone_num = 0;
    }

    //$phone_num = $orgcontactdet["phone_no"];

    $usercount = $orgcontactdet["usercount"];

    if ($deviceide == "" || $username == "" || $apptype == "" || $password == "" || $phone_no == "" || $model == "" || $version == "" || $code == "" || $country == "" || $language == "" || $email_id == "") {
        $data["status"] = 400;
        $data["message"] = "Required param is Null";
        echo json_encode($data);
        break;
    }

    $check_email = mysqli_query($dbconnection, "select * from ppa_register where email_id='" . $email_id . "'");
    if (mysqli_num_rows($check_email) > 0) {
        $data["status"] = 404;
        $data["message"] = "Email Already registered. Please Try some other email";
        echo json_encode($data);
        break;
    }
    $check_phone = mysqli_query($dbconnection, "select * from ppa_register where phone_no='" . $phone_no . "' and apptype = '" . $apptype . "'");
    if (mysqli_num_rows($check_phone) > 0) {
        $data["status"] = 404;
        $data["message"] = "Phone number Already registered. Please Try some other phone number";
        echo json_encode($data);
        break;
    } else {
        $checkusercount = mysqli_query($dbconnection, "select * from ppa_register where phone_no!='" . $phone_no . "' and apptype='" . $apptype . "'");

        if (mysqli_num_rows($checkusercount) < $usercount) {
            $selectavailability = mysqli_query($dbconnection, "select * from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "'");

            $availability = mysqli_query($dbconnection, "select * from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "' and username='" . $username . "'");

            //newly added
            $getReadType = mysqli_query($dbconnection, "select read_type from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "' and username='" . $username . "'");

            //$getReadType = mysqli_query($dbconnection, "select read_type from users where Org_code='" . $apptype . "'");
            $ReadType = mysqli_fetch_array($getReadType);
            //newly added

            if (mysqli_num_rows($selectavailability) == 0) {
                $insert_qry = mysqli_query($dbconnection, "insert ppa_register set version='" . $version . "',code='" . $code . "',apptype='" . $apptype . "',email_id='" . $email_id . "',username='" . $username . "',password='" . $hashPassword . "',phone_no='" . $phone_no . "',expiry_date='" . $expirydate . "',device_id='" . $deviceide . "',model='" . $model . "',cre_date='" . $curdate . "',country='" . $country . "',language='" . $language . "',notify_status='" . $notify_status . "'");
                $ide = mysqli_insert_id($dbconnection);
                $useride = md5($ide);
                $updatetoken = mysqli_query($dbconnection, "update ppa_register set userToken='" . $useride . "' where reg_id='" . $ide . "'");

                $blueToothqry = mysqli_query($dbconnection, "select bluetooth_id from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "' and username='" . $username . "' limit 0,1");
                $blueToothType = mysqli_fetch_array($blueToothqry);

                $data["apptype"] = $apptype;
                $data["username"] = $username;
                $data["status"] = 1; // Updated
                $data["activestatus"] = $activeall;
                $data["accountstatus"] = 0;
                $data["userToken"] = $useride;
                $data["userId"] = "$ide";
                if ($row["usertype"] == 1) {
                    $data["usertype"] = 'Admin';
                } else {
                    $data["usertype"] = 'Member';
                }
                $data["loftstatus"] = 0;
                $data["Orgphone_no"] = $phone_num;
                $data["phone_no"] = $phone_no;
                //$data["usertype"] = 0;
                $data["origin"] = $_SERVER['REMOTE_ADDR'];
                $data["email_id"] = $email_id;
                $data["isCameraAllowed"] = $cameraAllowed;
                $data["expirydate"] = $expirydate;
                $data["language"] = $language;
                $data["country"] = $country;
                $data["notify_status"] = $notify_status;
                $data["profile_url"] = $SITEMAINURL . "uploads/no-image.png";
                //newly added
                $data["read_type"] = $ReadType['read_type'];

                if ($data["read_type"] != "") {
                    $data["read_type"] = $ReadType['read_type'];
                } else {
                    $data["read_type"] = "0";
                }


                $data["bluetooth_id"] = $blueToothType['bluetooth_id'];

                if ($data["bluetooth_id"] != "") {
                    $data["bluetooth_id"] = json_decode($blueToothType['bluetooth_id']);
                } else {
                    $data["bluetooth_id"] = null;
                }

                //newly added
                $data["status"] = 200;
                $data["message"] = "registered successfully";
                echo json_encode($data);
                die;
            } elseif (mysqli_num_rows($availability) == 1) {
                $data["status"] = 404;
                $data["message"] = " User already exits";
            } else {
                $timezone = "Asia/Kolkata";
                date_default_timezone_set($timezone);
                $curdate = date("Y-m-d H:i:s");

                $update_qry = mysqli_query($dbconnection, "update ppa_register set version='" . $version . "',code='" . $code . "',apptype='" . $apptype . "',email_id='" . $email_id . "',username='" . $username . "',password='" . $hashPassword . "',phone_no='" . $phone_no . "',expiry_date='" . $expirydate . "',device_id='" . $deviceide . "',model='" . $model . "',update_date='" . $curdate . "',country='" . $country . "',language='" . $language . "',notify_status='" . $notify_status . "' where phone_no='" . $phone_no . "' and apptype='" . $apptype . "'");

                // Get user account status
                $accdetails = mysqli_fetch_array($selectavailability);

                $blueToothqry = mysqli_query($dbconnection, "select bluetooth_id from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "' and username='" . $username . "' limit 0,1");
                $blueToothType = mysqli_fetch_array($blueToothqry);

                // get org contact number
                $orgcont_details = mysqli_query($dbconnection, "select * from users where Org_code=" . $apptype);
                $orgcontactdet = mysqli_fetch_array($orgcont_details);
                //$phone_num = $orgcontactdet["phone_no"];

                if ($orgcontactdet["phone_no"] != "") {
                    $phone_num = $orgcontactdet["phone_no"];
                } else {
                    $phone_num = 0;
                }

                $ide = $accdetails["reg_id"];
                $useride = md5($ide);
                $updatetoken = mysqli_query($dbconnection, "update ppa_register set userToken='" . $useride . "' where reg_id='" . $ide . "'");
                $data["username"] = $username;
                $data["apptype"] = $apptype;
                $data["status"] = 1;
                $data["activestatus"] = $activeall;
                $data["accountstatus"] = $accdetails["status"];
                $data["userToken"] = $useride;
                if ($accdetails['usertype'] == 0) {
                    $data["usertype"] = "Member";
                } else {
                    $data["usertype"] = "Admin";
                }
                $data["userId"] = "$ide";
                $data["Orgphone_no"] = $phone_num;
                $data["phone_no"] = $phone_no;
                $data["email_id"] = $email_id;
                $data["origin"] = $_SERVER['REMOTE_ADDR'];
                $data["serorigin"] = $_SERVER['SERVER_ADDR'];
                //$data["usertype"] = $accdetails["usertype"];
                $data["loftstatus"] = $accdetails["loftstatus"];
                $data["isCameraAllowed"] = $cameraAllowed;
                $data["expirydate"] = $expirydate;
                $data["notify_status"] = $notify_status;
                //$data["test"]=$upquery;
                $data["language"] = $language;
                $data["country"] = $country;
                $data["bluetooth_id"] = $blueToothType['bluetooth_id'];

                if ($data["bluetooth_id"] != "") {
                    $data["bluetooth_id"] = json_decode($blueToothType['bluetooth_id']);
                } else {
                    $data["bluetooth_id"] = "";
                }

                $data["profile_url"] = $SITEMAINURL . "uploads/no-image.png";
                //newly added
                $data["read_type"] = $ReadType['read_type'];
                //newly added
                $data["status"] = 200;

                $data["message"] = "registered successfully";
                echo json_encode($data);
                die;
            }
        } else {
            $data["status"] = 0;
            $data["message"] = "Fancier count limit reached. Please contact your Oraganization";
        }
        echo json_encode($data);
        break;
    }

case 'clublist':
    $getClubList = mysqli_query($dbconnection, "select `users_id`,`name`,`Org_code` from users where status='active' AND Org_code NOT IN ('ADMIN')");

    $clubcount = mysqli_num_rows($getClubList);
    $i = 0;
    if (count($clubcount) > 0) {
        while ($clubList = mysqli_fetch_array($getClubList)) {
            $data["clublist"][$i]["ide"] = $clubList["users_id"];
            $data["clublist"][$i]["clubname"] = $clubList["name"];
            $data["clublist"][$i]["clubcode"] = $clubList["Org_code"];
            $i++;
        }
        $data["club_count"] = $clubcount;
        $data["status"] = 200;
        $data["message"] = "Club List successfully retrieved";
    } else {
        $data["status"] = 404;
        $data["message"] = "Club list not found";
    }
    echo json_encode($data);
    break;

case 'ppalogin':
    $username = $postdetails["user_name"];
    $password = $postdetails["password"];
    $apptype = $postdetails["apptype"];
    if ($apptype != "" && $username != "") 
    {
        $checklogin = mysqli_query($dbconnection, "select * from ppa_register where ( username='" . $username . "' OR phone_no='" . $username . "')  and apptype='" . $apptype . "'");
        $numRows = mysqli_num_rows($checklogin);
    }
    else 
    {
        $checklogin = mysqli_query($dbconnection, "select * from ppa_register where ( username='" . $username . "' OR phone_no='" . $username . "')");
        $numRows = mysqli_num_rows($checklogin);
    }

    if ($username == "" || $password == "" || $apptype == "") 
    {
        $data["status"] = 400;
        $data["message"] = "Required param is Null";
        echo json_encode($data);
        break;
    }

    if ($numRows == 1) 
    {
        $row = mysqli_fetch_assoc($checklogin);
        if (password_verify($password, $row["password"])) 
        {
            $get_user_token = mysqli_query($dbconnection, "select * from ppa_register where ( username='" . $username . "' OR phone_no='" . $username . "') and apptype='" . $apptype . "'");
            //$result = md5($userToken);
            $userToken = mysqli_fetch_array($get_user_token);
            $str = rand();
            $result = md5($str);
            if (isset($userToken['userToken'])) 
            {
                $get_tag_token = mysqli_query($dbconnection, "select user_token,user_id from ppa_tag_details where user_id = '" . $userToken['reg_id'] . "'");
                if (mysqli_num_rows($get_tag_token) > 0) 
                {
                    $get_token_result = mysqli_fetch_array($get_tag_token);
                    $user_id = $get_token_result['user_id'];
                    $update_tag_token = mysqli_query($dbconnection, "update ppa_tag_details set user_token='" . $result . "' where user_id='" . $user_id . "'");
                }
                $update_tag_token = mysqli_query($dbconnection, "update ppa_register set userToken='" . $result . "' where reg_id='" . $userToken['reg_id'] . "'");
            }
            //echo "select read_type from users where Org_code='" . $apptype . "' limit 0,1"; die;
            $getReadType = mysqli_query($dbconnection, "select read_type from ppa_register where ( username='" . $username . "' OR phone_no='" . $username . "') and apptype='" . $apptype . "'");
            //$getReadType = mysqli_query($dbconnection, "select read_type from users where Org_code='" . $apptype . "'");
            $ReadType = mysqli_fetch_array($getReadType);

            $data["status"] = 200;
            $data["message"] = "Login Successfully";
            $data["userId"] = $row["reg_id"];
            $data["deviceid"] = $row["device_id"];
            $data["version"] = $row["version"];
            $data["userToken"] = $result;
            //$data["userToken"] = $row["userToken"];
            $data["apptype"] = $row["apptype"];

            if ($row["latitude"] != "") {
                $data["latitude"] = $row["latitude"];
            } else {
                $data["latitude"] = "0";
            }

            if ($row["longitude"] != "") {
                $data["longitude"] = $row["longitude"];
            } else {
                $data["longitude"] = "0";
            }
            if ($row["usertype"] == 1) {
                $data["usertype"] = 'Admin';
            } else {
                $data["usertype"] = 'Member';
            }
            $data["username"] = $row["username"];
            $data["model"] = $row["model"];
            $data["phone_no"] = $row["phone_no"];

            $data["read_type"] = $ReadType['read_type'];

            if ($row["loftstatus"] == 1) {
                $data["loftstatus"] = '1';
            } else {
                $data["loftstatus"] = '0';
            }
            if ($row["profile_pic"] != '') {
                $data["profile_url"] = $SITEMAINURL . "uploads/" . $row["profile_pic"];
            } else {
                $data["profile_url"] = $SITEMAINURL . "uploads/no-image.png";
            }
            if ($row["android_id"] != "") {
                $data["android_id"] = $row["android_id"];
            } else {
                $data["android_id"] = "0";
            }
            $data["country"] = $row["country"];
            $data["language"] = isset($row["language"]) ? $row["language"] : "0";
            $data["notify_status"] = $row["notify_status"];
            $data["activestatus"] = $activeall;
            $data["accountstatus"] = $row["status"];
            $data["expirydate"] = $expirydate;
            $data["isCameraAllowed"] = $cameraAllowed;
            // $data["bluetooth_id"] = isset($row["bluetooth_id"]) ? $row["bluetooth_id"] : "";

            if (isset($row["bluetooth_id"])) 
            {
                $data["bluetooth_id"] = json_decode($row["bluetooth_id"]);
            } 
            else 
            {
                $data["bluetooth_id"] = null;
            }
            $action = "Logged In App";
            $desc = $data["username"] . " Logged in to the app Successfull";
            $userId = $data["userId"];
            entrylog($action,$desc, $userId,$dbconnection);
            echo json_encode($data);
            break;
        } 
        else 
        {
            $action = "Login Failure In App";
            $desc = $username . " Enter Incorrect username or password";
            $userId = "0";
            $data["status"] = 404;
            $data["message"] = "Incorrect username or password";
            entrylog($action,$desc, $userId,$dbconnection);
            echo json_encode($data);
            break;
        }
    } 
    else 
    {
        $data["status"] = 404;
        $data["message"] = "User does not exits ";
        echo json_encode($data);
        break;
    }
    break;

case 'ppapigeoncolor':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }

    $appType = $postdetails["apptype"];

    $getPigeonColor = mysqli_query($dbconnection, "select `ide`,`color` from pigeons_color where status='1' and apptype='".$appType."'");

    $pigeonColorCount = mysqli_num_rows($getPigeonColor);
    $i = 0;
    if (count($pigeonColorCount) > 0) 
    {
        while ($pigeoncolor = mysqli_fetch_array($getPigeonColor)) 
        {
            $data["pigeoncolor"][$i]["color"] = $pigeoncolor["color"];
            $i++;
        }
        $data["pigeon_color_count"] = $pigeonColorCount;
        $data["status"] = 200;
        $data["message"] = "Pigeon color successfully retrieved";
    } 
    else 
    {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
    }
    echo json_encode($data);
    break;

case 'ppagender':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }

    $userToken = $secureusertoken;
    $apptype = $postdetails["apptype"];
    $ringno = $postdetails["ringno"];
    $pigeonGender = $postdetails["gender"];

    // if ($apptype == "" || $ringno == "" || $pigeonGender == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }

    $getPigeonGender = mysqli_query($dbconnection, "select `gender` from pigeons where apptype='" . $apptype . "' and ringno='" . $ringno . "' and gender='" . $pigeonGender . "'");
    $pigeonGenderCount = mysqli_num_rows($getPigeonGender);

    if ($pigeonGenderCount == 1) {
        $pigeonGenderdetails = mysqli_fetch_array($getPigeonGender);
        $test123 = strcmp($pigeonGenderdetails["gender"], $pigeonGender);

        if (strcmp($pigeonGenderdetails["gender"], $pigeonGender) == 0) {
            $data["status"] = 200;
            $data["message"] = "Pigeon gender successfully retrieved";
        } else {
            $data["status"] = 404;
            $data["message"] = "Pigeon gender not specified";
        }
    } else {
        $data["status"] = 401;
        $data["message"] = "Input params not match";
    }
    echo json_encode($data);
    break;

case 'loftupdate': // Edit pending
    //$userToken = $postdetails["userToken"];
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }

    if (isset($_POST["latitude"]) && !empty($_POST["latitude"])) {
        $latitude = $_POST["latitude"];
    } else {
        $latitude = "0";
    }

    if (isset($_POST["longitude"]) && !empty($_POST["longitude"])) {
        $longitude = $_POST["longitude"];
    } else {
        $longitude = "0";
    }

    $apptype = $_POST["apptype"];

    //$deviceide = $_POST["deivce_id"];
    $phone_no = $_POST["phone_no"];

    $userToken = $secureusertoken;

    $path = "uploads/"; // Upload directory
    $count = 0;
    $loftprefix = $apptype . "_" . $phone_no . "_" . time();

    if ($_FILES['files']['error'] != 4 && !empty($_FILES['files'])) {
        // No error found! Move uploaded files
        $timeval = time();
        $path_parts = pathinfo($_FILES["files"]["name"]);
        $extension = $path_parts['extension'];
        $fancierinfo = mysqli_query($dbconnection, "select * from ppa_register where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' and loftstatus='0' limit 0,1");
        //echo "select * from ppa_register where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' and loftstatus='0' limit 0,1";die;

        $fancierCount = mysqli_num_rows($fancierinfo);
        if ($fancierCount == 1) {
            $fancierlist = mysqli_fetch_array($fancierinfo);
            $loft_image = "uploads/" . $fancierlist["loft_image"];

            if (file_exists($loft_image)) {
                @unlink($loft_image);
            }

            if (move_uploaded_file($_FILES["files"]["tmp_name"], $path . $loftprefix . $path_parts['basename'])) {
                $filespath = $loftprefix . $path_parts['basename'];
                // $update_qry = mysqli_query($dbconnection, "update ppa_register set latitude='" . $latitude . "',longitude='" . $longitude . "',loft_image='" . $filespath . "' where apptype='" . $apptype . "' and phone_no='" . $phone_no . "'");

                $update_qry = mysqli_query($dbconnection, "update ppa_register set latitude='" . $latitude . "',longitude='" . $longitude . "',loft_image='" . $filespath . "' where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' and userToken='".$userToken."'");

                $GetMyDeviceId = $fancierlist['android_id'];
                $android_deviceide = $fancierlist['android_id'];
                $apptype = $fancierlist['apptype'];
                $fancierphone_no = $fancierlist['phone_no'];
                $fancierusername = $fancierlist['username'];
                $userreg_id = $fancierlist['reg_id'];
                $badge = 1;
                $notify_key = 2;

                $title = "Loft update";
                $message = "Dear " . $fancierusername . " Loft details has been updated. Please check out!..";
                $pushparameter = '{"ResponseCode":"200","badge":"1"}';

                if (strlen($android_deviceide) == 64) {
                    $error_message = "Device token check!";
                    $log_file = "/portal/php_errorlog";
                    error_log($error_message, 3, $log_file);
                    sendIosPushNotification($dbconnection, $title, $message, $GetMyDeviceId, $pushparameter, $userreg_id, $notify_key, '');
                } else {
                    $pushparameter = "";
                    $badge = 1;
                    sendAnroidPushNotification($dbconnection, $title, $message, $android_deviceide, $pushparameter, $badge, $apptype, $userreg_id,$fancierphone_no);
                }

                $data["status"] = 200;
                $data["message"] = 'Loft details successfully updated';

                $action = "Loft update";
                $desc = $fancierusername . " Loft has been updated";
                $userId = $userreg_id;
                entrylog($action,$desc, $userId,$dbconnection);


                $data["usertoken"] = $secureusertoken;
                $data["latitude"] = $latitude;
                $data["longitude"] = $longitude;

                if (isset($data["latitude"]) && !empty($data["latitude"])) {
                    $data["latitude"] = $latitude;
                } else {
                    $data["latitude"] = "0";
                }

                if (isset($data["longitude"]) && !empty($data["longitude"])) {
                    $data["longitude"] = $longitude;
                } else {
                    $data["longitude"] = "0";
                }

                $data["loft_image"] = $SITEMAINURL . "uploads/" . $loftprefix . $path_parts['basename'];
                $data["photo_url"] = $SITEMAINURL . "uploads/" . $loftprefix . $path_parts['basename'];

                // echo "<pre>loft_image:";
                // print_r($data["loft_image"]);"</pre>";die;

            } else {
                //$update_qry = mysqli_query($dbconnection, "update ppa_register set latitude='" . $latitude . "', loft_image='', longitude='" . $longitude . "' where apptype='" . $apptype . "' and phone_no='" . $phone_no . "'");

                $update_qry = mysqli_query($dbconnection, "update ppa_register set latitude='" . $latitude . "', loft_image='', longitude='" . $longitude . "' where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' and userToken='".$userToken."'");

                $android_deviceide = $fancierlist['android_id'];
                $apptype = $fancierlist['apptype'];
                $fancierphone_no = $fancierlist['phone_no'];
                $fancierusername = $fancierlist['username'];
                $userreg_id = $fancierlist['reg_id'];
                $badge = 1;
                $notify_key = 2;

                $title = "Loft update";
                $message = "Dear " . $fancierusername . " Loft details has been updated. Please check out!..";
                $pushparameter = '{"ResponseCode":"200","badge":"1"}';

                if (strlen($android_deviceide) == 64) {
                    $error_message = "Device token check!";
                    $log_file = "/portal/php_errorlog";
                    error_log($error_message, 3, $log_file);
                    sendIosPushNotification($dbconnection, $title, $message, $android_deviceide, $pushparameter, $userreg_id, $notify_key, '');
                } else {
                    $pushparameter = "";
                    $badge = 1;
                    sendAnroidPushNotification($dbconnection, $message, $android_deviceide, $pushparameter, $badge, $apptype, $userreg_id, $notify_key, '');
                }

                $data["status"] = 200;
                $data["message"] = 'Loft details successfully updated';

                $action = "Loft update";
                $desc = $fancierusername . " Loft has been updated";
                $userId = $userreg_id;
                entrylog($action,$desc, $userId,$dbconnection);

                $data["usertoken"] = $secureusertoken;
                $data["latitude"] = $latitude;
                $data["longitude"] = $longitude;
                if (isset($data["latitude"]) && !empty($data["latitude"])) {
                    $data["latitude"] = $latitude;
                } else {
                    $data["latitude"] = "0";
                }

                if (isset($data["longitude"]) && !empty($data["longitude"])) {
                    $data["longitude"] = $longitude;
                } else {
                    $data["longitude"] = "0";
                }
                // $data["loft_image"] = $SITEMAINURL . "uploads/no-image.png";
                // $data["photo_url"] = $SITEMAINURL . "uploads/no-image.png";
                $data["loft_image"] = "";
                $data["photo_url"] = "";
            }
        } else {
            $data["status"] = 400;
            $data["latitude"] = $latitude;
            $data["longitude"] = $longitude;
            // $data["latitude"] = $fancierlist['latitude'];
            // $data["longitude"] = $fancierlist['longitude'];
            // $data["loft_image"] = $SITEMAINURL . "uploads/" . $fancierlist["loft_image"];
            $data["message"] = 'Loft details already updated in our system';

            $action = "Loft update";
            $desc = $fancierusername . " Loft already updated";
            $userId = $userreg_id;
            entrylog($action,$desc, $userId,$dbconnection);

            echo json_encode($data);
            break;
        }

    } else {
        // check now

        $loftStatusCheckQry = mysqli_query($dbconnection, "SELECT * FROM ppa_register WHERE loftstatus='1' and apptype='" . $apptype . "' and phone_no='" . $phone_no . "'");

        $checkQueryCount = mysqli_num_rows($loftStatusCheckQry);
        if ($checkQueryCount == 1) {

            $fancierlist = mysqli_fetch_array($loftStatusCheckQry);

            $data["status"] = 400;
            $data["latitude"] = $fancierlist['latitude'];
            $data["longitude"] = $fancierlist['longitude'];
            $data["loft_image"] = $SITEMAINURL . "uploads/" . $fancierlist["loft_image"];
            // echo "<pre>loft_image-2:";
            // print_r($data["loft_image"]);"</pre>";
            $data["message"] = 'Loft details already updated in our system';

            $action = "Loft update";
            $desc = $fancierusername . " Loft already updated";
            $userId = $userreg_id;
            entrylog($action,$desc, $userId,$dbconnection);

            echo json_encode($data);
            break;
        } else {
            // $update_qry = mysqli_query($dbconnection, "update ppa_register set latitude='" . $latitude . "',longitude='" . $longitude . "',loft_image='" . $loft_image . "' where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' and loftstatus='0'");

            $update_qry = mysqli_query($dbconnection, "update ppa_register set latitude='',longitude='',loft_image='' where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' and loftstatus='0'");

            $android_deviceide = $fancierlist['android_id'];
            $apptype = $fancierlist['apptype'];
            $fancierphone_no = $fancierlist['phone_no'];
            $fancierusername = $fancierlist['username'];
            $userreg_id = $fancierlist['reg_id'];
            $badge = 1;
            $notify_key = 2;

            $title = "Loft update";
            $message = "Dear " . $fancierusername . " Loft details has been updated. Please check out!..";
            $pushparameter = '{"ResponseCode":"200","badge":"1"}';

            if (strlen($android_deviceide) == 64) {
                $error_message = "Device token check!";
                $log_file = "/portal/php_errorlog";
                error_log($error_message, 3, $log_file);
                sendIosPushNotification($dbconnection, $title, $message, $android_deviceide, $pushparameter, $userreg_id, $notify_key, '');
            } else {
                $pushparameter = "";
                $badge = 1;
                sendAnroidPushNotification($dbconnection, $message, $android_deviceide, $pushparameter, $badge, $apptype, $userreg_id, $notify_key, '');
            }

            $data["status"] = 200;
            $data["message"] = 'Loft details successfully updated';

            $action = "Loft update";
            $desc = $fancierusername . " Loft has been updated";
            $userId = $userreg_id;
            entrylog($action,$desc, $userId,$dbconnection);

            $data["usertoken"] = $secureusertoken;
            $data["latitude"] = "0.0";
            $data["longitude"] = "0.0";

            // if (isset($data["latitude"]) && !empty($data["latitude"])) {
            //     $data["latitude"] = $latitude;
            // } else {
            //     $data["latitude"] = "0";
            // }

            // if (isset($data["longitude"]) && !empty($data["longitude"])) {
            //     $data["longitude"] = $longitude;
            // } else {
            //     $data["longitude"] = "0";
            // }

            // if ($data["longitude"] != '') {
            //     $data["latitude"] = $latitude;
            // } else {
            //     $data["longitude"] = "0";
            // }

            // if ($data["longitude"] != '') {
            //     $data["longitude"] = $longitude;
            // } else {
            //     $data["longitude"] = "0";
            // }

            // $data["loft_image"] = $SITEMAINURL . "uploads/no-image.png";
            // $data["photo_url"] = $SITEMAINURL . "uploads/no-image.png";

            // $data["loft_image"] = "";
            // $data["photo_url"] = "";

            if ($data["loft_image"] != '') {
                $data["loft_image"] = $SITEMAINURL . "uploads/" . $fancierlist["loft_image"];
            } else {
                $data["loft_image"] = "0";
            }
        }
    }
    echo json_encode($data);
    break;

case 'gallery': // Edit pending
    $userToken = $postdetails["userToken"];
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }

    $path = "uploads/"; // Upload directory
    //$count = 0;
    //$loftprefix = $apptype . "_" . $phone_no . "_" . time();
    if ($_FILES['files']['error'] != 4) {
        // No error found! Move uploaded files
        $path_parts = pathinfo($_FILES["files"]["name"]);
        $extension = $path_parts['extension'];
        $fancierinfo = mysqli_query($dbconnection, "select loft_image from ppa_register ");

        $fancierlist = mysqli_fetch_array($fancierinfo);
        $loft_image = "uploads/" . $fancierlist["loft_image"];
        $data["status"] = 200;
        $data["message"] = 'Gallery image list';
        $data["usertoken"] = $userToken;
        $data["loft_image"] = $SITEMAINURL . "uploads/" . $fancierlist["loft_image"];
    } else {
        $data["status"] = 404;
        $data["message"] = 'Gallery image not found';
        $data["usertoken"] = $userToken;
        $data["loft_image"] = $SITEMAINURL . "uploads/no-image.png";
    }
    echo json_encode($data);
    break;

case 'bird_filter':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $userToken = $secureusertoken;

    $raceId = $postdetails["raceid"];
    $birdtype = $postdetails["birdtype"];
    $fancierId = $postdetails["fancieride"];
    if (($raceId == "" || empty($raceId)) && ($fancierId == "" || empty($fancierId))) {
        $data["status"] = 404;
        $data["msg"] = "Required param is Null";
    }

    $getUser = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
    $checkUser = mysqli_num_rows($getUser);

    if ($checkUser == 1) {
        if ($raceId != "" && $fancierId != "") {
            $get_race_details = mysqli_query($dbconnection, "select * from ppa_basketing as a left join ppa_bird_type as b on a.bird_type=b.b_id where a.event_id ='" . $raceId . "' and a.fancier_id ='" . $fancierId . "' and a.bird_type='".$birdtype."' and a.admin_approval = '1'");
        } elseif ($raceId != "" && $fancierId == "") {
            $get_race_details = mysqli_query($dbconnection, "select * from ppa_basketing as a left join ppa_bird_type as b on a.bird_type=b.b_id where a.event_id ='" . $raceId . "' and a.bird_type='".$birdtype."' and a.admin_approval = '1'");
        }

        if (mysqli_num_rows($get_race_details) == 0) {
            $data["status"] = 400;
            $data["message"] = "No Details found";
        } else {
            // $birdFilterType = mysqli_num_rows($get_race_details);
            $i = 0;
            while ($race_details = mysqli_fetch_array($get_race_details)) {
                $data["details"][$i]["ringNo"] = $race_details["ring_no"];
                $data["details"][$i]["bird_name"] = $race_details["brid_type"];
                $data["details"][$i]["bird_type"] = $race_details["bird_type"];
                $data["details"][$i]["color"] = $race_details["color"];
                $data["details"][$i]["gender"] = $race_details["gender"];
                $data["details"][$i]["rubber_outer_no"] = $race_details["rubber_outer_no"];
                $data["details"][$i]["rubber_inner_no"] = $race_details["rubber_inner_no"];
                $data["details"][$i]["sticker_outer_no"] = $race_details["sticker_outer_no"];
                $data["details"][$i]["sticker_inner_no"] = $race_details["sticker_inner_no"];
                $data["details"][$i]["scanReader"] = $race_details["scanReader"];
                $data["status"] = 200;
                $data["message"] = "Bird details retrieved successfully";
                $i++;
            }
        }
    } else {
        $data["status"] = 404;
        $data["message"] = "No details found";
    }

    echo json_encode($data);
    break;

case 'reader_register':
    //$userToken = $postdetails["userToken"];
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $user_id = $postdetails["user_id"];
    $reader_id = $postdetails["reader_id"];
    //$reader_id = json_encode($reader_id);
    $deviceName = $reader_id['deviceName'];
    $macAddress = $reader_id['macAddress'];
    $deviceYear = $reader_id['deviceYear'];

    if ($reader_id == "" || $user_id == "") {
        $data["status"] = 400;
        $data["message"] = "Required param is Null";
        echo json_encode($data);
        break;
    }

    $getUser = mysqli_query($dbconnection, "select * from ppa_register where reg_id='" . $user_id . "' and userToken='" . $secureusertoken . "' limit 0,1");

    $checkUser = mysqli_num_rows($getUser);

    if ($checkUser == 1) {
        if ($deviceName != "") {
            $select_device = mysqli_query($dbconnection, "select * from ppa_register where deviceName='" . $deviceName . "'");
            $checkDevice = mysqli_num_rows($select_device);

            

            $getTokenDetail = mysqli_fetch_array($select_device);
            // echo "<pre>getTokenDetail:"; print_r($getTokenDetail); "</pre>"; die;

            if ($checkDevice == 1) {
                $data["status"] = 404;
                $data["message"] = "Device Id already registered";

                $username = $getTokenDetail['username'];

                $action = "Reader ID";
                $desc = $username . " given reader ID already registered in our system";
                
                $userId = $user_id;
                entrylog($action,$desc, $userId,$dbconnection);

            } else {
                $update_bluetooth_device = mysqli_query($dbconnection, "update ppa_register set bluetooth_id='" . json_encode($reader_id) . "',deviceName='" . $deviceName . "', macAddress ='" . $macAddress . "', deviceYear='" . $deviceYear . "' where reg_id='" . $user_id . "' and userToken='" . $secureusertoken . "'");

                //$update_bluetooth_device = mysqli_query($dbconnection, "update ppa_register set bluetooth_id='" . $reader_id . "',deviceName='" . $deviceName . "', macAddress ='" . $macAddress . "', deviceYear='" . $deviceYear . "' where reg_id='" . $user_id . "' and userToken='" . $secureusertoken . "'");


                $readerDevice = mysqli_query($dbconnection, "SELECT * FROM ppa_register where reg_id='" . $user_id . "'");
                $readerDetail = mysqli_fetch_array($readerDevice);
                $username = $readerDetail['username'];

                $data["message"] = 'Reader Id registered successfully';
                $data["status"] = 200;
                $data["usertoken"] = $secureusertoken;
                $data["user_id"] = $user_id;
                $data["reader_id"] = $reader_id;
                $data["username"] = $username;


                $action = "Reader ID";
                $username = $getTokenDetail['username'];
                $desc = $data["username"] . " the given Reader ID has been successfully registered in our system";
                $userId = $user_id;
                entrylog($action,$desc, $userId,$dbconnection);
            }
        } else {
            $update_bluetooth_device = mysqli_query($dbconnection, "update ppa_register set bluetooth_id='" . json_encode($reader_id) . "',deviceName='" . $deviceName . "', macAddress ='" . $macAddress . "', deviceYear='" . $deviceYear . "' where reg_id='" . $user_id . "' and userToken='" . $secureusertoken . "'");

            //$update_bluetooth_device = mysqli_query($dbconnection, "update ppa_register set bluetooth_id='" . $reader_id . "',deviceName='" . $deviceName . "', macAddress ='" . $macAddress . "', deviceYear='" . $deviceYear . "' where reg_id='" . $user_id . "' and userToken='" . $secureusertoken . "'");

            $data["message"] = 'Reader Id registered successfully';
            $data["status"] = 200;
            $data["usertoken"] = $secureusertoken;
            $data["user_id"] = $user_id;
            $data["reader_id"] = $reader_id;

            $action = "Reader ID";
            $desc = $data["username"] . " the given Reader ID has been successfully registered in our system";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);
        }

    } else {
        $data["status"] = 401;
        $data["message"] = "Incorrect user details";
    }
    echo json_encode($data);
    break;

case 'device_register':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $tag_id = $postdetails["tag_id"];
    $reader_id = $postdetails["reader_id"];
    //$reader_id = json_encode($reader_id);
    $deviceName = $reader_id["deviceName"];
    $macAddress = $reader_id['macAddress'];
    $deviceYear = $reader_id['deviceYear'];
    $userToken = $secureusertoken;

    $getBluetooth = mysqli_query($dbconnection, "select * from ppa_register where deviceName='" . $deviceName . "' and userToken='" . $userToken . "' limit 0,1");
    $getBluetoothQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");

    $checkDevice = mysqli_num_rows($getBluetooth);

    if ($checkDevice == 1) {
        $selectUser = mysqli_query($dbconnection, "select * from ppa_register where deviceName='" . $deviceName . "'");
        $getTokenDetail = mysqli_fetch_array($selectUser);
        $user_token = $getTokenDetail["userToken"];
        $user_id = $getTokenDetail["reg_id"];

        $checkTag = mysqli_query($dbconnection, "select * from ppa_tag_details where tag_id='" . $tag_id . "' and user_id='" . $user_id . "' and deviceName ='" . $deviceName . "' and tag_status = 1 ");
        //echo "<pre>"; print_r($checkTag); die;
        $checkTagRegister = mysqli_num_rows($checkTag);

        if ($checkTagRegister == 0) {
            // echo "string";die;
            $inserTagDetail = mysqli_query($dbconnection, "insert ppa_tag_details set user_id='" . $user_id . "',user_token='" . $secureusertoken . "',reader_id = '" . json_encode($reader_id) . "', deviceName ='" . $deviceName . "',macAddress ='" . $macAddress . "',deviceYear ='" . $deviceYear . "',tag_id='" . $tag_id . "'");
            $data["user_id"] = $user_id;
            $data["user_token"] = $secureusertoken;
            $data["reader_id"] = $reader_id;
            $data["tag_id"] = $tag_id;
            $data["status"] = 200;
            $data["message"] = "Tag details successfully registered";
            $username = $getTokenDetail['username'];
            $action = "Device Register";
            $desc = $username . " Tag details successfully registered in our system";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);

            echo json_encode($data);
            die;
        } else {
            $data["status"] = 400;
            $data["reader_id"] = $reader_id;
            $data["tag_id"] = $tag_id;
            $data["message"] = "Tag details already registered.";

            $username = $getTokenDetail['username'];
            $action = "Device Register";
            $desc = $username . " Tag details already registered in our system";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);

            echo json_encode($data);
            die;
        }
    } else {
        $data["status"] = 404;
        $data["message"] = "ReaderId not found";

        $getTokenDetail = mysqli_fetch_array($getBluetoothQuery);
        $username = $getTokenDetail["username"];
        $user_id = $getTokenDetail["reg_id"];


        $action = "Device Register";
        $desc = $username . " Given device details not found in system";
        $userId = $user_id;
        entrylog($action,$desc, $userId,$dbconnection);
    }
    echo json_encode($data);
    break;

case 'user_device_register':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }

    $userToken = $secureusertoken;
    $event_id = $postdetails["event_id"];
    $reader_id = $postdetails["reader_id"];
    //$reader_id = json_encode($reader_id);
    $deviceName = $reader_id['deviceName'];
    $macAddress = $reader_id['macAddress'];
    $deviceYear = $reader_id['deviceYear'];

    $tag_id = $postdetails["tag_id"];
    $latitude = $postdetails["latitude"];
    $longitude = $postdetails["longitude"];
    // $location = $postdetails["location"];
    $time = $postdetails["time"];

    // if ($tag_id == "" || $reader_id == "" || $location == "" || $time == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }

    $getBluetooth = mysqli_query($dbconnection, "select * from ppa_register where deviceName='" . $deviceName . "' and userToken='" . $userToken . "' limit 0,1");

    $getBluetoothQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");

    

    $checkDevice = mysqli_num_rows($getBluetooth);

    

    if ($checkDevice == 1) {
        $selectUser = mysqli_query($dbconnection, "select * from ppa_register where deviceName='" . $deviceName . "'");
        $getTokenDetail = mysqli_fetch_array($selectUser);
        $user_token = $getTokenDetail["userToken"];
        $user_id = $getTokenDetail["reg_id"];

        $checkTag = mysqli_query($dbconnection, "select * from ppa_tag_details where tag_id='" . $tag_id . "' and user_id='" . $user_id . "' and deviceName='" . $deviceName . "'");

        $checkTagRegister = mysqli_num_rows($checkTag);

        if ($checkTagRegister == 0) {
            $insert_user_device = mysqli_query($dbconnection, "insert ppa_tag_details set user_id='" . $user_id . "',user_token='" . $userToken . "', event_id='" . $event_id . "',reader_id = '" . json_encode($reader_id) . "', deviceName='" . $deviceName . "', macAddress='" . $macAddress . "', deviceYear='" . $deviceYear . "',tag_id='" . $tag_id . "', latitude='" . $latitude . "', longitude='" . $longitude . "', time='" . $time . "'");

            $data["user_id"] = $user_id;
            $data["event_id"] = $event_id;
            $data["user_token"] = $secureusertoken;
            //$data["reader_id"] = $reader_id;
            $data["reader_id"] = $reader_id;
            $data["tag_id"] = $tag_id;
            // $data["location"] = $location;
            $data["latitude"] = $latitude;
            $data["longitude"] = $longitude;
            $data["time"] = $time;
            $data["status"] = 200;
            $data["message"] = "User device and location successfully registered";

            $username = $getTokenDetail['username'];
            $action = "User Device Register";
            $desc = $username . " your device and location details successfully registered";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);

            echo json_encode($data);
            die;
        } else {
            $update_user_device = mysqli_query($dbconnection, "update ppa_tag_details set user_id='" . $user_id . "',user_token='" . $userToken . "',event_id='" . $event_id . "', reader_id = '" . json_encode($reader_id) . "', deviceName='" . $deviceName . "', macAddress='" . $macAddress . "', deviceYear='" . $deviceYear . "',tag_id='" . $tag_id . "',latitude='" . $latitude . "', longitude='" . $longitude . "', time='" . $time . "' where tag_id='" . $tag_id . "' and deviceName ='" . $deviceName . "'");
            $data["user_id"] = $user_id;
            $data["event_id"] = $event_id;
            $data["user_token"] = $secureusertoken;
            //$data["reader_id"] = $reader_id;
            $data["reader_id"] = $reader_id;
            $data["tag_id"] = $tag_id;
            // $data["location"] = $location;
            $data["latitude"] = $latitude;
            $data["longitude"] = $longitude;
            $data["time"] = $time;
            $data["status"] = 200;
            $data["message"] = "User device and location successfully updated";

            $username = $getTokenDetail['username'];
            $action = "User Device Register";
            $desc = $username . " your device and location details successfully registered";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);
            echo json_encode($data);
            die;
        }
    } else {
        $data["status"] = 404;
        $data["message"] = "ReaderId not found";

        $getTokenDetail = mysqli_fetch_array($getBluetoothQuery);
        $username = $getTokenDetail["username"];
        $user_id = $getTokenDetail["reg_id"];

        $action = "User Device Register";
        $desc = $username . " Given details not found in our system";
        $userId = $user_id;
        entrylog($action,$desc, $userId,$dbconnection);

    }
    echo json_encode($data);
    break;

case 'taglist_specific_reader':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $reader_id = $postdetails["reader_id"];
    //$reader_id = json_encode($reader_id);
    $deviceName = $reader_id["deviceName"];
    $macAddress = $reader_id['macAddress'];
    $deviceYear = $reader_id['deviceYear'];
    // if ($reader_id == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }

    $getBluetooth = mysqli_query($dbconnection, "select tag_id,time,location,deviceName,macAddress,deviceYear from ppa_tag_details  where deviceName='" . $deviceName . "'");
    $checkDevice = mysqli_num_rows($getBluetooth);
    $i = 0;
    if ($checkDevice > 0) {
        while ($checkDevice = mysqli_fetch_array($getBluetooth)) {
            $data["tag_id"][$i]["tag_id"] = $checkDevice["tag_id"];
            $data["tag_id"][$i]["time"] = $checkDevice["time"];
            $data["tag_id"][$i]["location"] = $checkDevice["location"];
            $data["tag_id"][$i]["reader_id"] = $checkDevice["deviceName"];
            $data["tag_id"][$i]["reader_id"] = $checkDevice["macAddress"];
            $data["tag_id"][$i]["reader_id"] = $checkDevice["deviceYear"];
            $data["status"] = 200;
            $i++;
        }
    } else {
        $data["status"] = 404;
        $data["message"] = "ReaderId not found";
    }
    echo json_encode($data);
    break;

case 'userprofile':
    // $userToken = $postdetails["userToken"];
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $userToken = $secureusertoken;
    //$selectfanciers = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "'");
    $selectfanciers = mysqli_query($dbconnection, "select a.*,b.Expire_date from ppa_register as a LEFT JOIN users as b on a.apptype=b.Org_code where a.userToken='" . $userToken . "'");
    $accdetails = mysqli_fetch_array($selectfanciers);

    // echo "<pre>accdetails:";
    // print_r($accdetails);"</pre>";

    // $getReadType = mysqli_query($dbconnection, "select read_type from ppa_register where userToken='" . $userToken . "'");
    $getReadType = mysqli_query($dbconnection, "select a.read_type from ppa_register as a LEFT JOIN users as b on a.apptype=b.Org_code where a.userToken='" . $userToken . "'");
    //$getReadType = mysqli_query($dbconnection, "select a.read_type from users as a LEFT JOIN ppa_register as b on a.Org_code=b.apptype where b.userToken='" . $userToken . "'");
    
    $ReadType = mysqli_fetch_array($getReadType);

    $data["userId"] = $accdetails["reg_id"];
    $data["username"] = $accdetails["username"];
    $data["deviceid"] = $accdetails["device_id"];
    $data["version"] = $accdetails["version"];
    $data["userToken"] = $accdetails["userToken"];
    if ($accdetails["latitude"] != "") {
        $data["latitude"] = $accdetails["latitude"];
    } else {
        $data["latitude"] = "0";
    }

    if ($accdetails["longitude"] != "") {
        $data["longitude"] = $accdetails["longitude"];
    } else {
        $data["longitude"] = "0";
    }
    $data["apptype"] = $accdetails["apptype"];
    if ($accdetails["usertype"] == 1) {
        $data["usertype"] = 'Admin';
    } else {
        $data["usertype"] = 'Member';
    }
    $data["username"] = $accdetails["username"];
    $data["model"] = $accdetails["model"];
    $data["phone_no"] = $accdetails["phone_no"];
    if ($accdetails["status"] == 1) {
        //$data["user_status"] = 'Active';
        $data["user_status"] = '1';
    } else {
        //$data["user_status"] = 'Inactive';
        $data["user_status"] = '0';
    }
    if ($accdetails["loftstatus"] == 1) {
        // $data["loftstatus"] = 'Active';
        $data["loftstatus"] = '1';
    } else {
        // $data["loftstatus"] = 'Inactive';
        // $data["loftstatus"] = '1';
        $data["loftstatus"] = '0';
    }
    if ($accdetails["profile_pic"] != '') {
        $data["profile_url"] = $SITEMAINURL . "uploads/" . $accdetails["profile_pic"];
    } else {
        //$data["profile_url"] = $SITEMAINURL . "uploads/no-image.png";
        $data["profile_url"] = "";
    }
    $data["android_id"] = $accdetails["android_id"];
    if ($data["android_id"] != "") {
        $data["android_id"] = $accdetails["android_id"];
    } else {
        $data["android_id"] = "0";
    }
    $data["country"] = $accdetails["country"];
    $data["language"] = $accdetails["language"];
    $data["notify_status"] = $accdetails["notify_status"];

    $data["read_type"] = $ReadType['read_type'];
    $data["activestatus"] = $activeall;
    $data["accountstatus"] = $accdetails["status"];
    $data["expirydate"] = $accdetails["Expire_date"] . " 00:00:00";
    //$data["expirydate"] = date("Y-m-d H:i:s", strtotime($accdetails["Expire_date"]));
    //echo "<pre>"; print_r($data["expirydate"]); die;
    // $data["expirydate"] = $expirydate;
    $data["isCameraAllowed"] = $cameraAllowed;

    // $data["bluetooth_id"] = $accdetails["bluetooth_id"];

    // if ($data["bluetooth_id"] != "") {
    //     $data["bluetooth_id"]["deviceName"] = $accdetails["deviceName"];
    //     $data["bluetooth_id"]["macAddress"] = $accdetails["macAddress"];
    //     $data["bluetooth_id"]["deviceYear"] = $accdetails["deviceYear"];
    // } else {
    //     $data["bluetooth_id"] = "";
    // }
    if (isset($accdetails["bluetooth_id"])) {
        $data["bluetooth_id"] = json_decode($accdetails["bluetooth_id"]);
    } else {
        $data["bluetooth_id"] = null;
    }

    // $data["bluetooth_id"]["deviceName"] = isset($accdetails["deviceName"]) ? $accdetails["deviceName"] : "";
    // $data["bluetooth_id"]["macAddress"] = isset($accdetails["macAddress"]) ? $accdetails["macAddress"] : "";
    // $data["bluetooth_id"]["deviceYear"] = isset($accdetails["deviceYear"]) ? $accdetails["deviceYear"] : "";
    $data["status"] = 200;
    $data["message"] = "Profile successfully retrived";
    $action = "User profile";
    $desc = $data["username"] . " profile retrived successfully";
    $userId = $data["userId"];
    entrylog($action,$desc, $userId,$dbconnection);
    echo json_encode($data);
    break;

case 'update_user_profile':
    //$userToken = $postdetails["userToken"];
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $user_id = $postdetails["user_id"];
    $user_token = $secureusertoken;
    $username = $postdetails["username"];
    $language = $postdetails["language"];
    $country = $postdetails["country"];

    $path = "uploads/";
    $count = 0;
    //$loftprefix = $apptype . "_" . $phone_no . "_" . time();
    $loftprefix = "profile_" . $phone_no . "_" . time();

    // if ($user_id == "" || $username == "" || $language == "" || $country == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }

    if ($_FILES['profile_image']['error'] != 4) {
        $timeval = time();
        $path_parts = pathinfo($_FILES["profile_image"]["name"]);
        $profilename = "profile_" . $secureusertoken . "_" . $timeval . "." . $path_parts['extension'];
        $extension = $path_parts['extension'];

        $userInfo = mysqli_query($dbconnection, "select profile_pic from ppa_register where userToken='" . $user_token . "' and reg_id='" . $user_id . "' limit 0,1");

        $checkUser = mysqli_num_rows($userInfo);
        if ($checkUser == 1) {
            $userData = mysqli_fetch_array($userInfo);
            $profile_image = "uploads/" . $userData["profile_pic"];

            echo "<pre>profile_image-1:"; print_r($profile_image); "</pre>";
            echo "<pre>profilename:"; print_r($profilename); "</pre>";

            if (file_exists($profile_image)) {
                @unlink($profile_image);
            }

            echo "<pre>profile_image-2:"; print_r($profile_image); "</pre>";
            echo "<pre>profilename-2:"; print_r($profilename); "</pre>";
            echo $path; die;

            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $path . $profilename)) {


                echo $_FILES["profile_image"]["tmp_name"];
                echo $path;
                echo $profilename; echo "ghghjghjjhrtjhghghjghjjhrtjh"; die;
                //$filespath = $loftprefix . $path_parts['basename'];
                // echo "<pre>filespath:";
                // print_r($filespath);"</pre>";die;

                $update_qry = mysqli_query($dbconnection, "update ppa_register set profile_pic='" . $profilename . "',language='" . $language . "',country='" . $country . "',username='" . $username . "' where userToken='" . $user_token . "' and reg_id='" . $user_id . "'");


                echo "update ppa_register set profile_pic='" . $profilename . "',language='" . $language . "',country='" . $country . "',username='" . $username . "' where userToken='" . $user_token . "' and reg_id='" . $user_id . "'"; die;

                $data["status"] = 200;
                $data["message"] = 'User profile successfully updated';
                $data["usertoken"] = $secureusertoken;
                $data["username"] = $username;
                $data["language"] = $language;
                $data["country"] = $country;
                $data["profile_image"] = $SITEMAINURL . "uploads/" . $profilename;

                $action = "Update user profile";
                $desc = $data["username"] . " your profile has been updated successfully";
                $userId = $user_id;
                entrylog($action,$desc, $userId,$dbconnection);

            } else {
                $data["status"] = 404;
                $data["message"] = 'Profile image not updated';
                $data["usertoken"] = $secureusertoken;

                $action = "Update user profile";
                $desc = $data["username"] . " your haven't update any profile image yet";
                $userId = $user_id;
                entrylog($action,$desc, $userId,$dbconnection);
            }

        } else {
            $data["status"] = 404;
            $data["message"] = 'User details not found';

            $action = "Update user profile";
            $desc = $data["username"] . " your details not found in our system ";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);
        }

    } else {
        $data["status"] = 404;
        $data["message"] = 'Profile image not updated successfully';

        $action = "Update user profile";
        $desc = $data["username"] . " your profile details updated successfully expect your image ";
        $userId = $user_id;
        entrylog($action,$desc, $userId,$dbconnection);
    }
    echo json_encode($data);
    break;

case 'racelistinfo':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $apptype = $postdetails["apptype"];
    date_default_timezone_set("Asia/Kolkata");
    $currdate = date('Y-m-d');
    $date = new DateTime($currdate); // For today/now, don't pass an arg.
    $date->modify("-3 day");
    $fromdate = $date->format("Y-m-d");
    $date2 = new DateTime($currdate);
    $date2->modify("+3 day");
    $todate = $date2->format("Y-m-d");

    // $fromdate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
    //$todate   = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $date) ) ));

    $select_races = mysqli_query($dbconnection, "select a.* from ppa_events as a LEFT JOIN users as b ON b.users_id=a.Org_id where b.Org_code='" . $apptype . "' and a.Event_date >= '" . $fromdate . "' and a.Event_date <= '" . $todate . "' order by a.Event_date DESC ");

    $i = 0;
    while ($race_res = mysqli_fetch_array($select_races)) {
        $data["race"][$i]["name"] = $race_res["Event_name"] . " ( " . $race_res["Event_name"] . " )";
        $data["race"][$i]["ide"] = $race_res["Events_id"];
        $i++;
    }
    echo json_encode($data);
    break;

case 'bird_type':
    $selectBirtType = mysqli_query($dbconnection, "select * from ppa_bird_type where bird_status='1'");
    $birtTypeCount = mysqli_num_rows($selectBirtType);
    $i = 0;
    if (count($birtTypeCount) > 0) {
        while ($birtTypeList = mysqli_fetch_array($selectBirtType)) {
            $data["birtTypeList"][$i]["bird_id"] = $birtTypeList["b_id"];
            $data["birtTypeList"][$i]["bird_type"] = $birtTypeList["brid_type"];
            $data["birtTypeList"][$i]["bird_status"] = $birtTypeList["bird_status"];
            $i++;
        }
        $data["club_count"] = $birtTypeCount;
        $data["status"] = 200;
        $data["message"] = "Bird Type successfully retrived";
    } else {
        $data["status"] = 404;
        $data["message"] = "Bird Type not found";
    }
    echo json_encode($data);
    break;

case 'bird_type_list_old':
    $event_id = $postdetails["raceid"];
    $fancierID = $postdetails["userid"];

    // $selectBirtType = mysqli_query($dbconnection, "select * from ppa_basketing where event_id = '" . $event_id . "' and fancier_id = '" . $fancierID . "'");

    // $selectBirtType = mysqli_query($dbconnection, "SELECT a.bird_type,b.brid_type FROM ppa_basketing as a LEFT JOIN ppa_bird_type as b on a.bird_type=b.b_id WHERE a.event_id = '" . $event_id . "' and a.fancier_id = '" . $fancierID . "' group by a.bird_type");

    $selectBirtType = mysqli_query($dbconnection, "SELECT bird_type FROM ppa_basketing  WHERE event_id = '" . $event_id . "' and fancier_id = '" . $fancierID . "' group by bird_type");

    // $bType = array();
    // foreach ($selectBirtType as $BirdType) {
    //     $birdID = $BirdType['bird_type'];
    //     $raceBirdType = mysqli_query($dbconnection, "SELECT brid_type FROM ppa_bird_type  WHERE b_id = '" . $birdID . "'");
    //     array_push($bType, $raceBirdType);
    // }
    // $bTypearr = $bType;

    $birdType = mysqli_num_rows($selectBirtType);

    $i = 0;
    if (count($birdType) > 0) {
        while ($birdList = mysqli_fetch_array($selectBirtType)) {
            $data["birdList"][$i]["birdname"] = $birdList["brid_type"];
            $data["birdList"][$i]["birdcode"] = $birdList["bird_type"];
            $i++;
        }
        $data["bird_count"] = $birdType;
        $data["status"] = 200;
        $data["message"] = "Bird List successfully retrieved";
    } else {
        $data["status"] = 404;
        $data["message"] = "Bird list not found";
    }
    echo json_encode($data);
    break;

case 'bird_type_list':
    $authuser = checkauth($dbconnection, $secureusertoken);
    //echo "<pre>"; print_r($authuser); die;
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $event_id = $postdetails["raceid"];
    $fancierID = $postdetails["userid"];

    $checkuserauth = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $secureusertoken . "' and reg_id='" . $fancierID . "' limit 0,1");

    $userData = mysqli_num_rows($checkuserauth);

    if ($userData > 0) {
        // $selectBirtType = mysqli_query($dbconnection, "SELECT a.bird_type,b.brid_type FROM ppa_basketing as a LEFT JOIN ppa_bird_type as b on a.bird_type=b.b_id LEFT JOIN ppa_event_details as c on a.event_id=c.event_id WHERE a.event_id = '" . $event_id . "' and a.fancier_id = '" . $fancierID . "' group by a.bird_type");

        //echo "SELECT * from ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN ppa_bird_type as c on a.bird_id=c.b_id WHERE a.event_id='" . $event_id . "'group by a.bird_id"; die;

        $selectBirtType = mysqli_query($dbconnection, "SELECT * from ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN ppa_bird_type as c on a.bird_id=c.b_id WHERE a.event_id='" . $event_id . "'group by a.bird_id");

        // echo "SELECT * from ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN ppa_bird_type as c on a.bird_id=c.b_id WHERE a.event_id='" . $event_id . "'group by a.bird_id"; die;

        $birdType = mysqli_num_rows($selectBirtType);
        $i = 0;
        if ($birdType > 0) {
            while ($birdList = mysqli_fetch_array($selectBirtType)) {
                $data["birdList"][$i]["birdname"] = $birdList["brid_type"];
                $data["birdList"][$i]["birdcode"] = $birdList["b_id"];
                $data["birdList"][$i]["bird_tag_color"] = $birdList["bird_tag_color"];
                $i++;
            }
            $data["bird_count"] = $birdType;
            $data["status"] = 200;
            $data["message"] = "Bird List successfully retrieved";
        } else {
            $data["status"] = 404;
            $data["message"] = "Bird list not found";
        }
        echo json_encode($data);
    } else {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    break;

case 'addpigeon':
    //$userToken = $postdetails["userToken"];
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    error_reporting(-1);
    ini_set('display_errors', 1);
    $apptype = $postdetails["apptype"];
    $owner_id = $postdetails["user_id"];
    //$fancier_id = $postdetails["fancier_id"];
    $userType = $postdetails["usertype"];
    $userToken = $secureusertoken;


    if ($userType == "Member") {
        $ringno = $postdetails["ringno"];
        $color = $postdetails["color"];
        $gender = $postdetails["gender"];
        $bird_type = $postdetails["bird_type"];
        $phone_no = $postdetails["phone_no"];
        $race_id = $postdetails["raceId"];
        $scanReader = "";
        $owner_id = $postdetails["user_id"];
        $update_date = date("Y-m-d H:i:s");
        $adminApproval = 0;

    } else {
        $ringno = $postdetails["ringno"];
        $color = $postdetails["color"];
        $gender = $postdetails["gender"];
        $bird_type = $postdetails["bird_type"];
        $phone_no = $postdetails["phone_no"];
        $race_id = $postdetails["raceId"];
        $scanReader = $postdetails["scanReader"];
        $update_date = date("Y-m-d H:i:s");
        $adminApproval = 1;
        $owner_id = $postdetails["fancier_id"];
    }

    if ($userType == "Member") {
        if ($apptype == "" || $bird_type == "" || $ringno == "" || $color == "" || $gender == "" || $phone_no == "" || $owner_id == "" || $race_id == "") {
            $data["status"] = 400;
            $data["message"] = "Required param is Null";
            echo json_encode($data);
            break;
        }
    } else {
        if ($apptype == "" || $bird_type == "" || $ringno == "" || $color == "" || $gender == "" || $phone_no == "" || $race_id == "" || $owner_id == "") {
            $data["status"] = 400;
            $data["message"] = "Required param is Null";
            echo json_encode($data);
            break;
        }
    }

    $check_race = mysqli_query($dbconnection, "select Event_date,Eventend_date,start_time,end_time from ppa_events as eve LEFT JOIN ppa_event_details as evt_d ON eve.Events_id=evt_d.event_id where Events_id='" . $race_id . "'");
    
    if(mysqli_num_rows($check_race) > 0){
        $Race_details = mysqli_fetch_array($check_race);
    
        $start_date = $Race_details["Event_date"].' '.$Race_details["start_time"];
        $start_date = strtotime($start_date);

        $end_date = $Race_details["Eventend_date"].' '.$Race_details["end_time"];
        $end_date = strtotime($end_date);

        // $curDate = date("Y-m-d");
        $curDate = date("Y-m-d h:i A");
        if ($start_date <= strtotime($curDate) && $end_date >= strtotime($curDate)) {
            $data["status"] = 404;
            $data["message"] = "You can't basket bird now since the race is live or completed.";
            echo json_encode($data);
            break;
            //$cateDate['race_status'] = "LIVE";
        } else if($end_date < strtotime($curDate)) {
            $data["status"] = 404;
            $data["message"] = "You can't basket bird now since the race is live or completed.";
            echo json_encode($data);
            break;
            //$cateDate['race_status'] = "Completed";
        }
    }

    // $checkqry = mysqli_query($dbconnection, "select * from pigeons where apptype='" . $apptype . "' and ringno='" . $ringno . "' and mobile_no='" . $phone_no . "'");
    // John sir
    //$checkqry = mysqli_query($dbconnection, "select * from pigeons where apptype='" . $apptype . "' and ringno='" . $ringno . "' and race_id='".$race_id."'");
    $checkqry = mysqli_query($dbconnection, "select * from pigeons as a left join ppa_basketing as b on a.race_id=b.event_id where a.apptype='" . $apptype . "' and a.ringno='" . $ringno . "' and a.race_id='".$race_id."'");
    

    // select * from pigeons as a left join ppa_basketing as b on a.race_id=b.event_id where a.apptype='ppa' and a.ringno='565465461125' and a.race_id='1163'
    
    if ($userType == "Admin") {

        //$get_scanner_id = mysqli_query($dbconnection, "select * from ppa_basketing as a left join ppa_register as b on a.fancier_id=b.reg_id where a.org_code='" . $apptype . "' and a.event_id='".$race_id."' and b.read_type='1'");

        
        //$get_scanner_id = mysqli_query($dbconnection, "select * from ppa_basketing where org_code='" . $apptype . "' and scanReader='" . $scanReader . "' and event_id='".$race_id."'");

        $get_scanner_id = 0;
        if(isset($scanReader) && !empty($scanReader))
        {
            // $get_scanner_id = mysqli_query($dbconnection, "select * from ppa_basketing where org_code='" . $apptype . "' and scanReader='" . $scanReader . "' and event_id='".$race_id."'");
            
            $get_scanner_id = mysqli_query($dbconnection, "select * from ppa_basketing as a left join ppa_register as b on a.fancier_id=b.reg_id where a.org_code='".$apptype."' and a.event_id='".$race_id."' and a.scanReader='' and a.ring_no='".$ringno."' and b.read_type='0'");
            echo "<pre>get_scanner_id:-1"; print_r("select * from ppa_basketing as a left join ppa_register as b on a.fancier_id=b.reg_id where a.org_code='".$apptype."' and a.event_id='".$race_id."' and a.scanReader='' and a.ring_no='".$ringno."' and b.read_type='0'"); "</pre>";
        }else{
            //$get_scanner_id = mysqli_query($dbconnection, "select * from ppa_basketing as a left join ppa_register as b on a.fancier_id=b.reg_id where a.org_code='" . $apptype . "' and a.event_id='".$race_id."' and b.read_type='1'");

            $get_scanner_id = mysqli_query($dbconnection, "select * from ppa_basketing as a left join ppa_register as b on a.fancier_id=b.reg_id where a.org_code='".$apptype."' and a.event_id='".$race_id."' and a.scanReader='".$scanReader."' and a.ring_no='".$ringno."' and b.read_type='1'");
            echo "<pre>get_scanner_id:-2"; print_r("select * from ppa_basketing as a left join ppa_register as b on a.fancier_id=b.reg_id where a.org_code='".$apptype."' and a.event_id='".$race_id."' and a.scanReader='".$scanReader."' and a.ring_no='".$ringno."' and b.read_type='1'"); "</pre>";
        }



        if (mysqli_num_rows($get_scanner_id) > 0) {
        $data["status"] = 404;
        $data["message"] = "You can't same RFID for same race.";
        echo json_encode($data);
        break;
        }
    }


    // Kumaran
    //$checkqry = mysqli_query($dbconnection, "select * from ppa_basketing where org_code='" . $apptype . "' and ring_no='" . $ringno . "' and event_id='".$race_id."'");

    // select * from pigeons as a LEFT JOIN ppa_register as b ON a.owner_id=b.reg_id where a.apptype='PPA' and a.ringno='1210202097' and b.usertype='1' limit 0,1
    if (mysqli_num_rows($checkqry) == 0) {
        $insert_qry = mysqli_query($dbconnection, "insert pigeons set bird_type='" . $bird_type . "',mobile_no='" . $phone_no . "',ringno='" . $ringno . "',color='" . $color . "',owner_id='" . $owner_id . "',gender='" . $gender . "',apptype='" . $apptype . "',race_id='" . $race_id . "',cre_date='" . $update_date . "'");

        $ide = mysqli_insert_id($dbconnection);

        $eventdetailsid = mysqli_query($dbconnection, "select ed_id from ppa_event_details where event_id='" . $race_id . "' and bird_id='" . $bird_type . "' limit 0,1");
        // select ed_id from ppa_event_details where event_id='1037' and bird_id='2' limit 0,1

        $e_details_id = mysqli_fetch_array($eventdetailsid);
        $ed_id = $e_details_id["ed_id"];

        if ($ed_id) {

            $insert_basketing_qry = mysqli_query($dbconnection, "insert ppa_basketing set event_id ='" . $race_id . "',event_details_id='" . $ed_id . "',fancier_id='" . $owner_id . "',org_code='" . $apptype . "',ring_no='" . $ringno . "',admin_approval='" . $adminApproval . "',bird_type='" . $bird_type . "',color='" . $color . "',gender='" . $gender . "',update_date='" . $update_date . "', scanReader='" . $scanReader . "'");
            $data["status"] = 200;
            $data["message"] = "Bird added successfully.";
        } else {
            $data["status"] = 404;
            $data["message"] = "No record found for the given event.";
        }

    } else {
        if ($userType == "Admin") {
        $ScannerId = mysqli_fetch_array($checkqry);

            if($ScannerId['scanReader'] == "" || empty($ScannerId['scanReader']))
            {

               $updateRaceEntry = mysqli_query($dbconnection, "update ppa_basketing set scanReader='" . $scanReader . "' where org_code='" . $apptype . "' and ring_no='" . $ringno . "' and event_id='".$race_id."'");
                $data["status"] = 200;
                $data["message"] = "Bird updated successfully.";
                echo json_encode($data);
                break;
            }
        }else{
            $ide = 0;
            $data["status"] = 401;
            $data["message"] = "Ringno : " . $ringno . " already available in our system. Contact admin for further";
            echo json_encode($data);
            break;
        }
    }

    if ($ide != 0) {
        $data["status"] = 200;
        $data["message"] = "Bird added successfully";
        echo json_encode($data);
        break;
    } else {
        $data["status"] = 404;
        $data["message"] = "Error in inserting bird";
        echo json_encode($data);
        break;
    }

    echo json_encode($data);
    break;

case 'scanreader':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }

    $scanReader = $postdetails["scanReader"];

    // $scanReader = json_encode($scanReader);
    // echo "<pre>scanReader"; print_r($scanReader); "</pre>";
    // $deviceName = $reader_id['deviceName'];
    // $macAddress = $reader_id['macAddress'];
    // $deviceYear = $reader_id['deviceYear'];

    $userToken = $secureusertoken;

    $checkuserauth = mysqli_query($dbconnection, "select fancier_id from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id=b.reg_id where a.scanReader='" . $scanReader . "' and b.userToken='" . $userToken . "'");

    // select fancier_id from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id=b.reg_id where a.scanReader='ADF4321' and b.userToken='ec09ff7bf73e82b830c5a784d5f3ca44'

    $userData = mysqli_num_rows($checkuserauth);
    if ($userData > 0) {
        $readerQuery = mysqli_query($dbconnection, "select * from ppa_basketing as a INNER JOIN ppa_events as b ON a.event_id=b.Events_id LEFT JOIN ppa_bird_type as c ON a.bird_type=c.b_id LEFT JOIN ppa_register as d ON a.fancier_id=d.reg_id
        where scanReader='" . $scanReader . "' ");

        // select * from ppa_basketing as a LEFT JOIN ppa_events as b ON a.event_id=b.Events_id LEFT JOIN ppa_bird_type as c ON a.bird_type=c.b_id LEFT JOIN ppa_register as d ON a.fancier_id=d.reg_id
        //     where scanReader='ADF4321'

        $readerDetails = mysqli_fetch_array($readerQuery);
        $readercount = mysqli_num_rows($readerQuery);
        if ($readercount > 0) {
            $data["event_id"] = $readerDetails["event_id"];
            $data["admin_approval"] = $readerDetails["admin_approval"];
            $data["fancier_id"] = $readerDetails["fancier_id"];
            $data["org_code"] = $readerDetails["org_code"];
            $data["ring_no"] = $readerDetails["ring_no"];
            $data["bird_type"] = $readerDetails["bird_type"];
            $data["color"] = $readerDetails["color"];
            $data["gender"] = $readerDetails["gender"];
            $data["race_name"] = $readerDetails["Event_name"];
            $data["category_name"] = $readerDetails["brid_type"];
            $data["fancier_name"] = $readerDetails["username"];
            // $data["scanReader"] = json_decode($scanReader);
            $data["status"] = 200;
            $data["message"] = "Reader info retrieved";
            echo json_encode($data);
            break;
        } else {
            $data["status"] = 404;
            $data["message"] = "Reader info not retrieved";
            echo json_encode($data);
            break;
        }
    } else {
        $data["status"] = 404;
        $data["message"] = "Reader data not found";
        echo json_encode($data);
        break;
    }
    break;

// case 'raceapprove':
//     $authuser = checkauth($dbconnection, $secureusertoken);
//     if ($authuser == "0" || $authuser == "") {
//         $data["status"] = 401;
//         $data["message"] = "Authentication failed";
//         echo json_encode($data);
//         break;
//     }

//     $entryID = $postdetails["entry_id"];
//     $approveStatus = $postdetails["admin_approval"];
//     $userToken = $secureusertoken;

//     $getEntryId = mysqli_query($dbconnection, "select * from ppa_basketing where entry_id='" . $entryID . "' limit 0,1");

//     $EntryDetails = mysqli_fetch_array($getEntryId);
//     $racecount = mysqli_num_rows($getEntryId);

//     if ($racecount >= 1) {
//         if ($approveStatus != 0) {
//             if ($EntryDetails["admin_approval"] == 1) {
//                 $data["status"] = 404;
//                 $data["message"] = "Admin already approved the Bird";
//                 echo json_encode($data);
//                 break;
//             }
//         }

//         $updateRaceEntry = mysqli_query($dbconnection, "update ppa_basketing set admin_approval='" . $approveStatus . "' where entry_id='" . $entryID . "'");
//         $data["status"] = 200;
//         if ($approveStatus == 1) {
//             $data["message"] = "Admin approved the Bird";
//         } else {
//             $data["message"] = "Admin Denied the approval";
//         }
//     } else {
//         $data["status"] = 404;
//         $data["message"] = "Basketing not found for the given event";
//     }
//     echo json_encode($data);
//     break;

case 'raceapprove':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $entryID = $postdetails["entry_id"];
    $approveStatus = $postdetails["admin_approval"];
    $scanReader = $postdetails["scanReader"];
    $userToken = $secureusertoken;

    $checkuserauth = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' and usertype='1'");
    $userData = mysqli_num_rows($checkuserauth);
    if ($userData > 0) {
        $getEntryId = mysqli_query($dbconnection, "select * from ppa_basketing where entry_id='" . $entryID . "' limit 0,1");
        $EntryDetails = mysqli_fetch_array($getEntryId);
        $racecount = mysqli_num_rows($getEntryId);

        if ($racecount > 0) {
            if ($approveStatus != 0) {
                if ($EntryDetails["admin_approval"] == 1 && $EntryDetails["scanReader"] != "") {
                    $data["status"] = 404;
                    $data["message"] = "Admin already approved the Bird";
                    echo json_encode($data);
                    break;
                }
            }

            $updateRaceEntry = mysqli_query($dbconnection, "update ppa_basketing set admin_approval='" . $approveStatus . "' , scanReader='" . $scanReader . "' where entry_id='" . $entryID . "'");
            $data["status"] = 200;
            if ($approveStatus == 1) {
                $data["message"] = "Admin approved the Bird";

                $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
                $entryLogDetail = mysqli_fetch_array($entrylogQuery);
                $username = $entryLogDetail["username"];
                $user_id = $entryLogDetail["reg_id"];
                $action = "raceapprove";
                $desc = $username . " Admin has approved the bird";
                $userId = $user_id;
                entrylog($action,$desc, $userId,$dbconnection);


                echo json_encode($data);
                break;
            } else {
                $data["message"] = "Admin Denied the approval";

                $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
                $entryLogDetail = mysqli_fetch_array($entrylogQuery);
                $username = $entryLogDetail["username"];
                $user_id = $entryLogDetail["reg_id"];
                $action = "raceapprove";
                $desc = $username . " Admin has denied the bird approval";
                $userId = $user_id;
                entrylog($action,$desc, $userId,$dbconnection);

                echo json_encode($data);
                break;
            }
        } else {
            $data["status"] = 404;
            $data["message"] = "Basketing not found for the given event";

            $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
            $entryLogDetail = mysqli_fetch_array($entrylogQuery);
            $username = $entryLogDetail["username"];
            $user_id = $entryLogDetail["reg_id"];
            $action = "raceapprove";
            $desc = $username . " Basketing not found for the given event";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);

            echo json_encode($data);
            break;
        }
    } else {
        $data["status"] = 401;
        $data["message"] = "Access not granted. Only Admin can approve the race";

        $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
        $entryLogDetail = mysqli_fetch_array($entrylogQuery);
        $username = $entryLogDetail["username"];
        $user_id = $entryLogDetail["reg_id"];
        $action = "raceapprove";
        $desc = $username . " Access not granted. Only Admin can approve the race";
        $userId = $user_id;
        entrylog($action,$desc, $userId,$dbconnection);

        echo json_encode($data);
        break;
    }
    break;

case 'getusers':
    $apptype = $_GET["apptype"];
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $data["url"] = $SITEMAINURL . "admin/app/user.php?club_type=" . $apptype;
    $data["activestatus"] = $activeall;
    $data["expirydate"] = $expirydate;
    $data["isCameraAllowed"] = $cameraAllowed;
    echo json_encode($data);
    break;

// case 'racelist':
//     $authuser = checkauth($dbconnection, $secureusertoken);
//     if ($authuser == "0" || $authuser == "") {
//         $data["status"] = 401;
//         $data["message"] = "Authentication failed";
//         echo json_encode($data);
//         break;
//     }
//     // $userToken = $postdetails["userToken"];
//     $apptype = $postdetails["apptype"];

//     $query = mysqli_query($dbconnection, "SELECT * FROM ppa_events AS A LEFT JOIN users AS B ON A.Org_id=B.users_id LEFT JOIN ppa_event_details AS C ON A.Events_id=C.event_id INNER JOIN ppa_bird_type AS D ON C.bird_id=D.b_id where B.Org_code='PPA' ORDER BY Event_date DESC");

//     $racecount = mysqli_num_rows($query);
//     if ($racecount > 0) {
//         $i = 0;
//         while ($res = mysqli_fetch_array($query)) {
//             $data["racelist"]["start_date"] = $res["date"];
//             $data["racelist"]["end_date"] = $res["End_date"];
//             $data["racelist"]["start_time"] = $res["start_time"];
//             $data["racelist"]["end_time"] = $res["end_time"];
//             $data["racelist"]["race_ide"] = $res["Events_id"];
//             $data["racelist"]["race_name"] = $res["Event_name"];
//             $data["racelist"]["race_date"] = $res["Event_date"];
//             $data["racelist"]["race_status"] = $res["Event_status"];
//             $data["racelist"]['category'][$i]["bird_id"] = $res["b_id"];
//             $data["racelist"]['category'][$i]["brid_type"] = $res["brid_type"];
//             $i++;
//         }
//         //$result = array("race_count" => $racecount, "message" => "Race count for this club");
//         $data["race_count"] = $racecount;
//         $data["message"] = "Race count for this club";
//         $data["status"] = 200;
//     } else {
//         //$result = array("race_count" => $racecount, "message" => "No race found for this club");
//         $data["race_count"] = $racecount;
//         $data["message"] = "No race found for this club";
//         $data["status"] = 404;
//         $data["result"] = $result;
//     }
//     echo json_encode($data);
//     break;

case 'racelist':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    // $userToken = $postdetails["userToken"];
    $apptype = $postdetails["apptype"];

    // $query = mysqli_query($dbconnection, "SELECT * FROM ppa_events AS A LEFT JOIN users AS B ON A.Org_id=B.users_id LEFT JOIN ppa_event_details AS C ON A.Events_id=C.event_id INNER JOIN ppa_bird_type AS D ON C.bird_id=D.b_id where B.Org_code='" . $apptype . "' ORDER BY Event_date DESC");

    // echo "SELECT * FROM ppa_events AS A LEFT JOIN users AS B ON A.Org_id=B.users_id LEFT JOIN ppa_event_details AS C ON A.Events_id=C.event_id INNER JOIN ppa_bird_type AS D ON C.bird_id=D.b_id where B.Org_code='" . $apptype . "' ORDER BY Event_date DESC";

    $query = mysqli_query($dbconnection, "SELECT * FROM ppa_events AS A LEFT JOIN users AS B ON A.Org_id=B.users_id LEFT JOIN ppa_event_details AS C ON A.Events_id=C.event_id INNER JOIN ppa_bird_type AS D ON C.bird_id=D.b_id where B.Org_code='" . $apptype . "' GROUP BY Event_date DESC");

    $racecount = mysqli_num_rows($query);
    if ($racecount > 0) {
        $i = 0;
        while ($res = mysqli_fetch_array($query)) {
            $data["racelist"][$i]["race_ide"] = $res["Events_id"];
            $data["racelist"][$i]["race_name"] = $res["Event_name"];
            $data["racelist"][$i]["race_date"] = $res["Event_date"];
            $data["racelist"][$i]["race_status"] = $res["Event_status"];
            $data["racelist"][$i]["bird_id"] = $res["b_id"];
            $data["racelist"][$i]["brid_type"] = $res["brid_type"];
            $i++;
        }
        $result = array("race_count" => $racecount, "message" => "Race count for this club");
        $data["race_count"] = $racecount;
        $data["message"] = "Race count for this club";
        $data["status"] = 200;
    } else {
        $data["race_count"] = $racecount;
        $data["message"] = "Race count for this club";
        $data["status"] = 200;
    }
    echo json_encode($data);
    break;

case 'basketinfo':
    $authuser = checkauth($dbconnection, $secureusertoken);
    /* if($authuser=="0" || $authuser=="")
    {
    $data["status"]=404;
    $data["msg"]="Authentication failed";
    echo json_encode($data);
    break;
     */

    $eventide = $postdetails["event_id"];
    $apptype = $postdetails["apptype"];
    $birdtype = mysqli_query($dbconnection, "SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type ,ed_id, race_distance , event_id  FROM `ppa_event_details` INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id where ppa_event_details.event_id='" . $eventide . "' group by ppa_event_details.bird_id,ppa_event_details.race_distance");
    $i = 0;

    $data["event_id"] = $postdetails["event_id"];

    while ($birdinfo = mysqli_fetch_array($birdtype)) {
        $data["birdinfo"][$i]["value"] = $birdinfo["b_id"] . "#" . $birdinfo["ed_id"];
        $data["birdinfo"][$i]["text"] = $birdinfo["race_distance"] . " Km - " . $birdinfo["brid_type"];
        $i++;
    }

    $birdcolorinfo = mysqli_query($dbconnection, "select * from pigeons_color");
    $i = 0;
    while ($birdcolinfo = mysqli_fetch_array($birdcolorinfo)) {
        $data["birdcolor"][$i] = $birdcolinfo["color"];
        $i++;
    }

    $fancierinfo = mysqli_query($dbconnection, "select * from ppa_register where apptype='" . $apptype . "'");
    $i = 0;
    while ($fancierlist = mysqli_fetch_array($fancierinfo)) {
        $data["fancierinfo"][$i]["useride"] = $fancierlist["reg_id"];
        $data["fancierinfo"][$i]["username"] = $fancierlist["username"];
        $i++;
    }
    echo json_encode($data);
    break;

case 'viewbasketinfo':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $eventide = $postdetails["event_id"];
    $apptype = $postdetails["apptype"];
    $birdtype = $postdetails["birdtype"];
    $approval = $postdetails["admin_approval"];
    $fancierId = $postdetails["fancieride"];

    if (isset($fancierId)) {
        $fancier = " and a.fancier_id='" . $fancierId . "'";
    } else {
        $fancier = "";
    }

    // if ($apptype == "" || $eventide == "" || $birdtype == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }

    // $basketquery = mysqli_query($dbconnection, "select a.entry_id,a.fancier_id,b.username,a.ring_no,a.color,a.gender,c.brid_type,f.race_distance from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id = b.reg_id LEFT JOIN ppa_bird_type as c ON c.b_id=a.bird_type LEFT JOIN ppa_event_details as d ON d.ed_id = a.event_id LEFT JOIN ppa_events as e ON d.event_id = a.event_id LEFT JOIN ppa_event_details as f ON f.ed_id=a.event_details_id where a.event_id='" . $eventide . "'" . $fancier . "");

    $basketquery = mysqli_query($dbconnection, "select a.admin_approval, a.entry_id, a.fancier_id, a.event_id, b.username, a.ring_no, a.color, a.gender, c.brid_type, f.race_distance, a.scanReader, a.org_code, a.bird_type, e.Event_name from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id = b.reg_id LEFT JOIN ppa_bird_type as c ON c.b_id=a.bird_type LEFT JOIN ppa_event_details as d ON d.ed_id = a.event_id LEFT JOIN ppa_events as e ON e.Events_id = a.event_id LEFT JOIN ppa_event_details as f ON f.ed_id=a.event_details_id where a.event_id='" . $eventide . "'" . $fancier . " and a.bird_type='" . $birdtype . "'");

    // echo "select a.admin_approval, a.entry_id, a.fancier_id, a.event_id, b.username, a.ring_no, a.color, a.gender, c.brid_type, f.race_distance, a.scanReader, a.org_code, a.bird_type, e.Event_name from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id = b.reg_id LEFT JOIN ppa_bird_type as c ON c.b_id=a.bird_type LEFT JOIN ppa_event_details as d ON d.ed_id = a.event_id LEFT JOIN ppa_events as e ON d.event_id = a.event_id LEFT JOIN ppa_event_details as f ON f.ed_id=a.event_details_id where a.event_id='" . $eventide . "'" . $fancier . " and a.bird_type='" . $birdtype . "'";die;

    $i = 0;

    //$data["event_id"] = $postdetails["event_id"];

    $numBasketRows = mysqli_num_rows($basketquery);

    if ($numBasketRows >= 1) {
        while ($basketinfo = mysqli_fetch_array($basketquery)) {
            $data["basketinfo"][$i]["entry_id"] = $basketinfo["entry_id"];
            $data["basketinfo"][$i]["event_id"] = $basketinfo["event_id"];
            $data["basketinfo"][$i]["fancier_id"] = $basketinfo["fancier_id"];
            $data["basketinfo"][$i]["username"] = $basketinfo["username"];
            $data["basketinfo"][$i]["birdcategory"] = $basketinfo["brid_type"];
            $data["basketinfo"][$i]["raceinfo"] = $basketinfo["race_distance"] . " km";
            $data["basketinfo"][$i]["ringno"] = $basketinfo["ring_no"];
            $data["basketinfo"][$i]["gender"] = $basketinfo["gender"];
            $data["basketinfo"][$i]["color"] = $basketinfo["color"];
            $data["basketinfo"][$i]["admin_approval"] = $basketinfo["admin_approval"];

            if ($basketinfo["admin_approval"] == 1) {
                $data["basketinfo"][$i]["admin_approval"] = "Approved";
            } else {
                $data["basketinfo"][$i]["admin_approval"] = "Not Approved";
            }

            $data["basketinfo"][$i]["scanReader"] = $basketinfo["scanReader"];
            if ($basketinfo["scanReader"] != "") {
                $data["basketinfo"][$i]["scanReader"] = $basketinfo["scanReader"];
            } else {
                $data["basketinfo"][$i]["scanReader"] = "";
            }

            $data["basketinfo"][$i]["org_code"] = $basketinfo["org_code"];
            $data["basketinfo"][$i]["bird_type"] = $basketinfo["bird_type"];
            $data["basketinfo"][$i]["race_name"] = $basketinfo["Event_name"];

            // "org_code":"PPA",
            // "bird_type":"1",
            // "race_name":"test_race_nov_27",
            // "fancier_name":"masco"

            $i++;
            $data["status"] = 200;
            $data["message"] = "Basket info retrieved";
        }

    } else {
        $data["status"] = 404;
        $data["message"] = "Basketing not found for the given event";
    }

    // $fancierinfo = mysqli_query($dbconnection, "select * from ppa_register where apptype='" . $apptype . "'");
    // $i = 0;
    // while ($fancierlist = mysqli_fetch_array($fancierinfo)) {
    //     $data["fancierinfo"][$i]["useride"] = $fancierlist["reg_id"];
    //     $data["fancierinfo"][$i]["username"] = $fancierlist["username"];
    //     $i++;
    // }
    echo json_encode($data);
    break;

case 'deletebasketinfo':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $evententryide = $postdetails["entry_id"];

    $deletebasketentry = mysqli_query($dbconnection, "delete from ppa_basketing where entry_id='" . $evententryide . "'");

    $eventide = $postdetails["event_id"];
    $apptype = $postdetails["apptype"];
    if (isset($postdetails["fancieride"])) {
        $fancier = " and a.fancier_id='" . $postdetails["fancieride"] . "'";
    } else {
        $fancier = "";
    }

    $basketquery = mysqli_query($dbconnection, "select a.entry_id,b.username,a.ring_no,a.color,a.gender,c.brid_type,f.race_distance from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id = b.reg_id LEFT JOIN ppa_bird_type as c ON c.b_id=a.bird_type LEFT JOIN ppa_event_details as d ON d.ed_id = a.event_id LEFT JOIN ppa_events as e ON d.event_id = a.event_id LEFT JOIN ppa_event_details as f ON f.ed_id=a.event_details_id where a.event_id='" . $eventide . "'" . $fancier . "");

    $i = 0;

    $data["event_id"] = $postdetails["event_id"];

    while ($basketinfo = mysqli_fetch_array($basketquery)) {
        $data["basketinfo"][$i]["entry_id"] = $basketinfo["entry_id"];
        $data["basketinfo"][$i]["username"] = $basketinfo["username"];
        $data["basketinfo"][$i]["birdcategory"] = $basketinfo["brid_type"];
        $data["basketinfo"][$i]["raceinfo"] = $basketinfo["race_distance"] . " km";
        $data["basketinfo"][$i]["ringno"] = $basketinfo["ring_no"];
        $data["basketinfo"][$i]["gender"] = $basketinfo["gender"];
        $data["basketinfo"][$i]["color"] = $basketinfo["color"];

        $i++;
    }

    $fancierinfo = mysqli_query($dbconnection, "select * from ppa_register where apptype='" . $apptype . "'");
    $i = 0;
    while ($fancierlist = mysqli_fetch_array($fancierinfo)) {
        $data["fancierinfo"][$i]["useride"] = $fancierlist["reg_id"];
        $data["fancierinfo"][$i]["username"] = $fancierlist["username"];
        $i++;
    }

    $data["status"] = 1;
    $data["message"] = "Your basket information deleted successfully"; // Updated
    echo json_encode($data);
    break;

case 'insertbasket':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $apptype = $postdetails["apptype"];
    $birdinfo = explode("#", $postdetails["birdcategory"]);
    $event_id = $postdetails["event_id"];
    $eventdetails_id = $birdinfo[1];

    $fancier_id = $postdetails["fancier_id"];
    if (!isset($postdetails["phone_no"])) {
        $phone_no = 0;
    } else {
        $phone_no = $postdetails["phone_no"];
    }

    if (!isset($postdetails["birdcategoryid"])) {
        $birdtype = 0;
    } else {
        $birdtype = $postdetails["birdcategoryid"];
    }

    // if fancier id null means fancier try to insert the user
    if ($fancier_id == "") {
        $fancierinfo = mysqli_query($dbconnection, "select * from ppa_register where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' limit 0,1");
        $fancierlist = mysqli_fetch_array($fancierinfo);
        $fancier_id = $fancierlist["reg_id"];
    }
    // end

    $duplicate = "";
    $count = 0;
    for ($t = 0; $t < count($postdetails["birds"]); $t++) {
        $ringno = $postdetails["birds"][$t]["ringno"];
        $color = $postdetails["birds"][$t]["color"];
        $gender = $postdetails["birds"][$t]["gender"];
        $update_date = date("Y-m-d H:i:s");
        $checkselect = mysqli_query($dbconnection, "select event_id from ppa_basketing where event_id='" . $event_id . "' and ring_no='" . $ringno . "'");
        if (mysqli_num_rows($checkselect) == 0) {
            $insert_qry = mysqli_query($dbconnection, "insert ppa_basketing set event_id='" . $event_id . "',event_details_id='" . $eventdetails_id . "',fancier_id='" . $fancier_id . "',org_code='" . $apptype . "',ring_no='" . $ringno . "',bird_type='" . $birdtype . "',color='" . $color . "',gender='" . $gender . "',update_date='" . $update_date . "',admin_approval='0'");
            $count++;
        } else {
            $duplicate .= $ringno . " , ";
        }
    }

    $data["status"] = 1; // Updated
    if ($duplicate == "") {
        $data["message"] = "Your information added successfully";
    }
    // Updated
    else {
        $data["message"] = $duplicate . "  these ring numbers are already added";
    }
    // Updated

    if ($count == 0) {
        $data["status"] = 0;
        $data["message"] = "Your information not added"; // Updated
    }
    echo json_encode($data);
    //print_r($postdetails);
    break;

case 'getmyBasket':

    $authuser = checkauth($dbconnection, $secureusertoken);
    /*if($authuser=="0" || $authuser=="")
    {
    $data["status"]=404;
    $data["msg"]="Authentication failed";
    echo json_encode($data);
    break;
     */

    $apptype = $postdetails["apptype"];
    $catid = $postdetails["categoryId"];
    $event_id = $postdetails["raceId"];
    $event_details_id = $postdetails["event_details_id"];

    $firstquery = mysqli_query($dbconnection, "SELECT max(date) as maxi,MIN(date) as mini,start_time as start FROM `ppa_event_details` WHERE event_id='" . $event_id . "'");
    $firstres = mysqli_fetch_array($firstquery);
    $racestartdate = $firstres["mini"];
    $starttime = $firstres["start"];

    if (!isset($postdetails["phone_no"])) {
        $phone_no = 0;
    } else {
        $phone_no = $postdetails["phone_no"];
    }

    // if fancier id null means fancier try to insert the user
    $fancierinfo = mysqli_query($dbconnection, "select * from ppa_register where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' limit 0,1");
    $fancierlist = mysqli_fetch_array($fancierinfo);
    $fancier_id = $fancierlist["reg_id"];

    // end
    $temp = array();
    $temp1 = array();

    if ($event_details_id == '' || $event_details_id == 0) {
        $query = mysqli_query($dbconnection, "select a.*,b.username as uname,b.latitude as loftlat,b.longitude as loftlong,e.Event_lat as eventlat,e.Event_long as eventlong,c.race_distance,d.brid_type  from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id=b.reg_id LEFT JOIN ppa_event_details as c ON c.ed_id=a.event_details_id LEFT JOIN ppa_bird_type as d ON d.b_id=c.bird_id LEFT JOIN ppa_events as e ON e.Events_id=a.event_id where a.event_id ='" . $event_id . "' and a.fancier_id ='" . $fancier_id . "'");
    } else {
        $query = mysqli_query($dbconnection, "select a.*,b.username as uname,b.latitude as loftlat,b.longitude as loftlong,e.Event_lat as eventlat,e.Event_long as eventlong,c.race_distance,d.brid_type  from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id=b.reg_id LEFT JOIN ppa_event_details as c ON c.ed_id=a.event_details_id LEFT JOIN ppa_bird_type as d ON d.b_id=c.bird_id LEFT JOIN ppa_events as e ON e.Events_id=a.event_id where a.event_details_id='" . $event_details_id . "' and a.event_id ='" . $event_id . "' and a.fancier_id ='" . $fancier_id . "'");
    }
    $i = 0;

    if (mysqli_num_rows($query) > 0) {
        while ($res = mysqli_fetch_array($query)) {
            if ($i == 0) {
                $temp["status"] = 1;
                $temp["userid"] = $res["fancier_id"];
                $temp["username"] = $res["uname"];
            }

            $updatedphoto = mysqli_query($dbconnection, "select photo_name from ppa_updatephoto where owner_ringno='" . $res["ring_no"] . "' and event_id ='" . $event_id . "' and phone_no='" . $phone_no . "' and club_code='" . $apptype . "' order by pid DESC limit 0,1");

            if (mysqli_num_rows($updatedphoto) > 0) {
                $photolists = mysqli_fetch_array($updatedphoto);
                $photo_url = "https://lespoton.com/portal/uploads/" . $photolists["photo_name"];

                // Start calculation

                $post_date = str_replace("'", '', $racestartdate) . " " . $starttime;
                $timeinfo = explode("_", $photolists["photo_name"]);
                $timestamp = (str_replace(".jpg", "", $timeinfo[2]) / 1000);
                $st_time = strtotime($post_date);
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
                $starteddate = strtotime(str_replace("'", '', $racestartdate));
                $calculationhour = 0;
                $phour = 0;
                if ($clickeddate == $starteddate) {
                    $starttime = strtotime($post_date);
                    $clickedtime = strtotime($fulltime);
                    $differenttime = $clickedtime - $starttime;
                    $calculationhour = $differenttime / 60;
                } else {
                    // a.ed_id='".$event_details_id."' AND
                    $calculationhour = 0;
                    $chk_date = mysqli_query($dbconnection, "SELECT * FROM ppa_event_details as a LEFT JOIN ppa_bird_type as b on b.b_id=a.bird_id WHERE a.event_id= '" . $event_id . "' AND date<='" . $fulldate . "' AND a.race_distance='" . $res["race_distance"] . "' AND b.brid_type='" . $res["brid_type"] . "'");
                    $chk_datedata = mysqli_fetch_array($chk_date);
                    $phour = 0;
                    foreach ($chk_datedata as $chk_datedatarow) {
                        $racestartdate = strtotime($chk_datedatarow->date);
                        $racestarttime = strtotime($chk_datedatarow->start_time);
                        $extimedata = date('h:i:s A', $racestarttime);

                        if ($clickeddate == $racestartdate) {
                            $full_start_date = $chk_datedatarow->date . ' ' . $extimedata;
                            $extime = strtotime($exfulltime) - strtotime($full_start_date);
                            $init = $extime;
                            $hours = floor($init / 3600);
                            $minutes = floor(($init / 60) % 60);
                            $seconds = $init % 60;
                            $secondstomin = $seconds / 60;
                            $phour = $phour + ($hours * 60) + $minutes + $secondstomin;

                        } else {
                            $phour = $phour + h2m($chk_datedatarow->boarding_time);
                        }

                    }

                    $calculationhour = $phour;
                }

                $flydistance = distance($res["loftlat"], $res["loftlong"], $res["eventlat"], $res["eventlong"], "K");
                if ($calculationhour == 0) {
                    $velocity1 = 0;
                } else {
                    $velocity1 = ($flydistance * 1000) / $calculationhour;
                }

                $flydistance = number_format($flydistance, 5) . " Km";
                $calculationhour = number_format($calculationhour, 2) . " Min";
                $velocity1 = number_format($velocity1, 7) . " Mt/Min";
                // End Calculation

            } else {
                $photo_url = "";
                $flydistance = "";
                $velocity1 = "";
                $calculationhour = "";
            }

            $temp1["ringNo"] = $res["ring_no"];
            $temp1["Color"] = $res["color"];
            $temp1["gender"] = $res["gender"];
            $temp1["basketStatus"] = $res["admin_approval"];
            $temp1["birdimage"] = $photo_url;
            $temp1["raceDistance"] = $flydistance;
            $temp1["timeTaken"] = $calculationhour;
            $temp1["velocity"] = $velocity1;
            $temp1["category"] = $res["brid_type"];
            //$temp1["raceDistance"] = $res["race_distance"]." Km";
            $temp1["basketId"] = $res["entry_id"];
            //$temp1["loftDistance"] = $res["gender"];
            $temp["birdDetail"][] = $temp1;
            $i++;
        }

        $data = $temp;
    } else {
        $data["message"] = "No Basketing lists found";
        $data["status"] = "0";
    }

    //$data["qry"] = $dis_qry;

    echo json_encode($data);
    //print_r($postdetails);
    break;

case 'categorylist':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }

    error_reporting(-1);
    ini_set('display_errors', 1);
    $apptype = $postdetails["apptype"];
    $selectdate = date("Y-m-d");

    date_default_timezone_set("Asia/Kolkata");
    $currdate = date('Y-m-d');
    $date = new DateTime($currdate); // For today/now, don't pass an arg.
    $date->modify("-3 day");
    $fromdate = $date->format("Y-m-d");
    $date2 = new DateTime($currdate);
    $date2->modify("+3 day");
    $todate = $date2->format("Y-m-d");
    //$photo_created = $postdetails["photo_created"];

    // if ($apptype == "" || $photo_created == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }

    //$query = mysqli_query($dbconnection,"select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,e.bird_name,e.color,e.ring_no,e.gender,e.rubber_inner_no,e.rubber_outer_no FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id INNER JOIN ppa_basketing as e on e.event_details_id=a.ed_id where c.Org_code='".$apptype."' and a.date >='".$fromdate."' and a.date <='".$todate."' and b.result_publish='0' group by a.bird_id order by a.ed_id ASC") ;
    // echo "SELECT a.event_id,b.Event_name FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id = b.Events_id LEFT JOIN users as c on c.users_id = b.Org_id where c.Org_code='" . $apptype . "' and a.date >= '" . $fromdate . "' and a.date <= '" . $todate . "' order by a.event_id DESC limit 0,1";die;

    $query = mysqli_query($dbconnection, "SELECT a.event_id,b.Event_name FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id = b.Events_id LEFT JOIN users as c on c.users_id = b.Org_id where c.Org_code='" . $apptype . "' and a.date >= '" . $fromdate . "' and a.date <= '" . $todate . "' order by a.event_id DESC limit 0,1");

    // SELECT a.event_id,b.Event_name FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id = b.Events_id LEFT JOIN users as c on c.users_id = b.Org_id where c.Org_code='PPA' and a.date >= '2020-11-09' and a.date <= '2020-11-15' order by a.event_id DESC limit 0,1

    // select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,e.bird_name,e.color,e.gender,e.rubber_inner_no FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id INNER JOIN ppa_basketing as e on e.event_details_id=a.ed_id where c.Org_code='PPA' and a.date >='2019-10-27' and a.date <='2019-11-13' and b.result_publish='0' group by a.bird_id order by a.ed_id ASC

    $i = 0;
    $temp = array();

    $temp1 = array();
    if (mysqli_num_rows($query) > 0) {
        while ($res = mysqli_fetch_array($query)) {
            $temp["status"] = 1;
            $temp["race"] = $res["Event_name"];
            $temp["raceId"] = $postdetails["event_id"];

            $query1 = mysqli_query($dbconnection, "SELECT a.*,b.brid_type as birdtype FROM ppa_basketing as a LEFT JOIN ppa_bird_type as b on a.bird_type=b.b_id LEFT JOIN ppa_register as c on c.reg_id=a.fancier_id where a.event_id='" . $postdetails["event_id"] . "' and a.org_code='" . $apptype . "' and c.phone_no='" . $postdetails["phone_no"] . "' and a.admin_approval='1'");

            // SELECT a.*,b.brid_type as birdtype FROM ppa_basketing as a LEFT JOIN ppa_bird_type as b on a.bird_type=b.b_id LEFT JOIN ppa_register as c on c.reg_id=a.fancier_id where a.event_id='1024' and a.org_code='PPA' and c.phone_no='7555273143' and a.admin_approval='1'

            while ($res1 = mysqli_fetch_array($query1)) {
                $temp1["owner_ringno"] = $res1["ring_no"] . "--" . $res1["rubber_outer_no"];
                $temp1["outer_no"] = $res1["rubber_outer_no"];
                $temp1["fancier_id"] = $res1["fancier_id"];
                $temp1["event_id"] = $res1["event_id"];
                $temp1["gender"] = $res1["gender"];
                $temp1["bird_color"] = $res1["color"];
                $temp1["categoryname"] = $res1["birdtype"];
                $temp1["categoryid"] = $res1["bird_type"] . "#" . $res1["event_details_id"] . "#" . $res["event_id"] . "#" . $res1["birdtype"] . "#0";
                $temp["birdsDetail"][] = $temp1;
            }

        }
        $data = $temp;
        $data["status"] = 200;
        $data["message"] = "Category List retrieved";
        if (mysqli_num_rows($query1) == 0) {
            // $data["birdsDetail"] = $temp1;
            $data["status"] = 404;
            $data["message"] = "Admin is yet to approve the bird";
        }

    } else {
        $data["status"] = 0;
        $data["status"] = 404;
        $data["message"] = "No Category List retrieved";
        // $data["birdsDetail"] = $temp;
    }

    echo json_encode($data);
    break;

case 'categorylistold':

    $authuser = checkauth($dbconnection, $secureusertoken);

    /*if($authuser=="0" || $authuser=="")
    {
    $data["status"]=404;
    $data["msg"]="Authentication failed";
    echo json_encode($data);
    break;
     */

    error_reporting(-1);
    ini_set('display_errors', 1);
    $apptype = $postdetails["apptype"];
    $selectdate = date("Y-m-d");

    date_default_timezone_set("Asia/Kolkata");
    $currdate = date('Y-m-d');
    $date = new DateTime($currdate); // For today/now, don't pass an arg.
    $date->modify("-3 day");
    $fromdate = $date->format("Y-m-d");
    $date2 = new DateTime($currdate);
    $date2->modify("+3 day");
    $todate = $date2->format("Y-m-d");

    $query = mysqli_query($dbconnection, "select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,e.bird_name,e.color,e.ring_no,e.gender,e.rubber_inner_no,e.rubber_outer_no FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id INNER JOIN ppa_basketing as e on e.event_details_id=a.ed_id where c.Org_code='" . $apptype . "' and a.date >='" . $fromdate . "' and a.date <='" . $todate . "' and b.result_publish='0' group by a.bird_id order by a.ed_id ASC");

    // select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,e.bird_name,e.color,e.gender,e.rubber_inner_no FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id INNER JOIN ppa_basketing as e on e.event_details_id=a.ed_id where c.Org_code='PPA' and a.date >='2019-10-27' and a.date <='2019-11-13' and b.result_publish='0' group by a.bird_id order by a.ed_id ASC

    $i = 0;
    if (mysqli_num_rows($query) > 0) {
        while ($res = mysqli_fetch_array($query)) {
            $data["category"][$i]["name"] = $res["race_distance"] . " Km (" . $res["brid_type"] . ")";
            $data["category"][$i]["value"] = $res["event_id"] . "#" . $res["ed_id"] . "#" . $res["bird_id"] . "#" . $res["brid_type"] . "#" . $res["race_distance"];
            $data["birdsDetail"][0]["owner_ringno"] = $res["ring_no"];
            $data["birdsDetail"][0]["gender"] = $res["gender"];
            $data["birdsDetail"][0]["bird_color"] = $res["color"];
            $i++;
        }

        $data["message"] = "Category List retrieved";
    } else {
        $data["message"] = "No categories found";
    }

    echo json_encode($data);
    break;

case 'updatephoto':
    //die($_SERVER['REMOTE_ADDR']);
    $com_ip = $_SERVER['REMOTE_ADDR'];

    /*$authuser = checkauth($dbconnection,$secureusertoken);
    if($authuser=="0" || $authuser=="")
    {
    $data["status"]=404;
    $data["msg"]="Authentication failed";
    echo json_encode($data);
    break;
     */

    $apptype = $postdetails["apptype"];
    $filename = $postdetails["filename"];
    $selectedvalue = $postdetails["category"];
    $deviceide = $postdetails["deivce_id"];
    $username = $postdetails["username"];
    $phone_no = $postdetails["phone_no"];
    if (isset($postdetails["loftDistance"])) {
        $loftDistance = $postdetails["loftDistance"];
    } else {
        $loftDistance = 0;
    }

    if (!isset($postdetails["auto_detected_tag_no"])) {
        $auto_detected_tag_no = $postdetails["auto_detected_tag_no"];
    } else {
        $auto_detected_tag_no = '';
    }

    if ($postdetails["inner_ringno"]) {
        $inner_ringno = $postdetails["inner_ringno"];
    } else {
        $inner_ringno = "";
    }

    if ($postdetails["outer_ringno"]) {
        $outer_ringno = $postdetails["outer_ringno"];
    } else {
        $outer_ringno = "";
    }

    if ($postdetails["bird_color"]) {
        $bird_color = $postdetails["bird_color"];
    } else {
        $bird_color = "";
    }

    if ($postdetails["owner_ringno"]) {
        $ownerinfodet = explode("--", $postdetails["owner_ringno"]);
        $owner_ringno = $ownerinfodet[0];
    } else {
        $owner_ringno = "";
    }

    if ($postdetails["gender"]) {
        $gender = $postdetails["gender"];
    } else {
        $gender = "";
    }

    $selectedinfo = explode("#", $selectedvalue);
    $update_date = date("Y-m-d H:i:s");
    // $res1["bird_type"]."#".$res1["event_details_id"]."#".$res["event_id"]."#".$res1["birdtype"]; from categorylist

    $racedistinfo = mysqli_query($dbconnection, "select race_distance from ppa_event_details where ed_id='" . $selectedinfo[1] . "' limit 0,1");
    $racedistdet = mysqli_fetch_array($racedistinfo);
    $race_distance = $racedistdet[0]["race_distance"];

    $loftinfo = mysqli_query($dbconnection, "select latitude,longitude from ppa_register where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' limit 0,1");
    $loftinfodet = mysqli_fetch_array($loftinfo);
    $loftlatitude = $loftinfodet["latitude"];
    $loftlongitude = $loftinfodet["longitude"];

    /*if($com_ip==$curr_ip)
    {
    //die("select race_distance from ppa_event_details where ed_id='".$selectedinfo[1]."' limit 0,1");
     */

    $checkphoto_entry = mysqli_query($dbconnection, "select loftdistance from ppa_updatephoto where photo_name='" . $filename . "'");

    if (mysqli_num_rows($checkphoto_entry) == 0) {
        $insert_qry = mysqli_query($dbconnection, "insert ppa_updatephoto set loftdistance='" . $loftDistance . "',username='" . $username . "',detected_tag_no='" . $auto_detected_tag_no . "',phone_no='" . $phone_no . "',device_ide='" . $deviceide . "',event_id='" . $selectedinfo[2] . "',event_details_id='" . $selectedinfo[1] . "',birdtype='" . $selectedinfo[0] . "',race_distance='" . $race_distance . "',photo_name='" . $filename . "',club_code='" . $apptype . "',cre_date='" . $update_date . "',owner_ringno='" . $owner_ringno . "',gender='" . $gender . "',color='" . $bird_color . "'");
    } else {
        $update_qry = mysqli_query($dbconnection, "update ppa_updatephoto set loftdistance='" . $loftDistance . "',username='" . $username . "',detected_tag_no='" . $auto_detected_tag_no . "',phone_no='" . $phone_no . "',device_ide='" . $deviceide . "',event_id='" . $selectedinfo[2] . "',event_details_id='" . $selectedinfo[1] . "',birdtype='" . $selectedinfo[0] . "',race_distance='" . $race_distance . "',photo_name='" . $filename . "',club_code='" . $apptype . "',cre_date='" . $update_date . "',owner_ringno='" . $owner_ringno . "',gender='" . $gender . "',color='" . $bird_color . "' where photo_name='" . $filename . "' ");
    }

    //$ide = mysql_insert_id();
    $ide = mysqli_insert_id($dbconnection);
    $latitude = 0;
    $longitude = 0;
    $distance = 0;
    if (isset($postdetails["latitude"])) {
        $latitude = $postdetails["latitude"];
    }

    if (isset($postdetails["longitude"])) {
        $longitude = $postdetails["longitude"];
    }

    $selectdate = date("Y-m-d");

    /*$selquery = mysqli_query($dbconnection,"select (6371 * acos(
    cos( radians(b.Event_lat) )
     * cos( radians( ".$latitude." ) )
     * cos( radians( ".$longitude." ) - radians(b.Event_long) )
    + sin( radians(b.Event_lat) )
     * sin( radians( ".$latitude." ) )
     */

    $selquery = mysqli_query($dbconnection, "select * FROM ppa_events as b where b.Events_id='" . $selectedinfo[2] . "'");
    $res = mysqli_fetch_array($selquery);
    $raceide = $selectedinfo[2];

    $lat1 = $res["Event_lat"];
    $lon1 = $res["Event_long"];
    //$lat2     = $latitude;
    //$lon2     = $longitude;
    $lat2 = $loftlatitude;
    $lon2 = $loftlongitude;
    //$data["loftlat"] = $loftlatitude;

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;

    $distance = $miles * 1.609344;

    $update_distance = mysqli_query($dbconnection, "update ppa_files set bird_type='" . $selectedinfo[0] . "',latitude='" . $latitude . "',longitude='" . $longitude . "',event_id='" . $raceide . "',distance='" . $distance . "',owner_ringno='" . $owner_ringno . "',bird_gender='" . $gender . "',bird_color='" . $bird_color . "' where filename='" . $postdetails["filename"] . "'");

    if ($ide != 0) {
        $data["status"] = 1;
    } else {
        $data["status"] = 0;
    }

    $data["distance"] = $distance;
    echo json_encode($data);
    break;

// case 'racecalculation':
//     $ringNo = $postdetails["ring_number"];
//     $userId = $postdetails["user_id"];
//     $eventId = $postdetails["event_id"];
//     $trapTime = $postdetails["trap_time"];
//     $phone_no = $postdetails["phone_no"];
//     // $latitute = $postdetails["latitute"];
//     // $longitude = $postdetails["longitude"];
//     $apptype = $postdetails["apptype"];
//     $filename = $postdetails["filename"];
//     $birdId = $postdetails["category"];
//     //$photoName = 'fname_863309040716277_1602315552105.jpg';
//     if (isset($postdetails["loftDistance"])) {
//         $loftDistance = $postdetails["loftDistance"];
//     } else {
//         $loftDistance = 0;
//     }
//     if (!isset($postdetails["auto_detected_tag_no"])) {
//         $auto_detected_tag_no = $postdetails["auto_detected_tag_no"];
//     } else {
//         $auto_detected_tag_no = '';
//     }

//     if ($postdetails["inner_ringno"]) {
//         $inner_ringno = $postdetails["inner_ringno"];
//     } else {
//         $inner_ringno = "";
//     }

//     if ($postdetails["outer_ringno"]) {
//         $outer_ringno = $postdetails["outer_ringno"];
//     } else {
//         $outer_ringno = "";
//     }

//     if ($postdetails["bird_color"]) {
//         $bird_color = $postdetails["bird_color"];
//     } else {
//         $bird_color = "";
//     }

//     if ($postdetails["owner_ringno"]) {
//         $ownerinfodet = explode("--", $postdetails["owner_ringno"]);
//         $owner_ringno = $ownerinfodet[0];
//     } else {
//         $owner_ringno = "";
//     }

//     if ($postdetails["gender"]) {
//         $gender = $postdetails["gender"];
//     } else {
//         $gender = "";
//     }

//     $update_date = date("Y-m-d H:i:s");
//     $current_date = date("Y-m-d");
//     //$current_date = "2020-10-23";
//     $get_event_details = mysqli_query($dbconnection, "select * from ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id where a.event_id = '" . $eventId . "' and date = '" . $current_date . "' and bird_id = '" . $birdId . "'");
//     $EventDetails = mysqli_fetch_array($get_event_details);
//     $race_distance = $EventDetails["race_distance"];
//     $event_id = $EventDetails["event_id"];
//     $event_date = $EventDetails["date"];
//     $event_start_time = $EventDetails["start_time"];
//     $event_end_time = $EventDetails["end_time"];
//     $event_details_id = $EventDetails["ed_id"];

//     $raceStartDate = strtotime($event_date);
//     $raceStartTime = strtotime($event_start_time);
//     $extimedata = date('h:i:s A', $raceStartTime);
//     $raceStartDateTime = $event_date . ' ' . $extimedata;
//     $getTimeDiff = strtotime($trapTime) - strtotime($raceStartDateTime);
//     $phour = 0;
//     $hours = floor($getTimeDiff / 3600);
//     $minutes = floor(($getTimeDiff / 60) % 60);
//     $seconds = $getTimeDiff % 60;
//     $secondstomin = $seconds / 60;
//     $TimeToMinutes = $phour + ($hours * 60) + $minutes + $secondstomin;

//     $userInfo = mysqli_query($dbconnection, "select latitude,longitude,phone_no,username,device_id from ppa_register where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' limit 0,1");
//     $UserDetails = mysqli_fetch_array($userInfo);
//     $userLatitude = $UserDetails["latitude"];
//     $userLongitude = $UserDetails["longitude"];
//     $UserName = $UserDetails["username"];
//     $phone_no = $UserDetails["phone_no"];
//     $deviceide = $UserDetails["device_id"];

//     $latitude = 0;
//     $longitude = 0;
//     $distance = 0;

//     if (isset($postdetails["latitute"])) {
//         $latitude = $postdetails["latitute"];
//     }

//     if (isset($postdetails["longitude"])) {
//         $longitude = $postdetails["longitude"];
//     }

//     $selectdate = date("Y-m-d");
//     $getEvents = mysqli_query($dbconnection, "select * FROM ppa_events as b where b.Events_id='" . $eventId . "'");
//     $eventResults = mysqli_fetch_array($getEvents);
//     $eventLatitude = $eventResults["Event_lat"];
//     $eventLongitude = $eventResults["Event_long"];
//     $getLogitude = $eventLongitude - $userLongitude;
//     $getDistance = sin(deg2rad($eventLatitude)) * sin(deg2rad($userLatitude)) + cos(deg2rad($eventLatitude)) * cos(deg2rad($userLatitude)) * cos(deg2rad($getLogitude));
//     $getDistance = acos($getDistance);
//     $getDistance = rad2deg($getDistance);
//     $miles = $getDistance * 60 * 1.1515;
//     $distance = $miles * 1.609344; // Converted to Meter
//     $getKilometer = number_format($miles, 3) . " Km";
//     $velocity = $distance / $TimeToMinutes;

//     $bird_color = $postdetails["bird_color"];
//     $owner_ringno = $postdetails["ring_no"];
//     $gender = $postdetails["gender"];
//     $loftdistance = $postdetails[""];

//     $path = "uploads/";
//     if ($_FILES['filename']['error'] != 4) 
//     {
//         $path_parts = pathinfo($_FILES["filename"]["name"]);
//         $getTraveTime = explode("_", $path_parts['basename']);
//         $TravelTime = explode(".", $getTraveTime[1]);
//         $extension = $path_parts['extension'];
//         if (move_uploaded_file($_FILES["filename"]["tmp_name"], $path . $path_parts['basename'])) 
//         {
//             $insert_qry = mysqli_query($dbconnection, "insert ppa_updatephoto set username='" . $UserName . "',detected_tag_no='" . $auto_detected_tag_no . "',phone_no='" . $phone_no . "',device_ide='" . $deviceide . "',event_id='" . $eventId . "',event_details_id='" . $event_details_id . "',birdtype='" . $birdId . "',race_distance='" . $race_distance . "',photo_name='" . $path_parts['basename'] . "',club_code='" . $apptype . "',cre_date='" . $update_date . "',owner_ringno='" . $ring_no . "',gender='" . $gender . "',color='" . $bird_color . "'");

//             $insert_race_details = mysqli_query($dbconnection, "insert ppa_files set device_id='" . $deviceide . "',club_code='" . $apptype . "',event_id='" . $eventId . "',temp_event_id='" . $event_details_id . "',bird_type='" . $birdId . "',username='" . $UserName . "',mobile='" . $phone_no . "',filename='" . $path_parts['basename'] . "',time_interval='" . $TravelTime . "',distance='" . $distance . "',velocity='" . $velocity . "',cre_date='" . $update_date . "',owner_ringno='" . $owner_ringno . "',bird_gender='" . $gender . "',bird_color='" . $bird_color . "',latitude='" . $latitude . "',longitude='" . $longitude . "'");

//             $updateReports = mysqli_query($dbconnection, "insert ppa_report set start_date='" . $event_date . "',event_sche_date='" . $event_date . "',start_time='" . $event_start_time . "',clubtype='" . $apptype . "',ring_no='" . $owner_ringno . "',bird_color='" . $bird_color . "',event_id='" . $eventId . "',bird_type_id='" . $birdId . "',apptype='" . $apptype . "',bird_gender='" . $gender . "',mobile_number='" . $phone_no . "',name='" . $UserName . "', device_id='" . $deviceide . "',velocity='" . $velocity . "',distance='" . $distance . "',img_name='" . $path_parts['basename'] . "',intervel='" . $TravelTime[0] . "',latitude='" . $latitude . "',longtitude='" . $longitude . "',event_details_id='" . $event_details_id . "',created_date='" . $update_date . "'");

//             $data["status"] = 200;
//             $data["message"] = 'Race Calculated Successfully';
//             $data["total_distance"] = $getKilometer;
//         } 
//         else 
//         {
//             $data["status"] = 404;
//             $data["message"] = 'Image Not Uploaded';
//         }
//     }
//     echo json_encode($data);
//     break;

// case 'racecalculation':
//     $ringNo = $postdetails["ring_number"];
//     $userId = $postdetails["user_id"];
//     $eventId = $postdetails["event_id"];
//     $trapTime = $postdetails["trap_time"];
//     $phone_no = $postdetails["phone_no"];
//     // $latitute = $postdetails["latitute"];
//     // $longitude = $postdetails["longitude"];
//     $apptype = $postdetails["apptype"];
//     $filename = $postdetails["filename"];
//     $birdId = $postdetails["category"];
//     //$photoName = 'fname_863309040716277_1602315552105.jpg';
//     if (isset($postdetails["loftDistance"])) {
//         $loftDistance = $postdetails["loftDistance"];
//     } else {
//         $loftDistance = 0;
//     }
//     if (!isset($postdetails["auto_detected_tag_no"])) {
//         $auto_detected_tag_no = $postdetails["auto_detected_tag_no"];
//     } else {
//         $auto_detected_tag_no = '';
//     }

//     if ($postdetails["inner_ringno"]) {
//         $inner_ringno = $postdetails["inner_ringno"];
//     } else {
//         $inner_ringno = "";
//     }

//     if ($postdetails["outer_ringno"]) {
//         $outer_ringno = $postdetails["outer_ringno"];
//     } else {
//         $outer_ringno = "";
//     }

//     if ($postdetails["bird_color"]) {
//         $bird_color = $postdetails["bird_color"];
//     } else {
//         $bird_color = "";
//     }

//     if ($postdetails["owner_ringno"]) {
//         $ownerinfodet = explode("--", $postdetails["owner_ringno"]);
//         $owner_ringno = $ownerinfodet[0];
//     } else {
//         $owner_ringno = "";
//     }

//     if ($postdetails["gender"]) {
//         $gender = $postdetails["gender"];
//     } else {
//         $gender = "";
//     }

//     $update_date = date("Y-m-d H:i:s");
//     $current_date = date("Y-m-d");
//     //$current_date = "2020-10-23";
//     $get_event_details = mysqli_query($dbconnection, "select * from ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id where a.event_id = '" . $eventId . "' and date = '" . $current_date . "' and bird_id = '" . $birdId . "'");
//     $EventDetails = mysqli_fetch_array($get_event_details);
//     $race_distance = $EventDetails["race_distance"];
//     $event_id = $EventDetails["event_id"];
//     $event_date = $EventDetails["date"];
//     $event_start_time = $EventDetails["start_time"];
//     $event_end_time = $EventDetails["end_time"];
//     $event_details_id = $EventDetails["ed_id"];

//     $raceStartDate = strtotime($event_date);
//     $raceStartTime = strtotime($event_start_time);
//     $extimedata = date('h:i:s A', $raceStartTime);
//     $raceStartDateTime = $event_date . ' ' . $extimedata;
//     $getTimeDiff = strtotime($trapTime) - strtotime($raceStartDateTime);
//     $phour = 0;
//     $hours = floor($getTimeDiff / 3600);
//     $minutes = floor(($getTimeDiff / 60) % 60);
//     $seconds = $getTimeDiff % 60;
//     $secondstomin = $seconds / 60;
//     $TimeToMinutes = $phour + ($hours * 60) + $minutes + $secondstomin;

//     $userInfo = mysqli_query($dbconnection, "select latitude,longitude,phone_no,username,device_id from ppa_register where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' limit 0,1");
//     $UserDetails = mysqli_fetch_array($userInfo);
//     $userLatitude = $UserDetails["latitude"];
//     $userLongitude = $UserDetails["longitude"];
//     $UserName = $UserDetails["username"];
//     $phone_no = $UserDetails["phone_no"];
//     $deviceide = $UserDetails["device_id"];

//     $latitude = 0;
//     $longitude = 0;
//     $distance = 0;

//     if (isset($postdetails["latitute"])) {
//         $latitude = $postdetails["latitute"];
//     }

//     if (isset($postdetails["longitude"])) {
//         $longitude = $postdetails["longitude"];
//     }

//     $selectdate = date("Y-m-d");
//     $getEvents = mysqli_query($dbconnection, "select * FROM ppa_events as b left join ppa_basketing as a on b.Events_id=a.event_id where b.Events_id='" . $eventId . "'");
//     $eventResults = mysqli_fetch_array($getEvents);
//     $eventLatitude = $eventResults["Event_lat"];
//     $eventLongitude = $eventResults["Event_long"];
//     $getLogitude = $eventLongitude - $userLongitude;
//     $getDistance = sin(deg2rad($eventLatitude)) * sin(deg2rad($userLatitude)) + cos(deg2rad($eventLatitude)) * cos(deg2rad($userLatitude)) * cos(deg2rad($getLogitude));
//     $getDistance = acos($getDistance);
//     $getDistance = rad2deg($getDistance);
//     $miles = $getDistance * 60 * 1.1515;
//     $distance = $miles * 1.609344; // Converted to Meter
//     $getKilometer = number_format($miles, 3) . " Km";
//     $velocity = $distance / $TimeToMinutes;

//     $bird_color = $postdetails["bird_color"];
//     $owner_ringno = $postdetails["ring_no"];
//     $gender = $postdetails["gender"];
//     $loftdistance = $postdetails[""];
//     $deviceTagId = $postdetails["tag_id"];

//     $path = "uploads/";

//     // tag_device_id
//     // device_tag_id

//     if (isset($_FILES["filename"]["name"])) 
//     {
//         $path_parts = pathinfo($_FILES["filename"]["name"]);
//         $getTraveTime = explode("_", $path_parts['basename']);
//         $TravelTime = explode(".", $getTraveTime[1]);
//         $extension = $path_parts['extension'];
//         move_uploaded_file($_FILES["filename"]["tmp_name"], $path . $path_parts['basename']);
//     }
//     else
//     {
//         $path_parts['basename'] = "";
//     }
    
//     // if (move_uploaded_file($_FILES["filename"]["tmp_name"], $path . $path_parts['basename'])) 
//     // {
//         $insert_qry = mysqli_query($dbconnection, "insert ppa_updatephoto set username='" . $UserName . "',detected_tag_no='" . $auto_detected_tag_no . "',phone_no='" . $phone_no . "',device_ide='" . $deviceide . "',event_id='" . $eventId . "',event_details_id='" . $event_details_id . "',birdtype='" . $birdId . "',race_distance='" . $race_distance . "',photo_name='" . $path_parts['basename'] . "',club_code='" . $apptype . "',cre_date='" . $update_date . "',owner_ringno='" . $ring_no . "',gender='" . $gender . "',color='" . $bird_color . "',device_tag_id='".$deviceTagId."'");

//         $insert_race_details = mysqli_query($dbconnection, "insert ppa_files set device_id='" . $deviceide . "',club_code='" . $apptype . "',event_id='" . $eventId . "',temp_event_id='" . $event_details_id . "',bird_type='" . $birdId . "',username='" . $UserName . "',mobile='" . $phone_no . "',filename='" . $path_parts['basename'] . "',time_interval='" . $TravelTime . "',distance='" . $distance . "',velocity='" . $velocity . "',cre_date='" . $update_date . "',owner_ringno='" . $owner_ringno . "',bird_gender='" . $gender . "',bird_color='" . $bird_color . "',latitude='" . $latitude . "',longitude='" . $longitude . "',tag_device_id='".$deviceTagId."'");

//         $updateReports = mysqli_query($dbconnection, "insert ppa_report set start_date='" . $event_date . "',event_sche_date='" . $event_date . "',start_time='" . $event_start_time . "',clubtype='" . $apptype . "',ring_no='" . $owner_ringno . "',bird_color='" . $bird_color . "',event_id='" . $eventId . "',bird_type_id='" . $birdId . "',apptype='" . $apptype . "',bird_gender='" . $gender . "',mobile_number='" . $phone_no . "',name='" . $UserName . "', device_id='" . $deviceide . "',velocity='" . $velocity . "',distance='" . $distance . "',img_name='" . $path_parts['basename'] . "',intervel='" . $TravelTime[0] . "',latitude='" . $latitude . "',longtitude='" . $longitude . "',event_details_id='" . $event_details_id . "',created_date='" . $update_date . "',device_tag='".$deviceTagId."'");

//         $data["status"] = 200;
//         $data["message"] = 'Race Calculated Successfully';
//         $data["total_distance"] = $getKilometer;
//         $data["bird_gender"] = $eventResults["gender"];
//         $data["ring_no"] = $eventResults["ring_no"];
//         $data["color"] = $eventResults["color"];



//         // $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
//         // $entryLogDetail = mysqli_fetch_array($entrylogQuery);
//         // $username = $entryLogDetail["username"];
//         // $user_id = $entryLogDetail["reg_id"];
//         $action = "Race calculation";
//         $desc = $UserName . " there is no record for the given event";
//         entrylog($action,$desc, $userId,$dbconnection);


//     // } 
//     // else 
//     // {
//     //     $data["status"] = 404;
//     //     $data["message"] = 'Image Not Uploaded';
//     // }
    
//     echo json_encode($data);
//     break;    

case 'racecalculation':
    $ringNo = $postdetails["ring_number"];
    $userId = $postdetails["user_id"];
    $eventId = $postdetails["event_id"];
    $trapTime = $postdetails["trap_time"];
    $phone_no = $postdetails["phone_no"];
    // $latitute = $postdetails["latitute"];
    // $longitude = $postdetails["longitude"];
    $apptype = $postdetails["apptype"];
    $filename = $postdetails["filename"];
    $birdId = $postdetails["category"];
    $chitTimeStamp = $postdetails["chip_time_stamp"];
    //$photoName = 'fname_863309040716277_1602315552105.jpg';
    if (isset($postdetails["loftDistance"])) {
        $loftDistance = $postdetails["loftDistance"];
    } else {
        $loftDistance = 0;
    }
    if (!isset($postdetails["auto_detected_tag_no"])) {
        $auto_detected_tag_no = $postdetails["auto_detected_tag_no"];
    } else {
        $auto_detected_tag_no = '';
    }

    if ($postdetails["inner_ringno"]) {
        $inner_ringno = $postdetails["inner_ringno"];
    } else {
        $inner_ringno = "";
    }

    if ($postdetails["outer_ringno"]) {
        $outer_ringno = $postdetails["outer_ringno"];
    } else {
        $outer_ringno = "";
    }

    if ($postdetails["bird_color"]) {
        $bird_color = $postdetails["bird_color"];
    } else {
        $bird_color = "";
    }

    if ($postdetails["owner_ringno"]) {
        $ownerinfodet = explode("--", $postdetails["owner_ringno"]);
        $owner_ringno = $ownerinfodet[0];
    } else {
        $owner_ringno = "";
    }

    if ($postdetails["gender"]) {
        $gender = $postdetails["gender"];
    } else {
        $gender = "";
    }

    $update_date = date("Y-m-d H:i:s");
    $current_date = date("Y-m-d");
    //$current_date = "2020-10-23";
    $get_event_details = mysqli_query($dbconnection, "select * from ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id where a.event_id = '" . $eventId . "' and date = '" . $current_date . "' and bird_id = '" . $birdId . "'");
    $EventDetails = mysqli_fetch_array($get_event_details);
    $race_distance = $EventDetails["race_distance"];
    $event_id = $EventDetails["event_id"];
    $event_date = $EventDetails["date"];
    $event_start_time = $EventDetails["start_time"];
    $event_end_time = $EventDetails["end_time"];
    $event_details_id = $EventDetails["ed_id"];

    $raceStartDate = strtotime($event_date);
    $raceStartTime = strtotime($event_start_time);
    $extimedata = date('h:i:s A', $raceStartTime);
    $raceStartDateTime = $event_date . ' ' . $extimedata;
    $getTimeDiff = strtotime($trapTime) - strtotime($raceStartDateTime);
    $phour = 0;
    $hours = floor($getTimeDiff / 3600);
    $minutes = floor(($getTimeDiff / 60) % 60);
    $seconds = $getTimeDiff % 60;
    $secondstomin = $seconds / 60;
    $TimeToMinutes = $phour + ($hours * 60) + $minutes + $secondstomin;

    $userInfo = mysqli_query($dbconnection, "select latitude,longitude,phone_no,username,device_id from ppa_register where apptype='" . $apptype . "' and phone_no='" . $phone_no . "' limit 0,1");
    $UserDetails = mysqli_fetch_array($userInfo);
    $userLatitude = $UserDetails["latitude"];
    $userLongitude = $UserDetails["longitude"];
    $UserName = $UserDetails["username"];
    $phone_no = $UserDetails["phone_no"];
    $deviceide = $UserDetails["device_id"];

    $latitude = 0;
    $longitude = 0;
    $distance = 0;

    if (isset($postdetails["latitute"])) {
        $latitude = $postdetails["latitute"];
    }

    if (isset($postdetails["longitude"])) {
        $longitude = $postdetails["longitude"];
    }

    $selectdate = date("Y-m-d");
    //$getEvents = mysqli_query($dbconnection, "select * FROM ppa_events as b where b.Events_id='" . $eventId . "'");
    $getEvents = mysqli_query($dbconnection, "select * FROM ppa_events as b left join ppa_basketing as a on b.Events_id=a.event_id where b.Events_id='" . $eventId . "'");
    
    // select * FROM ppa_events as b left join ppa_basketing as a on b.Events_id=a.event_id left join ppa_register as c on a.fancier_id=c.reg_id where b.Events_id='1168' and c.userToken='f15eda31a2da646eea513b0f81a5414d'

    $eventResults = mysqli_fetch_array($getEvents);
    $eventLatitude = $eventResults["Event_lat"];
    $eventLongitude = $eventResults["Event_long"];
    $getLogitude = $eventLongitude - $userLongitude;
    $getDistance = sin(deg2rad($eventLatitude)) * sin(deg2rad($userLatitude)) + cos(deg2rad($eventLatitude)) * cos(deg2rad($userLatitude)) * cos(deg2rad($getLogitude));
    $getDistance = acos($getDistance);
    $getDistance = rad2deg($getDistance);
    $miles = $getDistance * 60 * 1.1515;
    $distance = $miles * 1.609344; // Converted to Meter
    $getKilometer = number_format($miles, 3) . " Km";
    $velocity = $distance / $TimeToMinutes;

    $bird_color = $postdetails["bird_color"];
    $owner_ringno = $postdetails["ring_no"];
    $gender = $postdetails["gender"];
    $loftdistance = $postdetails[""];
    $deviceTagId = $postdetails["tag_id"];

    $path = "uploads/";

    if (isset($_FILES["filename"]["name"])) 
    {
        $path_parts = pathinfo($_FILES["filename"]["name"]);
        $getTraveTime = explode("_", $path_parts['basename']);
        $TravelTime = explode(".", $getTraveTime[1]);
        $extension = $path_parts['extension'];
        //move_uploaded_file($_FILES["filename"]["tmp_name"], $path . $path_parts['basename']);
        if (!move_uploaded_file($_FILES["filename"]["tmp_name"], $path . $path_parts['basename']))
        {
            $data["status"] = 404;
            $data["message"] = 'Image Not Uploaded';
            echo json_encode($data);
            break;
        }
    }
    else
    {
        if ($deviceTagId != '') 
        {
            $getTraveTime = explode("_", $chitTimeStamp);
            $TravelTime = explode(".", $getTraveTime[1]);
            $path_parts['basename'] = $chitTimeStamp;
        }
        else
        {
            $data["status"] = 404;
            $data["message"] = 'Tag Id is empty';
            echo json_encode($data);
            break;
        }
    }

    $insert_qry = mysqli_query($dbconnection, "insert ppa_updatephoto set username='" . $UserName . "',detected_tag_no='" . $auto_detected_tag_no . "',phone_no='" . $phone_no . "',device_ide='" . $deviceide . "',event_id='" . $eventId . "',event_details_id='" . $event_details_id . "',birdtype='" . $birdId . "',race_distance='" . $race_distance . "',photo_name='" . $path_parts['basename'] . "',club_code='" . $apptype . "',cre_date='" . $update_date . "',owner_ringno='" . $ring_no . "',gender='" . $gender . "',color='" . $bird_color . "',device_tag_id='".$deviceTagId."'");

    $insert_race_details = mysqli_query($dbconnection, "insert ppa_files set device_id='" . $deviceide . "',club_code='" . $apptype . "',event_id='" . $eventId . "',temp_event_id='" . $event_details_id . "',bird_type='" . $birdId . "',username='" . $UserName . "',mobile='" . $phone_no . "',filename='" . $path_parts['basename'] . "',time_interval='" . $TravelTime[0] . "',distance='" . $distance . "',velocity='" . $velocity . "',cre_date='" . $update_date . "',owner_ringno='" . $owner_ringno . "',bird_gender='" . $gender . "',bird_color='" . $bird_color . "',latitude='" . $latitude . "',longitude='" . $longitude . "',tag_device_id='".$deviceTagId."'");

    $updateReports = mysqli_query($dbconnection, "insert ppa_report set start_date='" . $event_date . "',event_sche_date='" . $event_date . "',start_time='" . $event_start_time . "',clubtype='" . $apptype . "',ring_no='" . $owner_ringno . "',bird_color='" . $bird_color . "',event_id='" . $eventId . "',bird_type_id='" . $birdId . "',apptype='" . $apptype . "',bird_gender='" . $gender . "',mobile_number='" . $phone_no . "',name='" . $UserName . "', device_id='" . $deviceide . "',velocity='" . $velocity . "',distance='" . $distance . "',img_name='" . $path_parts['basename'] . "',intervel='" . $TravelTime[0] . "',latitude='" . $latitude . "',longtitude='" . $longitude . "',event_details_id='" . $event_details_id . "',created_date='" . $update_date . "',device_tag='".$deviceTagId."'");

    $data["status"] = 200;
    $data["message"] = 'Race Calculated Successfully';
    $data["total_distance"] = $getKilometer;
    $data["bird_gender"] = $eventResults["gender"];
    $data["ring_no"] = $eventResults["ring_no"];
    $data["color"] = $eventResults["color"];
    
    echo json_encode($data);
    break;    

case 'winnerlist':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    //$secureusertoken = "d7d6f20118e3983813be386db0a1685f";
    $phoneNumber = $postdetails["phone_number"];
    $Name = $postdetails["name"];
    $appType = $postdetails["app_type"];
    $eventId = $postdetails["event_id"];
    $birdtype = $postdetails["birdtype"];
    
    $getUserDetails = mysqli_query($dbconnection, "select * from ppa_register where username='" . $Name . "' and apptype='" . $appType . "'and phone_no='" . $phoneNumber . "' limit 0,1");
    $checkDetails = mysqli_num_rows($getUserDetails);

    if ($checkDetails > 0) {
        $getEventDetails = mysqli_query($dbconnection, "select * from ppa_events where Events_id='" . $eventId . "'  limit 0,1");
        // echo "<pre>getEventDetails:";
        // print_r("select * from ppa_events where Events_id='" . $eventId . "'  limit 0,1");"</pre>";
        $checkEventDetails = mysqli_num_rows($getEventDetails);
        if ($checkEventDetails > 0) {
            $getWinnerDetails = mysqli_query($dbconnection, "select * from ppa_report where event_id='" . $eventId . "' and apptype='" . $appType . "' and bird_type_id='" . $birdtype . "' group by mobile_number order by velocity DESC");
            // echo "<pre>getWinnerDetails:";
            // print_r("select * from ppa_report where event_id='" . $eventId . "' and apptype='" . $appType . "' group by mobile_number order by velocity DESC");"</pre>";
            $WinnerDetails = mysqli_num_rows($getWinnerDetails);
            $i = 0;
            if ($WinnerDetails > 0) {
                // while ($color_res = mysqli_fetch_array($select_color))
                // {
                //     $data["color"][$i]["name"] = $color_res["color"];
                //     $data["color"][$i]["ide"] = $color_res["ide"];
                //     $i++;
                // }
                while ($WinnerList = mysqli_fetch_array($getWinnerDetails)) {
                    //echo "<pre>"; print_r($WinnerList["report_id"]);
                    $data["winner_list"][$i]["report_id"] = $WinnerList["report_id"];
                    $data["winner_list"][$i]["event_start_date"] = $WinnerList["event_sche_date"];
                    $data["winner_list"][$i]["event_start_time"] = $WinnerList["start_time"];
                    $data["winner_list"][$i]["intervel_time"] = $WinnerList["intervel"];
                    $data["winner_list"][$i]["ring_no"] = $WinnerList["ring_no"];
                    $data["winner_list"][$i]["bird_color"] = $WinnerList["bird_color"];
                    $data["winner_list"][$i]["bird_gender"] = $WinnerList["bird_gender"];
                    $data["winner_list"][$i]["apptype"] = $WinnerList["apptype"];
                    $data["winner_list"][$i]["mobile_number"] = $WinnerList["mobile_number"];
                    $data["winner_list"][$i]["name"] = $WinnerList["name"];
                    $data["winner_list"][$i]["device_id"] = $WinnerList["device_id"];
                    $data["winner_list"][$i]["velocity"] = $WinnerList["velocity"] . " Mt/MIN";
                    $data["winner_list"][$i]["distance"] = $WinnerList["distance"];
                    $data["winner_list"][$i]["img_name"] = $SITEMAINURL . "uploads/" . $WinnerList["img_name"];
                    $data["winner_list"][$i]["latitude"] = $WinnerList["latitude"];
                    $data["winner_list"][$i]["longtitude"] = $WinnerList["longtitude"];
                    $data["winner_list"][$i]["event_id"] = $WinnerList["event_id"];
                    $data["winner_list"][$i]["event_details_id"] = $WinnerList["event_details_id"];
                    $data["winner_list"][$i]["bird_type_id"] = $WinnerList["bird_type_id"];
                    $data["winner_list"][$i]["created_date"] = $WinnerList["created_date"];
                    $i++;
                }
                //die;
                //$data["winner_detials"] = $value["winner_list"];
                $data["club_count"] = $WinnerDetails;
                $data["status"] = 200;
                $data["message"] = "Winner List successfully retrieved";
                echo json_encode($data);
                break;
            } else {
                $data["status"] = 404;
                $data["message"] = "Winner List not found";
                echo json_encode($data);
                break;
            }
        } else {
            $data["status"] = 404;
            $data["message"] = "Event Details Not Found";
            echo json_encode($data);
            break;
        }
    } else {
        $data["status"] = 404;
        $data["message"] = "User Details Not Found";
        echo json_encode($data);
        break;
    }
    break;

case 'pigeoninfo':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $select_color = mysqli_query($dbconnection, "select * from pigeons_color");
    $i = 0;
    while ($color_res = mysqli_fetch_array($select_color)) {
        $data["color"][$i]["name"] = $color_res["color"];
        $data["color"][$i]["ide"] = $color_res["ide"];
        $i++;
    }
    $select_birdtypes = mysqli_query($dbconnection, "select * from ppa_bird_type");
    $i = 0;
    while ($birdtype_res = mysqli_fetch_array($select_birdtypes)) {
        $data["birdtype"][$i]["name"] = $birdtype_res["brid_type"];
        $data["birdtype"][$i]["ide"] = $birdtype_res["b_id"];
        $i++;
    }
    echo json_encode($data);
    break;

case 'getevents':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $apptype = $_GET["apptype"];
    $data["url"] = $SITEMAINURL . "admin/app/event.php?club_type=" . $apptype;
    $data["activestatus"] = $activeall;
    $data["expirydate"] = $expirydate;
    $data["isCameraAllowed"] = $cameraAllowed;
    echo json_encode($data);
    break;

case 'raceeventinfo':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $token = $secureusertoken;
    $apptype = $postdetails["clubcode"];
    $userid = $postdetails["userid"];
    $date = $postdetails["date"];
    $curdate = date("Y-m-d h:i A");
    //$dateTimeMinutesAgo = $dateTimeMinutesAgo->format("Y-m-d H:i A");
    $curdate = strtotime($curdate);

    // if ($apptype == "" || $date == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }
    $raceinfo = mysqli_query($dbconnection, "SELECT a.*,b.Event_name,b.Event_lat,b.Event_long,b.Event_date,d.brid_type,a.start_time,a.end_time FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id = b.Events_id LEFT JOIN users as c on c.users_id = b.Org_id LEFT JOIN ppa_bird_type as d on a.bird_id=d.b_id where c.Org_code='" . $apptype . "' and a.date = '" . $date . "' order by a.event_id DESC");

    if (mysqli_num_rows($raceinfo) > 0) {
        $i = 0;

        while ($birdtype_res = mysqli_fetch_array($raceinfo)) {
            $data["raceinfo"][$i]["ed_id"] = $birdtype_res["ed_id"];
            $data["raceinfo"][$i]["event_id"] = $birdtype_res["event_id"];
            $data["raceinfo"][$i]["race_name"] = $birdtype_res["Event_name"];
            $data["raceinfo"][$i]["race_latitude"] = $birdtype_res["Event_lat"];
            $data["raceinfo"][$i]["race_longitude"] = $birdtype_res["Event_long"];

            $cateDate = array();
            $cateDate['brid_type'] = $birdtype_res["brid_type"];
            $cateDate['bird_id'] = $birdtype_res["bird_id"];
            $cateDate['race_distance'] = $birdtype_res["race_distance"];
            $cateDate['boarding_time'] = $birdtype_res["boarding_time"];

            if ($birdtype_res["bird_tag_color"] == "Yellow") {
                $cateDate['bird_tag_color'] = "#FFCC00";
            } else if ($birdtype_res["bird_tag_color"] == "Red") {
                $cateDate['bird_tag_color'] = "#FF3B30";
            } else if ($birdtype_res["bird_tag_color"] == "Blue") {
                $cateDate['bird_tag_color'] = "#007AFF";
            } else if ($birdtype_res["bird_tag_color"] == "Green") {
                $cateDate['bird_tag_color'] = "#34C759";
            } else {
                $cateDate['bird_tag_color'] = "";
            }

            $start_date = $birdtype_res["date"] . ' ' . $birdtype_res["start_time"];
            $end_date = $birdtype_res["date"] . ' ' . $birdtype_res["end_time"];
            $start_date = strtotime($start_date);
            $end_date = strtotime($end_date);
            if ($start_date > $curdate) {
                $cateDate['race_status'] = "Upcoming";
            } else if ($start_date <= $curdate && $end_date >= $curdate) {
                $cateDate['race_status'] = "LIVE";
            } else {
                $cateDate['race_status'] = "Completed";
            }

            $cateDate['start_time'] = $birdtype_res["start_time"];
            $cateDate['end_time'] = $birdtype_res["end_time"];

            $s_date = $birdtype_res["date"] . ' ' . $birdtype_res["start_time"];
            $s_date = new DateTime($s_date);
            $s_date = $s_date->format("Y-m-d\T\ H:i:s.v\Z\ ");
            $e_date = $birdtype_res["date"] . ' ' . $birdtype_res["end_time"];
            $e_date = new DateTime($e_date);
            $e_date = $e_date->format("Y-m-d\T\ H:i:s.v\Z\ ");
            $DateCat = new DateTime($birdtype_res["date"]);
            $DateCat = $DateCat->format("Y-m-d\T\ H:i:s.v\Z\ ");
            $cateDate["cate_start_date"] = $DateCat;
            $cateDate["cate_end_date"] = $e_date;
            $data["raceinfo"][$i]["category"][] = $cateDate;
            $data["raceinfo"][$i]["start_date"] = $s_date;
            $data["raceinfo"][$i]["end_date"] = $e_date;

            if ($start_date > $curdate) {
                $data["raceinfo"][$i]["race_status"] = "Upcoming";
            } else if ($start_date <= $curdate && $end_date >= $curdate) {
                $data["raceinfo"][$i]["race_status"] = "LIVE";
            } else {
                $data["raceinfo"][$i]["race_status"] = "Completed";
            }
            $data["raceinfo"][$i]["race_distance"] = $birdtype_res["race_distance"];
            $data["raceinfo"][$i]["details_status"] = $birdtype_res["details_status"];

            $i++;
        }
        $data["isCameraAllowed"] = $cameraAllowed;
        $data["status"] = 200;

        date_default_timezone_set("Asia/Kolkata");
        $dd = date("Y-m-d H:i:s");
        $given = new DateTime($dd);
        //$localdate["localDate"] = $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e
        $localdate["localDate"] = $given->format("Y-m-d\T\ H:i:s.v\Z\ "); // Y-m-d H:i:s e
        // $given->setTimezone(new DateTimeZone("UTC"));
        //$data["localDate"] = $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e
        $data["localDate"] = $given->format("Y-m-d\T\ H:i:s.v\Z\ "); // Y-m-d H:i:s e
        $given->setTimezone(new DateTimeZone("UTC"));
        //$data["utcDate"] = $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e
        $data["utcDate"] = $given->format("Y-m-d\T\ H:i:s.v\Z\ "); // Y-m-d H:i:s e

        $unixDay = '45000';
        $unixHalfDay = '25200';

        $utcgiven = strtotime($data["utcDate"]);
        $istgiven = strtotime($data["localDate"]);
        // $data["returnType"] = "json";
        $data["timezone"] = "UTC";
        //$data["utctimestamp"] = $utcgiven;
        $data["utctimestamp"] = $utcgiven - $unixHalfDay;
        //$data["isttimestamp"] = $istgiven;
        $data["isttimestamp"] = $istgiven - $unixDay;
        $data["message"] = "Race list for the given date";

        //print_r($data); die;
        echo json_encode($data);
        break;
    } else {
        $data["status"] = 404;
        $data["message"] = "No race found";
    }
    echo json_encode($data);
    break;

case 'winner_list':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $token = $postdetails["userToken"];
    $event_id = $postdetails["Events_id"];
    $userid = $postdetails["userid"];

    $winnerinfo = mysqli_query($dbconnection, "SELECT a.*,b.Event_name FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id = b.Events_id LEFT JOIN users as c on c.users_id = b.Org_id where c.Org_code='" . $apptype . "'");

    if (mysqli_num_rows($winnerinfo) > 0) {
        $i = 0;
        while ($birdtype_res = mysqli_fetch_array($winnerinfo)) {
            $data["winnerinfo"][$i]["ed_id"] = $birdtype_res["ed_id"];
            $data["winnerinfo"][$i]["event_id"] = $birdtype_res["event_id"];
            $data["winnerinfo"][$i]["race_name"] = $birdtype_res["Event_name"];
            $i++;
        }
    } else {
        $data["status"] = 400;
        $data["message"] = "Winner list not found";
    }
    echo json_encode($data);
    break;

case 'current_time':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    date_default_timezone_set("Asia/Kolkata");
    $data["status"] = 3;
    $dd = date("Y-m-d H:i:s");
    $data["timezone"] = strtotime($dd);
    echo json_encode($data);
    break;

case 'locationupdate':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    date_default_timezone_set("Asia/Kolkata");
    $path = "uploads/"; // Upload directory
    $count = 0;
    $latitude = $postdetails["latitude"];
    $longitude = $postdetails["longitude"];
    $raceide = $postdetails["racename"];
    $liberationtime = $postdetails["liberationtime"];
    $userToken = $secureusertoken;

    if ($_FILES['files']['error'] != 4) {
        // No error found! Move uploaded files
        $timeval = time();
        $path_parts = pathinfo($_FILES["files"]["name"]);
        $extension = $path_parts['extension'];
        if (move_uploaded_file($_FILES["files"]["tmp_name"], $path . $path_parts['basename'])) {
            $filespath = $path_parts['basename'];
            $data["status"] = 200;
            $data["message"] = "Race location updated successfully";

            $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
            $entryLogDetail = mysqli_fetch_array($entrylogQuery);
            $username = $entryLogDetail["username"];
            $user_id = $entryLogDetail["reg_id"];
            $action = "Location update";
            $desc = $username . " Race location updated successfully";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);


            $data["activestatus"] = 0;
            $data["expirydate"] = $expirydate;
            $data["isCameraAllowed"] = $cameraAllowed;

            $update_eventloation = mysqli_query($dbconnection, "update ppa_events set liberation_url='" . $filespath . "',liberation_time='" . $liberationtime . "',Event_lat='" . $latitude . "',Event_long='" . $longitude . "' where Events_id='" . $raceide . "'");
        } else {
            $data["status"] = 400;
            $data["message"] = "Problem in updating liberation location-1";

            $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
            $entryLogDetail = mysqli_fetch_array($entrylogQuery);
            $username = $entryLogDetail["username"];
            $user_id = $entryLogDetail["reg_id"];
            $action = "locationupdate";
            $desc = $username . " Problem in updating liberation location";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);

        }
    } else {
        $data["status"] = 400;
        $data["message"] = "Problem in updating the liberation location-2";

        $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
        $entryLogDetail = mysqli_fetch_array($entrylogQuery);
        $username = $entryLogDetail["username"];
        $user_id = $entryLogDetail["reg_id"];
        $action = "locationupdate";
        $desc = $username . " Problem in updating liberation location";
        $userId = $user_id;
        entrylog($action,$desc, $userId,$dbconnection);
            
    }
    echo json_encode($data);
    break;

case 'liberationInfo':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $raceId = $postdetails["race_id"];
    $raceList = mysqli_query($dbconnection, "select * from ppa_events where Events_id='" . $raceId . "'");
    if (mysqli_num_rows($raceList) > 0) {
        $raceListDetails = mysqli_fetch_array($raceList);
        $data["status"] = 200;
        $data["message"] = "Liberation Details Successfully Retrived";
        $data["latitude"] = $raceListDetails["Event_lat"];
        $data["longitude"] = $raceListDetails["Event_long"];
        $data["event_date"] = $raceListDetails["Event_date"];
        $data["event_name"] = $raceListDetails["Event_name"];
        $data["event_status"] = $raceListDetails["Event_status"];
        //$data["location_image"] = $SITEMAINURL . "uploads/" . $raceListDetails["liberation_url"];

        // if (!empty($data["location_image"])) {
        //     $data["location_image"] = $SITEMAINURL . "uploads/" . $raceListDetails["liberation_url"];
        // } else {
        //     $data["location_image"] = $SITEMAINURL . "uploads/no-image.png";
        // }

        if ($raceListDetails["liberation_url"] != '') {
            $data["location_image"] = $SITEMAINURL . "uploads/" . $raceListDetails["liberation_url"];
        } else {
            //$data["location_image"] = $SITEMAINURL . "uploads/no-image.png";
            $data["location_image"] = "";

        }

        $data["result_publish"] = $raceListDetails["result_publish"];
    } else {
        $data["status"] = 404;
        $data["message"] = "Liberation Details Not Found";
    }
    echo json_encode($data);
    break;

case 'raceDetails':
    /*$authuser = checkauth($dbconnection,$secureusertoken);
    if($authuser=="0" || $authuser=="")
    {
    $data["status"]=404;
    $data["msg"]="Authentication failed";
    echo json_encode($data);
    break;
     */
    $apptype = $postdetails["apptype"];
    date_default_timezone_set("Asia/Kolkata");
    $currdate = date('Y-m-d');
    $date = new DateTime($currdate); // For today/now, don't pass an arg.
    $date->modify("-3 day");
    $fromdate = $date->format("Y-m-d");
    $date2 = new DateTime($currdate);
    $date2->modify("+3 day");
    $todate = $date2->format("Y-m-d");

    // $fromdate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
    //$todate   = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $date) ) ));

    //$select_races = mysqli_query($dbconnection,"select a.Event_name,a.Events_id from ppa_events as a LEFT JOIN users as b ON b.users_id=a.Org_id where b.Org_code='".$apptype."' and YEARWEEK(a.Event_date) = YEARWEEK(NOW()) group by a.Events_id order by a.Events_id DESC");
    $select_races = mysqli_query($dbconnection, "select a.Event_name,a.Events_id from ppa_events as a LEFT JOIN users as b ON b.users_id=a.Org_id where b.Org_code='" . $apptype . "' and a.Event_date >= '" . $fromdate . "' and a.Event_date <= '" . $todate . "' group by a.Events_id order by a.Events_id DESC");
    $i = 0;

    if (mysqli_num_rows($select_races) == 0) {
        $temp = array();
        $data["status"] = 0;
        $data["racelist"] = $temp;
    } else {
        while ($race_res = mysqli_fetch_array($select_races)) {
            //$data["race"][$i]["name"]  = $race_res["Event_name"]." ( ".$race_res["Event_name"]." )";
            //$data["race"][$i]["ide"]  = $race_res["Events_id"];

            $raceide = $race_res["Events_id"];
            //$bird_id = $race_res["bird_id"];
            $temp = array();
            $temp1 = array();
            $temp["racename"] = $race_res["Event_name"];
            $temp["raceid"] = $race_res["Events_id"];
            //$data[] = $temp;
            $select_races_details = mysqli_query($dbconnection, "select c.ed_id,c.bird_id,d.brid_type from ppa_event_details as c LEFT JOIN ppa_bird_type as d ON d.b_id=c.bird_id where c.event_id='" . $raceide . "' group by bird_id ORDER by ed_id ASC");

            while ($race_res_det = mysqli_fetch_array($select_races_details)) {
                //$temp1["category"] = $race_res_det["brid_type"]."#".$race_res_det["ed_id"];
                $temp1["category"] = $race_res_det["brid_type"] . "#" . $race_res_det["ed_id"];
                $temp1["categoryid"] = $race_res_det["bird_id"];
                $temp["raceCategegory"][] = $temp1;
            }
            $data["status"] = 1;
            $data["racelist"][] = $temp;
            $i++;
        }
    }
    echo json_encode($data);
    break;

case 'racebefore_ten':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $token = $postdetails["userToken"];
    $apptype = $postdetails["clubcode"];
    $userid = $postdetails["userid"];
    $date = $postdetails["date"];
    $raceinfo = mysqli_query($dbconnection, "SELECT a.*,b.Event_name,b.Event_lat,b.Event_long FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id = b.Events_id LEFT JOIN users as c on c.users_id = b.Org_id where c.Org_code='" . $apptype . "' and a.date = '" . $date . "' order by a.event_id DESC");
    $i = 0;
    while ($birdtype_res = mysqli_fetch_array($raceinfo)) {
        $data["raceinfo"][$i]["ed_id"] = $birdtype_res["ed_id"];
        $data["raceinfo"][$i]["event_id"] = $birdtype_res["event_id"];
        $data["raceinfo"][$i]["race_name"] = $birdtype_res["Event_name"];
        $data["raceinfo"][$i]["race_latitude"] = $birdtype_res["Event_lat"];
        $data["raceinfo"][$i]["race_longitude"] = $birdtype_res["Event_long"];
        $data["raceinfo"][$i]["bird_id"] = $birdtype_res["bird_id"];
        $data["raceinfo"][$i]["date"] = $birdtype_res["date"];
        $data["raceinfo"][$i]["start_time"] = $birdtype_res["start_time"];
        $data["raceinfo"][$i]["end_time"] = $birdtype_res["end_time"];
        $data["raceinfo"][$i]["race_distance"] = $birdtype_res["race_distance"];
        $data["raceinfo"][$i]["boarding_time"] = $birdtype_res["boarding_time"];
        $data["raceinfo"][$i]["details_status"] = $birdtype_res["details_status"];
        $i++;
    }
    echo json_encode($data);
    break;

case 'syncinfo':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    error_reporting(-1);
    ini_set('display_errors', 1);
    date_default_timezone_set("Asia/Kolkata");
    $dd = date("Y-m-d H:i:s");
    $given = new DateTime($dd);
    $localdate["localDate"] = $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e
    // $given->setTimezone(new DateTimeZone("UTC"));
    // $utcdate["utcDate"] = $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e
    // $str_utcgiven = strtotime($utcdate["utcDate"]);
    // $str_istgiven = strtotime($localdate["localDate"]);
    // $returnType["returnType"] = "json";
    // $utc["timezone"] = "UTC";
    // //$data["daylightSavingTime"] = false;
    // $url["url"] = $SITEMAINURL . "lespoton_new_version.php";
    // $utcgiven["timestamp"] = $str_utcgiven;
    // $istgiven["isttimestamp"] = $str_istgiven;

    $data["localDate"] = $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e
    $given->setTimezone(new DateTimeZone("UTC"));
    $data["utcDate"] = $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e
    // $unixDay = '86400';
    //$unixHalfDay = '43200';
    $unixHalfDay = '19800';
    $utcgiven = strtotime($data["utcDate"]);
    $istgiven = strtotime($data["localDate"]);
    $data["returnType"] = "json";
    $data["timezone"] = "UTC";
    //$data["daylightSavingTime"] = false;
    $data["url"] = $SITEMAINURL . "lespoton_new_version.php";
    $data["utctimestamp"] = $utcgiven + $unixHalfDay;
    // $data["utctimestamp"] = $utcgiven;
    //$data["timestamp"] = $utcgiven + $unixHalfDay;
    $data["isttimestamp"] = $istgiven;

    $apptype = $postdetails["apptype"];
    if (isset($postdetails["phone"])) {
        $phone_no = $postdetails["phone"];
    } else {
        $phone_no = 0;
    }

    // $selectavailability = mysqli_query($dbconnection, "select usertype from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "' limit 0,1");

    $selectavailability = mysqli_query($dbconnection, "select apptype, usertype, TimeZone from ppa_register as a left join users as b on a.apptype=b.Org_code where a.phone_no='" . $phone_no . "' and a.apptype='" . $apptype . "' limit 0,1");
    $userData = mysqli_num_rows($selectavailability);

    if ($userData > 0) {
        $accdetails = mysqli_fetch_array($selectavailability);
        $data["usertype"] = $accdetails["usertype"];
        $data["country"] = $accdetails["TimeZone"];
        $data["status"] = 200;
        $data["message"] = "UTC Timings successfully retrieved";
        echo json_encode($data);
        break;
    } else {
        $data["status"] = 404;
        $data["message"] = "User list not found";
        echo json_encode($data);
        break;
    }
    break;

case 'loftstatus':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $apptype = $postdetails["apptype"];
    $deviceide = $postdetails["deivce_id"];
    $phone_no = $postdetails["phone_no"];
    $select_loftstat = mysqli_query($dbconnection, "select * from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "'");
    if (mysqli_num_rows($select_loftstat) > 0) {
        $details = mysqli_fetch_array($select_loftstat);
        $data["loftstatus"] = $details["loftstatus"];
    } else {
        $data["loftstatus"] = 0;
    }

    $data["status"] = 1;
    $data["activestatus"] = $activeall;
    $data["expirydate"] = $expirydate;
    $data["isCameraAllowed"] = $cameraAllowed;
    echo json_encode($data);
    break;

case 'accountstatus':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $apptype = $postdetails["apptype"];
    $deviceide = $postdetails["deivce_id"];
    $phone_no = $postdetails["phone_no"];
    $select_loftstat = mysqli_query($dbconnection, "select * from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "'");
    if (mysqli_num_rows($select_loftstat) > 0) {
        $details = mysqli_fetch_array($select_loftstat);
        $data["accountstatus"] = $details["status"];
    } else {
        $data["accountstatus"] = 0;
    }

    $data["status"] = 1;
    $data["activestatus"] = $activeall;
    $data["expirydate"] = $expirydate;
    $data["isCameraAllowed"] = $cameraAllowed;
    echo json_encode($data);
    break;

case 'loftdetail':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $apptype = $postdetails["apptype"];
    $deviceide = $postdetails["deivce_id"];
    $phone_no = $postdetails["phone_no"];

    $select_loftstat = mysqli_query($dbconnection, "select * from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "'");

    if (mysqli_num_rows($select_loftstat) > 0) {
        $details = mysqli_fetch_array($select_loftstat);

        $data["loftstatus"] = $details["loftstatus"];
        $data["loft_image"] = $SITEMAINURL . "uploads/" . $details["loft_image"];
        $data["latitude"] = $details["latitude"];
        $data["longitude"] = $details["longitude"];

    } else {
        $data["loftstatus"] = 0;
        $data["loft_image"] = "";
        $data["latitude"] = "";
        $data["longitude"] = "";
    }

    $data["status"] = 1;
    $data["activestatus"] = $activeall;
    $data["expirydate"] = $expirydate;
    $data["isCameraAllowed"] = $cameraAllowed;
    echo json_encode($data);
    break;

case 'loftinfo':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $userToken = $secureusertoken;
    $apptype = $postdetails["apptype"];

    $select_loftstat = mysqli_query($dbconnection, "select * from ppa_register where apptype='" . $apptype . "' and userToken='" . $userToken . "'");

    if (mysqli_num_rows($select_loftstat) > 0) {
        $details = mysqli_fetch_array($select_loftstat);
        if ($details["loftstatus"] == 1) {
            $data["status"] = 200;
            $data["message"] = "Loft status active";
            $data["loftstatus"] = $details["loftstatus"];
            $data["loft_image"] = $details["loft_image"];

            if (!empty($data["loft_image"])) {
                $data["loft_image"] = $SITEMAINURL . "uploads/" . $details["loft_image"];
            } else {
                $data["loft_image"] = $SITEMAINURL . "uploads/no-image.png";
            }

            if (isset($details["latitude"]) && !empty($details["latitude"])) {
                $data["latitude"] = $details["latitude"];
            } else {
                $data["latitude"] = "0";
            }

            if (isset($details["longitude"]) && !empty($details["longitude"])) {
                $data["longitude"] = $details["longitude"];
            } else {
                $data["longitude"] = "0";
            }

        } else {
            $data["status"] = 200;
            $data["message"] = "Loft status inactive";
            $data["loftstatus"] = $details["loftstatus"];
            $data["loft_image"] = $details["loft_image"];

            if (!empty($data["loft_image"])) {
                $data["loft_image"] = $SITEMAINURL . "uploads/" . $details["loft_image"];
            } else {
                //$data["loft_image"] = $SITEMAINURL . "uploads/no-image.png";
                $data["loft_image"] = "";
            }

            if (isset($details["latitude"]) && !empty($details["latitude"])) {
                $data["latitude"] = $details["latitude"];
            } else {
                $data["latitude"] = "0.0";
            }

            if (isset($details["longitude"]) && !empty($details["longitude"])) {
                $data["longitude"] = $details["longitude"];
            } else {
                $data["longitude"] = "0.0";
            }

        }
    } else {
        $data["status"] = 404;
        $data["message"] = "Loft Details Not Found";
        $data["loft_image"] = "";
        $data["latitude"] = "";
        $data["longitude"] = "";
    }
    echo json_encode($data);
    break;

case 'notification_setting':
    // $apptype = $postdetails["apptype"];
    // $deviceide = $postdetails["deivce_id"];
    // $phone_no = $postdetails["phone_no"];
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $status = $postdetails["notify_status"];
    $user_id = $secureusertoken;

    // if ($status == "" || $apptype == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }

    $notificationQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $user_id . "'");

    $numNotification = mysqli_num_rows($notificationQuery);

    if (mysqli_num_rows($notificationQuery) > 0) {
        $notificationDetails = mysqli_fetch_array($notificationQuery);
        $data["userToken"] = $notificationDetails["userToken"];

        $updateNoticationQuery = mysqli_query($dbconnection, "update ppa_register set notify_status='" . $status . "' where userToken='" . $notificationDetails["userToken"] . "'");

        $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $user_id . "' limit 0,1");
        $entryLogDetail = mysqli_fetch_array($entrylogQuery);
        $username = $entryLogDetail["username"];
        $user_id = $entryLogDetail["reg_id"];
        $action = "Notification settings";
        $desc = $username . " Notification settings has been updated";
        $userId = $user_id;
        entrylog($action,$desc, $userId,$dbconnection);


    } else {
        $data["userToken"] = "";
    }

    if ($status == "1") {
        $data["status"] = 200;
        $data["message"] = "Notification setting is enabled";
        $data["notification_status"] = 1;
    } else {
        $data["status"] = 200;
        $data["message"] = "Notification setting is disabled";
        $data["notification_status"] = 0;
    }

    echo json_encode($data);
    break;

case 'fancier_list':
    // $userToken = $postdetails["userToken"];
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }

    $apptype = $postdetails["apptype"];
    $raceid = $postdetails["raceide"];
    $birdtype = $postdetails["birdtype"];

    // if ($user_id == "" || $username == "" || $language == "" || $country == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }

    // $select_races = mysqli_query($dbconnection, "select b.* from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id = b.reg_id LEFT JOIN ppa_event_details as d ON d.ed_id = a.event_id LEFT JOIN ppa_events as e ON d.event_id = a.event_id LEFT JOIN ppa_event_details as f ON f.ed_id=a.event_details_id where a.event_id='" . $raceid . "' and a.org_code='" . $apptype . "'");

    $select_races = mysqli_query($dbconnection, "select DISTINCT b.* from ppa_basketing as a LEFT JOIN ppa_register as b ON a.fancier_id = b.reg_id LEFT JOIN ppa_event_details as d ON d.ed_id = a.event_id LEFT JOIN ppa_events as e ON d.event_id = a.event_id LEFT JOIN ppa_event_details as f ON f.ed_id=a.event_details_id where a.event_id='" . $raceid . "' and a.bird_type='" . $birdtype . "'AND a.org_code='".$apptype."'");

    $fancierCount = mysqli_num_rows($select_races);

    if ($fancierCount > 0) 
    {
        $i = 0;
        while ($race_res = mysqli_fetch_array($select_races)) 
        {
            if (isset($race_res["reg_id"])) 
            {
                $data["fancier"][$i]["reg_id"] = $race_res["reg_id"];
                $data["fancier"][$i]["latitude"] = $race_res["latitude"];
                $data["fancier"][$i]["longitude"] = $race_res["longitude"];
                $data["fancier"][$i]["apptype"] = $race_res["apptype"];
                $data["fancier"][$i]["usertype"] = $race_res["usertype"];
                $data["fancier"][$i]["username"] = $race_res["username"];
                $data["fancier"][$i]["phone_no"] = $race_res["phone_no"];

                $data["fancier"][$i]["address"] = $race_res["address"];
                if ($race_res["address"] != "") 
                {
                    $data["fancier"][$i]["address"] = $race_res["address"];
                } 
                else 
                {
                    $data["fancier"][$i]["address"] = "";
                }

                $data["fancier"][$i]["loftstatus"] = $race_res["loftstatus"];
                $data["fancier"][$i]["deviceName"] = $race_res["deviceName"];
                $data["fancier"][$i]["macAddress"] = $race_res["macAddress"];
                //$data["fancier"][$i]["deviceYear"] = $race_res["deviceYear"];

                $data["fancier"][$i]["deviceYear"] = $race_res["deviceYear"];
                if ($race_res["deviceYear"] != "") 
                {
                    $data["fancier"][$i]["deviceYear"] = $race_res["deviceYear"];
                } 
                else 
                {
                    $data["fancier"][$i]["deviceYear"] = "";
                }
                $i++;
            }
            
        }
        $data["status"] = 200;
        $data["message"] = 'Fanicer list retrieved successfully';
        echo json_encode($data);
        break;
    } else {
        $data["status"] = 404;
        $data["message"] = "Incorrect user details";
        echo json_encode($data);
        break;
    }

    //echo json_encode($data);
    break;

case 'fancierdetails':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $userToken = $secureusertoken;
    $apptype = $postdetails["apptype"];
    $checkuserauth = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $secureusertoken . "'");
    $userData = mysqli_num_rows($checkuserauth);
    if ($userData > 0) {
        $selectfanciers = mysqli_query($dbconnection, "select * from ppa_register WHERE apptype='" . $apptype . "'");
        $fancierCount = mysqli_num_rows($selectfanciers);
        $i = 0;
        if ($fancierCount > 0) {
            while ($fancierList = mysqli_fetch_array($selectfanciers)) {
                $data["fancierList"][$i]["userToken"] = $fancierList["userToken"];
                $data["fancierList"][$i]["username"] = $fancierList["username"];
                $data["fancierList"][$i]["phone_no"] = $fancierList["phone_no"];
                $data["fancierList"][$i]["apptype"] = $fancierList["apptype"];
                $data["fancierList"][$i]["accountstatus"] = $fancierList["status"];
                $data["fancierList"][$i]["reg_id"] = $fancierList["reg_id"];
                $data["fancierList"][$i]["android_id"] = $fancierList["android_id"];

                if ($data["fancierList"][$i]["android_id"] != "") {
                    $data["fancierList"][$i]["android_id"] = $fancierList["android_id"];
                } else {
                    $data["fancierList"][$i]["android_id"] = "0";
                }

                $data["fancierList"][$i]["phone_no"] = $fancierList["phone_no"];
                $data["fancierList"][$i]["loftstatus"] = $fancierList["loftstatus"];
                $data["fancierList"][$i]["read_type"] = $fancierList["read_type"];
                $data["fancierList"][$i]["profile_url"] = $fancierList["profile_pic"];

                if ($data["fancierList"][$i]["profile_url"] != "") {
                    $data["fancierList"][$i]["profile_url"] = $SITEMAINURL . "uploads/" . $fancierList["profile_pic"];
                } else {
                    $data["fancierList"][$i]["profile_url"] = $SITEMAINURL . "uploads/no-image.png";
                }
                $i++;
            }
            $data["fancier_count"] = $fancierCount;
            $data["status"] = 200;
            $data["message"] = "Fancier List successfully retrieved";
        } else {
            $data["status"] = 404;
            $data["message"] = "Fancier list not found";
        }
        echo json_encode($data);
    } else {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    break;

// $selectfanciers = mysqli_query($dbconnection, "select * from ppa_register WHERE apptype='" . $apptype . "'");
// // echo "select * from ppa_register WHERE apptype='" . $apptype . "'";die;
// $accdetails = mysqli_fetch_array($selectfanciers);

// $ide = $accdetails["reg_id"];
// $data["status"] = 1;
// $data["userToken"] = $accdetails["userToken"];
// $data["username"] = $accdetails["username"];
// $data["phone_no"] = $accdetails["phone_no"];
// $data["apptype"] = $accdetails["apptype"];
// $data["accountstatus"] = $accdetails["status"];
// $data["android_id"] = $accdetails["android_id"];

// if ($data["android_id"] != "") {
//     $data["android_id"] = $accdetails["android_id"];
// } else {
//     $data["android_id"] = "0";
// }

// $data["userId"] = $ide;
// //$data["Orgphone_no"] = $phone_num;
// if ($data["Orgphone_no"] != "") {
//     $data["Orgphone_no"] = $phone_num;
// } else {
//     $data["Orgphone_no"] = "0";
// }
// $data["usertype"] = $accdetails["usertype"];
// $data["loftstatus"] = $accdetails["loftstatus"];
// $data["profile_url"] = $SITEMAINURL . "uploads/" . $accdetails["profile_pic"];
// echo json_encode($data);
// break;

case 'fileupload':
    $authuser = checkauth($dbconnection, $secureusertoken);

    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    date_default_timezone_set("Asia/Kolkata");
    $update_date = date("Y-m-d H:i:s");
    $path = "uploads/"; // Upload directory
    $count = 0;
    $phone_no = $_POST["phone_no"];
    $username = $_POST["username"];
    $apptype = $_POST["apptype"];
    $latitude = "";
    $longitude = "";

    $currdate = date('Y-m-d');
    $date = new DateTime($currdate); // For today/now, don't pass an arg.
    $date->modify("-3 day");
    $fromdate = $date->format("Y-m-d");
    $date2 = new DateTime($currdate);
    $date2->modify("+3 day");
    $todate = $date2->format("Y-m-d");

    $raceinfo = mysqli_query($dbconnection, "SELECT a.event_id FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id = b.Events_id LEFT JOIN users as c on c.users_id = b.Org_id where c.Org_code='" . $apptype . "' and a.date >= '" . $fromdate . "' and a.date <= '" . $todate . "' order by a.event_id DESC limit 0,1");
    $sel_curr_raceinfo = mysqli_fetch_array($raceinfo);
    $raceide = $sel_curr_raceinfo["event_id"];

    if ($_FILES['files']['error'] != 4) {
        // No error found! Move uploaded files
        $timeval = time();
        $path_parts = pathinfo($_FILES["files"]["name"]);
        $extension = $path_parts['extension'];
        if (move_uploaded_file($_FILES["files"]["tmp_name"], $path . $path_parts['basename'])) {

            // SELECT * FROM ppa_event_details as a LEFT JOIN ppa_events as b ON b.Events_id=a.event_id LEFT JOIN ppa_oraganization as c ON c.Org_id=b.Org_id where c.Org_code='PPA'

            $filespath = $path_parts['basename'];
            $data["status"] = 1;
            $data["activestatus"] = $activeall;
            $data["expirydate"] = $expirydate;
            $data["isCameraAllowed"] = $cameraAllowed;
            $latitude = $_POST["latitude"];
            $longitude = $_POST["longitude"];
            if (isset($_POST["interval"])) {
                $interval = $_POST["interval"];
                //newly added

                $dt = new DateTime();
                $dt->setTimestamp($interval / 1000);
                $timezone = "Asia/Kolkata";
                $dt->setTimezone(new DateTimeZone($timezone));
                $update_date = $dt->format("Y-m-d H:i:s");

                //newly added
            } else {
                $interval = "";
            }

            // $deviceide  = $_POST["deivce_id"];
            if (isset($_POST["phone_no"])) {
                $phone_no = $_POST["phone_no"];
            } else {
                $phone_no = '';
            }

            $insert_qry = mysqli_query($dbconnection, "insert ppa_files set temp_event_id='" . $raceide . "',latitude='" . $latitude . "',longitude='" . $longitude . "',club_code='" . $apptype . "',filename='" . $filespath . "',time_interval='" . $interval . "',mobile='" . $phone_no . "',username='" . $username . "',cre_date='" . $update_date . "'");

            sendnotification($dbconnection, $apptype, $phone_no, $username);
        } else {
            $data["status"] = 0;
            $data["activestatus"] = $activeall;
            $data["expirydate"] = $expirydate;
            $data["isCameraAllowed"] = $cameraAllowed;
        }
    } else {
        $data["status"] = 0;
        $data["activestatus"] = $activeall;
        $data["expirydate"] = $expirydate;
        $data["isCameraAllowed"] = $cameraAllowed;
    }

    echo json_encode($data);
    break;

case 'device_token':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $user_id = $secureusertoken;
    $deviceToken = $postdetails["deviceToken"];

    // if ($deviceToken == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }

    $notificationQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $user_id . "' limit 0,1");
    $numNotification = mysqli_num_rows($notificationQuery);

    if ($numNotification > 0) {
        $data["userToken"] = $user_id;
        $updateNoticationQuery = mysqli_query($dbconnection, "update ppa_register set android_id='" . $deviceToken . "' where userToken='" . $data["userToken"] . "'");

        $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $user_id . "' limit 0,1");
        $entryLogDetail = mysqli_fetch_array($entrylogQuery);
        $username = $entryLogDetail["username"];
        $user_id = $entryLogDetail["reg_id"];
        $action = "Device Token";
        $desc = $username . " Device Token updated successfully";
        $userId = $user_id;
        entrylog($action,$desc, $userId,$dbconnection);


    } else {
        $data["userToken"] = "";
    }

    $data["status"] = 200;
    $data["message"] = "Success";

    echo json_encode($data);
    break;

case 'notification_list':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $userToken = $secureusertoken;
    $user_id = $postdetails["user_id"];

    // if ($user_id == "") {
    //     $data["status"] = 400;
    //     $data["message"] = "Required param is Null";
    //     echo json_encode($data);
    //     break;
    // }

    if ($userToken != "") {
        $selectfanciers = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' and reg_id='" . $user_id . "' limit 0,1");
        $i = 0;
        if (mysqli_num_rows($selectfanciers) > 0) {
            $getNotification = mysqli_query($dbconnection, "select * from notificationlog where userToken='" . $userToken . "'");
            if (mysqli_num_rows($getNotification) > 0) {
                while ($accdetails = mysqli_fetch_array($getNotification)) {
                    $data["status"] = 200;
                    $data["message"] = "Race notification list";
                    $data["notification_list"][$i]["user_id"] = $accdetails["userToken"];
                    $data["notification_list"][$i]["updatedTime"] = $accdetails["updatedTime"];
                    $data["notification_list"][$i]["notifcation"] = $accdetails["Message"];
                    $i++;
                }
            } else {
                $data["status"] = 404;
                $data["message"] = "No Notification List Found";
            }
        } else {
            $data["status"] = 404;
            $data["message"] = "No User Found";
        }
    } else {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
    }
    echo json_encode($data);
    break;

case 'ppaexpiry':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }

    $apptype = $postdetails["apptype"];
    $code = $postdetails["code"];
    $deviceide = $postdetails["deivce_id"];
    $phone_no = $postdetails["phone_no"];
    $fcm_id = $postdetails["fcm_id"];
    $selectuserstatus = mysqli_query($dbconnection, "select * from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "'");
    // get org contact number
    $orgcont_details = mysqli_query($dbconnection, "select * from users where Org_code='" . $apptype . "'");
    $orgcontactdet = mysqli_fetch_array($orgcont_details);
    $phone_num = "8015512308"; //$orgcontactdet["phone_no"];
    $data["Orgphone_no"] = $phone_num;
    //
    if (mysqli_num_rows($selectuserstatus) > 0) {
        $accdetails = mysqli_fetch_array($selectuserstatus);
        $data["accountstatus"] = $accdetails["status"];
        $data["loftstatus"] = $accdetails["loftstatus"];
        $data["latitude"] = $accdetails["latitude"];
        $data["longitude"] = $accdetails["longitude"];
        $data["reg_id"] = $accdetails["reg_id"];
        $updatefcm_det = mysqli_query($dbconnection, "update ppa_register set android_id='" . $fcm_id . "' where reg_id='" . $accdetails["reg_id"] . "'");

        $data["loft_image"] = $SITEMAINURL . "uploads/" . $accdetails["loft_image"];
    } else {
        $data["accountstatus"] = 0;
        $data["loftstatus"] = 0;
        $data["latitude"] = "";
        $data["longitude"] = "";
        $data["loft_image"] = "";
    }
    $data["isCameraAllowed"] = $cameraAllowed;

    $data["status"] = 1;
    $data["activestatus"] = $activeall;
    $data["expirydate"] = $expirydate;
    echo json_encode($data);
    break;

case 'logout':
    // $authuser = checkauth($dbconnection, $secureusertoken);
    // if ($authuser == "0" || $authuser == "") {
    //     $data["status"] = 401;
    //     $data["message"] = "Authentication failed";
    //     echo json_encode($data);
    //     break;
    // }
    $app_type = $postdetails["app_type"];
    $reg_id = $postdetails["reg_id"];
    // $userToken = $postdetails["userToken"];

    if ($reg_id != "") {
        //$selectuser = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' and reg_id='" . $reg_id . "'");
        $selectuser = mysqli_query($dbconnection, "select * from ppa_register where reg_id='" . $reg_id . "'");
        if (mysqli_num_rows($selectuser) > 0) {
            $usetoken_remove_qry = mysqli_query($dbconnection, "update ppa_register set userToken='' WHERE reg_id='" . $reg_id . "'");

            $accdetails = mysqli_fetch_array($selectuser);
            $data["status"] = 200;
            $data["message"] = "User Token removed successfully";

            $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where reg_id='" . $reg_id . "' limit 0,1");
            $entryLogDetail = mysqli_fetch_array($entrylogQuery);
            $username = $entryLogDetail["username"];
            $user_id = $entryLogDetail["reg_id"];
            $action = "Logout";
            $desc = $username . " your token has been removed successfully from our system";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);


        } else {
            $data["status"] = 404;
            $data["message"] = "No User Found";
        }
    } else {
        $data["status"] = 400;
        $data["message"] = "Required param is Null";
    }
    echo json_encode($data);
    break;

case 'syncinfo':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $userToken = $secureusertoken;

    // error_reporting(-1);
    // ini_set('display_errors', 1);
    date_default_timezone_set("Asia/Kolkata");
    $dd = date("Y-m-d H:i:s");
    $given = new DateTime($dd);
    $data["localDate"] = $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e
    $given->setTimezone(new DateTimeZone("UTC"));
    $data["utcDate"] = $given->format("m/d/Y H:i:s"); // Y-m-d H:i:s e
    $utcgiven = strtotime($data["utcDate"]);
    $istgiven = strtotime($data["localDate"]);
    $data["returnType"] = "json";
    $data["timezone"] = "UTC";
    //$data["daylightSavingTime"] = false;
    $data["url"] = $SITEMAINURL . "newapi.php";
    $data["timestamp"] = $utcgiven;
    $data["isttimestamp"] = $istgiven;

    $apptype = $postdetails["apptype"];
    if (isset($postdetails["phone"])) {
        $phone_no = $postdetails["phone"];
    } else {
        $phone_no = 0;
    }

    $selectavailability = mysqli_query($dbconnection, "select usertype from ppa_register where phone_no='" . $phone_no . "' and apptype='" . $apptype . "'");

    $accdetails = mysqli_fetch_array($selectavailability);
    $data["usertype"] = $accdetails["usertype"];

    echo json_encode($data);
    break;

case 'ppa_bluetooth':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    $apptype = $postdetails["apptype"];
    $bluetooth_id = $postdetails["bluetooth_id"];
    $userToken = $secureusertoken;

    if ($bluetooth_id != "") {
        $selectuser = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' and apptype='" . $apptype . "'");
        if (mysqli_num_rows($selectuser) > 0) {
            $updatebluetooth_qry = mysqli_query($dbconnection, "update ppa_register set bluetooth_id='" . $bluetooth_id . "' WHERE userToken='" . $userToken . "' and apptype='" . $apptype . "'");

            $bluetoothdetails = mysqli_fetch_array($selectuser);
            $data["status"] = 200;
            $data["message"] = "Bluetooth ID updated";

            $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
            $entryLogDetail = mysqli_fetch_array($entrylogQuery);
            $username = $entryLogDetail["username"];
            $user_id = $entryLogDetail["reg_id"];
            $action = "Bluetooth";
            $desc = $username . " Bluetooth details has been updated successfully in our system";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);


        } else {
            $data["status"] = 404;
            $data["message"] = "No User Found";

            $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $userToken . "' limit 0,1");
            $entryLogDetail = mysqli_fetch_array($entrylogQuery);
            $username = $entryLogDetail["username"];
            $user_id = $entryLogDetail["reg_id"];
            $action = "Bluetooth";
            $desc = $username . " Entered bluetooth details is not matched with our system";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);

        }
    } else {
        $data["status"] = 400;
        $data["message"] = "Required param is Null";
    }
    echo json_encode($data);
    break;

case 'liberationupdate':
    $authuser = checkauth($dbconnection, $secureusertoken);
    if ($authuser == "0" || $authuser == "") {
        $data["status"] = 401;
        $data["message"] = "Authentication failed";
        echo json_encode($data);
        break;
    }
    date_default_timezone_set("Asia/Kolkata");
    $path = "uploads/"; // Upload directory
    $count = 0;
    $latitude = $postdetails["latitude"];
    $longitude = $postdetails["longitude"];
    $raceide = $postdetails["racename"];
    $liberationtime = $postdetails["liberationtime"];

    if ($_FILES['files']['error'] != 4) {
        // No error found! Move uploaded files
        $timeval = time();
        $path_parts = pathinfo($_FILES["files"]["name"]);
        $extension = $path_parts['extension'];
        if (move_uploaded_file($_FILES["files"]["tmp_name"], $path . $path_parts['basename'])) {

            $userInfo = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $authuser . "'");
            if (mysqli_num_rows($userInfo) > 0) {
                $userList = mysqli_fetch_array($userInfo);

                $android_deviceide = $userList['android_id'];
                $apptype = $userList['apptype'];
                $fancierphone_no = $userList['phone_no'];
                $fancierusername = $userList['username'];
                $userreg_id = $userList['reg_id'];
                $badge = 1;
                $notify_key = 1;

                $title = "Liberation update";
                $message = "Dear " . $fancierusername . " Liberation details has been updated for the event. " . $raceide . " Please check out!..";
                $pushparameter = '{"ResponseCode":"200","badge":"1"}';

                if (strlen($android_deviceide) == 64) {
                    $error_message = "Device token check!";
                    $log_file = "/portal/php_errorlog";
                    error_log($error_message, 3, $log_file);
                    sendIosPushNotification($dbconnection, $title, $message, $android_deviceide, $pushparameter, $userreg_id, $notify_key, '');
                } else {
                    $pushparameter = "";
                    $badge = 1;
                    sendAnroidPushNotification($dbconnection, $message, $android_deviceide, $pushparameter, $badge, $apptype, $userreg_id, $notify_key, '');
                }
            } else {
                $data["status"] = 401;
                $data["message"] = "Authentication failed";

                $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $authuser . "' limit 0,1");
                $entryLogDetail = mysqli_fetch_array($entrylogQuery);
                $username = $entryLogDetail["username"];
                $user_id = $entryLogDetail["reg_id"];
                $action = "liberationupdate";
                $desc = $username . " you have entered incorrect details";
                $userId = $user_id;
                entrylog($action,$desc, $userId,$dbconnection);


            }

            $filespath = $path_parts['basename'];
            $data["status"] = 200;
            $data["message"] = "Race location updated successfully";
            $data["activestatus"] = 0;
            $data["expirydate"] = $expirydate;
            $data["isCameraAllowed"] = $cameraAllowed;

            $update_eventloation = mysqli_query($dbconnection, "update ppa_events set liberation_url='" . $filespath . "',liberation_time='" . $liberationtime . "',Event_lat='" . $latitude . "',Event_long='" . $longitude . "' where Events_id='" . $raceide . "'");

            $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $authuser . "' limit 0,1");
            $entryLogDetail = mysqli_fetch_array($entrylogQuery);
            $username = $entryLogDetail["username"];
            $user_id = $entryLogDetail["reg_id"];
            $action = "liberationupdate";
            $desc = $username . " Liberation details has been updated successfully";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);


        } else {
            $data["status"] = 400;
            $data["message"] = "Problem in updating liberation location";

            $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $authuser . "' limit 0,1");
            $entryLogDetail = mysqli_fetch_array($entrylogQuery);
            $username = $entryLogDetail["username"];
            $user_id = $entryLogDetail["reg_id"];
            $action = "locationupdate";
            $desc = $username . " there is some problem in updating the liberation location";
            $userId = $user_id;
            entrylog($action,$desc, $userId,$dbconnection);

        }
    } else {
        $data["status"] = 400;
        $data["message"] = "Problem in updating liberation location";

        $entrylogQuery = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $authuser . "' limit 0,1");
        $entryLogDetail = mysqli_fetch_array($entrylogQuery);
        $username = $entryLogDetail["username"];
        $user_id = $entryLogDetail["reg_id"];
        $action = "locationupdate";
        $desc = $username . " there is some problem in updating the liberation location";
        $userId = $user_id;
        entrylog($action,$desc, $userId,$dbconnection);

    }
    echo json_encode($data);
    break;
default:
    header("HTTP/1.1 200 OK");
    die;
    break;
}

function resize_image($file, $w, $h, $crop = false) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width - ($width * abs($r - $w / $h)));
        } else {
            $height = ceil($height - ($height * abs($r - $w / $h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w / $h > $r) {
            $newwidth = $h * $r;
            $newheight = $h;
        } else {
            $newheight = $w / $r;
            $newwidth = $w;
        }
    }

    //Get file extension
    $exploding = explode(".", $file);
    $ext = end($exploding);

    switch ($ext) {
    case "png":
        $src = imagecreatefrompng($file);
        break;
    case "jpeg":
    case "jpg":
        $src = imagecreatefromjpeg($file);
        break;
    case "gif":
        $src = imagecreatefromgif($file);
        break;
    default:
        $src = imagecreatefromjpeg($file);
        break;
    }

    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

function checkauth($dbconnection, $token) {

    $checkuserauth = mysqli_query($dbconnection, "select * from ppa_register where userToken='" . $token . "'");
    if (mysqli_num_rows($checkuserauth) > 0) {
        $authusertoken = mysqli_fetch_array($checkuserauth);
        $checkuser = $authusertoken["userToken"];
    } else {
        $checkuser = 0;
    }

    return $checkuser;
}

// function sendnotification($dbconnection, $apptype, $phone_no, $username) {
//     $selectfanciers = mysqli_query($dbconnection, "select * from ppa_register where phone_no!='" . $phone_no . "' and apptype='" . $apptype . "'");
//     if (mysqli_num_rows($selectfanciers) > 0) {

//         while ($fancierinfo = mysqli_fetch_array($selectfanciers)) {
//             $android_deviceide = $fancierinfo["android_id"];
//             $message = '{"ResponseCode":"100","UserName":"' . $username . '","phone_no":"' . $phone_no . '","Apptype":"' . $apptype . '","Title":"Photo Taken","Message":"Fancier Mr.' . $username . '. taken the piegion snap :) check out his shots"}';
//             $pushparameter = "";
//             $badge = 1;
//             sendAnroidPushNotification($dbconnection, $message, $android_deviceide, $pushparameter, $badge, $apptype);
//         }

//     }
// }

function sendnotification($dbconnection, $apptype, $phone_no, $username) {
    $selectfanciers = mysqli_query($dbconnection, "select * from ppa_register where phone_no!='" . $phone_no . "' and apptype='" . $apptype . "'");
    if (mysqli_num_rows($selectfanciers) > 0) {

        while ($fancierinfo = mysqli_fetch_array($selectfanciers)) {
            $android_deviceide = $fancierinfo["android_id"];

            if (strlen($android_deviceide) == 64) {
                $message = '{"ResponseCode":"100","UserName":"' . $username . '","phone_no":"' . $phone_no . '","Apptype":"' . $apptype . '","Title":"Bird Approved","Message":"Admin approved the Bird"}';
                $pushparameter = "";
                $badge = 1;
                sendIosPushNotification($dbconnection, $message, $android_deviceide, $pushparameter, $badge, $apptype, '');
            } else {
                $message = '{"ResponseCode":"100","UserName":"' . $username . '","phone_no":"' . $phone_no . '","Apptype":"' . $apptype . '","Title":"Bird Approved","Message":"Admin approved the Bird"}';
                $pushparameter = "";
                $badge = 1;
                sendAnroidPushNotification($dbconnection, $message, $android_deviceide, $pushparameter, $badge, $apptype, '');
            }

        }

    }
}

// function sendAnroidPushNotification($dbconnection, $message = "", $deviceToken = "", $pushparameter = "", $badge = 1, $apptype, $notify_key) {
//     // echo "sendAnroidPushNotification triggered";die;
//     if ($apptype == "PPA") {
//         $pushkey = "AIzaSyBd1d-aGtwwbG-QUWd67PIiUZtnI-aKVow";
//     } else if ($apptype == "PRPA") {
//         $pushkey = "AIzaSyCeWZOqG71bbn8cuhe1Xm_P-Bgxe99slU0";
//     } else if ($apptype == "PHPA") {
//         $pushkey = "AIzaSyAvOdBc7pEDoeUEV-Hp4InswFz4B-r5Di4";
//     } else if ($apptype == "NRPA") {
//         $pushkey = "AIzaSyCkjkosA931Qy-2zsXCE4OUhDjZNWCbM0g";
//     } else if ($apptype == "KRPS") {
//         $pushkey = "AIzaSyBseqyBpWjuODiBrOtptcj-8H31kFME7yg";
//     } else if ($apptype == "GHPA") {
//         $pushkey = "AIzaSyCcbqJ4TXm13fvM5AT-WO_hwIaEuP75ZDE";
//     } else if ($apptype == "PPAS") {
//         $pushkey = "AIzaSyCOXLHuzrNg7z2Ct4N7K5Z93jDOUTDu-U8";
//     } else if ($apptype == "AMHC") {
//         $pushkey = "AIzaSyCuBA2dk4Obop7y3Wbu6w-EJkaR7TWTvwI";
//     } else if ($apptype == "GPRS") {
//         $pushkey = "AIzaSyBzFtKHwmvQE-6Qbz1vX0Uzyi-Ubmlk2_8";
//     } else if ($apptype == "INDI") {
//         $pushkey = "AIzaSyCZiIDyB54zSxZmhC-3ncykuYV1S9f1yQo";
//     } else if ($apptype == "MHPC") {
//         $pushkey = "AIzaSyCCHFeb3S_OA4yBkYnbltJhKDlbbFGNnGM";
//     } else if ($apptype == "THPA") {
//         $pushkey = "AIzaSyB1wotNytbJ6JQa3eTT5LNlgH6eMJ7n4Y0";
//     } else if ($apptype == "TRPC") {
//         $pushkey = "AIzaSyBv-r4Sm8K1zomINTiwQvlIoVcjUwj683g";
//     } else if ($apptype == "KRLR") {
//         $pushkey = "AIzaSyCJTTZDjUUiJeBgh6KTCDR8dpmRHr-ZR4c";
//     } else if ($apptype == "KHPA") {
//         $pushkey = "AIzaSyCmS5kZqIpQFlbec6A1ADtppZOdKMS4V7M";
//     } else if ($apptype == "RPC") {
//         $pushkey = "AIzaSyAeW2k1cgM_1a096t28TNW8Ybi7Rf9GV0U";
//     } else if ($apptype == "KRPC") {
//         $pushkey = "AIzaSyDEu9nqVoWZkbymTrPYKv4pNxubRHs56z0";
//     } else if ($apptype == "MRPA") {
//         $pushkey = "AIzaSyDZ1mX41QnAbOtY4WZDtdh5AvYDfNZG-Zw";
//     } else if ($apptype == "CRPA") {
//         $pushkey = "AIzaSyBL4fyz3-w4SvuJzWBUv0p9UwVxcCmyt7E";
//     } else if ($apptype == "PRPS") {
//         $pushkey = "AIzaSyCMauHRArwt-rr5mYuV7DNx2xw3UToMnMI";
//     } else if ($apptype == "SRPC") {
//         $pushkey = "AIzaSyAv2yh9vMpmijjPD6AzMinM57fNNJjhbnc";
//     } else if ($apptype == "KRPS2") {
//         $pushkey = "AIzaSyAbAtI3n_vV8TIZjQhvk5Pn8VlXnwLGZd4";
//     } else if ($apptype == "TRHPA") {
//         $pushkey = "AIzaSyDZ1mX41QnAbOtY4WZDtdh5AvYDfNZG-Zw";
//     } else if ($apptype == "AMHPC") {
//         $pushkey = "AIzaSyCBpX_duPPBreOr0QQA0c3h6aN1qSSISNI";
//     } else if ($apptype == "GPRS") {
//         $pushkey = "AIzaSyBzFtKHwmvQE-6Qbz1vX0Uzyi-Ubmlk2_8";
//     } else if ($apptype == "CRPA") {
//         $pushkey = "AIzaSyBzFtKHwmvQE-6Qbz1vX0Uzyi-Ubmlk2_8";
//     } else if ($apptype == "KGF") {
//         $pushkey = "AIzaSyDVJC54wJkEzZ4hu8fhNE1eYF3SUKZwrW4";
//     } else if ($apptype == "HHPA") {
//         $pushkey = "AIzaSyAeMo0UQU4ivREntYm9J0LAC5w5EkP3Orw";
//     } else if ($apptype == "KRPF") {
//         $pushkey = "AIzaSyBmSssqFWvvAP8xV5aVby8gkxVYg7KPm6U";
//     } else if ($apptype == "PUPA") {
//         $pushkey = "AIzaSyCt7QnJic5Kiady8gSHN65OnDhOqT2tWB8";
//     } else if ($apptype == "ELPRS") {
//         $pushkey = "AIzaSyDSmpxVG8N2lvY7aZaSznIBsD3F9k";
//     } else if ($apptype == "BRPS") {
//         $pushkey = "AIzaSyCBBw3HtwH57pkGzvSCZRAQrMPXY2RrWiI";
//     } else if ($apptype == "ARPA") {
//         $pushkey = "AIzaSyCYyg_cpfcibEbMRlHdFR0aE-DpJXlqqyk";
//     } else if ($apptype == "BRPA") {
//         $pushkey = "AIzaSyC4odxCydTz7vJTPOMPURMeILBALp7W0CQ";
//     } else if ($apptype == "NGTHPA") {
//         $pushkey = "AIzaSyB9A7hyLbAl1mrtq2JNWDX3vgpTPwmVrAs";
//     } else if ($apptype == "SBS") {
//         $pushkey = "AIzaSyChbdNbwyUc6q-Nxx4bus5R6nAM3dkvFYQ";
//     } else if ($apptype == "THPS") {
//         $pushkey = "AIzaSyCOJ11GNwl3XVETlAsRZZtzHJtXOAblgAk";
//     } else if ($apptype == "THRPC") {
//         $pushkey = "AIzaSyBaMQlYV4Gmh_4oe88A-JUxwEXaL4x2IY0";
//     } else if ($apptype == "DRPS") {
//         $pushkey = "AIzaSyA2R-bwZQ2_yPz2Ans6GX0rdz6giMW6esI";
//     } else if ($apptype == "KARPS") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else if ($apptype == "BDS") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else if ($apptype == "MHPS") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else if ($apptype == "CRPS") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else if ($apptype == "AIR") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else if ($apptype == "PCRPC") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else if ($apptype == "CHPFA") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else if ($apptype == "TRRPC") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else if ($apptype == "CRHPA") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else if ($apptype == "MRPC") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else if ($apptype == "NRPC") {
//         $pushkey = "AIzaSyDYtJcssxHk1F8YCeg14V1I-7_p9YUra7w";
//     } else {
//         $pushkey = "AIzaSyDUWKKRdi3Bu2o2mKzuog7SR1pHbz7QHQ4";
//     }

//     define('API_ACCESS_KEY', $pushkey);
//     $registrationIds = $deviceToken;
//     #prep the bundle

//     $fields = array(
//         'to' => $deviceToken,
//         'data' => array('to' => $deviceToken, 'message' => $message, 'notify' => $notify_key),
//     );

//     $headers = array
//         (
//         'Authorization: key=' . API_ACCESS_KEY,
//         'Content-Type: application/json',
//     );
//     #Send Reponse To FireBase Server
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//     $result = curl_exec($ch);
//     curl_close($ch);
//     $logquery = "insert notificationlog set status ='" . $result . "',deviceid ='" . $deviceToken . "',deviceType='Android',message='" . addslashes($message) . "'";
//     mysqli_query($dbconnection, $logquery);
//     #Echo Result Of FireBase Server
//     return $result;
// }

//     function sendAnroidPushNotification($dbconnection, $title = "", $message = "", $android_deviceide = "", $pushparameter = "", $badge = 1, $apptype = "", $userreg_id = "") {
   
//     define('API_ACCESS_KEY', "AAAAIIj1UWU:APA91bH47-0G7dEM90XnfldDAIOkQQ8b1gJmCd2XuqHtmuTD8a1JwoahrLiu753PKyAjjzG-xd4U9benlvUks0Ckij6kN5lZOWqGOyHIXEoAY9-LhCDqn2swIbcfjm1UkZyW1YVxMb03");

//     $registrationIds = $deviceToken;
//     #prep the bundle

//     $fields = array(
//         'to' => $deviceToken,
//         'data' => array('to' => $deviceToken, 'message' => $message, 'notify' => $notify_key),
//     );

//     $headers = array
//         (
//         'Authorization: key=' . API_ACCESS_KEY,
//         'Content-Type: application/json',
//     );
//     #Send Reponse To FireBase Server
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//     $result = curl_exec($ch);
//     curl_close($ch);
    
//     $logquery = "insert notificationlog set status ='" . $result . "',deviceid ='" . $android_deviceide . "',deviceType='Android',userid ='" . $userreg_id . "', message='" . addslashes($message) . "'";

//     mysqli_query($dbconnection, $logquery);
//     #Echo Result Of FireBase Server
//     return $result;
// }

function sendAnroidPushNotification($dbconnection, $title = "", $message = "", $android_deviceide = "", $pushparameter = "", $badge = 1, $apptype = "", $userreg_id = "",$fancierphone_no="") 
    {

        #API access key from Google API's Console
        define('API_ACCESS_KEY', 'AAAAIIj1UWU:APA91bH47-0G7dEM90XnfldDAIOkQQ8b1gJmCd2XuqHtmuTD8a1JwoahrLiu753PKyAjjzG-xd4U9benlvUks0Ckij6kN5lZOWqGOyHIXEoAY9-LhCDqn2swIbcfjm1UkZyW1YVxMb03');

        $registrationIds = $android_deviceide;
        $msg = array
            (
            'body' => $message,
            'title' => $title,
            // "category" => $action,
            // "user_id" => $user_id,
            // "auction_id" => $auction_id,
            // "bird_id" => $bird_id,
            'icon' => 'myicon', /*Default Icon*/
            'badge' => $badge,
            'sound' => 'mySound', /*Default sound*/
        );

        $fields = array
            (
            'to' => $registrationIds,
            'notification' => $msg,
        );

        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        $logquery ="insert notificationlog set status ='" . $result . "',action='".$title."', deviceid ='" . $android_deviceide . "', apptype='".$apptype."', phone_no='".$fancierphone_no."', userid ='" . $userreg_id . "',deviceType='Android',message='" . $msg['body'] . "'";

        // echo "insert notificationlog set status ='" . $result . "',deviceid ='" . $android_deviceide . "',userid ='" . $userreg_id . "',deviceType='Android',message='" . $msg['body'] . "'";

        mysqli_query($dbconnection, $logquery);
        #Echo Result Of FireBase Server
        return $result;
        }



function sendandroidnotification($dbconnection, $id, $message) {

    #API access key from Google API's Console
    define('API_ACCESS_KEY', 'YOUR-SERVER-API-ACCESS-KEY-GOES-HERE');
    $registrationIds = $id;
    #prep the bundle
    $msg = array
        (
        'body' => 'Body  Of Notification',
        'title' => 'Title Of Notification',
        'icon' => 'myicon', /*Default Icon*/
        'sound' => 'mySound', /*Default sound*/
    );
    $fields = array
        (
        'to' => $registrationIds,
        'notification' => $msg,
    );

    $headers = array
        (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json',
    );
    #Send Reponse To FireBase Server
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
    #Echo Result Of FireBase Server
    echo $result;

}

// function sendIosPushNotification($dbconnection, $title = "", $message = "", $GetMyDeviceId = "", $pushparameter = "", $userreg_id, $badge = 1, $notify_key) {
function sendIosPushNotification($dbconnection, $title = "", $message = "", $GetMyDeviceId = "", $pushparameter = "", $userreg_id, $notify_key) {
    try
    {
        $passphrase = '123';
        $pemfilepath = '/home/karlakat/public_html/lespoton.com/portal/lespotPushP12.pem';

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $pemfilepath);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        $fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp) {
            exit;
        }
        $body['aps'] = array(
            'alert' => array(
                'title' => $title,
                'body' => $message,
                'icon' => 'myicon', /*Default Icon*/
                'notify' => $notify_key,
            ),
            'badge' => (int) $badge,
            //'message' => $pushparameter,
            //'sound' => '1,624',
            'sound' => 'mySound',
        );
        $payload = json_encode($body);
        $msg = chr(0) . pack('n', 32) . pack('H*', $GetMyDeviceId) . pack('n', strlen($payload)) . $payload;
        $result = fwrite($fp, $msg, strlen($msg));
        // print_r($msg);
        fclose($fp);
        //return 1;

        $logquery = "insert notificationlog set status ='" . $result . "',deviceid ='" . $GetMyDeviceId . "',deviceType='Ios',userToken ='" . $userreg_id . "',message='" . addslashes($message) . "'";
        mysqli_query($dbconnection, $logquery);

        //     #Echo Result Of FireBase Server
        return $result;
    } catch (Exception $e) {
        print_r($e);
    }
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
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

function entrylog($action="",$desc="",$userId='',$dbconnection)
{
  

  $ipaddress = $_SERVER['REMOTE_ADDR'];
  $getAction = $action;
  $getdescription = $desc;
  $get_user_id = $userId;
  $get_entry_date = date("Y-m-d H:i:s");
  $type = 'APP';

  $insert_qry = "insert system_logs set ip='" . $ipaddress . "',action='" . $getAction . "',description='" . $getdescription . "',user_id='" . $get_user_id . "',entry_date='" . $get_entry_date . "', type='".$type."'";

  mysqli_query($dbconnection, $insert_qry);
}

//select a.event_id,a.ed_id,a.bird_id,d.brid_type,a.race_distance,a.date,a.end_time,TIMESTAMP(a.date, STR_TO_DATE(a.start_time, '%h:%i %p')) as stimes,TIMESTAMP(a.date, STR_TO_DATE(a.end_time, '%h:%i %p')) as etimes FROM ppa_event_details as a LEFT JOIN ppa_events as b on a.event_id=b.Events_id LEFT JOIN users as c on b.Org_id=c.users_id LEFT JOIN ppa_bird_type as d on d.b_id=a.bird_id where c.Org_code='PPA' and ('2018-09-09 13:00:00' BETWEEN TIMESTAMP(a.date, STR_TO_DATE(a.start_time, '%h:%i %p')) and TIMESTAMP(a.date, STR_TO_DATE(a.end_time, '%h:%i %p'))) and b.result_publish='0' group by a.race_distance order by etimes DESC

?>


