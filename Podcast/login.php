<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>3 Col Portfolio - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/3-col-portfolio.css" rel="stylesheet">

  </head>

  <body>
    <?php include 'config.php'; ?>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="#">Search</a>
            </li>
            <li class="nav-item active">
			  <?php
				if(isset($_COOKIE['userrole']) )
				{
					echo '<a class="nav-link" href="logout.php">Logout
					<span class="sr-only">(current)</span>
					</a>';
				}
				else
				{
					echo '<a class="nav-link" href="login.php">Login
					<span class="sr-only">(current)</span>
					</a>
					</li>
					<li>
					<a class="nav-link" href="register.php">Register</a>
					</li>
					';
				}
			  ?>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
	  <?php
		$flag=0;
		if (isSet($_POST['email']) && isSet($_POST['pass']) && $_POST['email'] != '' && $_POST['pass'] != '') 
		{
			$email= $_POST['email'];
			$pass= $_POST['pass'];
			$q = mysqli_query($conn, "SELECT * FROM podcast.users WHERE mail_id='$email' AND password='$pass'" ) ;
    		$check_user = mysqli_num_rows($q);

			if($check_user>0){
				if(($row = mysqli_fetch_assoc($q)))
				{
					$idd= $row["user_id"];
				}			
    			setcookie("loggedin", 1, time()+3600);  /* expire in 1 hour */
				setcookie("username", $email, time()+3600);  /* expire in 1 hour */
				setcookie("userid", $idd, time()+3600);  /* expire in 1 hour */
				setcookie("userrole", "user", time()+3600);  /* expire in 1 hour */
				header("Location: index.php");
    		}else{
				//die('ssss');
				$flag=1;
			}
		}
	?>
      <!-- Page Heading -->
      <div class="bg-faded p-2 my-2">
        <hr class="divider">
        <h2 class="text-center text-lg text-uppercase my-0">
          <strong>Sign in</strong>
        </h2>
        <hr class="divider">
		
        <form name="login_form" accept-charset="utf-8" method="post" action="login.php">
          <div class="row">
			<?php
			if($flag==1)
			{
				echo'
					<div class="form-group col-lg-4">
					</div>
					<div class="form-group col-lg-4">
						<label class="text-heading" style="color:red">Invalid email or password</label>
					</div>
					<div class="form-group col-lg-4">
					</div>';
			}
			?>
			<div class="form-group col-lg-4">
              <label class="text-heading">Email</label>
              <input name="email" type="email" class="form-control">
            </div>
			<div class="form-group col-lg-4">
              <label class="text-heading">Password</label>
              <input name="pass" type="password" class="form-control">
            </div>
			<div class="clearfix"></div>
			
            <div class="form-group col-lg-4">
			  <label class="text-heading">.</label></br>
              <button name="login" type="submit" class="btn btn-secondary">Login</button>
            </div>
			<div class="form-group col-lg-4">
			</div>
          </div>
        </form>
		
      </div>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
