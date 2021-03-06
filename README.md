# SCK (Stripe Checkout for Kirby)

A plug-in for Kirby CMS to process payments with [Stripe Checkout](https://stripe.com/checkout).

## Features

- Includes everything needed to add Checkout to any page and begin processing payments with Stripe
- Works on both desktop and mobile
- Checkout integration is easy with just the addition of a snippet and a template
- Makes use of Checkout's vast array of features and functionality
- Supports Stripe's [email receipts](https://stripe.com/docs/checkout) feature, so customers will receive an email confirmation of their purchase
- All billing and email information is passed to Stripe when creating the charge
- Option to collect shipping address information, which is then passed as metadata to Stripe and viewable within your Stripe Dashboard
- Supports both decimal mark types: decimal point or decimal comma (e.g. $999.99 or €999,99)
- Supports both left or right-positioned currency symbols (e.g. $999.99 or 999,99 kr)
- All configuration settings are integrated into Kirby's `config.php` file, making them easy to find and build upon if you want to extend the plugin's functionality

You can read about all of Stripe Checkout's features over at [Stripe's Checkout documentation](https://stripe.com/docs/checkout).

## Requirements

- Kirby 2.3+
- PHP 5.5+
- Stripe PHP library

SCK has been developed and tested using Kirby 2.3.1 running on PHP 5.5.27. With that, as long as you can run Kirby 2.3+ then you should be able to use this plugin. 

SSL/TLS is [required by Stripe](https://stripe.com/docs/security) when processing live credit card payments.

## Installation

1. Copy the included files to the appropriate folders. 
2. Download the [Stripe PHP library](https://github.com/stripe/stripe-php/releases), rename the extracted folder to `stripe-php` and copy it to `/site/plugins/sck`.  
3. Edit `/site/config/config.php` and insert `include 'sck.config.php';` after any listed options so Kirby will load the configuration file.
4. Edit `/site/config/sck.config.php`, insert your Stripe API keys, and change any options as needed.

### Upgrading from previous versions

The only file that should be modified is `sck.config.php`, which contains your SCK settings. When upgrading, replace all other plugin files except this one. Should there be any new options added to SCK, simply add them to your existing `sck.config.php` file. 

If you have modified any other plugin files, you will need to ensure your changes are made to the updated plugin files. 

### Setting up the template

At the very least, you need to have `<?php snippet('sck') ?>` somewhere in the page template you're going to be using. Use the included `checkout.php` template for info on how you can adapt or use it (comments are included), or even just modify it to fit.

## Usage

To use SCK in any page, three additional fields need to be added.

- `Stripe: true` will make sure that Checkout is inserted into the page. 
- `Amount: 10.00` will set the amount to charge your customer and display in the Checkout form. If you use a decimal comma, you can enter 10,00. For larger amounts, you can include a number divider (e.g. 2,999.99) if you wish. The currency is set within SCK's options in the `config.php` file. 
- `Description` is used both as the description in the Checkout form and also the description of the charge when you view it in the Stripe dashboard. 

## Example page

````
Title: Stripe Checkout Example
----
stripe: true
----
Amount: 9.99
----
Description: An example purchase with SCK
----

Text: Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. 
````

## Test vs live

Stripe provides two sets of API keys: test and live. Whether you process charges in test or live mode is dictated by the set of API keys used when inserting the Checkout form and creating a charge. 

SCK requires both sets and makes it easy to switch between test and live mode. By default, test mode is enabled. It's recommended that you fully test SCK before you begin processing live charges. 

The Stripe Dashboard will display both live and test charges in separate views, which you can toggle using the Live / Test switch in the Dashboard. Alternatively, you can jump straight to your Stripe "test" Dashboard at:

https://dashboard.stripe.com/test/dashboard

Once you're happy that everything is set up how you want it, you should change the option `stripe_test_mode` to `false`. At this point, SCK will process charges using your live API keys. 

### Testing SCK

Stripe has some useful information about [testing](https://stripe.com/docs/testing), and provides a number of [test credit card numbers](https://stripe.com/docs/testing#cards) you can use. For example, use the card number `4242 4242 4242 4242` with any future expiration date and random number for the CVC to create a successful charge.

## Options

SCK has a lot of options that allow you to customize Checkout to suit your needs. 

All options are set in the included `sck.config.php`, which should be placed in `/site/config` folder. Make sure to add `include 'sck.config.php'` in `/site/config/config.php` so that Kirby will be able to use them. The configuration file is fully commented so you can easily identify what each option does. 

Make sure to add `include 'sck.config.php` somewhere within Kirby's main configuration file at `/site/config.config.php` so it will load them.

### API keys

By default, test mode is enabled. When you're ready to begin processing live charges, change this to `false`. No payments can be made when test mode is enabled. 

````
c::set('stripe_test_mode', true);
c::set('stripe_test_secret_key', 'sk_test');
c::set('stripe_test_publishable_key', 'pk_test');
c::set('stripe_live_secret_key', 'sk_live');
c::set('stripe_live_publishable_key', 'pk_live');
````

### Currency support

Stripe has a [list of all supported currencies](https://support.stripe.com/questions/which-currencies-does-stripe-support), including their abbreviation. Refer to this when you're specifying a currency. 

The currency symbol is whatever you want visitors to see and can be anything you want, either a symbol ($) or "USD". Certain currencies have the symbol located on the right-side of the amount(such as DKK).

````
c::set('stripe_currency', 'usd');
c::set('stripe_currency_symbol', '$');
c::set('stripe_currency_symbol_location', 'left');
````

### Remember Me

[Remember Me](https://stripe.com/checkout#onetap) allows customers to save their card details wth Stripe to use again with any merchant that  uses Checkout.

````
c::set('stripe_remember_me', true);
````

### Shipping address

You can also have Checkout collect shipping address details. SCK will pass this information along as metadata when creating the charge, so you can view it within the Stripe dashboard. 

````
c::set('stripe_shipping_address', false);
````

### Default amount and description

By default, SCK uses the amount and description specified on each page. If no amount or description has been set on a page that Checkout is being displayed on, the following default information is used instead. This is useful if you want to display Checkout on all pages with only one amount (e.g., a fixed donation). 

````
c::set('stripe_default_amount', '100');
c::set('stripe_default_description', 'New Payment');
````

### Checkout image

Custom icon for Checkout. Default is false, though it's recommended that you specify one. Icon should be at least 128x128px and .gif, .jpeg, .png or .svg. 

````
c::set('stripe_icon', true);
c::set('stripe_icon_location', 'assets/images/logo.svg');
````

### Charge confirmation

When the charge process completes, the page will reload and the "Pay with Card" button will be replaced with a confirmation message consisting of a header and paragraph. You can specify what these say in the below parameters. 

````
c::set('stripe_confirmation_heading', '<h3>Purchase Complete</h3>');
c::set('stripe_confirmation_message', '<p>Thank you for your purchase! You\'ll receive an email receipt shortly.</p>');
````

### Redirect on successful charge

If you'd prefer that the charge process redirects to a specific page once completed, enable the `stripe_redirect_on_success` parameter and specify the page to redirect to. A custom route is used (which uses whatever you specify `stripe_redirect_to_url` to be) if you'd also like to perform some additional actions.

See the template `checkout-success.php` for example usage. An example page that you can add to your `content` folder is included, which uses this template and is the default location for the route. 

````
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
````

## Charge information and metadata

Since Checkout requires customers to enter their email address, name and full billing address, this is automatically passed to Stripe when a charge is created. In addition, SCK will pass as much information as possible to Stripe.

## Author

SCK created by [Jordan Merrick](https://www.jordanmerrick.com). Contact me at [info@jordanmerrick.com](mailto:info@jordanmerrick.com).

## Disclaimer

SCK is provided "as-is". There is no support provided, nor do I accept any responsibility for your use of SCK nor any issues that may occur.