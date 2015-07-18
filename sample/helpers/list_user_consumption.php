<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 


function print_user($user)
{
  foreach ($user as $device) {
    $recurring = !empty($device->billingItem->orderItem->recurringFee) ? 
                 $device->billingItem->orderItem->recurringFee : 
                 $device->billingItem->orderItem->hourlyRecurringFee;
    printf("%s\t%-10s\t%-10s\t%-20s\t%s\n", $device->billingItem->createDate,
                                         $device->billingItem->categoryCode,
                                         $recurring,
                                         $device->billingItem->orderItem->order->userRecord->username,
                                         $device->fullyQualifiedDomainName);
  }
}

$client = SoftLayer_SoapClient::getClient('SoftLayer_Account', null, SLAPI_USER, SLAPI_KEY);
$object_mask = "mask[fullyQualifiedDomainName, billingItem[categoryCode,description,createDate,orderItem[order[userRecord[username]]]]]";
$client->setObjectMask($object_mask);
$result = array();

try {
  $cci_list = $client->getVirtualGuests();
  $bm_list = $client->getHardware();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

printf("%s\t\t\t%s\t%s\t%s\t\t%s\n", 'Create date', 'Category code', 'Recurring', 'Username', 'FQDN');

foreach($cci_list as $c) {
  $result[$c->billingItem->orderItem->order->userRecord->username][] = $c;
}

foreach($bm_list as $b) {
  $result[$b->billingItem->orderItem->order->userRecord->username][] = $b;
}

foreach ($result as $user) {
  print_user($user);
}

?>
