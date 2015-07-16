<?php

function cci_order_helper($template, $provision)
{
  if (empty($template)) {
    echo "Empty configuration template\n";
    exit(1);
  }
  $client = SoftLayer_SoapClient::getClient('SoftLayer_Virtual_Guest', null, SLAPI_USER, SLAPI_KEY);
  $order_client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Order', null, SLAPI_USER, SLAPI_KEY);

  if ('yes' == $provision) {
    try {
      $result = $client->createObject($template);
      print_r($result);
    } catch (Exception $e) {
      die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
    }
  } else {
    try {
      $orderClient = SoftLayer_SoapClient::getClient('SoftLayer_Product_Order', null, SLAPI_USER, SLAPI_KEY);
      $orderContainer = $client->generateOrderTemplate($template);
      $result = $orderClient->verifyOrder($orderContainer);
      print_r($result);
      echo "Hourly expense post tax $result->postTaxRecurringHourly\n";
    } catch (Exception $e) {
      die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
    }
  }
}

function bms_order_helper($template, $template_extra, $provision)
{
  if (empty($template) || empty($template_extra)) {
    echo "Empty configuration template\n";
    exit(1);
  }
  $client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Order', null, SLAPI_USER, SLAPI_KEY);
  $cmd = 'yes' == $provision ? 'placeOrder' : 'verifyOrder';

  for ($cnt = 0; $cnt < $template->quantity; $cnt++) {
    $domain = new stdClass();
    $domain->hostname = "$template_extra->hostname-$cnt";
    $domain->domain = $template_extra->domain;
    $template->hardware[] = $domain;
  }
  
  if (empty($template->imageTemplateGlobalIdentifier))
    $template_extra->price_id[] = $template_extra->os;

  foreach ($template_extra->price_id as $id) {
    $price = new stdClass();
    $price->id = $id;
    $template->prices[] = $price;
  }

  try {
    $result = $client->$cmd($template);
    print_r($result);
    echo "Hourly expense post tax $result->postTaxRecurringHourly\n";
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
  echo shell_exec('date');
}


function vga_order_helper($template, $template_extra, $provision)
{
  if (empty($template) || empty($template_extra)) {
    echo "Empty configuration template\n";
    exit(1);
  }
  $client = SoftLayer_SoapClient::getClient('SoftLayer_Product_Order', null, SLAPI_USER, SLAPI_KEY);
  $cmd = 'yes' == $provision ? 'placeOrder' : 'verifyOrder';
  $my_template = new stdClass();
  $my_template->orderContainers = new stdClass();

 for ($cnt = 0; $cnt < $template->quantity; $cnt++) {
    $domain = new stdClass();
    $domain->hostname = "$template_extra->hostname-$cnt";
    $domain->domain = $template_extra->domain;
    $template->hardware[] = $domain;
  }
  
  if (empty($template->imageTemplateGlobalIdentifier))
    $template_extra->price_id[] = $template_extra->os;

  foreach ($template_extra->price_id as $id) {
    $price = new stdClass();
    $price->id = $id;
    $template->prices[] = $price;
  }
$my_template->orderContainers = array();
$my_template->orderContainers[0] = new stdClass();
$my_template->orderContainers[0]->prices = $template->prices;
$my_template->orderContainers[0]->hardware = $template->hardware;
$my_template->orderContainers[0]->quantity = $template->quantity;
$my_template->orderContainers[0]->location = $template->location;
$my_template->orderContainers[0]->packageId = $template->packageId;
$my_template->orderContainers[0]->containerIdentifier = $template->containerIdentifier;

  try {
    $result = $client->$cmd($my_template);
    print_r($result);
    echo "Hourly expense post tax $result->postTaxRecurringHourly\n";
  } catch (Exception $e) {
    die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
  }
  echo shell_exec('date');
}

?>
