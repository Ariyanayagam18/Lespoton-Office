<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
  <?php if ($this->session->flashdata("messagePr")) {?>
    <div class="alert alert-info">
      <?php echo $this->session->flashdata("messagePr") ?>
    </div>
  <?php }?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">clubs</h3>
            <div class="box-tools">
              <?php if (CheckPermission("users", "own_create")) {?>
              <button type="button" class="btn-sm  btn btn-success modalButtonUser" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Club</button>
              <button type="button" class="btn-sm  btn btn-success" onclick="pagerefresh('example1')"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
              <?php }?>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th>S.no</th>
									<th>Name</th>
									<th>Email</th>
                  <th>Phone No</th>
                  <th>Address</th>
                  <th>Expire Date</th>
                  <th>Status</th>
                  <th>Fancier Limit</th>
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
<div class="modal fade" id="nameModal_user" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <h3 class="box-title">Add/Edit Club Details</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 4 !important;"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div><!--End Modal Crud -->

<!-- Modal Crud Start-->
<div class="modal fade" id="clubviewwindow" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <h3 class="box-title">Club Details</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div><!--End Modal Crud -->


<script type="text/javascript">

  $(document).ready(function() {

    var url = '<?php echo base_url(); ?>';//$('.content-header').attr('rel');
    var table = $('#example1').DataTable({
          aaSorting: [[2, "asc"]],
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          "columnDefs": [
    { "orderable": false, "targets": 1 }
  ],
          "processing": true,
          "serverSide": true,
          "ajax": url+"user/dataTable",
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

        //$('.dataTables_info').before('<button data-base-url="<?php echo base_url() . 'user/delete/'; ?>" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> <i class="fa fa-trash"></i> </button><br><br>');
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});
  });

function changeclubstatus(ide,st)
{

    var url = '<?php echo base_url(); ?>';//$('.content-header').attr('rel');
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

</script>
<style>
  .table>tbody>tr>td {
    border: 1px solid #f4f4f4 !important;
}
</style>
