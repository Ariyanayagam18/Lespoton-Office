<?php
include "siteinfo.php";
$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);

$dd = date("Y-m-d h:i:A");
// 2020-07-21 01:52:PM

$cur_d = date("Y-m-d");
// 2020-07-21

$dt = date('h:i A');
// 12:52 PM

$unixdt = strtotime($dt);
$cur_dt = time();
$tenmins = 600;

$selectfanciers = mysqli_query($dbconnection, "select * from ppa_event_details WHERE date = '$cur_d'");

while ($race_res = mysqli_fetch_array($selectfanciers)) {
    $eventtime = $race_res["start_time"];

    $unixeventtime = strtotime($race_res["start_time"]);

    $customeventtime = $unixeventtime - $tenmins;
    $timestamp = $customeventtime;
    $modifiedtimestamp = date('h:i A', $timestamp);

    $updated_event = mysqli_query($dbconnection, "select * from ppa_event_details where start_time = '$eventtime' and '$dt' = '$modifiedtimestamp'");

    // $updated_event = mysqli_query($dbconnection, "select * from ppa_event_details where start_time = '$eventtime'");
    if (mysqli_num_rows($updated_event) > 0) {
        $event_details = mysqli_fetch_array($updated_event);
        $event_id = $event_details["event_id"];

        $basketingquery = mysqli_query($dbconnection, "select * from ppa_basketing where event_id='" . $event_id . "'");
        if (mysqli_num_rows($basketingquery) > 0) {
            while ($basketing_details = mysqli_fetch_array($basketingquery)){
            $basketing_event_id = $basketing_details["event_id"];
            $basketing_fancier_id = $basketing_details["fancier_id"];
            $basketinguserquery = mysqli_query($dbconnection, "select username,android_id,apptype,phone_no,reg_id from ppa_register where reg_id='" . $basketing_fancier_id . "'");
            if (mysqli_num_rows($basketinguserquery) > 0) {
                while ($eventUserList = mysqli_fetch_array($basketinguserquery)) {
                    $android_deviceide = $eventUserList["android_id"];
                    $username = $eventUserList["username"];
                    $apptype = $eventUserList["apptype"];
                    $phone_no = $eventUserList["phone_no"];
                    $userreg_id = $eventUserList["reg_id"];
                    $title = "Get Ready for the race";
                    $message = "Dear " . $username . " race is going to start in 10 minutes. Please get ready";
                    $body = "Dear " . $username . " race is going to start in 10 minutes. Please get ready";
                    $pushparameter = "";
                    $badge = 1;
                    $notify_key = 1;
                    $pushparameter = '{"ResponseCode":"200","badge":"1"}';
                    $action = "Race start";
                        if (strlen($android_deviceide) == 64) {
                            sendIosPushNotification($dbconnection, $title, $body, $message, $android_deviceide, $pushparameter, $badge, $notify_key, $userreg_id, $apptype, $phone_no, $action);
                        } else {
                            $pushparameter = "";
                            $badge = 1;
                           sendAnroidPushNotification($dbconnection, $title, $body, $message, $android_deviceide, $pushparameter, $badge, $notify_key, $userreg_id, $apptype, $phone_no, $action);
                        }
                    }
                }
            }
        }
    }
}

function sendAnroidPushNotification($dbconnection, $title = "", $body = "", $message = "", $android_deviceide = "", $pushparameter = "", $badge = 1, $notify_key, $userreg_id = "", $apptype = "", $phone_no = "", $action = "") {
        #API access key from Google API's Console
        define('API_ACCESS_KEY', 'AAAAIIj1UWU:APA91bH47-0G7dEM90XnfldDAIOkQQ8b1gJmCd2XuqHtmuTD8a1JwoahrLiu753PKyAjjzG-xd4U9benlvUks0Ckij6kN5lZOWqGOyHIXEoAY9-LhCDqn2swIbcfjm1UkZyW1YVxMb03');

        $registrationIds = $android_deviceide;
        $msg = array
            (
            'title' => $title,
            'body' => $body,
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
        $date = date("Y-m-d H:i:s A");

        $logquery ="insert notificationlog set status ='" . $result . "',deviceid ='" . $android_deviceide . "',userid ='" . $userreg_id . "',deviceType='Android',message='" . $msg['body'] . "',action='".$action."',apptype='".$apptype."',phone_no='".$phone_no."',updatedTime='".$date."'";
        mysqli_query($dbconnection, $logquery);

        // echo "<pre>";
        // print_r($result);
        return $result;
    }

function sendIosPushNotification($dbconnection, $title = "", $body = "", $message = "", $GetMyDeviceId = "", $pushparameter = "", $badge = 1, $notify_key, $userreg_id = "", $apptype = "", $phone_no, $action = "") {
        try
        {

            $passphrase = '123';
            $pemfilepath = 'var/www/html/pigeonsportsclock.com/pigeon/lespotPushP12.pem';
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
                    'body' => $body,
                ),
                'badge' => (int) $badge,
                //'message' => $pushparameter,
                'sound' => '1,624',
            );
            $payload = json_encode($body);

            $msg = chr(0) . pack('n', 32) . pack('H*', $GetMyDeviceId) . pack('n', strlen($payload)) . $payload;

            $result = fwrite($fp, $msg, strlen($msg));
            // print_r($msg);

            fclose($fp);
            //return 1;
            $date = date("Y-m-d H:i:s A");
            $logquery = $this->db->query("insert notificationlog set status ='" . $result . "',deviceid ='" . $GetMyDeviceId . "',userid ='" . $userreg_id . "',deviceType='Ios',message='" . addslashes($message) . "',action='".$action."',apptype='".$apptype."',phone_no='".$phone_no."',updatedTime='".$date."'");
            mysqli_query($dbconnection, $logquery);
            // echo "<pre>Insert:";
            // print_r("insert notificationlog set status ='" . $result . "',deviceid ='" . $GetMyDeviceId . "',userToken='" . $userreg_id . "',deviceType='Ios',message='" . addslashes($message) . "'");"</pre>";die;
            //     #Echo Result Of FireBase Server
            return $result;

        } catch (Exception $e) {
            print_r($e);
        }

    }