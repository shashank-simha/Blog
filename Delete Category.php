<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>
<?php
$IdFromURL=$_GET["id"];
$nameQuery="SELECT name FROM categories WHERE id='$IdFromURL' ";
$nameExecute=mysql_query($nameQuery);
$nameArr=mysql_fetch_array($nameExecute);
$name=$nameArr['name'];
mysql_free_result($nameExecute);
if(isset($_POST["confirm"]))
{
$SelectDB;
$Query="DELETE FROM categories WHERE id='$IdFromURL' ";
$Execute=mysql_query($Query);
if($Execute)
{
	$_SESSION["SuccessMessage"]="Category Deleted Successfully";
	}
	else
	{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	}
	Redirect_to("Categories.php");
}
else if((isset($_POST["cancel"]))||(isset($_POST["close"])))
{
Redirect_to("Categories.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
      <link rel="stylesheet" href="CSS/bootstrap.min.css">
      <script src="js/jquery-3.2.1.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
</head>
<body class="bg-danger" >   
<form method="POST" action="" >
 <div class="modal-dialog"  role="document">     
 <div class="modal-content">      
  <div class="modal-header">         
  <h2 class="pull-left danger" style="color:red;"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;Delete</h2>       
  <button type="submit" name="close" class="close"  data-dismiss="modal"  aria-label="Close">           
  <span aria-hidden="true">&times;</span>        
   </button>      
    </div>       
    <div class="modal-body">        
     <h3>
     <p><b><?php echo $name; ?></b> category will be deleted forever. Do you want to proceed?</p>
     </h3>     
     </div>       
     <div class="modal-footer">         
     <button type="submit"  class="btn btn-secondary" name="cancel"  data-dismiss="modal">Cancel</ button>         
     <button type="submit"  class="btn btn-danger" name="confirm" >Delete</button>     
       </div>   
         </div>      
         </div> 
       </form>
         </body>
</html>