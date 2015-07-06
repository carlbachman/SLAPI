<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$client_null = SoftLayer_SoapClient::getClient('SoftLayer_Product_Package', null, SLAPI_USER, SLAPI_KEY);
$req_items = array();

try {
  $result = $client_null->getAllObjects();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

printf("%s\n", '[AVAILABLE PACKAGES]');
foreach ($result as $res) {
  printf("%s\t%s\n", $res->id, $res->name);
}

?>
