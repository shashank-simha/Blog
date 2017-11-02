<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php
if(isset($_POST["Submit"]))
{
$Name=mysql_real_escape_string($_POST["Name"]);
$Email=mysql_real_escape_string($_POST["Email"]);
$PhNo=mysql_real_escape_string($_POST["PhNo"]);
$Comment=mysql_real_escape_string($_POST["Comment"]);
date_default_timezone_set("Asia/Kolkata");
$DateTime = date("d-m-Y")."<br>".date("h:i:s A");
if(empty($Name)||empty($Email) ||empty($Comment)||empty($PhNo)){
	$_SESSION["ErrorMessage"]="All Fields are required";
		Redirect_to("Contact Us.php");
}
elseif(strlen($Comment)>1000)
{
	$_SESSION["ErrorMessage"]="Only 1000 Characters are Allowed in Description";
	Redirect_to("Contact Us.php");
	}
else
{
	global $SelectDB;
    $Query="INSERT into enquiries (datetime,name,email,phno,enquiry)
	VALUES ('$DateTime','$Name','$Email','$PhNo','$Comment')";
	$Execute=mysql_query($Query);
	if($Execute)
	{
	$_SESSION["SuccessMessage"]="Request Submitted Successfully";
	Redirect_to("Contact Us.php");
	}
	else
	{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Contact Us.php");
	}	
}		
}
?>
<!DOCTYPE html>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Contact Us</title>
                <link rel="stylesheet" href="CSS/bootstrap.min.css">
                <script src="js/jquery-3.2.1.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
  	<link rel="stylesheet" href="css/publicstyles.css">
<style type="text/css">
body 
{
 background-color:#dfdfdf;
}
</style>
</head>
<body>
<div style="height: 10px; background: #27aae1;"></div>

<nav class="navbar navbar-inverse" role="navigation">
	<div class="container">
		<div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
		data-target="#collapse">
		<span class="sr-only">Toggle Navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>

		</div>
		<div class="collapse navbar-collapse" id="collapse">
		<ul class="nav navbar-nav">
			<li><a href="index.php">Home</a></li>
			<li><a href="Services.php">Services</a></li>
			<li><a href="Forum.php">Forum</a></li>	
			<li><a href="About Us.php">About Us</a></li>
			<li class="active"><a href="Contact Us.php">Contact Us</a></li>
			<li><a href="Login.php">Login</a></li>
		</ul>
		<form action="index.php" class="navbar-form navbar-right">
		<div class="form-group">
		<input type="text" class="form-control" placeholder="Search" name="Search" >
		</div>
	         <button class="btn btn-default" name="SearchButton">Go</button>
		</form>
		</div>
	</div>
</nav>

<div class="Line" style="height: 10px; background: #27aae1;"></div>

<div class="row">
<div class="col-sm-offset-2 col-sm-8 " >
<h1>Contact Form</h1>
<?php echo ErrorMessage();
echo SuccessMessage();
?>
<form  action="Contact Us.php" method="post" enctype="multipart/form-data">
<fieldset>
<div class="form-group">
<label for="Name"><span class="FieldInfo">Name</span></label>
<input class="form-control" type="text" name="Name" id="Name" placeholder="Name">
</div>
<div class="form-group">
<label for="Email"><span class="FieldInfo">Email</span></label>
<input class="form-control" type="email" name="Email" id="Email" placeholder="email">
</div>
<div class="form-group">
<label for="PhNo"><span class="FieldInfo">Ph No</span></label>
<input class="form-control" type="text" name="PhNo" id="PhNo" placeholder="Phone No.">
</div>
<div class="form-group">
<label for="commentarea"><span class="FieldInfo">Message:</span></label>
<textarea class="form-control" name="Comment" id="commentarea"></textarea>
<br>
<input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
</fieldset>
<br>
</form>
</div>
</div>
<div id="Footer">
<hr>
<p>Theme By | SHASHANK SIMHA M R |<br>&copy;Simha<br> All right reserved.</p>
<hr>
</div>

<div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>