<?php $eventide = $this->uri->segment(3);

$eventide = base64_decode(urldecode($eventide));
$birdtype = $this->db->query("SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type , race_distance , event_id  FROM `ppa_event_details` INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id where ppa_event_details.event_id='" .
                      $eventide . "'");
$birdinfo = $birdtype->result();
$clubcode = $result_data[0]->Org_code;   
?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
    <div class="alert alert-info" id="res" style="display: none;">
    </div>
  <?php if($this->session->flashdata("messagePr")){?>
    <div class="alert alert-info">      
      <?php echo $this->session->flashdata("messagePr")?>
    </div>
  <?php } ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Results</h3>
            <div class="box-tools">
             <?php //print_r($result_data);?>
             <a style="cursor: pointer;" onclick="refreshtable();"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="fa fa-refresh"></i>&nbsp;Refresh</button></a>
            </div>
          </div>
          <form id="editresult" method="post" action="<?php echo base_url().'user/updateresult'?>">
          <input type="hidden" name="eventide" value="<?php echo $eventide;?>">
          <div class="box-title width-side">
          <div class="row"> 
          <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
           <div class="row siderow" style="padding-top: 25px;">  
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6"> 
              <span><label><b>Event Name:</b></label><?php echo $result_data[0]->Event_name;?></span>
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">     
               <span><label><b>Event Scheduled Date:</b></label><?php echo $result_data[0]->Event_date;?></span>
          </div>
          </div>
           <div class="row siderow"> 
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">      
               <span><label><b>Result Status:</b></label><span id="resultstatus"><?php if($result_data[0]->result_publish=='0') 
                          echo "Unpublished <a style='cursor:pointer;' onclick=changeresultstatus(".$eventide.",'1')>Make Publish</a>"; 
                       else 
                         echo "Published  <a style='cursor:pointer;' onclick=changeresultstatus(".$eventide.",'0')>Make Unpublish</a>";?> </span> </span>
           </div> 
           <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">          
               <span><label><b>Club Name:</b></label><?php echo $result_data[0]->name;?></span> 
           </div>
           </div> 
           </div>        
           <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3" style="margin: auto;text-align: center; margin-top:10px;"> 
                <table>
                   <tr>
                       <td>
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="padding-bottom: 10px; "> 
                             <input type="submit" value="Update" class="btn btn-default">
                            </div> 
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="padding-bottom: 10px;"> 
                             <a style="cursor:pointer;" data-toggle="modal" class="mClass btn btn-default" onclick="clearresult('<?php echo $eventide;?>', 'user')" data-target="#cnfrm_delete" title="delete">Clear all</i></a>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="padding-bottom: 10px;"> 
                             <input type="button" class="btn btn-default" onclick="editmode()" value="edit">
                            </div>
                       </td>
                       <td align="center">
                             <div style="float:left;text-align:center;width:100%;">
                              <?php $filename = 'uploads/'.$result_data[0]->liberation_url; if(file_exists($filename) && $result_data[0]->liberation_url!='') { ?>
                                 <img style="text-align:center;height:120px;width:auto;" src="<?php echo base_url().$filename;?>" alt="User profile picture12"> <br>
                                 Latitude : <?php echo $result_data[0]->Event_lat; ?> <br> Longitude : <?php echo $result_data[0]->Event_long; ?>
                                 <br> Time : <?php 
                                  //echo $result_data[0]->liberation_time;
                                   $liberation_time = strtotime($result_data[0]->liberation_time);
                                   $liberation_timeinfo = date( 'd-m-Y , h:i:s A', $liberation_time );
                                   echo $liberation_timeinfo; ?>
                             <?php } else { ?>
                              <img class="profile-user-img img-responsive img-circle" src="https://d30y9cdsu7xlg0.cloudfront.net/png/60716-200.png" alt="User profile picture">
                             <?php } ?> 
                             &nbsp;
                             &nbsp;&nbsp;&nbsp;
                            </div>
                       </td>
                   </tr>
                </table>
             </div>
           </div>
            </div>
          <!-- /.box-header -->
          <div class="box-body">
                  
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th width="2%">S.no</th>
                  <th width="13%">Name</th>
				          <th width="8%">Mobile Number</th>
                  <th width="9%">Club Name</th>
                  <th width="5%">Bird Category</th>
                  <th width="5%">Club/Owner Ring No</th>
                   <th width="7%">RFID Tag no</th>
                  <th width="5%">Bird Name</th>
                  <th width="5%">Bird Gender</th>
                  <th width="8%">Bird Color</th>
                  
                  <th width="5%">Outer No</th>
                  <th width="7%">Start Time</th>
                  <th width="5%">Board Date</th>
                  <th width="7%">Trap Time</th>
                  <th width="5%">Time Taken (min)</th>
                  <th width="5%">Distance (Km)</th>
                  <th width="5%">Velocity (Mt/min)</th>
                 
                  <th width="7%">Action</th>
                 <!-- <th width="6%">Longitude</th>  -->
                </tr>
              </thead>
              <tbody>
              </tbody> 
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
editval = 0;
var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
  $(document).ready(function() {  
    
    var table = $('#example1').DataTable({ 
          responsive: true,
          dom: 'lfBrtip',
          buttons: [
              'copy','print',
            {
                extend: 'excel',
                orientation: 'landscape',
                messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.'
            },
            {
                extend: 'pdf',
                orientation: 'landscape',
                messageBottom: null
            }
          ],
          "columnDefs": [
    { "orderable": false, "targets": 1 },
    {
                "targets": [ 3,7,10 ],
                "visible": false
    }
  ],
          "order": [[ 16, 'desc' ]],
          "processing": true,
          "serverSide": true,
          "scrollY": false,
          "scrollX": true,
          "ajax": {"url" : url+"user/resultsTable","data" : {"event":<?php echo $eventide;?>,"edit":editval} },
          "sPaginationType": "full_numbers",
          "language": {
            "processing":"<img style='width:150px; height:90px;' src='http://datainflow.com/wp-content/uploads/2017/09/loader.gif' />",
            "search": "_INPUT_", 
            "searchPlaceholder": "Search",
            "paginate": {
                "next": '<i class="fa fa-angle-right"></i>',
                "previous": '<i class="fa fa-angle-left"></i>',
                "first": '<i class="fa fa-angle-double-left"></i>',
                "last": '<i class="fa fa-angle-double-right"></i>'
            }
          }, 
          "iDisplayLength": 100,
          "aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"All"]]
      });
    
    setTimeout(function() {
      var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
      $('.table-date-range').css('right',add_width+'px');
      $('#example1_length').append('<label>&nbsp;&nbsp;&nbsp;<select onchange="changeracetype(this.value)" class="form-control input-sm"><option value="">Select Bird Type</option><?php foreach ( $birdinfo as $key=>$dis ) { ?><option value="<?php echo $dis->b_id;?>"><?php echo $dis->race_distance." - ".$dis->brid_type;?></option><?php } ?></select></label>'); 
        
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});
  });

  function changeresultstatus(ide,st)
{
  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/changeresultstatus",
    cache: false,   
    data: {'ide':ide,'status':st},
    success: function(json){  
      
      document.getElementById('resultstatus').innerHTML = json;
     //$('#example1').DataTable().ajax.reload( null, false );  
     
     }
    
    });

 
  
}  


function getinfo(val,ind) {
   
   document.getElementById("colortype"+ind).disabled = false;
   document.getElementById("gender"+ind).disabled = false;
   var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/getbasketbirdinfo",
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


$("#editresult").submit(function(e) {

    var newurl = "<?php echo base_url().'user/updateresult'?>"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: newurl,
           data: $("#editresult").serialize(), // serializes the form's elements.
           success: function(data)
           {
               editval = 0;
               var urlval = url+"user/resultsTable?editmode="+editval;
               $('#example1').DataTable().ajax.url( urlval ).load();
              // $('#example1').DataTable().ajax.reload( null, false );  
           }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});

function delete_report(reid) {

  $('#res').show();
  var newurl = "<?php echo base_url().'user/deletereport'?>";
  // body...
  $.ajax({
         type: "POST",
         url: newurl,
         data: {'report_id':reid}, // serializes the form's elements.
         success: function(data)
         {
            console.log(data);

            if(data == 1){
              $('#res').html("Result deleted sucessfully.");
              $('#example1').DataTable().ajax.reload( null, false );  
              $('#res').hide();
            }
            // $('#example1').DataTable().ajax.reload( null, false );  
         }
       });
}
function refreshtable()
{
  $('#example1').DataTable().ajax.reload( null, false );  
}
function editmode()
{
   
   editval = 1;
   var urlval = url+"user/resultsTable?editmode="+editval;
   $('#example1').DataTable().ajax.url( urlval ).load();
}
function changeracetype(types)
{
   var urlval = url+"user/resultsTable?birdtype="+types;
   $('#example1').DataTable().ajax.url( urlval ).load();
}
/*
buttons: [
        {
            extend: "print",
            customize: function(win)
            {
 
                var last = null;
                var current = null;
                var bod = [];
 
                var css = '@page { size: landscape; }',
                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                    style = win.document.createElement('style');
 
                style.type = 'text/css';
                style.media = 'print';
 
                if (style.styleSheet)
                {
                  style.styleSheet.cssText = css;
                }
                else
                {
                  style.appendChild(win.document.createTextNode(css));
                }
 
                head.appendChild(style);
         }
      },
],*/

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
  
</style>           