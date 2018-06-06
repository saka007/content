<?php 
session_start();

if(!isset($_SESSION['sessionid']))
{
header("location: login.php");
}
else {
    require_once("inc/config.inc.php");
    require_once("inc/database.inc.php");

if(isset($_POST["manufacturer_name"]))
   {
    $db=new Database();
    $db->open();

    $manufacturer_name = $_POST['manufacturer_name'];

     $sql = "INSERT INTO manufacturer(manufacturer_name) VALUES ('$manufacturer_name')";
     $db_insert = $db->query($sql);
     if($db_insert) {
      echo "<b>Manufacturer Inserted Successfuly</b>";
     }
     $db->close();
     exit;
   }
?>
<html>
    <head>  
        <!-- Title -->
        <title>Manufacturer</title>    
        <?php include 'header.php'?>     
    </head>
    <body class="page-header-fixed">
       <main class="page-content content-wrap">
           <?php include 'topbar.php'?>
           <?php include 'sidebar.php'?>
		   
		      <div class="page-inner">
            <div class="page-title">
              <h3>Manufacturer </h3>
            </div>
          
          <div id="main-wrapper">
            <div class="row">
              <div class="col-md-10">
                <div class="panel panel-white">                     
                    <div class="panel-body">
                      <form class="form-horizontal" name="manufacturer" action="manufacturer" method="post">
					               	<div class="form-group">
                           <label for="input-Default" class="col-sm-2 control-label">Manufacturer Name</label>
                               <div class="col-sm-10">
                                  <input type="text" class="form-control" id="input-Default" name="manufacturer_name" placeholder="Manufacturer Name"  required>
                                </div>
                           </div>
                           						
                         <div class="form-group">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
							               <input type="submit" name="submit" class="btn btn-info" value="Save" >
							               <input type="reset" name="reset" class="btn btn-info" value="Clear" >
                             </div>
                          </div>

                          <div class="form-group">
                            <div class="col-sm-9">
                              <div class="result"></div>
                             </div>
                          </div>
										
                        </form>
                      </div>
                    </div>
                  </div>

					                  
						
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
             <?php include('footer.php'); ?>
            </div><!-- Page Inner -->
        </main><!-- Page Content -->

		 
		 
		 
<!-- Insert Code -->		 
<!--   <script type="text/javascript">
function ConfirmDelete(){
	var d = confirm('Do you really want to delete data?');
	if(d == false){
		return false;
	}
}
</script> -->

<?php

	  //Start Delete Contact
// if(isset($_POST["action"]) and $_POST["action"]=="delete"){
// 	$id = (isset($_POST["del"])? $_POST["del"] : '');
//     $sql2 = "delete from car_rate where id=$id";

//     $eresult =$db23->query($sql2);
    
// 	if(!$eresult)
// 	{
// 		echo "Delete Error";
// 		exit();
// 	}
//     else
//     {
//      echo '<META HTTP-EQUIV="Refresh" Content="0; URL=car_rate.php">';  
// echo "<script language=javascript>alert('Car Rate Deleted successfully ')</script>";
//    }
	  
//  }
 
  ?>
</body>
<script type="text/javascript">
  $(function() {
  $("form[name='manufacturer']").validate({
    // Specify validation rules
    rules: {
      manufacturer_name: "required",
    },
    // Specify validation error messages
    messages: {
      manufacturer_name: "Please enter manufacturer name"
    },
    submitHandler: function(form) {
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function(response) {
                 $('.result').html(response);
                //alert(response);
            }            
        });
    }
  });
});
</script>
</html>
<?php } ?>