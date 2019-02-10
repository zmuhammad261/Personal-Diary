<?php 
$dcontent = $_POST['diaryContent'];
$query = "UPDATE `user_details` set `diary_content`='".mysqli_real_escape_string($dbh,$dcontent)."'";
$stmt = mysqli_query($dbh,$query);
 ?>