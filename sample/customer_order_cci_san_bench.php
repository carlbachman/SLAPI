<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Order', null, SLAPI_USER, SLAPI_KEY); 
$my_order = new stdClass();
$my_order->packageId = 46;
$my_order->location  = 224092;
$my_order->quantity  = 20;
$my_order->imageTemplateGlobalIdentifier  = '3dd41c1d-aa8e-49f8-ae0a-57f4427d1665';
$my_order->virtualGuests = array();
$my_order->prices = array();
$os_item_price = 24341; // debian 7 minimal

for ($cnt = 0; $cnt < $my_order->quantity; $cnt++) {
  $domain = new stdClass();
  $domain->hostname = "bench-sg-$cnt";;
  $domain->domain = 'softlayer-singapore-test.com';
  $domain->localDiskFlag = true;
  $domain->hourlyBillingFlag = true;
  $my_order->virtualGuests[] = $domain;
}

$item_price_ids = array(26125, // 1x 2Ghz
                        22694, // 27884, // 2G, 4G 22694
                        23070, // Reboot remote console
                        24713, // GbE pub and priv
                        27674, // 5TB data
                        34807, // 1 IP
                        32578, // 25G SAN
                        27023, // Host ping
                        32627, // Auto notification
                        33483, // Unlimited ssl vpn
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
