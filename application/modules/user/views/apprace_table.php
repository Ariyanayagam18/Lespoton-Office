<div class="content-wrapper">
  <section class="content">
  <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Races</h3>
            <div class="box-tools">
             <a href="<?php echo base_url().'races/addrace'?>"><button type="button" class="btn-sm  btn btn-success modalButtonUser" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Race</button></a>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">           
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th>S.no</th>
                  <th>Name</th>
                  <th>Date</th>
                  <th>Status</th>
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
<script type="text/javascript">
var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
  $(document).ready(function() {  
    
    var table = $('#example1').DataTable({ 
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          "columnDefs": [
    { "orderable": false, "targets": 1 }
  ],
          "processing": true,
          "serverSide": true,
          "ajax": url+"user/appracesTable",
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
      <?php if($this->session->userdata('user_details')[0]->user_type =='Admin') { ?>
      $('#example1_length').append('<label>&nbsp;&nbsp;&nbsp;<select onchange="getracesbycompany(this.value)" class="form-control input-sm"><option value="">Select Club Type</option><?php foreach ( $getcompanylists as $key=>$dis ) { ?><option value="<?php echo $dis->users_id;?>"><?php echo $dis->name;?></option><?php } ?></select></label>'); 
       <?php } ?> 
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});
  });

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
function getracesbycompany(types)
{
   var urlval = url+"user/racesTable?companytype="+types;
   $('#example1').DataTable().ajax.url( urlval ).load();
}
</script>            