<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php Confirm_Login() ?>
<?php
$SerachQueryParameter =$_GET['Edit'];
$SelectDB;
$Query="SELECT * FROM posts WHERE id='$SerachQueryParameter'";
$ExecuteQuery=mysql_query($Query);
while($DataRows=mysql_fetch_array($ExecuteQuery)){
	$TitleToBeUpdated=$DataRows['title'];
	$CategoryToBeUpdated=$DataRows['category'];
	$ImageToBeUpdated=$DataRows['image'];
	$PostToBeUpdated=$DataRows['post'];
	$DownloadLinkToBeUpdated=$DataRows['link'];
}
mysql_free_result($ExecuteQuery);
?>
<?php
if(isset($_POST["Submit"])){
$Title =mysql_real_escape_string($_POST["Title"]);
$Category =mysql_real_escape_string($_POST["Category"]);
$Post =mysql_real_escape_string($_POST["Post"]);
$DownloadLink=mysql_real_escape_string($_POST["link"]);
if(empty($DownloadLink))
{
$DownloadLink = "#";
}
date_default_timezone_set("Asia/Kolkata");
$DateTime = date("d-m-Y")."<br>".date("h:i:s A");
$Admin=$_SESSION["Username"];
$Image =$_FILES["Image"]["name"];
if(empty($Image))
{
$Image = $ImageToBeUpdated;
}
else
{
$Target="Upload/".basename($_FILES["Image"]["name"]);
}
if(empty($Title)){
	$_SESSION["ErrorMessage"]="Title can't be empty";
	Redirect_to("Edit Post.php?Edit=".$SerachQueryParameter);
}
elseif(strlen($Title)<2)
{
	$_SESSION["ErrorMessage"]="Title should contain atleast 2 characters";
	Redirect_to("Edit Post.php?Edit=".$SerachQueryParameter );
}
elseif(empty($Post))
{
	$_SESSION["ErrorMessage"]="All Fields must be filled out";
	Redirect_to("Edit Post.php?Edit=".$SerachQueryParameter );	
}
else
{
	global $SelectDB;
	$EditFromURL =$_GET['Edit'];
	$Query="UPDATE posts SET datetime='$DateTime', title='$Title',
	category='$Category', author='$Admin',image='$Image',post='$Post',link='$DownloadLink'
	WHERE id='$EditFromURL'";
	$Execute=mysql_query($Query);
	move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
	if($Execute)
	{
	$_SESSION["SuccessMessage"]="Post Updated Successfully";
	Redirect_to("Edit Post.php?Edit=".$SerachQueryParameter);
	}
	else
	{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Edit Post.php?Edit=".$SerachQueryParameter );		
	}	
  }		
}
?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Edit Post</title>
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
	<h1>Edit Post</h1>
	<?php echo ErrorMessage();
	      echo SuccessMessage();
	?>
<div>
<form action="Edit Post.php?Edit=<?php echo $SerachQueryParameter;?>" method="post" enctype="multipart/form-data">
	<fieldset>
	<div class="form-group">
	<label for="title"><span class="FieldInfo">Title:</span></label>
	<input value="<?php echo $TitleToBeUpdated; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Title">
	</div>
	<div class="form-group">
	<span class="FieldInfo"> Existing Category: </span>
	<?php echo $CategoryToBeUpdated;?>
	<br>
	<label for="categoryselect"><span class="FieldInfo">Category:</span></label>
	<select class="form-control" id="categoryselect" name="Category" >
	<?php
	global $SelectDB;
	$ViewQuery="SELECT * FROM categories ORDER BY id desc";
	$Execute=mysql_query($ViewQuery);
	while($DataRows=mysql_fetch_array($Execute)){
	$Id=$DataRows["id"];
	$CategoryName=$DataRows["name"];
	?>	
	<option><?php echo $CategoryName; ?></option>
	<?php } 
	mysql_free_result($Execute);
	?>
	</select>
	</div>
	<div class="form-group">
		<span class="FieldInfo"> Existing Image: </span>
	<img src="Upload/<?php echo $ImageToBeUpdated;?>" width=170px; height=70px;>
	<br>
	<label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
	<input  type="File" class="form-control" name="Image" id="imageselect">
	</div>
	<div class="form-group">
	<label for="postarea"><span class="FieldInfo">Post:</span></label>
	<textarea class="form-control" name="Post" id="postarea">
		<?php echo $PostToBeUpdated; ?>
	</textarea>
	<div class="form-group">
	<label for="link"><span class="FieldInfo">Download link (optional):</span></label>
	<input class="form-control" value="<?php echo $DownloadLinkToBeUpdated; ?>" type="text" name="link" id="link" placeholder="Link">
	<span class="help-block">Please provide download link in case of codes/programmes.</span>
	</div>
	<br>
	</div>
<input class="btn btn-warning btn-block" type="Submit" name="Submit" value="Save changes">
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