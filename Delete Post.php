<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php Confirm_Login() ?>
<?php
$SerachQueryParameter =$_GET['Delete'];
$SelectDB;
$Query="SELECT * FROM posts WHERE id='$SerachQueryParameter'";
$ExecuteQuery=mysql_query($Query);
while($DataRows=mysql_fetch_array($ExecuteQuery)){
	$TitleTobeDeleted=$DataRows['title'];
	$CategoryTobeDeleted=$DataRows['category'];
	$ImageTobeDeleted=$DataRows['image'];
	$PostTobeDeleted=$DataRows['post'];	
	$DownloadLinkTobeDeleted=$DataRows['link'];			
}
mysql_free_result($ExecuteQuery);
?>
<?php
if(isset($_POST["Submit"])){
	global $SelectDB;
	$DeleteFromURL =$_GET['Delete'];
    $Query="DELETE FROM posts WHERE id='$DeleteFromURL'";
	$Execute=mysql_query($Query);
	move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
	if($Execute)
	{
	$_SESSION["SuccessMessage"]="Post Deleted Successfully";
	Redirect_to("Dashboard.php");
	}
	else
	{
		$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
		Redirect_to("Delete Post.php?Delete=".$DeleteFromURL);
	}			
}
?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Delete Post</title>
                <link rel="stylesheet" href="CSS/bootstrap.min.css">
                <script src="js/jquery-3.2.1.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="CSS/adminstyles.css">
<style>
.FieldInfo{
    color: rgb(251, 174, 44);
    font-family: Bitter,Georgia,"Times New Roman",Times,serif;
    font-size: 1.2em;
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
<li ><a href="Categories.php">
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
<li><a href="Logout.php">
<span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
</li>		
	</ul>
	</div><!-- Ending of Side area -->
	
	<div class="col-sm-10"> <!--Main Area-->
	<h1>Delete Post</h1>
<form action="Delete Post.php?Delete=<?php echo $SerachQueryParameter;?>" method="post" enctype="multipart/form-data">
<fieldset>
<div class="form-group">
<label for="title"><span class="FieldInfo">Title:</span></label>
<input disabled value="<?php echo $TitleTobeDeleted; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Title">
</div>
<div class="form-group">
<span class="FieldInfo"> Existing Category: </span>
<?php echo $CategoryTobeDeleted;?>
<br>
<label for="categoryselect"><span class="FieldInfo">Category:</span></label>
<select disabled class="form-control" id="categoryselect" name="Category" >
</select>
</div>
<div class="form-group">
	<span class="FieldInfo"> Existing Image: </span>
<img src="Upload/<?php echo $ImageTobeDeleted;?>" width=170px; height=70px;>
<br>
<label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
<input disabled type="File" class="form-control" name="Image" id="imageselect">
</div>
<div class="form-group">
<label for="postarea"><span class="FieldInfo">Post:</span></label>
<textarea disabled class="form-control" name="Post" id="postarea">
	<?php echo $PostTobeDeleted; ?>
</textarea>
<div class="form-group">
	<label for="link"><span class="FieldInfo">Download link (optional):</span></label>
	<input disabled class="form-control" value="<?php echo $DownloadLinkTobeDeleted; ?>" type="text" name="link" id="link" placeholder="Link">
	</div>
	<br>
	</div>
	<input class="btn btn-danger btn-block" type="Submit" name="Submit" value="Delete Post">
	</fieldset>
</form>
<br>
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