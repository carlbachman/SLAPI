<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Package', 50, SLAPI_USER, SLAPI_KEY);

try {
  $result = $client->getLocations();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

echo "\n[LOCATIONS]\n\n";
foreach ($result as $res) {
    echo "$res->name $res->id\n";
}
?>
