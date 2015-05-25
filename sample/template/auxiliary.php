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
      print_r($orderClient->verifyOrder($orderContainer));
    } catch (Exception $e) {
      die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
    }
  }
}

?>
