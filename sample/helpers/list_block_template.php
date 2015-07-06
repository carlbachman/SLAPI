<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$account_client = SoftLayer_SoapClient::getClient('SoftLayer_Account', null, SLAPI_USER, SLAPI_KEY);

try {
$result = $account_client->getBlockDeviceTemplateGroups();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

foreach ($result as $v) {
  if (!empty($v->globalIdentifier)) {
  $note = empty($v->note) ? '' : $v->note;
  echo "$v->globalIdentifier :: $v->name :: $note\n";
  }
}
?>
