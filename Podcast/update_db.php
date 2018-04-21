<?php
include 'config.php';
$id = (int)$_POST['id'];
//$q = mysqli_query($conn, "INSERT INTO podcast.user_pd_mp(user_id, pd_id, likes) VALUES (2, $id, 3)" );
echo 'aaaaaaaaaaaaaaaaaaa'.$_GET['id'];
//echo "INSERT INTO podcast.user_pd_mp(user_id, pd_id, likes) VALUES (2, $id, 3)";

$q = mysqli_query($conn, "SELECT * FROM podcast.podcasts WHERE pd_id= $id" ) ;
echo "SELECT * FROM podcast.podcasts WHERE pd_id= $id" ;
$check_user = mysqli_num_rows($q);
$likes=0;
$dislikes=0;
if(($row = mysqli_fetch_assoc($q)))
{
	echo 'likes'.$row["likes"];
	$likes= (int)$row["likes"];
	$dislikes= (int)$row["dislikes"];
}
echo '</br> likes are '.$likes;
if($_POST['like']=='1')
{
	$likes=$likes+1;
	echo '</br> likes are '.$likes;
}
else
{
	$dislikes=$dislikes+1;
	$likes=$likes-1;
}

$q = mysqli_query($conn, "UPDATE podcast.podcasts SET likes= $likes,dislikes= $dislikes WHERE pd_id= $id" ) ;
echo "UPDATE podcast.podcasts SET likes= $likes, dislikes= $dislikes WHERE pd_id= $id";
if(isset($_COOKIE['userid']))
{
	$lk=(int)$_POST['like'];
	$user_id= (int)$_COOKIE["userid"];
	//echo 'aaaaaaaaaaaaaaaa'.$user_id;
	$q = mysqli_query($conn, "SELECT * FROM podcast.user_pd_mp WHERE user_id=$user_id AND pd_id=$id");
	$check_user = mysqli_num_rows($q);
	if(($row = mysqli_fetch_assoc($q)))
	{
		$q = mysqli_query($conn, "UPDATE podcast.user_pd_mp SET likes= $lk WHERE user_id=$user_id AND pd_id=$id" );
	}
	else
	{
		$q = mysqli_query($conn, "INSERT INTO podcast.user_pd_mp(user_id, pd_id, likes) VALUES ($user_id, $id, $lk)" );
	}
}

?>