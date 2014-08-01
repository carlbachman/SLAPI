<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$my_user = new stdClass();
$my_user->userStatusId = 1021;

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
