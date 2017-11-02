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
			<li class="active" ><a href="#">Home</a></li>
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
 <?php
 global $SelectDB;
 if(isset($_GET["SearchButton"]) && (!empty($_GET["Search"])))
 {
 $Page=null;
 $Search=$_GET["Search"];
 $ViewQuery="SELECT * FROM posts
 WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%'
 OR category LIKE '%$Search%' OR post LIKE '%$Search%' ORDER BY id desc";
 }
 // QUery When Category is active URL Tab
 elseif(isset($_GET["Category"])){
 $Page=null;
 $Category=$_GET["Category"];
 $ViewQuery="SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";	
 }
 elseif(isset($_GET["Page"]))
 {
 $Page=$_GET["Page"];
 if($Page<1)
 {
 $ShowPostFrom=0;
 $Page=1;
 }
 else
 {
 $ShowPostFrom=($Page*3)-3;
 }
 $ViewQuery="SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,3";
 }
 else
 {
 $Page=1;
 $ViewQuery ="SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
 }
 $Execute=mysql_query($ViewQuery);
 while($DataRows=mysql_fetch_array($Execute)){
 $PostId=$DataRows["id"];
 $DateTime=$DataRows["datetime"];
 $Title=$DataRows["title"];
 $Category=$DataRows["category"];
 $Admin=$DataRows["author"];
 $Image=$DataRows["image"];
 $Post=$DataRows["post"];
 ?>
 <div class="blogpost thumbnail">
 <img class="img-responsive img-rounded"src="Upload/<?php echo $Image;  ?>" >
 <div class="caption">
 <h1 id="heading"> <?php echo $Title; ?></h1>
 <p class="description">Category:<?php echo $Category; ?> <br>
 Published on <?php echo $DateTime;?>
 </p>
 <p class="post"><?php
 if(strlen($Post)>150){$Post=substr($Post,0,150).'...';}
 
 echo $Post; ?></p>
 </div>
 <a href="Full Post.php?id=<?php echo $PostId; ?>"><span class="btn btn-info">
 Read More &rsaquo;&rsaquo;
 </span></a>
 
 </div>
 <?php }
  mysql_free_result($Execute);
  ?>
 <!--pagination-->
<nav>
	<ul class="pagination pull-left pagination-lg">
	<!-- Creating backward Button -->
	<?php
	if(!empty($Page)){
	       if($Page>1){
?>
<li><a href="index.php?Page=<?php echo $Page-1; ?>"> &laquo; </a></li>
         <?php } 
         
         }?>			
<?php
if(!empty($Page)){
global $SelectDB;
$QueryPagination="SELECT COUNT(*) FROM posts";
$ExecutePagination=mysql_query($QueryPagination);
$RowPagination=mysql_fetch_array($ExecutePagination);
mysql_free_result($ExecutePagination);
  $TotalPosts=array_shift($RowPagination);
  $PostPagination=$TotalPosts/3;
  $PostPagination=ceil($PostPagination);

for($i=1;$i<=$PostPagination;$i++){
if($i==$Page){
?>
<li class="active"><a href="index.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
<?php
}else{ ?>
<li><a href="index.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>	
<?php
}

}
} ?>
<!-- Creating Forward Button -->
<?php
	      if(!empty($Page)){ 
	       if($Page+1<=$PostPagination){
?>
<li><a href="index.php?Page=<?php echo $Page+1; ?>"> &raquo; </a></li>
         <?php } 
         
     }    ?>	
</ul>
</nav>
 </div>
 <div class="col-xs-1" >
 <!-- blank space-->
 </div>
 <div class="col-xs-4" >
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