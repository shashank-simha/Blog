<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>

<!DOCTYPE html>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Live Blog</title>
                <link rel="stylesheet" href="CSS/bootstrap.min.css">
                <script src="js/jquery-3.2.1.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="CSS/publicstyles.css">
<style type="text/css">
body 
{
 background-color:#dfdfdf;
}		
.FieldInfo{
    color: rgb(251, 174, 44);
    font-family: Bitter,Georgia,"Times New Roman",Times,serif;
    font-size: 1.2em;
}
.CommentBlock{
background-color:#F6F7F9;
}
.Comment-info{
	color: #365899;
	font-family: sans-serif;
	font-size: 1.1em;
	font-weight: bold;
	padding-top: 10px;	
}
.comment{
    margin-top:-2px;
    padding-bottom: 10px;
    font-size: 1.1em
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
			<li class="active"><a href="About Us.php">About Us</a></li>
			<li><a href="Contact Us.php">Contact Us</a></li>
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

<div class="container-fluid">
<div class="row">
 <div class="col-sm-offset-1 col-sm-10 " >
 <?php echo ErrorMessage();
 echo SuccessMessage();
 ?>
<?php
global $SelectDB;

$AdminIDFromURL=$_GET["id"];
$ViewQuery ="SELECT * FROM registration WHERE id='$AdminIDFromURL'";
$Execute=mysql_query($ViewQuery);
$DataRows=mysql_fetch_array($Execute);
mysql_free_result($Execute);
$AdminName=$DataRows["name"];
$Image=$DataRows["image"];
$AdminInfo=$DataRows["info"];
$AdminEmail=$DataRows["email"];
$AdminPhNo=$DataRows["phno"];
?>
<div>
<img class="img-responsive img-rounded " src="images/Admins/<?php echo $Image;?>">	
</div>
<div class="blog" >
<div class="" ><b><?php echo $AdminName;?></b></div><br><br>
<p><?php echo $AdminInfo;?></p>
</div>
<div>
Email: <?php echo $AdminEmail;?><br>
Phone No: <?php echo $AdminPhNo;?>
</div>
 </div>
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