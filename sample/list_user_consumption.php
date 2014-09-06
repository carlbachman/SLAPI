<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 


function print_item($item)
{
  $user = $item->billingItem->orderItem->order->userRecord->username; 
  $user = strlen($user) < 8 ? "$user    " : $user;
  $code = $item->billingItem->categoryCode; 
  $code = strlen($code) < 8 ? "$code    " : $code;
echo $item->billingItem->createDate . "\t" . 
     $code . "\t" .
     $item->billingItem->orderItem->recurringFee . "\t\t\t" .
     $user . "\t" .
     $item->fullyQualifiedDomainName . "\n";
}

$client = SoftLayer_SoapClient::getClient('SoftLayer_Account', null, SLAPI_USER, SLAPI_KEY);
$object_mask = "mask[fullyQualifiedDomainName, billingItem[categoryCode,description,createDate,orderItem[order[userRecord[username]]]]]";
$client->setObjectMask($object_mask);

try {
  $cci_list = $client->getVirtualGuests();
  $bm_list = $client->getHardware();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

echo "Create date\t\t\tCategory code\tRecurring fee (USD)\tUsername\tFQDN\n\n";

foreach($cci_list as $c) {
  print_item($c);
}
foreach($bm_list as $b) {
  print_item($b);
}
?>
