<?php $eventide = $this->uri->segment(3);
$eventide = base64_decode(urldecode($eventide));

$birdtype = $this->db->query("SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type , race_distance , event_id  FROM `ppa_event_details` INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id where ppa_event_details.event_id='" .
                      $eventide . "'");
$birdinfo = $birdtype->result();


$select_fancier = $this->db->query("select * from ppa_register where apptype='".$result_data[0]->Org_code."'");
$select_fancierres = $select_fancier->result();

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
            <h3 class="box-title box-header-title">Live Race Results <span><?php echo $result_data[0]->Event_name;?></span><span><?php echo $result_data[0]->Event_date;?></span><span><?php echo $result_data[0]->name." ( ".$result_data[0]->Org_code." ) ";?>
              
              </span></h3>
            <div class="box-tools">
            <table border="0" cellpadding="5" cellspacing="5">
               <tr>
                 <!--<td><h3 class="box-title box-header-title">Select by fancier :</h3></td>
                 <td>&nbsp;&nbsp;</td>
                 <td><select class="form-control input-sm" onchange="changebyfancier(this.value)" id="fanciertype" name="fanciertype">
                  <option value="All">All fancier</option>
                 <?php foreach ($select_fancierres as $facnciers) { ?>
                  <option value="<?php echo $facnciers->username;?>"><?php echo $facnciers->username;?></option>
                 <?php } ?>
            </select></td>
                 <td>&nbsp;&nbsp;</td>
                 <td><h3 class="box-title box-header-title">Select photo type :</h3></td>
                 <td>&nbsp;&nbsp;</td>
                 <td><select class="form-control input-sm" onchange="changephototype(this.value)" id="phototype" name="phototype">
                <option value="All">All Photos</option>
                <option value="Approved">Approved Photos</option>
            </select></td>-->
                 <td>&nbsp;&nbsp;</td>
                 <td>
                  <?php $encrypt = urlencode(base64_encode($eventide)); ?>

                 <a style="cursor: pointer;" onclick="refreshtable();"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"> <i class="fa fa-refresh"></i>&nbsp;Refresh</button></a>

                 <a href="#"><button type="button"  onclick="togglePublish()"   class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;" value=''>
                 <i class="fa fa-print"></i> <span id="togglePublish" >
                  Publish </span> </button></a>

                 <a href="<?php echo base_url().'user/raceresults/'.$encrypt;?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="fa fa-eye"></i> View Results</button></a>

                 <a id="btnViewRow" class="modalracefancierview mClass"  href="javascript:;" type="button" data-src="<?php echo $eventide."#".$result_data[0]->Org_code;?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="fa fa-user"></i>&nbsp;Fancier Details</button></a>

                 </td>
               </tr>
            </table>
            </div> 
          </div>
          <!-- /.box-header -->

            <div class="box-title">

                  
                    <?php 
                    $optionhtml = '';
                    foreach ($racetypes as $racetypesrow)
                    {  
                      // John sir 
                        // $getraceinfo = $this->db->query("SELECT max(date) as maxi,MIN(date) as mini,start_time as start,ed_id FROM `ppa_event_details` WHERE event_id='".$eventide."' and bird_id = '".$racetypesrow->b_id."' and race_distance='".$racetypesrow->race_distance."'");
                      
                        $getraceinfo = $this->db->query("SELECT max(date) as maxi,MIN(date) as mini,start_time as start,ed_id FROM `ppa_event_details` WHERE event_id='".$eventide."' and bird_id = '".$racetypesrow->b_id."' and race_distance='".$racetypesrow->race_distance."' group by ed_id");
                                $racedetails = $getraceinfo->result();
                                $autoresults[] = "'".$racedetails[0]->ed_id."','".$racetypesrow->race_distance."-".$racetypesrow->brid_type."','".$racedetails[0]->maxi."','".$racedetails[0]->mini."','".$racedetails[0]->start."','".$racetypesrow->brid_type."','".$result_data[0]->Org_code."','".$result_data[0]->users_id."'";

                       
                      $optionhtml .= "<option value=\"".$racedetails[0]->ed_id.",".$racetypesrow->race_distance."-".$racetypesrow->brid_type.",".$racedetails[0]->maxi.",".$racedetails[0]->mini.",".$racedetails[0]->start.",".$racetypesrow->brid_type.",".$result_data[0]->Org_code.",".$result_data[0]->users_id."\">".$racetypesrow->race_distance."-".$racetypesrow->brid_type."</option>";
                      ?>
                     <!--<div id="<?php echo $racetypesrow->race_distance."-".$racetypesrow->brid_type;?>" class="col-lg-4 box-style" >
                       <div class="layoutbox">                         
                <div class="col-lg-6"><label>Schedule Date:</label></div><div class="col-lg-6"><p><?php echo $racedetails[0]->mini;?> to <?php echo $racedetails[0]->maxi;?> </p>
                                </div>
                                <div class="clearfix"></div>
              
                                <div class="col-lg-6"><label>Start Time:</label></div><div class="col-lg-6"><p><?php echo $racedetails[0]->start;?></p></div>
                                <div class="clearfix"></div>
                               <div class="col-lg-6"><label>Latitude & Longitude:</label></div><div class="col-lg-6"><p><?php echo $result_data[0]->Event_lat;?> & <?php echo $result_data[0]->Event_long;?> </p></div>
                               <div class="clearfix"></div>
                               
                                 <div class="col-lg-12" style="text-align: center; padding-top: 15px;"><input type="button" class="btn btn-default btn-active" value="<?php echo $racetypesrow->race_distance." - ".$racetypesrow->brid_type;?>" onclick="getresults('<?php echo $racedetails[0]->ed_id;?>','<?php echo $racetypesrow->race_distance."-".$racetypesrow->brid_type;?>','<?php echo $racedetails[0]->maxi;?>','<?php echo $racedetails[0]->mini;?>','<?php echo $racedetails[0]->start;?>','<?php echo $racetypesrow->brid_type;?>','<?php echo $result_data[0]->Org_code;?>','<?php echo $result_data[0]->users_id;?>')"><br><span style="padding-top:5px;cursor: pointer;">Click button to refresh</span></div>
                             <div class="clearfix"></div>
                              </div>       
                               </div>-->
                   <?php } ?>
              <!--<div class="row" style="margin:0;margin-left: 7px; margin-right: 7px;" ><select> <?php echo $optionhtml;?></select>-->
              </div>
              </div>
        <div class="row">

         <div class="col-lg-12">
          <div class="box-body">           
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th>S.no</th>
                  <th>Fancier name</th>
                  <th>Mobile</th>
                  <th>Image</th>
                  <th>Owner Ring Num</th>
                  <!-- <th> RFID Tag no</th> -->
                   <th> RFID Tag no</th> 
                  <th>Date</th>
                  <th>Time</th>
                  <th>Time Taken ( Min )</th>
                  <th>Distance (Km)</th>
                  <th>Velocity (Mt/Min)</th>
                  <th>Verify</th>
                  <th>Latitude</th>
               <th>Distance gap (Metres)</th> 
                  <th>Longitude</th>
                
                  <th>Action</th>
              
                  <!-- <th> RFID Tag no</th> -->
                
                <!-- <th> Outer Ring no</th> -->
                  
                </tr>
              </thead>
              <tbody>
              </tbody> 
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
<?php for ($i=1;$i<=10;$i++) { ?>
<div id="myModal<?php echo $i;?>" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<?php } ?>

<!-- Modal Crud Start-->
<div class="modal fade" id="racefancierdetails" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <h3 class="box-title">Race Fancier Details  ( Approved Photos only )</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div><!--End Modal Crud --> 


<script type="text/javascript">

var urls = '<?php echo base_url();?>';//$('.content-header').attr('rel');
var lastcallvals = '';
var phototypeval = 'All'
var fanciertypeval = 'All'

/*
bird_type YB
clubtype  3
event_id  10
evnt_distance 150-YB
lat 
lon 
times 12:00+AM
values  2018-7-11
values1 2018-7-12
org_id = 3
*/
function getresults11(ed_id,dist,end,start,sttime,birdtype,orgcode,orgid)
{

   document.getElementById("contentarea").innerHTML = '<table border="0" cellpadding="0" cellspacing="0" width="100%" height="500"><tr><td align="center" valign="middle"><img src="https://www.lespoton.com/portal/loadingAnimation.gif"></td></tr></table>'; 
   
   lastcallvals = ed_id+"$"+dist+"$"+end+"$"+start+"$"+sttime+"$"+birdtype+"$"+orgcode+"$"+orgid;

   var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/raceresult",
    cache: false,   
    data: {'bird_type':birdtype,'clubtype':orgid,'event_id':'<?php echo $eventide;?>','evnt_distance':dist,'lat':'<?php echo $result_data[0]->Event_lat;?>','lon':'<?php echo $result_data[0]->Event_long;?>','times':sttime,'values':start,'values1':end,'org_code':orgcode,'ed_id':ed_id,'phototypeval':phototypeval,'fanciertypeval':fanciertypeval},
    success: function(json){  
    document.getElementById("contentarea").innerHTML = json; 
     
     }
    
  });
}

//getresults(<?php echo $autoresults[0];?>)
function openmodel(ide)
{
  $('#myModal'+ide).modal('show');
}
function changebyfancier(vals){
   fanciertypeval = vals;
   var getvals = lastcallvals.split("$");
   getresults(getvals[0],getvals[1],getvals[2],getvals[3],getvals[4],getvals[5],getvals[6],getvals[7]);
}

function revertback(filenameval,raceide,type)
{
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/removeresultentry",
    cache: false,   
    data: {'raceide':raceide,'img':filenameval,'type':type},
    success: function(json){  
          $('#example1').DataTable().ajax.reload( null, false );  
     }
    
    });
}

function verify_report(ctype,uname,phno,image,chour,deviceid,interval,velocity,distance,lat,lang,row,eventide,eventdist,birdtype,ed_id)
{
   
   
   var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/addresultentry",
    cache: false,   
    data: {'ctype':ctype,'uname':uname,'phno':phno,'image':image,'chour':chour,'deviceid':deviceid,'interval':interval,'velocity':velocity,'distance':distance,'lat':lat,'lang':lang,'row':row,'eventide':eventide,'eventdist':eventdist,'birdtype':birdtype,'ed_id':ed_id},
    success: function(json){  
      
       if(json=='0')
       {
           //alert ("verified result not added ..Please try again.")
           document.getElementById('rowide'+row).innerHTML = "verified result not added ..Please try again.";

           //$("#responseinfo").html("verified result not added ..Please try again.");
       }
       else
       {
         // $('#myModal'+row).modal().hide();
         //alert ("verified result not added ..Please try again.")
         $('.modal.in').modal('hide') 
         document.getElementById('rowide'+row).innerHTML = '<font style=color:red;>Verified</font>';
         document.getElementById('verify_data'+row).style.display="none";
          $('#example1').DataTable().ajax.reload( null, false );  
         //$('#imageide'+row).removeAttr("data-target");
         //document.getElementById('imageide'+row).style = 'width: 50px; height: 50px; cursor: not-allowed';
         //$("#responseinfo").html("Verified result added successfully.");
       }

     
     }
    
    });

}

$(".content-wrapper").on("click",".modalracefancierview", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'user/race_fancierview',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#racefancierdetails').find('.modal-body').html(data);
      $('#racefancierdetails').modal('show'); 
    })
  });



</script>

<style>

 .image-source-link {
  color: #98C3D1;
}

.mfp-with-zoom .mfp-container,
.mfp-with-zoom.mfp-bg {
  opacity: 0;
  -webkit-backface-visibility: hidden;
  /* ideally, transition speed should match zoom duration */
  -webkit-transition: all 0.3s ease-out; 
  -moz-transition: all 0.3s ease-out; 
  -o-transition: all 0.3s ease-out; 
  transition: all 0.3s ease-out;
}

.mfp-with-zoom.mfp-ready .mfp-container {
    opacity: 1;
}
.mfp-with-zoom.mfp-ready.mfp-bg {
    opacity: 0.8;
}

.mfp-with-zoom.mfp-removing .mfp-container, 
.mfp-with-zoom.mfp-removing.mfp-bg {
  opacity: 0;
}

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
    .box-title.box-header-title span { 
     padding: 10px;
     font-weight: bold; 
     }
    .box-title.box-header-title span:first-child {
      color: #00c0ef;}
    .box-title.box-header-title span:last-child {
       color: #50AEAF;
    }
    .box-style label { 
     font-weight: bold !important;
         color: #50AEAF; 
     }  
    .box-style .layoutbox {
       padding: 15px;
       border: 3px solid #00c0ef;
       margin: 7px;
     }
    .box-style .col-lg-6 {padding: 0px;}
    .layoutbox .col-lg-6 label {
        margin-bottom: 0;
    }
    .layoutbox .col-lg-6 p {    
      text-align: left;
      margin: 0;
     }

    .box-style {padding-right: 0px; padding-left: 0px; }
    .clearfix{border-bottom: 1px solid #ccc;
        margin-bottom: 10px;
    }
     .clearfix:last-child {border-bottom:none;}
     .btn-active{ background: #00c0ef;
    color: #fff;
    border-color: #00c0ef;}
</style>  

<script src="<?php echo base_url('assets/js/lightcase.js');?>"></script>
<script type="text/javascript">
var delide = 0;
var editval = 0;
var currfancier = 0;
var currbird = 0;
var sendvals = "<?php echo $autoresults[0];?>";
var  fanide = "";
var phototypeval = 'All';
function setbasketId(id) {
 $('#basket_delete').modal('show'); 
 delide = id
}



var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
  $(document).ready(function() {  
    
    var table = $('#example1').DataTable({ 
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          "columns": [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { data: 3 },
            { data: 13 },
            { data: 14 },
            { data: 4},
            { data: 5 },
            { data: 6 },
            { data: 7 },
            { data: 8 },
            { data: 9 },
            { data: 10 },
            { data: 12 },
            { data: 11 },
            {data: 15},
            

        ],
          "columnDefs": [
    { "orderable": false, "targets": 1 },
    {
                "targets": [ 13, 15 ],
                "visible": false
    }
  ],
          "order": [[ 10, 'desc' ]],
          "processing": true,
          "serverSide": true,
          "scrollX": true,
          "ajax": {"url" : url+"user/viewresultssummary","data" : {"event":<?php echo $eventide;?>,"edit":editval,"resultvalue":"<?php echo $autoresults[0];?>","fanide":fanide,"phototypeval":phototypeval} },
          "sPaginationType": "full_numbers",
          "language": {
            "search": "_INPUT_",
            "sLengthMenu": "Show _MENU_ Select Fancier & Race Type", 
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
      $('#example1_length').append('<label>&nbsp;&nbsp;&nbsp;<select onchange="getresultbyfancier(this.value)" class="form-control input-sm" id="clubtype"><option value="">All Fancier</option><?php foreach ( $geteventfancierlists as $key=>$dis ) { ?><option value="<?php echo $dis->phone_no;?>"><?php echo trim($dis->username);?></option><?php } ?></select></label><label>&nbsp;&nbsp;&nbsp;<select onchange="changebybirdtype(this.value)" class="form-control input-sm" id="clubtype"><?php echo $optionhtml;?></select></label>&nbsp;&nbsp;&nbsp;<select class="form-control input-sm" onchange="changephototype(this.value)" id="phototype" name="phototype"><option value="All">All Photos</option><option value="Approved">Approved Photos</option></select>');
     

    }, 300);
    $("button.closeTest, button.close").on("click", function (){});
    

    $('#phototype').click(function() {
    if ($('#phototype').is(":checked"))
    {
       phototypeval = 'Approved';
    }
    else
    {
       phototypeval = 'All';
    }
    var eventides = '<?php echo $eventide;?>';
    var urlval = url+"user/viewresultssummary?event="+eventides+"&resultvalue1="+sendvals+"&fanide1="+fanide+"&phototypeval="+phototypeval;
    $('#example1').DataTable().ajax.url( urlval ).load();
});





  });

function delete_report(id)
{
  $.ajax({
    type: "post",
    url: url+"user/delete_ppa_files",
    cache: false,   
    data: {'id':id},
    success: function(json){  
     // console.log(info);return false;
      if(json!='0')
      {
        var eventides = '<?php echo $eventide;?>';
        var urlval = url+"user/viewresultssummary?event="+eventides;
          $('#example1').DataTable().ajax.url( urlval ).load();
      }

     }
    
    });
}
//$('.zoom-gallery').lightcase();
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

function changebybirdtype(vals)
{
   getvals = vals.split(",");
   sendvals = "'"+getvals[0]+"','"+getvals[1]+"','"+getvals[2]+"','"+getvals[3]+"','"+getvals[4]+"','"+getvals[5]+"','"+getvals[6]+"','"+getvals[7]+"'";
   
   var eventides = '<?php echo $eventide;?>';
   var urlval = url+"user/viewresultssummary?event="+eventides+"&resultvalue1="+sendvals+"&fanide1="+fanide+"&phototypeval1="+phototypeval;
   $('#example1').DataTable().ajax.url( urlval ).load();
}


function changephototype(vals){
   phototypeval = vals;
   //var getvals = lastcallvals.split("$");
   //getresults(getvals[0],getvals[1],getvals[2],getvals[3],getvals[4],getvals[5],getvals[6],getvals[7]);
   var eventides = '<?php echo $eventide;?>';
   var urlval = url+"user/viewresultssummary?event="+eventides+"&resultvalue1="+sendvals+"&fanide1="+fanide+"&phototypeval1="+phototypeval;
   $('#example1').DataTable().ajax.url( urlval ).load();
}


function getresults(ed_id,dist,end,start,sttime,birdtype,orgcode,orgid)
{
   
   sendvals = "'"+ed_id+"','"+dist+"','"+end+"','"+start+"','"+sttime+"','"+birdtype+"','"+orgcode+"','"+orgid+"'";
   var eventides = '<?php echo $eventide;?>';
   var urlval = url+"user/viewresultssummary?event="+eventides+"&resultvalue1="+sendvals+"&fanide1="+fanide;
   $('#example1').DataTable().ajax.url( urlval ).load();
}

function getresultbyfancier(ide)
{
   fanide = ide
   var eventides = '<?php echo $eventide;?>';
   var urlval = url+"user/viewresultssummary?event="+eventides+"&resultvalue1="+sendvals+"&fanide2="+fanide+"&phototypeval1="+phototypeval;
   $('#example1').DataTable().ajax.url( urlval ).load();


   //fanide = ide;
   //var getvals = lastcallvals.split("$");
   //getresults(getvals[0],getvals[1],getvals[2],getvals[3],getvals[4],getvals[5],getvals[6],getvals[7]);


}


function editmode()
{
   
   editval = 1;
   var urlval = url+"user/basketingTable?editmode="+editval;
   $('#example1').DataTable().ajax.url( urlval ).load();
}

function getentrybyfancier(types)
{
   currfancier = types
   if(currbird>0)
   var urlval = url+"user/viewbasketingTable?fanciertype="+types+"&btype="+currbird+"&event=<?php echo $eventide;?>";
   else
   var urlval = url+"user/viewbasketingTable?fanciertype="+types+"&event=<?php echo $eventide;?>";
   $('#example1').DataTable().ajax.url( urlval ).load();
 }

function getentrybybirdtype(types)
{
   currbird = types
   if(currfancier>0)
   var urlval = url+"user/viewbasketingTable?fanciertype="+currfancier+"&btype="+types+"&event=<?php echo $eventide;?>";
   else
   var urlval = url+"user/viewbasketingTable?btype="+types+"&event=<?php echo $eventide;?>";
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



// Ariyanayagam 11-10-2022 - 12-10-2022

function togglePublish()
{
     
     if($('#togglePublish')[0].innerText == 'Publish')
     {
      liveResultsPublish(1)
      $('#togglePublish')[0].innerText = 'Un Publish';
     }
     else
     {
      liveResultsPublish(0)
      $('#togglePublish')[0].innerText = 'Publish';
     }
}


function  liveResultsPublish(status)
{
  
   var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
    $.ajax({
        type: 'post',
        url: url+'user/liveResultsPublish',
        cache: false,
        data: {
            admin_approve : status
        },
        dataType: 'json',
        success: function(data) {
            console.log(data);
        }
});

}  



// Ariyanayagam 11-10-2022 - 12-10-2022



</script> 

<style>
 /* Style the Image Used to Trigger the Modal */
.myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
/*.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}
*/
/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
} 

div.gallery {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 210px;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    height: auto;
}
.modal-backdrop.fade.in {display: none;}

.table>tbody>tr>td {
    border: 1px solid #f4f4f4 !important;
}

</style>   

