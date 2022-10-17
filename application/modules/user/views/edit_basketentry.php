<?php $eventide = $this->uri->segment(3);
$eventide = base64_decode(urldecode($eventide));

$get_event_race = $this->db->query("SELECT a.date,a.start_time,a.end_time FROM ppa_event_details as a where a.event_id = '" . $eventide . "' order by a.event_id DESC");
$raceEvent = $get_event_race->result();


$clubcode = $result_data[0]->Org_code;   

$birdtype = $this->db->query("SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type ,ed_id, race_distance , event_id  FROM `ppa_event_details` INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id where ppa_event_details.event_id='".$eventide . "'");
$birdinfo = $birdtype->result();
foreach ($birdinfo as $key=>$dis ) { 
          if($dis->b_id."#".$dis->ed_id!='')
           {
             $racecat[] = $dis->b_id."$".$dis->race_distance." - ".$dis->brid_type;
           }
        }


$racestartdate      = $racedetailsinfo[0]->mini;
  $starttime          = $racedetailsinfo[0]->start;
  $post_date          = str_replace("'", '',$racestartdate)." ".$starttime;     
  $start_timestamp    = strtotime($post_date);
  $racestart_time     = date( 'd-m-Y , h:i:s A', $start_timestamp );
  date_default_timezone_set("Asia/Kolkata");
  $currdate_timestamp = strtotime(date('d-m-Y , h:i:s A'));
  if ($start_timestamp > $currdate_timestamp)
    $racestatus = "Race Not Started";
  else
    $racestatus = "<h1 style='text-align:center;color:red;'> Race Started - You are not allowed to add / edit the birds</h1>";
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
            <h3 class="box-title">Basketing Entries for - <?php echo $result_data[0]->Event_name;?> - <?php echo $result_data[0]->Event_date;?></h3>
            <div class="error_status" style="padding-top:10px;"></div>
            <div class="box-tools">
              <?php $encrypt = urlencode(base64_encode($eventide)); ?>
            <a style="cursor: pointer;" onclick="refreshtable();"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="fa fa-refresh"></i>&nbsp;Refresh</button></a>
            <a href="<?php echo base_url().'user/races/';?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="fa fa-eye"></i>&nbsp;Race Listing</button></a>
            <?php 
              // foreach($raceEvent as $Events){ 
              $curdate = date("Y-m-d h:i A");
              $start_date = $raceEvent[0]->date.' '.$raceEvent[0]->start_time;
              //$end_date = $raceEvent->date.' '.$raceEvent->end_time;
              if (strtotime($start_date) > strtotime($curdate)) {
            ?>
             <a href="<?php echo base_url().'user/basketing/'.$encrypt;?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="glyphicon glyphicon-plus"></i> Add Basketing Entry</button></a>
             <a href="<?php echo base_url().'user/viewbasketing/'.$encrypt;?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="glyphicon glyphicon-eye-open"></i> View Basketing Entry</button></a>
           <?php } ?>
            </div>
          </div>
          <form id="editbasket" method="post">
          <input type="hidden" name="piclubcode" value="<?php echo $clubcode;?>">
          <!-- /.box-header -->
          <?php //if($start_timestamp > $currdate_timestamp) { ?>
          <div class="box-body">           
            
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th>S.no</th>
                  <th>Fancier name</th>
									<th>Bird Type</th>
                  <!-- <th>Race Category</th> -->
                  <th>Club/Owner Ring No</th>
                  <th>Gender</th>
                  <th>Color</th>
                  <th>Outer no</th>
                  <th>Inner no</th>
                  <th>Sticker outer no</th>
                  <th>Sticker inner no</th>
                  <th>Event Id</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody> 
            </table>
             
          </div>
          <?php //if($this->session->userdata('user_details')[0]->user_type =='Admin') { ?>
          <div class="box-body">
             <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td align="center">
                    <?php 
                      // foreach($raceEvent as $Events){ 
                      $curdate = date("Y-m-d h:i A");
                      $start_date = $raceEvent[0]->date.' '.$raceEvent[0]->start_time;
                      //$end_date = $raceEvent->date.' '.$raceEvent->end_time;
                      if (strtotime($start_date) > strtotime($curdate)) {
                    ?>
                      <input type="submit" style="font-size:15px;" class="btn-sm  btn btn-success" id="updatebasket" value="Update Data">
                    <?php } ?>
                  </td>
                </tr>
             </table>
          </div>
         <?php //} else { ?>

           <?php //echo $racestatus; } ?>
<br><br>
          <!-- /.box-body -->
        </div>
        </form>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>  
<!-- Modal Crud Start-->
<div id="basketupdate" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content col-md-9">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Updated !!</h4>
            </div>
            <div class="modal-body">
                <p>Basketing details updated successfully !!</p>
            </div>
            
        </div> 
    </div>
</div><!--End Modal Crud --> 
<div id="basket_delete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content col-md-6">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete ?</p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-small  yes-btn btn-danger" onclick="deleteentry()">yes</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">no</button>
            </div>
        </div> 
    </div>
</div>
<script type="text/javascript">
var delide = 0;
var editval = 0;
var btype = '';
var fancier_type = '';

function setbasketId(id) {
 $('#basket_delete').modal('show'); 
 delide = id
}

function deleteentry()
{
	$('#basket_delete').modal('hide');
	var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
    $.ajax({
    type: "post",
    url: url+"user/deletebasketentry",
    cache: false,   
    data: {'ide':delide},
    success: function(json){  
      //$("#sendstatus").html = json;
     $(".error_status").html('<div class="alert alert-info">Basket entry deleted successfully</div>');
     $('#example1').DataTable().ajax.reload( null, false );  
                        setTimeout(function(){
                       $(".alert-info").hide('blind', {}, 500)
                      }, 5000);
         
     }
    
    });
}


var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
  $(document).ready(function() {  
    
    var table = $('#example1').DataTable({ 
          dom: 'lfBrtip',
          buttons: [],
          "columnDefs": [
    { "orderable": false, "targets": 1 },
    {
                "targets": [ 7,8,9,10 ],
                "visible": false
    }
  ],
          "processing": true,
          "serverSide": true,
          "ajax": {"url" : url+"user/basketingTable","data" : {"event":<?php echo $eventide;?>,"edit":editval,"fanciertype":fancier_type,"btype":btype} },
          "sPaginationType": "full_numbers",
          "language": {
            "search": "_INPUT_",
            "sLengthMenu": "Show _MENU_ Fancier & Bird Type", 
            "searchPlaceholder": "Search",
            "paginate": {
                "next": '<i class="fa fa-angle-right"></i>',
                "previous": '<i class="fa fa-angle-left"></i>',
                "first": '<i class="fa fa-angle-double-left"></i>',
                "last": '<i class="fa fa-angle-double-right"></i>'
            }
          }, 
          "iDisplayLength": 10,
          "aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"All"]]
      });
    
    setTimeout(function() {
      var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
      $('.table-date-range').css('right',add_width+'px');
      
      $('#example1_length').append('<label>&nbsp;&nbsp;&nbsp;<select onchange="getentrybyfancier(this.value)" class="form-control input-sm"><option value="">Select Fancier</option><?php foreach ($geteventfancierlists as $key=>$fancierlist ) { ?><option value="<?php echo $fancierlist->reg_id;?>"><?php echo trim($fancierlist->username);?></option><?php } ?></select>&nbsp;&nbsp;&nbsp;<select onchange="getentrybybirdtype(this.value)" class="form-control input-sm"><option value="">Select Bird Type</option><?php for($t=0;$t<count($racecat);$t++) { $values = explode("$",$racecat[$t]); ?><option value="<?php echo $values[0];?>"><?php echo $values[1];?></option><?php } ?></select></label>'); 


    }, 300);
    $("button.closeTest, button.close").on("click", function (){});
  });


function getinfo(val,ind) {
   
   document.getElementById("colortype"+ind).disabled = false;
   document.getElementById("gender"+ind).disabled = false;
   var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/getclubbirdinfo",
    cache: false,   
    data: {'ringno':val,'clode':'<?php echo $clubcode;?>'},
    success: function(json){  
     // console.log(info);return false;
      if(json!='0')
      {
        var info = json.split("#")

        //document.getElementById("colortype"+ind).disabled = true;
        //document.getElementById("gender"+ind).disabled = true;
        document.getElementById("colortype"+ind).value = info[1];
        document.getElementById("gender"+ind).value = info[0];
        //document.getElementById("birdname"+ind).value = info[2];
        //document.getElementById("outer_no"+ind).value = info[3];
        $("#colortype"+ind+" option[value='"+info[1]+"]'").prop("selected", true);   
        $("#gender"+ind+" option[value='"+info[0]+"]'").prop("selected", true);   
        
      }
      console.log(json)
     }
    
    });
}




  function changestatus(ide,st)
{
  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/changeaccountstatus",
    cache: false,   
    data: {'ide':ide,'status':st},
    success: function(json){  
      //$("#sendstatus").html = json;
     $('#example1').DataTable().ajax.reload( null, false );  
     
     }
    
    });

 
  
}  

function editmode()
{
   
   editval = 1;
   var urlval = url+"user/basketingTable?editmode="+editval;
   $('#example1').DataTable().ajax.url( urlval ).load();
}

function getentrybyfancier(types)
{
   fancier_type = types
   var urlval = url+"user/basketingTable?fanciertype1="+fancier_type+"&btype1="+btype+"&event=<?php echo $eventide;?>";
   $('#example1').DataTable().ajax.url( urlval ).load();
 }

function getentrybybirdtype(types)
{
   btype = types
   var urlval = url+"user/basketingTable?fanciertype1="+fancier_type+"&btype1="+btype+"&event=<?php echo $eventide;?>";
   $('#example1').DataTable().ajax.url( urlval ).load();
 }

$("#editbasket").submit(function(e) {

    var newurl = "<?php echo base_url().'user/updateentryresult'?>"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: newurl,
           data: $("#editbasket").serialize(), // serializes the form's elements.
           success: function(data)
           {
              $('#example1').DataTable().ajax.reload( null, false );  
              $('#basketupdate').modal('show'); 
              setTimeout(function() {
               // location.reload();
               $('#basketupdate').modal('hide'); 
              }, 3000);
                   }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});

function refreshtable()
{
  $('#example1').DataTable().ajax.reload( null, false );  
}


</script>            