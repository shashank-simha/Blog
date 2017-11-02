<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php Confirm_Login() ?>
<?php
$SelectDB;
$currentAdmin=$_SESSION["User_Id"];
$Query="SELECT * FROM registration WHERE id='$currentAdmin'";
$ExecuteQuery=mysql_query($Query);
while($DataRows=mysql_fetch_array($ExecuteQuery)){
	$NameToBeUpdated=$DataRows['name'];
	$UserNameToBeUpdated=$DataRows['username'];
	$ImageToBeUpdated=$DataRows['image'];
	$EmailToBeUpdated=$DataRows['email'];		
	$PhNoToBeUpdated=$DataRows['phno'];		
	$InfoToBeUpdated=$DataRows['info'];		
}
mysql_free_result($ExecuteQuery);
?>
<?php
$currentAdmin=$_SESSION["User_Id"];
if(isset($_POST["UpdateInfo"]))
{
$Name =mysql_real_escape_string($_POST["Name"]);
$Info =mysql_real_escape_string($_POST["Info"]);
$Image =$_FILES["Image"]["name"];
$Email =mysql_real_escape_string($_POST["Email"]);
$PhNo =mysql_real_escape_string($_POST["PhNo"]);
if(empty($Name))
{
	$Name = $NameToBeUpdated;
}
if(empty($Email))
{
	$Email = "N/A";
}
if(empty($PhNo))
{
	$PhNo = "N/A";
}
if(empty($Image))
{
$Image = $ImageToBeUpdated;
}
else
{
$Target="images/Admins/".basename($_FILES["Image"]["name"]);
}
if(strlen($Name)>200)
{
	$_SESSION["ErrorMessage"]="Name can not be more than 200 characters !";
    Redirect_to("Settings.php");
}
elseif(strlen($Info)>2000)
{
	$_SESSION["ErrorMessage"]="User Info is too long !";
    Redirect_to("Settings.php");
}
else
{
	global $SelectDB;
	$Query="UPDATE registration SET name='$Name',image='$Image',info='$Info',email='$Email',phno='$PhNo' WHERE id='$currentAdmin'";
	$Execute=mysql_query($Query);
	move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
	if($Execute)
	{
	mysql_free_result($Execute);
	$_SESSION["SuccessMessage"]="Details Updated Successfully";
	Redirect_to("Settings.php");	
	}
	else
	{
	mysql_free_result($Execute);
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Settings.php");		
	}	
  }		
}
?>
<?php
$currentAdmin=$_SESSION["User_Id"];
if(isset($_POST["ChangeUserName"]))
{
$UserName =mysql_real_escape_string($_POST["UserName"]);
if(empty($UserName))
{
	$_SESSION["ErrorMessage"]="User Name can't be empty";
    Redirect_to("Settings.php");
}
else
{
    global $SelectDB;
    //check for availability of username
    $UsernameCheckQuery="SELECT * FROM registration where username='$UserName'";
    $UsernameCheckExecute =mysql_query($UsernameCheckQuery);
    $UsernameArray=mysql_fetch_array($UsernameCheckExecute);
    mysql_free_result($UsernameCheckExecute);
    $UsernameExist=$UsernameArray["id"];
    $Usernameavailable=null;
    if($UsernameExist)
    {
    $Usernameavailable="NO";
    }
    if(!empty($Usernameavailable))
    {
    $_SESSION["ErrorMessage"]="User Name already exist.";
    Redirect_to("Settings.php");	
    }
    //
	$Query="UPDATE registration SET username='$UserName' WHERE id='$currentAdmin'";
	$Execute=mysql_query($Query);
	if($Execute)
	{
	mysql_free_result($Execute);
	$_SESSION["SuccessMessage"]="User Name changed Successfully";
	Redirect_to("Settings.php");	
	}
	else
	{
	mysql_free_result($Execute);
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Settings.php");		
	}	
  }		
}
?>
<?php 
$currentAdmin=$_SESSION["User_Id"];
$SelectDB;
if(isset($_POST["ChangePassword"]))
{
 $AdminPasswordQuery="SELECT password FROM registration WHERE id='$currentAdmin'";
 $AdminPasswordExecute=mysql_query($AdminPasswordQuery);
 $AdminPassword=mysql_fetch_array($AdminPasswordExecute);
 mysql_free_result($AdminPasswordExecute);
 $AdminPassword=$AdminPassword["password"];
 $CurrentPassword=mysql_real_escape_string($_POST["CurrentPassword"]);
 $NewPassword=mysql_real_escape_string($_POST["NewPassword"]);
 $ConfirmPassword=mysql_real_escape_string($_POST["ConfirmPassword"]);
 if(empty($CurrentPassword)||empty($NewPassword)||empty($ConfirmPassword))
 {
 $_SESSION["ErrorMessage"]="All Password Fields must be filled out";
 Redirect_to("Settings.php");	
 }
 elseif($CurrentPassword!=$AdminPassword)
 {
 $_SESSION["ErrorMessage"]="Current Password is wrong.";
 Redirect_to("Settings.php");
 }
 elseif(strlen($NewPassword)<4)
 {
 $_SESSION["ErrorMessage"]="Password length is too short";
 Redirect_to("Settings.php");
 }
 elseif(strlen($NewPassword)>100)
 {
 $_SESSION["ErrorMessage"]="Password length is too long";
 Redirect_to("Settings.php");
 }
 elseif($NewPassword!==$ConfirmPassword)
 {
 $_SESSION["ErrorMessage"]="Password / ConfirmPassword does not match";
 Redirect_to("Settings.php");
 }
 else
 {
 global $SelectDB;
 $Query="UPDATE registration SET password='$NewPassword' WHERE id='$currentAdmin'";
 $Execute=mysql_query($Query);
 if($Execute)
 {
 mysql_free_result($Execute);
 $_SESSION["SuccessMessage"]="Password changed Successfully";
 Redirect_to("Settings.php");
 }
 else
 {
 mysql_free_result($Execute);
 $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
 Redirect_to("Settings.php");
 }	
 }
}
?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Personal Settings</title>
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
<li><a href="#">
<span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a>
</li>
<li><a href="Categories.php">
<span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a>
</li>
<li><a href="Admins.php">
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
<li class="active"><a href="Settings.php">
<span class="glyphicon glyphicon-wrench"></span>&nbsp;Settings</a>
</li>
<li><a href="Logout.php">
<span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
</li>		
	</ul>
	</div><!-- Ending of Side area -->
	
	<div class="col-sm-10"> <!--Main Area-->
	<h1>Personal Settings</h1>
	<?php echo ErrorMessage();
	      echo SuccessMessage();
	?>
	<div>
	<b id="generalInfo">General Info</b>
	<br>
	<div id="generalInfoSub" hidden="hidden" >
	<form action="Settings.php" method="post" enctype="multipart/form-data">
	<fieldset>
	<div class="form-group">
	<label for="Name"><span class="FieldInfo">Name:</span></label>
	<input value="<?php echo $NameToBeUpdated; ?>" class="form-control" type="text" name="Name" id="Name" placeholder="Name">
	</div>
	<div class="form-group">
	<span class="FieldInfo"> Existing Image: </span>
	<img src="images/Admins/<?php echo $ImageToBeUpdated;?>" width=170px; height=70px;>
	<br>
	<label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
	<input  type="File" class="form-control" name="Image" id="imageselect">
	</div>
	<div class="form-group">
	<label for="Email"><span class="FieldInfo">Email:</span></label>
	<input value="<?php echo $EmailToBeUpdated; ?>" class="form-control" type="email" name="Email" id="Email" placeholder="Email">
	</div>
	<div class="form-group">
	<label for="PhNo"><span class="FieldInfo">Phone No.:</span></label>
	<input value="<?php echo $PhNoToBeUpdated; ?>" class="form-control" type="text" name="PhNo" id="PhNo" placeholder="Ph No.">
	</div>
	<div class="form-group">
	<label for="infoarea"><span class="FieldInfo">About you:</span></label>
	<textarea class="form-control" name="Info" id="infoarea">
	<?php echo $InfoToBeUpdated; ?>
	</textarea>
	<br>
	</div>
	<input class="btn btn-warning btn-block" type="Submit" name="UpdateInfo" value="Save changes">
	</fieldset>
	<br>
	</form>
	</div>
	</div>
	<div>
	 <b id="changeUsername" >Change User Name</b><br>
	 <div id="changeUsernameSub" hidden="hidden" >
	<form action="Settings.php" method="POST">
	<fieldset>
	<div class="form-group">
     <label for="UserName"><span class="FieldInfo">User Name:</span></label>
     <input class="form-control" value="<?php echo $UserNameToBeUpdated; ?>" type="text" name="UserName" id="UserName" placeholder="User Name">
    </div>
	<br>
	<input class="btn btn-warning btn-block" type="Submit" name="ChangeUserName" value="Change User Name">
	</fieldset>
	<br>
	</form>
	</div>
	</div>
	<div>
	 <b id="changePassword" >Change Password</b><br>
	<div id="changePasswordSub" hidden="hidden" >
	<form action="Settings.php" method="POST">
	<fieldset>
	<div class="form-group">
	<label for="CurrentPassword"><span class="FieldInfo">Current Password:</span></label>
	<input class="form-control" type="Password" name="CurrentPassword" id="CurrentPassword" placeholder="Current Password">
	</div>
	<div class="form-group">
	<label for="NewPassword"><span class="FieldInfo">New Password:</span></label>
	<input class="form-control" type="Password" name="NewPassword" id="NewPassword" placeholder="New Password">
	</div>
	<div class="form-group">
	<label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span></label>
	<input class="form-control" type="Password" name="ConfirmPassword" id="ConfirmPassword" placeholder=" Retype New Password">
	</div>
	<br>
	<input class="btn btn-warning btn-block" type="Submit" name="ChangePassword" value="Change Password">
	</fieldset>
	<br>
	</form>
	</div>
	</div>
	<div>
    <b id="deleteAccount">Delete Account</b><br>
    <div id="deleteAccountSub" hidden="hidden" >
    <a href="Delete Account.php" >
    <input class="btn btn-danger btn-block" type="Submit" name="Submit" value="Delete Account">
	</a>
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
	<script type="text/javascript">
	$("#generalInfo").click(function() {
	$("#generalInfoSub").slideToggle(500);
	});
	$("#changeUsername").click(function() {
	$("#changeUsernameSub").slideToggle(500);
	});
	$("#changePassword").click(function() {
	$("#changePasswordSub").slideToggle(500);
	});
	$("#deleteAccount").click(function() {
	$("#deleteAccountSub").slideToggle(500);
	});
	</script>
	</html>