jQuery(document).ready(function($) {
  if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
    return false;
  }

  var image = $('.knife-background-image');
  var color = $('.knife-background-color');


  /**
   * Check required options
   */
  if(typeof knife_background_options === 'undefined') {
    return false;
  }


  /**
   * Toggle background
   */
  function toggleBackground() {
    var input = image.find('input.image').val();

    image.find('img').remove();
    image.find('button.remove').attr('disabled', 'disabled');
    image.find('select').attr('disabled', 'disabled');


    if(input && input.length > 1) {
      $('<img />', {src: input}).prependTo(value).css('max-width', '100%');

      image.find('button.remove').removeAttr('disabled');
      image.find('select').removeAttr('disabled');
    }
  }


  /**
   * Define color input as colorpicker
   */
  color.find('input.color').wpColorPicker();


  /**
   * Process select image button click
   */
  image.on('click', 'button.select', function(e) {
    e.preventDefault();

    var frame = wp.media({
      title: knife_background_options.choose,
      multiple: false
    });

    frame.on('select', function() {
      var attachment = frame.state().get('selection').first().toJSON();

      image.find('input.image').val(attachment.url);

      return toggleBackground();
    });

    frame.open();
  });


  /**
   * Delete image on link clicking
   */
  image.on('click', 'button.remove', function(e) {
    e.preventDefault();

    image.find('input.image').val('');

    return toggleBackground();
  });


  /**
   * Launch toggle on load
   */
  return toggleBackground();
});
