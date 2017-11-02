<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>

<!DOCTYPE html>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>About Us</title>
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
			<li><a href="Forum.php">Forum</a></li>
			<li><a href="Services.php">Services</a></li>
			<li class="active"><a href="#">About Us</a></li>
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
 <?php
 global $SelectDB;
 if(isset($_GET["Page"]))
 {
 $Page=$_GET["Page"];
 if($Page<1)
 {
 $ShowAdminFrom=0;
 $Page=1;
 }
 else
 {
 $ShowAdminFrom=($Page*3)-3;
 }
 $ViewQuery="SELECT * FROM registration ORDER BY id desc LIMIT $ShowAdminFrom,3";
 }
 else
 {
 $Page=1;
 $ViewQuery ="SELECT * FROM registration ORDER BY id desc LIMIT 0,3";
 }
 $Execute=mysql_query($ViewQuery);
 while($DataRows=mysql_fetch_array($Execute)){
 $AdminId=$DataRows["id"];
 $Name=$DataRows["name"];
 $Info=$DataRows["info"];
 $Image=$DataRows["image"];
 $Email=$DataRows["email"];
 $PhNo=$DataRows["phno"];
 ?>
 <div class="blogpost thumbnail row">
 <div class="col-sm-4">
 <img class="img-responsive img-rounded"src="images/Admins/<?php echo $Image;  ?>" width=250px;>
 </div>
 <div class="col-sm-8">
 <h2 id="heading"> <?php echo $Name; ?></h2>
 <p class="post"><?php
 if(strlen($Info)>500){$Info=substr($Info,0,500).'...';}
 echo $Info; ?></p>
 </div>
 <a href="About Admin.php?id=<?php echo $AdminId; ?>"><span class="btn btn-info">
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
	       if($Page>1){
?>
<li><a href="About Us.php?Page=<?php echo $Page-1; ?>"> &laquo; </a></li>
         <?php } ?>			
<?php
global $SelectDB;
$QueryPagination="SELECT COUNT(*) FROM registration";
$ExecutePagination=mysql_query($QueryPagination);
$RowPagination=mysql_fetch_array($ExecutePagination);
mysql_free_result($ExecutePagination);
  $TotalAdmins=array_shift($RowPagination);
  $AdminPagination=$TotalAdmins/3;
  $AdminPagination=ceil($AdminPagination);

for($i=1;$i<=$AdminPagination;$i++){
if($i==$Page){
?>
<li class="active"><a href="About Us.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
<?php
}else{ ?>
<li><a href="About Us.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>	
<?php
}

} ?>
<!-- Creating Forward Button -->
<?php
	       if($Page+1<=$AdminPagination){
?>
<li><a href="About Us.php?Page=<?php echo $Page+1; ?>"> &raquo; </a></li>
         <?php } ?>	
</ul>
</nav>
</div> <!-- Ending of Container-->

<div id="Footer">
<hr>
<p>Theme By | SHASHANK SIMHA M R |<br>&copy;Simha<br> All right reserved.</p>
<hr>
</div>

<div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>