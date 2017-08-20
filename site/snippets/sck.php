<?php

  // Check to see if test_mode is enabled and use the correct API keys. 

  if (c::get('stripe_test_mode')) {
    $pk = c::get('stripe_test_publishable_key');
  } else {
    $pk = c::get('stripe_live_publishable_key');
  }

  // Declaring some variables now to include in the form

  $currency = c::get('stripe_currency');
  $displayAmount = $page->amount();
  if ($page->amount()->empty()) {
    $amount = c::get('stripe_default_amount');
  } else {
    $amount = str_replace('.', '', $page->amount());
    $amount = str_replace(',', '', $amount);
  }
  $checkoutName = $site->title();
  $checkoutDescription = $page->description();

  // Some session variables as these shouldn't be passed with POST
  // (We don't want visitors to be able to edit these before submitting)

  s::set(array(
      'stripeAmount' => (int)$amount,
      'stripeDescription' => (string)$checkoutDescription
     ));

  // Check if an icon has been set. 

  if (c::get('stripe_icon')) {
    $logo = url(c::get('stripe_icon_location'));
  } else {
    $logo = '';
  }

  // Check if "Remember Me" has been enabled

  if (c::get('stripe_remember_me')) {
    $rememberMe = 'true';
  } else {
    $rememberMe = 'false';
  }

  // Check if the option to collect a shipping address has been enabled

  if (c::get('stripe_shipping_address')) {
    $shippingAddress = 'true';
  } else {
    $shippingAddress = 'false';
  }

  // Process the charge

  if (isset($_POST['stripeToken'])) {
    stripeCheckout();
    return;
  }

?>

<form action="#" method="POST">
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
  data-key="<?php echo $pk; ?>"
  data-amount="<?php echo $amount; ?>"
  data-name="<?php echo $checkoutName; ?>"
  data-description="<?php echo $checkoutDescription; ?>"
  data-image="<?php echo $logo; ?>"
  data-locale="auto"
  data-billing-address="true"
  data-shipping-address="<?php echo $shippingAddress; ?>"
  data-allow-remember-me="<?php echo $rememberMe; ?>"
  data-currency="<?php echo $currency; ?>">
  </script>
</form>