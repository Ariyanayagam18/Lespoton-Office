<?php //print_r($birdhistory);?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
  <?php if($this->session->flashdata("messagePr")){?>
    <div class="alert alert-info">      
      <?php echo $this->session->flashdata("messagePr")?>
    </div>
  <?php } ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">History of Pigeon ( <?php echo $birddetails[0]->ringno;?> )</h3>
            <div class="box-tools">
             <a href="<?php echo base_url().'user/pigeon/';?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="fa fa-eye"></i>&nbsp;Pigeon Listing</button></a>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
                <div class=" col-md-5">
                      <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
                        <thead>
                           <tr><td colspan="2"><h4 class="box-title">Details</h4></td></tr>
                           <tr>
                              <td>Ring no</td><td> : &nbsp;<?php echo $birddetails[0]->ringno;?></td>
                           </tr>
                           <tr>
                              <td>Owner / Fancier Name</td><td> : &nbsp;<?php echo $birddetails[0]->fancier;?></td>
                           </tr>
                           <tr>
                              <td>Club Name</td><td> : &nbsp;<?php echo $birddetails[0]->clubname;?></td>
                           </tr>
                           <tr>
                              <td>Bird Type</td><td> : &nbsp;<?php echo $birddetails[0]->birdtype;?></td>
                           </tr>
                           <tr>
                              <td>Color</td><td> : &nbsp;<?php echo $birddetails[0]->color;?></td>
                           </tr>
                           <tr>
                              <td>Gender</td><td> : &nbsp;<?php echo $birddetails[0]->gender;?></td>
                           </tr>
                        </thead>
                       </table>
                </div>
                <div class=" col-md-7">
                      <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
                         <thead>
                           <tr><td colspan="4"><h4 class="box-title">Race History</h4></td></tr>
                           <?php if(count($birdhistory)>0) { ?>
                           <tr>
                              <th><b>Race Name</b></th>
                              <th><b>Date</b></th>
                              <th><b>Distance</b></th>
                              <th><b>Velocity</b></th>
                              <!--<th><b>Position</b></th>-->
                           </tr>
                           <?php foreach ($birdhistory as $key=>$birdinfo ) { ?>
                           <tr>
                              <td><?php echo $birdinfo->Event_name;?></td>
                              <td><?php echo $birdinfo->Event_date;?></td>
                              <td><?php echo $birdinfo->race_distance;?></td>
                              <td><?php echo $birdinfo->velocity;?></td>
                              <!--<td><?php echo $birdinfo->rank;?></td>-->
                           </tr>
                           <?php } } else { ?>
                            <tr><td>There's no race history available for this Pigeon</td></tr>
                           <?php } ?>
                           
                         </thead>
                       </table>
                </div>
            </div>           
            
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>  
<!-- Modal Crud Start-->
<div class="modal fade" id="fancierviewwindow" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <h3 class="box-title">Fancier Details</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div><!--End Modal Crud --> 

<script type="text/javascript">
var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
  
</script>            