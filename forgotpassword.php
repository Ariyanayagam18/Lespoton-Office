<?PHP
include "siteinfo.php";
$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);
?>
<?php
$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$a = explode("=", $current_url);

$checkUser = mysqli_query($dbconnection, "SELECT * FROM ppa_register WHERE verify_id = '" . $a[1] . "'");
$checkRows = mysqli_num_rows($checkUser);

if ($checkRows > 0) {
    while ($checkRowUser = mysqli_fetch_array($checkUser)) {
        $data["username"] = $checkRowUser["username"];
        $reg_id = $checkRowUser["reg_id"];
        if (isset($_POST['verify'])) {
            $url_components = parse_url($current_url);
            parse_str($url_components['query'], $params);
            $rand_number = $params['verify_id'];
            $pwd = $_POST['password'];
            $hashPassword = password_hash($pwd, PASSWORD_DEFAULT);
            $r_num = rand();
            $updateUser = mysqli_query($dbconnection, "UPDATE ppa_register SET password='" . $hashPassword . "' ,verify_id='' WHERE reg_id = '" . $reg_id . "'");

            if (mysqli_num_rows($updateUser) == 0) {
                echo "Password updated successfully";die;
            } else {
                echo "Error in update";die;
            }
        }
    }
}
?>
<html>
	<head>
				 <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</head>

	<body>
		<div class="panel panel-default">
				<div class="panel-heading">
					<div class="header_logo">
						<!-- <img src=""> -->
						<img src="https://www.lespoton.com/portal/twilight_logo.png" alt="Logo" width="100" height="25">

					</div>
					<h2 align="center">Forgot Password</h2>
				</div>
			<div class="panel-body">
				<div class="container">
					<?php
$str = rand();
?>
					<form name="myForm" id="myForm" method="post" action="" >
						<div class="col-md-3">
						</div>
						<div class="col-md-6">
							<label>New Password</label>
							<div class="form-group">
								<input type="password" id="password" name="password" class="form-control">
							</div>
							<div class="form-group">
								<input type="submit" value="Verify" id="verify" name="verify" class="btn btn-primary">
							</div>
						</div>
						<div class="col-md-3">
						</div>
					</form>

				</div>
			</div>
		</div>
	</body>
</html>


<style>
    .header_logo{
        /*margin: 20px;
        height: 50px;*/
        /*width: 50px;*/
        margin-bottom: 0px;
        margin-top: 10px;
    }
</style>