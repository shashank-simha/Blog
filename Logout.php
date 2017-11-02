<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php
if(isset($_POST["confirm"]))
{
$_SESSION["User_Id"]=null;
session_destroy();
Redirect_to("Login.php");
}
else if((isset($_POST["cancel"]))||(isset($_POST["close"])))
{
Redirect_to("Dashboard.php");
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
<body class="bg-warning" >   
<form method="POST" action="" >
 <div class="modal-dialog"  role="document">     
 <div class="modal-content">      
  <div class="modal-header bg-primary">         
  <h2 class="pull-left warning" style="color:white;"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;Logout</h2>       
  <button type="submit" name="close" class="close"  data-dismiss="modal"  aria-label="Close">           
  <span aria-hidden="true">&times;</span>        
   </button>      
    </div>       
    <div class="modal-body">        
     <h3>
     <p>Do you want to Logout?</p>
     </h3>     
     </div>       
     <div class="modal-footer">         
     <button type="submit"  class="btn btn-secondary" name="cancel"  data-dismiss="modal">Cancel</ button>         
     <button type="submit"  class="btn btn-warning" name="confirm" >Logout</button>     
       </div>   
         </div>      
         </div> 
       </form>
         </body>
</html>