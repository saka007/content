<!DOCTYPE html>
<?php 
session_start();

if(!isset($_SESSION['sessionid']))
{
header("location: login.php");
}
else {
    require_once("inc/config.inc.php");
    require_once("inc/database.inc.php");

    if(isset($_POST["submit"]))
       {

        $db5=new Database();
        $db5->open();
        
                    $id=$_POST['id'];
                    $username=$_POST['username'];
                    $email=$_POST['email'];
                    $first_name=$_POST['first_name'];
                    $last_name=$_POST['last_name'];
                    $password=$_POST['password'];
        
        $sql="update login set username='$username' , first_name='$first_name' , last_name='$last_name' ,password='$password' , email='$email' where id='$id'";
        $db5->query($sql);
          echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';    
     
         echo "<script language=javascript>alert('Account Information successfully Update')</script>";
       }
?>
<html>
    <head>
        
        <!-- Title -->
        <title>My Account</title>
        <?php include 'header.php'?>        
    </head>
    <body class="page-header-fixed">
   <?php
    $db2=new Database();
    $db2->open();
    $sql="select * from login where username='".$_SESSION['sessionid']."'";
    $result = $db2->query($sql);

    if(!$result)
      {
           echo "ERROR";
           exit();
      } 
      while($rows = $db2->fetchArray())
      {
          $contact_list[] = array('id' => $rows['id'] ,'username' => $rows['username'],'first_name' => $rows['first_name'], 'last_name' => $rows['last_name'], 'password' => $rows['password'], 'email' => $rows['email']);
      } 
		if(isset($contact_list))
		{ 
           foreach($contact_list as $con)
		   {
				$id=$con['id'];
				$username=$con['username'];
				$email=$con['email'];
				$first_name=$con['first_name'];
				$last_name=$con['last_name'];
				$password=$con['password'];
		   }
		}
  ?>		
        <main class="page-content content-wrap">
           <?php include 'topbar.php'?>
           <?php include 'sidebar.php'?>
		   
		   <div class="page-inner">
                <div class="page-title">
                    <h3>My Account</h3>
                </div>
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title"></h4>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal" action="my_account.php" method="post">
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="input-Default" name="first_name" placeholder="First Name" required value="<?php echo $first_name; ?>">
												
												<input type="hidden" class="form-control" id="input-Default" name="id"  required value="<?php echo $id; ?>">
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="input-Default" name="last_name" placeholder="First Name" required value="<?php echo $last_name; ?>">
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Email Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="input-Default" name="email" placeholder="First Name" required value="<?php echo $email; ?>">
                                            </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">User Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="input-Default" name="username" placeholder="First Name" required value="<?php echo $username; ?>">
                                            </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="input-Default" name="password" placeholder="First Name" required value="<?php echo $password; ?>">
                                            </div>
                                        </div>
										
										<div class="form-group">
                                           <div class="col-sm-2">
										   </div>
                                           <div class="col-sm-10">
												<input type="submit" name="submit" class="btn btn-danger" value="Save" >
												
                                            </div>
                                        </div>
										
                                         </form>
                                </div>
                            </div>
                        </div>
     </div><!-- Row -->
                </div><!-- Main Wrapper -->
                
			  <?php include 'footer.php'?>
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
 </body>
</html>
<?php } ?>