
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
    
  	<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
    <title>Twilight Centralized System</title> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/Style.css'); ?>" />
	<style type="text/css">
		html, body {
			min-height: auto;
		}	
	</style>
<script type="text/javascript">

if (location.protocol == 'http:')
  location.href = location.href.replace(/^http:/, 'https:')
</script>
  </head>





<body class="hold-transition login-page">
	<div class="container-fluid">
	<div class="login-box">
	  	<div class="login-logo">

	    	<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/twilight_whitelogo.png"></a>
	  	</div>
	  	<!-- /.login-logo -->
	  	
	  	<div class="">
	  		
	  	<div class="login-box-body">
	  		<div class="login-logo text-center">
				<a href="<?php echo base_url(); ?>"><b>Twilight Centralized System</b></a>
			</div>
	    	<p class="login-box-msg">Sign in to start your session</p>
			<?php if($this->session->flashdata("messagePr")){?>
	  		<div class="alert alert-info">      
		        <?php echo $this->session->flashdata("messagePr")?>
		    </div>
		    <?php } ?>
		    <form class="m-0" action="<?php echo base_url().'user/auth_user'; ?>" method="post">
		    	<div class="form-group has-feedback">
		    		<input type="text" name="email" class="form-control" id="" placeholder="Email">
		        	<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		      	</div>
				<div class="form-group has-feedback">
<input type="password" name="password" class="form-control" placeholder="Password" id="pass_log_id">
<span class="fa fa-fw fa-eye field_icon toggle-password"></span>
</div>
			   
			  	<div class="row">
			  		<div class="col-xs-12">
		          		<button type="submit" class="btn btn-primary btn-block btn-flat btn-color">Sign In</button>
		        	</div>
				</div>
		    </form>
		    <br>
		    <!-- /.social-auth-links -->
		    <div class="row">
		    <?php if(setting_all('register_allowed')==10){ ?>
		    	
		    	<div class="col-lg-7 col-md-7">
				<span class="glyphicon glyphicon-user bg-icon-paste"></span><a href="<?php echo base_url().'user/registration';?>" class="text-center"> Register a new membership</a>
				</div>
			<?php } ?>

			 <div class="row" style="padding-top:15px;text-align:center;" ><a href="forgetpassword" class="">I Forgot my password?</a></div>
			</div>
			<div class="row" style="padding-top:15px;text-align:center;">
				<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=c8vc581HsQsPR2R8fPUa11ulIFtHNIt7kShNBuWPLLlT1M1708jtFG2prLu1"></script></span>
			</div>
		</div>
		</div>
		<div class="clearfix"></div>
		<!-- /.login-box-body -->
	</div>
	</div>
</body>
</html>
<style>

span.toggle-password {
position: absolute;
right: 7px !important;
top: 14px !important;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
	$("body").on('click', '.toggle-password', function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $("#pass_log_id");
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }

});
</script>
