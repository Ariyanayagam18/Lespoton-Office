<?php $eventide = $this->uri->segment(3);
$eventide = base64_decode(urldecode($eventide));

$get_event_race = $this->db->query("SELECT a.date,a.start_time,a.end_time FROM ppa_event_details as a where a.event_id = '" . $eventide . "' order by a.event_id DESC");
$raceEvent = $get_event_race->result();

$birdtype = $this->db->query("SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type ,ed_id, race_distance , event_id  FROM `ppa_event_details` INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id where ppa_event_details.event_id='" . $eventide . "' group by ppa_event_details.bird_id,ppa_event_details.race_distance");
$birdinfo = $birdtype->result();

$birdcolorinfo = $this->db->query("select * from pigeons_color");
$birdcolorres = $birdcolorinfo->result();
foreach ($birdcolorres as $key => $colors) {
    $birdcolor[] = $colors->color;
}
$genderarray[] = "Male";
$genderarray[] = "Female";
$birdcount = count($birdcolor);
$gendercount = count($genderarray);
$clubcode = $result_data[0]->Org_code;

$racestartdate = $racedetailsinfo[0]->mini;
$starttime = $racedetailsinfo[0]->start;
$post_date = str_replace("'", '', $racestartdate) . " " . $starttime;
$start_timestamp = strtotime($post_date);
$racestart_time = date('d-m-Y , h:i:s A', $start_timestamp);
date_default_timezone_set("Asia/Kolkata");
$currdate_timestamp = strtotime(date('d-m-Y , h:i:s A'));
if ($start_timestamp > $currdate_timestamp) {
    $racestatus = "Race Not Started";
} else {
    $racestatus = "<h1 style='text-align:center;color:red;'> Race Started - You are not allowed to add / edit the birds</h1>";
}

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
            <h3 class="box-title">Add Basketing Entry for - <?php echo $result_data[0]->Event_name; ?> - <?php echo $result_data[0]->Event_date; ?></h3>
            <div class="error_status" style="padding-top:10px;"></div>
            <div class="box-tools">
             <?php $encrypt = urlencode(base64_encode($eventide)); ?>
             <a href="<?php echo base_url() . 'user/races/'; ?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="fa fa-eye"></i>&nbsp;Race Listing</button></a>
             <?php 
              // foreach($raceEvent as $Events){ 
              $curdate = date("Y-m-d h:i A");
              $start_date = $raceEvent[0]->date.' '.$raceEvent[0]->start_time;
              //$end_date = $raceEvent->date.' '.$raceEvent->end_time;
              if (strtotime($start_date) > strtotime($curdate)) {
            ?>
             <a href="<?php echo base_url() . 'user/viewbasketing/' . $encrypt; ?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i> View Basketing Entry</button></a>
             <a href="<?php echo base_url() . 'user/editbasketing/' . $encrypt; ?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="glyphicon glyphicon-pencil"></i> Update Basketing Entry</button></a>
             <?php } ?>
            </div>
          </div>
          <form id="editresult" method="post" action="<?php echo base_url() . 'user/updatebasket' ?>">
          <input type="hidden" name="eventide" value="<?php echo $eventide; ?>">
          <div class="box-title width-side">
          <div class="row">
          <div class="col-md-12">
          <?php //if($start_timestamp > $currdate_timestamp) { ?>
           <table border="0" class="fontinfo" cellspacing="0" cellpadding="0" width="100%">
              <tr><td><b>&nbsp;</b></td></tr>
              <tr>
                  <td width="2%"></td>
                  <td width="15%">
                     <table cellspacing="0" cellpadding="0">
                       <tr><td><b>Select Fancier:</b></td></tr>
                       <tr>
                          <td>
                              <select name="fancieride" id="fancieride" class="form-control input-sm">
                              <?php ?>
                              <option value="">Select Fancier</option>
                              <?php foreach ($geteventfancierlists as $fancierlist) {?>
                              <option value="<?php echo $fancierlist->reg_id; ?>"><?php echo $fancierlist->username; ?> - <?php echo $fancierlist->phone_no; ?></option>
                              <?php }?>
                              </select>
                          </td>
                       </tr>
                     </table>
                  </td>
                  <td width="15%">
                     <table cellspacing="0" cellpadding="0">
                       <tr><td><b>Select Race category:</b></td></tr>
                       <tr>
                          <td>
                              <select name="birdtypes" id="birdtypes" class="form-control input-sm"><option value="">Select Race category</option><?php foreach ($birdinfo as $key => $dis) {?><option value="<?php echo $dis->b_id . "#" . $dis->ed_id; ?>"><?php echo $dis->race_distance . " - " . $dis->brid_type; ?></option><?php }?></select>
                          </td>
                       </tr>
                     </table>
                  </td>
                  <td width="68%" align="left">
                     <table cellspacing="0" cellpadding="0">
                       <tr><td><b>&nbsp;</b></td></tr>
                       <tr>
                          <td>
                            <?php 
                                // foreach($raceEvent as $Events){ 
                                $curdate = date("Y-m-d h:i A");
                                $start_date = $raceEvent[0]->date.' '.$raceEvent[0]->start_time;
                                //$end_date = $raceEvent->date.' '.$raceEvent->end_time;
                                if (strtotime($start_date) > strtotime($curdate)) {
                              ?>
                              <button type="button" class="btn-sm  btn btn-success" data-toggle="modal" onclick="insertrows()"><i class="glyphicon glyphicon-plus"></i> Add Bird</button>
                            <?php } ?>
                          </td>
                       </tr>
                     </table>
                  </td>
              </tr>
               <tr><td><b>&nbsp;</b></td></tr>
           </table>
           <?php //} else { ?>

           <?php //echo $racestatus; } ?>
            </div>

           </div>
            </div>
          <!-- /.box-header -->

          <div class="box-body">
            <table id="example1" style="" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th width="24%" align="center">Club/Owner Ring No</th>
                  <!--<th width="10%" align="center">Bird name</th>-->
                  <th width="14%" align="center">Bird Color</th>
                  <th width="14%" align="center">Bird Gender</th>
                  <th width="22%" align="center" id="outer_no">Outer no</th>
                  <!--<th width="10%" align="center">Inner no</th>-->
                  <!--<th width="10%" align="center">Sticker outer no</th>-->
                  <!--<th width="10%" align="center">Sticker inner no</th>-->
                  <th width="16%" align="center">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

          </div>
          <div class="box-body">
             <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td align="center">
                    <input type="submit" class="btn-sm  btn btn-success" id="updatebasket" style="display: none;" value="Submit Info">
                  </td>
                </tr>
             </table>
          </div>
          <!-- /.box-body -->
           </form>
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

<div id="fancierviewwindow" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content col-md-6">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p>Please select the fancier</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="birdideviewwindow" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content col-md-6">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p>Please select the race category</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
editval = 0;
var inc = 0;
var url = '<?php echo base_url(); ?>';//$('.content-header').attr('rel');

$(document).ready(function() {
  var urls = '<?php echo base_url(); ?>';//$('.content-header').attr('rel');

     $("#editresult").submit(function(e){
        e.preventDefault();
        var formData = $("#editresult").serialize();
        $.ajax({
              type:"POST",
              url:urls+"user/updatebasket",
              data:formData,//only input
              cache       : false,
              success: function(response){
                  $(".error_status").show();
                  var info = response.split('#');
                  var ringnos = info[0].split(',');



                  for (t=1;t<200;t++)
                  {
                     if($('#row'+t))
                     $('#row'+t).hide();
                  }

                  for (t=0;t<ringnos.length;t++)
                  {
                    var indval = ringnos[t];
                    if(indval!='')
                    {
                      $('#row'+indval).show();
                      document.getElementById("ringno"+indval).style = "border:1px solid red;";
                    }
                  }

                  $("#editresult")[0].reset();
                  if(info[0]!='')
                  // $(".error_status").html('<div class="alert alert-info">Basket info added successfully & following hightlighted ring numbers are duplicated </div>');
                  $(".error_status").html('<div class="alert alert-info">Basket info not added as following hightlighted ring numbers are already exist in our system. </div>');
                  else
                  $(".error_status").html('<div class="alert alert-info">Basket info added successfully</div>');
                        setTimeout(function(){
                        location.reload();
                       $(".alert-info").hide('blind', {}, 500)
                      }, 3000);

                  console.log(response);
                  return false;
              }
          });

     });

});

$('#fancieride').change(function()
{
  var fancierid = $("#fancieride").val();
  var event_id = $("input[name=eventide]").val();
  $.ajax(
    {
      type: "post",
      url: url+"events/checkFancierType",
      cache: false,
      dataType: 'json',
      data: {'fancierid':fancierid, 'eventide':event_id},
      success: function(json)
      {
        if(json.read_type =='1')
        {
          $('#outer_no').html("RFID tag no.");
          $('.rubber_outer_no').val(json.scanReader);
          $('.rubber_outer_no').prop('readonly', true);
        }
        else
        {
          $('#outer_no').html("Outer no");
          $('.rubber_outer_no').val(json.rubber_outer_no);
          $('.rubber_outer_no').prop('readonly', false);
        }
      }

    });
});

function insertrows()
{
  var fancierid = $("#fancieride").val();
  var birdide = $("#birdtypes").val();
  var rfid_no = $("#outer_no").text();
  if(rfid_no != "Outer no")
   {
      $('.rubber_outer_no').prop('readonly', true);
   }else{
      $('.rubber_outer_no').prop('readonly', false);
   }
  if(fancierid=='')
  {
    $('#fancierviewwindow').modal('show');
  }
  else if(birdide=='')
  {
    $('#birdideviewwindow').modal('show');
  }
  else 
  {
    var html = '';
    inc++;
   /*html = '<table id="example1" style="" class="cell-border example1 table table-striped table1 delSelTable"><thead><tr><th width="14%"><input class="form-control" onkeyup="getinfo(this.value,'+inc+')" type="text" name="ringno[]"></th><th width="14%"><select class="form-control input-sm"><option value="">Select color</option><?php for ($t = 0; $t < count($birdcolor); $t++) {?><option value="<?php echo $birdcolor[$t]; ?>"><?php echo $birdcolor[$t]; ?></option><?php }?></select></th><th width="16%"><select class="form-control input-sm" name="gender[]"><option value="">Select Gender</option><?php for ($t = 0; $t < count($genderarray); $t++) {?><option value="<?php echo $genderarray[$t]; ?>"><?php echo $genderarray[$t]; ?></option><?php }?></select></th><th width="14%"><input class="form-control" type="text" name="ringno3[]"></th><th width="14%"><input class="form-control" type="text" name="ringno4[]"></th><th width="14%"><input class="form-control" type="text" name="ringno1[]"></th><th width="14%"><input class="form-control" type="text" name="ringno1ingno2[]"></th></tr></thead><tbody></tbody></table>';*/

   /*html2 = '<tr id="row'+inc+'"><th width="14%"><input id="ringno'+inc+'" class="form-control" onkeyup="getinfo(this.value,'+inc+')" type="text" name="ringno[]"></th><th width="10%"><input id="birdname'+inc+'" class="form-control" onkeyup="getinfo(this.value,'+inc+')" type="hidden" name="birdname[]"></th><th width="14%"><select id="colortype'+inc+'" name="colortypes[]" class="form-control input-sm"><option value="">Select color</option><?php for ($t = 0; $t < $birdcount; $t++) {?><option value="<?php echo $birdcolor[$t]; ?>"><?php echo $birdcolor[$t]; ?></option><?php }?></select></th><th width="14%"><select id="gender'+inc+'" class="form-control input-sm" name="gender[]"><option value="">Select Gender</option><?php for ($t = 0; $t < $gendercount; $t++) {?><option value="<?php echo $genderarray[$t]; ?>"><?php echo $genderarray[$t]; ?></option><?php }?></select></th><th width="13%"><input class="form-control" type="text" name="rubber_outer_no[]"></th><th width="10%"><input class="form-control" type="hidden" name="rubber_inner_no[]"></th><th width="10%"><input class="form-control" type="hidden" name="sticker_outer_no[]"></th><th width="10%"><input class="form-control" type="hidden" name="sticker_inner_no[]"></th><th width="6%"><i onclick="insertrows()" class="fa fa-plus" style="font-size:22px;color:green;"></i></i>&nbsp;<i onclick="removerow('+inc+')" class="fa fa-remove" style="font-size:23px;color:red"></th></tr>';*/

   html2 = '<tr id="row'+inc+'"><th width="24%"><input id="ringno'+inc+'" class="form-control" onkeyup="getinfo(this.value,'+inc+')" type="text" name="ringno[]"></th><input id="birdname'+inc+'" class="form-control" onkeyup="getinfo(this.value,'+inc+')" type="hidden" name="birdname[]"><th width="14%"><select id="colortype'+inc+'" name="colortypes[]" class="form-control input-sm"><option value="">Select color</option><?php for ($t = 0; $t < $birdcount; $t++) {?><option value="<?php echo $birdcolor[$t]; ?>"><?php echo $birdcolor[$t]; ?></option><?php }?></select></th><th width="14%"><select id="gender'+inc+'" class="form-control input-sm" name="gender[]"><option value="">Select Gender</option><?php for ($t = 0; $t < $gendercount; $t++) {?><option value="<?php echo $genderarray[$t]; ?>"><?php echo $genderarray[$t]; ?></option><?php }?></select></th><th width="22%"><input class="form-control rubber_outer_no" type="text" name="rubber_outer_no[]"></th><input class="form-control" type="hidden" name="rubber_inner_no[]"><input class="form-control" type="hidden" name="sticker_outer_no[]"><input class="form-control" type="hidden" name="sticker_inner_no[]"><th width="26%"><i onclick="insertrows()" class="fa fa-plus" style="font-size:22px;color:green;"></i></i>&nbsp;<i onclick="removerow('+inc+')" class="fa fa-remove" style="font-size:23px;color:red"></th></tr>';
   $(".example1").append(html2);
   if(rfid_no != "Outer no")
   {
      $('.rubber_outer_no').prop('readonly', true);
   }else{
      $('.rubber_outer_no').prop('readonly', false);
   }
   if(inc>0)
   {
    $("#updatebasket").show();
   }
   else
   {
    $("#updatebasket").hide();
   }
  }
}

function getinfo(val,ind) {

   document.getElementById("colortype"+ind).disabled = false;
   document.getElementById("gender"+ind).disabled = false;
   var url = '<?php echo base_url(); ?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/getclubbirdinfo",
    cache: false,
    data: {'ringno':val,'clode':'<?php echo $clubcode; ?>'},
    success: function(json){
      if(json!='0')
      {
        var info = json.split("#")
        document.getElementById("colortype"+ind).value = info[1];
        document.getElementById("gender"+ind).value = info[0];
        document.getElementById("birdname"+ind).value = info[2];
       // document.getElementById("colortype"+ind).disabled = true;
       // document.getElementById("gender"+ind).disabled = true;
      }
      console.log(json)
     }

    });
}



function removerow(ide)
{
  //alert(ide);
  $('#row'+ide).remove();inc--;
  if(inc>0)
   {
    $("#updatebasket").show();
   }
   else
   {
    $("#updatebasket").hide();
   }
  //$('#row'+ide).parent().remove();
}
</script>
<style>
  #editresult .box-title label,#editresult .box-title span{
    padding-right: 5px;
    padding-left: 5px;
        font-size: 16px;
  }
  .float-side{float:right;}
  .box-title .btn-default {
    width: 120px;}

   .siderow {
      padding-top: 15px;
    padding-bottom: 26px;
    padding-left: 35px;
    }
    .width-side{
            border: 3px solid #00c0ef;
            margin: 10px;

             }
   .box-header .box-title {

    border: none;
    }
    .fontinfo
    {
      font-size:15px;
    }
</style>