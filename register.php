<?php
ob_start();
session_start();
if(isset($_SESSION['user'])!="")
{
    header("Location: maintain.php");
}
include_once 'dbconnect.php';
if(isset($_POST['btn-signup']))
{
    $uname=trim($_POST['uname']);
    $email=trim($_POST['email']);
    $upass=trim($_POST['pass']);
    
    $uname=strip_tags($uname);
    $email=strip_tags($email);
    $upass=strip_tags($upass);
        
    $password=hash('sha256',$upass);
    
    $query="SELECT userEmail FROM user WHERE userEmail='$email'";
    $result=mysqli_query($conn,$query);
    $count=mysqli_num_rows($result);
    
    if($count==0)
    {
        $query = "INSERT INTO user(userName,userEmail,userPass) VALUES('$uname','$email','$password')";
  $res = mysqli_query($conn,$query);

     if ($res) 
     {
        $errTyp = "success";
        $errMSG = "successfully registered, you may login now";
     } 
     else 
     {
        $errTyp = "danger";
        $errMSG = "Something went wrong, try again later..."; 
     } 
   
    } 
    else 
    {
        $errTyp = "warning";
        $errMSG = "Sorry Email already in use ...";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<style>

    #background{
    width:100%;
    height:auto;
    position:absolute;
    left:0;
    top:0;
    }
</style>
<body>
<img id="background" src="dog.jpg">
<div class="container col-xs-offset-1 col-md-5 col-lg-5" style="background:rgba(0,0,0,0.3); margin-top:15%;">

 <div id="login-form">
    <form method="post" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h2 class=""  style="color:white;">Sign Up.</h2>
            </div>
        
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
             <input type="text" name="uname" class="form-control" placeholder="Enter Username" required />
                </div>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Enter Full Name" required />
                </div>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                 <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Enter Password" required />
                </div>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <a href="login.php">Login</a>
            </div>
        
        </div>
   
    </form>
    </div> 

</div>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
