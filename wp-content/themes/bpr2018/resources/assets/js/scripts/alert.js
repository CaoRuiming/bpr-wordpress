$(document).ready(function() {
  // check if user has recently closed the banner
  if (!document.cookie.split(';').some((item) => item.includes('hide-alert=true'))) {
    // add close button to alert banner
    $('.alert-banner').append(
      '<button class="alert-banner-close" role="button">Close</button>'
    );
    $('.alert-banner-close').click(function(){
      // hide banner on button click and remember action for 24 hours
      $('.alert-banner').css('display', 'none');
      document.cookie = 'hide-alert=true; max-age=86400';
    });

    // show alert banner because it is hidden to begin with
    $('.alert-banner').css('display', 'block');
  }
});
