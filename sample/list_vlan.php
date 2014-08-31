<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$account_client = SoftLayer_SoapClient::getClient('SoftLayer_Account', null, SLAPI_USER, SLAPI_KEY);
$object_mask = "mask[id, name, vlanNumber]";
$account_client->setObjectMask($object_mask);

try {
  $account_vlans = $account_client->getNetworkVlans();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

echo "ID\tVLAN Number\tName\n\n";
foreach ($account_vlans as $k) {
  echo "$k->id\t" . $k->vlanNumber . "\t$k->name\n\n";
}
?>
