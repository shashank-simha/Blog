<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php
if(isset($_POST["Submit"]))
{
$Name=mysql_real_escape_string($_POST["Name"]);
$Email=mysql_real_escape_string($_POST["Email"]);
$Comment=mysql_real_escape_string($_POST["Comment"]);
date_default_timezone_set("Asia/Kolkata");
$DateTime = date("d-m-Y")."<br>".date("h:i:s A");
$PostId=$_GET["id"];
if(empty($Name)||empty($Email) ||empty($Comment)){
	$_SESSION["ErrorMessage"]="All Fields are required";
		Redirect_to("Full Post.php?id={$PostId}");
}
elseif(strlen($Comment)>500)
{
	$_SESSION["ErrorMessage"]="Only 500 Characters are Allowed in Comment";
	Redirect_to("Full Post.php?id={$PostId}");
	}
else
{
	global $SelectDB;
	$PostIDFromURL=$_GET['id'];
    $Query="INSERT into comments (datetime,name,email,comment,approvedby,status,posts_id)
	VALUES ('$DateTime','$Name','$Email','$Comment','Pending','OFF','$PostIDFromURL')";
	$Execute=mysql_query($Query);
	if($Execute)
	{
	$_SESSION["SuccessMessage"]="Comment Submitted Successfully";
	Redirect_to("Full Post.php?id={$PostId}");
	}
	else
	{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Full Post.php?id={$PostId}");
	}	
}		
}
?>
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
			<li class="active" ><a href="index.php">Home</a></li>
			<li><a href="Services.php">Services</a></li>
			<li><a href="Forum.php">Forum</a></li>	
			<li><a href="About Us.php">About Us</a></li>
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
 <div class="col-xs-7" >
 <?php echo ErrorMessage();
 echo SuccessMessage();
 ?>
<?php
global $SelectDB;
if(isset($_GET["SearchButton"]) && (!empty($_GET["Search"])))
{
$Search=$_GET["Search"];
$ViewQuery="SELECT * FROM posts
WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%'
OR category LIKE '%$Search%' OR post LIKE '%$Search%' ORDER BY id desc";
}
else
{
$PostIDFromURL=$_GET["id"];
$ViewQuery ="SELECT * FROM posts WHERE id='$PostIDFromURL' ORDER BY datetime desc";
}
$Execute=mysql_query($ViewQuery);
while($DataRows=mysql_fetch_array($Execute)){
$PostId=$DataRows["id"];
$DateTime=$DataRows["datetime"];
$Title=$DataRows["title"];
$Category=$DataRows["category"];
$AdminId=$DataRows["adminid"];
$Image=$DataRows["image"];
$Post =$DataRows["post"];
$DownloadLink=$DataRows["link"];
?>
<div class="blogpost thumbnail">
<img class="img-responsive img-rounded"src="Upload/<?php echo $Image;  ?>" >
<div class="caption">
<h1 id="heading"> <?php echo $Title; ?></h1>
<p class="description">Category:<?php echo $Category; ?> <br>
Published on <?php echo $DateTime;?>
</p>
<p class="post"><?php echo $Post; ?></p>
</div>
<div class="">
<a href="https://<?php echo $DownloadLink; ?>">
<span class="glyphicon glyphicon-download-alt"></span>&nbsp;Download</a>
</div>
</div>
<?php }
 mysql_free_result($Execute);
 ?>
 
 <br><br>
 <br><br>
 <div class="bg-warning" >
 <span class="FieldInfo">Comments</span>
<?php
$SelectDB;
$PostIdForComments=$_GET["id"];
$ExtractingCommentsQuery="SELECT * FROM comments
WHERE posts_id='$PostIdForComments' AND status='ON' ";
$Execute=mysql_query($ExtractingCommentsQuery);
while($DataRows=mysql_fetch_array($Execute))
{
	$CommentDate=$DataRows["datetime"];
	$CommenterName=$DataRows["name"];
	$Comments=$DataRows["comment"];
?>
 <div class="CommentBlock" style="background-color:#ffffff;">
 <img style="margin-left: 10px; margin-top: 10px;" class="pull-left" src="images/comment.png" width=70px; height=70px;>
 <p style="margin-left: 90px;" class="Comment-info"><?php echo $CommenterName; ?></p>
 <p style="margin-left: 90px;"class="description"><?php echo $CommentDate; ?></p>
 <p style="margin-left: 90px;" class="Comment"><?php echo $Comments; ?></p>
 
 </div>
 <hr>
 <?php } 
 mysql_free_result($Execute);
 ?>
 <br>
 </div>
 <div class="bg-info">
 <span class="FieldInfo">Share your thoughts about this post</span>	
 <form  action="Full Post.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data">
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
 <label for="commentarea"><span class="FieldInfo">Comment</span></label>
 <textarea class="form-control" name="Comment" id="commentarea"></textarea>
 <br>
 <input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
 </fieldset>
 <br>
 </form>
 </div>
 </div>
 <div class="col-xs-1" >
 <!-- blank space-->
 </div>
 <div class="col-xs-4" >
<h2>About author</h2>
<?php
 $AdminQuery="SELECT * FROM registration WHERE id='$AdminId'";
 $Execute=mysql_query($AdminQuery);
 $DataRows=mysql_fetch_array($Execute);
 mysql_free_result($Execute);
 $Name=$DataRows["name"];
 $Image=$DataRows["image"];
 $Info=$DataRows["info"];
 if(strlen($Info)>500){$Info=substr($Info,0,500).'...';}
?>
	<img class=" img-responsive img-circle imageicon" src="images/Admins/<?php echo $Image;?>">		
<h3><?php echo $Name;?></h3>
<p><?php echo $Info;?></p>
 <a href="About Admin.php?id=<?php echo $AdminId; ?>"><span class="btn btn-info">
 Read More &rsaquo;&rsaquo;
 </span></a>
 <br><br>

<div class="panel panel-primary">
<div class="panel-heading">
<h2 class="panel-title">Categories</h2>
</div>
<div class="panel-body">
<?php
global $SelectDB;
$ViewQuery="SELECT * FROM categories ORDER BY id desc";
$Execute=mysql_query($ViewQuery);
while($DataRows=mysql_fetch_array($Execute)){
$Id=$DataRows['id'];
$Category=$DataRows['name'];
?>
<a href="index.php?Category=<?php echo $Category; ?>">
<span id="heading"><?php echo $Category."<br>"; ?></span>
</a>
<?php } 
mysql_free_result($Execute);
?>
</div>
<div class="panel-footer">

</div>
</div>
<div class="panel panel-primary">
<div class="panel-heading">
<h2 class="panel-title">Recent Posts</h2>
</div>
<div class="panel-body background">
<?php
$SelectDB;
$ViewQuery="SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
$Execute=mysql_query($ViewQuery);
while($DataRows=mysql_fetch_array($Execute))
{
$Id=$DataRows["id"];
$Title=$DataRows["title"];
$DateTime=$DataRows["datetime"];
$Image=$DataRows["image"];
if(strlen($DateTime)>10){$DateTime=substr($DateTime,0,10);}
?>
<div>
<img class="pull-left" style="margin-top: 10px; margin-left: 0px;"  src="Upload/<?php echo htmlentities($Image); ?>" width=120; height=60;>
<a href="Full Post.php?id=<?php echo $Id;?>">
<p id="heading" style="margin-left: 130px; padding-top: 10px;"><?php echo htmlentities($Title); ?></p>
</a>
<p class="description" style="margin-left: 130px;"><?php echo htmlentities($DateTime);?></p>
<hr>
</div>	
<?php }
 mysql_free_result($Execute);
 ?>	
</div>
<div class="panel-footer">

</div>
</div>
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