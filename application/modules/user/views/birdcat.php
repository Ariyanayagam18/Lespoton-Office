<?php ?>
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
            <h3 class="box-title">Pigeon Categories</h3>
            <div class="box-tools">
            </div>
          </div>
          <form id="editresult" method="post" action="<?php echo base_url().'user/updateresult'?>">
          <input type="hidden" name="eventide" value="<?php echo $eventide;?>">
          <div class="box-title width-side">
          <div class="row"> 
          <div class="col-lg-12">
           <div class="row siderow1">  
          <div class="col-lg-12"> 
              <table cellspacing="0" cellpadding="0" border="0" width="100%">
                   <tr>
                     <td align="center">
                        <table cellspacing="5" cellpadding="5" border="0" width="50%">
                             <tr>
                               <td align="right">
                                <span><label><b>Bird Category Name:</b></label></span>
                               </td>
                               <td>
                                <span><input id="birdname" class='form-control' type="text" name="birdname" value=""></span>
                               </td>
                               <td align="center">
                                 <button type="button" onclick="addeditcats()" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><span id="buttontext">ADD</span></button>
                               </td>
                               <td>
                                  <span id="updateresponse"></span>
                               </td>
                              </tr>
                        </table>
                     </td>
                   </tr>
              </table>
            </div>
          </div>
          
           </div>        
           
           </div>
            </div>
          <!-- /.box-header -->
          <div class="box-body">            
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th width="10%">S.no</th>
                  <th width="80%">Category Name</th>
				          <th width="10%">Action</th>
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
var updatebirdide = 0
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
    { "orderable": false, "targets": 1 }
  ],
          "processing": true,
          "serverSide": true,
          "ajax": {"url" : url+"user/birdcatTable","data" : {"ides":0} },
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
          "iDisplayLength": 10,
          "aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"All"]]
      });
    
    setTimeout(function() {
      var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
      $('.table-date-range').css('right',add_width+'px');
       
        
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});
  });

 

function addeditcats()
{
    var  birdname = $('#birdname').val();

    $.ajax({
    type: "post",
    url: url+"user/birdaddedit",
    cache: false,   
    data: {'birdname':birdname,'ide':updatebirdide},
    success: function(json){  
         updatebirdide = 0;
         $('#birdname').val('')
         $('#buttontext').html('ADD')
         $('#updateresponse').html('submitted details updated !!')
         $('#example1').DataTable().ajax.reload( null, false );  
     }
    
    });
}


function setbirdedit(ide,vals)
{
   $('#birdname').focus();
   $('#birdname').val(vals);
   $('#buttontext').html('UPDATE');
   updatebirdide = ide
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
  .table>tbody>tr>td {
  border: 1px solid #f4f4f4 !important;
  }
  
</style>           