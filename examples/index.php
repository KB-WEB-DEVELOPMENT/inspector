<?php

// import the Controller class present in the 'src/' directory

require __DIR__ . '/../vendor/autoload.php';

use Inspector\Controller;

$searchTerm = 'some case-insensitive string to be searched by PHP Reflection API classes';
		
// $result data type: 'string'
$result = Controller::find($searchTerm); 

?>
