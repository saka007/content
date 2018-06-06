<?php 
session_start();

if(!isset($_SESSION['sessionid']))
{
header("location: login.php");
}
else {
?>
<html>
    <head>
        
        <!-- Title -->
        <title>Dashboard</title>
        
       <?php include 'header.php'?>   
    </head>
    <body class="page-header-fixed">     
        <main class="page-content content-wrap">
           <?php include 'topbar.php'?>
           <?php include 'sidebar.php'?>
		   
		   <div class="page-inner">
                <div class="page-title">
                    <h3>Dashboard</h3>
                </div>
            <div id="main-wrapper">
              <div class="row">
                <table id="employee-grid" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Manufacturer Name</th>
                            <th>Model Name</th>
                            <th>Count</th>
                            <th>Update</th>
                        </tr>
                    </thead>
               </table>
            
            <div class="modal fade" id="DescModal" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
                       <h3 class="modal-title">Model Description</h3>

                  </div>
                  <div class="modal-body">
                    <div class="row dataTable">
                       <div class="col-md-4">
                            <label class="control-label">Model Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" maxlength="50" id="model_name" name="model_name">
                        </div>
                    </div>
                     <br>
                    <div id="content1"></div>
                    <div class="row dataTable">
                        <div class="col-md-4">
                            <label class="control-label">Manufacturer Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" maxlength="30" id="manu_name" name="manu_name">
                            <input type="hidden" class="form-control" maxlength="30" value="" id="rowid">
                        </div>
                      </div>

                      <div class="row dataTable">
                        <div class="col-md-4">
                            <label class="control-label">Model Color</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" maxlength="30" id="model_color" name="model_color">
                        </div>
                      </div>

                      <div class="row dataTable">
                        <div class="col-md-4">
                            <label class="control-label">Model Manufacturing Year</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" maxlength="30" id="model_manufacturing_yr" name="model_manufacturing_yr">
                        </div>
                      </div>

                      <div class="row dataTable">
                        <div class="col-md-4">
                            <label class="control-label">Model Registration Number</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" maxlength="30" id="model_reg_number" name="model_reg_number">
                        </div>
                      </div>

                      <div class="row dataTable">
                        <div class="col-md-4">
                            <label class="control-label">Model Note</label>
                        </div>
                        <div class="col-md-8">
                           <div id="note"></div>
                        </div>
                      </div>

                       <br>
                     </div>
                     <div class="modal-footer">
                        <button type="button" id="delete" class="btn btn-default " data-dismiss="modal">Delete!</button>
                    </div>
                  </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->


	        </div><!-- Row -->
         </div><!-- Main Wrapper -->
        <?php include 'footer.php'?>
    </div><!-- Page Inner -->
</main><!-- Page Content -->	
</body>

         <script type="text/javascript" language="javascript" >
            $(document).ready(function() {
                var dataTable = $('#employee-grid').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
                    "ajax":{
                        url :"data_table.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                            $(".employee-grid-error").html("");
                            $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#employee-grid_processing").css("display","none");
                            
                        }
                    }
                } );
                

               $('#employee-grid tbody').on( 'click', 'button', function () {
                  var data  = dataTable.row( $(this).parents('tr') ).data();
                  $(this).parents('tr').addClass('selected');
                //  console.log( data[0] );
                  
                   $.ajax({
                         url: "data_table.php", 
                         type: "post",  // method
                         data: "model_id="+data[0],
                         dataType: 'json', // jQuery will parse the response as JSON
                          success: function (outputfromserver) {
                              $("#model_color").val( outputfromserver[0] );
                              $("#model_manufacturing_yr").val( outputfromserver[1] );
                              $("#model_reg_number").val( outputfromserver[2] );
                              $("#note").html( outputfromserver[3] );
                          }
                       }); 

                  $("#rowid").val( data[0]);
                  $("#model_name").val( data[1] );
                  $("#manu_name").val( data[2] );
                  $('#DescModal').modal("show");

              });
    
                            
               $('#delete').click( function () {
                     var datapost = $("#rowid").val();
                    //dataTable.row('.selected').remove().draw( false );
                     $.ajax({
                         url: "data_table.php", 
                         type: "post",  // method  , by default get
                         data: "id="+datapost,
                         success : function(data){
                            //delete the row
                            dataTable.row('.selected').remove().draw( false );
                          },
                         error: function(xhr){
                             //error handling
                           }
                       }); 
              } );
            } );
        </script>
</html>
<?php } ?>