<?php


//Simple array for topics - Övning 4 (http://porkforge.mardby.se/index.php?title=PHP_Laboration_3_-_Array_och_loopar#.C3.96vning_4)
//$model = array("Första inlägget","Snart är det vår","Robin Presenterar sig","Senaste inlägget")

//2D Associative array for full posts - Övning 9 (http://porkforge.mardby.se/index.php?title=PHP_Laboration_3_-_Array_och_loopar#.C3.96vning_9_-_g.C3.B6r_2D_associative_array)
$host = 'localhost';
$dbname = 'blogg';
$user = 'admin';
$password = '1tt2t3';

//skapar atributer
$attr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

//ÅÄÖ
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

//skapar pdo object
$pdo = new PDO($dsn, $user, $password, $attr);

//skapar SQL-fråga
$sql = 'SELECT p.ID, p.Slug, p.Headline, CONCAT(u,FName, u.LName)  AS Name, p.Creation_time, p.Text FROM posts AS p JOIN Users AS u ON u.ID = p.User_ID';

//testar vår anslutning
if($pdo) {
    //skapar vår model-array
  $model = array();

  foreach($pdo->query($sql) as $row) {
    $model += array(
      $row[ID] => array(
        'slug' => $row['Slug'],
        'title' => $row['Headline'],
        'auther' => $row['Username'],
        'date' => $row['Creation_time'],
        'text' => $row['text'],
      )
    );
  }

  else { print_r($pdo->errorInfo()); }}

?>
