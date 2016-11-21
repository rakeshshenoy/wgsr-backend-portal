<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // it will never let you open index(login) page if session is set
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: maintain.php");
  exit;
 }
 
 if( isset($_POST['btn-login']) ) { 
  
  $email = $_POST['email'];
  $upass = $_POST['pass'];
  
  $email = strip_tags(trim($email));
  $upass = strip_tags(trim($upass));
  
  $password = hash('sha256', $upass); // password hashing using SHA256
  
  $res=mysqli_query($conn,"SELECT userId, userName, userPass FROM user WHERE userEmail='$email'");
  
  $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
  
  $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
  
  if( $count == 1 && $row['userPass']==$password ) {
   $_SESSION['user'] = $row['userId'];
   header("Location: maintain.php");
  } else {
   $errMSG = "Wrong Credentials, Try again...";
  }
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<img id="background" src="images/background%20login.jpg">
<div class="container col-xs-offset-1 col-md-5 col-lg-5" style="background:rgba(0,0,0,0.3); margin-top:15%;">

 <div id="login-form" >
    <form method="post" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h2 class="" style="color:white;">LOGIN</h2>
            </div>
        
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Your Email" required />
                </div>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Your Password" required />
                </div>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <a href="register.php">Sign Up Here</a>
            </div>
            <div class="form-group">
             <a href="forgot.php">Forgot your password?</a>
            </div>
        </div>
   
    </form>
    </div> 

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>