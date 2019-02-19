jQuery(document).ready(function($) {
  if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
    return false;
  }

  var box = $('#knife-background-boxs');


  /**
   * Check required metabox options
   */
  if(typeof knife_background_metabox === 'undefined') {
    return false;
  }


  /**
   * Toggle background
   */
  function toggleBackground() {
    var input = box.find('input.image').val();

    box.find('img').remove();
    box.find('button.remove').attr('disabled', 'disabled');
    box.find('select').attr('disabled', 'disabled');

    if(input && input.length > 1) {
      $('<img />', {src: input}).prependTo(box).css('max-width', '100%');

      box.find('button.remove').removeAttr('disabled');
      box.find('select').removeAttr('disabled');
    }
  }


  /**
   * Process select image button click
   */
  box.on('click', 'button.select', function(e) {
    e.preventDefault();

    var frame = wp.media({
      title: knife_background_metabox.choose,
      multiple: false
    });

    frame.on('select', function() {
      var attachment = frame.state().get('selection').first().toJSON();

      box.find('input.image').val(attachment.url);

      return toggleBackground();
    });

    frame.open();
  });


  /**
   * Delete image on link clicking
   */
  box.on('click', 'button.remove', function(e) {
    e.preventDefault();

    box.find('input.image').val('');

    return toggleBackground();
  });


  /**
   * Launch toggle on load
   */
  return toggleBackground();
});
