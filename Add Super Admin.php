<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>
<?php
$currentAdmin=$_SESSION["User_Id"];
$SuperAdminQuery="SELECT superadmin FROM registration WHERE id='$currentAdmin'";
$SuperAdminExecute=mysql_query($SuperAdminQuery);
$SuperAdmin=mysql_fetch_array($SuperAdminExecute);
mysql_free_result($SuperAdminExecute);
$SuperAdmin=$SuperAdmin["superadmin"];
if($SuperAdmin=="YES")
{
if(isset($_GET["id"]))
{
    $IdFromURL=$_GET["id"];
    $SelectDB;
$Query="UPDATE registration SET superadmin='YES' WHERE id='$IdFromURL' ";
$Execute=mysql_query($Query);
if($Execute)
{
	$_SESSION["SuccessMessage"]="Super Admin added Successfully";
	}
	else
	{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	}
}
}
else
{
$_SESSION["ErrorMessage"]="Super Admin previlages required to Manage Admins.";
}
Redirect_to("Super Admins.php");
?>