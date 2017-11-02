<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php Confirm_Login() ?>
<?php
if(isset($_POST["Submit"]))
{
$Category=mysql_real_escape_string($_POST["Category"]);
date_default_timezone_set("Asia/Kolkata");
$DateTime = date("d-m-Y")."<br>".date("h:i:s A");
$Admin=$_SESSION["Username"];
if(empty($Category))
{
	$_SESSION["ErrorMessage"]="All Fields must be filled out";
	Redirect_to("Categories.php");	
}
elseif(strlen($Category)>99)
{
	$_SESSION["ErrorMessage"]="Category name must not contain more than 99 characters";
	Redirect_to("Categories.php");	
}
else
{
	global $SelectDB;
	$Query="INSERT INTO categories(datetime,name,creator_name) VALUES('$DateTime','$Category','$Admin')";
	$Execute=mysql_query($Query);
	if($Execute)
	{
	$_SESSION["SuccessMessage"]="Category Added Successfully";
	Redirect_to("Categories.php");
	}
	else
	{
	$_SESSION["ErrorMessage"]="Failed to add category";
	Redirect_to("Categories.php");
	}	
  }		
}
?>
<!DOCTYPE html>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Categories</title>
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
	<li class="active"><a href="#">
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
	<li><a href="Settings.php">
	<span class="glyphicon glyphicon-wrench"></span>&nbsp;Settings</a>
	</li>
	<li><a href="#">
	<span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
	</li>		
	</ul>
	</div><!-- Ending of Side area -->
	
	<div class="col-sm-10"> <!--Main Area-->
	<h1>Manage Categories</h1>
	<?php echo ErrorMessage();
	      echo SuccessMessage();
	?>
	<div>
	<form action="Categories.php" method="post">
	<fieldset>
	<div class="form-group">
	<label for="categoryname"><span class="FieldInfo">Name:</span></label>
	<input class="form-control" type="text" name="Category" id="categoryname" placeholder="Name">
	</div>
	<br>
	<input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Category">
	</fieldset>
	<br>
	</form>
	</div>
	
	<div class="table-responsive">
	<table class="table table-striped table-hover">
	<tr>
	<th>Sl. No.</th>
	<th>Date & Time</th>
	<th>Category Name</th>
	<th>Creator Name</th>
	<th>Action</th>
	</tr>
<?php
global $SelectDB;
$ViewQuery="SELECT * FROM categories ORDER BY id desc";
$Execute=mysql_query($ViewQuery);
$SrNo=0;
while($DataRows=mysql_fetch_array($Execute)){
	$Id=$DataRows["id"];
	$DateTime=$DataRows["datetime"];
	$CategoryName=$DataRows["name"];
	$CreatorName=$DataRows["creator_name"];
	$SrNo++;
?>
<tr>
	<td><?php echo $SrNo; ?></td>
	<td><?php echo $DateTime; ?></td>
	<td><?php echo $CategoryName; ?></td>
	<td><?php echo $CreatorName; ?></td>
	<td><a href="Delete Category.php?id=<?php echo $Id;?>">
	<span class="btn btn-danger">Delete</span>
	</a></td>
	
</tr>		
	<?php } 
	mysql_free_result($Execute);
	?>	
	</tr>
	</table>
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