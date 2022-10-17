<?php
//print_r($bird_type);
$id = $event_list[0]->Events_id;
$event_date = strtotime($event_list[0]->Event_date);
$eventenddate = strtotime($event_list[0]->Eventend_date);

$server_data = array();
$bird_data = array();
foreach ($bird_type as $key => $value) {
    # code...

    $bird_data["b_id"] = $value->b_id;
    $bird_data["brid_type"] = $value->brid_type;
    array_push($server_data, $bird_data);
}

$bl = json_encode($server_data);
$get_users_id = $this->db->query("select Org_id from ppa_events where Events_id = '".$id."'");
$user_id = $get_users_id->row_array();
$user_id = $user_id['Org_id'];
//$user_id = $this->session->userdata("user_details")[0]->users_id;
?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
<?php if ($this->session->flashdata("messagePr")) {?>
  <div class="alert alert-info">
  <?php echo $this->session->flashdata("messagePr") ?>
  </div>
  <?php }?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Edit Race Details</h3>
            <div class="box-tools">

            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">


                <div class="bs-example bs-example12 col-md-8 col-sm-12 col-xs-12">
               <!-- <div class="pic-container">  -->
                  <div class="box-body pic-container">
                  <form id="update_race" name="update_race" method="post" action="">
                  <div class="error_log"></div>
                    <div class="row">
                    <!-- Edit event  start-->
                    <input type="hidden" id="org_name" name="org_name" value="<?php echo $user_id; ?>">
                      <div class="panel panel-default marg_class">
                        <div class="panel-heading">
                          <h4>Race Details</h4>
                        </div>
                          <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-left: 10px; padding-bottom: 10px;">
                                    <!-- <strong><h4><p class="text-center text-success" id="status_re<?php //echo $id;?>" style="display: none">Race updated successfully.</p></h4></strong>

                                    <strong><h4><p class="text-center text-success" id="status_de<?php //echo $id;?>" style="display: none">Race deleted successfully.</p></h4></strong> -->
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 mb-5">
                                    <label>Date</label>
                                    <input type="text" class="form-control current_race_date" name="view_date" id="view_date<?php echo $id; ?>" data-id="<?php echo $id; ?>" value="<?php echo date("d-m-Y", $event_date); ?>">
                                    </div>

                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 mb-5">
                                    <label>End Date</label>
                                    <input type="text" class="form-control end_race_date" name="view_end_race_date" id="end_race_date<?php echo $id; ?>" data-id="<?php echo $id; ?>" value="<?php echo date("d-m-Y", $eventenddate); ?>">
                                    </div>

                                    
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 mb-5">
                                    <label>Event Name</label>
                                    <input type="text" class="form-control" name="view_name" id="view_name<?php echo $id; ?>" value="<?php echo $event_list[0]->Event_name; ?>">
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 mb-5">
                                    <label>Latitude</label>
                                    <input type="text" class="form-control" name="view_latitude" id="view_latitude<?php echo $id; ?>" value="<?php echo $event_list[0]->Event_lat; ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-left: 10px; padding-bottom: 10px;">
                                    
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 mb-5">
                                    <label>Longitude</label>
                                    <input type="text" class="form-control" name="view_longitude" id="view_longitude<?php echo $id; ?>" value="<?php echo $event_list[0]->Event_long; ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"  style="padding-left: 26px;display: -webkit-inline-flex;display: -ms-inline-flexbox;display: inline-flex;">
                                    <!-- <input style="width: 70px"  type="button" class="btn btn-primary" id="main_ev_edit" value="Edit" onclick="main_event_edit('<?php //echo $id;?>')"> -->
                                    <!-- <input type="button" class="btn btn-primary"
                                    id="main_ev_update" value="Update" onclick="main_event_update('<?php //echo $id;?>')"> -->
                                    <a href="<?php echo base_url() . 'user/races' ?>"><input type="button" class="btn btn-default"
                                    id="main_ev_cancel" value="Cancel"></a>
                                    <p id="loder<?php echo $id; ?>" style="margin-left: 10px;color: red;"></p>
                                  </div>
                                </div>
                            </div>
                          </div>
                      </div>
                    <!-- Edit event  end-->
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                      <button  type="button" class="btn btn-primary pull-right" id="addMoreCate">Add Category</button>
                      <button type="button" class="btn btn-primary pull-right" id="addMoreDate" style="margin-right: 10px;">Add Date</button>
                    </div>
                    <input type="hidden" value='<?php echo $bl; ?>' id="bird_values">
                    <br><br><br>
                    <!--  Add Cate-->
                    <div class="panel panel-default" id="CateShows">
                      <div class="panel-heading">
                      <h4>Category Details</h4>
                      <button class="btn btn-danger pull-right remove" type="button" style="margin-top: -50px;margin-right: -15px;"><i class="glyphicon glyphicon-remove"></i></button>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <!-- <form method="POST" action="" name="addRaceForm" id="addRaceForm"> -->
                            <h4><p class="text-center text-danger" id="error" style="display: none"> Please fill the fields *</p></h4>
                            <h4><p class="text-center text-success" id="success" style="display: none"> Race added successfully</p></h4>
                            <input type="hidden" id="bird_id_val">
                            <input type="hidden" id="event_id" name="event_id" value="<?php echo $id; ?>">
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
                                  <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                    <label>Bird Type<strong style="color: red;">*</strong></label>
                                    <select class="form-control select_bird_type" id="select_bird_type" name="select_bird_type[]" onchange="check_val(this);">
                                      <option value="">Select Bird Category</option>
<?php
foreach ($bird_type as $btype) { 
//echo "<pre>"; print_r($bird_type); die;
    ?>
                                        <option value = "<?php echo $bird_type->b_id; ?>"><?php echo $bird_type->brid_type; ?></option>
  <?php
 }
?>
</select>
                                  </div>

                                  <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                  <label>Bird Tag Color</label>
                                  <select class="form-control bird_tag_color" id="select_bird_tag_color" name="select_bird_tag_color[]" onchange="check_tag_color(this);">
                                    <option value="">Select Bird Tag Color</option>
                                     <!-- <option value="Yellow">Yellow</option>
                                     <option value="Red">Red</option>
                                     <option value="Blue">Blue</option>
                                     <option value="Green">Green</option> -->
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
                          <!-- </form> -->
                        </div>
                      </div>
                    </div>
                    <!--  End Cate-->
                    <!--  View Event-->
                    <div class="row">
                      <div class="panel-heading">
                        <h4 style="background-color: #f5f5f5;border-color: #ddd;padding: 15px;border-radius: 6px;">Category Details</h4>
                      </div>
                    <div class="col-md-12" id="add_more_date">
<?php
$i = 1;
foreach ($event_details as $eve_details) {
  //echo "<pre>"; print_r($eve_details);
  $eventID = $eve_details->event_id;
    $ed_id = $eve_details->ed_id;
    $edu = $eve_details->bird_id;
    $color = $eve_details->bird_tag_color;
    $events_date = date('d-m-Y', strtotime($eve_details->date));
    ?>
                        <div class="col-md-6 date_count" id="date_count<?php echo $i; ?>">
                        <div class="panel panel-default">
                          <div class="panel-body">
                            <div class="row">
                              <div class="row">
                                <!-- <strong>
                                  <h4><p class="text-center text-success" id="status_re<?php //echo $ed_id.$id;?>" style="display: none">Race updated sucessfully.</p></h4>
                                </strong>
                                <strong>
                                  <h4><p class="text-center text-success" id="status_de<?php //echo $ed_id.$id;?>" style="display: none">Race deleted sucessfully.</p></h4>
                                </strong> -->
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                                  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Race Distance</label>
                                    <input type="text" class="form-control race_distance" readonly="" name="race_distance[]" id="race_distance<?php echo $ed_id; ?>" value="<?php echo $eve_details->race_distance; ?>">
                                  </div>
                                  <input type="hidden" class="form-control race_distance" readonly="" name="event_det_id[]" value="<?php echo $ed_id; ?>">
                                  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Bird Type</label>
                                    <select class="form-control same_category" name="Bird_Type[]" id="Bird_Type<?php echo $ed_id; ?>" onchange="check_val(this);">

                                    <option value="">Select Bird Type</option>
  <?php
foreach ($bird_type as $gtype) {
        $i = $gtype->b_id;
        $val = $gtype->brid_type;
        ?>
                                      <option value="<?php echo $i; ?>"<?php echo (($i == $edu) ? ' selected="selected"' : '');
        ?>><?php echo $val;
        ?></option>'
    <?php
}
    ?>
                                    </select>
                                  </div>

                                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <label>Bird Tag Color</label>
                                    <select class="form-control same_color" id="BirdTag_color" name="BirdTag_color[]" onchange="check_tag_color(this);">
                                       <?php
                                      foreach ($bird_sticker_color as $sticker_color) {
                                               $val = $sticker_color->sticker_color; 
                                               echo $color;
                                              ?>
                                                <option value="<?php echo $val; ?>"<?php echo (($val == $color) ? ' selected="selected"' : '');
                                              ?>><?php echo $val;
                                              ?></option>'
                                          <?php
                                      }
                                          ?>
                                    </select>
                                  </div>

                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                                  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Event Date</label>
                                    <input type="text" class="form-control events_date" readonly name="Bird_Date[]" id="Bird_Date<?php echo $ed_id; ?>" value="<?php echo $events_date; ?>">
                                  </div>
                                  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Start Time</label>
                                    <input type="text" class="form-control start_time" name="Bird_start_time[]" id="Bird_start_time<?php echo $ed_id; ?>" value="<?php echo $eve_details->start_time; ?>">
                                  </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                                  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>End Time</label>
                                    <input type="text" class="form-control end_time" name="Bird_end_time[]" id="Bird_end_time<?php echo $ed_id; ?>" value="<?php echo $eve_details->end_time; ?>">
                                  </div>
                                  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label>Boarding Time</label>
                                      <input type="text" readonly id="boarding_time_distance<?php echo $ed_id; ?>" name="boarding_time_distance[]" class="form-control time_distance<?php echo $ed_id; ?>" value="<?php echo $eve_details->boarding_time; ?>">
                                  </div>
                                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" >
                                    <div style="display: flex;margin-top: 10px;margin-top: 10px;">
                                      <?php 
                                      $get_basketing = $this->db->query("select bird_type from ppa_basketing where ( event_details_id = '".$ed_id."' or event_id = '".$eventID."' ) and bird_type = '".$edu."'"); 
                                      $get_basketing_count = $get_basketing->num_rows();
                                      ?>
                                      <button type="button" class="btn btn-danger" id="view_delete<?php echo $ed_id; ?>" value="" onclick="eventdetail_delete('<?php echo $ed_id; ?>','<?php echo $id; ?>','<?php echo $get_basketing_count; ?>')">Delete</button>
                                      <p id="loder<?php echo $ed_id . $id; ?>" style="margin-left: 10px;color: red;"></p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <script type="text/javascript">
                          $(document).ready(function(){
                            var eid = '<?php echo $ed_id; ?>';

                            $("#Bird_Date"+eid).datetimepicker({
                                format:'DD-M-YYYY',
                            });
                            $("#Bird_start_time"+eid).timepicker({
                               'timeFormat': 'h:i A',
                               'step': 15
                             });
                            $("#Bird_end_time"+eid).timepicker({
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
                            $("#Bird_end_time"+eid).on('changeTime', function() {

                               var stime = $ ("#Bird_start_time"+eid).val ();
                               var etime = $(this).val();;
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

                              // $("#Bird_end_time"+eid).on('changeTime', function() {
                                 $ ("#Bird_start_time"+eid).val ();


                                 if(stime != "" && etime != ""){
                                   $(".time_distance"+eid).val(Converttimeformat(stime, etime));
                                 }
                              // });

                               $ ("#Bird_end_time"+eid).timepicker ( "option", "minTime", offsetArr[1], "defaultTime", addhour);

                               if(stime != "" && etime != ""){
                                 //alert(Converttimeformat(starttime, endtime));
                                 $(".time_distance"+eid).val(Converttimeformat(stime, etime));
                               }


                            });
                          });
                        </script>
                        </div>
  <?php
$i++;
}
?>
                      </div>
                      </div>
                    </div>

                    <!--  End Event-->
                      <input type="button" name="updateRaceformtester" id="updateRaceform" value="Update" class="btn btn-primary pull-right" onclick="location.href = 'https://pigeonsportsclock.com/pigeon/user/races';">
                      <p class="text-danger process" style="float: right;margin-right: 25px;margin-top: 8px;"></p>
                      <input type="button" value="Cancel" class="btn btn-primary cancelBtn" id="cancelBtn" style="margin-bottom: 10px; margin-left: 10px;" onClick="document.location.href='https://pigeonsportsclock.com/pigeon/user/races'"/>

                     </form>
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script>
function alertmsg(msg)
{
  toastr.error(msg, 'Lespoton');
}

function check_val(e) { 
     $('.same_category,.select_bird_type').each(function(i, ele){
            if(ele != e && ele.value == e.value){
                   //Throw an error Here <---
                  alertmsg("We must not choose same Bird Category");
                  $("#Savecate").prop("disabled",true);
                  $("#updateRaceform").prop("disabled",true);
                  return false;   
            }else{
                $("#Savecate").prop("disabled",false);
                $("#updateRaceform").prop("disabled",false);
            }
      })
    }

function check_tag_color(e) { 
     $('.same_color,.bird_tag_color').each(function(i, ele){
            if(ele != e && ele.value == e.value){
                   //Throw an error Here <---
                  alertmsg("We must not choose same Bird Tag Color");
                  $("#Savecate").prop("disabled",true);
                  $("#updateRaceform").prop("disabled",true);
                  return false;   
            }else{
                $("#Savecate").prop("disabled",false);
                $("#updateRaceform").prop("disabled",false);
            }
      })
    }

    $("#addMoreCate").click(function(){
      var org_name = $("#org_name").val();
        if(org_name != "")
        {
          $.ajax({
           type: "POST",
           url:locurl+"events/get_bird_value",
           cache: false,
           //data: org_name,
           data: { org_name: org_name },
           dataType: 'json',
           success: function(data){
            if($(".select_bird_type").val() == "" && $(".bird_tag_color").val() == "")
              {
                $('.select_bird_type').find('option').not(':first').remove();
                $('.bird_tag_color').find('option').not(':first').remove();
                 $.each(data, function(key, value) {
                  if(value.b_id != null)
                  {
                      $('.select_bird_type').append('<option value="'+ value.b_id +'">'+ value.brid_type +'</option>');
                  }
                  if(value.ide != null)
                  {
                      $('.bird_tag_color').append('<option value="'+ value.sticker_color +'">'+ value.sticker_color +'</option>');
                  }
                  });
              }
           }

         });
      }
  });


  $(document).ready(function(){

        var st_date = $("input[name=view_date]").val();
        var end_date = $("input[name=view_end_race_date]").val();

        if(st_date == end_date)
        {
          $("#addMoreDate").prop("disabled", true);
        }
        /*Functionality added on 22-01-2022*/
        if(end_date > st_date)
        {
          $(".events_date").attr("readonly",false);
        }
        else if(end_date == st_date)
        {
          $(".events_date").attr("readonly",true);
        }
        /*Functionality added on 22-01-2022*/

        $('input[name="view_end_race_date"]').blur(function(){
          if ($(this).val())
          {
            $("#addMoreDate").prop("disabled", false);
          }else if ($(this).val() == ''|| end_date == 'NULL')
          {
            $("#updateRaceform").prop("disabled", true);
          }
          if ($(this).val() !='')
          {
            $("#updateRaceform").prop("disabled", false);
          }
        });

        // $(".end_race_date").on("blur", function() {
        //   if(end_date > st_date)
        //   {
        //     $("#addMoreDate").prop("disabled", false);
        //   }
        // });


     $("#addMoreCate").click(function(){
       //$("#CateShows").toggle(1000);
       $("#CateShows").show();
     });

     // var org_name = $("#org_name").val();
     // if(org_name != "")
     //  {
     //      $.ajax({
     //       type: "POST",
     //       url:locurl+"events/get_bird_value",
     //       cache: false,
     //       //data: org_name,
     //       data: { org_name: org_name },
     //       dataType: 'json',
     //       success: function(data){
     //        $('.bird_type').find('option').not(':first').remove();
     //        $('.bird_tag_color').find('option').not(':first').remove();
     //         $.each(data, function(key, value) {
     //          if(value.b_id != null)
     //          {
     //              $('.bird_type').append('<option value="'+ value.b_id +'">'+ value.brid_type +'</option>');
     //          }
     //          if(value.ide != null)
     //          {
     //              $('.bird_tag_color').append('<option value="'+ value.sticker_color +'">'+ value.sticker_color +'</option>');
     //          }
     //          });
     //       }

     //     });
     //  }

     $(".end_race_date").blur(function () {
       let race_distance = $(".race_distance").val();
       let bird_type = $(".bird_type").val();
       let bird_tag_color = $(".bird_tag_color").val();
       if(race_distance == "" && bird_type == "" && bird_tag_color == "")
       {
          $("#add-more").prop("disabled", true);
       }else{
          $("#add-more").prop("disabled", false);
       }
     });


     $('.current_race_date,.end_race_date').datetimepicker({
          format:'DD-M-YYYY'
      });

     $('.current_race_date').focus(function(){
      $('.current_race_date').datetimepicker({
            
        });
     });

     $('.current_race_date').datetimepicker().on('dp.change', function (e) {
          var incrementDay = moment(new Date(e.date));
          incrementDay.add(0, 'days');
          $('.end_race_date').data('DateTimePicker').minDate(incrementDay);
          $(this).data("DateTimePicker").hide();
      });

      $('.end_race_date').datetimepicker().on('dp.change', function (e) {
          var start_date = new Date($('.current_race_date').val());
          var end_date = new Date($('.end_race_date').val());
          if(end_date <= start_date)
          {
            var decrementDay = moment(new Date(e.date));
            decrementDay.subtract(0, 'days');
            $('.end_race_date').data('DateTimePicker').minDate(decrementDay);
            $(this).data("DateTimePicker").hide();
          }
          // else{
          //   var decrementDay = moment(new Date(e.date));
          //   decrementDay.subtract(1, 'days');
          //   $('.end_race_date').data('DateTimePicker').minDate(decrementDay);
          //    $(this).data("DateTimePicker").hide();
          // }
      });

     //new date validation start

     // $('.current_race_date').datetimepicker({
     //      useCurrent: true,
     //      format:'DD-M-YYYY',
     //      minDate: new Date()
     //  });

     //  $('.end_race_date').datetimepicker({
     //      useCurrent: true,
     //      format:'DD-M-YYYY',
     //      minDate: new Date()
     //  });

     //  $('.current_race_date').datetimepicker().on('dp.change', function (e) {
     //      var incrementDay = moment(new Date(e.date));
     //      incrementDay.add(0, 'days');
     //      $('.end_race_date').data('DateTimePicker').minDate(incrementDay);
     //      $(this).data("DateTimePicker").hide();
     //  });

     //  $('.end_race_date').datetimepicker().on('dp.change', function (e) {
     //      var start_date = new Date($('.current_race_date').val());
     //      var end_date = new Date($('.end_race_date').val());
     //      if(end_date <= start_date)
     //      {
     //        var decrementDay = moment(new Date(e.date));
     //        decrementDay.subtract(0, 'days');
     //        $('.end_race_date').data('DateTimePicker').minDate(decrementDay);
     //        $(this).data("DateTimePicker").hide();
     //      }else{
     //        var decrementDay = moment(new Date(e.date));
     //        decrementDay.subtract(1, 'days');
     //        $('.end_race_date').data('DateTimePicker').minDate(decrementDay);
     //         $(this).data("DateTimePicker").hide();
     //      }
     //  });

     // $('.end_date').datetimepicker({
     //   format:'DD-M-YYYY',
     //   minDate: new Date()
     // });
//new date validation end

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
       format:'DD-M-YYYY'

     });

     $('.start_date').datetimepicker({
      minDate: new Date(),
      format:'DD-M-YYYY'
     });

     $('.start_time').on('keypress', function (event) {
        var regex = new RegExp("^[APM0-9:]+$");
        var start_time = $(this).val();
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
           event.preventDefault();
           return false;
        }
    });

     $('.end_time').on('keypress', function() {
        var regex = new RegExp("^[APM0-9:]+$");
        var start_time = $(this).val();
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
           event.preventDefault();
           return false;
        }
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

     $("#updateRaceform").click(function ( ) {
      // $(".error_log").html('<div class="alert alert-success text-align">Race deleted successfully.</div').delay(3000).fadeOut('slow');
      $("p.process").html("Processing Please wait ...");
      var parTag = '#add_more_date';
      var startDate = new Date($("#view_date<?php echo $id; ?>").val());
      var endDate = new Date($("#end_race_date<?php echo $id; ?>").val());
      var lastDate = new Date($(".events_date").last().val());

      if(lastDate < startDate)
      {
        $("p.process").html("");
        alertmsg("Your Race Date should be with in start date");
        return false;
      }

      if(endDate < lastDate)
      {
        $("p.process").html("");
        alertmsg("Your Race Date should be with in end date");
        return false;
      }

       var rdvalid = true;
        $(parTag).find(".race_distance").each(function() {
          if($(this).val() == ""){
            $( this ).focus();
            rdvalid = false;
          }
        });
        if(rdvalid == false){
          alertmsg("Enter the Distance");
          return false;
        }

        var btvalid = true;
        $(parTag).find(".bird_type").each(function() {
          if($(this).val() == ""){
            $( this ).focus();
            btvalid = false;
          }
        });
        if(btvalid == false){
          alertmsg("Select Bird Type");
          return false;
        }


        var btcvalid = true;
          $(parTag).find(".bird_tag_color").each(function() {
            if($(this).val() == ""){
              $( this ).focus();
              btcvalid = false;
            }
          });
          if(btcvalid == false){
            alertmsg("Select Bird Tag Color");
            return false;
          }


      var edvalid = true;
        $(parTag).find(".events_date").each(function() {
          if($(this).val() == ""){
            $( this ).focus();
            edvalid = false;
          }
        });
        if(edvalid == false){
          alertmsg("Select Event Date");
          return false;
        }


        var stvalid = true;
        $(parTag).find(".start_time").each(function() {
          if($(this).val() == ""){
            $( this ).focus();
            stvalid = false;
          }
        });
        if(stvalid == false){
          alertmsg("Select Start Time");
          return false;
        }

        var etvalid = true;
        $(parTag).find(".end_time").each(function() {
          if($(this).val() == ""){
            $( this ).focus();
            etvalid = false;
          }
        });
        if(etvalid == false){
          alertmsg("Select End Time");
          return false;
        }

        if(etvalid == false){
          alertmsg("Select End Time");
          return false;
        }

      var locurl = '<?php echo base_url() ?>';
      console.log("locurl:",locurl); //https://pigeonsportsclock.com/pigeon
      var form_data = $("#update_race").serialize();
      console.log("form_data:",form_data);
      $.ajax({
           type: "post",
           url:locurl+"events/update_category",
           cache: false,
           data: form_data,
           success: function(data){
             // console.log(data);
             // return false;
             //$("p.process").html("Processing...");
             if(data == 1){
               setTimeout(function(){
                 $("p.process").css("display", "none");
                 $(".error_log").html('<div class="alert alert-success text-align">Race updated successfully.</div').delay(4000).fadeOut('slow');
                 window.location = locurl+'user/races';
                 // $("p#success").css("display", "block");
                 // $("p#success").fadeOut(2000);
                 //$("#viewModal").delay(1500).fadeOut(3000);
               }, 1500);

               // setTimeout(function(){
               //   $("#viewModal").modal("hide");
               // }, 500);
             }

           }

         });
     });


     $("#Savecate").click(function ( ) {
      var locurl = '<?php echo base_url() ?>';
       var dis = $("#bird_distance").val();
       var types = $("#select_bird_type").val();
       var start_time = $(".start_time").val();
       var end_time = $(".end_time").val();
//        var myform = document.getElementById("update_race");
//       var fd = new FormData(myform );
// console.log(fd);
//              return false;
       if(dis != "" && types !="" && start_time != "" && end_time != ""){
         var form_data = $("#update_race").serialize();

         $.ajax({
           type: "post",
           url:locurl+"events/add_anoter_event",
           cache: false,
           data: form_data,
           success: function(data){
             // console.log(data);
             // return false;
             $("p#process").html("Processing...");
             if(data == "1"){
               setTimeout(function(){
                 $("p#process").css("display", "none");
                 $("p#success").css("display", "block");
                 $("p#success").fadeOut(2000);
                 $("#viewModal").delay(1500).fadeOut(3000);

                 location.reload(true);
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
         alertmsg("Please fill the all field *");
       }
     });


      $('#addMoreDate').on('click',function(){

    var org_name = $("#org_name").val();
    var rdc = $('.date_count').length+1;
    if(org_name != "")
        {
          $.ajax({
           type: "POST",
           url:locurl+"events/get_bird_value",
           cache: false,
           //data: org_name,
           data: { org_name: org_name },
           dataType: 'json',
           success: function(data){
            for(var i = rdc; i <= rdc; i++)
            {
                   $.each(data, function(key, value) {
                    if(value.sticker_color != null)
                    {
                        $("#BirdTag_color"+rdc).append('<option value="'+ value.sticker_color +'">'+ value.sticker_color +'</option>');
                    }
                  });
            }
           }

         });
      }

        var parTag = '#add_more_date';
          var rdvalid = true;
        $(parTag).find(".race_distance").each(function() {
          if($(this).val() == ""){
            $( this ).focus();
            rdvalid = false;
          }
        });
        if(rdvalid == false){
          alertmsg("Enter the Distance");
          return false;
        }

        var btvalid = true;
        $(parTag).find(".bird_type").each(function() {
          if($(this).val() == ""){
            $( this ).focus();
            btvalid = false;
          }
        });
        if(btvalid == false){
          alertmsg("Select Bird Type");
          return false;
        }


      var edvalid = true;
        $(parTag).find(".events_date").each(function() {
          if($(this).val() == ""){
            $( this ).focus();
            edvalid = false;
          }
        });
        if(edvalid == false){
          alertmsg("Select Event Date");
          return false;
        }


        var stvalid = true;
        $(parTag).find(".start_time").each(function() {
          if($(this).val() == ""){
            $( this ).focus();
            stvalid = false;
          }
        });
        if(stvalid == false){
          alertmsg("Select Start Time");
          return false;
        }

        var etvalid = true;
        $(parTag).find(".end_time").each(function() {
          if($(this).val() == ""){
            $( this ).focus();
            etvalid = false;
          }
        });
        if(etvalid == false){
          alertmsg("Select End Time");
          return false;
        }

        var row_no = $('#bird_values').val();
        var servers = $.parseJSON(row_no);
        var rdc = $('.date_count').length+1;
        var select = '<select class="form-control bird_type" id="Bird_Type'+rdc+'" name="Bird_Type[]"><option value="">Select Bird Type</option>';
          $.each(servers, function(index, items) {
            select +='<option value="' + items.b_id + '">' + items.brid_type + '</option>';
          });
          select +='</select>';
          
          var end_new_date = $("input[name=view_end_race_date]").val();

          var html ='<div class="col-md-6 date_count" id="date_count'+rdc+'"><div class="panel panel-default"><div class="panel-body"><div class="row"><div class="row"><div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;"><div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"><label>Race Distance</label><input type="text" class="form-control race_distance" name="race_distance[]" id="race_distance'+rdc+'" value=""></div><div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"><label>Bird Category</label>'+select+'</div></div><div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"><label>Bird Tag Color</label><select class="form-control same_color" id="BirdTag_color'+rdc+'" name="BirdTag_color[]"></select> </div><div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;"><div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"><label>Event Date</label><input type="text" class="form-control events_date" name="Bird_Date[]" id="Bird_Date'+rdc+'" value=""></div><div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"><label>Start Time</label><input type="text" class="form-control start_time" name="Bird_start_time[]" id="Bird_start_time'+rdc+'" value=""></div></div><div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;"><div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"><label>End Time</label><input type="text" class="form-control end_time" name="Bird_end_time[]" id="Bird_end_time'+rdc+'" value=""></div><div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"><label>Boarding Time</label><input type="text" readonly id="boarding_time_distance'+rdc+'" name="boarding_time_distance[]" class="form-control time_distance'+rdc+'" value=""></div><div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"><div style="display: flex;margin-top: 10px;margin-top: 10px;"><button type="button" class="btn btn-danger" id="view_delete'+rdc+'" value="" onclick="remove_more_date('+rdc+')">Delete</button><p id="loder'+rdc+'" style="margin-left: 10px;color: red;"></p></div></div></div></div></div></div></div></div>';

          

          $("#add_more_date").append(html);

          var min_date = $("input[name=view_date]").val();
          var max_date = $("input[name=view_end_race_date]").val();
          var dateFormat = "DD-MM-YYYY";

          dateMin = moment(min_date, dateFormat);
          dateMax = moment(max_date, dateFormat);

          $("#Bird_Date"+rdc).datetimepicker({
              format:dateFormat,
              minDate: dateMin,
              maxDate: dateMax
          
          });

          $("#Bird_start_time"+rdc).timepicker({
             'timeFormat': 'h:i A',
             'step': 15
           });

            $("#Bird_start_time"+rdc).on('changeTime', function() {
                 $ ("#Bird_end_time"+rdc).val ();
                 var stime = $(this).val();
                 var etime = $("#Bird_end_time"+rdc).val('');
                 var date = $("#Bird_Date"+rdc).val();
                 var dateArr = date.split("-");
                 var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr[0];
                 var cons_datTime = newDate + " " + stime;
                 var now = new Date(cons_datTime);
                 now.setHours(now.getHours() + 1);
                 var offset = now.toLocaleString();
                 var offsetArr = offset.split(" ");

                 var addhour = moment($("#Bird_start_time"+rdc).val(), "hh:mm").add(1, 'hour');
                 $("#Bird_end_time"+rdc).timepicker({
                   'timeFormat': 'h:i A',
                   'step': 15,
                   'defaultTime':addhour,
                   'minTime':offsetArr[1]
                 });

                 $("#Bird_end_time"+rdc).on('changeTime', function() {
                   $ ("#Bird_start_time"+rdc).val ();
                   var etime = $(this).val();

                   if(stime != "" && etime != ""){
                     $(".time_distance"+rdc).val(Converttimeformat(stime, etime));
                   }
                 });

                 $ ("#Bird_end_time"+rdc).timepicker ( "option", "minTime", offsetArr[1], "defaultTime", addhour);

                 if(stime != "" && etime != ""){
                   //alert(Converttimeformat(starttime, endtime));
                   $(".time_distance"+rdc).val(Converttimeformat(stime, etime));
                 }

            });
      });



   });

function remove_more_date (no ) {
  //$(this).parents(".control-group"+id).remove();
  $('#date_count'+no).remove();
}


function eventdetail_delete(ed_id,id,count){
  if(count > 0)
  {
    alertmsg("You cant delete this category because you already basketed for this category");
    return false;
  }
  var con = confirm("Are sure delete to the event?");
  if(con){
    $("#view_edit"+id).prop('disabled',true);
    $("#view_delete"+ed_id).prop('disabled',true);
    $("p#loder"+ed_id+id).html("");
    $.ajax( {
      type: "post",
      url: locurl+"events/event_deleted",
      cache: false,
      data: {'ids': ed_id},
      success: function ( data ) {
        // console.log(data);
        // return false;
        if(data == 1){
          $("p#loder"+ed_id+id).html("Processing");
          setTimeout(function(){
            $("p#loder"+ed_id+id).css("display", "none");
            $("p#status_de"+ed_id+id).css("display", "block");
            $("p#status_de"+ed_id+id).fadeOut(2000);
          }, 1500);


          setTimeout(function(){
            $("p#loder"+ed_id+id).html("");
            /*$("p#loder"+id).css("display", "none");
            $("p#status_de"+id).fadeOut(2000);*/
            $("#view_delete"+ed_id).parent('div').parent('div').parent('div').parent('div').parent('div').parent('div').parent('div').remove();
            // $("#view_delete"+id).parent('div').parent('div').parent('div').parent('div').parent('div').parent('div').parent('div').parent('div').remove();
            //$('#viewModal').delay(1500).fadeOut(3000);
          }, 2500);

          // setTimeout(function(){
          //  $('#viewModal').modal("hide");
          // }, 5000);
        }
      }
    });
  }

}




</script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.timepicker.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/front_style.css'); ?>">


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.timepicker.js'); ?>"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<!-- script src="<?php //echo base_url('assets/js/front_controller.js');?>"></script> -->
<script type="text/javascript">

  $('.remove').on('click',function(){
     $("#CateShows").hide();
  });




</script>
<script type="text/javascript">
    // document.getElementById("myButton").onclick = function () {
    //     location.href = "https://pigeonsportsclock.com/pigeon/user/races";
    // };
</script>
<style type="text/css">
    .pic-container {
    /*height: 315px;
    overflow-y: auto;
    overflow-x: hidden;*/
    padding: 30px;
    border: 1px solid #ccc;
}
  .box-body
  {
     margin: 0px auto;
     width: 750px;
  }
  .mb-5 {
    margin-bottom: 15px;
}
input#cancelBtn {
    float: right;
}
</style>
