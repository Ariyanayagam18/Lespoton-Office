<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
  <?php if($this->session->flashdata("messagePr")){?>
    <div class="alert alert-info" id="success">      
      <?php echo $this->session->flashdata("messagePr")?>
    </div>
  <?php } ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Races</h3>
            <div class="box-tools">
             <button type="button" class="btn-sm btn btn-success modalButtonUser" id="merge_race" data-toggle="modal" data-target="#mergemodal"><i class="fal fa-code-merge"></i> Merge Race</button> 
             <a href="<?php echo base_url().'events/addrace'?>"><button type="button" class="btn-sm  btn btn-success modalButtonUser" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Race</button></a>
             <button type="button" class="btn-sm  btn btn-success" onclick="pagerefresh('example1')"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">           
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th>S.no</th>
                  <th><input type="checkbox" id="checkAll" name="selData[]" class="selAll"></th>
                  <th>Name</th>
									<th>Org Name</th>
                  <th>Date</th>
                  <th>Lat & Long</th>
                  <th>Basketing</th>
                  <th>Status</th>
                  <th>Live Results</th>
                  <th>Merge Event</th>
                  <th>Verify Result<br>(By fancier)</th>
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
      <div class="box-header with-border formsize">
        <h3 class="box-title">Fancier Details</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div>
<!--End Modal Crud --> 

<!-- Modal Crud Start-->
<div class="modal fade" id="mergemodal" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <h3 class="box-title">Merge Race Name</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;">
          <div class="row" style="margin-top: 15px">        
            <div class="col-md-12">
              <div class="col-md-3"> 
                <div class="form-group">
                  <label for="usr">Race Title</label>
                </div>
              </div>
              <div class="col-md-6"> 
                 <div class="form-group">
                  <input type="text" class="form-control" id="race_name" name="race_name">
                </div> 
              </div>
              <div class="col-md-3">
                  <button type="button" class="btn-sm btn btn-success" id="merge_race_save">Save</button>
              </div>
          </div>
        </div>
        

      </div>
    </div>
  </div>
</div>
<!--End Modal Crud --> 

<script type="text/javascript">
var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
var clubid = '';
  $(document).ready(function() {

      $("#checkAll").click(function () {
         $('input:checkbox').not(this).prop('checked', this.checked);
     });  
    var val = [];
    
     $('#merge_race').click(function(){
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
        
      });

    




    
    var table = $('#example1').DataTable({ 
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          "columnDefs": [
    { "orderable": false, "targets": 1 },
    {
                "targets": [ 10 ],
                "visible": false
    }
  ],
          "order": [[ 0, 'desc' ]],
          "processing": true,
          "serverSide": true,
          "ajax": url+"user/racesTable",
          "sPaginationType": "full_numbers",
          "language": {
            "processing":"<img style='width:150px; height:90px;' src='http://datainflow.com/wp-content/uploads/2017/09/loader.gif' />",
            "search": "_INPUT_", 
            "sLengthMenu": "Show _MENU_ Club",
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
      $('#example1_length').append('<label>&nbsp;&nbsp;&nbsp;<select onchange="getracesbycompany(this.value)" class="form-control input-sm" id="clubtype"><option value="">Select Club Type</option><?php foreach ( $getcompanylists as $key=>$dis ) { ?><option value="<?php echo $dis->users_id;?>"><?php echo $dis->name;?></option><?php } ?></select></label>'); 
       <?php } ?> 
    }, 300);

    $("button.closeTest, button.close").on("click", function (){});

     $('#example1').on( 'length.dt', function ( e, settings, len ) {   // Per page change this one trigger
     $("#clubtype").val(clubid); 
   } );

     $("#merge_race_save").click(function () {
        
        var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
        var title = $("#race_name").val();
         $.ajax({
          type: "post",
          url: url+"user/add_merge_race",
          cache: false,   
          data: {'event_val':val,'race_title':title},
          success: function(result){  
              if(result == 1){
                $('#mergemodal').modal('hide');
                $('#success').html("Result Successfully Merged");
                setTimeout(function(){ 
                  $('#success').html("");
                  $('#example1').DataTable().ajax.reload( null, false );  
                },2000);
                
              }     
           }
          
          });
    });

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
  clubid = types;
   var urlval = url+"user/racesTable?companytype="+types;
   $('#example1').DataTable().ajax.url( urlval ).load();
}
</script>  
<style>
  .table>tbody>tr>td {
    border: 1px solid #f4f4f4 !important;
}
</style>          