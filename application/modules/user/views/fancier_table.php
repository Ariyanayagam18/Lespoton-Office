<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
  <?php if($this->session->flashdata("messagePr")){?>
    <div class="alert alert-info">      
      <?php echo $this->session->flashdata("messagePr")?>
    </div>
  <?php } ?>
    <div id="deletefan">
      
    </div>      
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Fanciers</h3>
            <div class="box-tools">
            <?php if($this->session->userdata('user_details')[0]->user_type =='Admin' || $this->session->userdata('user_details')[0]->user_type =='admin') { ?>
             <button type="button" class="btn-sm  btn btn-success" onclick="add_app_admin()"><i class="glyphicon glyphicon-plus"></i> Add App Admin</button> <?php } ?>
             <button type="button" class="btn-sm  btn btn-success" onclick="pagerefresh('example1')"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">           
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable table-bordered nowrap" style="width:100%">
              <thead>
                <tr>
					<th>S.no</th>
					<th><input type="checkbox" name="selData[]" id="checkAll" class="checked_all"></th>
					<th>Name</th>
					<th>Contact No</th>
					<th>Address</th>
					<th>Account Status</th>
					<th>Loft Status</th>
					<th>Member Status</th>
          <th>Loft Image</th>
          <th>Device ID</th>
          <th>Device Status</th>
					<th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody> 
            </table>
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
<!-- Modal Crud Start-->
<div class="modal fade" id="fancierviewwindow" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize" style="text-align: center !important;">
        <h3 class="box-title">Fancier Details</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div><!--End Modal Crud --> 

<div class="modal fade" id="add_app_admin" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add App Admin</h4>
      </div>
      <div class="modal-body">
          <div class="error"></div>

               <form id="addform" name="addform" class="form-horizontal" method="post" action="<?php echo base_url();?>user/addappadmin" >
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="Name (Full name)">Name (Full name) <strong style="color: red">*</strong></label>
                      <div class="col-md-5">
                        <input id="name" name="name" type="text" class="form-control input-md">
                      </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label" for="Age">Club Name</label>
                       
                       <div class="col-md-5" id="rest_name" style="font-weight: bold;">
                         <select name="clubname" id="clubname" class="form-control input-sm">
                          <!-- <option value="">Select Club Name</option> -->
                         <?php foreach ( $getcompanylists as $key=>$lists ) { ?>
                             <option value="<?php echo $lists->Org_code;?>"><?php echo $lists->name;?></option>
                         <?php } ?>
                         </select>
                       </div>
                   </div>

                  <div class="form-group">
                      <label class="col-md-4 control-label" for="Age">Contact Number <strong style="color: red">*</strong></label>
                      <div class="col-md-5">
                          <input id="contact_number" name="contact_number" type="text" class="form-control input-md ">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-md-4 control-label" for="Age">Email<strong style="color: red">*</strong></label>
                      <div class="col-md-5">
                          <input id="email_id" name="email_id" type="email" class="form-control input-md ">
                      </div>
                  </div>
                 

                   <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-5">
                      <input type="submit" name="add_appadmin" class="btn btn-primary" id="add_appadmin" value="Save">
                      <input type="button" style="background-color:#0c1012; margin-right: 60px;color: white;" name="cancel_admin" class="btn btn-dark" id="cancel_admin" value="Cancel" data-dismiss="modal">
                      <!-- <input type="button" style="background-color:#cccccc; margin-right: 60px;" name="cancel_admin" class="btn btn-secondary close" id="cancel_admin" value="Cancel" data-dismiss="modal"> -->
                    </div>
                  </div>

                </form>
      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>

  </div>
</div>


<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

<script type="text/javascript">
function alertmsg(msg)
{
  toastr.error(msg, 'Lespoton');
}

$('#add_appadmin').click( function() 
{
  var name           = $('#name').val();
  var clubname       = $('#clubname').val();
  var contact_number = $('#contact_number').val();
  var email_id       = $('#email_id').val();

  if (name == "") 
  {
    alertmsg("Please Enter Name.");
    return false;
  }
  else if (clubname == "") 
  {
    alertmsg("Please Select Club Name.");
    return false;
  }
  else if (contact_number == "") 
  {
    alertmsg("Please Enter Contact Number.");
    return false;
  }
  else if (contact_number != "") 
  {
    var filter = /^\d*(?:\.\d{1,2})?$/;

     if (filter.test(contact_number)) 
     {
      if(contact_number.length != 10)
      {
        alertmsg("Please Enter 10  digit mobile number");
        return false;
      }
    }
    else 
    {
      alertmsg("Not a valid number");
      return false;
    }
  }
  if (email_id == "") 
  {
    alertmsg("Please Enter Email Id.");
    return false;
  }
  if (email_id != "") 
  {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var getEmail = regex.test(email_id)
    if (getEmail == false) 
    {
      alertmsg("Please Enter Correct Email");
      return false;
    }
  }
  $('#addform').submit();
  
});
var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
var clubid = '';

$(document).ready(function() 
{  
  var table = $('#example1').DataTable(
  { 
    // aaSorting: [[3, "asc"]],
    dom: 'lfBrtip',
    order: [[ 0, "desc" ]],
    responsive: true,
    buttons: [
      'copy', 'excel', 'pdf', 'print'
    ],
          
    "columnDefs": 
    [
      { "orderable": false, "targets": 1 },
      {
          "targets": [ 4 ],
          "visible": false
      },
      {
          "targets": [ 8 ],
          "visible": false
      }
    ],
    "processing": true,
    "serverSide": true,
    "ajax": url+"user/fancierTable",
    "sPaginationType": "full_numbers",
    "language": 
    {
      "processing":"<img style='width:150px; height:90px;' src='http://datainflow.com/wp-content/uploads/2017/09/loader.gif' />",
      "search": "_INPUT_", 
      "sLengthMenu": "Show _MENU_ Club",
      "searchPlaceholder": "Search",
      "paginate": 
      {
          "next": '<i class="fa fa-angle-right"></i>',
          "previous": '<i class="fa fa-angle-left"></i>',
          "first": '<i class="fa fa-angle-double-left"></i>',
          "last": '<i class="fa fa-angle-double-right"></i>'
      }
    }, 
    "iDisplayLength": 10,
    "aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"All"]]
  });
    
  setTimeout(function() 
  {
    var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
    $('.table-date-range').css('right',add_width+'px');
        
    <?php if($this->session->userdata('user_details')[0]->user_type =='Admin') { ?>
    $('.dataTables_length').before('<div style="margin-bottom:15px;"><table border=0 cellpadding=5 cellspacing=5 width=15%><tr><td style="padding:5px;"><button data-base-url="<?php echo base_url().'user/changestatusall/'; ?>" title=1 rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> Active all </i> </button></td><td style="padding:5px;"><button data-base-url="<?php echo base_url().'user/changestatusall/'; ?>" rel="delSelTable" title=0 class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> In Active all</i> </button></td><td><button class="btn btn-default btn-sm pull-left btn-blk-del" onclick="delete_fancier();"> Delete</i> </button></td></tr></table></div>');
    $('#example1_length').append('<label>&nbsp;&nbsp;&nbsp;<select onchange="getracesbycompany(this.value)" name="example1_length" class="form-control input-sm" id="clubtype"><option value="">Select Club Type</option><?php foreach ( $getcompanylists as $key=>$dis ) { ?><option value="<?php echo $dis->Org_code;?>"><?php echo $dis->name;?></option><?php } ?></select></label>');  
    <?php }else{
      ?>
      $('.dataTables_length').before('<div style="margin-bottom:15px;"><table border=0 cellpadding=5 cellspacing=5 width=15%><tr><td style="padding:5px;"><button data-base-url="<?php echo base_url().'user/changestatusall/'; ?>" title=1 rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> Active all </i> </button></td><td style="padding:5px;"><button data-base-url="<?php echo base_url().'user/changestatusall/'; ?>" rel="delSelTable" title=0 class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> In Active all</i> </button></td></tr></table></div>');
    <?php  
    } ?>
    }, 300);

    $("button.closeTest, button.close").on("click", function (){});
    new $.fn.dataTable.FixedHeader( table );

    $('#example1').on( 'length.dt', function ( e, settings, len ) {   // Per page change this one trigger
     $("#clubtype").val(clubid); 
    });


	 $("#merge_race_save").click(function () {
        
        var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
         $.ajax({
          type: "post",
          url: url+"user/deletefancier",
          cache: false,   
          data: {'event_val':val,'race_title':title},
          success: function(result){  
              console.log(result);    
           }
          
          });
    });

  });

function add_app_admin(){
    $("#add_app_admin").modal("show");
  }

  function delete_fancier() {
    // body...
    var myCheckboxes = new Array();
    $("input:checked").each(function() {
       myCheckboxes.push($(this).val());
    });
    if(myCheckboxes.length > 0){
      var result = confirm("Are you sure to delete selected users?");
      if(result){
          $.ajax({
            type: "post",
            url: url+"user/delete_fancier",
            cache: false,   
            data: {'ide':myCheckboxes},
            success: function(res){  
              console.log(res);
              if(res == ""){
                $("#deletefan").html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Fancier Deleted Successfully !!!</div>');
                $('#example1').DataTable().ajax.reload( null, false );

              }else{
                $("#deletefan").html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Fancier Deleted Error !!!</div>');
                $('#example1').DataTable().ajax.reload( null, false );
              }
            }    
          });
      }else{
          return false;
      }
  }else{

      alert('Select at least 1 record to delete.');
      return false;
    }
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

  function changetagstatus(ide,st)
  {
  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/changetagstatus",
    cache: false,   
    data: {'ide':ide,'status':st},
    success: function(json){  
      //$("#sendstatus").html = json;
     $('#example1').DataTable().ajax.reload( null, false );  
     
     }
    
    });
  }  

function changeadminstatus(ide,st)
{
  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/changeadminstatus",
    cache: false,   
    data: {'ide':ide,'status':st},
    success: function(json){  
      //$("#sendstatus").html = json;
     $('#example1').DataTable().ajax.reload( null, false );  
     
     }
    
    });
}  

function changeloftstatus(ide,st)
{
  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/changeloftstatus",
    cache: false,   
    data: {'ide':ide,'status':st},
    success: function(json)
    { 
      if (json == "loft_empty") 
      {
        alertmsg("Please Add Loft Image!.");
      } 
      else
      {
        $('#example1').DataTable().ajax.reload( null, false ); 
      }
       
     
     }
    
    });

}  


function getracesbycompany(types)
{
	clubid = types;
   	var urlval = url+"user/fancierTable?companytype="+types;
   	$('#example1').DataTable().ajax.url( urlval ).load();

}
</script>            