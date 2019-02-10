<?php 
session_start();
include 'config.php';
$signerror = "";
	$logerror = "";

if(array_key_exists("logout",$_GET)){
	session_unset();
	setcookie("user_id","",time()-60*60);
	$_COOKIE["user_id"] = "";

	// print_r($_GET);
}

else if(array_key_exists('user_id',$_SESSION) OR array_key_exists('user_id',$_COOKIE)){
	header("Location: diary.php");
}

if(array_key_exists('signin',$_POST)){
	// print_r($_POST);

	// if(!$_POST['loguserid']){
	// 	$logerror = "An email address is required <br />";
	// }

	// if($_POST['pswd']){
	// 	$logerror = "Password is required";
	// }

	// if($logerror != ""){
	// 	$logerror="<p> Error Found: </p>";
	// }
	// else {
		$query= "SELECT * FROM `user_details` WHERE user_email='".mysqli_real_escape_string($dbh,$_POST['loguserid'])."' LIMIT 1";
		$stmt = mysqli_query($dbh,$query);
		while($row = mysqli_fetch_array($stmt)){

		if(mysqli_num_rows($stmt) == 0){
			$logerror = "<p>Email does not exist.</p>";
		}
		else {
		// 	$query= "SELECT user_id FROM `user_details` WHERE user_email='".mysqli_real_escape_string($dbh,$_POST['loguserid'])."' LIMIT 1";
		// $stmt = mysqli_query($dbh,$query);
		// 
		$hashedPswd = md5(md5($row['user_id']).$_POST['pswd']);

		echo $hashedPswd;
		print_r($row['user_pswd']);

		if($hashedPswd == $row['user_pswd']){

				$_SESSION['user_id']= mysqli_insert_id($dbh);

				if($_POST['logcheck'] == '1'){
					setcookie("user_id",mysqli_insert_id($dbh),time()*60*60*24*7);
				}
				header("Location: diary.php");		
			}
		}
	}
	// }


}

if(array_key_exists('signup',$_POST)){

		$query= "SELECT user_id FROM `user_details` WHERE user_email='".mysqli_real_escape_string($dbh,$_POST['emailid'])."' LIMIT 1";
		$stmt = mysqli_query($dbh,$query);

		if(mysqli_num_rows($stmt) > 0){
			$signerror.= "Email already taken";
		}

		else {
			// $usname = '".mysqli_real_escape_string($dbh,$_POST['userid'])."';
			// $usemail = '".mysqli_real_escape_string($dbh,$_POST['emailid'])."';
			// $usname = '".mysqli_real_escape_string($dbh,$_POST['pswdup'])."';
			$query = "INSERT INTO `user_details`(`user_name`,`user_email`,`user_pswd`) VALUES('".mysqli_real_escape_string($dbh,$_POST['userid'])."', '".mysqli_real_escape_string($dbh,$_POST['emailid'])."', '".mysqli_real_escape_string($dbh,$_POST['pswdup'])."')";
			$stmt= mysqli_query($dbh,$query);
			if(!$stmt) {
				$signerror.= "<p>Could not sign you up - please try again later.</p>";
			}
			else {
				$query = "UPDATE `user_details` SET user_pswd='".md5(md5(mysqli_insert_id($dbh)).$_POST['pswdup'])."' WHERE user_id ='".mysqli_insert_id($dbh)."' LIMIT 1";
				mysqli_query($dbh,$query);

				// $_SESSION['user_id']= mysqli_insert_id($dbh);

				// if($_POST['logcheck'] == '1'){
				// 	setcookie("user_id",mysqli_insert_id($dbh),time()*60*60*24*7);
				// }
				header("Location: index.php?submit=true");
			}
		}

	if($signerror != ""){
		$signerror ="<p> Error Found: </p> ".$signerror;
	}
}
 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Your Personal Diary</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>
<body>

	<div class="main py-5">
		<div class="container">

	<ul class="nav nav-tabs" id="myTab" role="tablist">
	  <li class="nav-item">
	    <a class="nav-link active" id="signup-tab" data-toggle="tab" href="#signup-this" role="tab" aria-controls="signup" aria-selected="true">Sign Up</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" id="signin-tab" data-toggle="tab" href="#signin-this" role="tab" aria-controls="signin" aria-selected="false">Sign In</a>
	  </li>
	</ul>
		<div class="tab-content" id="myTabContent">
		  <div class="tab-pane fade show active" id="signup-this" role="tabpanel" aria-labelledby="signup-tab">
		  	<h2 class="pt-4 pb-3">Sign Up</h2>
			<?php if($signerror){
				?>
				<div class="alert alert-danger">
					<?php echo $signerror; ?>
				</div>
				<?php
			} ?>
			<form method="post" id="signup_form">
			 	<div class="form-group">
			 		<label for="userid">Username</label>
			 		<input type="text" name="userid" id="userid" class="form-control" placeholder="Your Name" required>
			 	</div>
		
			 	<div class="form-group">
			 		<label for="emailid">Email</label>
			 		<input type="email" name="emailid" id="emailid" class="form-control" placeholder="Your Email" required>
			 	</div>
		
			 	<div class="form-group">
			 		<label for="pswdup">Password</label>
			 		<input type="text" name="pswdup" id="pswdup" class="form-control" placeholder="Your Password" required>
			 	</div>
		
			 	<input type="submit" name="signup" id="signup" class="btn btn-info px-5" value="Sign Up">
			</form>
		  </div>
		  <div class="tab-pane fade" id="signin-this" role="tabpanel" aria-labelledby="signin-tab">
		  	<h2 class="pt-4 pb-3">Sign In</h2>
			<?php if($logerror){
				?>
				<div class="alert alert-danger pt-3">
					<?php echo $logerror; ?>
				</div>
				<?php
			} ?>
			<form method="post" id="login_form">
		
			 	<div class="form-group">
			 		<label for="loguserid">Email</label>
			 		<input type="email" name="loguserid" id="loguserid" class="form-control" placeholder="Your Email" required>
			 	</div>
			 	
			 	<div class="form-group">
			 		<label for="pswd">Password</label>
			 		<input type="text" name="pswd" id="pswd" class="form-control" placeholder="Your Password" required>
			 	</div>
		
			 	<div class="form-group">
			 		<label><input type="checkbox" name="logcheck" value="1"> Remember Me</label>
			 	</div>
		
			 	<input type="submit" name="signin" id="signin" class="btn btn-success px-5" value="Sign In">
			</form>
		  </div>
		</div>
		</div>
	</div>

<!-- Scripts -->
 <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
 <script type="text/javascript" src="bootstrap.bundle.min.js"></script>

</body>
</html>