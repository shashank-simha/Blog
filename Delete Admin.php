<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>
<?php Confirm_Login() ?>
<?php
$currentAdmin=$_SESSION["User_Id"];
$SuperAdminQuery="SELECT superadmin FROM registration WHERE id='$currentAdmin'";
$SuperAdminExecute=mysql_query($SuperAdminQuery);
$SuperAdmin=mysql_fetch_array($SuperAdminExecute);
mysql_free_result($SuperAdminExecute);
$SuperAdmin=$SuperAdmin["superadmin"];
//
$IdFromURL=$_GET["id"];
if($IdFromURL==$currentAdmin)
{
 $_SESSION["ErrorMessage"]="Cannot delete the current admin.\n
                            Try Delete account option in personal settings.";
Redirect_to("Admins.php");
}
if($SuperAdmin=="YES")
{
$nameQuery="SELECT username FROM registration WHERE id='$IdFromURL' ";
$nameExecute=mysql_query($nameQuery);
$nameArr=mysql_fetch_array($nameExecute);
$name=$nameArr['username'];
mysql_free_result($nameExecute);
if(isset($_POST["confirm"]))
{
$SelectDB;
$Query="DELETE FROM registration WHERE id='$IdFromURL' ";
$Execute=mysql_query($Query);
if($Execute)
{
	$_SESSION["SuccessMessage"]="Admin Deleted Successfully";
	}
	else
	{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	}
	Redirect_to("Admins.php");
}
else if((isset($_POST["cancel"]))||(isset($_POST["close"])))
{
Redirect_to("Admins.php");
}
}
else
{
$_SESSION["ErrorMessage"]="Super Admin previlages required to Manage Admins.";
Redirect_to("Admins.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Delete Admin</title>
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
     <p><b><?php echo $name; ?></b> admin will be deleted forever. Do you want to proceed?</p>
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