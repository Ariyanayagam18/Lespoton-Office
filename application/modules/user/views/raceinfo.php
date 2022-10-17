<?php $eventide = $this->uri->segment(3);


$birdtype = $this->db->query("SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type , race_distance , event_id  FROM `ppa_event_details` INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id where ppa_event_details.event_id='" .
                      $eventide . "'");
$birdinfo = $birdtype->result();


$select_fancier = $this->db->query("select * from ppa_register where apptype='".$result_data[0]->Org_code."'");
$select_fancierres = $select_fancier->result();

?>
<style>
#customers {
    font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
    border-collapse: collapse;
    
}
.disp
{
 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
 color:#3c8dbc;
 font-size:16px;
 font-weight: bold;
}
.pageno
{
 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
 color:#FFFFFF;
 background-color:#3c8dbc;
 padding:2px;
 font-size:13px;
 width:20px;
 height:20px;
 text-align:center;
 font-weight: bold;
}
.curpageno
{
 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
 color:#50AEAF;
 border:1px solid #3c8dbc;
 background-color:#ffffff;
 padding:2px;
 font-size:13px;
 width:20px;
 height:20px;
 text-align:center;
 font-weight: bold;
}

#customers td, #customers th , #example1 td ,#example1 th, #example td ,#example th  {
    border: 1px solid #3c8dbc;
        padding: 4px;
        font-size: 14px;
    white-space: nowrap;
}

#customers tr:nth-child(even){background-color: #ffffff;}

#customers tr:hover {background-color: #f2f2f2;}

#customers th {
    padding-top: 10px;
    padding-bottom: 10px;
    text-align: left;
    background-color: #3c8dbc;
    color: white;
    white-space: nowrap;
        font-size: 17px;
}
/*Radio box*/

input[type="radio"] + .label-text:before{
  content: "\f10c";
  font-family: "FontAwesome";
  speak: none;
  font-style: normal;
  font-weight: normal;
  font-variant: normal;
  text-transform: none;
  line-height: 1;
  -webkit-font-smoothing:antialiased;
  width: 1em;
  display: inline-block;
  margin-right: 5px;
  }

input[type="radio"]:checked + .label-text:before{
  content: "\f192";
  color: #8e44ad;
  animation: effect 250ms ease-in;
  }

input[type="radio"]:disabled + .label-text{
  color: #aaa;
  }

input[type="radio"]:disabled + .label-text:before{
  content: "\f111";
  color: #ccc;
  }
label{
  position: relative;
  cursor: pointer;
  color: #666;
  font-size: 15px;
  }

input[type="radio"]{
  position: absolute;
  right: 9000px;
  }
.image_resizing img {
  width:auto;
  height:460px;
  margin: auto;
}
.zoomContainer {z-index: 10000;}  
</style>
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
                 <td><h3 class="box-title box-header-title">Select by fancier :</h3></td>
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
            </select></td>
                 <td>&nbsp;&nbsp;</td>
                 <td><a href="<?php echo base_url().'user/raceresults/'.$eventide;?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="fa fa-eye"></i> View Results</button></a></td>
               </tr>
            </table>
            </div> 
          </div>
          <!-- /.box-header -->

            <div class="box-title">

                  <div class="row" style="margin:0;margin-left: 7px; margin-right: 7px;" >
                    <?php foreach ($racetypes as $racetypesrow)
                    { ?>
                     <div id="<?php echo $racetypesrow->race_distance."-".$racetypesrow->brid_type;?>" class="col-lg-4 box-style" >
                       <div class="layoutbox">
                           <?php 
                               $getraceinfo = $this->db->query("SELECT max(date) as maxi,MIN(date) as mini,start_time as start,ed_id FROM `ppa_event_details` WHERE event_id='".$eventide."' and bird_id = '".$racetypesrow->b_id."' and race_distance='".$racetypesrow->race_distance."'");
                                $racedetails = $getraceinfo->result();
                                $autoresults[] = "'".$racedetails[0]->ed_id."','".$racetypesrow->race_distance."-".$racetypesrow->brid_type."','".$racedetails[0]->maxi."','".$racedetails[0]->mini."','".$racedetails[0]->start."','".$racetypesrow->brid_type."','".$result_data[0]->Org_code."','".$result_data[0]->users_id."'";
                              ?>
                                <!--<div class="col-lg-6"><label>Bird Type:</label></div><div class="col-lg-6"><p><?php echo $racetypesrow->brid_type;?></p></div>
                                <div class="clearfix"></div>-->
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
                               </div>
                   <?php } ?>
            
              </div>
              </div>
               <hr style="margin-bottom: 4px;">
         <div class="row">
         <div class="col-lg-12">
          <div class="box-body" id="contentarea">           
             
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
function getresults(ed_id,dist,end,start,sttime,birdtype,orgcode,orgid)
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

getresults(<?php echo $autoresults[0];?>)
function openmodel(ide)
{
  $('#myModal'+ide).modal('show');
}

function changephototype(vals){
   phototypeval = vals;
   var getvals = lastcallvals.split("$");
   getresults(getvals[0],getvals[1],getvals[2],getvals[3],getvals[4],getvals[5],getvals[6],getvals[7]);
}
function changebyfancier(vals){
   fanciertypeval = vals;
   var getvals = lastcallvals.split("$");
   getresults(getvals[0],getvals[1],getvals[2],getvals[3],getvals[4],getvals[5],getvals[6],getvals[7]);
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
           document.getElementById('responseinfo').innerHTML = "verified result not added ..Please try again.";
           //$("#responseinfo").html("verified result not added ..Please try again.");
       }
       else
       {
         // $('#myModal'+row).modal().hide();
         //alert ("verified result not added ..Please try again.")
         $('.modal.in').modal('hide') 
         document.getElementById('rowide'+row).style = 'background-color:#87CEFF' 
         //$('#imageide'+row).removeAttr("data-target");
         //document.getElementById('imageide'+row).style = 'width: 50px; height: 50px; cursor: not-allowed';
         //$("#responseinfo").html("Verified result added successfully.");
       }

     
     }
    
    });

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