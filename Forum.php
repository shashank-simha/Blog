<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php
if(isset($_POST["SubmitQuestion"]))
{
$Name=mysql_real_escape_string($_POST["Name"]);
$Email=mysql_real_escape_string($_POST["Email"]);
$PhNo=mysql_real_escape_string($_POST["PhNo"]);
$Comment=mysql_real_escape_string($_POST["Comment"]);
$Title=mysql_real_escape_string($_POST["Title"]);
$Tags=mysql_real_escape_string($_POST["Tags"]);
date_default_timezone_set("Asia/Kolkata");
$DateTime = date("d-m-Y")."<br>".date("h:i:s A");
if(empty($Name)||empty($Email) ||empty($Comment)||empty($PhNo)||empty($Title)||empty($Tags)){
	$_SESSION["ErrorMessage"]="All Fields are required";
		Redirect_to("Forum.php");
}
elseif(strlen($Comment)>10000)
{
	$_SESSION["ErrorMessage"]="Only 10000 Characters are Allowed in Description";
	Redirect_to("Forum.php");
	}
else
{
	global $SelectDB;
    $Query="INSERT into questions (datetime,name,email,phno,description,title,tags)
	VALUES ('$DateTime','$Name','$Email','$PhNo','$Comment','$Title','$Tags')";
	$Execute=mysql_query($Query);
	if($Execute)
	{
	$_SESSION["SuccessMessage"]="Request Submitted Successfully";
	Redirect_to("Forum.php");
	}
	else
	{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Forum.php");
	}	
}		
}
?>
<!DOCTYPE html>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Forum</title>
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
			<li class="active"><a href="#">Forum</a></li>
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
<div class="col-sm-offset-1 col-sm-10 " >
<div class="row" >
<?php echo ErrorMessage();
echo SuccessMessage();
?>
<div class="form-group">
<form action="Forum.php" >
<input type="text" class="" placeholder="Search" name="SearchForum" >
<button type="submit" class="btn btn-default" name="SearchForumButton">Go</button>
</form>
<div>
<button class="btn btn-lg btn-primary pull-right" data-toggle="modal" data-target="#ask" >Ask a question</button>
</div>
</div>
<div class="modal fade"  id="ask"  tabindex="-1"  role="dialog"  arialabelledby="Label"  aria-hidden="true">   
<div class="modal-dialog"  role="document">     
<div class="modal-content">       
<div class="modal-header">        
 <h5 class="modal-title"  id="Label">Ask a Question</h5>         
 <button type="button"  class="close"  data-dismiss="modal"  aria-label="Close">    
 <span aria-hidden="true">&times;</span>      
  </button> 
  </div> 
  </div>      
   <div class="modal-body bg-info">      
         <form  action="Forum.php" method="post" enctype="multipart/form-data">
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
         <label for="Title"><span class="FieldInfo">Title</span></label>
         <input class="form-control" type="text" name="Title" id="Title" placeholder="Title">
         </div>
         <div class="form-group">
         <label for="Tags"><span class="FieldInfo">Tags</span></label>
         <input class="form-control" type="text" name="Tags" id="Tags" placeholder="Tags">
         </div>
         <div class="form-group">
         <label for="commentarea"><span class="FieldInfo">Question:</span></label>
         <textarea class="form-control" name="Comment" id="commentarea"></textarea>
         <br>
         </fieldset>
         <br>
         <button type="button"  class="btn btn-secondary"  data-dismiss="modal">Close</ button>         
         <button class="btn btn-primary" type="Submit" name="SubmitQuestion">Submit</button>
         </form>
     </div>      
      <div class="modal-footer">      
      
        </div>   
        </div>  
        </div>
       </div>
<?php
global $SelectDB;
if(isset($_GET["SearchForumButton"]) && (!empty($_GET["SearchForum"])))
{
$Page=null;
$Search=$_GET["SearchForum"];
$ViewQuery="SELECT * FROM questions
WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%'
OR tags LIKE '%$Search%' OR description LIKE '%$Search%' ORDER BY id desc";
}

elseif(isset($_GET["Page"]))
{
$Page=$_GET["Page"];
if($Page<1)
{
$ShowQuestionFrom=0;
$Page=1;
}
else
{
$ShowQuestionFrom=($Page*5)-5;
}
$ViewQuery="SELECT * FROM questions ORDER BY id desc LIMIT $ShowQuestionFrom,5";
}
else
{
$Page=1;
$ViewQuery ="SELECT * FROM questions ORDER BY id desc LIMIT 0,5";
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
<p class="post"><?php
if(strlen($Question)>150){$Question=substr($Question,0,150).'...';}
echo $Question; ?></p>
<a href="Full Question.php?id=<?php echo $QuestionId; ?>"><button class="btn btn-primary">
Read More &rsaquo;&rsaquo;
</button></a>
</div><hr>
<?php }
 mysql_free_result($Execute);
 ?>
<!--pagination-->
<div>
<nav>
	<ul class="pagination pull-left pagination-lg">
	<!-- Creating backward Button -->
	<?php
	if(!empty($Page)){
	       if($Page>1){
?>
<li><a href="Forum.php?Page=<?php echo $Page-1; ?>"> &laquo; </a></li>
        <?php } 
        
        }?>			
<?php
if(!empty($Page)){
global $SelectDB;
$QueryPagination="SELECT COUNT(*) FROM questions";
$ExecutePagination=mysql_query($QueryPagination);
$RowPagination=mysql_fetch_array($ExecutePagination);
mysql_free_result($ExecutePagination);
 $TotalPosts=array_shift($RowPagination);
 $PostPagination=$TotalPosts/5;
 $PostPagination=ceil($PostPagination);

for($i=1;$i<=$PostPagination;$i++){
if($i==$Page){
?>
<li class="active"><a href="Forum.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
<?php
}else{ ?>
<li><a href="Forum.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>	
<?php
}

}
} ?>
<!-- Creating Forward Button -->
<?php
	      if(!empty($Page)){ 
	       if($Page+1<=$PostPagination){
?>
<li><a href="Forum.php?Page=<?php echo $Page+1; ?>"> &raquo; </a></li>
        <?php } 
        
    }    ?>	
</ul>
</nav>
</div>
</div>
</div>
</div> <!-- Ending of Container-->

<div id="Footer">
<hr>
<p>Theme By | SHASHANK SIMHA M R |<br>&copy;Simha<br> All right reserved.</p>
<hr>
</div>

<div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>