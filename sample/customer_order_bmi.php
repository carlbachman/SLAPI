<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Order', null, SLAPI_USER, SLAPI_KEY); 
$my_order = new stdClass();
$my_order->packageId = 50;
$my_order->location  = 224092;
$my_order->quantity  = 1;
$my_order->imageTemplateGlobalIdentifier  = 'd8a12975-b1e2-4963-9a85-c9886953a851';
$my_order->hardware = array();
$my_order->prices = array();
$my_order->useHourlyPricing = true;
$os_item_price = 30764; // WinDos2008R2, 31329 Debian 7 x86_64

for ($cnt = 0; $cnt < $my_order->quantity; $cnt++) {
  $domain = new stdClass();
  $domain->hostname = "foo-$cnt";;
  $domain->domain = 'softlayer-singapore-test.com';
  $my_order->hardware[] = $domain;
}

$item_price_ids = array(31728, // 4x 2Ghz 16G
                        29372, // 250G SATAII
                        27023, // Host ping
                        33483, // SSL VPN
                        24713, // 1GbE
                        32627, // Auto notification
                        34183, // 0G
                        34807, // 1IP
                        23070, // Remote Management 
                        35310, // Nessus scanning
                        32500, // Email and ticket notification
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
