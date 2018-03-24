export default {
  init() {
    /**
     * Set aria labels for current navigation items
     */
    // Main navigation in header and footer
    $('.menu-primary-menu-container .menu-item').each(function() {
      if ($(this).hasClass('current-page-ancestor')) {
        $(this).children('a').attr('aria-current', 'true');
      }
      if ($(this).hasClass('current-menu-item')) {
        $(this).children('a').attr('aria-current', 'page');
      }
    });
    // Sidebar navigation
    $('.widget_nav_menu .menu-item').each(function() {
      if ($(this).hasClass('current-page-ancestor')) {
        $(this).children('a').attr('aria-current', 'true');
      }
      if ($(this).hasClass('current-menu-item')) {
        $(this).children('a').attr('aria-current', 'page');
      }
    });
  },
  finalize() {
    // Controls for changing text size
    $('#text-size input[name="text-size"]').on('change', function() {
      let tsize = $(this).val();
      $('html').attr('data-text-size', tsize);
      document.cookie = 'data_text_size=' + tsize + ';max-age=31536000;path=/';
    });

    // Controls for changing contrast
    $('#toggle-contrast input[name="contrast"]').on('change', function() {
      let contrast = $(this).is(':checked');
      $('html').attr('data-contrast', contrast);
      document.cookie = 'data_contrast=' + contrast + ';max-age=31536000;path=/';
    });
  },
};
