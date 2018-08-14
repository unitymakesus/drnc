export default {
  finalize() {
    $(document).on('facetwp-loaded', function() {
      // $('.ajax-video').each(function() {
      //   var videoid = $(this).attr('id');
      //   console.log(videoid);
      //   eslint-disable-next-line no-undef
      // });

      // eslint-disable-next-line no-undef
      if (FWP.loaded) {
        $('html, body').animate({
          scrollTop: $('.facetwp-template').offset().top,
        }, 500);
      }
      /**
       * Add labels above each facet
       */
      $('.facetwp-facet').each(function() {
        let facet_name = $(this).attr('data-name');
        // eslint-disable-next-line no-undef
        let facet_label = FWP.settings.labels[facet_name];
        if ($('.facet-label[data-for="' + facet_name + '"]').length < 1) {
          $(this).before('<div class="h4 facet-label" data-for="' + facet_name + '">' + facet_label + '</div>');
        }
        // Add aria support for search field
        if (facet_name == 'search') {
          $(this).find('input').attr('aria-label', facet_label);
        }
      });

      /**
       * Add aria support for checkboxes
       */
       $('.facetwp-checkbox').each(function() {
         $(this).attr('role', 'checkbox');
         $(this).attr('aria-checked', $(this).hasClass('checked') ? 'true' : 'false');
         $(this).attr('tabindex', 0);

         $(this).bind( 'keydown', function( e ) {
           if( e.keyCode == 32 || e.keyCode == 13 ) {
             e.stopPropagation();
             e.preventDefault();
             // eslint-disable-next-line no-undef
             LG.LAST_FACETWP_CHECKED = $(this).data( 'value' );
             $(this).click();
           }
         } );
       });
    });

    // Change Self-Advocacy Tools text to Spanish while parameter is activate
    if (window.location.search.indexOf('?_resource_type=en-espanol') > -1) {
      var espanolheader ='Recursos de Auto-Abogacía';

      var espanol1 = '<p>Nuestras hojas informativas, guías, y videos proporcionan información sobre los derechos de personas con discapacidades bajo la ley federal y estatal. Ellos también ofrecen consejos sobre cómo navegar por varios sistemas públicos, como solicitar adaptaciones o modificaciones, y que hacer si se violan sus derechos o si sufre una discriminación. También contamos con recursos proporcionados por el gobierno federal, el gobierno estatal y otras organizaciones.</p>';

      var espanol2 = '<p>Use los filtros o la caja de búsqueda en la columna de la izquierda para encontrar los recursos que necesita. Por favor tenga en cuenta que muchos de nuestros recursos se aplican a una amplia gama de discapacidades, por lo que no clasificamos nuestros recursos por discapacidad individual.</p>';

      $('.self-advocacy-tools .content-container').html(espanol1 + espanol2);
      $('.self-advocacy-tools h1').html(espanolheader);
    }
  },
};
