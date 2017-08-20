<?php

/*

---------------------------------------
SCK (Stripe Checkout for Kirby) Configuration
---------------------------------------

Provide BOTH sets of API keys for your Stripe account. These can be found in your Stripe Dashboard at: 

- https://dashboard.stripe.com/account/apikeys. 

By default, test mode is enabled. When you're ready to begin processing live charges, change this to `false`. No payments using real credit cards can be made when test mode is enabled. Instead, use the test card numbers provided by Stripe:

- https://stripe.com/docs/testing

*/

c::set('stripe_test_mode', true);
c::set('stripe_test_secret_key', '');
c::set('stripe_test_publishable_key', '');
c::set('stripe_live_secret_key', '');
c::set('stripe_live_publishable_key', '');

/* 

You can find a list of all supported currencies (and their abbreviation) at:

- https://support.stripe.com/questions/which-currencies-does-stripe-support

The currency symbol is whatever you want visitors to see and can be anything you want, either a symbol ($) or "USD".

Certain currencies have the symbol on the right-side of the amount (such as "kr"). Set 'stripe_currency_symbol_location' to either 'left' or 'right' (default is 'left').

*/ 

c::set('stripe_currency', 'usd');
c::set('stripe_currency_symbol', '$');
c::set('stripe_currency_symbol_location', 'left');

/*

"Remember Me" allows customers to save their card details with Stripe to use again with any merchant that uses Checkout.

- https://stripe.com/checkout#onetap

*/ 

c::set('stripe_remember_me', false);

// By default, SCK uses the amount and description specified on each page. If no amount or description has been set on a page that Checkout is being displayed on, the following default information is used instead. This is useful if you want to use SCK for donation purposes, where you'd only want to use one amount anyway. 

c::set('stripe_default_amount', '100'); // in cents (or similar lowest denomination)
c::set('stripe_default_description', 'New Payment');

// You can also have Checkout collect shipping address details. SCK will pass this information along as metadata when creating the charge, so you can view it within the Stripe dashboard. 

c::set('stripe_shipping_address', false);

// Custom icon for Checkout. Default is false, though it's recommended that you specify one. Icon should be at least 128x128px and .gif, .jpeg, .png or .svg. 

c::set('stripe_icon', false);
c::set('stripe_icon_location', 'assets/images/logo.svg');

// When the charge process completes, the page will reload and the "Pay with Card" button will be replaced with a confirmation message consisting of a header and paragraph. You can specify what these say in the below parameters. 

c::set('stripe_confirmation_heading', '<h3>Purchase Complete</h3>');
c::set('stripe_confirmation_message', '<p>Thank you for your purchase! You\'ll receive an email receipt shortly.</p>');

/*

If you'd prefer that the charge process redirects to a specific page once completed, enable the `stripe_redirect_on_success` parameter and specify the page to redirect to. 

A custom route is used (which uses whatever you specify `stripe_redirect_to_url` to be) if you'd also like to perform some additional actions.

See the template "checkout-success.php" for example usage. An example page that you can add to your `content` folder is included, which uses this template and is the default location for the route. 

As an example, the `stripeAmount` (decimal points removed, 123456) and `displayAmount` (decimal points retained, 1234.56) variables that have been stored in the session are included in the route.

*/

c::set('stripe_redirect_on_success', false);
c::set('stripe_redirect_to_page', 'thanks');

c::set('routes', array(
  array(
    'pattern' => c::get('stripe_redirect_to_page'),
    'action'  => function() {
      $data = array(
      'stripeAmount' => s::get('stripeAmount'),
      'displayAmount' => s::get('displayAmount')
      );
        return array('stripe-checkout-complete', $data);
    }
  )
));