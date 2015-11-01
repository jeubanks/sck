<?php

	// Check to see if test_mode is enabled and use the correct API keys. 

	if (c::get('stripe_test_mode')) {
		$pk	= c::get('stripe_test_publishable_key');
	} else {
		$pk	= c::get('stripe_live_publishable_key');
	}

	// Declaring some variables now to include in the form

	$currency						= c::get('stripe_currency');
	$displayAmount					= $page->amount();
	$amount							= str_replace('.', '', $page->amount());
	$amount							= str_replace(',', '', $amount);
	$checkoutName					= $site->title();
	$checkoutDescription 		    = $page->description();
	
	// Some session variables as these shouldn't be passed with POST
	// (We don't want visitors to be able to edit these before submitting)
	
	s::set(array(
			'stripeAmount' 			=> (int)$amount,
			'displayAmount' 		=> (int)$displayAmount,
			'stripeDescription'     => (string)$checkoutDescription
		 ));

	// Check if the Alipay payment method has been enabled

	if (c::get('stripe_alipay')) {
		$alipay = 'data-alipay="true"';
	}

	// Check if the Bitcoin payment method has been enabled

	if (c::get('stripe_bitcoin')) {
		$bitcoin = 'data-bitcoin="true"';
	}
	
	// Check if an icon has been set. 

	if (c::get('stripe_icon')) {
		$logo = url(c::get('stripe_icon_location'));
	}
	
	// Check if "Remember Me" has been enabled
	
	if (!c::get('stripe_remember_me')) {
		$rememberMe = 'data-allow-remember-me="false"';
	}
	
	// Check if the option to collect a shipping address has been enabled
	
	if (c::get('stripe_shipping_address')) {
		$shippingAddress = 'data-shipping-address="true"';
	}
	
	// Process the charge
	
	if (isset($_POST['stripeToken'])) {
		stripeCheckout();
		return;
	}
	
?>

<form action="#" method="POST">
	<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
	data-key="<?php echo $pk ?>"
	data-amount="<?php echo $amount ?>"
	data-name="<?php echo $checkoutName ?>"
	data-description="<?php echo $checkoutDescription ?>"
	data-image="<?php echo $logo ?>"
	data-locale="auto"
	data-billing-address="true"
	<?php echo $shippingAddress; ?>
	<?php echo $rememberMe; ?>
	<?php echo $alipay; ?>
	<?php echo $bitcoin; ?>
	data-currency="<?php echo $currency; ?>">
	</script>
</form>
	