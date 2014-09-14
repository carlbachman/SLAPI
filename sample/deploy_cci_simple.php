<?php

$object_mask = new stdClass();
$object_mask->datacenter['name'] = 'sng01';
$object_mask->hostname = 'windos';
$object_mask->domain = 'softlayer-singapore-test.com';
$object_mask->startCpus = 1;
$object_mask->maxMemory = 4096;
$object_mask->operatingSystemReferenceCode = 'WIN_2008-STD-R2_64';

$client = SoftLayer_SoapClient::getClient('SoftLayer_Virtual_Guest', null, SLAPI_USER, SLAPI_KEY);
try {
  $result = $client->createObject($object_mask);
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

?>
