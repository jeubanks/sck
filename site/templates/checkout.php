 <?php snippet('header') ?>

  <main class="main" role="main">

    <div class="text">
      <h1><?php echo $page->description()->html() ?></h1>
      <?php 
      // The following is included to ensure the amount and currency are specified. Since the currency can be either left or right, you should include this if statement in your template
      ?>
      <?php if(c::get('stripe_currency_symbol_location') == 'left'): ?>
        <h2><?php echo c::get('stripe_currency_symbol') . " " . $page->amount()->html() ?></h2>
      <?php else: ?>
        <h2><?php echo $page->amount()->html() . " " . c::get('stripe_currency_symbol') ?></h2>
      <?php endif ?>
      <?php echo $page->text()->kirbytext() ?>
      <?php 
      // The following checks to see if the page has `stripe: true` to check whether to load Checkout. If it has, it'll load the `sc-kirby` snippet. 
      ?>
    <?php if($page->stripe()->isTrue()): ?>
      <?php snippet('sck') ?>
    <?php endif ?>
    </div>

  </main>

<?php snippet('footer') ?>