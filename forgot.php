<?php
 ob_start();
 require_once 'dbconnect.php';

 
 if( isset($_POST['btn-change']) ) { 
  $email = $_POST['email'];
  $email = strip_tags(trim($email));
  $res=mysqli_query($conn,"SELECT userId, userName, userPass FROM user WHERE userEmail='$email'");
  
  $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
  
  $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
  
  if( $count == 1 ) {
  $encrypt = md5(1290*3+$row['userId']);
  $message = "Your password reset link send to your e-mail address.";
  $to=$email;
  $subject="Password Reset";
  $from = 'test@test.com';
  $body='Hi'.$row[userName].',<br><br>Click here to reset your password http://localhost/reset.php?encrypt='.$encrypt.'&action=reset';
                $headers = "From: " . strip_tags($from) . "\r\n";
                $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                
                mail($to,$subject,$body,$headers);
  } else {
   $errMSG = "There is no account with this email id.";
  }
 }
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
<div id="login-form">
    <form method="post" autocomplete="off">
    
     <div class="col-md-6">
<h3>Enter the email id for recovering the password</h3>
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
             <button type="submit" class="btn btn-block btn-primary" name="btn-change">change My Password</button>
            </div>
</div> 
        </form>
        </div>
    
</body>
</html>