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

$users_id = '2';

$selectUser = mysqli_query($dbconnection, "SELECT pid,club_code,event_id,event_details_id FROM ppa_updatephoto WHERE club_code='PPA'");
	// SELECT pid,club_code,event_id,event_details_id FROM ppa_updatephoto WHERE club_code='PPA'
while($getUserQuery = mysqli_fetch_array($selectUser)){
	$club_code = $getUserQuery["club_code"];
	$event_id = $getUserQuery["event_id"];

	$ppa_events_query = mysqli_query($dbconnection, "SELECT Events_id FROM ppa_events WHERE Events_id = '$event_id'");
	// SELECT Events_id FROM ppa_events WHERE Events_id = '966'


	if(mysqli_num_rows($ppa_events_query) > 0)
	{
		$get_ppa_events_Events_id = mysqli_fetch_array($ppa_events_query);

		$ppa_Events_id = $get_ppa_events_Events_id["Events_id"];

		$ppa_events_details_query = mysqli_query($dbconnection, "SELECT ed_id,event_id FROM ppa_event_details WHERE event_id = '$ppa_Events_id'");
		//SELECT ed_id,event_id FROM ppa_event_details WHERE event_id = '966'

		if(mysqli_num_rows($ppa_events_details_query) > 0)
		{

			$get_ppa_updatephoto = mysqli_fetch_array($ppa_events_details_query);

			$updatephoto_ed_id = $get_ppa_updatephoto["ed_id"];
			$updatephoto_event_id = $get_ppa_updatephoto["event_id"];

			$ppa_report_query = mysqli_query($dbconnection, "SELECT report_id,apptype FROM ppa_report WHERE event_id = '$updatephoto_event_id'");
			// select report_id,apptype from ppa_report where event_id = '173'

			if(mysqli_num_rows($ppa_report_query) > 0)
			{
				$get_ppa_report = mysqli_fetch_array($ppa_report_query);

				$report_apptype = $get_ppa_report["apptype"];

				$ppa_register_query = mysqli_query($dbconnection,"SELECT reg_id,apptype FROM ppa_register WHERE apptype='$report_apptype'");
				//SELECT reg_id,apptype FROM ppa_register WHERE apptype='PPA'

				if(mysqli_num_rows($ppa_register_query) > 0)
				{
					$get_ppa_register = mysqli_fetch_array($ppa_register_query);
					$register_apptype = $get_ppa_register["apptype"];


					$ppa_files_query = mysqli_query($dbconnection,"SELECT ide,club_code,event_id FROM ppa_files WHERE club_code = '$register_apptype'");
					//SELECT ide,club_code,event_id FROM ppa_files WHERE club_code = 'PPA'

					if(mysqli_num_rows($ppa_files_query) > 0)
					{
						$get_ppa_files = mysqli_fetch_array($ppa_files_query);
						$ppa_files_club_code = $get_ppa_files["club_code"];

						$ppa_basketing_query = mysqli_query($dbconnection,"SELECT entry_id,org_code FROM ppa_basketing WHERE org_code = '$ppa_files_club_code'");
						// SELECT entry_id,org_code FROM ppa_basketing WHERE org_code = 'PPA'

						if(mysqli_num_rows($ppa_basketing_query) > 0)
						{
							$get_ppa_basketing = mysqli_fetch_array($ppa_basketing_query);
							//echo "<pre>get_ppa_basketing:"; print_r($get_ppa_basketing); "</pre>";


							// $delete_get_ppa_basketing = mysqli_query($dbconnection,"DELETE FROM ppa_basketing WHERE org_code='$ppa_files_club_code'");

							// echo "<pre>Delete query:"; print_r("DELETE FROM ppa_basketing WHERE org_code='$ppa_files_club_code'"); "</pre>";



						}


					}

				}

			}
			
		}

	}
}
die;
?>