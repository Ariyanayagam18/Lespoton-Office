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

  </head>



<?php if($this->session->flashdata("alert_msg")){?>
  <div class="alert alert-danger">      
    <?php echo $this->session->flashdata("alert_msg")?>
  </div>
<?php } ?>
	<body class="hold-transition register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/twilight_whitelogo.png"></a>
      </div>
      <div class="register-box-body">
        <div class="login-logo text-center">
        <a href="<?php echo base_url(); ?>"><b>Twilight Centralized System</b></a>
      </div>
        <p class="login-box-msg">Register a new membership</p>
        <?php if($this->session->flashdata("messagePr")){?>
          <div class="alert alert-info">      
            <?php echo $this->session->flashdata("messagePr")?>
          </div>
        <?php } ?>
        <form action="<?php echo base_url().'user/registration'; ?>" method="post">
          
						<div class="form-group has-feedback">
			            <input type="text" name="name" class="form-control" data-validation="required" placeholder="Name">
			            <span class="glyphicon glyphicon-user form-control-feedback"></span>
			          </div>
					
						<div class="form-group has-feedback">
			            <input type="text" name="email" class="form-control" data-validation="required" placeholder="Email">
			            <span class="glyphicon glyphicon-user form-control-feedback"></span>
			          </div>
					
           <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Password" data-validation="required">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Retype password" data-validation="confirmation">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <?php $type = json_decode(setting_all('user_type')); ?>
            <select name="user_type" id="" class="form-control">
              <?php 
              foreach ($type as $key => $value) {
                if($value != 'admin') {
                  echo '<option value="'.$value.'">'.ucfirst($value).'</option>';            
                }
              }
              ?>
            </select>
            <!-- <input type="" name="password" class="form-control" placeholder="Retype password" data-validation="confirmation"> -->
            <span class="glyphicon glyphicon-random form-control-feedback"></span>
          </div>
    	     <div class="row">
              <div class="col-xs-12">
               <!--  <input type="hidden" name="user_type" value="<?php //echo setting_all('user_type');?>"> -->
                <input type="hidden" name="call_from" value="reg_page">
                <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat btn-color">Register</button>
              </div>
            </div>
        </form>
    	  
        <a href="<?php echo base_url('user/login');?>" class="text-center">I already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div>
<!-- /.register-box -->
  </body>
<script>
$(document).ready(function(){
  <?php if($this->input->get('invited') && $this->input->get('invited') != ''){ ?>
    $burl = '<?php echo base_url() ?>';
    $.ajax({
      url: $burl+'user/chekInvitation',
      method:'post',
      data:{
        code: '<?php echo $this->input->get('invited'); ?>'
      },
      dataType: 'json'
    }).done(function(data){
      console.log(data);
      if(data.result == 'success') {
        $('[name="email"]').val(data.email);
        $('form').attr('action', $burl + 'user/register_invited/' + data.users_id);
      } else{
        window.location.href= $burl + 'user/login';
      }
    });
  <?php } ?>
});
</script>
</html>