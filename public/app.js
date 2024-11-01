jQuery(document).ready(function () {
    var GoToBtn = jQuery('#ssub_btn-js');
    GoToBtn.hide();
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 80) {
            GoToBtn.fadeIn();
        } else {
            GoToBtn.fadeOut();
        }
    });

    GoToBtn.click(function () {
        jQuery('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
});
