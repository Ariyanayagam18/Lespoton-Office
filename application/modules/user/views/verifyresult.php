<link rel="stylesheet" type="text/css" href="http://edison.github.io/leroy-zoom/css/jquery.leroy-zoom.min.css">   
<script src="http://edison.github.io/leroy-zoom/js/jquery.leroy-zoom.min.js" type="text/javascript"></script>
<style>
* {box-sizing: border-box;}

.img-magnifier-container {
  position:relative;
}

.img-magnifier-glass {
  position: absolute;
  border: 3px solid #000;
  border-radius: 50%;
  cursor: none;
  /*Set the size of the magnifier glass:*/
  width: 120px;
  height: 120px;
}
</style>
<script>
function magnify(imgID, zoom) {
  var img, glass, w, h, bw;
  img = document.getElementById(imgID);
  /*create magnifier glass:*/
  glass = document.createElement("DIV");
  glass.setAttribute("class", "img-magnifier-glass");
  /*insert magnifier glass:*/
  img.parentElement.insertBefore(glass, img);
  /*set background properties for the magnifier glass:*/
  glass.style.backgroundImage = "url('" + img.src + "')";
  glass.style.backgroundRepeat = "no-repeat";
  glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
  bw = 3;
  w = glass.offsetWidth / 2;
  h = glass.offsetHeight / 2;
  /*execute a function when someone moves the magnifier glass over the image:*/
  glass.addEventListener("mousemove", moveMagnifier);
  img.addEventListener("mousemove", moveMagnifier);
  /*and also for touch screens:*/
  glass.addEventListener("touchmove", moveMagnifier);
  img.addEventListener("touchmove", moveMagnifier);
  function moveMagnifier(e) {
    var pos, x, y;
    /*prevent any other actions that may occur when moving over the image*/
    e.preventDefault();
    /*get the cursor's x and y positions:*/
    pos = getCursorPos(e);
    x = pos.x;
    y = pos.y;
    /*prevent the magnifier glass from being positioned outside the image:*/
    if (x > img.width - (w / zoom)) {x = img.width - (w / zoom);}
    if (x < w / zoom) {x = w / zoom;}
    if (y > img.height - (h / zoom)) {y = img.height - (h / zoom);}
    if (y < h / zoom) {y = h / zoom;}
    /*set the position of the magnifier glass:*/
    glass.style.left = (x - w) + "px";
    glass.style.top = (y - h) + "px";
    /*display what the magnifier glass "sees":*/
    glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
  }
  function getCursorPos(e) {
    var a, x = 0, y = 0;
    e = e || window.event;
    /*get the x and y positions of the image:*/
    a = img.getBoundingClientRect();
    /*calculate the cursor's x and y coordinates, relative to the image:*/
    x = e.pageX - a.left;
    y = e.pageY - a.top;
    /*consider any page scrolling:*/
    x = x - window.pageXOffset;
    y = y - window.pageYOffset;
    return {x : x, y : y};
  }
}
</script>

<?php $eventide = $this->uri->segment(3);


$birdtype = $this->db->query("SELECT DISTINCT ppa_bird_type.b_id,ppa_bird_type.brid_type , race_distance , event_id  FROM `ppa_event_details` INNER JOIN ppa_bird_type ON ppa_event_details.bird_id=ppa_bird_type.b_id where ppa_event_details.event_id='" .
                      $eventide . "'");
$birdinfo = $birdtype->result();

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
            <h3 class="box-title box-header-title">Verify Race Results <span><?php echo $result_data[0]->Event_name;?></span><span><?php echo $result_data[0]->Event_date;?></span><span><?php echo $result_data[0]->name." ( ".$result_data[0]->Org_code." ) ";?></span></h3>
            <div class="box-tools">
            <a href="<?php echo base_url().'user/raceresults/'.$eventide;?>"><button type="button" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><i class="fa fa-eye"></i> View Results</button></a>
            </div> 
          </div>
          <!-- /.box-header  <hr style="margin-bottom: 4px;"> -->

            
               
         <div class="row">
         <div class="row"> 
          <div class="col-md-12">
           <table border="0" class="fontinfo" cellspacing="0" cellpadding="0" width="100%">
              <tr><td><b>&nbsp;</b></td></tr>
              <tr>
                  <td width="2%"></td>
                  <td width="13%">
                     <table cellspacing="0" cellpadding="0">
                       <tr><td><b>Select Fancier:</b></td></tr>
                       <tr>
                          <td>
                              <select onchange="restoredefault()" name="fancieride" id="fancieride" class="form-control input-sm">
                              <?php ?>
                              <option value="">Select Fancier</option>
                              <option value="0">All</option>
                              <?php foreach ($geteventfancierlists as $fancierlist) { ?>
                              <option value="<?php echo $fancierlist->phone_no;?>"><?php echo $fancierlist->username;?></option>
                              <?php } ?>
                              </select>
                          </td>
                       </tr>
                     </table>
                  </td>
                  <td width="11%">
                     <table cellspacing="0" cellpadding="0">
                       <tr><td><b>Select Race category:</b></td></tr>
                       <tr>
                          <td>
                              <select onchange="fetchresult(this.value)" name="birdtypes" id="birdtypes" class="form-control input-sm"><option value="">Select Race category</option><?php foreach ($racetypes as $racetypesrow) { 
                                 $getraceinfo = $this->db->query("SELECT max(date) as maxi,MIN(date) as mini,start_time as start,ed_id FROM `ppa_event_details` WHERE event_id='".$eventide."' and bird_id = '".$racetypesrow->b_id."' and race_distance='".$racetypesrow->race_distance."'");
                                $racedetails = $getraceinfo->result();
                                ?><option value="<?php echo $racetypesrow->race_distance."-".$racetypesrow->brid_type."#".$racedetails[0]->maxi."#".$racedetails[0]->mini."#".$racedetails[0]->start."#".$racetypesrow->brid_type."#".$result_data[0]->Org_code."#".$result_data[0]->users_id."#".$racedetails[0]->ed_id;?>"><?php echo $racetypesrow->race_distance." - ".$racetypesrow->brid_type;?></option><?php } ?></select>
                          </td>
                       </tr>
                     </table>
                  </td>
                  <td width="14%" align="left" valign="bottom">
                      <table cellspacing="0" cellpadding="0">
                       <tr><td><input type="checkbox" class="form-group" name="phototype" id="phototype" value="Approved"></td><td>&nbsp;&nbsp;&nbsp;<b>Approved photos only</b></td></tr>
                      </table>
                  </td>
                  <td width="60%" align="left">
                     
                  </td>
              </tr>
               <tr><td><b>&nbsp;</b></td></tr>
           </table>
            </div>        
          
           </div>
         <div class="col-lg-12">
          <div class="box-body col-xs-12" id="contentarea">           
               <table width="100%" height="300" cellspacing="5" cellpadding="5" border="0"><tbody><tr><td style="font-size:20px;color:red;" align="center">Please choose fancier and race category to review result...</td></tr></tbody></table>
          </div> 
          <!--<div class="box-body col-xs-1">
            <table id="customers" border="0" cellpadding="5" cellspacing="5" width="100%">
               <tr><th>Fanciers List</th></tr>
               <?php foreach ($geteventfancierlists as $fancierlist) { ?>
               <tr>
                 <td><?php echo ucfirst($fancierlist->username);?></td>
               </tr>
               <?php } ?>
            </table>
          </div>-->
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
<img src="<?php echo base_url();?>assets/images/load.gif" style="display:none;height:35px;width:35px;"> 
<script type="text/javascript">
var urls = '<?php echo base_url();?>';//$('.content-header').attr('rel');
var phototypeval = 'All';
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
function fetchresult(vals)
{
   if($("#fancieride").val()=="")
   {
     alert("Please select proper fancier to get results")
   }
   else if(vals!='') {
   var info = vals.split('#')
   //console.log(info);
   getresults(info[0],info[1],info[2],info[3],info[4],info[5],info[6],info[7])
   }
   else
   {
     alert("Please select proper race event to get results")
   }
}
function restoredefault()
{
  
  document.getElementById("birdtypes").value = '';
  document.getElementById("contentarea").innerHTML = '<table width="100%" height="300" cellspacing="5" cellpadding="5" border="0"><tbody><tr><td style="font-size:20px;color:red;" align="center">Please choose fancier and race category to review result...</td></tr></tbody></table>';
}

$('#phototype').click(function() {
    if ($('#phototype').is(":checked"))
    {
       phototypeval = 'Approved';
    }
    else
    {
       phototypeval = 'All';
    }

});

function getresults(dist,end,start,sttime,birdtype,orgcode,orgid,edid)
{
   var phoneno = document.getElementById("fancieride").value
   var url = '<?php echo base_url();?>';
   
   document.getElementById("contentarea").innerHTML = '<table border="0" cellpadding="0" cellspacing="0" width="100%" height="500"><tr><td align="center" valign="middle"><img src="'+url+'assets/images/load.gif"></td></tr></table>'; 
   var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/verifyphotos",
    cache: false,   
    data: {'phoneno':phoneno,'bird_type':birdtype,'clubtype':orgid,'event_id':'<?php echo $eventide;?>','evnt_distance':dist,'lat':'<?php echo $result_data[0]->Event_lat;?>','lon':'<?php echo $result_data[0]->Event_long;?>','times':sttime,'values':start,'values1':end,'org_code':orgcode,'event_details_id':edid,'phototypeval':phototypeval},
    success: function(json){  
    document.getElementById("contentarea").innerHTML = json;    
             setTimeout(function(){
                 //callagain();
              }, 2000);
     }
    
  });
}

function callagain()
{
  for(var t=0;t<=100;t++)
       {
         if(document.getElementById("imageide"+t))
          {           
             var imide = "imageide"+t;
             magnify(imide, 4);
          }
       }
}

//getresults(<?php echo $autoresults[0];?>)
function openmodel(ide)
{
  $('#myModal'+ide).modal('show');
}
function verify_report(ctype,uname,phno,image,chour,deviceid,interval,velocity,distance,lat,lang,row,eventide,eventdist,birdtype,edid)
{
   var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   var loading = '<img src="'+url+'assets/images/load.gif" style="height:35px;width:35px;">'
   var curcont = document.getElementById('buttonarea'+row).innerHTML
   document.getElementById('buttonarea'+row).innerHTML = loading;

   var buthtml = "<a onclick=\"remove_report('"+ctype+"','"+uname+"','"+phno+"','"+image+"','"+chour+"','"+deviceid+"','"+interval+"','"+velocity+"','"+distance+"','"+lat+"','"+lang+"','"+row+"','"+eventide+"','"+eventdist+"','"+birdtype+"','"+edid+"')\"><button style=\"cursor: pointer;background-color:red;border-color:red;color:white;\" type=\"button\" class=\"btn-sm btn\" data-toggle=\"modal\">Decline</button></a>";
   $.ajax({
    type: "post",
    url: url+"user/addresultentry",
    cache: false,   
    data: {'ctype':ctype,'uname':uname,'phno':phno,'image':image,'chour':chour,'deviceid':deviceid,'interval':interval,'velocity':velocity,'distance':distance,'lat':lat,'lang':lang,'row':row,'eventide':eventide,'eventdist':eventdist,'birdtype':birdtype,'ed_id':edid},
    success: function(json){  
      
       if(json=='0')
       {
          document.getElementById('buttonarea'+row).innerHTML = curcont;
       }
       else
       {
          document.getElementById('buttonarea'+row).innerHTML = buthtml;
       }

     
     }
    
    });

}


function remove_report(ctype,uname,phno,image,chour,deviceid,interval,velocity,distance,lat,lang,row,eventide,eventdist,birdtype,edid)
{
   var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   var loading = '<img src="'+url+'assets/images/load.gif" style="height:35px;width:35px;">'
   var curcont = document.getElementById('buttonarea'+row).innerHTML
   document.getElementById('buttonarea'+row).innerHTML = loading;
   var buthtml = "<a onclick=\"verify_report('"+ctype+"','"+uname+"','"+phno+"','"+image+"','"+chour+"','"+deviceid+"','"+interval+"','"+velocity+"','"+distance+"','"+lat+"','"+lang+"','"+row+"','"+eventide+"','"+eventdist+"','"+birdtype+"','"+edid+"')\"><button style=\"cursor: pointer;\" type=\"button\" class=\"btn-sm  btn btn-success\" data-toggle=\"modal\">Approve</button></a>";
   $.ajax({
    type: "post",
    url: url+"user/removeresultentry",
    cache: false,   
    data: {'img':image},
    success: function(json){  
      
       if(json=='1')
       {
           document.getElementById('buttonarea'+row).innerHTML = buthtml;
      }
       else
       {
           document.getElementById('buttonarea'+row).innerHTML = curcont;
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

div.desc {
    padding: 15px;
    text-align: center;
}
</style>
