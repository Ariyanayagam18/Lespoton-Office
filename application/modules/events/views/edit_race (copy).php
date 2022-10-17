<?php
//print_r($bird_type);
$id = $event_list[0]->Events_id;
$event_date = strtotime($event_list[0]->Event_date);

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
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Edit Race</h3>
            <div class="box-tools">
             
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">           
            <div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-10">
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 40px;" id="addMoreCate">Add Category</button>
              </div>
              
                <div class="bs-example bs-example12 col-md-8 col-sm-12 col-xs-12">
                  <div class="box-body">
                    <div class="row">
                    <!-- Edit event  start-->  
                      <div class="panel panel-default marg_class">
                          <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-left: 10px; padding-bottom: 10px;">
                                    <strong><h4><p class="text-center text-success" id="status_re<?php echo $id;?>" style="display: none">Race updated successfully.</p></h4></strong>
                                    
                                    <strong><h4><p class="text-center text-success" id="status_de<?php echo $id;?>" style="display: none">Race deleted successfully.</p></h4></strong>
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Date</label>
                                    <input type="text" class="form-control" name="view_date" id="view_date<?php echo $id;?>" value="<?php echo date("d-m-Y",$event_date);?>">
                                    </div>
                                    <div class="col-md-1 col-lg-1"></div>
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Event Name</label>
                                    <input type="text" class="form-control" name="view_name" id="view_name<?php echo $id;?>" value="<?php echo $event_list[0]->Event_name;?>">
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-left: 10px; padding-bottom: 10px;">
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Latitude</label>
                                    <input type="text" class="form-control" name="view_latitude" id="view_latitude<?php echo $id;?>" value="<?php echo $event_list[0]->Event_lat;?>">
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Longitude</label>
                                    <input type="text" class="form-control" name="view_longitude" id="view_longitude<?php echo $id;?>" value="<?php echo $event_list[0]->Event_long;?>">
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"  style="padding-left: 26px;display: -webkit-inline-flex;display: -ms-inline-flexbox;display: inline-flex;">
                                    <!-- <input style="width: 70px"  type="button" class="btn btn-primary" id="main_ev_edit" value="Edit" onclick="main_event_edit('<?php //echo $id;?>')"> -->
                                    <input type="button" class="btn btn-primary" 
                                    id="main_ev_update" value="Update" onclick="main_event_update('<?php echo $id;?>')">
                                    <input type="button" class="btn btn-default" 
                                    id="main_ev_cancel" value="Cancel" style="margin-left: 20px;" >
                                    <p id="loder<?php echo $id;?>" style="margin-left: 10px;color: red;"></p>
                                  </div>
                                </div>
                            </div>
                          </div>        
                      </div>
                    <!-- Edit event  end--> 
                    <!--  Add Cate-->
                    <div class="panel panel-default" id="CateShows">
                      <div class="panel-heading"><h4>Add New Category</h4></div>
                      <div class="panel-body">
                        <div class="row">
                          <form method="POST" action="" name="addRaceForm" id="addRaceForm">
                            <h4><p class="text-center text-danger" id="error" style="display: none"> Please fill the fields *</p></h4>
                            <h4><p class="text-center text-success" id="success" style="display: none"> Race added successfully</p></h4>
                            <input type="hidden" id="bird_id_val">
                            <input type="hidden" id="event_id" name="event_id" value="<?php echo $id;?>">
                            <!-- plus button start -->
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                              <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10"></div>
                              <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12" style="text-align: right;">
                                <button class="btn form-control button_plus" disabled id="add-more" type="button" onclick="add_more();"><i class="glyphicon glyphicon-plus"></i></button>
                              </div>
                            </div>
                            <!-- plus button end -->
                            <!-- start -->
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                              <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Race Distance (KM) <strong style="color: red;">*</strong></label>
                                    <input type="text" class="form-control" name="bird_distance[]" id="bird_distance" value="" placeholder="Enter The KM">
                                  </div>
                                  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Bird Type<strong style="color: red;">*</strong></label>
                                    <select class="form-control select_bird_type" id="select_bird_type" name="select_bird_type[]">
                                      <option value="">Select Bird Type</option>
                                      <?php
                                      foreach ($bird_type as $btype) {
                                      ?>
                                      <option value = "<?php echo $btype->b_id;?>"><?php echo $btype->brid_type; ?></option>
                                      <?php
                                      }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- end -->
                            <!-- start -->
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                              <div class="copy-fields after-add-more">
                                <div class="input-group control-group ">
                                  <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                    <label>Date</label>
                                    <input type="text" name="start_date10[]" class="form-control start_date dateChangeCat">
                                  </div>
                                  <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                    <label>Start Time</label>
                                    <input type="text" id="onselectstarttime" name="start_time10[]" class="form-control start_time">
                                  </div>
                                  <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                    <label>End Time</label>
                                    <input type="text" id="onselectendtime" name="end_time10[]" class="form-control end_time">
                                  </div>
                                  <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                    <label>Boarding Time</label>
                                    <input type="text" readonly name="time_distance10[]" class="form-control time_distance">
                                  </div>
                                </div>
                              </div>
                              <div class="add_row"></div>
                              <input type="button" value="Save" id="Savecate" class="btn btn-primary pull-right" style="margin-top: 10px;">
                            </div>
                            <!-- end -->
                            <p id="process" class="text-danger text-right" style="margin-right: 20px;"></p>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--  End Cate-->
                    <!--  View Event-->
                    <div class="pic-container">
                      <?php
                      foreach ($event_details as $eve_details) {
                        // echo "<pre>";
                        // print_r($eve_details);
                        // echo "</pre>";
                        $ed_id = $eve_details->ed_id;
                        $edu = $eve_details->bird_id;
                        $events_date=date( 'd-m-Y',strtotime( $eve_details->date));
                      
                      ?>
                      <div class="panel panel-default">
                        <div class="panel-body"> 
                          <div class="row">
                            <div class="row">
                              <strong>
                                <h4><p class="text-center text-success" id="status_re<?php echo $ed_id.$id;?>" style="display: none">Race updated sucessfully.</p></h4>
                              </strong>
                              <strong>
                                <h4><p class="text-center text-success" id="status_de<?php echo $ed_id.$id;?>" style="display: none">Race deleted sucessfully.</p></h4>
                              </strong>
                              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                  <label>Race Distance</label>
                                  <input type="text" class="form-control" disabled name="race_distance" id="race_distance<?php echo $ed_id;?>" value="<?php echo $eve_details->race_distance; ?>">
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                  <label>Bird Type</label>
                                  <select class="form-control" name="Bird_Type" id="Bird_Type<?php echo $ed_id;?>">
                                  <option value="">Select Bird Type</option>
                                  <?php
                                  foreach ($bird_type as $gtype) {
                                      $i = $gtype->b_id;
                                      $val = $gtype->brid_type;
                                  ?>
                                  <option value="<?php echo $i;?>"<?php echo (($i == $edu) ?' selected="selected"':'');?>><?php echo $val;?></option>'
                                  <?php
                                  }
                                  ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                  <label>Event Date</label>
                                  <input type="text" class="form-control" name="Bird_Date" id="Bird_Date<?php echo $ed_id;?>" value="<?php echo $events_date; ?>">
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                  <label>Start Time</label>
                                  <input type="text" class="form-control" name="Bird_start_time" id="Bird_start_time<?php echo $ed_id;?>" value="<?php echo $eve_details->start_time;?>">
                                </div>
                              </div>
                              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                  <label>End Time</label>
                                  <input type="text" class="form-control" name="Bird_end_time" id="Bird_end_time<?php echo $ed_id;?>" value="<?php echo $eve_details->end_time;?>">
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                  <label>Boarding Time</label>
                                    <input type="text" readonly id="boarding_time_distance<?php echo $ed_id;?>" name="boarding_time_distance" class="form-control time_distance<?php echo $ed_id;?>" value="<?php echo $eve_details->boarding_time;?>"> 
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" >
                                  <div style="display: flex;margin-top: 10px;margin-top: 10px;">
                                    <!-- <div id="edit<?php //echo $ed_id;?>">
                                      <button style="width: 70px;" type="button" class="btn btn-primary" id="view_edit<?php //echo $ed_id;?>" value=""  onclick="event_edit('<?php //echo $id;?>','<?php //echo $ed_id;?>')">Edit</button>
                                    </div> -->
                                    <div id="update<?php echo $ed_id;?>">
                                      <button type="button" class="btn btn-primary" id="update_edit<?php echo $ed_id;?>" value="" onclick="event_update('<?php echo $id;?>','<?php echo $ed_id;?>')">Update</button>
                                    </div>
                                    <button type="button" class="btn btn-danger" id="view_delete<?php echo $ed_id;?>" value="" onclick="event_dalete('<?php echo $ed_id;?>')" style="margin-left: 20px;" >Delete</button>

                                    <p id="loder<?php echo $ed_id.$id;?>" style="margin-left: 10px;color: red;"></p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <script type="text/javascript">
                        $(document).ready(function(){
                          var eid = '<?php echo $ed_id;?>';
                          $("#Bird_Date"+eid).datetimepicker({
                              format:'D-M-YYYY',
                          });
                          $("#Bird_start_time"+eid).timepicker({
                             'timeFormat': 'h:i A',
                             'step': 15
                           });
                          $("#Bird_start_time"+eid).on('changeTime', function() {
                             $ ("#Bird_end_time"+eid).val ();
                             var stime = $(this).val();
                             var etime = $("#Bird_end_time"+eid).val('');
                             var date = $("#Bird_Date"+eid).val();
                             var dateArr = date.split("-");
                             var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr[0];
                             var cons_datTime = newDate + " " + stime;
                             var now = new Date(cons_datTime);
                             now.setHours(now.getHours() + 1);
                             var offset = now.toLocaleString();
                             var offsetArr = offset.split(" ");

                             var addhour = moment($("#Bird_start_time"+eid).val(), "hh:mm").add(1, 'hour');
                             $("#Bird_end_time"+eid).timepicker({
                               'timeFormat': 'h:i A',
                               'step': 15,
                               'defaultTime':addhour,
                               'minTime':offsetArr[1]
                             });

                             $("#Bird_end_time"+eid).on('changeTime', function() {
                               $ ("#Bird_start_time"+eid).val ();
                               var etime = $(this).val();

                               if(stime != "" && etime != ""){
                                 $(".time_distance"+eid).val(Converttimeformat(stime, etime));
                               }
                             });

                             $ ("#Bird_end_time"+eid).timepicker ( "option", "minTime", offsetArr[1], "defaultTime", addhour);

                             if(stime != "" && etime != ""){
                               //alert(Converttimeformat(starttime, endtime));
                               $(".time_distance"+eid).val(Converttimeformat(stime, etime));
                             }

                          });
                        });
                      </script>
                      <?php
                      }
                      ?>
                    </div>
                    <!--  End Event-->
                    </div>
                  </div>  
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
<script>


  $(document).ready(function(){
     $("#addMoreCate").click(function(){
       //$("#CateShows").toggle(1000);
       $("#CateShows").show();
     });

     $("#select_bird_type").change(function () {
       var id = $(this).val();
       if(id != ''){
         $("#add-more").prop("disabled", false);
       }
       else {
         $("#add-more").prop("disabled", true);
       }
     });


     $("#event_sch_date").blur(function () {
       $(".start_date").val($(this).val());
       $(".dateChangeCat").val($(this).val());

     });

     $('#event_sch_date').datetimepicker({
       minDate: new Date(),
       format:'D-M-YYYY'

     });

     $('.start_date').datetimepicker({
      minDate: new Date(),
      format:'D-M-YYYY'
     });



     $("input[name='start_time10[]']").timepicker({
       'timeFormat': 'h:i A',
       'step': 5
     });

     $("input[name='start_time10[]']").on('changeTime', function() {
       $ ("input[name='end_time10[]']").val ();
       var stime = $(this).val();
       var etime = $("input[name='end_time10[]']").val();
       var date = $("input[name='start_date10[]']").val();
       var dateArr = date.split("-");
       var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr[0];
       var cons_datTime = newDate + " " + stime;
       var now = new Date(cons_datTime);
       now.setHours(now.getHours() + 1);
       var offset = now.toLocaleString();
       var offsetArr = offset.split(" ");

       var addhour = moment($("input[name='start_time10[]']").val(), "hh:mm").add(1, 'hour');

       $("input[name='end_time10[]']").timepicker({
         'timeFormat': 'h:i A',
         'step': 15,
         'defaultTime':addhour,
         'minTime':offsetArr[1]

       });

       $("input[name='end_time10[]']").on('changeTime', function() {
         $ ("input[name='start_time10[]']").val ();
         var etime = $(this).val();

         if(stime != "" && etime != ""){
           $(".time_distance").val(Converttimeformat(stime, etime));
         }
       });

       $ ( "input[name='end_time10[]']" ).timepicker ( "option", "minTime", offsetArr[1], "defaultTime", addhour);

       if(stime != "" && etime != ""){
         //alert(Converttimeformat(starttime, endtime));
         $(".time_distance").val(Converttimeformat(stime, etime));
       }

     });

     $("#Savecate").click(function ( ) {
      var locurl = '<?php echo base_url()?>';
       var dis = $("#bird_distance").val();
       var types = $("#select_bird_type").val();

       if(dis != "" && types !=""){
         var form_data = $("#addRaceForm").serialize();
         $.ajax({
           type: "post",
           url:locurl+"races/add_anoter_event",
           cache: false,
           data: form_data,
           success: function(data){
             console.log(data);
             $("p#process").html("Processing...");
             if(data == "1"){
               setTimeout(function(){
                 $("p#process").css("display", "none");
                 $("p#success").css("display", "block");
                 $("p#success").fadeOut(2000);
                 $("#viewModal").delay(1500).fadeOut(3000);
               }, 500);

               setTimeout(function(){
                 $("#viewModal").modal("hide");
               }, 500);
             }

           }

         });

       }
       else
       {
         alert("Please fill the all field *");
       }
     });



   });

</script> 
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.timepicker.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/front_style.css'); ?>">
  

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.timepicker.js'); ?>"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<style type="text/css">
    .pic-container { 
    height: 315px;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 10px;
    border: 1px solid #ccc;
}
  .box-body
  {
     margin: 0px auto;
     width: 750px;
  }
</style>
          