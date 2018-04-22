<?php
include 'config.php';

$id = (int)$_POST['id'];
if(isset($_COOKIE['userid']))
{
	$lk=(int)$_POST['like'];
	$user_id= (int)$_COOKIE["userid"];
	$q = mysqli_query($conn, "SELECT * FROM podcast.user_pd_mp WHERE user_id=$user_id AND pd_id=$id");
	$check_user = mysqli_num_rows($q);
	if($check_user>0)
	{
		if(($row = mysqli_fetch_assoc($q)))
		{
			$lk= $lk+ $row['likes'];
			$q = mysqli_query($conn, "UPDATE podcast.user_pd_mp SET likes= $lk WHERE user_id=$user_id AND pd_id=$id" );
		}
	}
	else
	{
		$q = mysqli_query($conn, "INSERT INTO podcast.user_pd_mp(user_id, pd_id, likes) VALUES ($user_id, $id, $lk)" );
	}
}
$mystring = shell_exec('"C:/Users/Sambartika/Anaconda2/python" C:/wamp64/www/Podcast/MF.py');
?>