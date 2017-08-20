<?php
  require_once('sck.inc.php');

  // Setting some warnings in case certain fields are not provided.

  $email = 'No email provided!';
  $billingName = 'No name provided!';
  $stripeShippingName = 'No shipping name provided';
  $stripeShippingAddressLine1 = 'No shipping street address provided';
  $stripeShippingAddressZip = 'No shipping postal code provided';
  $stripeShippingAddressState = 'No shipping state provided';
  $stripeShippingAddressCity = 'No shipping city provided';
  $stripeShippingAddressCountry = 'No shipping country provided';

  // Setting variables using POST and session data to create the charge and pass to Stripe to process.

  $token = $_POST['stripeToken'];
  $email = $_POST['stripeEmail'];
  $amount = s::get('stripeAmount');
  $description = s::get('stripeDescription');
  $currency = c::get('stripe_currency');
  $billingName = $_POST['stripeBillingName'];
  $billingZip = $_POST['stripeBillingAddressZip'];

  $email = $_POST['stripeEmail'];
  if( isset($_POST['stripeShippingName']) ) {
    $stripeShippingName = $_POST['stripeShippingName'];
  }
  if( isset($_POST['stripeShippingAddressLine1']) ) {
    $stripeShippingAddressLine1 = $_POST['stripeShippingAddressLine1'];
  }
  if( isset($_POST['stripeShippingAddressZip']) ) {
    $stripeShippingAddressZip = $_POST['stripeShippingAddressZip'];
  }
  if( isset($_POST['stripeShippingAddressState']) ) {
    $stripeShippingAddressState = $_POST['stripeShippingAddressState'];
  }
  if( isset($_POST['stripeShippingAddressCity']) ) {
    $stripeShippingAddressCity = 
  $_POST['stripeShippingAddressCity'];
  }
  if( isset($_POST['stripeShippingAddressCountry']) ) {
    $stripeShippingAddressCountry = $_POST['stripeShippingAddressCountry'];
  }

  $charge = \Stripe\Charge::create(array(
      'amount' => $amount,
      'source' => $token,
      'currency' => $currency,
      'receipt_email' => $email,
      'description' => $description,
      'metadata' => array('customer_name' => $billingName,
                          'customer_email' => $email,
                          'shipping_name' => $stripeShippingName,
                          'shipping_street' => $stripeShippingAddressLine1,
                          'shipping_city' => $stripeShippingAddressCity,
                          'shipping_state' => $stripeShippingAddressState,
                          'shipping_zip' => $stripeShippingAddressZip,
                          'shipping_country' => $stripeShippingAddressCountry)
      ));

  if (c::get('stripe_redirect_on_success')) {
    header('Location: ' . c::get('stripe_redirect_to_page'));
  } else {
      echo c::get('stripe_confirmation_heading');
      echo c::get('stripe_confirmation_message');
  }
  
?>