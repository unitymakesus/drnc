<?php

namespace App;

add_shortcode('newsletter-form', function($atts) {
  ob_start();
  ?>
  <script type="text/javascript" src="//app.icontact.com/icp/core/mycontacts/signup/designer/form/automatic?id=206&cid=1752697&lid=7571"></script>
  <?php
  return ob_get_clean();
});

add_shortcode('drnc-login', function($atts) {
  if ( is_user_logged_in() )
    return '';

  $login = wp_login_form( array( 'echo' => false, 'label_username' => 'Email Address' ) );

  $login .= '<a href="' . wp_lostpassword_url( get_permalink() ) . '" title="Lost Password">Forgot password?</a>';

  return $login;
});
