<?php 
session_start();
$diaryContentz = "";
if (array_key_exists("user_id",$_COOKIE)) {
	$_SESSION['user_id'] = $_COOKIE['user_id'];

}

if(array_key_exists('user_id',$_SESSION)) {
	include 'config.php';
	$query = "SELECT `diary_content` FROM `user_details` WHERE user_id=".mysqli_real_escape_string($dbh,$_SESSION['user_id'])." LIMIT 1";
	$stmt = mysqli_query($dbh,$query);

	$row = mysqli_fetch_array($stmt);

	$diaryContentz = $row['diary_content'];

	// echo $diaryContentz;
	// print_r($_SESSION['user_id']);
	?>
	

	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<title>Your Personal Space</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
		<style type="text/css">
			#diaryContent {
				min-height: 100vh;
				border: none;
				padding: 1rem;
				resize: none;
			}
			#diaryContent:focus {
				box-shadow: none;
			}
		</style>
	</head>
	<body>
	
	<div class="main py-5">
		<div class="container">
			<a href="index.php?logout=true" class="pb-3 d-block text-right text-danger">Logout</a>
			<div class="card shadow border-0">
		<div class="card-body p-0"><textarea name="diaryContent" id="diaryContent" class="form-control"><?php echo $diaryContentz; ?></textarea></div>
	</div>	
		</div>
	</div>

	<!-- Scripts -->
 <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
 <script type="text/javascript" src="bootstrap.bundle.min.js"></script>
 <script type="text/javascript">
 	$(document).ready(function() {

 	$('#diaryContent').bind('input change', function(event){
 		// alert($(this).val());
 		
 		$.ajax({
 			url: 'submitcontent.php',
 			type: 'POST',
 			data: {diaryContent: $("#diaryContent").val()}
 		});
 		
 	});	

 	});
 </script>
	</body>
	</html>
		
	<?php
}
else {
	header("Location: index.php");
}
 ?>

