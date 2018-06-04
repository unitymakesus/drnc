<?php

namespace App;

add_shortcode('newsletter-form', function($atts) {
  ob_start();
  ?>
  <!-- Begin VR Signup Form -->
  <form class="vr-signup-form" id="vr-signup-form-42880953483397">
    <div class="vr-field">
      <label for="email_address">Email Address <span class="vr-required" aria-label="Required">*</span></label>
      <input id="email_address" type="email" name="email_address" required>
    </div>
    <div class="vr-submit">
      <div class="vr-notice"></div>
      <input type="submit" value="Subscribe">
    </div>
  </form>
  <script type="text/javascript" src="https://marketingsuite.verticalresponse.com/signup_forms/signup_forms.embedded-2.js"></script>
  <script type="text/javascript">
    if (typeof VR !== "undefined" && typeof VR.SignupForm !== "undefined") {
      new VR.SignupForm({ id: "42880953483397", element: "vr-signup-form-42880953483397", endpoint: "https://marketingsuite.verticalresponse.com/se/", submitLabel: "Submitting...", invalidEmailMessage: "Invalid email address", generalErrorMessage: "An error occurred", notFoundMessage: "Signup form not found", successMessage: "Success!", nonMailableMessage: "Nonmailable address"});
    }
  </script>
  <!-- End VR Signup Form -->
  <?php
  return ob_get_clean();
});
