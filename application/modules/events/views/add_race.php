<?php
$server_data = array();
$bird_data = array();
foreach ($bird_list as $key => $value) {
    # code...

    $bird_data["b_id"] = $value->b_id;
    $bird_data["brid_type"] = $value->brid_type;
    array_push($server_data, $bird_data);
}
$bl = json_encode($server_data);

$user_id = $this->session->userdata("user_details")[0]->users_id;
?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
<?php if ($this->session->flashdata("messagePr")) { ?>
	<div class="alert alert-info">
	<?php echo $this->session->flashdata("messagePr") ?>
	</div>
	<?php }?>
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
          </div> </div>
       <div class="col-md-2" ></div>
          <div class="bs-example bs-example12 col-md-8 col-sm-12 col-xs-12"  style="border: 1px solid #e1e1e1;" >
            <div class="box-body">

                <div class="row">
                  <div class="panel-heading">
                  <h4>Race Details</h4>
                </div>

              <form method="POST" action="" name="eventForm" id="eventForm">
                  <p class="error_log" style="color: red; text-align: center"></p>
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <label>Race Name</label>
                      <input type="text" class="form-control" name="event_name" id="event_name">
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label>Organization Name</label>
                        <select id="org_name" class="form-control" name="org_name">
                          <?php if (count($org_list) > 0) { ?>
                            <option value="">Select</option>
                          <?php }
foreach ($org_list as $item) {
     // if($item->Org_code != ""){
    ?>
                          	    <option value="<?php echo $item->users_id; ?>" <?php if ($item->users_id == $user_id) {echo "selected = selected";}?>><?php echo $item->name; ?></option>
                          	<?php //} 
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
                    <label>Race Start Date</label>
                      <input type="text" class="form-control" name="event_sch_date" id="event_sch_date">
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label>Race End Date</label>
                      <input type="text" class="form-control" name="event_end_date" id="event_end_date">
                   </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
              <!--<button type="button"  name="saveBtn" id="saveBtn" class="btn btn-primary saveBtn save_change" >Save</button>-->
              <button type="button" class="btn btn-primary" id="addMoreForm" style="float: right; margin-bottom: 10px;" onclick="add_race();">Add Category</button>

            </div>
            <hr>

                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pic-container"  style="border-top: 1px solid #e1e1e1;">
                    <input type="hidden" value='<?php echo $bl; ?>' id="bird_values">

                 <div class="add_new_race"></div>
                <br><br>
                <div class="panel panel-default race_add" id="race_add">
                <div class="panel-heading">
                  <h4>Category Details</h4>
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
                            <input type="text" class="form-control race_distance" name="bird_distance[]" id="bird_distance" value="" placeholder="Enter The KM">
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                              <label>Bird Category</label>
                            <select class="form-control bird_type" id="select_bird_type" name="select_bird_type[]" onchange="check_val(this);">
                              <option value="">Select Bird Category</option>
<?php
//foreach ($bird_list as $key => $value) {
    ?>
		                                  <!-- <option value="<?php //echo $value->b_id; ?>"><?php //echo $value->brid_type;?></option> -->
	<?php
// }
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
                      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                          <div class="copy-fields after-add-more">
                          <div class="input-group control-group ">
                        <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                <label>Start Date</label>
                             <input type="text" readonly name="start_date10[]" class="form-control start_date dateChangeCat">
                             </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                              <label>Start Time</label>
                             <input type="text" id="onselectstarttime" name="start_time10[]" id="start_time" class="form-control start_time qaw_form_input3">
                            </div>
                            <!-- <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                <label>End Date</label>
                             <input type="text" readonly name="end_date10[]" class="form-control end_date dateChangeCat">
                             </div> -->
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                              <label>End Time</label>
                              <input type="text" id="onselectendtime" name="end_time10[]" class="form-control end_time qaw_form_input3">
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


            <div id="statusdiv" style="color: green;    padding: 10px;"></div>
                <!-- <button type="button"  name="saveBtn" id="saveBtn" class="btn btn-primary saveBtn" >Save</button> -->
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
             <tr>
               <td align="right"><button type="button"  name="saveBtn" id="saveBtn" class="btn btn-primary saveBtn " style="margin-bottom: 10px;" >Save</button></td>
               <td align="left"><input type="button" value="Cancel" class="btn btn-primary cancelBtn" id="cancelBtn" style="margin-bottom: 10px; margin-left: 10px;"/></td>
             </tr>
          </table>
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
<!-- <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="<?php echo base_url().'assets/js/front_controller.js'; ?>"></script>
<script>
function alertmsg(msg)
  {
      toastr.error(msg, 'Lespoton');
  }

function diff(a, b) {
    function toTime(a) {  
        return Date.parse('2020-12-08 ' + a.substr(0,8)) / 1000
             + (a.includes('PM') && (12*60*60));
    }
    var d = toTime(b) - toTime(a);
    return d >= 0 ? new Date(0,0,0,0,0,d).toTimeString().substr(0,8) : '';
}


function datediff(fromDate,toDate,interval) { 
  /*
                 * DateFormat month/day/year hh:mm:ss
                 * ex.
                 * datediff('01/01/2011 12:00:00','01/01/2011 13:30:00','seconds');
                 */
  
  var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7; 
  fromDate = new Date(fromDate); 
  toDate = new Date(toDate); 
  var timediff = toDate - fromDate; 

  if (isNaN(timediff)) return NaN; 
  switch (interval) { 
    case "years": return toDate.getFullYear() - fromDate.getFullYear(); 
    case "months": return ( 
      ( toDate.getFullYear() * 12 + toDate.getMonth() ) 
      - 
      ( fromDate.getFullYear() * 12 + fromDate.getMonth() ) 
    ); 
    case "weeks"  : return Math.floor(timediff / week); 
    case "days"   : return Math.floor(timediff / day);  
    case "hours"  : return Math.floor(timediff / hour);  
    case "minutes": return Math.floor(timediff / minute); 
    case "seconds": return Math.floor(timediff / second); 
    default: return undefined; 
  } 
}

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

function check_val(e) { 
     $('.bird_type').each(function(i, ele){
            if(ele != e && ele.value == e.value){
                   //Throw an error Here <---
                  alertmsg("We must not choose same Bird Category");
                  $("#saveBtn").prop("disabled",true);
                  return false;   
            }else{
                $("#saveBtn").prop("disabled",false);
            }
      })
    }

function check_tag_color(e) { 
     $('.bird_tag_color').each(function(i, ele){
            if(ele != e && ele.value == e.value){
                   //Throw an error Here <---
                  alertmsg("We must not choose same Bird Tag Color");
                  $("#saveBtn").prop("disabled",true);
                  return false;   
            }else{
                $("#saveBtn").prop("disabled",false);
            }
      })
    }

  $("#addMoreForm").click(function(){

    /*Functionality added on 22-01-2022*/
    var race_start_date = $('#event_sch_date').val();
    var race_end_date = $('#event_end_date').val();
    
    if(race_end_date > race_start_date)
    {
      $(".dateChangeCat1").attr("readonly",false);
    }
    else if(race_end_date == race_start_date)
    {
      $(".dateChangeCat1").attr("readonly",true);
    }
    /*Functionality added on 22-01-2022*/

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
            for(var i = 20; i <= 100; i+=10)
            {
              if($("#select_bird_type"+i).text() == "Select Bird Category" && $("#select_bird_tag_color"+i).text() == "Select Bird Tag Color")
              {
                  $("#select_bird_type"+i).find('option').not(':first').remove();
                  $("#select_bird_tag_color"+i).find('option').not(':first').remove();
                   $.each(data, function(key, value) {
                    if(value.b_id != null)
                    {
                        $("#select_bird_type"+i).append('<option value="'+ value.b_id +'">'+ value.brid_type +'</option>');
                    }
                    if(value.ide != null)
                    {
                        $("#select_bird_tag_color"+i).append('<option value="'+ value.sticker_color +'">'+ value.sticker_color +'</option>');
                    }
                  });
              }
              //alert($("#select_bird_type"+i).val());
            }
           }

         });
      }
  });

  $(document).ready(function() {

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
            if($('.bird_type').val() == "" && $('.bird_tag_color').val() == ""){
            $('.bird_type').find('option').not(':first').remove();
            $('.bird_tag_color').find('option').not(':first').remove();
             $.each(data, function(key, value) {
              if(value.b_id != null)
              {
                  $('.bird_type').append('<option value="'+ value.b_id +'">'+ value.brid_type +'</option>');
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

      
     $("#add-more").prop("disabled", true);

     $("#event_sch_date").blur(function () {
       $(".start_date").val($(this).val());
       $(".dateChangeCat1").val($(this).val());
       $("#event_end_date").attr("readonly",false);
     });

     // $('#event_sch_date').datetimepicker({
     //   minDate: new Date(),
     //   format:'D-M-YYYY'

     // });
     $('.start_date').datetimepicker({
       format:'DD-M-YYYY',
       minDate: new Date()
     });

     $("#event_end_date").blur(function () {
       $(".end_date").val($(this).val());
       $(".dateChangeCat1").val($(this).val());
       var race_distance = $(".race_distance").val();
       var bird_type = $(".bird_type").val();
       var bird_tag_color = $(".bird_tag_color").val();
       if(race_distance == "" && bird_type == "" && bird_tag_color == "")
       {
          $("#add-more").prop("disabled", true);
       }else{
          $("#add-more").prop("disabled", false);
       }
     });

     // $('#event_end_date').datetimepicker({
     //   minDate: new Date(),
     //   format:'D-M-YYYY'

     // });

      $('#event_sch_date').datetimepicker({
          useCurrent: true,
          format:'DD-M-YYYY',
          minDate: new Date()
      });

      $('#event_end_date').datetimepicker({
          useCurrent: true,
          format:'DD-M-YYYY',
          minDate: new Date()
          
      });

      $('#event_sch_date').datetimepicker().on('dp.change', function (e) {
          var incrementDay = moment(new Date(e.date));
          incrementDay.add(0, 'days');
          $('#event_end_date').data('DateTimePicker').minDate(incrementDay);
          $(this).data("DateTimePicker").hide();
      });

      $('#event_end_date').datetimepicker().on('dp.change', function (e) {
          var start_date = new Date($('#event_sch_date').val());
          var end_date = new Date($('#event_end_date').val());
          if(end_date <= start_date)
          {
            var decrementDay = moment(new Date(e.date));
            decrementDay.subtract(0, 'days');
            $('#event_end_date').data('DateTimePicker').minDate(decrementDay);
            $(this).data("DateTimePicker").hide();
          }
          // else{
          //   var decrementDay = moment(new Date(e.date));
          //   decrementDay.subtract(0, 'days');
          //   $('#event_end_date').data('DateTimePicker').minDate(decrementDay);
          //    $(this).data("DateTimePicker").hide();
          // }
      });

     $('.end_date').datetimepicker({
       format:'DD-M-YYYY',
       minDate: new Date()
     });



     $('#onselectstarttime').timepicker({
       'timeFormat': 'h:i A',
       'step': 5
     });

     $('#onselectendtime').timepicker({
       'timeFormat': 'h:i A',
       'step': 5
     });

     $('.start_time').on('keypress', function (event) {
        var regex = new RegExp("^[APM0-9: ]+$");
        var start_time = $(this).val();
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
           event.preventDefault();
           return false;
        }
    });

     $('.end_time').on('keypress', function() {
        var regex = new RegExp("^[APM0-9: ]+$");
        var start_time = $(this).val();
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
           event.preventDefault();
           return false;
        }
     });


 //     $('.qaw_form_input3').on('changeTime', function () {
 //     	var start_date = $("input[name='start_date10[]']").val();
 //     	var formattedDate = new Date(start_date);
	// 	var d = formattedDate.getDate();
	// 	var m =  formattedDate.getMonth();
	// 	m += 1;  // JavaScript months are 0-11
	// 	var y = formattedDate.getFullYear();
	// 	var new_date = (d+'/'+m+'/'+y);
 //     	var timestart = $('#onselectstarttime').val();
 //     	var timeStart = new Date(new_date+" "+timestart);
 //     	var timeend = $('#onselectendtime').val();
 //     	var timeEnd = new Date(new_date+" "+timeend);
     	
 //        //alert(datediff(timeStart, timeEnd, 'seconds') % 60);
	// 	var hours = datediff(timeStart, timeEnd, 'hours');
	// 	var minutes = datediff(timeStart, timeEnd, 'minutes') % 60;
	// 	if(timestart != "" && timeend != "")
	// 	{
	// 		var arr = [0,1,2,3,4,5,6,7,8,9];
	// 		for (var i = 0; i <= arr.length; i++) {
	// 			if(hours == arr[i]){
	// 				hours = '0'+hours;
	// 			}

	// 			if(minutes == arr[i]){
	// 				minutes = '0'+minutes;
	// 			}
	// 		}
	// 		$(".time_distance").val(hours+":"+minutes);
	// 	}
	// });


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

     $('#onselectendtime').on('changeTime', function() {
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

       var addhour = moment($('#onselectendtime').val(), "hh:mm").add(1, 'hour');

       $('#onselectendtime').timepicker({
         'timeFormat': 'h:i A',
         'step': 15,
         'defaultTime':addhour,
         'minTime':offsetArr[1]

       });

       // $('#onselectendtime').on('changeTime', function() {
       //   $ ('#onselectstarttime').val ();
       //   var etime = $(this).val();

       //   if(stime != "" && etime != ""){
       //     //alert(Converttimeformat(starttime, endtime));
       //     $(".time_distance").val(Converttimeformat(stime, etime));
       //   }
       // });

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

     $("#org_name").change(function(){
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
              $('.bird_type').find('option').not(':first').remove();
              $('.bird_tag_color').find('option').not(':first').remove();
               $.each(data, function(key, value) {
                if(value.b_id != null)
                {
                    $('.bird_type').append('<option value="'+ value.b_id +'">'+ value.brid_type +'</option>');
                }
                if(value.ide != null)
                {
                    $('.bird_tag_color').append('<option value="'+ value.sticker_color +'">'+ value.sticker_color +'</option>');
                }
                });
             }

           });
        }
     });

     $("#cancelBtn").click(function ( ) {
      var locurl = '<?php echo base_url(); ?>';
      window.location = locurl+'user/races';
     });


     $("#saveBtn").click(function ( ) {

     	var parTag = '.race_add';

	    var rdvalid = true;
      var event_name = $("#event_name").val();
      var org_name = $("#org_name").val();

      if(event_name == '' || event_name == 'NULL' )
      {
        alertmsg("Event name field is empty");
        return false;
      }

      if(org_name == '' || org_name == 'NULL' )
      {
        alertmsg("Organization name is empty");
        return false;
      }

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
	      alertmsg("Select Bird Category");
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
      var locurl = '<?php echo base_url(); ?>';


       //var form_data = $(this).serializeArray();
       // var form_data = $("#eventForm").serializeArray();
       // alert(form_data);
       var org_name = $( "#org_name option:selected" ).val();
       var form_data = $("#eventForm").serialize();
       if(org_name != ""){
         $.ajax({
           type: "POST",
           url:locurl+"events/add_event",
           cache: false,
           data: form_data,
           success: function(data){
             console.log(data);
             // return false;
             if(data == 1){
                $('.error_logs').html('<div class="alert alert-success text-center"role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Race added successfully!</div>');

                  setTimeout(function() {
                      window.location = locurl+'user/races';
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
button#addMoreForm {
    margin-top: 10px;
}


</style>
