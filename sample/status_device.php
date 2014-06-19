<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

function status_domain($domain_id)
{
  if (empty($domain_id))
    return;

  $object_mask = "mask[id, datacenter[name], fullyQualifiedDomainName, provisionDate]";

  echo "ID\t\tDatacenter\tProvision date\t\t\tFQDN\n\n";
  foreach ($domain_id as $my_id) {
    $domain_client = SoftLayer_SoapClient::getClient('SoftLayer_Virtual_Guest', $my_id, SLAPI_USER, SLAPI_KEY);
    $domain_client->setObjectMask($object_mask);
    try {
      $res = $domain_client->getObject();
    } catch (Exception $e) {
      die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
    }
    if (empty($res->provisionDate)) {
      $res->provisionDate = 'NOT FINISHED PROVISIONING';
      $res->datacenter->name = '---';
    }
    echo "$res->id\t\t" . $res->datacenter->name . "\t\t$res->provisionDate" . "\t$res->fullyQualifiedDomainName\n";
  }
}

$domain_to_status = array();
$account_client = SoftLayer_SoapClient::getClient('SoftLayer_Account', null, SLAPI_USER, SLAPI_KEY);
$object_mask = "mask[id]";
$account_client->setObjectMask($object_mask);

$start = gettimeofday();
while (1) {
  $now = gettimeofday();
  try {
    $my_domains = $account_client->getVirtualGuests();
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
  foreach ($my_domains as $k) {
    $domain_to_status[] = $k->id;
  }
  status_domain($domain_to_status);
  $domain_to_status = null;
  $delta = $now['sec'] - $start['sec'];
  $minutes = round($delta/60);
  echo "\t\t### Time passed since start is $minutes minutes ($delta seconds) ###\n\n";
  sleep(10);
}
?>
