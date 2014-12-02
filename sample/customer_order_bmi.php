<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Order', null, SLAPI_USER, SLAPI_KEY); 
$my_order = new stdClass();
$my_order->packageId = 200;
$my_order->location  = 224092;
$my_order->quantity  = 1;
$my_order->presetId  = 64;
// $my_order->imageTemplateGlobalIdentifier  = 'd8a12975-b1e2-4963-9a85-c9886953a851';
$my_order->hardware = array();
$my_order->prices = array();
$my_order->useHourlyPricing = true;
$os_item_price = 44992; // 44992 CentOS7_64, 31673 W2012 std 64

for ($cnt = 0; $cnt < $my_order->quantity; $cnt++) {
  $domain = new stdClass();
  $domain->hostname = "foo-$cnt";;
  $domain->domain = 'softlayer-singapore-test.com';
  $my_order->hardware[] = $domain;
}

$item_price_ids = array(37332, // 1xQuad Xeon 1270 3.4G 8M
                        37344, // 8G
                        32927, // Non-raid
                        24713, // 1GbE
                        34183, // 0G
                        34807, // 1IP
                        33483, // SSL VPN
                        25014, // Reboot/KVM 
                        );

if (empty($my_order->imageTemplateGlobalIdentifier))
  $item_price_ids[] = $os_item_price;

foreach ($item_price_ids as $id) {
  $price = new stdClass();
  $price->id = $id;
  $my_order->prices[] = $price;
}

$cmd = 'yes' == $argv[1] ? 'placeOrder' : 'verifyOrder';
try {
  $result = $client->$cmd($my_order);
  print_r($result);
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}
echo shell_exec('date');
?>
