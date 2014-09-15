<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

function delete_domain($domain_id)
{
  if (empty($domain_id))
    return;

  foreach ($domain_id as $my_id) {
    try {
      $domain_client = SoftLayer_SoapClient::getClient('SoftLayer_Virtual_Guest', $my_id, SLAPI_USER, SLAPI_KEY);
      $res = $domain_client->getActiveTransaction();
      if (isset($res->transactionStatus))
        continue;
      $domain_client->rebootSoft();
    } catch (Exception $e) {
      die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
    }
  }
}

$domain_to_reboot = array();

if (strlen($argv[1]) < 7 && 'all' != $argv[1]) {
  echo "Please enter device id ID1,ID2,IDn or 'all' as first argument\n";
  echo "Example: \$php " . basename($argv[0]) . " 1234567,7654321\n\n";
  exit(1);
} elseif ('all' == $argv[1]) {
  $account_client = SoftLayer_SoapClient::getClient('SoftLayer_Account', null, SLAPI_USER, SLAPI_KEY);
  $object_mask = "mask[id, datacenter[name], fullyQualifiedDomainName, primaryIpAddress, primaryBackendIpAddress]";
  $account_client->setObjectMask($object_mask);

  try {
    $my_domains = $account_client->getVirtualGuests();
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }

  echo "\n\n[WARNING! ALL LISTED DOMAINS WILL BE REBOOTED IN 10 SECONDS!]\n\n";
  echo "ID\t\tDatacenter\tPublic IP\tBackend IP\tFQDN\n\n";
  foreach ($my_domains as $k) {
    $domain_to_reboot[] = $k->id;
    echo "$k->id\t\t" . $k->datacenter->name . "\t\t$k->primaryIpAddress\t" .
      "$k->primaryBackendIpAddress\t$k->fullyQualifiedDomainName \n\n";
  }
  sleep(10);
  delete_domain($domain_to_reboot);
} else {
  delete_domain(explode(',', $argv[1]));
}
?>
