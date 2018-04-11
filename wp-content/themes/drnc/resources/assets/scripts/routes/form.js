export default {
  finalize() {
    // Multi-page form pagination and progress functions
    $('.form-step').on('click', '.btn', function(e) {
      console.log('btn click');
      e.preventDefault();
      let thisSection = $(this).closest('.form-step');

      // Don't allow clicks on disabled buttons
      if ($(this).hasClass('disabled')) {
        return false;
      }

      // If loader already added to DOM, don't proceed
      if( $(this).next('.loading-spinner').length ) {
        console.log('already spinner');
        e.preventDefault();
        return false;
      } else {
        console.log('add spinner');
        // Add loader to DOM
        $(this).after('<div class="loading-spinner"></div>');
      }

      // Next button handler
      if ($(this).attr('data-button-type') == "next") {
        let thisStep = Number(thisSection.attr('data-section-number'));
        let nextStepN = thisStep+1;
        let nextStepT = $('.form-progress .progress-step[data-step-current]').next().html();

        // Hide this section
        thisSection.addClass('hidden').attr('aria-hidden', 'true');

        // Show next section
        $('.form-step[data-section-number="' + nextStepN + '"]').removeClass('hidden').attr('aria-hidden', 'false');

        // Change progress step
        $('.form-progress').attr('aria-valuenow', nextStepN);
        $('.form-progress').attr('aria-valuetext', 'Step ' + nextStepN + ' of 3: ' + nextStepT);
        $('.form-progress').attr('aria-valuetext', 'Step ' + nextStepN + ' of 3: ' + nextStepT);
        $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-complete', '')
          .next().removeAttr('data-step-incomplete').attr('data-step-current', '');

        $(this).next('.loading-spinner').remove();

      // Submit button handler
      } else if ($(this).attr('data-button-type') == "submit") {
        $('form#ecosubmit').submit();
      }
    });

    // Progress step click functions
    $('.form-progress').on('click', '.progress-step[data-step-complete]', function() {
      let targetIndex = $(this).index();
      let thisSection = $('.form-step[aria-hidden="false"]');
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
      $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-incomplete', '');
      $(this).removeAttr('data-step-complete').attr('data-step-current', '');
    });

    // Conditional fields -- show contact areas depending on answer
    $('.select-1 input[type="radio"]').on('change', function() {
      const pattern = /legal guardian/;
      let exists = pattern.test(this.value);
      if (exists === true) {
        $('#individual-contact').removeClass('hidden');
        $('#individual-contact').attr('aria-hidden', 'false');
      } else {
        $('#individual-contact').addClass('hidden');
        $('#individual-contact').attr('aria-hidden', 'true');
      }
    });

  },
};
