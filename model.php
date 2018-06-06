<?php 
session_start();

if(!isset($_SESSION['sessionid']))
{
header("location: login.php");
}
else {
     require_once("inc/config.inc.php");
     require_once("inc/database.inc.php");

     $db=new Database();
     $db->open();
     $sql_manufacturer = "select * from manufacturer order by id";
     $result =$db->query($sql_manufacturer);
      if(!$result)
      {
           echo "No Manufacturer Yet";
           exit();
      } 
      while($rows = $db->fetchArray())
      {
          $arraylist[] = array('id' => $rows['id'], 'manufacturer_name' => $rows['manufacturer_name']);
      }
   if(isset($_POST["model_name"]))
   {
       
        $image1 = $_FILES["file1"]["name"];   
        $image2 = $_FILES["file2"]["name"];   
        $name = filter_var($_POST["model_name"], FILTER_SANITIZE_STRING);
        $color = filter_var($_POST["color"], FILTER_SANITIZE_STRING);
      $manufacturing_year = filter_var($_POST["manufacturing_year"], FILTER_SANITIZE_STRING);
    $registration_number = filter_var($_POST["registration_number"], FILTER_SANITIZE_STRING);
        $note = $_POST["editor1"];
        $manufacturer = filter_var($_POST["manufacturer"], FILTER_SANITIZE_STRING);


        if($image1!='' || $image2!='') {
          $sql="insert into model(name,color,manufacturing_year,registration_number,image1,image2,note,manufacturer_id) values('". $name ."','". $color ."','". $manufacturing_year ."','".$registration_number."','".$image1."','".$image2."','".$note."','".$manufacturer."')"; 
          
          $insert_query = $db->query($sql);    
          if($insert_query) {
             move_uploaded_file($_FILES["file1"]["tmp_name"],"assets/images/" . $_FILES["file1"]["name"]);  
             move_uploaded_file($_FILES["file2"]["tmp_name"],"assets/images/" . $_FILES["file2"]["name"]);  
             echo "Successfully Inserted and Moved Files to folder"; 
            $db->close();
            exit;    
           }
          
        }
        else {
              $sql1="insert into model(name,color,manufacturing_year,registration_number,note,manufacturer_id) values('$name','$color','$manufacturing_year','$registration_number','$note','$manufacturer')"; 

          $insert_query = $db->query($sql1); 

          if($insert_query) {
           echo "Successfully Inserted";
           $db->close();
           exit;     
          }
      }
   exit; 
  }	     
?>
<html>
    <head>
        
        <!-- Title -->
        <title>Model</title>
        <?php include 'header.php'?> 
    </head>
  <body class="page-header-fixed">  
   <main class="page-content content-wrap">
    <?php include 'topbar.php';?>
    <?php include 'sidebar.php';?>	   
		   <div class="page-inner">
        <div class="page-title">
            <h3>Model</h3>
        </div>
        <div id="main-wrapper">
          <div class="row">
            <div class="col-md-8">
                <div class="panel panel-white">
                    
                    <div class="panel-body">
                        <form name="model" class="form-horizontal" action="model.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                               <div class="col-sm-6">
                                <label for="input-Default" class="col-sm-4 control-label">Model Name</label>
                                <div class="col-sm-8  ">
                                    <input type="text" class="form-control" id="input-Default" name="model_name" placeholder="Enter Model Name">
                                    <div class="error_div"></div>
                                </div>
                                
                                </div>
                                
                                <div class="col-sm-6">
                                <label for="input-Default" class="col-sm-4 control-label">Manufacturer</label>
                                <div class="col-sm-8  ">
                                    <select name="manufacturer" class="form-control">
                                      <?php 
                                        if(isset($arraylist))
                                         { 
                                           foreach($arraylist as $option) { ?>
                                             <option value="<?php echo $option['id']?>"><?php echo $option['manufacturer_name']?></option>
                                          <?php  } } ?>
                                      <option value="1">AA</option>
                                    </select>
                                    <div class="error_div"></div>
                                </div>
                                
                                </div>
                                

                            </div>

                            <div class="form-group">
                                <label for="input-Default" class="col-sm-2 control-label">Color</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input-Default" name="color" placeholder="Enter Model Color">
                                    <div class="error_div"></div>
                                </div>
                               

                            </div>

                            <div class="form-group">
                                <label for="input-Default" class="col-sm-2 control-label">Manufacturing Year</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="input-Default" name="manufacturing_year" placeholder="Enter Manufacturing Year">
                                    <div class="error_div"></div>
                                </div>
                              
                            </div>

                            <div class="form-group">
                                <label for="input-Default" class="col-sm-2 control-label">Registration Number</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="input-Default" name="registration_number" placeholder="Enter Registration Number">
                                     <div class="error_div"></div>
                                </div>
                            </div>

				                    <div class="form-group">
                                <label for="input-Default" class="col-sm-2 control-label">Image 1 </label>
                                <div class="col-sm-10">
					                           <input type="file" name="file1" class="form-control"> 
                                    <div class="error_div"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-Default" class="col-sm-2 control-label">Image 2 </label>
                                <div class="col-sm-10">
                                     <input type="file" name="file2" class="form-control">
                                  <div class="error_div"></div>
                                </div>
                            </div>
				
				                    <div class="form-group"> 
				                      <label for="input-Default" class="col-sm-2 control-label">Note</label>
                                <div class="col-sm-10">
						                      <textarea class="ckeditor" cols="20" id="editor1" name="editor1" rows="10"></textarea>
                                  <div class="error_div"></div>
                                </div>
                              
                            </div>

				                    <div class="form-group">
                               <div class="col-sm-2"></div>
                                <div class="col-sm-10">
						                      <input type="submit" name="submit" class="btn btn-info" value="Save" >
						                      <input type="reset" name="reset" class="btn btn-info" value="Clear" >     
                                </div>
                            </div>
                      </form>

                      <div class="modal fade" id="DescModal" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-body">
                     <div class="result"></div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-default " data-dismiss="modal">Close!</button>
                    </div>
                  </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

                 </div>
              </div>
                
          </div>
                        						
      	 </div><!-- Row -->
       </div><!-- Main Wrapper -->
     <?php include('footer.php'); ?>
   </div><!-- Page Inner -->
 </main><!-- Page Content -->
</body>
</html>
<script type="text/javascript">
  $(function() {
  $("form[name='model']").validate({
   //Specify validation rules
    rules: {
      model_name: "required",
      manufacturer: "required",
      color: "required",
      manufacturing_year: "required",
      registration_number: "required"
    },
    errorPlacement: function(error, element) {
          //error.insertAfter(element);
          error.appendTo('.error_div');
      },

    submitHandler: function(form) {

        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
        var form = $('form')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        $.ajax({
            url: form.action,
            type: form.method,
            enctype: 'multipart/form-data',
            processData: false,  // Important!
            contentType: false,
            cache: false,
            //data: $(form).serialize(),
            data: formData,

            success: function(response) {
                 $('.result').html(response);
                  $('#DescModal').modal("show");
                //alert(response);
            }            
         });
       }
    });

       $('#close').click( function () {
           location.reload();
        } );

   });
</script>
<?php } ?>