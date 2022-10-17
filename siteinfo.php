<?php
error_reporting(1);
ini_set('display_errors', 1);
global $dbconnection;
$dbconnection = mysqli_connect('localhost','admin','CoreSpot@321','ppa_lespoton');
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);

//$SITEMAINURL = "http://104.236.218.51/spotlightdemo/";
$SITEMAINURL = "https://pigeonsportsclock.com/pigeon/";

function checkauthuser($dbconnection,$token)
   {
      $checkuserauth = mysqli_query($dbconnection,"select * from ppa_register where userToken='".$token."'");
      if(mysqli_num_rows($checkuserauth)>0)
       {
        $authusertoken = mysqli_fetch_array($checkuserauth);
        $checkuser = $authusertoken["userToken"];
       }
       else
       $checkuser = 0;
       return $checkuser;
   }

?>