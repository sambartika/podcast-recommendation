<?php  
	//Checks if the Database is Configured or Not
	//Removes the error reporting
	error_reporting(E_ERROR);
	$conn = mysqli_connect('localhost:3306', 'root', '', 'library'); 
	if (!$conn) {	
		echo "Your Database is not Configured yet. ";
		//echo "<a href='setup.php'>Configure</a>";
		die();
	}
	if(!mysqli_set_charset($conn, "utf8"))
	{
		die;
	}
	$url= "http://localhost";
	//mysql_set_charset("UTF8");
?>