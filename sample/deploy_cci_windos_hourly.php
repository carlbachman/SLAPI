<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 


$object_mask = new stdClass();
$object_mask->datacenter['name'] = 'sng01';
$object_mask->hostname = 'windos';
$object_mask->domain = 'softlayer-singapore-test.com';
$object_mask->startCpus = 1;
$object_mask->maxMemory = 4096;
$object_mask->hourlyBillingFlag = true;
$object_mask->operatingSystemReferenceCode = 'WIN_2008-STD-R2_64';
$object_mask->localDiskFlag = true;
$object_mask->networkComponents[0]['maxSpeed'] = 1000;
$client = SoftLayer_SoapClient::getClient('SoftLayer_Virtual_Guest', null, SLAPI_USER, SLAPI_KEY);
$order_client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Order', null, SLAPI_USER, SLAPI_KEY);

if ('yes' == $argv[1]) {
  try {
    $result = $client->createObject($object_mask);
    print_r($result);
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
} else {
  try {
    $orderClient = SoftLayer_SoapClient::getClient('SoftLayer_Product_Order', null, SLAPI_USER, SLAPI_KEY);
    $orderContainer = $client->generateOrderTemplate($object_mask);
    print_r($orderClient->verifyOrder($orderContainer));
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
}
?>
