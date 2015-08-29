<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$client = SoftLayer_SoapClient::getClient('SoftLayer_Account', null, SLAPI_USER, SLAPI_KEY);
$object_mask = "mask[username, userStatus[id,name]]";
$client->setObjectMask($object_mask);
$nbr_users = 0;

try {
$users = $client->getUsers();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

printf("%s\t%s\n", 'Status', 'Username');
foreach ($users as $u) {
  if ($u->userStatus->id == 1001) {
    printf("%s\t%s\n", $u->userStatus->name, $u->username);
    $nbr_users++;
  }
}
printf("\n%s\n", "The total number of Active users is: $nbr_users");
?>
