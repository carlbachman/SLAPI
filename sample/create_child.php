<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

define('CREATE_NBR_ACCOUNTS', 15);
define('USERNAME_PREFIX', 'carl.SLTOPGUNBKKH');
$cnt = 0;
$my_user = new stdClass();
$my_user->address1 = 'myaddress';
$my_user->city = 'Ulan Bator';
$my_user->companyName = 'SoftLayer';
$my_user->country = 'TH';
$my_user->email = 'foo@bar.com';
$my_user->firstName = 'SoftLayer';
$my_user->lastName = 'TopGun';
$my_user->postalCode = '12345';
$my_user->secondaryLoginRequiredFlag = false;
$my_user->userStatusId = 1001;
$my_user->timezoneId = 153;

$default_perm = array('ACCOUNT_SUMMARY_VIEW', 'SERVER_ADD','USER_MANAGE',
                      'RESET_PORTAL_PASSWORD', 'SERVER_CANCEL', 'NTF_SUBSCRIBER_MANAGE',
                      'REMOTE_MANAGEMENT', 'TICKET_VIEW', 'TICKET_VIEW_ALL', 'TICKET_SEARCH', 'TICKET_ADD',
                      'TICKET_EDIT', 'FIREWALL_MANAGE', 'ANTI_MALWARE_MANAGE', 'NETWORK_IDS_MANAGE',
                      'SECURITY_CERTIFICATE_VIEW', 'GATEWAY_MANAGE', 'HOST_ID_MANAGE',
                      'VULN_SCAN_MANAGE', 'SECURITY_CERTIFICATE_MANAGE', 'CUSTOMER_SSH_KEY_MANAGEMENT',
                      'HARDWARE_VIEW', 'REMOTE_MANAGEMENT', 'MONITORING_MANAGE', 'HOSTNAME_EDIT',
                      'VIRTUAL_GUEST_VIEW', 'REMOTE_MANAGEMENT',
                      'MONITORING_MANAGE', 'PUBLIC_IMAGE_MANAGE', 'SERVER_RELOAD',
                      'HOSTNAME_EDIT', 'LICENSE_VIEW', 'VIEW_CPANEL', 'VIEW_PLESK', 'VIEW_HELM',
                      'VIEW_QUANTASTOR', 'BANDWIDTH_MANAGE', 'PORT_CONTROL', 'DNS_MANAGE', 'DNS_MANAGE',
                      'DNS_MANAGE', 'DNS_MANAGE', 'LOADBALANCER_MANAGE', 'CDN_ACCOUNT_MANAGE',
                      'CDN_FILE_MANAGE', 'CDN_BANDWIDTH_VIEW', 'NETWORK_ROUTE_MANAGE',
                      'FIREWALL_RULE_MANAGE', 'BANDWIDTH_MANAGE', 'PORT_CONTROL', 'LOCKBOX_MANAGE',
                      'NETWORK_TUNNEL_MANAGE', 'NAS_MANAGE', 'NETWORK_VLAN_SPANNING', 'VPN_MANAGE',
                      'SERVER_UPGRADE', 'SERVICE_ADD','INSTANCE_UPGRADE', 'IP_ADD', 'ADD_SERVICE_STORAGE',
                      'SERVICE_CANCEL', 'USER_EVENT_LOG_VIEW', 'REQUEST_COMPLIANCE_REPORT',
                      'SCALE_GROUP_MANAGE', 'QUEUE_MANAGE', 'CUSTOMER_POST_PROVISION_SCRIPT_MANAGEMENT',
                      'NETWORK_MESSAGE_DELIVERY_MANAGE');

function get_word($len = 8) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for ($i = 0; $i < $len; $i++) {
      $word .= $chars{mt_rand(0, strlen($chars) - 1)};
    }
    return $word;
}

foreach ($default_perm as $value) {
  ${'my_perm' . $cnt}['keyName'] = $value;
  $perm[] = ${'my_perm' . $cnt};
  $cnt++;
}

for ($user = 0; $user < CREATE_NBR_ACCOUNTS; $user++) {
  $my_user->username = USERNAME_PREFIX . $user;
  $my_word = get_word();
  $client = SoftLayer_SoapClient::getClient('SoftLayer_User_Customer', '', SLAPI_USER, SLAPI_KEY);
  $k = "!Za9$my_word";
  try {
    $res = $client->createObject($my_user, $k, $k);
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }

  $client = SoftLayer_SoapClient::getClient('SoftLayer_User_Customer', $res->id, SLAPI_USER, SLAPI_KEY);

  try {
    $res = $client->addBulkPortalPermission($perm);
    $res = $client->removeAllHardwareAccessForThisUser();
    $res = $client->removeAllVirtualAccessForThisUser();
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
  echo "$user : Credentials $my_user->username $k\n\n";
}
?>
