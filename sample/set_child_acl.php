<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$cnt = 0;
$default_perm = array('ACCOUNT_SUMMARY_VIEW', 'SERVER_ADD','USER_MANAGE',
                      'RESET_PORTAL_PASSWORD', 'SERVER_CANCEL', 'NTF_SUBSCRIBER_MANAGE',
                      'REMOTE_MANAGEMENT', 'TICKET_VIEW', 'TICKET_VIEW_ALL', 'TICKET_SEARCH', 'TICKET_ADD',
                      'TICKET_EDIT', 'FIREWALL_MANAGE', 'ANTI_MALWARE_MANAGE', 'NETWORK_IDS_MANAGE',
                      'SECURITY_CERTIFICATE_VIEW', 'GATEWAY_MANAGE', 'HOST_ID_MANAGE',
                      'VULN_SCAN_MANAGE', 'SECURITY_CERTIFICATE_MANAGE', 'CUSTOMER_SSH_KEY_MANAGEMENT',
                      'HARDWARE_VIEW', 'REMOTE_MANAGEMENT', 'MONITORING_MANAGE', 'SERVER_RELOAD',
                      'SERVER_RELOAD', 'HOSTNAME_EDIT', 'VIRTUAL_GUEST_VIEW', 'REMOTE_MANAGEMENT',
                      'MONITORING_MANAGE', 'PUBLIC_IMAGE_MANAGE', 'SERVER_RELOAD', 'SERVER_RELOAD',
                      'HOSTNAME_EDIT', 'LICENSE_VIEW', 'VIEW_CPANEL', 'VIEW_PLESK', 'VIEW_HELM',
                      'VIEW_QUANTASTOR', 'BANDWIDTH_MANAGE', 'PORT_CONTROL', 'DNS_MANAGE', 'DNS_MANAGE',
                      'DNS_MANAGE', 'DNS_MANAGE', 'LOADBALANCER_MANAGE', 'CDN_ACCOUNT_MANAGE',
                      'CDN_FILE_MANAGE', 'CDN_BANDWIDTH_VIEW', 'NETWORK_ROUTE_MANAGE',
                      'FIREWALL_RULE_MANAGE', 'BANDWIDTH_MANAGE', 'PORT_CONTROL', 'LOCKBOX_MANAGE',
                      'NETWORK_TUNNEL_MANAGE', 'NAS_MANAGE', 'SERVER_RELOAD', 'SERVER_RELOAD',
                      'NETWORK_VLAN_SPANNING', 'VPN_MANAGE', 'SERVER_UPGRADE', 'SERVICE_ADD',
                      'INSTANCE_UPGRADE', 'IP_ADD', 'ADD_SERVICE_STORAGE', 'SERVER_CANCEL',
                      'SERVICE_CANCEL', 'USER_EVENT_LOG_VIEW', 'REQUEST_COMPLIANCE_REPORT',
                      'SCALE_GROUP_MANAGE', 'QUEUE_MANAGE', 'CUSTOMER_POST_PROVISION_SCRIPT_MANAGEMENT',
                      'NETWORK_MESSAGE_DELIVERY_MANAGE');

foreach ($default_perm as $value) {
  ${'my_perm' . $cnt}['keyName'] = $value;
  $perm[] = ${'my_perm' . $cnt};
  $cnt++;
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
    $res = $client->addBulkPortalPermission($perm);
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
}
?>
