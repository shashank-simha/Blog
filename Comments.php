<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>
<?php Confirm_Login() ?>
<!DOCTYPE html>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Comments</title>
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
<li><a href="Categories.php">
<span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a>
</li>
<li><a href="Admins.php">
<span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a>
</li>
<li class="active" ><a href="#">
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
	<?php echo ErrorMessage();
	echo SuccessMessage();
	?>
	<h1>Un-Approved Comments</h1>
	<div class="table-responsive">
	<table class="table table-striped table-hover">
	<tr>
	<th>No.</th>
	<th>Name</th>
	<th> Date</th>
	<th>Comment</th>
	<th>Approve</th>
	<th>Delete Comment</th>
	<th>Details</th>
	</tr>
	<?php
	$SelectDB;
	$Query="SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
	$Execute=mysql_query($Query);
	$SrNo=0;
	while($DataRows=mysql_fetch_array($Execute)){
	$CommentId=$DataRows['id'];
	$DateTimeofComment=$DataRows['datetime'];
	$PersonName=$DataRows['name'];
	$PersonComment=$DataRows['comment'];
	$CommentedPostId=$DataRows['posts_id'];
	$SrNo++;
	
	if(strlen($PersonName) >10) { $PersonName = substr($PersonName, 0, 10).'..';}	
	?>
	<tr>
	<td><?php echo htmlentities($SrNo); ?></td>
	<td style="color: #5e5eff;"><?php echo htmlentities($PersonName); ?></td>
	<td><?php echo $DateTimeofComment; ?></td>
	<td><?php echo htmlentities($PersonComment); ?></td>
	<td><a href="Approve Comment.php?id=<?php echo $CommentId; ?>">
	<span class="btn btn-success">Approve</span></a></td>
	<td><a href="Delete Comment.php?id=<?php echo $CommentId;?>">
	<span class="btn btn-danger">Delete</span></a></td>
	<td><a href="Full Post.php?id=<?php echo $CommentedPostId; ?>" target="_blank">
	<span class="btn btn-primary">Live Preview</span></a></td>
	</tr>
	<?php } 
	mysql_free_result($Execute);
	?>
	</table>
	</div>
	    <h1>Approved Comments</h1>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
	<tr>
	<th>No.</th>
	<th>Name</th>
	<th>Date & Time</th>
	<th>Comment</th>
	<th>Approved By</th>
	<th>Revert Approval </th>
	<th>Delete Comment</th>
	<th>Details</th>
	</tr>
    <?php
    $SelectDB;
    $Query="SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
    $Execute=mysql_query($Query);
    $SrNo=0;
    while($DataRows=mysql_fetch_array($Execute)){
    $CommentId=$DataRows['id'];
    $DateTimeofComment=$DataRows['datetime'];
    $PersonName=$DataRows['name'];
    $PersonComment=$DataRows['comment'];
    $ApprovedBy=$DataRows['approvedby'];
    $CommentedPostId=$DataRows['posts_id'];
    $SrNo++;
    if(strlen($PersonName) >10) { $PersonName = substr($PersonName, 0, 10).'..';}
    if(strlen($DateTimeofComment)>18){$DateTimeofComment=substr($DateTimeofComment,0,18);} 
    ?>
    <tr>
    <td><?php echo htmlentities($SrNo); ?></td>
    <td style="color: #5e5eff;"><?php echo htmlentities($PersonName); ?></td>
    <td><?php echo $DateTimeofComment; ?></td>
    <td><?php echo htmlentities($PersonComment); ?></td>
    <td><?php echo htmlentities($ApprovedBy); ?></td>
    <td><a href="DisApprove Comment.php?id=<?php echo $CommentId;?>">
    <span class="btn btn-warning">Dis-Approve</span></a></td>
    <td><a href="Delete Comment.php?id=<?php echo $CommentId;?>">
    <span class="btn btn-danger">Delete</span></a></td>
    <td><a href="Full Post.php?id=<?php echo $CommentedPostId; ?>"target="_blank">
    <span class="btn btn-primary">Live Preview</span></a></td>
    </tr>
    <?php } 
    mysql_free_result($Execute);
    ?>
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