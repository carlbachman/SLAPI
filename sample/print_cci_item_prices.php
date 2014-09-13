<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Package', 46, SLAPI_USER, SLAPI_KEY);
$object_mask = "mask[hourlyRecurringFee, recurringFee, item[description]]";

echo "[ITEM PRICES]\n\n";
$client->setObjectMask($object_mask); 

try { 
  $my_items = $client->getItemPrices(); 
} catch (Exception $e) { 
  die('Unable to retrieve package list: ' . $e->getMessage()); 
}
echo "Hourly Recurring Fee\tRecurring Fee\tDescription\n\n";
foreach ($my_items as $v) {
    $myitem = get_object_vars($v->item);
  echo "$v->hourlyRecurringFee\t\t\t" . "$v->recurringFee\t\t" .
       $myitem['description'] . "\n";
}

?>
