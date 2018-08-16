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

    $('#hometoolsform').submit(function() {
      event.preventDefault();
      var url = '/getting-help/self-advocacy-tools';
      var topic = $("select", this).val();
      var keyword = $(".facetwp-search", this).val();

      $.ajax({
        type: "POST",
        success: function() {
          if(!topic) {
            window.location.replace(url + "?_search=" + keyword);
          } else {
            window.location.replace(url + "?_resource_topic=" + topic + "&_search=" + keyword);
          }
        },
      })
    });
  },
};
