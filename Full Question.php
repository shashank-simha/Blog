<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php
if(isset($_POST["Submit"]))
{
$Name=mysql_real_escape_string($_POST["Name"]);
$Email=mysql_real_escape_string($_POST["Email"]);
$Response=mysql_real_escape_string($_POST["Response"]);
date_default_timezone_set("Asia/Kolkata");
$DateTime = date("d-m-Y")."<br>".date("h:i:s A");
$QuestionId=$_GET["id"];
if(empty($Name)||empty($Email) ||empty($Response)){
	$_SESSION["ErrorMessage"]="All Fields are required";
		Redirect_to("Full Question.php?id={$QuestionId}");
}
elseif(strlen($Response)>10000)
{
	$_SESSION["ErrorMessage"]="Only 10000 Characters are Allowed in Response";
	Redirect_to("Full Question.php?id={$QuestionId}");
	}
else
{
	global $SelectDB;
    $Query="INSERT into responses (datetime,name,email,response,questionid)
	VALUES ('$DateTime','$Name','$Email','$Response','$QuestionId')";
	$Execute=mysql_query($Query);
	if($Execute)
	{
	$_SESSION["SuccessMessage"]="Response added Successfully";
	Redirect_to("Full Question.php?id={$QuestionId}");
	}
	else
	{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Full Question.php?id={$QuestionId}");
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
			<li><a href="index.php">Home</a></li>
			<li><a href="Services.php">Services</a></li>
			<li class="active"><a href="Forum.php">Forum</a></li>	
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
 <div class="col-sm-offset-1 col-sm-10" >
 <?php echo ErrorMessage();
 echo SuccessMessage();
 ?>
<?php
global $SelectDB;
if(isset($_GET["SearchForumButton"]) && (!empty($_GET["SearchForum"])))
{
$Search=$_GET["SearchForum"];
$ViewQuery="SELECT * FROM questioms
WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%'
OR tags LIKE '%$Search%' OR description LIKE '%$Search%' ORDER BY id desc";
}
else
{
$QuestionIDFromURL=$_GET["id"];
$ViewQuery ="SELECT * FROM questions WHERE id='$QuestionIDFromURL' ORDER BY datetime desc";
}
$Execute=mysql_query($ViewQuery);
while($DataRows=mysql_fetch_array($Execute)){
$QuestionId=$DataRows["id"];
$DateTime=$DataRows["datetime"];
$Title=$DataRows["title"];
$Tags=$DataRows["tags"];
$Name=$DataRows["name"];
$Question=$DataRows["description"];
?>
<div class="caption" style="background-color:#ffffff;">
<h1 id="heading"> <?php echo $Title; ?></h1>
<p class="description">Tags:<?php echo $Tags; ?> <br>
Published on <?php echo $DateTime;?>
</p>
<p class="post">
<?php echo $Question; ?></p>
</div>
<?php }
 mysql_free_result($Execute);
 ?>
 
 <br><br>
 <br><br>
 <div class="" >
 <span class="FieldInfo">Responses:</span>
<?php
$SelectDB;
$QuestionId=$_GET["id"];
$ExtractingResponsesQuery="SELECT * FROM responses
WHERE questionid='$QuestionId'";
$Execute=mysql_query($ExtractingResponsesQuery);
while($DataRows=mysql_fetch_array($Execute))
{
	$ResponseDate=$DataRows["datetime"];
	$Name=$DataRows["name"];
	$Response=$DataRows["response"];
?>
 <div class="CommentBlock">
 <img style="margin-left: 10px; margin-top: 10px;" class="pull-left" src="images/comment.png" width=70px; height=70px;>
 <p style="margin-left: 90px;" class="Comment-info"><?php echo $Name; ?></p>
 <p style="margin-left: 90px;"class="description"><?php echo $ResponseDate; ?></p>
 <p style="margin-left: 90px;" class=""><?php echo $Response; ?></p>
 
 </div>
 <hr>
 <?php } 
 mysql_free_result($Execute);
 ?>
 <br>
 </div>
 <div class="bg-info">
 <span class="FieldInfo">Add a response<br></span>	
 <form  action="Full Question.php?id=<?php echo $QuestionId; ?>" method="post" enctype="multipart/form-data">
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
 <label for="commentarea"><span class="FieldInfo">Response</span></label>
 <textarea class="form-control" name="Response" id="Responsearea"></textarea>
 <br>
 <input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
 </fieldset>
 <br>
 </form>
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