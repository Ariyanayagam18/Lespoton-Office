<?php
$server_data = array();
  $bird_data = array();
    foreach ($bird_list as $key => $value) {
      # code...

      $bird_data["b_id"]= $value->b_id;
      $bird_data["brid_type"] = $value->brid_type;
      array_push($server_data, $bird_data);
    }
  $bl = json_encode($server_data);
?>
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
        <div class="error_logs">
          
        </div>
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Add Race</h3>
            <div class="box-tools">
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">           
                     <section class="content">
      <div class="row">
        <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
        <?php
          if(isset($_GET['success']) == 1){
            ?>
            <strong><h4><p class="text-center text-success" id="status_re">Race Sucessfully Added.</p></h4></strong>
            
            <script>
             setTimeout(function(){
            $("p#status_re").css('display','none');
          }, 3000);
           </script>
            <?php
          }
        ?>

        <div class="row">
 <div class="col-md-2" ></div>
  <div class="col-md-8"  >
          <button type="button" class="btn btn-primary" id="addMoreForm" style="float: right; margin-bottom: 10px;" onclick="add_race();">Add Category</button></div> </div>
       <div class="col-md-2" ></div>
          <div class="bs-example bs-example12 col-md-8 col-sm-12 col-xs-12"  style="border: 1px solid #e1e1e1;" >
            <div class="box-body">
          
                <div class="row">
              
              <form method="POST" action="" name="eventForm" id="eventForm">
                  <p class="error_log" style="color: red; text-align: center"></p>
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <label>Race Name</label>
                      <input type="text" class="form-control" name="event_name" id="event_name">
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label>Organization Name</label>
                        <select id="org_name" class="form-control" name="org_name">
                          <option value="">Select</option>
                           <?php foreach ($org_list as $item) 
                           {
                             if($item->Org_code != ""){
                               ?>
                               <option value="<?php echo $item->Org_id;?>"><?php echo $item->Org_code; ?></option>
                             <?php }
                            }
                             ?>
                         </select>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    
                    <label>Race Latitude</label>
                      <input type="text" class="form-control" name="event_latitude" id="event_latitude">
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                   
                    <label>Race Longitude</label>
                      <input type="text" class="form-control" name="event_longitude" id="event_longitude">
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label>Race Schedule Date</label>
                      <input type="text" class="form-control" name="event_sch_date" id="event_sch_date">
                   </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
              <button type="button"  name="saveBtn" id="saveBtn" class="btn btn-primary saveBtn save_change" >Save</button>
               
            </div>
            <hr>

                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pic-container"  style="border-top: 1px solid #e1e1e1;">
                    <input type="hidden" value='<?php echo $bl; ?>' id="bird_values">
                   
                <br><br>
                <div class="panel panel-default race_add" id="race_add">
                <div class="panel-heading">
                  <h4>Add New Category</h4>
                </div>
                  <div class="panel-body">
                  <div class="row">
                    <input type="hidden" id="bird_id_val">


                      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">


                        <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10"></div>

                              <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12" style="text-align: right;">
                              <button class="btn form-control button_plus" id="add-more"  type="button" onclick="add_more();"><i class="glyphicon glyphicon-plus"></i></button>
                              
                            
                            </div>
                    </div>


                          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">


                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <label>Race Distance (KM)</label>
                            <input type="text" class="form-control" name="bird_distance[]" id="bird_distance" value="" placeholder="Enter The KM">
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                              <label>Bird Type</label>
                            <select class="form-control" id="select_bird_type" name="select_bird_type[]">
                              <option value="">Select Bird Type</option>
                              <?php
                              foreach ($bird_list as $key => $value) {
                                  ?>
                                  <option value="<?php echo $value->b_id;?>"><?php echo $value->brid_type;?></option>
                                  <?php
                                }
                              ?>
                            </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                          <div class="copy-fields after-add-more">
                          <div class="input-group control-group ">
                        <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                <label>Date</label>
                             <input type="text" readonly name="start_date10[]" class="form-control start_date dateChangeCat">
                             </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                              <label>Start Time</label>
                             <input type="text" id="onselectstarttime" name="start_time10[]" id="start_time" class="form-control start_time">
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                              <label>End Time</label>
                              <input type="text" id="onselectendtime" name="end_time10[]" class="form-control end_time">
                            </div>
                            
        <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 row_plus">
                  <label>Boarding Time</label>
                <input type="text" readonly name="time_distance10[]" class="form-control time_distance"></div>
         


                        </div>
          <div class="add_row"></div>
                      </div>
                      </div>
                      
                            </div>
                            </div>
                    </div>
                  </div>
                  
                </div>
                  
            <div class="add_new_race"></div>
            <div id="statusdiv" style="color: green;    padding: 10px;"></div> 
                <!-- <button type="button"  name="saveBtn" id="saveBtn" class="btn btn-primary saveBtn" >Save</button> -->
               
                </form>

         
</div>
</div>
</div>
</div>
</div>
</div>
</div>

 </section>
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

<script>


  $(document).ready(function() {
     $("#add-more").prop("disabled", true);
    
     $("#event_sch_date").blur(function () {
       $(".start_date").val($(this).val());
       $(".dateChangeCat1").val($(this).val());

     });

     $('#event_sch_date').datetimepicker({
       minDate: new Date(),
       format:'D-M-YYYY'

     });
     $('.start_date').datetimepicker({
       format:'D-M-YYYY',
       minDate: new Date()
     });


     $('#onselectstarttime').timepicker({
       'timeFormat': 'h:i A',
       'step': 10
     });
     $('#onselectstarttime').on('changeTime', function() {
       $ ('#onselectendtime').val ();
       var stime = $(this).val();
       var etime = $('#onselectendtime').val();
       var date = $("input[name='start_date10[]']").val();
       var dateArr = date.split("-");
       var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr["0"];
       var cons_datTime = newDate + " " + stime;
       var now = new Date(cons_datTime);
       now.setHours(now.getHours() + 1);
       var offset = now.toLocaleString();
       var offsetArr = offset.split(" ");

       var addhour = moment($('#onselectstarttime').val(), "hh:mm").add(1, 'hour');

       $('#onselectendtime').timepicker({
         'timeFormat': 'h:i A',
         'step': 15,
         'defaultTime':addhour,
         'minTime':offsetArr[1]

       });

       $('#onselectendtime').on('changeTime', function() {
         $ ('#onselectstarttime').val ();
         var etime = $(this).val();

         if(stime != "" && etime != ""){
           //alert(Converttimeformat(starttime, endtime));
           $(".time_distance").val(Converttimeformat(stime, etime));
         }
       });

       $ ( '#onselectendtime' ).timepicker ( "option", "minTime", offsetArr[1], "defaultTime", addhour);

       if(stime != "" && etime != ""){
         //alert(Converttimeformat(starttime, endtime));
         $(".time_distance").val(Converttimeformat(stime, etime));
       }

     });



     $("#select_bird_type").change(function () {

       $("#bird_id_val").val($(this).val());
       var id = $(this).val();
       if(id != ''){
         $("#add-more").prop("disabled", false);
       }
       else {
         $("#add-more").prop("disabled", true);
       }
     });





     $("#saveBtn").click(function ( ) {
      var locurl = '<?php echo base_url();?>';
       //var form_data = $(this).serializeArray();
       // var form_data = $("#eventForm").serializeArray();
       // alert(form_data);
       var org_name = $( "#org_name option:selected" ).val();
       var form_data = $("#eventForm").serialize();
       if(org_name != ""){
         $.ajax({
           type: "POST",
           url:locurl+"races/add_event",
           cache: false,
           data: form_data,
           success: function(data){
             console.log(data);
             // return false;
             if(data == 1){
                $('.error_logs').html('<div class="alert alert-success text-center"role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Race added successfully!</div>');
                  setTimeout(function() {
                      window.location = locurl+'races/races_list';
                  }, 3000);
                  
             }else{
              $('.error_logs').html('<div class="alert alert-danger text-center"role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Race is not added </div>');
             }
              

             // var stid="#statusdiv";
             // $(stid).html("Event Sucessfully Added.");
             // setTimeout(function(){
             //   // $(".close").click();
             //   // location.reload();
             // }, 3000);
           }

         });
       }else {

         $("p.error_log").html("Select Oraganisation Name..");
       }

     });

   } );

</script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.timepicker.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/front_style.css'); ?>">
  

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.timepicker.js'); ?>"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<style type="text/css">
  .pic-container {
    height: 55%;
    overflow-x:hidden;
}
.save_change{
  margin-top: 10px;
       float: right !important;
    margin-bottom: 10px;
}
.row_right{
  padding-right: 0px;
}
.row_right1{
  padding-top: 25px;
}

@media screen and (max-width : 767px) {
 
}
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
.row_plus label {
    font-size: 10px;
}

}


</style>
          