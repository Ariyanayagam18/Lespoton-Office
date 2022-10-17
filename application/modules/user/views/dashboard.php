<?php
//print_r($facnierstats);
$recordcount = count($currentraces);
foreach ($facnierstats as $info)  { 
	$countarr[] = $info->cnt;
	$namearr[]  = $info->name;
}
?>

<style>
.card-no-border .card {
    border-color: #d7dfe3;
    border-radius: 4px;
    -webkit-box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
}
.card {
    -webkit-box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.1);
    box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}
.card {
    margin-bottom: 30px;
}
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
        border-top-color: rgba(0, 0, 0, 0.125);
        border-right-color: rgba(0, 0, 0, 0.125);
        border-bottom-color: rgba(0, 0, 0, 0.125);
        border-left-color: rgba(0, 0, 0, 0.125);
    border-radius: .25rem;
}
* {
    outline: none;
}
*, ::after, ::before {
    box-sizing: border-box;
}
.little-profile .pro-img {
    margin-top: -80px;
    margin-bottom: 20px;
}
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
            <h3 class="box-title">Dashboard</h3>
            <div class="box-tools">
             
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">   
              <div class="row">
               <?php if($this->session->userdata('user_details')[0]->user_type =='Admin') { ?>
                <!--<div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                       <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">No of Clubs</span>
                          <span class="info-box-number"><?php echo $clubcount;?></span>
                       </div>
                    </div>
                </div>-->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box bg-aqua">
                       <div class="inner">
                         <h3><?php echo $clubcount;?></h3>
                         <p>No of Clubs</p>
                       </div>
                       <div class="icon">
                         <i class="fa fa-users"></i>
                       </div>
                       <a href="<?php echo base_url();?>user/userTable" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
               <?php } ?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box bg-yellow">
                       <div class="inner">
                         <h3><?php echo $fanciercount;?></h3>
                         <p>No of Fanciers</p>
                       </div>
                       <div class="icon">
                         <i class="fa fa-user"></i>
                       </div>
                       <a href="<?php echo base_url();?>user/fancier" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box bg-red">
                       <div class="inner">
                         <h3><?php echo $racecount;?></h3>
                         <p>No of Races</p>
                       </div>
                       <div class="icon">
                         <i class="fa fa-twitter"></i>
                       </div>
                       <a href="<?php echo base_url();?>user/races" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12" hidden>
                    <div class="small-box bg-green">
                       <div class="inner">
                         <h3><?php echo $livecount;?></h3>
                         <p>Live Races</p>
                       </div>
                       <div class="icon">
                         
                       </div>
                       <a href="<?php echo base_url();?>user/live" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12" hidden>
                    <div class="small-box bg-orange">
                       <div class="inner">
                         <h3><?php echo $upcomingcount;?></h3>
                         <p>Upcoming Races</p>
                         
                       </div>
                       <div class="icon">
                         
                       </div>
                       <a href="<?php echo base_url();?>user/upcoming" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12" hidden>
                    <div class="small-box bg-blue">
                       <div class="inner">
                         <h3><?php echo $completedcount;?></h3>
                         <p>Completed Races</p>
                       </div>
                       <div class="icon">
                         
                       </div>
                       <a href="<?php echo base_url();?>user/completed" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                
              </div>
              <div class="row">
                  <div class="box-header with-border">
                    <div class="box-tools"></div>
                  </div><br>
                  <div class="col-md-6">
                       <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                  </div>
                  <?php if($this->session->userdata('user_details')[0]->user_type =='Admin') { ?>
                  <div class="col-md-6">
                       <div id="piechartContainer" style="height: 370px; width: 100%;"></div>
                  </div>
                  <?php } ?>
              </div>
              <div class="row">
                  <div class="box-header with-border">
                    <div class="box-tools"></div>
                  </div>
              </div><br>
              <div class="row">
                   <div class="col-md-6">
                    <!-- Start -->
                         <div class="box box-info">
                           <div class="box-header with-border">
              <h3 class="box-title">This Week Races</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Race Name</th>
                    <th>club Name</th>
                    <th>Race Date</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $recordcount = count($currentraces);
                     //echo "<pre>";print_r($currentraces);
                    if($recordcount>0) {
                    foreach ($currentraces as $raceinfo)  { 


                        $timezone = "Asia/Kolkata";
                        date_default_timezone_set($timezone);
                        $curdate = date("Y-m-d");
                        ?>
                  <tr>
                    <?php $encrypt_one = urlencode(base64_encode($raceinfo->Events_id)); ?>
                    <td><a href="<?php echo base_url();?>events/editrace/<?php echo $encrypt_one;?>"><?php echo $raceinfo->Event_name;?></a></td>
                    <td><?php echo $raceinfo->name;?></td>
                    <td>
                      <?php echo $raceinfo->Event_date;?>
                    </td>
                    <?php if(trim($raceinfo->Event_date>$curdate)) { 
                     
                      //echo $raceinfo->Event_date>$curdate;
                      ?>
                    <td><span class="label label-info">Upcoming</span></td>
                    <?php } else if(trim($raceinfo->Event_date==$curdate)) { ?>
                    <td><span class="label label-success">LIVE</span></td>
                    <?php } else { ?>
                    <td><span class="label label-danger">Completed</span></td>
                    <?php }  ?>
                  </tr>
                  <?php } } else { ?>
                  <tr>
                    <td colspan="4" align="center">No races available this week</td>
                  </tr>
                  <?php } ?>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?php echo base_url();?>events/addrace" class="btn btn-sm btn-info btn-flat pull-left">Create New Race</a>
              <a href="<?php echo base_url();?>user/races" class="btn btn-sm btn-default btn-flat pull-right">View All races</a>
            </div>
            <!-- /.box-footer -->
          </div>
                    <!-- End -->
              </div>

               <div class="col-md-3">
                     <!-- /.Last race Results start -->
                      <div class="box box-info">
                           <div class="box-header with-border">
              <h3 class="box-title">Last Race Results</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Position</th>
                    <th>Event Name</th>
                    <th>Name</th>
                    <th>Velocity</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $recordcount = count($lastresult);$i=1;

                    //echo "<pre>";print_r($recordcount);
                    if($recordcount>0) {
                    foreach ($lastresult as $resultinfo)  { 
                        $eventide = $resultinfo->event_id;
                        if($i==1)
                        $winnername = $resultinfo->name;
                        $timezone = "Asia/Kolkata";
                        date_default_timezone_set($timezone);
                        $curdate = date("Y-m-d");
                        ?>
                  <tr>
                    <td><?php echo $i;?></a></td>
                    <td><?php echo $resultinfo->Event_name;?></td>
                    <td><?php echo $resultinfo->name;?></td>
                    <td>
                      <?php echo $resultinfo->velocity;?>
                     
                    </td>
                    
                  </tr>
                  <?php $i++;} } else { ?>
                  <tr>
                    <td colspan="4" align="center">No races available this week</td>
                  </tr>
                  <?php } ?>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <?php $encrypt = urlencode(base64_encode($eventide)); ?>
               <a href="<?php echo base_url();?>user/raceresults/<?php echo $encrypt;?>" class="btn btn-sm btn-default btn-flat pull-right">View All Results</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.Last race Results end -->
               </div>
               <div class="col-md-3">
                      <div class="card"> <img class="" src="https://wrappixel.com/demos/admin-templates/material-pro/assets/images/background/profile-bg.jpg" alt="Card image cap">
                            <div class="card-body little-profile text-center">
                                <div class="pro-img"><img width="100" height="100" src="<?php echo base_url().'assets/images/'.$resultinfo->img_name;?>"  alt="user"></div>
                                <h3 class="m-b-0"><?php echo $winnername;?></h3>
                                <p>WINNER</p>
                                <!-- <p><small>Lorem ipsum dolor sit amet, this is a consectetur adipisicing elit</small></p> <a href="javascript:void(0)" class="m-t-10 waves-effect waves-dark btn btn-primary btn-md btn-rounded">Follow</a>
                                <div class="row text-center m-t-20">
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h3 class="m-b-0 font-light">1099</h3><small>Articles</small></div>
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h3 class="m-b-0 font-light">23,469</h3><small>Followers</small></div>
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h3 class="m-b-0 font-light">6035</h3><small>Following</small></div>
                                    <div class="col-md-12 m-b-10"></div>
                                </div>-->
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
<?php
//SELECT YEAR(Event_date) as yr,COUNT(*) as cnt FROM `ppa_events` WHERE 1 GROUP BY YEAR(Event_date) 

// SELECT apptype,COUNT(*) as cnt,(SELECT COUNT(*) FROM `ppa_register` WHERE 1) as tocont,((cnt/tocont)*100) as per FROM `ppa_register` WHERE 1 GROUP BY apptype
if($this->session->userdata('user_details')[0]->user_type =='Admin')
$whereqry = " 1";
else
$whereqry = " Org_id=".$this->session->userdata ('user_details')[0]->users_id;

$racestqry = $this->db->query("SELECT YEAR(Event_date) as yr,COUNT(*) as cnt FROM `ppa_events` WHERE ".$whereqry." GROUP BY YEAR(Event_date)");
$racestats = '';
foreach ($racestqry->result() as $row) {
  $racestats .= '{ label: "'.$row->yr.'",  y: '.$row->cnt.'  },';
}

$fancierqry = $this->db->query("SELECT apptype,(COUNT(*)/(SELECT COUNT(*) FROM `ppa_register` WHERE 1))*100 as per FROM `ppa_register` WHERE 1 GROUP BY apptype");
$fancierstats = '';
foreach ($fancierqry->result() as $row1) {
  $fancierstats .= '{ y: '.$row1->per.',  name: "'.$row1->apptype.'"  },';
}

//echo $racestats;
/*$fancierstats = '{ y: 20, name: "PPA" },
      { y: 34, name: "GPRS" },
      { y: 44, name: "AHMC" },
      { y: 12, name: "IBM" }';*/
      
?>
 <script>
window.onload = function () {

//Better to construct options first and then pass it as a parameter
var options = {
  title: {
    text: "Race Statistics"              
  },
  data: [              
  {
    // Change type to "doughnut", "line", "splineArea", etc.
    type: "column",
    dataPoints: [
      <?php echo $racestats;?>
    ]
  }
  ]
};

$("#chartContainer").CanvasJSChart(options);

var options = {
  exportEnabled: true,
  animationEnabled: true,
  title:{
    text: "Fanciers"
  },
  legend:{
    horizontalAlign: "right",
    verticalAlign: "center"
  },
  data: [{
    type: "pie",
    showInLegend: true,
    toolTipContent: "<b>{name}</b>: {y} (#percent%)",
    indexLabel: "{name}",
    legendText: "{name} (#percent%)",
    indexLabelPlacement: "inside",
    dataPoints: [
      <?php echo $fancierstats;?>
    ]
  }]
};
$("#piechartContainer").CanvasJSChart(options);




}
</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
