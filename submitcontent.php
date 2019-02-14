<?php 
session_start();
include 'config.php';
if(array_key_exists("diaryContent",$_POST)){
	$diaryContent = $_POST['diaryContent'];
$query = "UPDATE user_details SET diary_content='".mysqli_real_escape_string($dbh,$diaryContent)."' WHERE user_id=".mysqli_real_escape_string($dbh, $_SESSION['user_id'])." LIMIT 1";
$stmt = mysqli_query($dbh,$query);
}

 ?>