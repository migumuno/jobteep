jQuery(document).ready(function($) {
    $('#docs_top').hide();
    $(window).scroll(function() {
        if ($(window).scrollTop() >= 600)
            $('#docs_top').fadeIn(500);
        else
            $('#docs_top').fadeOut(500);
    });
    $('pre').addClass('prettyprint');
});