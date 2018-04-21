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
	<link href="css/custom.css" rel="stylesheet">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
    <!-- Custom styles for this template -->
    <link href="css/3-col-portfolio.css" rel="stylesheet">

  </head>

  <body>
    <?php include 'config.php'; ?>
	<script type="text/javascript">
		$( document ).ready(function() {
			$(".more").click( function() {
		    $(".text").show();
		    $(".less").show();
		    $(".more").hide();
		    });
			$(".less").click( function() {
		    $(".text").hide();
		    $(".less").hide();
		    $(".more").show();
		 });
		});
		function myFunction(x,$id) {
			$z='-1';
			if(x.className=="fa fa-thumbs-up")
				$z='1';
			x.classList.toggle("fa-thumbs-down");
			setData($id, $z);
		}
		function setData($id, $z){
			$.ajax({
				type: "POST",
				url: "update_db.php",
				data: { id: $id, like: $z}
			   });
		}
	</script>
	
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
              <a class="nav-link active" href="index.php">Home</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="#">Search</a>
            </li>
            <li class="nav-item">
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

      <!-- Page Heading -->
      <h1 class="my-4">Page Heading
        <small>Secondary Text</small>
      </h1>
	  
	  <form name="search_form" accept-charset="utf-8" method="post" action="index.php">
          <div class="row">
		    <div class="form-group col-lg-1">
			</div>
			<div class="form-group col-lg-8">
              <label class="text-heading">Search Here</label>
              <input name="pd_name" type="text" class="form-control" value="<?php echo $_POST['pd_name']; ?>" required>
            </div>
			<div class="form-group col-lg-2">
              <label class="text-heading">.</label></br>
              <button name="submit" type="submit" class="btn btn-secondary">Search</button>
            </div>
			<div class="form-group col-lg-1">
			</div>
		  </div>
	  </form>
	  
	  <?php
		$flag=0;
		if (isSet($_POST['pd_name']) && $_POST['pd_name'] != '') 
		{
			$name= $_POST['pd_name'];
			$q = mysqli_query($conn, "SELECT * FROM podcast.podcasts WHERE pd_name  like '%$name%'" ) ;
    		$check_user = mysqli_num_rows($q);

			if($check_user>0){
				if(($row = mysqli_fetch_assoc($q)))
				{
					//$idd= $row["user_id"];
					echo '
					<div class="clearfix"></div>
					  <h3 class="my-4">You searched for </h3></br>
					<div class="clearfix"></div>
					<div class="row">';
					
					$arr1 = str_split($row['description'],200);
					echo '
					<div class="col-lg-3 col-sm-3 portfolio-item">
					  <div class="card h-100">
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
						<div class="card-body">
						  <h4 class="card-title">
							<a href="'.$row['pd_link'].'">'.$row['pd_name'].'</a>
						  </h4>
						  <p class="card-text">'.$arr1[0].' more......</p>
						</div>
					  </div>
					</div>';
					echo '</div>';
				}
    		}else{
				echo'
				    <div class="clearfix"></div>
					<div class="row">
					  <div class="form-group col-lg-4">
					  </div>
					  <div class="form-group col-lg-4">
						<label class="text-heading" style="color:red">Podcast not found</label>
					  </div>
					  <div class="form-group col-lg-4">
					  </div>
					</div>';
			}
		}
	?>
	  
	  <?php
	  $tps= array(1,5,11);
	  foreach ($tps as &$value) 
	  {
		$q = mysqli_query($conn, "SELECT * FROM podcast.topics WHERE topic_id= $value" ) ;
		$check_user = mysqli_num_rows($q);
		if($check_user>0)
		{	
		  if(($row = mysqli_fetch_assoc($q)))
		  {
			$nm= $row["topic_name"];
		  }
		  else
			  continue;
	    }
		
		echo '
		<div class="clearfix"></div>
		  <h3 class="my-4">'.$nm.'</h3></br>
		<div class="clearfix"></div>
		<div class="row">';
		
		$q = mysqli_query($conn, "SELECT * FROM podcast.podcasts WHERE topic_id= $value LIMIT 4" ) ;
		$check_user = mysqli_num_rows($q);
		
		if($check_user>0)
		{
		  while ($row = mysqli_fetch_assoc($q)) 
		  {
			$arr1 = str_split($row['description'],200);
		    echo '
			<div class="col-lg-3 col-sm-3 portfolio-item">
			  <div class="card h-100">
				<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
				<div class="card-body">
				  <h4 class="card-title">
					<a href="'.$row['pd_link'].'">'.$row['pd_name'].'</a>
				  </h4>
				  <p class="card-text">'.$arr1[0].' more......</p>
				</div>
				<i onclick="myFunction(this,'.$row['pd_id'].')" class="fa fa-thumbs-up" style="font-size:30px;padding-left:30px"></i>
			  </div>
            </div>';
		  }
		}
		echo '</div>';
	  }
	  ?>

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
    <script type="text/javascript" src="vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
