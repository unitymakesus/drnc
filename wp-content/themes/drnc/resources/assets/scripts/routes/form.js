export default {
  init() {
    // Add HTML5 markup for required fields
    $('form .required').each(function() {
      // $(this).attr('required', 'required');
    });

    //Hide form after successful submission
    document.addEventListener( 'wpcf7mailsent', function() {
      $('form.wpcf7-form').hide();
      $('html, body').animate({
        scrollTop: ($('#main').offset().top),
      }, 500);
    }, false);
  },
  finalize() {
    /**
     * Validation functions
     *
     */

    // Check if all fields in section are valid
    function compareValid($this) {
      let thisSection = $this.closest('.form-step');

      if (thisSection.validate().checkForm()) {
        thisSection.find('button[data-button-type=next]').removeClass('disabled');
      } else {
        thisSection.find('button[data-button-type=next]').addClass('disabled');
      }
    }

    // Validate section when radio buttons change
    $('form .form-section').on('change', 'input[type="radio"]', function() {
      compareValid($(this));
    })

    // Validate section when each field loses focus
    $('form .form-section').on('blur', '.required', function() {
      compareValid($(this));
    });

    /**
     * Button handlers
     *
     */
    // Multi-page form pagination and progress functions
    $('.form-step').on('click', '.btn', function(e) {
      let thisSection = $(this).closest('.form-step');

      // Handle disabled buttons
      if ($(this).hasClass('disabled')) {
        e.preventDefault();

        // Validate the fields in this section of the form
        thisSection.find('.form-section:not(.hidden) .required').valid();

        // Don't allow click
        return false;
      }

      // If loader already added to DOM, don't proceed
      if( $(this).next('.loading-spinner').length ) {
        e.preventDefault();
        return false;
      } else {
        // Add loader to DOM
        $(this).after('<div class="loading-spinner"></div>');
      }

      // Next button handler
      if ($(this).attr('data-button-type') == "next") {
        e.preventDefault();

        let thisStep = Number(thisSection.attr('data-section-number'));
        let nextStepN = thisStep+1;
        let nextStepT = $('.form-progress .progress-step[data-step-current]').next().html();

        // Hide this section
        thisSection.addClass('hidden').attr('aria-hidden', 'true');

        // Show next section
        $('.form-step[data-section-number="' + nextStepN + '"]').removeClass('hidden').attr('aria-hidden', 'false');

        // Scroll to top of form
        $('html, body').animate({
          scrollTop: ($('#main').offset().top),
        }, 500);

        // Change progress step
        $('.form-progress').attr('aria-valuenow', nextStepN);
        $('.form-progress').attr('aria-valuetext', 'Step ' + nextStepN + ' of 3: ' + nextStepT);
        $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-complete', '')
          .next().removeAttr('data-step-incomplete').attr('data-step-current', '');

        $(this).next('.loading-spinner').remove();
      }
    });

    // Progress step click functions
    $('.form-progress').on('click', '.progress-step[data-step-complete]', function() {
      let thisSection = $('.form-step[aria-hidden="false"]');
      let currentIndex = $('.form-progress .progress-step[data-step-current]').index();
      let currentStepN = currentIndex+1;
      let targetIndex = $(this).index();
      let targetStepN = targetIndex+1;
      let targetStepT = $(this).html();

      // Hide this section
      thisSection.addClass('hidden').attr('aria-hidden', 'true');

      // Show target section
      $('.form-step[data-section-number="' + targetStepN + '"]').removeClass('hidden').attr('aria-hidden', 'false');

      // Change progress step
      $('.form-progress').attr('aria-valuenow', targetStepN);
      $('.form-progress').attr('aria-valuetext', 'Step ' + targetStepN + ' of 3: ' + targetStepT);
      $('.form-progress').attr('aria-valuetext', 'Step ' + targetStepN + ' of 3: ' + targetStepT);

      // If current step is before the target step, set attr to complete,
      // otherwise set attr to incomplete
      if (currentStepN > targetStepN) {
        $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-complete', '');
      } else {
        $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-incomplete', '');
      }

      $(this).removeAttr('data-step-complete').attr('data-step-current', '');
    });

    // Conditional fields -- show contact areas depending on answer
    $('.select-1 input[type="radio"]').on('change', function() {
      const pattern1 = /legal guardian/;
      const pattern2 = /abuse or neglect/;
      let exists1 = pattern1.test(this.value);
      let exists2 = pattern2.test(this.value);
      if (exists1 === true || exists2 === true) {
        $('#individual-contact').removeClass('hidden');
        $('#individual-contact').attr('aria-hidden', 'false');
      } else {
        $('#individual-contact').addClass('hidden');
        $('#individual-contact').attr('aria-hidden', 'true');
      }
    });

  },
};
