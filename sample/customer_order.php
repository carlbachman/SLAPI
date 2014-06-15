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
$my_order->quantity  = 1;
$my_order->imageTemplateGlobalIdentifier  = '3dd41c1d-aa8e-49f8-ae0a-57f4427d1665';
$my_order->virtualGuests = array();
$my_order->prices = array();
$os_item_price = 24341; // debian 7 minimal

$fqdns = array(
         array('hostname' => 'carl4',
               'domain' => 'softlayer-singapore-test.com',
               'localDiskFlag' => true,
               'hourlyBillingFlag' => true),
              );
foreach ($fqdns as $fqdn) {
  $domain = new stdClass();
  $domain->hostname = $fqdn['hostname'];
  $domain->domain = $fqdn['domain'];
  $my_order->virtualGuests[] = $domain;
}

$item_price_ids = array(26125, // 1x 2Ghz
                        22694, // 27884, // 2G, 4G 22694
                        23070, // Reboot remote console
                        24713, // Gbit pub and priv
                        27674, // 5TB data
                        34807, // 1 IP
                        24013, // 25G LOCAL
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

if ('yes' == $argv[1]) {
  try {
    $result = $client->placeOrder($my_order);
    print_r($result);
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
} else {
  try {
    $result = $client->verifyOrder($my_order);
    print_r($result);
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
}

?>
