<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

 /**
  * 
  * Use can also directly retrieve the meta data from the terminal
  * curl -s https://api.service.softlayer.com/rest/v3/SoftLayer_Resource_Metadata/UserMetadata.txt | base64 --decode
  *
  */

$client = SoftLayer_SoapClient::getClient('SoftLayer_Resource_Metadata', null, SLAPI_USER, SLAPI_KEY, SoftLayer_SoapClient::API_PRIVATE_ENDPOINT);

try {
  $result = $client->getUserMetadata();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}
print_r(base64_decode($result));
?>
