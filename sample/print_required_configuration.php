<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$client_null = SoftLayer_SoapClient::getClient('SoftLayer_Product_Package', null, SLAPI_USER, SLAPI_KEY);
$client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Package', 46, SLAPI_USER, SLAPI_KEY);
$req_items = array();

try {
  $result = $client_null->getAllObjects();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

echo "[AVAILABLE PACKAGES]\n\n";
foreach ($result as $res) {
  echo "$res->id $res->name\n";
}


try {
  $result = $client->getConfiguration();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

foreach ($result as $res) {
  if ($res->isRequired == 1) {
    $req_items[] = $res->itemCategoryId;
  }
}

try {
  $result = $client->getCategories();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

echo "[REQUIRED ITEMS]\n\n";
foreach ($result as $res) {
  if (in_array($res->id, $req_items))
    echo "$res->id $res->name\n";
}
try {
  $result = $client->getLocations();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

echo "[LOCATIONS]\n\n";
foreach ($result as $res) {
    echo "$res->name $res->id\n";
}

$object_mask = new SoftLayer_ObjectMask(); 
$object_mask->items; 
$client->setObjectMask($object_mask); 
try { 
  $my_package = $client->getObject(); 
} catch (Exception $e) { 
  die('Unable to retrieve package list: ' . $e->getMessage()); 
}
$my_items = $my_package->items;

foreach ($my_items as $item) {
  $id = null;
  foreach ($item->prices as $price) {
    $id[] = $price->id;
  }
    echo "$id[0] $item->description\n";
}
?>
