<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$domain_id = '1234567';
$my_data = 'myFile';

$client = SoftLayer_SoapClient::getClient('SoftLayer_Virtual_Guest', $domain_id,
                                          SLAPI_USER,
                                          SLAPI_KEY,
                                          SoftLayer_SoapClient::API_PRIVATE_ENDPOINT);

// Create and execute a transaction. Your domain will be rebooted!
try {
  $result = $client->setUserMetadata(array(base64_encode($my_data)));
  $result = $client->configureMetadataDisk();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}
print_r($result);
?>
