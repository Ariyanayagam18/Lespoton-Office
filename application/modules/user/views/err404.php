<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper clearfix">
<!-- Main content -->
  <div class="col-md-12 form f-label">
  <?php if($this->session->flashdata("messagePr")){?>
    <div class="alert alert-info">      
      <?php echo $this->session->flashdata("messagePr")?>
    </div>
  <?php } ?>
    <!-- Profile Image -->
    <div class="box box-success pad-profile">
     	<div class="box-header with-border">
        <h3 class="box-title"><a href="<?php echo base_url(); ?>">Go Back</a></h3>
      </div> 
        <div class="box-body box-profile">
          <div class="col-md-12">
          </div>
         <!-- /.box-body -->
        </div>                    
      <!-- /.box -->
    </div>
    <!-- /.content -->
  </div>
</div>
<!-- /.content-wrapper -->