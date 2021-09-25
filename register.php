<!DOCTYPE html>
<!-- Designined by CodingLab - youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Registration Form | TCS </title>
    <link rel="stylesheet" href="assets/css/register.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <?php
   require_once './admin/classes/variables.php';
  
   

   $dbhost=$DB['host'];
   $dbuser=$DB['user'];
   $dbpass=$DB['pass'];
   $dbname=$DB['dbName'];
   $conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("failed");
   $query_res="";
if(isset(  $_POST['submit'])){
$first= mysqli_real_escape_string($conn,$_POST['firstname']);
$last= mysqli_real_escape_string($conn,$_POST['lastname']);
$email_id= mysqli_real_escape_string($conn,$_POST['email']);
$phone= mysqli_real_escape_string($conn,$_POST['phone']);
$address= mysqli_real_escape_string($conn,$_POST['address']);
$country= mysqli_real_escape_string($conn,$_POST['country']);

 $sql= "INSERT INTO {$dbPre}contacts (firstName,lastName,Address,Phone,Email,Country,leadType,leadSource,lastModifiedBy,assignedTo,IStatus) values('{$first}','{$last}','{$address}','{$phone}','{$email_id}','{$country}',1,1,1,1,1)";

$res=mysqli_query($conn,$sql);

if($res){
  require_once 'mailer.php';
   $email=new mail();
  $email->sendmail($email_id,$first);
    $query_res="Thanks for contact us,We will contact you back as sooner. Stay tunned and active..";
    
    

}else{
    $query_res= mysqli_error();
}

}

?>
<body>
  <div class="container">
    <div class="title">Register Now</div>
    <div class="content">
      <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="user-details">
          <div class="input-box">
            <span class="details">First Name</span>
            <input type="text" placeholder="Enter your first name" name="firstname" required>
          </div>
          <div class="input-box">
            <span class="details">Last Nmae</span>
            <input type="text" placeholder="Enter your last name" name="lastname" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="text" placeholder="Enter your email" name="email" required>
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="text" placeholder="Enter your number" name="phone" required>
          </div>
          <div class="input-box">
            <span class="details">Address</span>
            <input type="text" placeholder="Enter your address" name="address"required>
          </div>
          <div class="input-box">
            <span class="details">Country</span>
            <input type="text" placeholder="Enter your country" name="country" required>
          </div>
        </div>
        <div class="gender-details">
          <input type="radio" name="gender" id="dot-1">
          <input type="radio" name="gender" id="dot-2">
          <input type="radio" name="gender" id="dot-3">
          <span class="gender-title">Gender</span>
          <div class="category">
            <label for="dot-1">
            <span class="dot one"></span>
            <span class="gender">Male</span>
          </label>
          <label for="dot-2">
            <span class="dot two"></span>
            <span class="gender">Female</span>
          </label>
          <label for="dot-3">
            <span class="dot three"></span>
            <span class="gender">Prefer not to say</span>
            </label>
          </div>
        </div>
        <div class="button">
          <input type="submit" value="Register" name="submit">
        </div>
      </form>
      <p style="color:red"><?php echo $query_res;?></p> &nbsp;<a href="index.html">Go to homepage</a>
    </div>
  </div>

</body>
</html>
