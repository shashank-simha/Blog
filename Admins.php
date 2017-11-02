<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php Confirm_Login() ?>
<?php

if(isset($_POST["Submit"]))
{
$currentAdmin=$_SESSION["User_Id"];
$SuperAdminQuery="SELECT superadmin FROM registration WHERE id='$currentAdmin'";
$SuperAdminExecute=mysql_query($SuperAdminQuery);
$SuperAdmin=mysql_fetch_array($SuperAdminExecute);
mysql_free_result($SuperAdminExecute);
$SuperAdmin=$SuperAdmin["superadmin"];
if($SuperAdmin=="YES")
{
$Username=mysql_real_escape_string($_POST["Username"]);
$Password=mysql_real_escape_string($_POST["Password"]);
$ConfirmPassword=mysql_real_escape_string($_POST["ConfirmPassword"]);
$DateTime = date("d-m-Y")."<br>".date("h:i:s A");
$Admin=$_SESSION["Username"];
//check for availability of username
$UsernameCheckQuery="SELECT * FROM registration where username='$Username'";
$UsernameCheckExecute =mysql_query($UsernameCheckQuery);
$UsernameArray=mysql_fetch_array($UsernameCheckExecute);
mysql_free_result($UsernameCheckExecute);
$UsernameExist=$UsernameArray["id"];
$Usernameavailable=null;
if($UsernameExist)
{
 $Usernameavailable="NO";
}
//
if(empty($Username)||empty($Password)||empty($ConfirmPassword)){
	$_SESSION["ErrorMessage"]="All Fields must be filled out";
	Redirect_to("Admins.php");	
}
elseif(!empty($Usernameavailable))
{
 $_SESSION["ErrorMessage"]="User Name already exist.";
 Redirect_to("Admins.php");	
}
elseif(strlen($Password)<4)
{
	$_SESSION["ErrorMessage"]="Password length is too short";
	Redirect_to("Admins.php");
}
elseif(strlen($Password)>100)
{
	$_SESSION["ErrorMessage"]="Password length is too long";
	Redirect_to("Admins.php");
}
elseif($Password!==$ConfirmPassword)
{
	$_SESSION["ErrorMessage"]="Password / ConfirmPassword does not match";
	Redirect_to("Admins.php");
}
else
{
	global $SelectDB;
	$Query="INSERT INTO registration(datetime,username,password,addedby,superadmin,name)
	VALUES('$DateTime','$Username','$Password','$Admin','NO','$Username')";
	$Execute=mysql_query($Query);
	if($Execute)
	{
	$_SESSION["SuccessMessage"]="Admin Added Successfully ";
	Redirect_to("Admins.php");
	}
	else
	{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Admins.php");		
	}	
  }
 }
 else
 {
 $_SESSION["ErrorMessage"]="Super Admin previlages required to Manage Admins.";
 Redirect_to("Admins.php");
 }
}
?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Manage Admins</title>
                <link rel="stylesheet" href="CSS/bootstrap.min.css">
                <script src="js/jquery-3.2.1.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="CSS/adminstyles.css">
<style>

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
		<li><a href="index.php" target="_Blank">Home</a></li>
		<li><a href="Services.php" target="_Blank">Services</a></li>
		<li><a href="Forum.php" target="_Blank">Forum</a></li>
		<li><a href="About Us.php" target="_Blank">About Us</a></li>
		<li><a href="Contact Us.php" target="_Blank">Contact Us</a></li>
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
	<div class="col-sm-2">
	<br><br>
	<ul id="Side_Menu" class="nav nav-pills nav-stacked">
<li>
<a href="Dashboard.php">
<span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a>
</li>
<li><a href="Add New Post.php">
<span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a>
</li>
<li><a href="Categories.php">
<span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a>
</li>
<li class="active"><a href="#">
<span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a>
</li>
<li><a href="Comments.php">
<span class="glyphicon glyphicon-comment"></span>&nbsp;Comments
<?php
$SelectDB;
$QueryTotal="SELECT COUNT(*) FROM comments WHERE status='OFF'";
$ExecuteTotal=mysql_query($QueryTotal);
$RowsTotal=mysql_fetch_array($ExecuteTotal);
mysql_free_result($ExecuteTotal);
$Total=array_shift($RowsTotal);
if($Total>0){
?>
<span class="label pull-right label-warning">
<?php echo $Total;?>
</span>
<?php }?>
</a>	
</li>
<li><a href="Enquiries.php">
<span class="glyphicon glyphicon-question-sign"></span>&nbsp;Enquiries</a>
</li>
</li>
<li><a href="index.php" target="_Blank">
<span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a>
</li>
<li><a href="Settings.php">
<span class="glyphicon glyphicon-wrench"></span>&nbsp;Settings</a>
</li>
<li><a href="Logout.php">
<span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
</li>		
	</ul>
	</div><!-- Ending of Side area -->
	
	<div class="col-sm-10"> <!--Main Area-->
	<h1>Manage Admin Access</h1>
	<?php echo ErrorMessage();
	echo SuccessMessage();
	?>
	<div>
	<form action="Admins.php" method="POST">
	<fieldset>
	<div class="form-group">
	<label for="Username"><span class="FieldInfo">User Name:</span></label>
	<input class="form-control" type="text" name="Username" id="Username" placeholder="User name">
	</div>
	<div class="form-group">
	<label for="Password"><span class="FieldInfo">Password:</span></label>
	<input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
	</div>
	<div class="form-group">
	<label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span></label>
	<input class="form-control" type="Password" name="ConfirmPassword" id="ConfirmPassword" placeholder=" Retype same Password">
	</div>
	<br>
	<input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Admin">
	</fieldset>
	<br>
	</form>
	</div>
	<div class="table-responsive">
	<table class="table table-striped table-hover">
	<tr>
	<th>Sr No.</th>
	<th>Date & Time</th>
	<th>Admin Name</th>
	<th>Added By</th>
	<th>Action</th>
	</tr>
<?php
global $SelectDB;
$ViewQuery="SELECT * FROM registration ORDER BY id desc";
$Execute=mysql_query($ViewQuery);
$SrNo=0;
while($DataRows=mysql_fetch_array($Execute))
{
	$Id=$DataRows["id"];
	$DateTime=$DataRows["datetime"];
	$Username=$DataRows["username"];
	$Admin=$DataRows["addedby"];
	$SrNo++;
?>
<tr>
	<td><?php echo $SrNo; ?></td>
	<td><?php echo $DateTime; ?></td>
	<td><?php echo $Username; ?></td>
	<td><?php echo $Admin; ?></td>
	<td><a href="Delete Admin.php?id=<?php echo $Id;?>">
	<span class="btn btn-danger">Delete</span></a></td>
	
</tr>
		
	<?php }
	 mysql_free_result($Execute);
	 ?>	
	</table><br><br>
	<div>
	<a href="Super Admins.php">
	<span class="btn btn-primary pull-right">Super Admins</span></a>
	</div>
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