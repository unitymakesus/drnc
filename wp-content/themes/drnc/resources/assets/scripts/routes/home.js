export default {
  init() {
    // JavaScript to be fired on the home page
  },
  finalize() {
    // Change style of select box in tools search on home page
    $('select').on('change', function() {
      if ($(this).val() !== "") {
        $(this).removeClass('default');
      } else {
        $(this).addClass('default');
      }
    });
  },
};
