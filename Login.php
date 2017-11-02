<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php
if(isset($_SESSION["User_Id"]))
{
 Redirect_to("Dashboard.php");	
}
else{
if(isset($_POST["Submit"])){
$Username=mysql_real_escape_string($_POST["Username"]);
$Password=mysql_real_escape_string($_POST["Password"]);

if(empty($Username)||empty($Password))
{
	$_SESSION["ErrorMessage"]="All Fields must be filled out";
	Redirect_to("Login.php");	
}
else
 {
	$Found_Account=Login_Attempt($Username,$Password);
	$_SESSION["User_Id"]=$Found_Account["id"];
	$_SESSION["Username"]=$Found_Account["username"];
	if($Found_Account)
	   {
     	$_SESSION["SuccessMessage"]="Welcome  {$_SESSION["Username"]} ";
      	Redirect_to("Dashboard.php");	
       }
	else
       {
		$_SESSION["ErrorMessage"]="Invalid Username / Password";
    	Redirect_to("Login.php");
    	}
  }	
 }	
}
?>

<!DOCTYPE>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
	<head>
		<title>Log-in</title>
                <link rel="stylesheet" href="CSS/bootstrap.min.css">
                <script src="js/jquery-3.2.1.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <link rel="stylesheet" href="CSS/publicstyles.css">
<style>
	.FieldInfo{
    color: rgb(251, 174, 44);
    font-family: Bitter,Georgia,"Times New Roman",Times,serif;
    font-size: 1.2em;
}
body{
	background-color: #ffffff;
}

</style>
                
	</head>
	<body>
	<div style="height: 10px; background: #27aae1;"></div>
<nav class="navbar navbar-inverse" role="navigation">
	<div class="container">
		<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
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
			<li><a href="Contact Us.php">Contact Us</a></li>
			<li class="active" ><a href="#">Login</a></li>
		</ul>
		<form action="#" class="navbar-form navbar-right">
		<div class="form-group">
		<input type="text" class="form-control" placeholder="Search" name="Search" >
		</div>
	    <button class="btn btn-default" name="SearchButton">Go</button>
		</form>
		</div>	
	</div>
</nav>
<div class="Line" style="height: 10px; background: #27aae1;"></div>
<div class="container-fluid">
<div class="row">
	
	<div class="col-sm-offset-3 col-sm-6">
		<br><br><br><br>
	<h2>Welcome</h2>
	<?php echo ErrorMessage();
	      echo SuccessMessage();
	?>
<div>
<form action="Login.php" method="post">
	<fieldset>
	<div class="form-group">
	<label for="Username"><span class="FieldInfo">UserName:</span></label>
	<div class="input-group input-group-lg">
	<span class="input-group-addon">
	<span class="glyphicon glyphicon-envelope text-primary"></span>
	</span>
	<input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
	</div>	
	</div>
	
	<div class="form-group">
	<label for="Password"><span class="FieldInfo">Password:</span></label>
	<div class="input-group input-group-lg">
	<span class="input-group-addon">
	<span class="glyphicon glyphicon-lock text-primary"></span>
	</span>
	<input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
	</div>
	</div>
	<br>
	<input class="btn btn-info btn-block" type="Submit" name="Submit" value="Login">
	</fieldset><br>
</form>
</div>
	
</div> <!-- Ending of Main Area-->	
</div> <!-- Ending of Row-->	
</div> <!-- Ending of Container-->
<div id="Footer">
<hr>
<p>Theme By | SHASHANK SIMHA M R |<br>&copy;Simha<br> All right reserved.</p>
<hr>
</div>

<div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>