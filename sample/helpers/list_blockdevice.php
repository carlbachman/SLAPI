<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$account_client = SoftLayer_SoapClient::getClient('SoftLayer_Account', null, SLAPI_USER, SLAPI_KEY);
$object_mask = "mask[id, datacenter[name], fullyQualifiedDomainName, primaryIpAddress, primaryBackendIpAddress]";
$account_client->setObjectMask($object_mask);

try {
  $my_domains = $account_client->getVirtualGuests();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

foreach ($my_domains as $k) {
  $client = SoftLayer_SoapClient::getClient('SoftLayer_Virtual_Guest', $k->id, SLAPI_USER, SLAPI_KEY);
  try {
    $result = $client->getBlockDevices();
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
  print_r($result);
}

?>
