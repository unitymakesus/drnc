export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // Controls for changing text size
    $('#text-size input[name="text-size"]').on('change', function() {
      let tsize = $(this).val();
      $('body').attr('data-text-size', tsize);
    });

    // Controls for changing contrast
    $('#toggle-contrast input[name="contrast"]').on('change', function() {
      let contrast = $(this).is(':checked');
      $('body').attr('data-contrast', contrast);
    });
  },
};
