<?php
 require_once '../classes/variables.php';
 require_once 'mailer.php';
 $email=new mail();

 $dbhost=$DB['host'];
 $dbuser=$DB['user'];
 $dbpass=$DB['pass'];
 $dbname=$DB['dbName'];
 $conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("failed");
 $arr=array();
 $arr=$_POST['favorite'];
 $teach_id=$_POST['teacher_id'];

  $query="select * from {$dbPre}users where id='$teach_id'";
  $res= mysqli_query($conn,$query) or die("query unsuccessful".mysqli_error($conn));
  while ($row = mysqli_fetch_assoc($res)) {
     $teacher_email=$row['email'];
     $teacher_name=$row['first'];
      }
  
 
   for($i=0; $i<sizeof($arr); $i++){
   
   echo $sql = "UPDATE {$dbPre}contacts SET `assign_teacher` = '$teach_id' WHERE `tcs_contacts`.`id` = '$arr[$i]'"; 
   echo '<br>';
   
 $result= mysqli_query($conn,$sql) or die("query unsuccessful".mysqli_error($conn));
 $conn->close();
   }
 if(isset($result))
 {
  $email->sendmail($teacher_email,$teacher_name);
    echo 1;
 }
 else{
   echo 0;
 }
?>