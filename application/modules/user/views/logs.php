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
            <h3 class="box-title">System Logs</h3>
            <div class="box-tools">
             </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">           
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                 <tr>
                  <th width="5%">S.no</th>
									<th width="10%">Action</th>
									<th width="60%">Description</th>
                  <th width="5%">IP</th>
                  <th width="5%">Modified By</th>
                  <th width="15%">Date</th>
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



<script type="text/javascript">
  var clubid = 0;
  var logtype = '';
  $(document).ready(function() { 

    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
    var table = $('#example1').DataTable({ 
          dom: 'lfBrtip',
          "order": [[ 0, 'DESC' ]],
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          "processing": true,
          "serverSide": true,
          "ajax": url+"user/systemTable",
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
      $('#example1_length').append('<label>&nbsp;&nbsp;&nbsp;<select onchange="getlogsbycompany(this.value)" class="form-control input-sm" id="clubtype"><option value="">Select Club Type</option><?php foreach ( $getcompanylists as $key=>$dis ) { ?><option value="<?php echo $dis->users_id;?>"><?php echo $dis->name;?></option><?php } ?></select>&nbsp;&nbsp;&nbsp;<select onchange="getlogsbytype(this.value)" class="form-control input-sm" id="clubtype"><option value="">Select Log Type</option><?php foreach ( $logtypes as $key=>$typo ) { ?><option value="<?php echo $typo->action;?>"><?php echo $typo->action;?></option><?php } ?></select></label>'); 

        //$('.dataTables_info').before('<button data-base-url="<?php echo base_url().'user/delete/'; ?>" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> <i class="fa fa-trash"></i> </button><br><br>');  
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});
  });

function changeclubstatus(ide,st)
{
  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/changeclubstatus",
    cache: false,   
    data: {'ide':ide,'status':st},
    success: function(json){  
      //$("#sendstatus").html = json;
     $('#example1').DataTable().ajax.reload( null, false );  
     
     }
    
    });

 
  
}  
function getlogsbycompany(types)
{
   var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   clubid = types;
   var urlval = url+"user/systemTable?companytype="+clubid+"&logtype="+logtype;
   $('#example1').DataTable().ajax.url( urlval ).load();
}
function getlogsbytype(types)
{
   var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   logtype = types;
   var urlval = url+"user/systemTable?companytype="+clubid+"&logtype="+logtype;
   $('#example1').DataTable().ajax.url( urlval ).load();
}
</script>   
 