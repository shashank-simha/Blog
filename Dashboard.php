<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>
<?php Confirm_Login() ?>

<!DOCTYPE html>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Admin Dashboard</title>
                <link rel="stylesheet" href="CSS/bootstrap.min.css">
                <script src="js/jquery-3.2.1.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="CSS/adminstyles.css">
<style>
    .btn
    {
    margin:2px;
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
<li class="active" >
<a href="#">
<span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a>
</li>
<li><a href="Add New Post.php">
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
<li><a href="Settings.php">
<span class="glyphicon glyphicon-wrench"></span>&nbsp;Settings</a>
</li>
<li><a href="Logout.php">
<span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
</li>		
	</ul>
	</div><!-- Ending of Side area -->
	
	<div class="col-sm-10"> <!--Main Area-->
	<h1 style="background-color:#aaffee;" >Admin Dashboard</h1>
	<?php echo ErrorMessage();
	echo SuccessMessage();
	?>
	<div class="table-responsive">
	<table class="table table-striped table-hover">
		<tr>
			<th>No.</th>
			<th>Post Title</th>
			<th>Date & Time</th>
			<th>Author</th>
			<th>Category</th>
			<th>Banner</th>
			<th>Comments</th>
			<th>Action</th>
			<th>Details</th>		
		</tr>
		<tr>
		<?php
		$SelectDB;
		$ViewQuery="SELECT * FROM posts ORDER BY id desc;";
		$Execute=mysql_query($ViewQuery);
		$SrNo=0;
		while($DataRows=mysql_fetch_array($Execute)){
		$Id=$DataRows["id"];
		$DateTime=$DataRows["datetime"];
		$Title=$DataRows["title"];
		$Category=$DataRows["category"];
		$Admin=$DataRows["author"];
		$Image=$DataRows["image"];
		$Post=$DataRows["post"];
		$SrNo++;
		?>
		<tr>
		
		<td><?php echo $SrNo; ?></td>
		<td style="color: #5e5eff;">
		<?php
		if(strlen($Title)>19){$Title=substr($Title,0,10).'..';}
		echo $Title;
		?>
		</td>
		<td>
		<?php
		echo $DateTime;
		?>
		</td>
		<td>
		<?php
		if(strlen($Admin)>9){$Admin=substr($Admin,0,9);}
		echo $Admin; ?>
		</td>
		<td>
		<?php
		if(strlen($Category)>10){$Category=substr($Category,0,10);}
		echo $Category;
		?>
		</td>
		<td class="img-responsive"><img src="Upload/<?php echo $Image; ?>" width="170px"; height="70px"></td>
		<td>
		<?php
		$SelectDB;
		$QueryApproved="SELECT COUNT(*) FROM comments WHERE posts_id='$Id' AND status='ON'";
		$ExecuteApproved=mysql_query($QueryApproved);
		$RowsApproved=mysql_fetch_array($ExecuteApproved);
		$TotalApproved=array_shift($RowsApproved);
		mysql_free_result($ExecuteApproved);
		$QueryUnApproved="SELECT COUNT(*) FROM comments WHERE posts_id='$Id' AND status='OFF'";
		$ExecuteUnApproved=mysql_query($QueryUnApproved);
		$RowsUnApproved=mysql_fetch_array($ExecuteUnApproved);
		$TotalUnApproved=array_shift($RowsUnApproved);
		mysql_free_result($ExecuteUnApproved);
		?>
		<?php if($TotalApproved>0){ ?>
		<span class="label lg pull-right label-success">
		<?php echo $TotalApproved; ?>
		</span>
		<?php } ?>
		<?php if($TotalUnApproved>0){ ?>
		<span class="label pull-left label-danger">
		<?php echo $TotalUnApproved; ?>
		</span>
		<?php } ?>
		</td>
		<td><div>
		<a href="Edit Post.php?Edit=<?php echo $Id; ?>">
		<span class="btn btn-warning">Edit</span>
		</a>
		<a href="Delete Post.php?Delete=<?php echo $Id; ?>">
		<span class="btn btn-danger">Delete</span>
		</a></div>
		</td>
		<td>
		<a href="Full Post.php?id=<?php echo $Id; ?>" target="_blank">
		<span class="btn btn-primary"> Live Preview</span>
		</a>
		</td>
		</tr>
		<?php } 
		mysql_free_result($Execute);?>
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