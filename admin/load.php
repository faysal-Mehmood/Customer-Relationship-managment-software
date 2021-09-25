
<?php


require_once 'classes/variables.php';


$dbhost=$DB['host'];
$dbuser=$DB['user'];
$dbpass=$DB['pass'];
$dbname=$DB['dbName'];
$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("failed");

//$connect = new PDO('mysql:host=localhost;dbname=testing', 'root', '');

$data = array();

$query = "SELECT * FROM {$dbPre}contacts  ORDER BY id";

//$statement = $connect->prepare($query);
$result= mysqli_query($conn,$query) or die("query unsuccessful".mysqli_error($conn));

//$statement->execute();

//$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["firstName"],
  
  'start'   => $row["dateAdded"],
  'end'   => $row["dateModified"]
 );
}

echo json_encode($data);

?>
