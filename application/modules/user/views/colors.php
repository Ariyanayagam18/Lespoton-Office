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
            <h3 class="box-title">Pigeon Colors</h3>
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
                                <span><label><b>Color Name:</b></label></span>
                               </td>
                               <td>
                                <!-- <div id="cp2" class="input-group colorpicker-component"> -->
                                  <span><input id="colorname" class='form-control' type="text" name="colorname" value=""></span>
                                  <!-- <span class="input-group-addon"><i></i></span>
                                </div> -->
                               </td>
                               <td align="center">
                                 <button type="button" onclick="addeditcolor()" class="btn-sm  btn btn-success" data-toggle="modal" style="font-size:14px;"><span id="buttontext">ADD</span></button>
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
                  <th width="80%">Color Name</th>
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
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/css/bootstrap-colorpicker.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/js/bootstrap-colorpicker.js"></script> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script type="text/javascript">
function alertmsg(msg)
{
  toastr.error(msg, 'Lespoton');
}  
editval = 0;
var updatecoloride = 0
var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
// $('#cp2').colorpicker({  color: '#0000ff', });
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
          "ajax": {"url" : url+"user/colorTable","data" : {"ides":0} },
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

  function changeresultstatus(ide,st)
{
  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
   $.ajax({
    type: "post",
    url: url+"user/changeresultstatus",
    cache: false,   
    data: {'ide':ide,'status':st},
    success: function(json){  
      
      document.getElementById('resultstatus').innerHTML = json;
     //$('#example1').DataTable().ajax.reload( null, false );  
     
     }
    
    });

 
  
}  

function addeditcolor()
{
    var  colorname = $('#colorname').val();
    if(colorname == '')
    {
      alertmsg("Please Enter Color Name!.");
      return false;
    }

    $.ajax(
    {
      type: "post",
      url: url+"user/coloraddedit",
      cache: false,   
      data: {'colorname':colorname,'ide':updatecoloride},
      success: function(json)
      {  
        updatecoloride = 0;
        $('#colorname').val('')
        $('#buttontext').html('ADD')
        $('#updateresponse').html('submitted details updated !!')
        $('#example1').DataTable().ajax.reload( null, false );  
      }    
    });
}

function setcoloredit(ide,vals)
{
  $('#colorname').focus();
  $('#colorname').val(vals);
  $('#buttontext').html('UPDATE');
  updatecoloride = ide
}


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
        document.getElementById("birdname"+ind).value = info[2];
        document.getElementById("outer_no"+ind).value = info[3];
        $("#colortype"+ind+" option[value='"+info[1]+"]'").prop("selected", true);   
        $("#gender"+ind+" option[value='"+info[0]+"]'").prop("selected", true);   
        
      }
      console.log(json)
     }
    
    });
}


$("#editresult").submit(function(e) {

    var newurl = "<?php echo base_url().'user/updateresult'?>"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: newurl,
           data: $("#editresult").serialize(), // serializes the form's elements.
           success: function(data)
           {
               editval = 0;
               var urlval = url+"user/resultsTable?editmode="+editval;
               $('#example1').DataTable().ajax.url( urlval ).load();
              // $('#example1').DataTable().ajax.reload( null, false );  
           }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});

function editmode()
{
   
   editval = 1;
   var urlval = url+"user/resultsTable?editmode="+editval;
   $('#example1').DataTable().ajax.url( urlval ).load();
}
function changeracetype(types)
{
   var urlval = url+"user/resultsTable?birdtype="+types;
   $('#example1').DataTable().ajax.url( urlval ).load();
}
/*
buttons: [
        {
            extend: "print",
            customize: function(win)
            {
 
                var last = null;
                var current = null;
                var bod = [];
 
                var css = '@page { size: landscape; }',
                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                    style = win.document.createElement('style');
 
                style.type = 'text/css';
                style.media = 'print';
 
                if (style.styleSheet)
                {
                  style.styleSheet.cssText = css;
                }
                else
                {
                  style.appendChild(win.document.createTextNode(css));
                }
 
                head.appendChild(style);
         }
      },
],*/

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
    /*.colorpicker{
      top: 180px !important;
      left: 785.5px !important;
      right: 415px !important;
    }*/
  
</style>           