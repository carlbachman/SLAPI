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

echo "ID\t\tDatacenter\tPublic IP\tBackend IP\tFQDN\n\n";
foreach ($my_domains as $k) {
  echo "$k->id\t\t" . $k->datacenter->name . "\t\t$k->primaryIpAddress\t" .
       "$k->primaryBackendIpAddress\t$k->fullyQualifiedDomainName \n\n";
}
?>
