<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

function status_domain($domain_id, &$all_done, &$timestamp, $minutes)
{
  if (empty($domain_id))
    return;

  $object_mask = "mask[id, datacenter[name], fullyQualifiedDomainName, provisionDate]";

  echo "ID\t\tDatacenter\tProvision date\t\t\tTime(min)\tFQDN\n\n";
  foreach ($domain_id as $my_id) {
    $domain_client = SoftLayer_SoapClient::getClient('SoftLayer_Virtual_Guest', $my_id, SLAPI_USER, SLAPI_KEY);
    $domain_client->setObjectMask($object_mask);
    try {
      $res = $domain_client->getObject();
    } catch (Exception $e) {
      die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
    }
    if (empty($res->provisionDate)) {
      $all_done = false;
      $res->provisionDate = 'NOT FINISHED PROVISIONING';
      if (!isset($res->datacenter))
        $res->datacenter = new stdClass();
      $res->datacenter->name = '---';
      $timestamp["$my_id"] = $minutes;
    }
    $time = empty($timestamp["$my_id"]) ? 0 : $timestamp["$my_id"];
    echo "$res->id\t\t" . $res->datacenter->name . "\t\t$res->provisionDate" .
         "\t$time" . "\t\t$res->fullyQualifiedDomainName\n";
  }
}

function calculate_mean($timestamp)
{
if (empty($timestamp))
  return 0;
return array_sum($timestamp)/sizeof($timestamp);
}

$domain_to_status = array();
$timestamp = array();
$delta = 0;
$account_client = SoftLayer_SoapClient::getClient('SoftLayer_Account', null, SLAPI_USER, SLAPI_KEY);
$object_mask = "mask[id]";
$account_client->setObjectMask($object_mask);

$start = gettimeofday();
while (1) {
  $all_done = true;
  $domain_to_status = null;
  $now = gettimeofday();
  try {
    $my_domains = $account_client->getVirtualGuests();
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
  foreach ($my_domains as $k) {
    $domain_to_status[] = $k->id;
  }
  $delta = $now['sec'] - $start['sec'];
  $minutes = round($delta/60);
  status_domain($domain_to_status, $all_done, $timestamp, $minutes);
  $mean_provision_time = calculate_mean($timestamp);
  $min = empty($timestamp) ? 0 : min($timestamp);
  $max = empty($timestamp) ? 0 : max($timestamp);
  echo "\t\t########################################################\n";
  echo "\t\t### Time passed since start is $minutes minutes ($delta seconds)\n";
  echo "\t\t### Provisioning duration\n";
  echo "\t\t### MIN: $min MAX: $max AVERAGE: $mean_provision_time\n";
  echo "\t\t### All done: $all_done\n";
  echo "\t\t########################################################\n\n";
  if ($all_done) exit;
  sleep(10);
}
?>
