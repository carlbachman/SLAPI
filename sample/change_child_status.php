<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$my_user = new stdClass();

switch ($argv[1]) {
  case 'ACTIVE':
    $my_user->userStatusId = 1001;
  break;
  case 'INACTIVE':
    $my_user->userStatusId = 1003;
  break;
  case 'DISABLED':
    $my_user->userStatusId = 1002;
  break;
  case 'DELETE':
    $my_user->userStatusId = 1021;
  break;
  case 'VPN':
    $my_user->userStatusId = 1022;
  break;

  default:
  echo "Please new account status for children as first argument\n";
  echo 'Example: $php '. basename($argv[0]) . " ACTIVE|INACTIVE|DISABLED|DELETE|VPN\n\n";
  exit(1);
}

$object_mask = "mask[id]";
$client = SoftLayer_SoapClient::getClient('SoftLayer_Account','', SLAPI_USER, SLAPI_KEY);
$client->setObjectMask($object_mask);

try {
  $res = $client->getCurrentUser();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}
$client = SoftLayer_SoapClient::getClient('SoftLayer_User_Customer', $res->id, SLAPI_USER, SLAPI_KEY);
$client->setObjectMask($object_mask);

try {
  $res = $client->getChildUsers();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

foreach ($res as $val) {
  $client = SoftLayer_SoapClient::getClient('SoftLayer_User_Customer', $val->id, SLAPI_USER, SLAPI_KEY);
  try {
    $res = $client->editObject($my_user);
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
}
?>
