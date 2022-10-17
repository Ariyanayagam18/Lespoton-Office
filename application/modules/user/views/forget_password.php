
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

  <body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/twilight_whitelogo.png"></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <div class="login-logo text-center">
        <a href="<?php echo base_url(); ?>"><b>Twilight Centralized System</b></a>
      </div>
      <p class="login-box-msg">Please enter your or email address. You will receive a link to create a new password via email.</p>
      <?php if($this->session->flashdata('forgotpassword')):?>
        <div class="callout callout-success">
          <h5 style='color:red;' class="fa fa-close">  <?php echo $this->session->flashdata('forgotpassword'); ?></h5>
        </div>
      <?php endif ?>
      <form action="<?php echo base_url().'user/forgetpassword'?>" method="post">
        <div class="form-group has-feedback">
          <input type="email" name="email" class="form-control" placeholder="Email" data-validation="email" />
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat btn-color">Get New Password</button>
          </div>
          <div class="text-center">
            <span class="glyph-icon-back glyphicon glyphicon-circle-arrow-left" style="cursor:pointer" onclick="window.history.back()" title="Back"></span>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="social-auth-links text-center">
      </div>
      <!-- /.social-auth-links -->
    </div>
    <!-- /.login-box-body -->
  </div>
<!-- /.login-box -->
</body>

</html>
