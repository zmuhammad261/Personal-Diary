<?php 
session_start();

if (array_key_exists("user_id",$_COOKIE)) {
	$_SESSION['user_id'] = $_COOKIE['user_id'];
}

if(array_key_exists('user_id',$_SESSION)) {
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
		<div class="card-body p-0"><textarea name="diaryContent" id="diaryContent" class="form-control"></textarea></div>
	</div>	
		</div>
	</div>

	<!-- Scripts -->
 <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
 <script type="text/javascript" src="bootstrap.bundle.min.js"></script>
 <script type="text/javascript">
 	$(document).ready(function() {
 		$('#diaryContent').change(function(){

 			/* stop form from submitting normally */
            event.preventDefault();

 			var thiscontent = $(this).val();
 			

 			$.ajax({
 				url: 'submitcontent.php',
 				type: 'POST',
 				data: {diaryContent: diaryContent},
 				dataType: "json",
 				success: function(response) {
	 				if(response.status == "success") {
	                 $("#diaryContent").val(response.diary_content);
	              }
 			}
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

