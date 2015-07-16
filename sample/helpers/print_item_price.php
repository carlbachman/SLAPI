<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$package_id = !empty($argv[1]) ? $argv[1] : 46;

$client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Package', $package_id, SLAPI_USER, SLAPI_KEY);
$object_mask = "mask[id, hourlyRecurringFee, recurringFee, item[description]]";

echo "[ITEM PRICES]\n\n";
$client->setObjectMask($object_mask); 

try { 
  $my_items = $client->getItemPrices(); 
} catch (Exception $e) { 
  die('Unable to retrieve package list: ' . $e->getMessage()); 
}
printf("%s\t%s\t%s\t\t%s\n", 'priceId', 'Hourly', 'Monthly', 'Description');
foreach ($my_items as $v) {
  printf("%s\t%s\t%s\t\t%s\n", $v->id, $v->hourlyRecurringFee, $v->recurringFee, $v->item->description);
}

?>
