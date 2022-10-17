// $(function () {
// 	alert("sadfsd");
// })
//var locurl = getAbsolutePath()+'/twilight/';


var locurl = getAbsolutePath()+'/lespoton/';
$(window).load(function() {
	$(".loader").delay(2000).fadeOut("slow");
});

$("form#login_form").submit(function(event) {

	event.preventDefault ();

	var email = $("#email").val();
	var pwd = $("#password").val();
	if(email != "" && pwd != ""){
		$.post( "../controller/User.php?action=login", { email: email, pwd: pwd }, function( data ) {
			// console.log( data.name ); // John
			// console.log( data.time ); // 2pm
			console.log(data);
			if($.trim(data) == 1)
			{
				window.location = "dashboard.php";
			}
			else {
				$("p.error").html("<div class=\"alert alert-danger\">Username and Password Incorrect!!!</div>");
			}

		});
	}
	else {
		$("p.error").html("<div class=\"alert alert-danger\">Please Enter Username and Password</div>");
	}
});

$("form#register-form").submit(function(event) {
	event.preventDefault ();
	var Orgname = $('#org_name').val();
	var Adname = $('#ad_name').val();
	var Adpwd = $('#ad_pwd').val();
	var file = $('#Org_logo').val();
	var file_name = $('#Org_logo')[0].files[0];
	//var org_logo = file_name.name;

	if(Orgname == ""){

		$("p.error").html("<div class=\"alert alert-danger\">Please enter Organization Name.</div>");
	}
	else if(Adname == ""){
		$("p.error").html("<div class=\"alert alert-danger\">Please enter User Name.</div>");
	}
	else if(Adpwd == ""){
		$("p.error").html("<div class=\"alert alert-danger\">Please enter Password.</div>");
	}
	else if(file == ""){
		$("p.error").html("<div class=\"alert alert-danger\">Please Upload Logo.</div>");
	}
	else if(Orgname != "" && Adname != "" && Adpwd != "" && file != ""){

		var formData = new FormData ( $ ( this )[ 0 ] );

		$.ajax ( {

			url: '../controller/User.php?action=signup',

			type: 'POST',

			data: formData,

			async: false,

			cache: false,

			contentType: false,

			processData: false,

			success: function ( returndata ) {
				console.log(returndata);
				if($.trim(returndata) == 1)
				{
					window.location = "login.php?res=1";
				}
				else{
					$("p.error").html("<div class=\"alert alert-danger\">Already registered !!!.</div>");
				}
			}

		} );
	}

});

function convertTimeFrom12To24(timeStr) {
	var colon = timeStr.indexOf(':');
	var hours = timeStr.substr(0, colon),
		minutes = timeStr.substr(colon+1, 2),
		meridian = timeStr.substr(colon+4, 2).toUpperCase();


	var hoursInt = parseInt(hours, 10) + 1,
		offset = meridian == 'PM' ? 12 : 0;


	if (hoursInt === 12) {
		hoursInt = offset;
	} else {
		hoursInt += offset;
	}

	return hoursInt + ":" + minutes;
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
$(document).ready(function(){
	$('#register-form').keypress(function(e){
		if(e.which == 13){//Enter key pressed
			$('form#register-form').click();//Trigger search button click event
		}
	});

// });

// $(document).ready(function(){
	$('#signin').keyup(function(e) {
		if(e.keyCode == 13){
			$('form#login_form').click()
		}

	});


	// $("input[name='start_time[]']").blur(function () {
	// 	start_time =  $(this).val();
	// 	if(start_time != "" && end_time != ""){
	// 		$(".time_distance").val(Converttimeformat(start_time, end_time)+" Hours");
	// 	}
	//
	// });
	//
	// $("input[name='end_time[]']").blur(function () {
	// 	end_time =  $(this).val();
	// 	if(start_time != "" && end_time != ""){
	//
	// 		$(".time_distance").val(Converttimeformat(start_time, end_time)+" Hours");
	// 	}
	// });

});

function getAdjustedDate(adjustment) {

	var dates1 = adjustment.split("-");
	var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
	var cha_dat = new Date(newDate).getTime()
	var d = new Date(cha_dat);
	//var n = d.toISOString();
	var curr_date = d.getDate();
	var curr_month = d.getMonth()+1;
	var curr_year = d.getFullYear();
	if(curr_date < 10){
		curr_date = "0"+curr_date;
	}
	if( curr_month<10){
		curr_month = "0"+curr_month;
	}
	var res_date = curr_year+'-'+curr_month+'-'+curr_date;
	return res_date;
};

function add_race () {
	
	var row_no = $('#bird_values').val();
	var curr_date = $('#event_sch_date').val();
	var servers = $.parseJSON(row_no);
	var rowno = $('.race_add').length+1;
	rowno=rowno * 10;
	var select = '<select class="form-control" id="select_bird_type'+rowno+'" name="select_bird_type[]"><option value="">Select Bird Type</option>';
	$.each(servers, function(index, items) {
		select +='<option value="' + items.b_id + '">' + items.brid_type + '</option>';
	});
	select +='</select>';

	var add_race = '<div class="panel panel-default race_add" id="race_add'+rowno+'">' +
		'<div class="panel-heading"><h4>Add New Category</h4>' +
		'<button class="btn btn-danger pull-right remove'+rowno+'" type="button" style="margin-top: -50px;margin-right: -15px;">' +
		'<i class="glyphicon glyphicon-remove"></i>' +
		'</button>' +
		'</div>' +
		'<div class="panel-body">' +
		'<div class="row">' +
		'<input type="hidden" id="bird_id_val'+rowno+'">' +
		'<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">' +
		'<div class="row">' +
		'<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">' +
		'<div class="col-md-10 col-lg-10 col-sm-10 col-xs-10">' +
		'</div>' +
		'<div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 " style="text-align: right;">' +
		'<button class="btn form-control button_plus" id="add_more'+rowno+'" type="button" onclick="add_more_race('+rowno+');">' +
		'<i class="glyphicon glyphicon-plus"></i>' +
		'</button>' +
		'</div>' +
		'</div>' +
		'<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">' +
		'<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">' +
		'<label>Race Distance (KM)</label>' +
		'<input type="text" class="form-control" name="bird_distance[]" id="bird_distance'+rowno+'" value="" placeholder="Enter The KM">' +
		'</div>' +
		'<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">' +
		'<label>Bird Type</label>'+select+'' +
		'</div>' +
		'</div>	' +
		'</div>' +
		'</div>' +
		'<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"> ' +
		'<div class="row">' +
		'<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">' +
		'<div class="copy-fields'+rowno+' after-add-more'+rowno+'">' +
		'<div class="input-group control-group ">' +
		'<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">' +
		'<label>Date</label>' +
		'<input type="text" name="start_date'+rowno+'[]" readonly class="form-control start_date'+rowno+' dateChangeCat1">' +
		'</div>' +
		'<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><label>Start Time</label><input type="text" name="start_time'+rowno+'[]" class="form-control start_time'+rowno+'"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><label>End Time</label><input type="text" name="end_time'+rowno+'[]" class="form-control end_time'+rowno+'"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">	<label>Boarding Time</label><input type="text" readonly name="time_distance'+rowno+'[]" class="form-control time_distance'+rowno+'" ></div></div></div>' +
		'<div class="add_row'+rowno+'"></div></div></div></div></div>'+
		'<script type="text/javascript"> var curr_date1 = $(\'#event_sch_date\').val();var chgdate1 = getAdjustedDate(curr_date1); console.log(chgdate1);$(".start_date'+rowno+'").datetimepicker({ format:"D-M-YYYY", minDate:new Date(chgdate1)}); </script> ';

	$(".add_new_race").append(add_race);

	$("#add_more"+rowno).prop("disabled", true);

	$("#select_bird_type"+rowno).change(function () {
		$("#bird_id_val"+rowno).val($(this).val());
		var id = $(this).val();
		if(id != ''){
			$("#add_more"+rowno).prop("disabled", false);
		}
		else {
			$("#add_more"+rowno).prop("disabled", true);
		}
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
	// 	timeFormat: 'h:mm p',
	// 	interval: 15, // 15 minutes
	//
	// 	change: function(time) {
	// 		// the input field
	// 		$ ( ".end_time" ).val ();
	// 		var element = $(this), text;
	// 		// get access to this Timepicker instance
	// 		var timepicker = element.timepicker();
	// 		text = 'Selected time is: ' + timepicker.format(time);
	// 		element.siblings('span.help-line').text(text);
	// 		var starttime = $(this).val();
	// 		//var times = convertTimeFrom12To24(starttime);
	// 		// Gets the current time
	// 		var date = $("input[name='start_date"+rowno+"[]']").val();
	// 		var dateArr = date.split("-");
	// 		var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr["0"];
	// 		var cons_datTime = newDate + " " + starttime;
	// 		var now = new Date(cons_datTime);
	//
	//
	//
	// 		now.setHours(now.getHours() + 1);
	// 		// console.log("actual time + 1 hour:", now);
	// 		var offset = now.toLocaleString();
	// 		var offsetArr = offset.split(" ");
	//
	// 		$('.end_time'+rowno).timepicker({
	// 			timeFormat: 'h:mm p',
	// 			minTime: offsetArr[1],
	// 			// startTime:offsetArr[1],
	// 			interval: 15,
	// 			dynamic: true,
	// 			change: function(time) {
	// 				// the input field
	// 				var element = $ ( this ), text;
	// 				// get access to this Timepicker instance
	// 				var timepicker = element.timepicker ();
	// 				text = 'Selected time is: ' + timepicker.format ( time );
	// 				element.siblings ( 'span.help-line' ).text ( text );
	// 				var end_time = $ ( this ).val ();
	// 				var start_time =  $("input[name='start_time"+rowno+"[]']").val();
	// 				console.log(start_time+end_time);
	// 				// console.log(Converttimeformat(starttime, end_time));
	// 				if(start_time != "" && end_time != ""){
	// 					$(".time_distance"+rowno).val(Converttimeformat(start_time, end_time));
	// 				}
	// 			}
	//
	// 		});
	// 		$ ( '.end_time'+rowno ).timepicker ( "option", "minTime", offsetArr[1]);
	//
	// 		var end_time =  $("input[name='end_time"+rowno+"[]']").val();
	// 		console.log(starttime+end_time);
	// 		if(starttime != "" && end_time != ""){
	// 			$(".time_distance"+rowno).val(Converttimeformat(starttime, end_time));
	// 		}
	//
	// 	}
	//
	// });

	// $('.start_date'+rowno).datetimepicker({
	// 	format:'D-M-YYYY',
	// 	minDate: new Date("2018-2-10")
	// });

	// $('.start_time'+rowno).blur(function () {
	// 	var starttime = $(this).val();
	// 	var con_time = convertTimeFrom12To24(starttime);
	// 	var valNew = con_time.split(':');
	// 	$('.end_time'+rowno).datetimepicker({
	// 		format: 'hh:mm A',
	// 		minDate: moment({h:valNew[0],m:valNew[1]})
	// 	});
	//
	// });
	//
	// $('.start_time'+rowno).datetimepicker({
	// 	format: 'hh:mm A'
	// });
	//
	// var start_time = end_time = "";
	//
	// $(document).on("blur", "input[name='start_time"+rowno+"[]']", function(){
	// 	// var values = $(this).map(function(){return $(this).val();}).get();
	// 	start_time =  $(this).val();
	// 	if(start_time != "" && end_time != ""){
	// 		$(".time_distance"+rowno).val(Converttimeformat(start_time, end_time));
	// 	}
	// });
	//
	// $(document).on("blur", "input[name='end_time"+rowno+"[]']", function(){
	// 	// var values = $(this).map(function(){return $(this).val();}).get();
	// 	end_time =  $(this).val();
	// 	if(start_time != "" && end_time != ""){
	// 		$(".time_distance"+rowno).val(Converttimeformat(start_time, end_time));
	// 	}
	// });

	$("#select_bird_type"+rowno).change(function () {

		var id = $("#bird_id_val"+rowno).val($(this).val());
		if(id != ''){
			$(".add-more").prop("disabled", false);
		}
		else {
			$(".add-more").prop("disabled", true);
		}
	});
	$('.remove'+rowno).on('click',function(){
		$("#race_add"+rowno).remove();
	});
}


function add_more_race (id) {
	//var html = $(".copy-fields"+id).html();

	var rowno = $('.copy-fields'+id).length;
	rowno = id+rowno;

	//var id = $("#bird_id_val"+rowno).val();
	var lastChangeCatDate = $(".dateChangeCat1").last().val();
	//var data_id = rowno;
	var html = '<div class="copy-fields'+id+'" id="copy-fields'+id+rowno+'"><div class="control-group input-group" style="margin-top:10px"><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><input type="text" name="start_date'+rowno+'[]" class="form-control start_date'+id+rowno+' dateChangeCat1"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 "><input type="text" name="start_time'+rowno+'[]" class="form-control start_time'+id+rowno+'"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><input type="text" name="end_time'+rowno+'[]" class="form-control end_time'+id+rowno+'"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><input type="text" readonly name="time_distance'+rowno+'[]" class="form-control time_distance'+id+rowno+'" style="width: 60%;"><div class="input-group-btn" style="float: right;margin-right: 37px;"><button class="btn button_remove form-control remove'+id+rowno+'" type="button"><i class="glyphicon glyphicon-remove"></i></button></div></div></div></div>';


	$(".add_row"+id).append(html);

	var con_date = getAdjustedDate(lastChangeCatDate);
	var max_date = new Date(con_date);
	var last_date = max_date.setDate(max_date.getDate() + 1);

	$('.start_date'+id+rowno).datetimepicker({
		format:'D-M-YYYY',
		minDate : new Date(last_date),
		maxDate: new Date(last_date)
	});

	// var con_date = getAdjustedDate(lastChangeCatDate);
	//
	// $('.start_date'+id+rowno).datetimepicker({
	// 	format:'D-M-YYYY',
	// 	minDate : new Date(con_date),
	// 	maxDate : new Date(con_date)
	// });


	$('.start_time'+id+rowno).timepicker({
		'timeFormat': 'h:i A',
		'step': 10
	});

	$('.start_time'+id+rowno).on('changeTime', function() {
		$ ('.end_time'+id+rowno).val ();
		var stime = $(this).val();
		var etime = $('.end_time'+id+rowno).val();
		var date = $("input[name='start_date"+rowno+"[]']").val();
		var dateArr = date.split("-");
		var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr["0"];
		var cons_datTime = newDate + " " + stime;
		var now = new Date(cons_datTime);
		now.setHours(now.getHours() + 1);
		var offset = now.toLocaleString();
		var offsetArr = offset.split(" ");

		var addhour = moment($('.start_time'+id+rowno).val(), "hh:mm").add(1, 'hour');

		$('.end_time'+id+rowno).timepicker({
			'timeFormat': 'h:i A',
			'step': 15,
			'defaultTime':addhour,
			'minTime':offsetArr[1]

		});

		$('.end_time'+id+rowno).on('changeTime', function() {
			$ ('.start_time'+id+rowno).val ();
			var etime = $(this).val();

			if(stime != "" && etime != ""){
				//alert(Converttimeformat(starttime, endtime));
				$(".time_distance"+id+rowno).val(Converttimeformat(stime, etime));
			}
		});

		$ ( '.end_time'+id+rowno ).timepicker ( "option", "minTime", offsetArr[1], "defaultTime", addhour);

		if(stime != "" && etime != ""){
			//alert(Converttimeformat(starttime, endtime));
			$(".time_distance"+id+rowno).val(Converttimeformat(stime, etime));
		}

	});

	// $('.start_time'+id+rowno).timepicker({
	//
	// 	timeFormat: 'h:mm p',
	// 	interval: 15, // 15 minutes
	//
	// 	change: function(time) {
	// 		// the input field
	// 		$ ( ".end_time" ).val ();
	// 		var element = $(this), text;
	// 		// get access to this Timepicker instance
	// 		var timepicker = element.timepicker();
	// 		text = 'Selected time is: ' + timepicker.format(time);
	// 		element.siblings('span.help-line').text(text);
	// 		var starttime = $(this).val();
	// 		//var times = convertTimeFrom12To24(starttime);
	// 		// Gets the current time
	// 		var date = $("input[name='start_date"+rowno+"[]']").val();
	// 		var dateArr = date.split("-");
	// 		var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr["0"];
	// 		var cons_datTime = newDate + " " + starttime;
	// 		var now = new Date(cons_datTime);
	//
	//
	//
	// 		now.setHours(now.getHours() + 1);
	// 		// console.log("actual time + 1 hour:", now);
	// 		var offset = now.toLocaleString();
	// 		var offsetArr = offset.split(" ");
	//
	// 		$('.end_time'+id+rowno).timepicker({
	// 			timeFormat: 'h:mm p',
	// 			minTime: offsetArr[1],
	// 			// startTime:offsetArr[1],
	// 			interval: 15,
	// 			dynamic: true,
	// 			change: function(time) {
	// 				// the input field
	// 				var element = $ ( this ), text;
	// 				// get access to this Timepicker instance
	// 				var timepicker = element.timepicker ();
	// 				text = 'Selected time is: ' + timepicker.format ( time );
	// 				element.siblings ( 'span.help-line' ).text ( text );
	// 				var end_time = $ ( this ).val ();
	// 				var start_time =  $("input[name='start_time"+rowno+"[]']").val();
	// 				//console.log(start_time+end_time);
	// 				// console.log(Converttimeformat(starttime, end_time));
	// 				if(start_time != "" && end_time != ""){
	// 					$(".time_distance"+id+rowno).val(Converttimeformat(start_time, end_time));
	// 				}
	// 			}
	//
	// 		});
	// 		$ ( '.end_time'+id+rowno ).timepicker ( "option", "minTime", offsetArr[1]);
	//
	// 		var end_time =  $("input[name='end_time"+rowno+"[]']").val();
	// 		console.log(starttime+end_time);
	// 		if(starttime != "" && end_time != ""){
	// 			$(".time_distance"+id+rowno).val(Converttimeformat(starttime, end_time));
	// 		}
	//
	// 	}
	//
	// });

	// $('.start_time'+id+rowno).blur(function () {
	// 	var starttime = $(this).val();
	// 	var con_time = convertTimeFrom12To24(starttime);
	// 	var valNew = con_time.split(':');
	// 	$('.end_time'+id+rowno).datetimepicker({
	// 		format: 'hh:mm A',
	// 		minDate: moment({h:valNew[0],m:valNew[1]})
	// 	});
	//
	// });
	//
	// $('.start_time'+id+rowno).datetimepicker({
	// 	format: 'hh:mm A'
	// });
	//
	// // $('.start_time'+id+rowno+',.end_time'+id+rowno).datetimepicker({
	// // 	format: 'hh:mm A'
	// // });
	//
	// var start_time = end_time = "";
	//
	// $(document).on("blur", "input[name='start_time"+rowno+"[]']", function(){
	// 	// var values = $(this).map(function(){return $(this).val();}).get();
	// 	start_time =  $(this).val();
	// 	if(start_time != "" && end_time != ""){
	// 		$(".time_distance"+id+rowno).val(Converttimeformat(start_time, end_time));
	// 	}
	// });
	//
	// $(document).on("blur", "input[name='end_time"+rowno+"[]']", function(){
	// 	// var values = $(this).map(function(){return $(this).val();}).get();
	// 	end_time =  $(this).val();
	// 	if(start_time != "" && end_time != ""){
	// 		$(".time_distance"+id+rowno).val(Converttimeformat(start_time, end_time));
	// 	}
	// });

	$('.remove'+id+rowno).on('click',function(){
		$("#copy-fields"+id+rowno).remove();
	});
}

// function  remove_race_date(nos) {
// 	$('#'+nos).remove();
// }
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

function add_more () {

	//var html = $(".copy-fields"+id).html();
	var id = $("#bird_id_val").val();
	var rowno = $('.copy-fields').length;
	rowno=rowno+10;

	var lastChangeCatDate = $(".dateChangeCat").last().val();

	//var data_id = rowno;
	var html = '<div class="copy-fields '+rowno+'"><div class="control-group input-group" style="margin-top:10px"><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><input type="text" name="start_date'+rowno+'[]" class="form-control start_date'+rowno+' dateChangeCat"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><input type="text" name="start_time'+rowno+'[]" class="form-control start_time'+rowno+'"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><input type="text" name="end_time'+rowno+'[]" class="form-control end_time'+rowno+'"></div><div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 "><input type="text" readonly name="time_distance'+rowno+'[]" class="form-control time_distance'+rowno+'" style="width: 60%;"><div class="input-group-btn" style="float: right;margin-right: 37px;"><button class="btn button_remove form-control remove" type="button" onclick="remove('+rowno+');"><i class="glyphicon glyphicon-remove"></i></button></div></div></div></div>	';

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
	// 	timeFormat: 'h:mm p',
	// 	interval: 15, // 15 minutes
	//
	// 	change: function(time) {
	// 		// the input field
	// 		$ ( ".end_time" ).val ();
	// 		var element = $(this), text;
	// 		// get access to this Timepicker instance
	// 		var timepicker = element.timepicker();
	// 		text = 'Selected time is: ' + timepicker.format(time);
	// 		element.siblings('span.help-line').text(text);
	// 		var starttime = $(this).val();
	// 		//var times = convertTimeFrom12To24(starttime);
	// 		// Gets the current time
	// 		var date = $("input[name='start_date"+rowno+"[]']").val();
	// 		var dateArr = date.split("-");
	// 		var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr["0"];
	// 		var cons_datTime = newDate + " " + starttime;
	// 		var now = new Date(cons_datTime);
	//
	//
	//
	// 		now.setHours(now.getHours() + 1);
	// 		// console.log("actual time + 1 hour:", now);
	// 		var offset = now.toLocaleString();
	// 		var offsetArr = offset.split(" ");
	//
	// 		$('.end_time'+rowno).timepicker({
	// 			timeFormat: 'h:mm p',
	// 			minTime: offsetArr[1],
	// 			// startTime:offsetArr[1],
	// 			interval: 15,
	// 			dynamic: true,
	// 			change: function(time) {
	// 				// the input field
	// 				var element = $ ( this ), text;
	// 				// get access to this Timepicker instance
	// 				var timepicker = element.timepicker ();
	// 				text = 'Selected time is: ' + timepicker.format ( time );
	// 				element.siblings ( 'span.help-line' ).text ( text );
	// 				var end_time = $ ( this ).val ();
	// 				var start_time =  $("input[name='start_time"+rowno+"[]']").val();
	// 				console.log(start_time+end_time);
	// 				// console.log(Converttimeformat(starttime, end_time));
	// 				if(start_time != "" && end_time != ""){
	// 					$(".time_distance"+rowno).val(Converttimeformat(start_time, end_time));
	// 				}
	// 			}
	//
	// 		});
	// 		$ ( '.end_time'+rowno ).timepicker ( "option", "minTime", offsetArr[1]);
	//
	// 		var end_time =  $("input[name='end_time"+rowno+"[]']").val();
	// 		console.log(starttime+end_time);
	// 		if(starttime != "" && end_time != ""){
	// 			$(".time_distance"+rowno).val(Converttimeformat(starttime, end_time));
	// 		}
	//
	// 	}
	//
	// });

	// $('.start_time'+rowno).blur(function () {
	// 	var starttime = $(this).val();
	// 	var con_time = convertTimeFrom12To24(starttime);
	// 	var valNew = con_time.split(':');
	// 	$('.end_time'+rowno).datetimepicker({
	// 		format: 'hh:mm A',
	// 		minDate: moment({h:valNew[0],m:valNew[1]})
	// 	});
	//
	// });
	//
	// $('.start_time'+rowno).datetimepicker({
	// 	format: 'hh:mm A'
	// });
	//
	// var start_time = end_time = "";
	//
	// $(document).on("blur", "input[name='start_time"+rowno+"[]']", function(){
	// 	start_time =  $(this).val();
	// 	if(start_time != "" && end_time != ""){
	// 		$(".time_distance"+rowno).val(Converttimeformat(start_time, end_time));
	// 	}
	// });
	//
	// $(document).on("blur", "input[name='end_time"+rowno+"[]']", function(){
	// 	end_time =  $(this).val();
	// 	if(start_time != "" && end_time != ""){
	// 		$(".time_distance"+rowno).val(Converttimeformat(start_time, end_time));
	// 	}
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
function generate_code(){
	var len = $("#no_of_code").val();
	var org = $("#org_code option:selected").val();
	var org_code = $("#org_code option:selected").text();
	if(org == ""){
		$("#org_code").css("border", "2px dotted red");
	}
	else if(len == ""){
		$("#no_of_code").css("border", "2px dotted red");
	}
	else{
		$.post( "../controller/User.php?action=generate_code", { len: len, org: org, org_code: org_code }, function( data ) {
			location.reload();
		});
	}

}

// function view_details ( id ) {
// 	if(id!= ""){
// 		//$('#viewModal').modal('show');
// 		window.location = "viewevent.php?id="+id;
// 		// $.post( "../controller/User.php?action=view_details", {id: id}, function( data ) {
// 		// 	$("#event_det").html(data);
// 			// var obj = jQuery.parseJSON(data);
// 			// $("#view_date").val();
// 			// $("#view_latitude").val();
// 			// $("#view_name").val();
// 			// $("#view_longitude").val();
// 			// $("#Bird_Type").val();
// 			// $("#view_date").val();
// 			// $("#view_date").val();
// 			// console.log(obj.event_name);
// 		});
// 	}
// }

// function add_new_cate(eid) {
// 	$("#CateShows").toggle(1000);
// }

function main_event_edit(ids)
{
	$('#view_date'+ids).datetimepicker({
		format:'D-M-YYYY'
	});

	$("#main_ev_edit").css("display", "none");
	$("#main_ev_update").css("display", "block");
	$("#main_ev_update").prop('disabled',false);
	$("#view_date"+ids).removeAttr("disabled");
	$("#view_latitude"+ids).removeAttr("disabled");
	$("#view_name"+ids).removeAttr("disabled");
	$("#view_longitude"+ids).removeAttr("disabled");

}
function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf(' ') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}

function main_event_update ( event_id ) {
	$("#main_ev_update").prop('disabled',true);
	var event_name = $("#view_name"+event_id).val();
	var event_sche_date = $("#view_date"+event_id).val();
	var event_lat = $("#view_latitude"+event_id).val();
	var event_long = $("#view_longitude"+event_id).val();
	
	$.ajax({
		type: "POST",
		url:locurl+"races/update_main_event",
		cache: false,
		data: {'event_id':event_id,'event_name':event_name,'event_sche_date':event_sche_date,'event_lat':event_lat,'event_long':event_long},
		success: function(data){
			// console.log(data);
			// return false;

			if(data == 1){
				$("p#loder"+event_id).html("Processing");
				setTimeout(function(){
					$("p#loder"+event_id).css("display", "none");
					$("#main_ev_update").prop('disabled',false);
					// $("#main_ev_update").css("display", "none");
					// $("#main_ev_edit").css("display", "block");
					// $("#view_date"+event_id).attr('disabled', 'disabled');
					// $("#view_latitude"+event_id).attr('disabled', 'disabled');
					// $("#view_name"+event_id).attr('disabled', 'disabled');
					// $("#view_longitude"+event_id).attr('disabled', 'disabled');
					$("p#status_re"+event_id).css("display", "block");
					$("p#status_re"+event_id).fadeOut(3000);
					//$('#viewModal').delay(1500).fadeOut(3000);
				}, 500);
			}
			
		}
	});
}
function event_edit ( event_id, details_id ) {
	if(details_id != "" && event_id != ""){

		$('#Bird_Date'+details_id).datetimepicker({
			format:'D-M-YYYY'
		});

		// $('#Bird_start_time'+details_id+',#Bird_end_time'+details_id).datetimepicker({
		// 	format: 'hh:mm A'
		// });
		// $('.end_time'+rowno).timepicker({
		// 	'timeFormat': 'h:i A',
		// 	'step': 15,
		// 	'defaultTime':addhour,
		// 	'minTime':offsetArr[1]
		//
		// });
		// $('#Bird_start_time'+details_id).timepicker({
		//
		// 	'timeFormat': 'h:i A',
		// 	'interval': 10, // 15 minutes
		//
		// 	change: function(time) {
		// 		// the input field
		// 		$ ('#Bird_end_time'+details_id  ).val ();
		// 		var element = $(this), text;
		// 		// get access to this Timepicker instance
		// 		var timepicker = element.timepicker();
		// 		text = 'Selected time is: ' + timepicker.format(time);
		// 		element.siblings('span.help-line').text(text);
		// 		var starttime = $(this).val();
		// 		//var times = convertTimeFrom12To24(starttime);
		// 		// Gets the current time
		// 		var date = $("#Bird_Date"+details_id).val();
		//
		// 		var dateArr = date.split("-");
		// 		var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr["0"];
		// 		var cons_datTime = newDate + " " + starttime;
		// 		var now = new Date(cons_datTime);
		//
		// 		now.setHours(now.getHours() + 1);
		// 		// console.log("actual time + 1 hour:", now);
		// 		var offset = now.toLocaleString();
		// 		var offsetArr = offset.split(" ");
		//
		// 		$('#Bird_end_time'+details_id).timepicker({
		// 			'timeFormat': 'h:i A',
		// 			'minTime': offsetArr[1],
		// 			// startTime:offsetArr[1],
		// 			'interval': 10,
		// 			change: function(time) {
		// 				// the input field
		// 				var element = $ ( this ), text;
		// 				// get access to this Timepicker instance
		// 				var timepicker = element.timepicker ();
		// 				text = 'Selected time is: ' + timepicker.format ( time );
		// 				element.siblings ( 'span.help-line' ).text ( text );
		// 				// var end_time = $ ( this ).val ();
		// 				// var start_time =  $("input[name='start_time"+rowno+"[]']").val();
		// 				// console.log(start_time+end_time);
		// 				// // console.log(Converttimeformat(starttime, end_time));
		// 				// if(start_time != "" && end_time != ""){
		// 				// 	$(".time_distance"+rowno).val(Converttimeformat(start_time, end_time));
		// 				// }
		// 			}
		//
		// 		});
		// 		$ ( '#Bird_end_time'+details_id ).timepicker ( "option", "minTime", offsetArr[1]);
		//
		// 		// var end_time =  $("input[name='end_time"+rowno+"[]']").val();
		// 		// console.log(starttime+end_time);
		// 		// if(starttime != "" && end_time != ""){
		// 		// 	$(".time_distance"+rowno).val(Converttimeformat(starttime, end_time));
		// 		// }
		//
		// 	}
		//
		// });
		$('#Bird_start_time'+details_id).timepicker({
			'timeFormat': 'h:i A',
			'step': 10
		});

		$('#Bird_start_time'+details_id).on('changeTime', function() {
			$ ('#Bird_end_time'+details_id).val ();
			var stime = $(this).val();
			var etime = $('#Bird_end_time'+details_id).val();
			var date = $('#Bird_Date'+details_id).val();
			var dateArr = date.split("-");
			var newDate = dateArr[2] + "-" + dateArr[1] + "-" + dateArr["0"];
			var cons_datTime = newDate + " " + stime;
			var now = new Date(cons_datTime);
			now.setHours(now.getHours() + 1);
			var offset = now.toLocaleString();
			var offsetArr = offset.split(" ");

			var addhour = moment($('#Bird_start_time'+details_id).val(), "hh:mm").add(1, 'hour');

			$('#Bird_end_time'+details_id).timepicker({
				'timeFormat': 'h:i A',
				'step': 10,
				'defaultTime':addhour,
				'minTime':offsetArr[1],

			});

			$('#Bird_end_time'+details_id).on('changeTime', function() {
				$ ('#Bird_start_time'+details_id).val ();
				var etime = $(this).val();

				// if(stime != "" && etime != ""){
				// 	//alert(Converttimeformat(starttime, endtime));
				// 	$(".time_distance"+rowno).val(Converttimeformat(stime, etime));
				// }
			});

			$ ( '#Bird_end_time'+details_id ).timepicker ( "option", "minTime", offsetArr[1], "defaultTime", addhour);

			// if(stime != "" && etime != ""){
			// 	//alert(Converttimeformat(starttime, endtime));
			// 	$(".time_distance"+rowno).val(Converttimeformat(stime, etime));
			// }

		});

		$("#edit"+details_id).css("display", "none");
		$("#update"+details_id).css("display", "block");

		/*$("#view_date"+event_id).removeAttr("disabled");
		$("#view_latitude"+event_id).removeAttr("disabled");
		$("#view_name"+event_id).removeAttr("disabled");
		$("#view_longitude"+event_id).removeAttr("disabled");*/

		// $("#Bird_Type"+details_id).removeAttr("disabled");
		$("#Bird_Type"+details_id).removeAttr("disabled");
		$("#Bird_Date"+details_id).removeAttr("disabled");
		$("#Bird_start_time"+details_id).removeAttr("disabled");
		$("#Bird_end_time"+details_id).removeAttr("disabled");
	}
}

function event_update ( event_id, details_id ) {
// alert(event_id+details_id);
// return false;
	$("#update"+details_id).prop('disabled',true);
	var bird_type = $("#Bird_Type"+details_id+" option:selected").val();
	var bird_Date = $("#Bird_Date"+details_id).val();
	var bird_start_time = $("#Bird_start_time"+details_id).val();
	var bird_end_time = $("#Bird_end_time"+details_id).val();
	var boarding_time = $("#boarding_time_distance"+details_id).val();
	
	$.ajax({
		type: "post",
		url:locurl+"races/update_event_details",
		cache: false,
		data: {'event_id':event_id,'event_details_id':details_id,'bird_type':bird_type,'bird_date':bird_Date,'bird_start_time':bird_start_time,'boarding_time':boarding_time,'bird_end_time':bird_end_time},
		success: function(data){
			// console.log(data);
			// return false;
			if(data == 1){
				$("p#loder"+details_id+event_id).html("Processing");

				setTimeout(function(){
					$("p#loder"+details_id+event_id).css("display", "none");
					//$("#update"+details_id).css("display", "none");
					//$("#edit"+details_id).css("display", "block");

					// $("#Bird_Type"+details_id).attr('disabled', 'disabled');
					// $("#Bird_Date"+details_id).attr('disabled', 'disabled');
					// $("#Bird_start_time"+details_id).attr('disabled', 'disabled');
					// $("#Bird_end_time"+details_id).attr('disabled', 'disabled');

					$("p#status_re"+details_id+event_id).css("display", "block");
					$("p#loder"+details_id+event_id).html("");
					$("p#status_re"+details_id+event_id).fadeOut(2000);
					//$('#viewModal').delay(1500).fadeOut(3000);
				}, 500);
			}
		}
	});
}

function event_dalete(ed_id,id){
	var con = confirm("Are sure delete to the event?");
	if(con){
		$("#view_edit"+id).prop('disabled',true);
		$("#view_delete"+ed_id).prop('disabled',true);
		$("p#loder"+ed_id+id).html("");
		$.ajax( {
			type: "post",
			url: locurl+"races/event_deleted",
			cache: false,
			data: {'ids': id},
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
					// 	$('#viewModal').modal("hide");
					// }, 5000);
				}
			}
		});
	}

}

function getParameterByName(name, url) {
	if (!url) url = window.location.href;
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function orga_changes() {
	var org = $("#org_code option:selected").val();
	if(org != ""){
		$.post( "../controller/User.php?action=sorting_org", {org: org}, function( data ) {

			$("#example").css("display", "none");
			$("#example_wrapper").css("display", "none");
			$("#code_list_data").html(data);

		});
	}
}

// function tConvert (time) {
// 	// Check correct time format and split into components
// 	time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
//
// 	if (time.length > 1) { // If time format correct
// 		time = time.slice (1);  // Remove full string match value
// 		time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
// 		time[0] = +time[0] % 12 || 12; // Adjust hours
// 	}
// 	return time.join (''); // return adjusted time or original string
// }

function leadingZero(value) {
	if (value < 10) {
		return "0" + value.toString();
	}
	return value.toString();
}
function convertTime24to12(time24){
	var tmpArr = time24.split(':'), time12;
	if(+tmpArr[0] == 12) {
		time12 = tmpArr[0] + ':' + tmpArr[1] + ' PM';
	} else {
		if(+tmpArr[0] == 00) {
			time12 = '12:' + tmpArr[1] + ' AM';
		} else {
			if(+tmpArr[0] > 12) {
				time12 = (+tmpArr[0]-12) + ':' + tmpArr[1] + ' PM';
			} else {
				time12 = (+tmpArr[0]) + ':' + tmpArr[1] + ' AM';
			}
		}
	}
	return time12;
}

// var d = new Date();
//
// var curr_date = d.getDate();
//
// var curr_month = d.getMonth() + 1;
//
// var curr_year = d.getFullYear();
//
// curr_year = curr_year.toString().substr(0,4);
//
// alert(curr_date+"-"+curr_month+"-"+curr_year);


var currentdate='';
var currenttime='';
var currentpage = '';
var currentdist = 0;
var latitude = '';
var longitude = '';
var clubtype = '';

var event_details_id = '';
var event_id = '';
var events_date = '';
var birdid = '';
/*$(document).ready(function() {

	$('input.timepicker').timepicker({});
	// var mydate = new Date();
	//  	currentdate = mydate.toString("d-M-yyyy");
	currentpage = 0;
	currentdist = 0;
	//clubtype = 2;
	var ids =  $("#login_id").val();

	var detailsURL = getParameterByName('id');
	var eventURL = getParameterByName('events_id');
	var sche_dateURL = getParameterByName('events_sche_date');
	var birdURL = getParameterByName('bird_id');

	 if(detailsURL == null || detailsURL == '' ){
		 event_details_id='';

	 }else{
		 event_details_id=detailsURL;
	 }
	 if(eventURL == null || eventURL == '' ){
		 event_id='';
	 }else{
		 event_id=eventURL;
	 }
	 if(sche_dateURL == null || sche_dateURL == '' ){
		 events_date='';
	 }else{
		 var targetDate = new Date(sche_dateURL);
		 targetDate.setDate(targetDate.getDate());
		 var dd = targetDate.getDate();
		 var mm = targetDate.getMonth() + 1;
		 var yyyy = targetDate.getFullYear();
		 events_date = yyyy + "-" + mm + "-" + leadingZero(dd);
	 }
	 if(birdURL == null || birdURL == '' ){
		 birdid='';
	 }else{
		 birdid=birdURL;
	 }

	 var dateURL = getParameterByName('date');
	if(dateURL == null || dateURL == '' ){
		var targetDate = new Date();
		targetDate.setDate(targetDate.getDate());
		var dd = targetDate.getDate();
		var mm = targetDate.getMonth() + 1;
		var yyyy = targetDate.getFullYear();
		currentdate = yyyy + "-" + mm + "-" + leadingZero(dd);
		 //currentdate = $("#datepicker").val(current);


	}
	else{
		var targetDate = new Date(dateURL);
		targetDate.setDate(targetDate.getDate());
		var dd = targetDate.getDate();
		var mm = targetDate.getMonth() + 1;
		var yyyy = targetDate.getFullYear();
		currentdate = yyyy + "-" + mm + "-" + leadingZero(dd);
		//currentdate = $("#datepicker").val(current);
	}
	var timeURL = getParameterByName('time');
	if(timeURL == null || timeURL == '') {
		currenttime = $ ( "#timeval" ).val ();
	}
	else{
		var timeconvert = convertTime24to12(timeURL);
		$('input.timepicker').timepicker({
			defaultTime: timeconvert
		});
		currenttime = timeconvert;
	}

	if(ids == '' ){
		clubtype = 2;
	}
	else {
		var data = $("#cript_type").val();
		if(typeof ids === "undefined"){
			var type=data;
		}
		else {
			var type=data.toUpperCase();
		}
		clubtype = ids;
		/!*$("#title").html('<h1 style="color:#50AEAF;font-family: \'Trebuchet MS\', Arial, Helvetica, sans-serif;">'+type+' Statistics Records - Date :<font id="curdate">'+currentdate+'</font> </h1>');*!/
	}
	// $("#timeval").val('');

	$("#distance").val('')
	 //currenttime = $("#timeval").val();
	 $("#timeval").val(currenttime );
	 $("#datepicker").val(currentdate);
	// $("#curdate").html(currentdate);
	$.ajax({
		type: "post",
		url:"../controller/newphoto.php",
		cache: false,
		data: {'clubtype':clubtype,'values':currentdate,'page':currentpage,'times':currenttime,'distance':currentdist,'lat':latitude,'lon':longitude,'event_details_id':event_details_id,'event_id':event_id,'events_sche_date':events_date,'bird_type':birdid},
		success: function(data){
			$("#tabledata").html(data);
			console.log(data);

			//$("#promocode").val('');
		}

	});

} );*/

function changestat(dateStr)
{

	$("#tabledata").html('<img src="../upload/images/dove.gif" style="width: 15%">');
	var currentdate = dateStr;
	var currentdist = 0;
	var currentpage = 0;
	var clubtype = $("#login_id").val();
	$("#timeval").val('');
	$("#distance").val('')
	var currenttime = $("#timeval").val();
	$("#curdate").html(dateStr);
	$.ajax({
		type: "post",
		url:"../controller/newphoto.php",
		cache: false,
		data: {'clubtype':clubtype,'values':currentdate,'page':currentpage,'times':currenttime,'distance':currentdist,'lat':latitude,'lon':longitude,'event_details_id':event_details_id,'event_id':event_id,'events_sche_date':events_date,'bird_type':birdid},
		success: function(html){
			console.log(html);
			$("#tabledata").html(html);
			//$("#promocode").val('');
		}

	});

}

/*var currentdate='';
var currenttime='';
var currentpage = '';
var currentdist = 0;
var latitude = '';
var longitude = '';
var clubtype = '';
$(document).ready(function() {

	$('input.timepicker').timepicker({});
	currentpage = 0;
	currentdist = 0;
	var dateURL = getParameterByName('date');
	var mydate = new Date(dateURL);
	currentdate = mydate.toString("yyyy-M-d");

	if(dateURL == "")
		var data_id = $("#datepicker").val(currentdate);
	else
		var data_id = $("#datepicker").val(dateURL);

	var timeURL = getParameterByName('time');

	if(timeURL == "") {
		currenttime = $ ( "#timeval" ).val ();
	}
	else{
		var timeconvert = tConvert(timeURL);
		$('input.timepicker').timepicker({
			defaultTime: timeconvert
		});
		currenttime = timeconvert;
	}

	latitude = $ ( "#latitude" ).val ();
	longitude = $ ( "#longitude" ).val ();

	//clubtype = 2;
	var ids =  $("#login_id").val();
	//var temp_id=$("#orgid").val();

	// if(typeof ids === "undefined" ){
	// 	if( temp_id === "undefined" ) {
	// 		clubtype = 2;
	// 	}
	// 	else{
	// 		clubtype = temp_id;
	// 	}
	// }
	if(ids == "2" ){
		clubtype = 2;
	}
	else {
		 var data = $("#cript_type").val();
		//var data = $("#login_id").val();
		if(typeof ids === "undefined"){
			var type=data;
		}
		else {
			var type=data.toUpperCase();
		}
		clubtype = ids;
		$("#title").html('<h1 style="color:#50AEAF;font-family: \'Trebuchet MS\', Arial, Helvetica, sans-serif;">'+type+' Statistics Records - Date :<font id="curdate">'+data_id+'</font> </h1>');
	}

	// $("#timeval").val('');
	$("#distance").val('')



	$("#curdate").html(currentdate);
	$.ajax({
		type: "post",
		url:"../controller/newphoto.php",
		cache: false,
		data: {'clubtype':clubtype,'values':currentdate,'page':currentpage,'times':currenttime,'distance':currentdist,'lat':latitude,'lon':longitude},
		success: function(data){
			$("#tabledata").html(data);
			//$("#promocode").val('');
		}

	});

} );*/



// function changestat1(dateStr)
// {
// 	$("#tabledata").html('<img src="../upload/images/dove.gif">');
// 	currentdate = dateStr;
// 	currentdist = 0;
// 	currentpage = 0;
// 	var ids =  $("#login_id").val();
// 	alert(ids);
// 	$("#timeval").val('');
// 	$("#distance").val('')
// 	currenttime = $("#timeval").val();
// 	$("#curdate").html(dateStr);
// 	$.ajax({
// 		type: "post",
// 		url:"../controller/newphoto.php",
// 		cache: false,
// 		data: {'clubtype':clubtype,'values':currentdate,'page':currentpage,'times':currenttime,'distance':currentdist,'lat':latitude,'lon':longitude},
// 		success: function(html){
// 			$("#tabledata").html(html);
// 			//$("#promocode").val('');
// 		}
//
// 	});
//
// }

function clearresult (id) {
	var con = confirm("Are sure delete to the result?");
	if(con){
		$.post( "../controller/User.php?action=clear_result", {'r_id': id}, function( data ) {
			console.log(data);
			location.reload();
		});
	}
}
function clearorgresult (org_id, id) {
	var con = confirm("Are sure delete to the result?");
	if(con){
		$.post( "../controller/User.php?action=clear_org_result", {'app_type': org_id,'r_id': id}, function( data ) {
			console.log(data);
			location.reload();
		});
	}
}

function paging(pagide)
{

	$("#tabledata").html('<img src="../upload/images/dove.gif" style="width: 15%">');
	$("#curdate").html(currentdate);
	var ids =  $("#login_id").val();
	if(ids == '' ){
		clubtype = 2;
	}
	else {
		clubtype = ids;
	}
	currentpage = pagide;
	currentdist = $("#distance").val();
	longitude = $("#longitude").val();
	latitude = $("#latitude").val();
	currenttime = $("#timeval").val();
	$.ajax({
		type: "post",
		url:"../controller/newphoto.php",
		cache: false,
		data: {'clubtype':clubtype,'values':currentdate,'page':currentpage,'times':currenttime,'distance':currentdist,'lat':latitude,'lon':longitude},
		success: function(html){
			console.log(html);
			$("#tabledata").html(html);
			//$("#promocode").val('');
		}

	});
}

$(document).ready(function(){

	$('input[type="checkbox"]').click(function() {
		if ( $ ( this ).is ( ":checked" ) ) {
			$("#active_action").prop("disabled", false);
			$("#inactive_action").prop("disabled", false);
			$("#delete_action").prop("disabled", false);
		}
		else if ( $ ( this ).is ( ":not(:checked)" ) ) {
			$("#active_action").prop("disabled", true);
			$("#inactive_action").prop("disabled", true);
			$("#delete_action").prop("disabled", true);
		}
	});
	var type = $("#cript_type").val();
	$("#exTab2 li:first").addClass("active");
	/*$("#title").html('<h1 style="color:#50AEAF;font-family: \'Trebuchet MS\', Arial, Helvetica, sans-serif;">'+type+' Statistics Records - Date :<font id="curdate">'+currentdate+'</font> </h1>');*/
// });

// $(document).ready(function(){
	$("#active_action").prop("disabled", true);
	$("#inactive_action").prop("disabled", true);
	$("#delete_action").prop("disabled", true);
	$("input[type=checkbox]").change( function() {
		//var arr = [];
		$.each($("input[name='act_status']:checked"), function(){
			//arr.push($(this).val());
			$("#active_action").prop("disabled", false);
			$("#inactive_action").prop("disabled", false);
			$("#delete_action").prop("false", true);
		});

	});

	$("#active_action").click(function(){
		var arr = [];
		$.each($("input[name='act_status']:checked"), function(){
			arr.push($(this).val());
		});
		console.log(arr);
		$.post( "../controller/User.php?action=active_all", { val: arr}, function( data ) {
			location.reload();
		});
	});

	$("#inactive_action").click(function(){
		var arr = [];
		$.each($("input[name='act_status']:checked"), function(){
			arr.push($(this).val());
		});
		console.log(arr);
		$.post( "../controller/User.php?action=inactive_all", { val: arr}, function( data ) {
			//console.log(data);
			location.reload();
		});
	});

	$("#delete_action").click(function(){
		var arr = [];
		$.each($("input[name='act_status']:checked"), function(){
			arr.push($(this).val());
		});
		console.log(arr);

		$.post( "../controller/User.php?action=delete_all", { val: arr}, function( data ) {
			//console.log(data);
			location.reload();
		});
	});

	$("#checkAll").click(function () {
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

});

function change_live_event(id,name){

	$("#tabledata").html('<img src="../upload/images/dove.gif" style="width: 15%">');
	var type = name.toUpperCase();
	// var mydate = new Date();
	// currentdate = mydate.toString("yyyy-M-d");
	currentpage = 0;
	currentdist = 0;
	clubtype = id;
	$("#timeval").val('');
	$("#login_id").val(id);
	$("#distance").val('')
	var dateURL = getParameterByName('date');
	if(dateURL == null || dateURL == '' ){
		var targetDate = new Date();
		targetDate.setDate(targetDate.getDate());
		var dd = targetDate.getDate();
		var mm = targetDate.getMonth() + 1;
		var yyyy = targetDate.getFullYear();
		currentdate = yyyy + "-" + mm + "-" + leadingZero(dd);
		//currentdate = $("#datepicker").val(current);


	}
	else{
		var targetDate = new Date(dateURL);
		targetDate.setDate(targetDate.getDate());
		var dd = targetDate.getDate();
		var mm = targetDate.getMonth() + 1;
		var yyyy = targetDate.getFullYear();
		currentdate = yyyy + "-" + mm + "-" + leadingZero(dd);
		//currentdate = $("#datepicker").val(current);
	}
	var timeURL = getParameterByName('time');
	if(timeURL == null || timeURL == '') {
		currenttime = $ ( "#timeval" ).val ();
	}
	else{
		var timeconvert = convertTime24to12(timeURL);
		$('input.timepicker').timepicker({
			defaultTime: timeconvert
		});
		currenttime = timeconvert;
	}
	$("#timeval").val(currenttime);
	// currenttime = $("#timeval").val();
	$("#datepicker").val(currentdate);
	$("#curdate").html(currentdate);
	$.ajax({
		type: "post",
		url:"../controller/newphoto.php",
		cache: false,
		data: {'clubtype':clubtype,'values':currentdate,'page':currentpage,'times':currenttime,'distance':currentdist,'lat':latitude,'lon':longitude,'event_details_id':event_details_id,'event_id':event_id,'events_sche_date':events_date,'bird_type':birdid},
		success: function(data){
			/*$("#title").html('<h1 style="color:#50AEAF;font-family: \'Trebuchet MS\', Arial, Helvetica, sans-serif;">'+type+' Statistics Records - Date :<font id="curdate">'+currentdate+'</font> </h1>');*/
			$("#tabledata").html(data);

			//$("#promocode").val('');
		}

	});
}
function add_event ( ) {
	var org_name = $("#org_name option:selected").val();
	var org_name = $("#org_name").val();
	var event_name = $("#event_name").val();
	var event_date = $("#event_date").val();
	//var event_time = $("#event_time").val();
	var event_time = $("#event_time option:selected").val();
	var event_latitude = $("#event_latitude").val();
	var event_longitude = $("#event_longitude").val();
	if(org_name != "" && event_name != "" && event_date != "" && event_time != "" && event_latitude != "" && event_longitude != ""){
		$.post( "../controller/User.php?action=add_event", { org_name: org_name, event_name: event_name, event_date: event_date, event_time: event_time, event_latitude: event_latitude, event_longitude: event_longitude }, function( data ) {
			//console.log(data);
			location.reload();
		});
	}
	else{

	}
}

function distance_cal()
{
	var lat1 = $("#lat1").val();
	var lon1 = $("#lon1").val();
	var lat2 = $("#lat2").val();
	var lon2 = $("#lon2").val();

	$.ajax({
		type: "post",
		url:"../controller/newphoto.php",
		cache: false,
		data: {'calc':0,'lat1':lat1,'lon1':lon1,'lat2':lat2,'lon2':lon2},
		success: function(html){
			//console.log(html);
			$("#result").val(html);
			//$("#promocode").val('');
		}

	});
}

function velocity_calc()
{
	var time1 = $("#time1").val();
	var time2 = $("#time2").val();
	var lat1 = $("#lat1").val();
	var lon1 = $("#lon1").val();
	var lat2 = $("#lat2").val();
	var lon2 = $("#lon2").val();

	$.ajax({
		type: "post",
		url:"../controller/newphoto.php",
		cache: false,
		data: {'velocity_calc':0,'time1':time1,'time2':time2,'lat1':lat1,'lon1':lon1,'lat2':lat2,'lon2':lon2},
		success: function(html){
			//console.log(html);
			$("#result").val(html);
			//$("#promocode").val('');
		}
	});
}

function change_status(id){
	$.post( "../controller/User.php?action=user_status", { id: id}, function( data ) {
		location.reload();
	});
}
function change_publish(id){
	$.post( "../controller/User.php?action=publish_status", { id: id}, function( data ) {
		location.reload();
	});
}
function change_loft_status(id){
	$.post( "../controller/User.php?action=user_loft_status", { id: id}, function( data ) {
		location.reload();
	});
}

function change_distance () {
	var dis_id = $( "#race_distance option:selected" ).val();

	var dis_km = $( "#race_distance option:selected" ).html();
	var event_id = $( "#event_details_id" ).val();
	var dis_text = $( "#race_distance option:selected" ).text();
	var text = dis_text.split('-');
	$("#bird_type").val(text[1]);

	if(dis_id != "") {
		$(".panel-default").css('display', 'none');
		$("#tabledata").css('display', 'block');
		$.ajax ( {
			type: "post",
			url: "../controller/User.php?action=change_dis",
			cache: false,
			data: { 'distance_id': dis_id,'events_id': event_id,'bird_type': text[1] },
			success: function ( data ) {
				var obj = jQuery.parseJSON(data);
				// $("#bird_type").val(obj.bird_type);
				$("#start_date").val(obj.start_date);
				$("#End_date").val(obj.end_date);
				$("#latitude").val(obj.event_lat);
				$("#longitude").val(obj.event_long);
				$("#club_id").val(obj.clube_id);
				$("#start_time").val(obj.start_time);
				$("#boarding_time").text('- Boarding Time :'+obj.boarding_time+' Hours');
				$("#boarding_hours").val(obj.boarding_time);
				
				if(text.length > 1){
					change_live_race(obj.clube_id, text[1], obj.start_date, obj.end_date, obj.start_time, obj.event_lat, obj.event_long, obj.boarding_time, event_id, dis_km);
				}
				else {
					change_live_race(obj.clube_id, obj.bird_type, obj.start_date, obj.end_date, obj.start_time, obj.event_lat, obj.event_long, obj.boarding_time, event_id, dis_km);
				}

			}
		} );
	}
	else {
		$(".panel-default").css('display', 'block');
		$("#tabledata").html(" ");
		$("#tabledata").css('display', 'none');
	}
}

function change_date_format(dateURL)
{
	var targetDate = new Date(dateURL);
	targetDate.setDate(targetDate.getDate());
	var dd = targetDate.getDate();
	var mm = targetDate.getMonth() + 1;
	var yyyy = targetDate.getFullYear();
	currentdate = yyyy + "-" + mm + "-" + leadingZero(dd);
	return currentdate;
}

function change_live_race (clubtype, birdid, start_date, end_date, start_time, latitude, longitude, boarding_time, event_id, distance)
{
	$("#tabledata").html('<img src="../upload/images/dove.gif" style="width: 15%">');
	var startdate = change_date_format(start_date);
	var enddate = change_date_format(end_date);
	var starttime = start_time;
	$.ajax( {
		type: "post",
		url: "../controller/newphoto.php",
		cache: false,
		data: {
			'clubtype': clubtype,
			'values': startdate,
			'values1': enddate,
			'evnt_distance':distance,
			'times': starttime,
			'lat': latitude,
			'lon': longitude,
			'event_id': event_id,
			'bird_type': birdid
		},
		success: function ( html ) {
			console.log ( html );
			$ ( "#tabledata" ).html ( html );
			//$("#promocode").val('');
		}
	});

}

function fancier_edit ( id ) {
	if(id != ""){
		$('#EditUser').modal('show');
		$.post( "../controller/User.php?action=edit_profile", {id: id}, function( data ) {
			var obj = jQuery.parseJSON(data);
			//console.log(obj.details.Org_name);
			/*$("#get_user_id").val(obj.details.Org_id);
			$("#user_name").val(obj.details.Org_name);
			$("#latitude").val(obj.details.phone_no);
			$("#longitude").text(obj.details.address);
			$("#user_address").text(obj.details.address);*/
		});
	}
}



function editprofiledata (  ) {
	$("#Update_data").css("display", "block");
	$("#Edit_data").css("display", "none");
	$("#org_name").prop("disabled", false);
	$("#edit_profile_image").prop("disabled", false);
	$("#org_phone").prop("disabled", false);
	$("#longitude").prop("disabled", false);
	$("#org_address").prop("disabled", false);
}

function update_location ( ids ) {
	var lat = $("#latitude").val();
	var long = $("#longitude").val();
	var add = $("#user_address").val();
	$.post( "../controller/User.php?action=update_location", {'id': ids,'lat': lat,'long': long,'address': add}, function( data ) {
		console.log(data);
		if(data == 1){
			// $("p.error").html("<div class=\"alert alert-success\">Location updated successfully</div>");
			$("#org_result").fadeIn('1000').show();
			setTimeout(function(){
				$("#org_result").fadeIn('1500').hide();
			}, 2500);
		}
	});
}

function edit_profile ( id ) {
	if(id != ""){
		$('#Editprofile').modal('show');
		$.post( "../controller/User.php?action=edit_profile", {id: id}, function( data ) {
			var obj = jQuery.parseJSON(data);
			//console.log(obj.details.Org_name);
			$("#get_id").val(obj.details.Org_id);
			$("#org_name").val(obj.details.Org_name);
			$("#org_phone").val(obj.details.phone_no);
			$("#org_address").text(obj.details.address);
		});
	}
}
function ora_edit ( id ) {
	if(id != ""){
		$('#myModal').modal('show');
		$("#pwd_id").val(id);
		$("#pro_id").val(id);
		$.post( "../controller/User.php?action=edit_profile", {id: id}, function( data ) {
			var obj = jQuery.parseJSON(data);
			console.log(obj);
			if(obj.details.Org_logo != ""){
				var img = "../upload/logo/"+obj.details.Org_logo;
				//$("#profImg").css("display", "none");
				// $("#profImg").html('<img src="../upload/logo/'+obj.details.Org_logo+'" id="image" width="25%"/>');
				$('#profImg').attr('src', img);
			}

			$("#org_name").val(obj.details.Org_name);
			$("#org_number").val(obj.details.phone_no);
			$("#org_address1").val(obj.details.address);
			$("#org_exp_date").val(obj.details.Expire_date);
			
		});
	}
}
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#profImg').attr('src', e.target.result);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
// function update_profile ( ) {
// 	var id = $("#get_id").val();
// 	var phone = $("#org_phone").val();
// 	var address = $("textarea#org_address").val();
// 	$.post( "../controller/User.php?action=update_profile", {'org_id': id,'org_phone': phone,'org_address': address}, function( data ) {
// 		console.log(data);
// 		$("#org_result").css("display", "block");

// 		setTimeout(function(){
// 			$(".close").click();
// 			location.reload();
// 		}, 2000);

// 	});
// }
// function genpdf () {
// 	$.post( "../controller/User.php?action=update_profile", {}, function( data ) {
// 		console.log(data);
// 	});
// }