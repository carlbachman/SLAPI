<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$object_mask = "mask[accountId, eventCreateDate, eventName, ipAddress, label, username, userType]";
$client = SoftLayer_SoapClient::getClient('SoftLayer_Event_Log','', SLAPI_USER, SLAPI_KEY);
$client->setObjectMask($object_mask);
$client->setResultLimit(250);

try {
  $res = $client->getAllObjects();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

echo "Account\t User type  Created \t\t\t\t User \t\t      IP\t      Event\t\t   Label\n";
foreach ($res as $elem) {
  echo sprintf("%s\t %-10s %-20s\t %-20s %-15s %-20s %s\n", $elem->accountId, $elem->userType,
                                                            $elem->eventCreateDate, $elem->username,
                                                            $elem->ipAddress, $elem->eventName, $elem->label);
}

?>
