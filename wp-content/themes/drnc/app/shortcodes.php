<?php

namespace App;

add_shortcode('newsletter-form', function($atts) {
  ob_start();
  ?>
  <script type="text/javascript" src="//app.icontact.com/icp/core/mycontacts/signup/designer/form/automatic?id=206&cid=1752697&lid=7571"></script>
  <?php
  return ob_get_clean();
});
