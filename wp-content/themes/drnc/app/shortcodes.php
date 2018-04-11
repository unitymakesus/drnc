<?php

namespace App;

add_shortcode('intake-form', function ($atts, $content = null) {
  ob_start();
  ?>
  <ol class="form-progress" tabindex="0" role="progressbar" aria-valuemin="1" aria-valuemax="3" aria-valuenow="1" aria-valuetext="Step 1 of 3: Notice">
    <li>Notice</li>
    <li>Description</li>
    <li>When &amp; Where</li>
  </ol>

  <section data-section-name="notice">
    <p>Because of the rules of our federal funding, there are certain issues we cannot assist you with. These include:</p>
    <ul>
      <li>Applications or appeals for Social Security or disability benefits (such as SSI or SSDI)</li>
      <li>Housing issues that are not related to a disability (such as eviction for failure to pay rent)</li>
      <li>Worker’s compensation</li>
      <li>Divorce, child support and other family law matters</li>
      <li>Wills, trusts and estate planning</li>
      <li>Malpractice and personal injury</li>
    </ul>
If your child has criminal charges related to a behavior incident at school, please continue. Otherwise, we do not represent people in criminal, probation or parole matters.
If you are already receiving Social Security benefits and have questions about returning to work, please continue. We cannot help you apply for Social Security benefits (SSI/SSDI) or appeal a denial of your application.
If your Medicaid services have been reduced or denied, please continue. We cannot help you apply for Medicaid benefits or appeal a denial of your application.
If Social Services (DSS or CPS) has threatened to take custody of a child because of the parent’s disability, please continue. Otherwise, we do not represent people in child custody disputes.
If your case involves removal of or a challenge to a guardianship, please continue. We cannot help you obtain guardianship over a person with a disability.

    <div class="dz-wrapper">
      <div>
        <?php echo do_shortcode('[wp-dropzone id="dropfile" max-file-size="10" remove-links="true" accepted-files="image/*" max-files="1" dom-id="dz-files" title="Drop image here or click to upload"]'); ?>
      </div>
    </div>
    <div class="form-buttons">
      <a class="btn-primary" type="button">Next Step</a>
    </div>
  </section>

  <form name="ecosubmit">
    <input type="hidden" name="dz-files" id="dz-files" required="true" aria-required="true" />
    <fieldset data-section-name="description">
      <div class="form-row input-field">
        <label for="identification">Species Identification <span aria-label="Required">*</span></label>
        <input type="text" name="identification" id="identification" required="true" aria-required="true">
      </div>

      <div class="form-row input-field">
        <label for="description">Description of Observation (optional)</label>
        <textarea name="description" id="description" class="materialize-textarea"></textarea>
      </div>

      <div class="form-buttons">
        <a class="btn-primary" type="button">Next Step</a>
      </div>
    </fieldset>

    <fieldset data-section-name="whenWhere">
      <div class="form-row">
        <label for="datetime">Date &amp; Time Observed <span aria-label="Required">*</span></label>
        <input type="text" name="datetime" class="flatpickr-input" id="datetime" aria-required="true" required="true" readonly="readonly">
      </div>

      <div class="form-row">
        <label for="location">Location of Observation</label>
        <input type="text" name="picker-coords" id="picker-coords">
        <input type="text" name="picker-address" id="picker-address">
        <div id="google-map" style="width:800px;height:400px;"></div>
      </div>

      <div class="form-buttons">
        <a class="btn-secondary" type="submit">Submit Observation</a>
      </div>
    </fieldset>
  </form>
  <?php
  return ob_get_clean();
});
