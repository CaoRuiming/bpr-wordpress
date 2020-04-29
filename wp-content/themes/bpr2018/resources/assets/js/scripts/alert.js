$(document).ready(function() {
  // check if user has recently closed the banner
  if (!document.cookie.split(';').some((item) => item.includes('hide-alert=true'))) {
    // add close button to alert banner
    $('.alert-banner').append(
      '<button class="alert-banner-close" role="button">Close</button>'
    );
    $('.alert-banner').css('position', 'relative');
    $('.alert-banner-close').css({
      'position': 'absolute',
      'top': '50%',
      'transform': 'translateY(-50%)',
      'right': '0',
      'padding': '0',
      'border': 'none',
      'outline': 'none',
      'font': 'inherit',
      'color': 'inherit',
      'background': 'none'
    }).click(function(){
      // hide banner on button click and remember action for 24 hours
      $('.alert-banner').css('display', 'none');
      document.cookie = 'hide-alert=true; max-age=86400';
    });

    // show alert banner because it is hidden to begin with
    $('.alert-banner').css('display', 'block');
  }
});
