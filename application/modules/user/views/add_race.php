<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
<?php if ($this->session->flashdata("messagePr")) {?>
	<div class="alert alert-info">
	<?php echo $this->session->flashdata("messagePr")?>
	</div>
	<?php }?>
<div class="row">
      <div class="col-xs-12">
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
if (isset($_GET['success']) == 1) {
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
<?php
if ($_SESSION["userid"] == 1) {
	$live2 = mysqli_query($ReqObj->con, "SELECT * FROM ppa_oraganization WHERE Org_id != 1");
	?>
	<select id="org_name" class="form-control" name="org_name">
						                     <option value="">Select</option>
	<?php while ($rowl1 = mysqli_fetch_array($live2)) {
		if ($rowl1["Org_code"] != "") {
			?>
																		                               <option value="<?php echo $rowl1["Org_id"];?>"><?php echo $rowl1["Org_code"];
			?></option>
			<?php }
	}?>
	</select>
	<?php
} else {
	$live = mysqli_fetch_array(mysqli_query($ReqObj->con, "SELECT * FROM `ppa_oraganization` WHERE Org_id = '".$_SESSION["userid"]."'"));
	?>
						                         <select id="org_name" class="form-control" name="org_name">
						                    <option value="<?php echo $live["Org_id"];?>"><?php echo $live["Org_code"];
	?></option>
						                  </select>
	<?php
}

?>

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
                    <input type="hidden" value='<?php echo $data;?>' id="bird_values">

                <br><br>
                <div class="panel panel-default" id="formShows">
                <div class="panel-heading"><h4>Add New Category</h4></div>
                  <div class="panel-body">
                  <div class="row">
                      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12" style="padding-left: 10px; padding-bottom: 10px;">
                          <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-left: 0px; padding-bottom: 10px;">
                              <input type="text" class="col-sm-7 form-control1" name="Bird_Type" id="Bird_Type" value="">
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-left: 0px; padding-bottom: 10px;">
                              <input type="text" class="col-sm-7 form-control1" name="Bird_Date" id="Bird_Date" value="">
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-left: 0px; padding-bottom: 10px;">
                              <input type="text" class="col-sm-7 form-control1" name="Bird_start_time" id="Bird_start_time" value="">

                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding-left: 0px; padding-bottom: 10px;">
                              <input type="text" class="col-sm-7 form-control1" name="Bird_end_time" id="Bird_end_time" value="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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
<?php while ($row = mysqli_fetch_array($type)) {
	?>
						                                  <option value="<?php echo $row['b_id'];?>"><?php echo $row['brid_type'];
	?></option>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

      <script type="text/javascript" src="../js/timejs/jquery.timepicker.js"></script>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

      <script src="http://www.datejs.com/build/date.js" type="text/javascript"></script>
      <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" type="text/javascript"></script>-->
      <!--<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>-->
      <!--<script src="../bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>-->

      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>
<script>
function Converttimeformat(start, end) {
  var time = start;
  var hrs = Number(time.match(/^(\d+)/)[1]);
  var mnts = Number(time.match(/:(\d+)/)[1]);
  var format = time.match(/\s(.*)$/)[1];
  if (format == "PM" && hrs < 12) hrs = hrs + 12;
  if (format == "AM" && hrs == 12) hrs = hrs - 12;
  var hours =hrs.toString();
  var minutes = mnts.toString();
  if (hrs < 10) hours = "0" + hours;
  if (mnts < 10) minutes = "0" + minutes;
//alert(hours + ":" + minutes);

  var date1 = new Date();
  date1.setHours(hours );
  date1.setMinutes(minutes);
//alert(date1);

  var time = end;
  var hrs = Number(time.match(/^(\d+)/)[1]);
  var mnts = Number(time.match(/:(\d+)/)[1]);
  var format = time.match(/\s(.*)$/)[1];
  if (format == "PM" && hrs < 12) hrs = hrs + 12;
  if (format == "AM" && hrs == 12) hrs = hrs - 12;
  var hours = hrs.toString();
  var minutes = mnts.toString();
  if (hrs < 10) hours = "0" + hours;
  if (mnts < 10) minutes = "0" + minutes;

//alert(hours+ ":" + minutes);

  var date2 = new Date();
  date2.setHours(hours );
  date2.setMinutes(minutes);

//alert(date2);

  var diff = date2.getTime() - date1.getTime();

   var hours = Math.floor(diff / (1000 * 60 * 60));
   diff -= hours * (1000 * 60 * 60);

   var mins = Math.floor(diff / (1000 * 60));
   diff -= mins * (1000 * 60);

   var hrss = "";
   var minss = "";

  if(Math.abs(hours) >= 10){
    hrss = Math.abs(hours);
  }else{
    hrss = '0'+Math.abs(hours);
  }

  if(Math.abs(mins) >= 10){
    minss = Math.abs(mins);
  }else {
    minss = '0'+Math.abs(mins);
  }
  var time_Diff = hrss+ ':' + minss;

   return time_Diff;
}

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
       //var form_data = $(this).serializeArray();
       // var form_data = $("#eventForm").serializeArray();
       // alert(form_data);
       var org_name = $( "#org_name option:selected" ).val();
       var form_data = $("#eventForm").serialize();
       if(org_name != ""){
         $.ajax({
           type: "post",
           url:"../controller/User.php?action=add_event",
           cache: false,
           data: form_data,
           success: function(data){
             // console.log(data);
             // return false;
             if(data == '1'){
               window.location = 'events.php?success=1';
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
function add_more () {

  //var html = $(".copy-fields"+id).html();
  var id = $("#bird_id_val").val();
  var rowno = $('.copy-fields').length;
  rowno=rowno+10;

  var lastChangeCatDate = $(".dateChangeCat").last().val();

  //var data_id = rowno;
  var html = '<div class="copy-fields '+rowno+'"><div class="control-group input-group" style="margin-top:10px"><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><input type="text" name="start_date'+rowno+'[]" class="form-control start_date'+rowno+' dateChangeCat"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><input type="text" name="start_time'+rowno+'[]" class="form-control start_time'+rowno+'"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><input type="text" name="end_time'+rowno+'[]" class="form-control end_time'+rowno+'"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 "><input type="text" readonly name="time_distance'+rowno+'[]" class="form-control time_distance'+rowno+'" style="width: 60%;"><div class="input-group-btn" style="float: right;margin-right: 37px;"><button class="btn button_remove form-control remove" type="button" onclick="remove('+rowno+');"><i class="glyphicon glyphicon-remove"></i></button></div></div></div></div>  ';

  //$(".after-add-more"+id).after(html);
  $(".add_row").append(html);
  //console.log("================================ >>>> ", getAdjustedDate(lastChangeCatDate));
  var con_date = getAdjustedDate(lastChangeCatDate);
  var max_date = new Date(con_date);
  var last_date = max_date.setDate(max_date.getDate() + 1);

  $('.start_date'+rowno).datetimepicker({
    format:'D-M-YYYY',
    minDate : new Date(last_date),
    maxDate: new Date(last_date)
  });


  $('.start_time'+rowno).timepicker({
    'timeFormat': 'h:i A',
    'step': 10
  });
  $('.start_time'+rowno).on('changeTime', function() {
    $ ('.end_time'+rowno).val ();
    var stime = $(this).val();
    var etime = $('.end_time'+rowno).val();
    var date = $("input[name='start_date"+rowno+"[]']").val();
    var dateArr = date.split("-");
    var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr["0"];
    var cons_datTime = newDate + " " + stime;
    var now = new Date(cons_datTime);
    now.setHours(now.getHours() + 1);
    var offset = now.toLocaleString();
    var offsetArr = offset.split(" ");

    var addhour = moment($('.start_time'+rowno).val(), "hh:mm").add(1, 'hour');

    $('.end_time'+rowno).timepicker({
      'timeFormat': 'h:i A',
      'step': 15,
      'defaultTime':addhour,
      'minTime':offsetArr[1]

    });

    $('.end_time'+rowno).on('changeTime', function() {
      $ ('.start_time'+rowno).val ();
      var etime = $(this).val();

      if(stime != "" && etime != ""){
        //alert(Converttimeformat(starttime, endtime));
        $(".time_distance"+rowno).val(Converttimeformat(stime, etime));
      }
    });

    $ ( '.end_time'+rowno ).timepicker ( "option", "minTime", offsetArr[1], "defaultTime", addhour);

    if(stime != "" && etime != ""){
      //alert(Converttimeformat(starttime, endtime));
      $(".time_distance"+rowno).val(Converttimeformat(stime, etime));
    }

  });

  // $('.start_time'+rowno).timepicker({
  //
  //  timeFormat: 'h:mm p',
  //  interval: 15, // 15 minutes
  //
  //  change: function(time) {
  //    // the input field
  //    $ ( ".end_time" ).val ();
  //    var element = $(this), text;
  //    // get access to this Timepicker instance
  //    var timepicker = element.timepicker();
  //    text = 'Selected time is: ' + timepicker.format(time);
  //    element.siblings('span.help-line').text(text);
  //    var starttime = $(this).val();
  //    //var times = convertTimeFrom12To24(starttime);
  //    // Gets the current time
  //    var date = $("input[name='start_date"+rowno+"[]']").val();
  //    var dateArr = date.split("-");
  //    var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr["0"];
  //    var cons_datTime = newDate + " " + starttime;
  //    var now = new Date(cons_datTime);
  //
  //
  //
  //    now.setHours(now.getHours() + 1);
  //    // console.log("actual time + 1 hour:", now);
  //    var offset = now.toLocaleString();
  //    var offsetArr = offset.split(" ");
  //
  //    $('.end_time'+rowno).timepicker({
  //      timeFormat: 'h:mm p',
  //      minTime: offsetArr[1],
  //      // startTime:offsetArr[1],
  //      interval: 15,
  //      dynamic: true,
  //      change: function(time) {
  //        // the input field
  //        var element = $ ( this ), text;
  //        // get access to this Timepicker instance
  //        var timepicker = element.timepicker ();
  //        text = 'Selected time is: ' + timepicker.format ( time );
  //        element.siblings ( 'span.help-line' ).text ( text );
  //        var end_time = $ ( this ).val ();
  //        var start_time =  $("input[name='start_time"+rowno+"[]']").val();
  //        console.log(start_time+end_time);
  //        // console.log(Converttimeformat(starttime, end_time));
  //        if(start_time != "" && end_time != ""){
  //          $(".time_distance"+rowno).val(Converttimeformat(start_time, end_time));
  //        }
  //      }
  //
  //    });
  //    $ ( '.end_time'+rowno ).timepicker ( "option", "minTime", offsetArr[1]);
  //
  //    var end_time =  $("input[name='end_time"+rowno+"[]']").val();
  //    console.log(starttime+end_time);
  //    if(starttime != "" && end_time != ""){
  //      $(".time_distance"+rowno).val(Converttimeformat(starttime, end_time));
  //    }
  //
  //  }
  //
  // });

  // $('.start_time'+rowno).blur(function () {
  //  var starttime = $(this).val();
  //  var con_time = convertTimeFrom12To24(starttime);
  //  var valNew = con_time.split(':');
  //  $('.end_time'+rowno).datetimepicker({
  //    format: 'hh:mm A',
  //    minDate: moment({h:valNew[0],m:valNew[1]})
  //  });
  //
  // });
  //
  // $('.start_time'+rowno).datetimepicker({
  //  format: 'hh:mm A'
  // });
  //
  // var start_time = end_time = "";
  //
  // $(document).on("blur", "input[name='start_time"+rowno+"[]']", function(){
  //  start_time =  $(this).val();
  //  if(start_time != "" && end_time != ""){
  //    $(".time_distance"+rowno).val(Converttimeformat(start_time, end_time));
  //  }
  // });
  //
  // $(document).on("blur", "input[name='end_time"+rowno+"[]']", function(){
  //  end_time =  $(this).val();
  //  if(start_time != "" && end_time != ""){
  //    $(".time_distance"+rowno).val(Converttimeformat(start_time, end_time));
  //  }
  // });

}
function remove (no ) {
  //$(this).parents(".control-group"+id).remove();
  $('.'+no).remove();
}

function bird_type_checked( id ) {
  $("input:checkbox[id=brid_type"+id+"]:checked").each(function () {
    var bird_val = $(this).val();
    if(bird_val != ""){
      $(".add-more"+id).prop("disabled", false);
    }
    else{
      $(".add-more"+id).prop("disabled", true);
    }
  });
  //var chkArray = [];
  /* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
  //$("#brid_type"+id+" input:checked").each(function() {
  //chkArray.push($(this).val());
  //});

}
</script>
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
