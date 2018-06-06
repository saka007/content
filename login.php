<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/database.inc.php");
$db2=new Database();
$db2->open();
?>
<html>
    <head>
        
        <!-- Title -->
        <title>Code Max Login</title>
        <?php include 'header.php'?> 
                
    </head>
    <body class="page-login" >
        <main class="page-content">
            <div class="page-inner" >
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-3 center">
                            <div class="login-box">
                                <a href="index.php" class="logo-name text-lg text-center">Code Max</a>
                                <p class="text-center m-t-md">Please login into your account.</p>
                                <form action="login.php" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="user name" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                                    </div>
									
									<input type="submit" name="save" class="btn btn-success btn-block" value="Login">
                                    
                                </form>
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                <?php include('footer.php'); ?>
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
	
	<?php
      function filter($data) {
          $data = trim(htmlentities(strip_tags($data)));
          if (get_magic_quotes_gpc())
            $data = stripslashes($data);
          return $data;
        }

	 if(isset($_POST['save']))
 {
		$username = $db2->escapestring($_POST['username']); 
		$password = $db2->escapestring($_POST['password']); 
        $username = filter($_POST['username']); 
        $password = filter($_POST['password']); 

		$sql="SELECT * FROM login WHERE username='".$username."' and password='".$password."'";
		
		$result = $db2->query($sql);

		if ($db2->numRows($result) > 0) 
		{
			$_SESSION['sessionid']= $username;
			echo "<script>window.open('index.php','_self')</script>";
		}
		else
		{
			echo "<script>alert('Wrong User Id or Password');
			location.assign(login.php);
			</script>";
		}
 }
	?>
    </body>
</html>