<?php
$Invalid_pwd='';
$ID='';
$PWD='';
$invalid_search='';
$input='';
  include('../config.php');
  require '../vendor/autoload.php';

use Aws\DynamoDb\DynamoDbClient;

// Create the AWS service builder, providing the path to the config file
  $dynamoDbClient = DynamoDbClient::factory(array(
    'credentials' => array(
        'key'    => $aws_access_key_id,
        'secret' => $aws_secret_access_key,
    ),
   'region'  => 'us-east-1',
   'version' => 'latest',
));
?>

<!-- Directs existing user to livefeed from login page -->
<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <title>pickture: Retrieved images</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="home.css">
</head>

<body>
    <div class= "container" align= "center" float="center">
      <p align = "center", float= "center">
        <?php
        echo '<br>';
        echo '<br>';
        $iterator = $dynamoDbClient->getIterator('Scan', array(
                    'TableName'     => 'multimedia'
                    ));
        $name=$_POST['Name'];
        echo 'Displaying all relevant images your keyword '.$name.'!';
        echo '<br>'
        foreach ($iterator as $item) {
        // Grab the relevant key items from dynamoDb and displays in a livefeed format
          if(($item['key1']['S']==$name)||($item['key2']['S']==$name)||($item['key3']['S']==$name)||($item['key4']['S']==$name)||($item['key5']['S']==$name)){
            echo "<img src='". $item['url']['S'] ."' width='600' height='400'></b><br>";
            echo $item['description']['S']."<br>";
            echo "<i>submitted by  ". $item['email']['S']." on ".$item['date']['S']."<br>";
            echo "<br><br>________________________________________<br><br>";
          }
        }
        ?>
      </p>
    </div>
  </body>
</html>